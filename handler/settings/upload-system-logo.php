<?php
session_start();
$conn = new mysqli("localhost", "root", "", "simsdb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_POST['upload_logo'])) {
    if (isset($_FILES['logo_picture']) && $_FILES['logo_picture']['error'] === 0) {
        $fileTmp = $_FILES['logo_picture']['tmp_name'];
        $fileType = mime_content_type($fileTmp);

        if (str_starts_with($fileType, 'image/')) {
            $uploadDir = '../assets/images/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = uniqid('logo_') . '_' . basename($_FILES['logo_picture']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmp, $filePath)) {
                $stmt = $conn->prepare("UPDATE business_details SET logo = ? LIMIT 1");
                $stmt->bind_param("s", $filePath);
                $stmt->execute();
                $_SESSION['success_message'] = 'Logo updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Error moving uploaded file.';
            }
        } else {
            $_SESSION['error_message'] = 'Invalid file type. Only images are allowed.';
        }
    }
}

$conn->close();
header("Location: business-settings.php");
exit;
?>
