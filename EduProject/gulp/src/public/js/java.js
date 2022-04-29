window.addEventListener('load', () => {

    /* Register the service worker .*/
    navigator.serviceWorker.register('../serviceworker.js', { 'scope': '../' });

    /* The navigation bar.
       ======================================================================================================= */
    document.querySelector(".nav-show").addEventListener("click", showMenu);
    document.querySelector(".nav-hide").addEventListener("click", hideMenu);

    function showMenu() {
        navLinks.style.right = "0";
    }

    function hideMenu() {
        navLinks.style.right = "-200px";
    }

});