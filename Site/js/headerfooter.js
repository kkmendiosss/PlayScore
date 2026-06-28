const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("navLinks");

hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
});

// Dropdowns no telemóvel
document.querySelectorAll(".dropdown > a").forEach(link => {
    link.addEventListener("click", function (e) {

        if (window.innerWidth <= 768) {
            e.preventDefault();

            this.parentElement.classList.toggle("active");
        }

    });
});