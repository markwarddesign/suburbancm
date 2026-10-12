const sliderTrack = document.getElementById("slider-track");
const slides = sliderTrack ? Array.from(sliderTrack.children) : [];
const nextButton = document.getElementById("slider-next");
const prevButton = document.getElementById("slider-prev");
const dotsContainer = document.getElementById("slider-dots");
let currentIndex = 0;

function updateSlider() {
    if (!sliderTrack || slides.length === 0) return;
    const slideWidth = slides[0].getBoundingClientRect().width;
    sliderTrack.style.transform = `translateX(-${Math.round(
        currentIndex * slideWidth
    )}px)`;
    updateDots();
}

function updateDots() {
    if (!dotsContainer) return;
    const isDarkMode = document.documentElement.classList.contains("dark");
    Array.from(dotsContainer.children).forEach((dot, index) => {
        dot.classList.remove(
            "bg-[#a38f50]",
            "bg-[#ffffff]/50",
            "dark:bg-[#a38f50]",
            "dark:bg-[#80703a]/50"
        );
        if (index === currentIndex) {
            dot.classList.add("bg-[#a38f50]", "dark:bg-[#e4d198]");
        } else {
            dot.classList.add("bg-[#ffffff]/50", "dark:bg-[#80703a]/50");
        }
    });
}

function createDots() {
    if (!dotsContainer || slides.length <= 1) return;
    dotsContainer.innerHTML = "";
    slides.forEach((_, index) => {
        const dot = document.createElement("button");
        dot.className = "w-3 h-3 rounded-full cursor-pointer transition-colors";
        dot.setAttribute("aria-label", `Go to slide ${index + 1}`);
        dot.addEventListener("click", () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });
    updateDots();
}

function goToSlide(index) {
    if (slides.length === 0) return;
    currentIndex = (index + slides.length) % slides.length;
    updateSlider();
}

if (nextButton)
    nextButton.addEventListener("click", () => goToSlide(currentIndex + 1));
if (prevButton)
    prevButton.addEventListener("click", () => goToSlide(currentIndex - 1));

if (sliderTrack && slides.length > 0) {
    createDots();
    setTimeout(updateSlider, 0);
    window.addEventListener("resize", () => setTimeout(updateSlider, 100));
    new MutationObserver(updateDots).observe(document.documentElement, {
        attributes: true,
        attributeFilter: ["class"]
    });
}