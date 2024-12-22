<!-- | ALL HEADER CONTENT HERE | -->

<!--header.php file-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    
    <!-- | LINK FOR GLOBAL, TOPNAV, AND SIDEBAR CSS  |--> 
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/topNav.css">
    <link rel="stylesheet" href="../styles/sidebar.css">

    <!-- | LINK FOR SIDEBAR SCRIPT |--> 
    <script src="../scripts/sidebar.js"></script>

    <!-- | LINK FOR CSS AND SCRIPT BASED ON THE CURRENT PAGE |--> 
    <?php
    switch ($page) {

        // IF THE CURRENT PAGE IS LOGIN, THEN LINK THE CSS AND SCRIPT OF THE LOGIN PAGE
        case 'login':
            echo '<title>Login</title>';
            echo '<link rel="stylesheet" href="../styles/login.css">';
            break;

        // IF THE CURRENT PAGE IS DASHBOARD, THEN LINK THE CSS AND SCRIPT OF THE DASHBOARD PAGE
        case 'dashboard':
            echo '<title>Dashboard</title>';
            echo '<link rel="stylesheet" href="../styles/dashboard.css">';
            break;
        // IF THE CURRENT PAGE IS RECORDS, THEN LINK THE CSS AND SCRIPT OF THE RECORDS PAGE
        case 'records':
            echo '<title>Analytics</title>';
            echo '<link rel="stylesheet" href="../styles/records.css">';
            echo '<script src="../scripts/records/records.js"></script>';
            break;

        // IF THE CURRENT PAGE IS ANALYTICS, THEN LINK THE CSS AND SCRIPT OF THE ANALYTICS PAGE
        case 'analytics':
            echo '<title>Analytics</title>';
            echo '<link rel="stylesheet" href="../styles/analytics.css">';
            echo '<script src="../scripts/analytics.js"></script>';
            break;
        // IF THE CURRENT PAGE IS INVENTORY, THEN LINK THE CSS AND SCRIPT OF THE INVENTORY PAGE
        case 'inventory':
            echo '<title>Inventory</title>';
            echo '<link rel="stylesheet" href="../styles/inventory.css">';
            echo '<script src="../scripts/inventory/inventory.js"></script>';
            break;
        // IF THE CURRENT PAGE IS SALES, THEN LINK THE CSS AND SCRIPT OF THE SALES PAGE
        case 'sales':
            echo '<title>Sales</title>';
            echo '<link rel="stylesheet" href="../styles/sales.css">';
            echo '<script src="../scripts/sales.js"></script>';
            break;
        // IF THE CURRENT PAGE IS RENTAL-BOXES, THEN LINK THE CSS AND SCRIPT OF THE RENTAL-BOXES PAGE
        case 'rental-boxes':
            echo '<title>Rental Boxes</title>';
            echo '<link rel="stylesheet" href="../scripts/rental-boxes.css">';
            break;
        // IF THE CURRENT PAGE IS SETTINGS, THEN LINK THE CSS AND SCRIPT OF THE SETTINGS PAGE
        case 'settings':
            echo '<title>Settings</title>';
            echo '<link rel="stylesheet" href="../styles/settings.css">';
            echo '<script src="../scripts/settings.js"></script>';
            break;
       
        default:
            echo '<title>Dashboard</title>';
            break;
    }
    ?>

</head>



<body data-page="<?php echo $page; ?>">

    <!-- | IF THE ACTIVE PAGE IS NOT LOGIN PAGE INCLUDE THE TOPNAV AND SIDEBAR. ONLY PAGES EXCEPT LOGIN PAGE USE THE TOPNAV AND SIDEBAR |--> 
<?php
    if ($page != "login") {
        require '../includes/topNav.php';
        include '../includes/sidebar.php';
    }
    ?>

</body>