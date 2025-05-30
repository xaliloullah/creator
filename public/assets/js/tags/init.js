document.addEventListener("DOMContentLoaded", function () {
    //  tags
    document.querySelectorAll(".tags").forEach((el) => {
        new TomSelect(el, {
            persist: false,
            createOnBlur: true,
            create: true,
            plugins: ["remove_button"],
        });
    });

    document.querySelectorAll(".tags-option").forEach((el) => {
        new TomSelect(el, {
            persist: false,
            create: false,
            plugins: ["remove_button"],
            maxItems: 1,
        });
    });
    document.querySelectorAll(".tags-options").forEach((el) => {
        new TomSelect(el, {
            persist: false,
            create: false,
            plugins: ["remove_button"],
        });
    });
});
