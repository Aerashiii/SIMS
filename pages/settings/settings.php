<!-- | ALL SETTING CONTENT ONLY HERE |-->

<style>
    .settings-main-content-container {
        padding: 0px 10px 0px 20px;
        margin-left: 13%;
        background-color: #ffffff;
    }
    .settings-header-container {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 5px;
        font-size: 30px;
        cursor: pointer;
        font-weight: bold;
    }
    .settings-header-container:hover {
        color: #B2CF9B;
    }
    .settings-header-container span {
        font-size: 2.5rem;
    }
    .settings-sidebar-submenu-container {
        height: 85vh;
        width: 0px;
        border-radius: 3px;
        background-color: #ffffff;
        z-index: 10;
        top: 12vh;
        position: fixed;
        overflow: hidden;
        border: none;
        transition: width 0.3s ease;
    }
    .settings-sidebar-submenu-container.active {
        width: 180px;
    }
    #hide-settings-submenu-button {
        float: right;
        cursor: pointer;
    }
    #hide-settings-submenu-button:hover {
        color: red;
    }
    .settings-top-submenu-container {
        width: 100%;
    }
    .settings-sidebar-submenu-container h4 {
        text-align: center;
        padding: 10px 0;
        border-bottom: 1px solid rgb(73, 73, 73);
    }
    .settings-submenu-list {
        display: flex;
        flex-direction: column;
    }
    .settings-submenu-list li {
        list-style: none;
        padding: 5px 0;
        transition: all ease 0.6s;
    }
    .settings-submenu-list li:hover {
        padding-left: 10px;
    }
    .settings-submenu-list li a {
        text-decoration: none;
        padding: 5px 30px;
        display: flex;
        align-items: center;
        gap: 5px;
        color: rgb(73, 73, 73);
        transition: all 0.3s ease;
    }
    .settings-submenu-list li a:hover {
        color: #99BC85;
        border-bottom: 2px solid #99BC85;
    }
    .settings-submenu-list li a.active {
        color: #99BC85;
        border-bottom: 3px solid #99BC85;
        background-color: #eaf8e2;
        font-weight: bold;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    
        const currentPath = window.location.pathname.split('/').pop();
        const settingsTopbarLinks = document.querySelectorAll('.settings-top-bar');

        settingsTopbarLinks.forEach(link => {
            const linkPath = link.getAttribute('href').split('/').pop();
            if (linkPath === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });

        const settingSideBar = document.querySelector('.settings-sidebar-submenu-container');
        const settingsidebarButton = document.getElementById('settings-header-container');
        const hidesettingSideMenu = document.getElementById('hide-settings-submenu-button');

        settingsidebarButton.addEventListener('click', function () {
            settingSideBar.classList.toggle('active');
        });

        hidesettingSideMenu.addEventListener('click', function () {
            settingSideBar.classList.remove('active');
        });
    });
</script>

<main class="main-content-container">

    <div class="settings-header-container" id="settings-header-container">
        <span class="material-symbols-rounded">settings</span> <!-- Changed to settings icon -->
        Settings
    </div>

    <div class="settings-sidebar-submenu-container"> 
        <span class="material-symbols-rounded" id="hide-settings-submenu-button">cancel</span>
        <h4>Settings Content</h4>
        <ul class="settings-submenu-list">
            <li>
                <a href="./profile-settings.php" class="settings-top-bar">
                    <span class="material-symbols-rounded">person</span> <!-- profile icon -->
                    Profile
                </a>
            </li>
            <li>
                <a href="./user-management.php" class="settings-top-bar">
                    <span class="material-symbols-rounded">group</span> <!-- user management icon -->
                    User Management
                </a>
            </li>
            <li>
                <a href="./system-preferences.php" class="settings-top-bar">
                    <span class="material-symbols-rounded">settings</span> <!-- system preferences icon -->
                    System Preferences
                </a>
            </li>          
        </ul>
    </div> 
</main>
