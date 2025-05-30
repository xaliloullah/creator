function translator() {
    new google.translate.TranslateElement({ autoDisplay: false }, "translator");
}

function changeLanguage(lang) {
    let select = document.querySelector(".goog-te-combo");
    if (select) {
        select.value = lang;
        select.dispatchEvent(new Event("change"));
    }
}
