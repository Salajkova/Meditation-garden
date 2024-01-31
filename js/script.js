const swiper = new Swiper('.swiper', {
    autoplay: {
        delay: 7000,
        disabledOninteraction: false,
    },

    loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

});

function showform() {
    var formular = document.getElementById("Form1");
    formular.style.visibility = 'visible';
    formular.style.display = "block";
}