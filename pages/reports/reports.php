
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<!-- Include jsPDF Library (for PDF export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- Include jsPDF AutoTable Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<!-- Include SheetJS Library (for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<style>
    .reports-main-content-container {
        padding: 0px 10px 0px 20px;
        margin-left: 13%;
        background-color: #ffffff;
    }

    .reports-top-submenu-container {
        width: 100%;
    }

    .reports-submenu-list {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .reports-submenu-list li {
        list-style: none;
        padding: 5px 0;
    }

    .reports-submenu-list li a {
        text-decoration: none;
        padding: 5px 30px;
        display: flex;
        align-items: center;
        gap: 5px;
        color: rgb(73, 73, 73);
        border-bottom: 1px solid rgb(133, 133, 133);
        transition: all 0.3s ease;
    }

    .reports-submenu-list li a:hover {
        padding-left: 25px;
        color: #99BC85;
        border-bottom: 1px solid #99BC85;
    }

    .reports-submenu-list li a.active {
        color: #99BC85;
        border-bottom: 3px solid #99BC85;
        background-color: #eaf8e2;
        padding-left: 25px;
        font-weight: bold;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname.split('/').pop(); // get only the file name like 'report-sales.php'
    const reportsTopbarLinks = document.querySelectorAll('.reports-top-bar');

    reportsTopbarLinks.forEach(link => {
        const linkPath = link.getAttribute('href').split('/').pop(); // get href's filename

        if (linkPath === currentPath) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});
</script>

<main class="main-content-container">
    <div class="reports-top-submenu-container">  
        <ul class="reports-submenu-list">
            <li><a href="./report-inventory.php" class="reports-top-bar"><span class="material-symbols-rounded">inventory_2</span>Inventory</a></li>
            <li><a href="./report-sales.php" class="reports-top-bar"><span class="material-symbols-rounded">request_quote</span>Sales</a></li>
            <li><a href="./report-rental.php" class="reports-top-bar"><span class="material-symbols-rounded">storefront</span>Rental</a></li>          
        </ul>
    </div> 
</main>
