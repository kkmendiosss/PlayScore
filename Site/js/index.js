const slider = document.getElementById("slider");
const nextBtn = document.getElementById("nextBtn");
const prevBtn = document.getElementById("prevBtn");

nextBtn.addEventListener("click", () => {
    slider.scrollLeft += 300;
});

prevBtn.addEventListener("click", () => {
    slider.scrollLeft -= 300;
});
