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



    /* Change HTML dropdown dox value.
       ======================================================================================================= */

    /* HTML */
    document.querySelector('#dropdownH').addEventListener('change', dropdownH);

    function dropdownH() {
        switch (document.querySelector("#dropdownH").value) {
            case "h1":
                document.querySelector("#dropdownHText").textContent = "</h1>";
                break;
            case "h2":
                document.querySelector("#dropdownHText").textContent = "</h2>";
                break;
            case "h3":
                document.querySelector("#dropdownHText").textContent = "</h3>";
                break;
            case "h4":
                document.querySelector("#dropdownHText").textContent = "</h4>";
                break;
            case "h5":
                document.querySelector("#dropdownHText").textContent = "</h5>";
                break;
            case "h6":
                document.querySelector("#dropdownHText").textContent = "</h6>";
                break;
        }
    }

    document.querySelector('#dropdownLinks').addEventListener('change', dropdownLinks);

    function dropdownLinks() {
        switch (document.querySelector("#dropdownLinks").value) {
            case "link":
                document.querySelector("#dropdownLinksText").textContent = ' rel="stylesheet" href="style.css" />';
                break;
            case "script":
                document.querySelector("#dropdownLinksText").textContent = ' src="js/index.js"></script>';
                break;
        }
    }

    document.querySelector('#dropdownDivSpan').addEventListener('change', dropdownDivSpan);

    function dropdownDivSpan() {
        switch (document.querySelector("#dropdownDivSpan").value) {
            case "div":
                document.querySelector("#dropdownDivSpanText").textContent = '</div>';
                break;
            case "span":
                document.querySelector("#dropdownDivSpanText").textContent = '</span>';
                break;
        }
    }

    document.querySelector('#dropdownDivision').addEventListener('change', dropdownDivision);

    function dropdownDivision() {
        switch (document.querySelector("#dropdownDivision").value) {
            case "header":
                document.querySelector("#dropdownDivisionText").textContent = "The header, a container for introductory content!</h1>";
                break;
            case "main":
                document.querySelector("#dropdownDivisionText").textContent = "The main, representing the content of the <body> of a document!</main>";
                break;
            case "article":
                document.querySelector("#dropdownDivisionText").textContent = "An article, a self-contained section in a document!</article>";
                break;
            case "section":
                document.querySelector("#dropdownDivisionText").textContent = "A section, a standalone section of a document!</section>";
                break;
            case "footer":
                document.querySelector("#dropdownDivisionText").textContent = "The footer, a footer containing information!</footer>";
                break;
        }
    }

    /* CSS */

    document.querySelector('#dropdownClassId').addEventListener('change', dropdownClassId);

    function dropdownClassId() {
        switch (document.querySelector("#dropdownClassId").value) {
            case "class":
                document.querySelector("#dropdownClassIdText").textContent = "You are editing a class!";
                break;
            case "id":
                document.querySelector("#dropdownClassIdText").textContent = "You are editing an id!";
                break;
        }
    }

    /* JavaScript */

});