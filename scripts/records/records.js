document.addEventListener('DOMContentLoaded' , function(){
    // FOR DISPLAYING AND HIDING SUBMENU ON RECORDS
    const recordsHeader = document.getElementById('records-header-container');
    const hideRecordsSubMenuButton = document.getElementById('hide-records-submenu-button');
    const recordsSubMenuCon = document.querySelector('.records-submenu-container');

    // FOR SWITCHING CONTENT IN RECORDS 
    const subMenuList = document.querySelectorAll('.records-submenu-list li');
    const recordsContents = document.querySelectorAll('.records-content-container');

    // FOR CATEGORY 
    const categoryButton = document.querySelectorAll('.category-header-buttons-container button')
    const categoryContent = document.querySelectorAll('.category-container');

/***********| FOR CATEGORY |************ */
    // ADD AND REMOVE ACTIVE CLASS
    categoryButton.forEach((button, index) => {
        button.addEventListener('click', function () {
            // Remove 'active' class from all buttons and containers
            categoryButton.forEach(btn => btn.classList.remove('active'));
            categoryContent .forEach(container => container.classList.remove('active'));

            // Add 'active' class to the clicked button and corresponding container
            button.classList.add('active');
            categoryContent [index].classList.add('active');
        });
    });

/********************| DISPLAYING AND HIDING THE SUB MENU ON RECORDS PAGE |************************* */
    recordsHeader.addEventListener('click', function(){
        recordsSubMenuCon.classList.toggle('active'); // Use toggle for better UX
    })
    hideRecordsSubMenuButton.addEventListener('click', function(){
        recordsSubMenuCon.classList.remove('active');
    })

/***********************| FOR SWITCHING RECORDS CONENTS BASED ON THE SUBMENU CLICKED |****************************************************** */
    subMenuList.forEach((button, index) => {
        button.addEventListener('click', function () {
            // Remove 'active' class from all buttons and containers
            subMenuList.forEach(btn => btn.classList.remove('active'));
            recordsContents .forEach(container => container.classList.remove('active'));

            // Add 'active' class to the clicked button and corresponding container
            button.classList.add('active');
            recordsContents [index].classList.add('active');
        });
    });
});