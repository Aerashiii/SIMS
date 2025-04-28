<?php 
// business-settings.php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Authorization check
if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>alert('Access Denied: Cashier role cannot access this page.'); window.location.href='../login.php';</script>";
    exit;
}

$page = 'system_preferences';
require '../../includes/header.php';

// === DATABASE CONNECTION ===
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch business details
$stmt = $conn->prepare("SELECT * FROM business_details LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $business = $result->fetch_assoc();
} else {
    // Initialize empty array if no business details exist
    $business = [
        'name' => '',
        'logo' => 'default.png',
        'address' => '',
        'contact_number' => '',
        'email' => '',
        'daily_rate' => '0',
        'weekly_rate' => '0',
        'monthly-rate' => '0', // Note the hyphen in the column name
        'low_strock_alert' => '0', // Note the typo in column name
        'overdue_rental_alert' => '0'
    ];
}

// Handle logo upload
if (isset($_POST['upload_logo'])) {
    if (isset($_FILES['logo_picture']) && $_FILES['logo_picture']['error'] === 0) {
        $fileTmp = $_FILES['logo_picture']['tmp_name'];
        $fileType = mime_content_type($fileTmp);

        // Validate image type
        if (str_starts_with($fileType, 'image/')) {
            $uploadDir = '../../assets/images/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES['logo_picture']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmp, $filePath)) {
                // Delete old logo if it exists and isn't the default
                if (!empty($business['logo']) && $business['logo'] !== 'default.png' && file_exists($business['logo'])) {
                    unlink($business['logo']);
                }

                // Update logo path in database
                $updateStmt = $conn->prepare("UPDATE business_details SET logo = ?");
                if ($updateStmt) {
                    $updateStmt->bind_param("s", $filePath);
                    if ($updateStmt->execute()) {
                        $_SESSION['success_message'] = 'Logo updated successfully!';
                        header("Location: system-preferences.php");
                        exit();
                    } else {
                        $_SESSION['error_message'] = 'Error updating logo in database.';
                    }
                } else {
                    $_SESSION['error_message'] = 'Database error: ' . $conn->error;
                }
            } else {
                $_SESSION['error_message'] = 'Error uploading file.';
            }
        } else {
            $_SESSION['error_message'] = 'Invalid file type. Only images allowed.';
        }
    } else {
        $_SESSION['error_message'] = 'Please select a valid image file.';
    }
}

// Handle saving business details
if (isset($_POST['save_business_details'])) {
    // Sanitize and validate input
    $business_name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $contact_number = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $daily_rate = $_POST['daily_rate']; // Keep as string to match DB
    $weekly_rate = $_POST['weekly_rate']; // Keep as string to match DB
    $monthly_rate = $_POST['monthly_rate']; // Keep as string to match DB
    $low_stock_alert = isset($_POST['low_stock_alert']) ? '1' : '0'; // String to match DB
    $overdue_rental_alert = isset($_POST['overdue_rental_alert']) ? '1' : '0'; // String to match DB

    // Basic validation
    if (empty($business_name)) {
        $_SESSION['error_message'] = 'Business name cannot be empty.';
    } else {
        // Check if business details already exist
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM business_details");
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $count = $checkResult->fetch_row()[0];
        
        if ($count > 0) {
            // Update existing record - note the column name with hyphen and typo
            $stmt = $conn->prepare("UPDATE business_details SET 
                name = ?, 
                address = ?, 
                contact_number = ?, 
                email = ?, 
                daily_rate = ?, 
                weekly_rate = ?, 
                `monthly-rate` = ?,
                `low_strock_alert` = ?,
                overdue_rental_alert = ?
                WHERE id = 1");
        } else {
            // Insert new record - note the column name with hyphen and typo
            $stmt = $conn->prepare("INSERT INTO business_details (
                name, 
                address, 
                contact_number, 
                email, 
                daily_rate, 
                weekly_rate, 
                `monthly-rate`,
                `low_strock_alert`,
                overdue_rental_alert
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        }
        
        $stmt->bind_param("sssssssss", 
            $business_name, 
            $address, 
            $contact_number, 
            $email, 
            $daily_rate, 
            $weekly_rate, 
            $monthly_rate,
            $low_stock_alert,
            $overdue_rental_alert
        );

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Business details updated successfully!';
            exit();
        } else {
            $_SESSION['error_message'] = 'Error updating business details: ' . $conn->error;
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 13%;
        }
        
        .business-setting {
            margin: 20px 0;
            color: #333;
            font-size: 1.5rem;
            text-align: center;
        }
        
        .business-setting-content-container {
            display: flex;
            gap: 70px;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .logo-pic-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            min-width: 250px;
        }
        
        #logo-pic {
            object-fit: cover;
            border: 3px solid #99BC85;
            border-radius: 5px;
        }
        
        .upload-logo-form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .upload-logo-form-container input[type="file"] {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
        
        .upload-logo-form-container button {
            background-color: #99BC85;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .upload-logo-form-container button:hover {
            background-color: #88aa74;
        }
        
        .business-details-container {
            flex-grow: 1;
        }
        
        #business-details-form div {
            margin-bottom: 15px;
        }
        
        #business-details-form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        
        #business-details-form input:not([type="checkbox"]), 
        #business-details-form textarea {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
        
        #business-details-form h3 {
            margin-top: 20px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        #save-business-changes-button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        #save-business-changes-button:hover {
            background-color: #4cae4c;
        }
        
        #edit-business-button {
            background-color: #99BC85;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        #edit-business-button:hover {
            background-color: #88aa74;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .form-check-input {
            margin-right: 10px;
        }
        
        .alert {
            margin: 20px auto;
            max-width: 800px;
            padding: 15px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-dismissible {
            position: relative;
        }
        
        .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 1.5rem;
            cursor: pointer;
            background: none;
            border: none;
            color: inherit;
        }
        /* MEDIA QUERIES FOR RESPONSIVENESS */

/* For Tablets and smaller screens */
@media (max-width: 768px) {
    .container {
        padding-left: 5%;
    }

    .business-setting {
        font-size: 1.2rem;
    }

    .business-setting-content-container {
        flex-direction: column;
        gap: 20px;
    }

    .logo-pic-container {
        min-width: 200px;
    }

    #business-details-form input, 
    #business-details-form textarea {
        max-width: 100%;
    }

    #save-business-changes-button,
    #edit-business-button {
        width: 100%;
    }

    #logo-pic {
        width: 150px;
        height: 150px;
    }
}

/* For Small Devices (Mobile phones) */
@media (max-width: 480px) {
    .container {
        padding-left: 3%;
    }

    .business-setting {
        font-size: 1rem;
    }

    .business-setting-content-container {
        padding: 10px;
    }

    .logo-pic-container {
        min-width: 150px;
    }

    #logo-pic {
        width: 120px;
        height: 120px;
    }

    #business-details-form input, 
    #business-details-form textarea {
        padding: 10px;
    }

    #save-business-changes-button,
    #edit-business-button {
        width: 100%;
    }
}
    </style>
</head>
<body>
    <?php include 'settings.php'; ?>

    <div class="container">
        <!-- Display success/error messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible">
                <?= $_SESSION['success_message'] ?>
                <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <?= $_SESSION['error_message'] ?>
                <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
        <h4 class="business-setting">Business Settings</h4>
        
        <div class="business-setting-content-container">
            <div class="logo-pic-container">
                <img src="<?= htmlspecialchars($business['logo'] ?? 'default.png') ?>" 
                     alt="Business Logo" 
                     id="logo-pic" 
                     width="200" 
                     height="200">
                <div class="upload-logo-form-container">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="file" name="logo_picture" accept="image/*" required>
                        <button type="submit" name="upload_logo">Upload Logo</button>
                    </form>
                </div>
            </div>

            <div class="business-details-container">
                <form action="system-preferences.php" method="POST" id="business-details-form">
                    <div>
                        <label for="name">Business Name:</label>
                        <input type="text" name="name" id="name" 
                               value="<?= htmlspecialchars($business['name']) ?>" disabled required>
                    </div>
                    
                    <div>
                        <label for="address">Address:</label>
                        <textarea name="address" id="address" rows="2" disabled><?= htmlspecialchars($business['address']) ?></textarea>
                    </div>
                    
                    <div>
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" name="contact_number" id="contact_number" 
                               value="<?= htmlspecialchars($business['contact_number']) ?>" disabled>
                    </div>
                    
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" 
                               value="<?= htmlspecialchars($business['email']) ?>" disabled>
                    </div>

                    <h3>Rental Box Rates</h3>
                    <div>
                        <label for="daily_rate">Daily Rate:</label>
                        <input type="number" name="daily_rate" id="daily_rate" step="0.01" min="0"
                               value="<?= htmlspecialchars($business['daily_rate']) ?>" disabled>
                    </div>
                    <div>
                        <label for="weekly_rate">Weekly Rate:</label>
                        <input type="number" name="weekly_rate" id="weekly_rate" step="0.01" min="0"
                               value="<?= htmlspecialchars($business['weekly_rate']) ?>" disabled>
                    </div>
                    <div>
                        <label for="monthly_rate">Monthly Rate:</label>
                        <input type="number" name="monthly_rate" id="monthly_rate" step="0.01" min="0"
                               value="<?= htmlspecialchars($business['monthly-rate']) ?>" disabled>
                    </div>

                    <h3>Notification Alerts</h3>
                    <div class="form-check">
                        <input type="checkbox" name="low_stock_alert" id="low_stock_alert" 
                               <?= ($business['low_strock_alert'] ?? '0') === '1' ? 'checked' : '' ?> disabled>
                        <label for="low_stock_alert">Low Stock Alert</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="overdue_rental_alert" id="overdue_rental_alert" 
                               <?= ($business['overdue_rental_alert'] ?? '0') === '1' ? 'checked' : '' ?> disabled>
                        <label for="overdue_rental_alert">Overdue Rental Alert</label>
                    </div>

                    <button type="submit" name="save_business_details" id="save-business-changes-button" style="display:none;">Save Changes</button>
                    <button type="button" id="edit-business-button">Edit Business Details</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButton = document.getElementById('edit-business-button');
            const saveButton = document.getElementById('save-business-changes-button');
            const inputs = document.querySelectorAll('#business-details-form input:not([type="checkbox"]), #business-details-form textarea');
            const checkboxes = document.querySelectorAll('#business-details-form input[type="checkbox"]');

            if (editButton && saveButton && inputs) {
                editButton.addEventListener('click', () => {
                    inputs.forEach(input => input.disabled = false);
                    checkboxes.forEach(checkbox => checkbox.disabled = false);
                    editButton.style.display = 'none';
                    saveButton.style.display = 'inline-block';
                });
            }

            // Validate numeric inputs
            const numericInputs = document.querySelectorAll('input[type="number"]');
            numericInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>