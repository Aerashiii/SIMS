 <style>
 /***********| RECORDS SUBMENU STYLES |*********************** */
    .records-submenu-container {
        height: 85vh;
        width: 0px;
        border-radius: 3px;
        background-color: #ffffff;
        z-index: 10;
        top: 12vh;
        position: fixed;
        overflow: hidden;
        border: none;
        transition: width 0.3s ease; /* Smooth transition effect */
    }

    .records-submenu-container.active {
        width: 180px;
    }
    #hide-records-submenu-button{
        float:right;
        cursor: pointer;
    }
    #hide-records-submenu-button:hover{
        color:red;
    }
    .records-submenu-container h4{
        text-align:center;
        padding:20px 0;
    }
    .records-submenu-container ul{
        list-style: none;
        padding-left:10%;
        text-align: left;
      
    }
    .records-submenu-container ul li{
        display: flex;
        align-items: center;
        gap:5px;
        padding:10px 0;
        cursor:pointer;
        align-items: center;
    }

    .records-submenu-container ul li:hover{
        background-color: #B2CF9B;
    }
    .records-submenu-list li a{
        text-decoration: none;
        color: black;
        font-size: 14px;
    }
    
 </style>
 
 <div class="records-header-container" id="records-header-container"><span class="material-symbols-rounded">menu</span>Record Management</div>
<div class="records-submenu-container">
    <span class="material-symbols-rounded" id="hide-records-submenu-button">cancel</span>
    <h4>Records Content</h4>
    <ul class="records-submenu-list">
        <li><a href="records-category.php"><span class="material-symbols-rounded">category</span>Category</a></li>
        <li><a href="records-brand.php"><span class="material-symbols-rounded">sell</span>Brand</a></li>
        <li><a href="records-product.php"><span class="material-symbols-rounded">inventory</span>Products</a></li>
        <li><a href="records-supplier.php"><span class="material-symbols-rounded">local_shipping</span>Supplier</a></li>
    </ul>

</div>