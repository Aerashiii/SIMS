<!--header.php file-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Material Symbols Rounded Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />

  <?php
  $settingsPages = ['report-inventory', 'report-rental', 'report-sales', 'profile_settings', 'user_management', 'system_preferences','inventory'];

  // Common styles
  echo '<link rel="stylesheet" href="../styles/global.css">';
  echo '<link rel="stylesheet" href="../styles/topNav.css">';
  echo '<link rel="stylesheet" href="../styles/sidebar.css">';

  // Sidebar JS path handling
  $scriptPath = in_array($page, $settingsPages) ? '../scripts/sidebar.js' : '../scripts/sidebar.js';
  echo '<!-- | LINK FOR SIDEBAR SCRIPT |-->';
  echo "<script src=\"$scriptPath\"></script>";
  ?>

  <!-- | LINK FOR CSS AND SCRIPT BASED ON THE CURRENT PAGE |--> 
  <?php
  switch ($page) {
    case 'login':
      echo '<title>Login</title>';
      echo '<link rel="stylesheet" href="../styles/login.css">';
      break;

    case 'dashboard':
      echo '<title>Dashboard</title>';
      echo '<link rel="stylesheet" href="../styles/dashboard.css">';
      echo '<script src="../scripts/dashboard/dashboard.js"></script>';
      break;

    case 'records-category':
    case 'records-subcategory':
    case 'records-brand':
    case 'records-product':
    case 'records-supplier':
    case 'records-add-category':
    case 'records-add-subcategory':
    case 'records-add-brand':
    case 'records-add-product':
    case 'records-add-supplier':
      echo '<title>Records</title>';
      echo '<link rel="stylesheet" href="../styles/records.css">';
      echo '<script src="../scripts/records/records.js"></script>';
      echo '<script src="../scripts/records/category.js"></script>';
      echo '<script src="../scripts/records/subcategory.js"></script>';
      echo '<script src="../scripts/records/brand.js"></script>';
      echo '<script src="../scripts/records/products.js"></script>';
      echo '<script src="../scripts/records/supplier.js"></script>';     
      break;

    case 'inventory':
    case 'inventory-add-product':
      echo '<title>Inventory</title>';
      echo '<link rel="stylesheet" href="../styles/inventory.css">';
      echo '<script type="module" src="../scripts/inventory/inventory.js"></script>';
      echo '<script type="module" src="../scripts/inventory/onhand-product-list.js"></script>';
      echo '<script type="module" src="../scripts/inventory/low-stock-product.js"></script>';
      echo '<script type="module" src="../scripts/inventory/out-of-stock-products.js"></script>';
      echo '<script type="module" src="../scripts/inventory/stock-in.js"></script>';
      echo '<script type="module" src="../scripts/inventory/edit-and-delete-product.js"></script>';
      echo '<script type="module" src="../scripts/inventory/purchase-order.js"></script>';

      echo '<script type="module" src="../scripts/inventory/inventory-add-product.js"></script>';
      break;

    case 'pos':
      echo '<title>Point Of Sale</title>';
      echo '<link rel="stylesheet" href="../styles/pos.css">';
      echo '<script type="module" src="../scripts/pos/pos.js"></script>';
      echo '<script type="module" src="../scripts/pos/print-receipt.js"></script>';
      break;

    case 'rental':
      echo '<title>Rental</title>';
      echo '<link rel="stylesheet" href="../styles/rental.css">';
      echo '<script type="module" src="../scripts/rental/rental.js"></script>';
      echo '<script type="module" src="../scripts/rental/renter-list.js"></script>';
      echo '<script type="module" src="../scripts/rental/rental-box.js"></script>';
      echo '<script type="module" src="../scripts/rental/add-rental.js"></script>';
      echo '<script type="module" src="../scripts/rental/rental-transaction-print-receipt.js"></script>';
      echo '<script type="module" src="../scripts/rental/rental-list.js"></script>';
      break;

    case 'reports-submenu':
    case 'report-inventory':
    case 'report-rental':
    case 'report-sales':
      echo '<title>Reports</title>';
      echo '<link rel="stylesheet" href="../styles/reports.css">';
      echo '<script src="../scripts/reports/reports.js"></script>';
      echo '<script src="../scripts/reports/report-inventory.js"></script>';
      echo '<script src="../scripts/reports/report-low-stock.js"></script>';
      echo '<script src="../scripts/reports/report-out-stock.js"></script>';
      echo '<script src="../scripts/reports/report-sales.js"></script>';
      echo '<script src="../scripts/reports/report-rental.js"></script>';
      break;

    case 'settings-profile-settings':
    case 'settings-user-management':
    case 'settings-system-preferences':
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

  <?php
  if ($page !== 'login') {
    require '../includes/topNav.php';

    // Exclude sidebar on POS page only
    if ($page !== 'pos') {
      include '../includes/sidebar.php';
    }
  }
  ?>
