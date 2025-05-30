(() => {
    "use strict";
    const forms = document.querySelectorAll(".validate");

    forms.forEach((form) => {
        //
        if (!form.hasAttribute("novalidate")) {
            form.setAttribute("novalidate", "");
        }
        const validateField = (input) => {
            let inputGroup = input.closest(".input-group");

            if (!input.checkValidity()) {
                let errorContainer = inputGroup
                    ? inputGroup.nextElementSibling
                    : input.nextElementSibling;

                if (
                    !errorContainer ||
                    !errorContainer.classList.contains("error-message")
                ) {
                    errorContainer = document.createElement("div");
                    errorContainer.className = "error-message";
                    if (inputGroup) {
                        inputGroup.parentNode.insertBefore(
                            errorContainer,
                            inputGroup.nextElementSibling
                        );
                    } else {
                        input.parentNode.insertBefore(
                            errorContainer,
                            input.nextElementSibling
                        );
                    }
                }

                errorContainer.textContent = input.validationMessage;

                input.classList.add("is-invalid");
            } else {
                let errorContainer = inputGroup
                    ? inputGroup.nextElementSibling
                    : input.nextElementSibling;
                if (
                    errorContainer &&
                    errorContainer.classList.contains("error-message")
                ) {
                    errorContainer.remove();
                }
                input.classList.remove("is-invalid");
            }
        };

        form.querySelectorAll("input, select, textarea").forEach((input) => {
            input.addEventListener("input", () => validateField(input));
            input.addEventListener("blur", () => validateField(input));
        });

        form.addEventListener("submit", (event) => {
            let isValid = true;

            Array.from(form.elements).forEach((input) => {
                validateField(input);
                if (!input.checkValidity()) {
                    showInvalidToast();
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    });
})();

function showInvalidToast() {
    var invalidToast = document.getElementById("invalid-toast");
    var toast = new bootstrap.Toast(invalidToast, {
        delay: 3000,
    });
    toast.show();
}
