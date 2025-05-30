const togglePassword = document.querySelectorAll('[id^="toggle"]');
togglePassword.forEach((button) => {
    button.addEventListener("click", function () {
        const input = this.previousElementSibling;
        const type =
            input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);
        const icon = this.querySelector("i");
        icon.classList.toggle("bi-eye");
        icon.classList.toggle("bi-eye-slash");
    });
});
