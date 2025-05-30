document.addEventListener("DOMContentLoaded", function () {
    // active menu and submenu
    let currentUrl = window.location.href.split(/[?#]/)[0];
    let baseLink = null;

    document.querySelectorAll("#sidebar .menu").forEach((link) => {
        if (
            currentUrl.includes(link.href) &&
            (!baseLink || link.href.length > baseLink.href.length)
        ) {
            baseLink = link;
        }
    });

    if (baseLink) {
        baseLink.classList.add("active");

        let showMenu = (element) => {
            let parentCollapse = element.closest(".submenu");
            if (parentCollapse) {
                parentCollapse.classList.add("show");
                let parentLink = parentCollapse.previousElementSibling;
                if (parentLink) {
                    parentLink.classList.add("active");
                    parentLink.setAttribute("aria-expanded", "true");
                    showMenu(parentLink);
                }
            }
        };
        showMenu(baseLink);
    }

    let menu = document.querySelectorAll("#sidebar .menu + .submenu");
    menu.forEach((submenu) => {
        let parentLink = submenu.previousElementSibling;

        if (parentLink) {
            let icon = document.createElement("i");
            icon.className = "bi bi-chevron-right ms-auto float-end";
            parentLink.appendChild(icon);
        }
    });

    // color picker
    const colorPicker = document.getElementById("color-picker");

    if (colorPicker) {
        colorPicker.addEventListener("change", function (event) {
            if (event.target.type === "radio") {
                const selectedColor = event.target.value;

                document.querySelectorAll(".color-option").forEach((option) => {
                    option.classList.remove("active");
                });
                event.target.nextElementSibling.classList.add("active");
            }
        });
    }

    document.querySelectorAll(".color-picker").forEach((colorPicker) => {
        const colorInput = colorPicker.querySelector(".color-input");
        const colorCode = colorPicker.querySelector(".color-code");
        const colorRandom = colorPicker.querySelector(".color-random");

        function updateColor(color) {
            colorInput.value = color;
            colorCode.value = color;
        }

        colorInput.addEventListener("input", (e) =>
            updateColor(e.target.value)
        );
        colorCode.addEventListener("input", (e) => updateColor(e.target.value));
        colorRandom.addEventListener("click", () => {
            const randomColor =
                "#" +
                Math.floor(Math.random() * 16777215)
                    .toString(16)
                    .padStart(6, "0");
            updateColor(randomColor);
        });
    });
});
// active tab
document.addEventListener("DOMContentLoaded", function () {
    const tabKey = "activeTab";
    const tabButtons = document.querySelectorAll(".nav-link");

    // Vérifier si un onglet a été enregistré dans le localStorage
    const savedTab = localStorage.getItem(tabKey);
    if (savedTab) {
        const activeTab = document.querySelector(
            `[data-bs-target='${savedTab}']`
        );
        if (activeTab) {
            new bootstrap.Tab(activeTab).show();
        }
    }

    // Ajouter un écouteur d'événements sur chaque onglet
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function (event) {
            const targetTab = event.target.getAttribute("data-bs-target");
            localStorage.setItem(tabKey, targetTab);
        });
    });
});
