<?php 
session_start();

// Authentication check
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Authorization check
if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>alert('Access Denied: Cashier role cannot access this page.'); window.location.href='../login.php';</script>";
    exit;
}

$page = 'user_management';
require '../../includes/header.php';
include 'settings.php';

// Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'] ?? 'staff'; // Default role is 'staff'
    
    // Basic validation
    if (empty($name) || empty($username) || empty($password)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Check if username already exists
        $check_sql = "SELECT id FROM user WHERE username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>alert('Username already exists! Please choose a different username.');</script>";
        } else {
            // Insert new user
            $insert_sql = "INSERT INTO user (name, username, password, role, profile_pic) VALUES (?, ?, ?, ?, 'default.png')";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ssss", $name, $username, $password, $role);

            if ($insert_stmt->execute()) {
                echo "<script>alert('User added successfully!'); window.location.reload();</script>";
            } else {
                echo "<script>alert('Failed to add user.');</script>";
            }
        }
    }
}

// Handle user deletion (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id']);

    // Prevent self-deletion
    if ($user_id == $_SESSION['user_id']) {
        echo json_encode(['success' => false, 'message' => 'You cannot delete your own account!']);
        exit;
    }

    $delete_sql = "DELETE FROM user WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $user_id);

    if ($delete_stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $updated_name = trim($_POST['name']);
    $updated_username = trim($_POST['username']);
    $updated_password = trim($_POST['password']);
    $updated_role = $_POST['role'] ?? 'staff';

    // Basic validation
    if (empty($updated_name) || empty($updated_username) || empty($updated_password)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Check if username already exists for other users
        $check_sql = "SELECT id FROM user WHERE username = ? AND id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $updated_username, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
           
        } else {
            $update_sql = "UPDATE user SET name = ?, username = ?, password = ?, role = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssssi", $updated_name, $updated_username, $updated_password, $updated_role, $user_id);

            if ($update_stmt->execute()) {
                echo "<script>alert('User details updated successfully!');</script>";
            } else {
                echo "<script>alert('Failed to update user details.');</script>";
            }
        }
    }
}
?>

<style>
    /* Styles */
    .user-management-content-container {
        margin-left: 200px;
        padding: 20px;
    }
    .user-management {
        margin-top: 20px;
        color: #333;
        font-size: 1.8rem;
        text-align: center;
    }
    .staff-details-table {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .staff-details-table th, .staff-details-table td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }
    .staff-details-table img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }
    .staff-update-button,
    .staff-save-button,
    .staff-cancel-button,
    .staff-delete-button,
    .add-user-button {
        padding: 6px 10px;
        font-size: 0.85rem;
        font-weight: bold;
        border: 1px solid;
        border-radius: 3px;
        cursor: pointer;
        margin: 2px;
    }
    .staff-update-button { background: #0e0e4e; color: white; }
    .staff-save-button { background: #4CAF50; color: white; }
    .staff-cancel-button { background: #f44336; color: white; }
    .staff-delete-button { background: #cc0909; color: white; }
    .add-user-button { background: #2196F3; color: white; margin-bottom: 20px; }
    
    /* Add user form styles */
    #add-user-form {
        display: none;
        background: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.99);
        width:40%;
        margin: 0 auto;
    }
    #add-user-form div{
        width:100%;
        padding: 5px 10px;
    }
    #add-user-form div label {
        display: inline-block;
        width: 100px;
        margin-right: 10px;
    }
    #add-user-form div input, #add-user-form div select {
        padding: 8px;
        margin-right: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .add-user-button-container{
        width:100%;
        display: flex;
        justify-content: flex-end;
    }
    #add-user-submit-button {
        background: #4CAF50;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top:20px;
    }
    #add-user-submit-button:hover {
        background: #45a049;
    }
    /* MEDIA QUERY FOR SMALLER DEVICES (Tablets and below) */
@media (max-width: 768px) {
    .user-management-content-container {
        margin-left: 0;
        padding: 10px;
    }
    .user-management {
        font-size: 1.5rem;
    }
    .staff-details-table {
        margin-top: 10px;
    }
    .staff-details-table th, .staff-details-table td {
        padding: 8px;
    }
    .staff-details-table img {
        width: 35px;
        height: 35px;
    }
    .staff-update-button,
    .staff-save-button,
    .staff-cancel-button,
    .staff-delete-button,
    .add-user-button {
        font-size: 0.75rem;
        padding: 5px 8px;
    }
    #add-user-form {
        width: 80%;
    }
    #add-user-submit-button {
        width: 100%;
    }
}

/* MEDIA QUERY FOR VERY SMALL DEVICES (Phones) */
@media (max-width: 480px) {
    .user-management-content-container {
        margin-left: 0;
        padding: 5px;
    }
    .user-management {
        font-size: 1.2rem;
    }
    .staff-details-table {
        font-size: 0.85rem;
    }
    .staff-details-table th, .staff-details-table td {
        padding: 5px;
    }
    .staff-details-table img {
        width: 30px;
        height: 30px;
    }
    .staff-update-button,
    .staff-save-button,
    .staff-cancel-button,
    .staff-delete-button,
    .add-user-button {
        font-size: 0.65rem;
        padding: 4px 6px;
    }
    #add-user-form {
        width: 90%;
    }
    #add-user-submit-button {
        width: 100%;
    }
}
</style>

<div class="user-management-content-container">
    <h4 class="user-management">User Management</h4>
    
    <!-- Add User Button -->
     <div class="add-user-button-container">
        <button id="add-user-button" class="add-user-button">Add New User</button>
     </div>
    
    
    <!-- Add User Form (initially hidden) -->
    <form action="add-user.php" method="POST" id="add-user-form">
        <div>
            <label for="add-name">Name:</label>
            <input type="text" id="add-name" name="name" required>
        </div>
        <div>
            <label for="add-user-name">Username:</label>
            <input type="text" id="add-user-name" name="username" required>
        </div>
        <div>               
            <label for="add-user-password">Password:</label>
            <input type="password" id="add-user-password" name="password" required>
        </div>
        <div>
            <label for="add-user-role">Role:</label>
            <select id="add-user-role" name="role">
                <option value="admin">Admin</option>
                <option value="cashier">Cashier</option>
            </select>
        </div>
        
        
    
        
        <button type="submit" id="add-user-submit-button" name="add_user">Add User</button>
    </form>

<?php
// Fetch users from database
$userRole = $_SESSION['role'] ?? '';
if ($userRole === 'admin') {     
    $sql = "SELECT * FROM user ORDER BY role, name";
}

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

echo "<table class='staff-details-table' id='user-table'>
    <tr>
        <th>Profile</th>
        <th>Role</th>
        <th>Staff Name</th>
        <th>Username</th>
        <th>Password</th>
        <th>Action</th>
    </tr>";

while ($user = $result->fetch_assoc()) {
    $userId = htmlspecialchars($user['id']);
    $isCurrentUser = ($userId == $_SESSION['id']);
    
    echo "
    <tr id='user-row-$userId'>
        <td><img src='" . htmlspecialchars($user['profile_pic'] ?? 'default.png') . "' alt='Profile Picture'></td>
        <td>
            <select id='role-$userId' " . ($isCurrentUser ? 'disabled' : '') . " class='role-select'>
                <option value='admin'" . ($user['role'] === 'admin' ? ' selected' : '') . ">Admin</option>
                <option value='cashier'" . ($user['role'] === 'cashier' ? ' selected' : '') . ">Cashier</option>
            </select>
        </td>
        <td><input type='text' id='fullname-$userId' value='" . htmlspecialchars($user['name']) . "' " . ($isCurrentUser ? 'disabled' : '') . "></td>             
        <td><input type='text' id='username-$userId' value='" . htmlspecialchars($user['username']) . "' " . ($isCurrentUser ? 'disabled' : '') . "></td>
        <td><input type='password' id='password-$userId' value='" . htmlspecialchars($user['password']) . "' " . ($isCurrentUser ? 'disabled' : '') . "></td>
        <td>";
    
    if (!$isCurrentUser) {
        echo "<button onclick=\"editUser('$userId')\" id='edit-btn-$userId' class='staff-update-button'>Edit</button>
              <button onclick=\"saveUser('$userId')\" id='save-btn-$userId' class='staff-save-button' style='display:none;'>Save</button>
              <button onclick=\"cancelEdit('$userId')\" id='cancel-btn-$userId' class='staff-cancel-button' style='display:none;'>Cancel</button>
              <button onclick=\"deleteUser('$userId')\" class='staff-delete-button'>Delete</button>";
    } else {
        echo "<span>Current User</span>";
    }
    
    echo "</td>
    </tr>
    ";
}
echo "</table>";
?>
</div>

<script>
// Toggle add user form visibility
document.getElementById('add-user-button').addEventListener('click', function() {
    const form = document.getElementById('add-user-form');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
});

function editUser(id) {
    document.getElementById('fullname-' + id).disabled = false;
    document.getElementById('username-' + id).disabled = false;
    document.getElementById('password-' + id).disabled = false;
    document.getElementById('role-' + id).disabled = false;
    document.getElementById('edit-btn-' + id).style.display = 'none';
    document.getElementById('save-btn-' + id).style.display = 'inline-block';
    document.getElementById('cancel-btn-' + id).style.display = 'inline-block';
}

function cancelEdit(id) {
    document.getElementById('fullname-' + id).disabled = true;
    document.getElementById('username-' + id).disabled = true;
    document.getElementById('password-' + id).disabled = true;
    document.getElementById('role-' + id).disabled = true;
    document.getElementById('edit-btn-' + id).style.display = 'inline-block';
    document.getElementById('save-btn-' + id).style.display = 'none';
    document.getElementById('cancel-btn-' + id).style.display = 'none';
    
    // Reset values (optional - you might want to reload from server instead)
    // This would require an additional AJAX call to get original values
}

function saveUser(id) {
    const name = document.getElementById('fullname-' + id).value;
    const username = document.getElementById('username-' + id).value;
    const password = document.getElementById('password-' + id).value;
    const role = document.getElementById('role-' + id).value;

    const form = document.createElement('form');
    form.method = 'POST';
    form.style.display = 'none';
    document.body.appendChild(form);

    const inputUserId = document.createElement('input');
    inputUserId.name = 'user_id';
    inputUserId.value = id;
    form.appendChild(inputUserId);

    const inputName = document.createElement('input');
    inputName.name = 'name';
    inputName.value = name;
    form.appendChild(inputName);

    const inputUsername = document.createElement('input');
    inputUsername.name = 'username';
    inputUsername.value = username;
    form.appendChild(inputUsername);

    const inputPassword = document.createElement('input');
    inputPassword.name = 'password';
    inputPassword.value = password;
    form.appendChild(inputPassword);

    const inputRole = document.createElement('input');
    inputRole.name = 'role';
    inputRole.value = role;
    form.appendChild(inputRole);

    const updateUser = document.createElement('input');
    updateUser.name = 'update_user';
    updateUser.value = '1';
    form.appendChild(updateUser);

    form.submit();
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch(window.location.href, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'delete_user=1&user_id=' + encodeURIComponent(id)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User deleted successfully!');
                document.getElementById('user-row-' + id).remove();
            } else {
              
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.location.reload();
        });
    }
}
</script>