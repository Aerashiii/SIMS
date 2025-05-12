<div class="top-nav-container">
    <?php 
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Database connection
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "simsdb";

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch business logo
    $logo_path = 'pages/settings/uploads/logo.png'; // Default logo
    $sql = "SELECT logo FROM business_details LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['logo'])) {
            $logo_path = htmlspecialchars($row['logo']);
        }
    }

    echo '<a href="dashboard.php"><img src="' . $logo_path . '" id="logo"></a>';

    // Fetch user details
    $name = 'Admin';
    $role = 'admin';
    $profile_pic_path = 'assets/images/profile.png';

    if (isset($_SESSION['id'])) {
        $user_id = intval($_SESSION['id']);
        $user_sql = "SELECT name, role, profile_pic FROM user WHERE id = $user_id LIMIT 1";
        $user_result = $conn->query($user_sql);
        if ($user_result && $user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            $name = htmlspecialchars($user['name']);
            $role = htmlspecialchars($user['role']);
            if (!empty($user['profile_pic'])) {
                $profile_pic_path = htmlspecialchars($user['profile_pic']);
            }
        }
    }

    $conn->close();
    ?>

    <!-- Current Time & Date -->
    <?php date_default_timezone_set('Asia/Manila'); ?>
    <div class="datetime-container">
        <p><?php echo date('l, M j, Y | h:i A'); ?></p>
    </div>

    <!-- Right Side Admin Profile -->
    <div class="right-container">
        <div class="admin">
            <p>Hey, <span class="admin-name"><?php echo $name; ?></span>
               <span class="admin-txt"><?php echo $role; ?></span></p>
            <?php 
            echo '<img src="' . $profile_pic_path . '" id="profile" width="30" height="30">';
            ?>
        </div>
    </div>
</div>
