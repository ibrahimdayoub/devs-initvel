try {
    // Header
    const currentLang = document.documentElement.getAttribute("lang");

    const langElements = document.querySelectorAll(".header .lang");

    langElements.forEach(function (langElement) {
        if (langElement.getAttribute("lang") === currentLang) {
            langElement.classList.add("active");
        }
    });

    console.log("Testt");

    // Footer
    const floatBtn = document.querySelector(".footer .float-btn");

    const toggleFloatBtnVisibility = () => {
        if (window.scrollY > 500) {
            floatBtn.classList.add("show");
        } else {
            floatBtn.classList.remove("show");
        }
    }

    toggleFloatBtnVisibility();

    window.addEventListener("scroll", toggleFloatBtnVisibility);

    floatBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

} catch (error) {
    console.log(error);
}