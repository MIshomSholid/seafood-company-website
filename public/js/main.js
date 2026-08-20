document.addEventListener("DOMContentLoaded", function () {
    const animatedSections = document.querySelectorAll(".section-animation");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                }
            });
        },
        {
            threshold: 0.2,
        }
    );

    animatedSections.forEach((section) => {
        observer.observe(section);
    });
});