const form = document.getElementById("registerForm");
const achievement = document.getElementById("achievement");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  achievement.classList.add("show");

  setTimeout(() => {
    achievement.classList.remove("show");
  }, 3000);

  form.reset();
});

const elements = document.querySelectorAll(".card, .game-card");

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = 1;
      entry.target.style.transform = "translateY(0)";
    }
  });
});

elements.forEach(el => {
  el.style.opacity = 0;
  el.style.transform = "translateY(50px)";
  el.style.transition = "0.6s";
  observer.observe(el);
});