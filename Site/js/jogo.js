const loginBtn = document.querySelector(".login-btn");

loginBtn.addEventListener("click", () => {
    alert("Página de login em desenvolvimento!");
});

const favoriteBtn = document.querySelector(".favorite");

favoriteBtn.addEventListener("click", (e) => {
    e.preventDefault();

    favoriteBtn.innerText = "Adicionado aos favoritos!";
});

