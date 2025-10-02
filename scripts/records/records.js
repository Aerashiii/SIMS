document.addEventListener('DOMContentLoaded' , function(){
    // FOR DISPLAYING AND HIDING SUBMENU ON RECORDS
    const recordsHeader = document.getElementById('records-header-container');
    const hideRecordsSubMenuButton = document.getElementById('hide-records-submenu-button');
    const recordsSubMenuCon = document.querySelector('.records-submenu-container');


/********************| DISPLAYING AND HIDING THE SUB MENU ON RECORDS PAGE |************************* */
    recordsHeader.addEventListener('click', function(){
        recordsSubMenuCon.classList.toggle('active'); // Use toggle for better UX
    })
    
    hideRecordsSubMenuButton.addEventListener('click', function(){
        recordsSubMenuCon.classList.remove('active');
    })


});