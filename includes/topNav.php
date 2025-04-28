<div class="top-nav-container">
    <!-- | STORE LOGO |-->
    <?php 
    // Database connection
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "simsdb";

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch business details (including logo) from the database
    $sql = "SELECT logo FROM business_details LIMIT 1"; // Fetching the logo from the first record
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the logo path
        $business_details = $result->fetch_assoc();
        $logo_path = $business_details['logo'];
    } else {
        // Default logo in case there's no data in the table
        $logo_path = 'pages/settings/uploads/logo.png';
    }

    // Logic to display different logo based on the current page
    if ($page == "report-inventory" || $page == "report-rental" || $page == "report-sales" || $page == "profile_settings" || $page == "user_management" || $page == "system_preferences") {
        echo '<a href="../../pages/dashboard.php"><img src="../../assets/images/' . htmlspecialchars($logo_path) . '" id="logo"></a>';
    } else {
        echo '<a href="../pages/dashboard.php"><img src="../assets/images/' . htmlspecialchars($logo_path) . '" id="logo"></a>';
    }

    // Fetch the logged-in user's profile picture
    $user_id = $_SESSION['id'];
    
    $user_sql = "SELECT name, role, profile_pic FROM user WHERE id = $user_id LIMIT 1";
    $user_result = $conn->query($user_sql);

    if ($user_result->num_rows > 0) {
      // Fetch the user details
      $user_details = $user_result->fetch_assoc();
      $name = $user_details['name'];
      $role = $user_details['role'];
      $profile_pic_path = $user_details['profile_pic'];
  } else {
      // Default profile picture if no custom profile is set
      $name = 'Aaaaa';  // Default name
      $role = 'admin';   // Default role
      $profile_pic_path = 'assets/images/profile.png';
  }

    // Close the connection
    $conn->close();
    ?>

    <!-- Current Time & Date -->
    <?php date_default_timezone_set('Asia/Manila'); ?>
    <div class="datetime-container">
        <p><?php echo date('l, M j, Y | h:i A'); ?></p>
    </div>

    <div class="right-container"> 
        <!-- | ADMIN PROFILE |--> 
        <div class="admin">
        <p>Hey, <span class="admin-name"><?php echo htmlspecialchars($name); ?></span><span class="admin-txt"> <?php echo htmlspecialchars($role); ?></span></p>
            <?php 
            if ($page == "report-inventory" || $page == "report-rental" || $page == "report-sales" || $page == "profile_settings" || $page == "user_management" || $page == "system_preferences") {
                echo '<img src="../../assets/images/' . htmlspecialchars($profile_pic_path) . '" id="profile" width="30" height="20">>';
            } else {
                echo '<img src="../assets/images/' . htmlspecialchars($profile_pic_path) . '" id="profile">';
            }
            ?>
        </div>
    </div>
</div>
