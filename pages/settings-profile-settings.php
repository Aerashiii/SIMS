<?php
// profile-settings.php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location:login.php');
    exit;
}



$page = 'settings-profile-settings';
require '../includes/header.php';

$user_id = $_SESSION['id'];

// === DATABASE CONNECTION ===
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<div class='error-message'>No user data found.</div>";
    exit;
}

// Handle Profile Picture Upload
if (isset($_POST['upload_profile'])) {
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $fileTmp = $_FILES['profile_picture']['tmp_name'];
        $fileType = mime_content_type($fileTmp);

        // Validate image type
        if (str_starts_with($fileType, 'image/')) {
            $uploadDir = '../../assets/images/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmp, $filePath)) {
                // Delete old profile picture if it exists and isn't the default
                if (!empty($user['profile_pic']) && $user['profile_pic'] !== 'default.png' && file_exists($user['profile_pic'])) {
                    unlink($user['profile_pic']);
                }

                // Update profile pic path in database
                $updatePic = "UPDATE user SET profile_pic = ? WHERE id = ?";
                $stmt = $conn->prepare($updatePic);
                $stmt->bind_param("si", $filePath, $user_id);
                if ($stmt->execute()) {
                    echo "<script>alert('Profile picture updated successfully!');</script>";
                    echo "<script>window.location.reload()</script>";
                    header("Refresh:0");
                    exit();
                } else {
                    echo "<script>alert('Error updating profile picture.');</script>";
                }
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only images allowed.');</script>";
        }
    } else {
        echo "<script>alert('Please select a valid image file.');</script>";
    }
}

// Handle Saving Profile Changes
if (isset($_POST['save_changes'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($name) || empty($username)) {
        echo "<script>alert('Name and username cannot be empty.');</script>";
    } else {
        if (!empty($password)) {
            // Password provided, hash it
           // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $updateDetails = "UPDATE user SET name = ?, username = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($updateDetails);
            $stmt->bind_param("sssi", $name, $username, $password, $user_id);
        } else {
            // Password empty, don't update password
            $updateDetails = "UPDATE user SET name = ?, username = ? WHERE id = ?";
            $stmt = $conn->prepare($updateDetails);
            $stmt->bind_param("ssi", $name, $username, $user_id);
        }

        if ($stmt->execute()) {
    
            
            header("Refresh:0");
            exit();
        } else {
            echo "<script>alert('Error updating profile.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <style>
        .profile-setting {
            margin-top: 20px;
            margin-left: 180px;
            color: #333;
            font-size: 1.5rem;
            text-align: center;
        }
        .profile-setting-content-container {
            display: flex;
            gap: 70px;
            margin-left:200px;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
          
        }
        .profile-pic-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        #profile-pic {
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #99BC85;
        }
        .upload-profile-form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .upload-profile-form-container input[type="file"] {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
        .upload-profile-form-container button {
            background-color: #99BC85;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .upload-profile-form-container button:hover {
            background-color: #88aa74;
        }
        .profile-details-container {          
            width:50%;
         
        }
        #user-details-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        #user-details-form div {
            display: flex;
            flex-direction: column;
            gap: 5px;
          
        }
        #user-details-form label {
            font-weight: bold;
        }
        #user-details-form input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            max-width: 400px;
        }
        #user-details-form h3 {
            margin-top: 15px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        #change-profile-button, #save-profile-changes-button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: fit-content;
        }
        #change-profile-button {
            background-color: #99BC85;
            color: white;
        }
        #change-profile-button:hover {
            background-color: #88aa74;
        }
        #save-profile-changes-button {
            background-color: #5cb85c;
            color: white;
        }
        #save-profile-changes-button:hover {
            background-color: #4cae4c;
        }
        #view-password-button {
            margin-left: 10px;
            padding: 5px 10px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            width:100px;
        }
        .password-container {
            display: flex;
        }
        /* MEDIA QUERY FOR SMALLER DEVICES (Tablets and below) */
@media (max-width: 768px) {
    .profile-setting {
        font-size: 1.2rem;
        margin-left: 0;
    }
    .profile-setting-content-container {
        flex-direction: column;
        gap: 20px;
        margin-left: 0;
    }
    .profile-pic-container {
        align-items: center;
    }
    .profile-details-container {
        width: 100%;
    }
    #user-details-form input {
        max-width: 100%;
    }
    #user-details-form h3 {
        font-size: 1.4rem;
    }
    #change-profile-button,
    #save-profile-changes-button {
        width: 100%;
        padding: 10px;
    }
    #view-password-button {
        width: 100%;
    }
}

/* MEDIA QUERY FOR VERY SMALL DEVICES (Phones) */
@media (max-width: 480px) {
    .profile-setting {
        font-size: 1rem;
        margin-left: 0;
        padding: 10px;
    }
    .profile-setting-content-container {
        flex-direction: column;
        gap: 10px;
        margin-left: 0;
    }
    .profile-pic-container {
        gap: 10px;
    }
    #profile-pic {
        width: 80px;
        height: 80px;
    }
    .profile-details-container {
        width: 100%;
    }
    #user-details-form input {
        max-width: 100%;
    }
    #user-details-form h3 {
        font-size: 1.2rem;
    }
    #change-profile-button,
    #save-profile-changes-button {
        width: 100%;
        padding: 12px;
    }
    #view-password-button {
        width: 100%;
    }
}
    </style>

</head>
<body>
    <?php include 'settings-submenu.php'; ?>

    <h4 class="profile-setting">Profile Setting</h4>
    
    <div class="profile-setting-content-container">
        <div class="profile-pic-container">
            <img src="<?= htmlspecialchars($user['profile_pic'] ?? 'default.png') ?>" alt="Profile Picture" id="profile-pic" width="170" height="170">
            <div class="upload-profile-form-container">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="profile_picture" accept="image/*" required>
                    <button type="submit" name="upload_profile">Upload Profile</button>
                </form>
            </div>
        </div>

        <div class="profile-details-container">
            <form action="settings-profile-settings.php" method="POST" id="user-details-form">
                <div>
                    <label>Name:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" disabled>
                </div>

                <h3>Account Details</h3>
                <div>
                    <label>User Name:</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                </div>

                <div>
                    <label>Password:</label>
                    <div class="password-container">
                        <input type="password" name="password" value="" disabled id="password-input" placeholder="Leave blank to keep current">
                        <button type="button" id="view-password-button">View</button>
                    </div>
                </div>

                <button type="submit" name="save_changes" id="save-profile-changes-button" style="display:none;">Save Changes</button>
                <button type="button" id="change-profile-button">Edit Profile</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const changeButton = document.getElementById('change-profile-button');
            const saveButton = document.getElementById('save-profile-changes-button');
            const inputs = document.querySelectorAll('#user-details-form input[type="text"], #user-details-form input[type="password"]');
            const passwordInput = document.getElementById('password-input');
            const viewPasswordButton = document.getElementById('view-password-button');

            if (changeButton && saveButton && inputs) {
                changeButton.addEventListener('click', () => {
                    inputs.forEach(input => input.disabled = false);
                    changeButton.style.display = 'none';
                    saveButton.style.display = 'inline-block';
                });
            }

            if (viewPasswordButton && passwordInput) {
                viewPasswordButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        viewPasswordButton.textContent = "Hide";
                    } else {
                        passwordInput.type = "password";
                        viewPasswordButton.textContent = "View";
                    }
                });
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();

?>