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

    /* The clickable text sections.
       ======================================================================================================= */
    const section = document.querySelectorAll(".clickableSection");
    let sectionNumber;

    for (sectionNumber = 0; sectionNumber < section.length; sectionNumber++) {
        section[sectionNumber].addEventListener("click", function() {
            this.classList.toggle("active");
            const content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

});