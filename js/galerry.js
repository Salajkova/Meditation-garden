var currentPage = document.getElementById("page1");
var currentLink = document.getElementById("link1");

function displayPage(id) {
    const newLink = document.getElementById(`link${id}`);
    const newPage = document.getElementById(`page${id}`);

    // Kontrola, zda se jedná o změnu nebo kliknutí na již aktivní odkaz
    if (newPage !== currentPage) {
        newLink.classList.add("active");
        newPage.classList.add("active");

        currentPage.classList.remove("active");
        currentLink.classList.remove("active");

        currentPage = newPage;
        currentLink = newLink;
    }
}