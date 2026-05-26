window.onload = function () {
    const ctaButton = document.querySelector('a[href="#features"]');
    if (ctaButton) {
        ctaButton.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);

            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    }
    const form = document.getElementById('signup-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const userName = document.getElementById('name').value;

            alert(`Registrado com sucesso, ${userName}! O teu cupão Humble Bundle será enviado para o teu email.`);

            form.reset();
        });
    } else {
        console.error("Erro: O formulário com id 'signup-form' não foi encontrado no HTML.");
    }
};