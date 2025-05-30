function updateTheme(theme) {
    const body = document.body;
    document.body.setAttribute("data-bs-theme", theme);
    document.getElementById("theme-icon").className =
        theme === "dark" ? "bi bi-sun me-2" : "bi bi-moon me-2";
    document.getElementById("theme-text").textContent =
        theme === "dark" ? "Mode Clair" : "Mode Sombre";
}

function setTheme(theme) {
    updateTheme(theme);
    localStorage.setItem("theme", theme);
}

const themeToggle = document.getElementById("theme-toggle");
const theme = localStorage.getItem("theme") || "light";

updateTheme(theme);

if (themeToggle) {
    themeToggle.addEventListener("click", function (event) {
        event.preventDefault();
        const currentTheme = document.body.getAttribute("data-bs-theme");
        const newTheme = currentTheme === "light" ? "dark" : "light";
        setTheme(newTheme);
    });
}
