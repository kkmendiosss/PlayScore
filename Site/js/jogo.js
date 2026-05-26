const loginBtn = document.querySelector(".login-btn");

loginBtn.addEventListener("click", () => {
    alert("Página de login em desenvolvimento!");
});

const favoriteBtn = document.querySelector(".favorite");

favoriteBtn.addEventListener("click", (e) => {
    e.preventDefault();

    favoriteBtn.innerText = "Adicionado aos favoritos!";
});

document.addEventListener("DOMContentLoaded", () => {

    const stars = document.querySelectorAll(".stars span");
    const input = document.getElementById("ratingValue");
    const form = document.getElementById("ratingForm");

    console.log({ stars, input, form });

    // 🔥 evita crash
    if (!stars.length || !input || !form) {
        console.error("Elementos não encontrados no HTML");
        return;
    }

    stars.forEach((star, index) => {

        star.addEventListener("click", () => {

            let value = index + 1;

            console.log("CLICK:", value);

            input.value = value;

            stars.forEach((s, i) => {
                s.style.color = i < value ? "gold" : "#444";
            });

            form.submit();
        });

    });

});

document.addEventListener("DOMContentLoaded", () => {

    const toast = document.getElementById("toast");

    if (!toast) return;

    const params = new URLSearchParams(window.location.search);

    if (params.get("rated") === "1") {

        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }
});