<?php 
// business-settings.php
session_start();

// ✅ Access control
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>alert('Access Denied: Cashier role cannot access this page.'); window.location.href='../login.php';</script>";
    exit;
}

$page = 'settings-system-preferences';
require '../includes/header.php';

// ✅ DATABASE CONNECTION
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Fetch business details (single record)
$stmt = $conn->prepare("SELECT * FROM business_details LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $business = $result->fetch_assoc();
    $business_id = $business['id'];
} else {
    $business = [
        'name' => '',
        'logo' => 'default.png',
        'address' => '',
        'contact_number' => '',
        'email' => '',
        'daily_rate' => '0',
        'weekly_rate' => '0',
        'monthly_rate' => '0',
        'low_stock_alert' => '0',
        'overdue_rental_alert' => '0'
    ];
    $business_id = null;
}

// ✅ Handle logo upload
if (isset($_POST['upload_logo'])) {
    if (isset($_FILES['logo_picture']) && $_FILES['logo_picture']['error'] === 0) {
        $fileTmp = $_FILES['logo_picture']['tmp_name'];
        $fileType = mime_content_type($fileTmp);

        if (str_starts_with($fileType, 'image/')) {
            $uploadDir = '../assets/images/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid('logo_') . '_' . basename($_FILES['logo_picture']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmp, $filePath)) {
                // Delete old logo if exists (and not default)
                $oldLogo = $business['logo'];
                if (!empty($oldLogo) && $oldLogo !== 'default.png' && file_exists($oldLogo)) {
                    unlink($oldLogo);
                }

                // Update or insert logo record
                if ($business_id) {
                    $updateStmt = $conn->prepare("UPDATE business_details SET logo = ? WHERE id = ?");
                    $updateStmt->bind_param("si", $filePath, $business_id);
                } else {
                    $updateStmt = $conn->prepare("INSERT INTO business_details (logo) VALUES (?)");
                    $updateStmt->bind_param("s", $filePath);
                }

                if ($updateStmt->execute()) {
                    $_SESSION['success_message'] = 'Logo updated successfully!';
                    header("Location: business-settings.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Error updating logo: ' . $conn->error;
                }
            } else {
                $_SESSION['error_message'] = 'Error moving uploaded file.';
            }
        } else {
            $_SESSION['error_message'] = 'Invalid file type. Only images are allowed.';
        }
    } else {
        $_SESSION['error_message'] = 'Please select a valid image file.';
    }
}

// ✅ Handle saving business details
if (isset($_POST['save_business_details'])) {
    $business_name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $contact_number = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $daily_rate = $_POST['daily_rate'] ?? '0';
    $weekly_rate = $_POST['weekly_rate'] ?? '0';
    $monthly_rate = $_POST['monthly_rate'] ?? '0';
    $low_stock_alert = isset($_POST['low_stock_alert']) ? '1' : '0';
    $overdue_rental_alert = isset($_POST['overdue_rental_alert']) ? '1' : '0';

    if (empty($business_name)) {
        $_SESSION['error_message'] = 'Business name cannot be empty.';
    } else {
        if ($business_id) {
            // ✅ Update existing
            $stmt = $conn->prepare("UPDATE business_details SET 
                name = ?, address = ?, contact_number = ?, email = ?, 
                daily_rate = ?, weekly_rate = ?, monthly_rate = ?, 
                low_stock_alert = ?, overdue_rental_alert = ? 
                WHERE id = ?");
            $stmt->bind_param("sssssssssi", 
                $business_name, $address, $contact_number, $email,
                $daily_rate, $weekly_rate, $monthly_rate,
                $low_stock_alert, $overdue_rental_alert, $business_id
            );
        } else {
            // ✅ Insert new record
            $stmt = $conn->prepare("INSERT INTO business_details 
                (name, address, contact_number, email, daily_rate, weekly_rate, monthly_rate, low_stock_alert, overdue_rental_alert) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", 
                $business_name, $address, $contact_number, $email,
                $daily_rate, $weekly_rate, $monthly_rate,
                $low_stock_alert, $overdue_rental_alert
            );
        }

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Business details saved successfully!';
            header("Location: business-settings.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Error saving details: ' . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Business Settings</title>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
<style>
/* simplified CSS, same as before */
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial,sans-serif;}
body{background:#f5f5f5;color:#333;line-height:1.6;}
.container{max-width:1200px;margin:0 auto;padding-left:13%;}
.business-setting{text-align:center;margin:20px 0;font-size:1.5rem;}
.business-setting-content-container{display:flex;gap:70px;margin-top:20px;padding:20px;background:#fff;border-radius:5px;box-shadow:0 2px 5px rgba(0,0,0,0.1);}
.logo-pic-container{display:flex;flex-direction:column;align-items:center;gap:15px;min-width:250px;}
#logo-pic{object-fit:cover;border:3px solid #99BC85;border-radius:5px;}
.upload-logo-form-container form{display:flex;flex-direction:column;gap:10px;}
.upload-logo-form-container button{background:#99BC85;color:#fff;border:none;padding:8px 15px;border-radius:4px;cursor:pointer;}
.upload-logo-form-container button:hover{background:#88aa74;}
.business-details-container{flex:1;}
#business-details-form div{margin-bottom:15px;}
#business-details-form label{font-weight:bold;margin-bottom:5px;display:block;}
#business-details-form input:not([type="checkbox"]), #business-details-form textarea{padding:8px;border:1px solid #ddd;border-radius:4px;width:100%;}
#save-business-changes-button{background:#5cb85c;color:#fff;border:none;padding:8px 15px;border-radius:4px;cursor:pointer;margin-top:10px;}
#save-business-changes-button:hover{background:#4cae4c;}
#edit-business-button{background:#99BC85;color:#fff;border:none;padding:8px 15px;border-radius:4px;cursor:pointer;margin-top:10px;}
.alert{margin:20px auto;max-width:800px;padding:15px;border-radius:4px;}
.alert-success{background:#d4edda;color:#155724;border:1px solid #c3e6cb;}
.alert-danger{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;}
.close-btn{position:absolute;top:5px;right:10px;font-size:1.5rem;cursor:pointer;background:none;border:none;}
</style>
</head>
<body>
<?php include 'settings-submenu.php'; ?>
<div class="container">
<?php if(isset($_SESSION['success_message'])): ?>
<div class="alert alert-success alert-dismissible"><?= $_SESSION['success_message']; ?><button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button></div>
<?php unset($_SESSION['success_message']); endif; ?>

<?php if(isset($_SESSION['error_message'])): ?>
<div class="alert alert-danger alert-dismissible"><?= $_SESSION['error_message']; ?><button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button></div>
<?php unset($_SESSION['error_message']); endif; ?>

<h4 class="business-setting">Business Settings</h4>
<div class="business-setting-content-container">
<div class="logo-pic-container">
<img src="<?= htmlspecialchars($business['logo'] ?? 'default.png') ?>" alt="Business Logo" id="logo-pic" width="200" height="200">
<div class="upload-logo-form-container">
<form action="" method="POST" enctype="multipart/form-data">
<input type="file" name="logo_picture" accept="image/*" required>
<button type="submit" name="upload_logo">Upload Logo</button>
</form>
</div>
</div>

<div class="business-details-container">
<form action="" method="POST" id="business-details-form">
<div><label>Business Name:</label><input type="text" name="name" value="<?= htmlspecialchars($business['name']) ?>" disabled required></div>
<div><label>Address:</label><textarea name="address" rows="2" disabled><?= htmlspecialchars($business['address']) ?></textarea></div>
<div><label>Contact Number:</label><input type="text" name="contact_number" value="<?= htmlspecialchars($business['contact_number']) ?>" disabled></div>
<div><label>Email:</label><input type="email" name="email" value="<?= htmlspecialchars($business['email']) ?>" disabled></div>

<h3>Rental Box Rates</h3>
<div><label>Daily Rate:</label><input type="number" name="daily_rate" step="0.01" min="0" value="<?= htmlspecialchars($business['daily_rate']) ?>" disabled></div>
<div><label>Weekly Rate:</label><input type="number" name="weekly_rate" step="0.01" min="0" value="<?= htmlspecialchars($business['weekly_rate']) ?>" disabled></div>
<div><label>Monthly Rate:</label><input type="number" name="monthly_rate" step="0.01" min="0" value="<?= htmlspecialchars($business['monthly_rate']) ?>" disabled></div>

<h3>Notification Alerts</h3>
<div class="form-check"><input type="checkbox" name="low_stock_alert" <?= ($business['low_stock_alert'] ?? '0')==='1'?'checked':'' ?> disabled> <label>Low Stock Alert</label></div>
<div class="form-check"><input type="checkbox" name="overdue_rental_alert" <?= ($business['overdue_rental_alert'] ?? '0')==='1'?'checked':'' ?> disabled> <label>Overdue Rental Alert</label></div>

<button type="submit" name="save_business_details" id="save-business-changes-button" style="display:none;">Save Changes</button>
<button type="button" id="edit-business-button">Edit Business Details</button>
</form>
</div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded',()=>{
const editBtn=document.getElementById('edit-business-button');
const saveBtn=document.getElementById('save-business-changes-button');
const inputs=document.querySelectorAll('#business-details-form input:not([type="checkbox"]), #business-details-form textarea');
const checks=document.querySelectorAll('#business-details-form input[type="checkbox"]');

editBtn.addEventListener('click',()=>{
inputs.forEach(i=>i.disabled=false);
checks.forEach(c=>c.disabled=false);
editBtn.style.display='none';
saveBtn.style.display='inline-block';
});

document.querySelectorAll('input[type="number"]').forEach(input=>{
input.addEventListener('change',()=>{if(input.value<0)input.value=0;});
});
});
</script>
</body>
</html>
<?php $conn->close(); ?>
