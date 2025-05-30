document.addEventListener("DOMContentLoaded", function () {
    const imageUploads = document.querySelectorAll(".image-input");
    imageUploads.forEach(function (imageUpload) {
        const imagePreview = document.querySelector(
            `.image-preview.${imageUpload.id}`
        );

        imageUpload.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
});

// dropzone

const dropzone = document.getElementById("dropzone");
if (dropzone) {
    const dropzoneInput = document.getElementById("dropzone-input");
    const dropzoneContainer = document.getElementById("dropzone-container");
    let filesToUpload = [];

    dropzone.addEventListener("click", () => dropzoneInput.click());
    dropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropzone.classList.add("dragover");
    });
    dropzone.addEventListener("dragleave", () =>
        dropzone.classList.remove("dragover")
    );
    dropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        handleFiles(e.dataTransfer.files);
    });
    dropzoneInput.addEventListener("change", (e) =>
        handleFiles(e.target.files)
    );

    function handleFiles(files) {
        [...files].forEach((file) => {
            if (!filesToUpload.some((f) => f.name === file.name)) {
                filesToUpload.push(file);
                dropzoneFile(file);
            }
        });
    }

    function dropzoneFile(file) {
        const reader = new FileReader();
        reader.onloadend = function () {
            const dropzone = document.createElement("div");
            dropzone.className = "dropzone-item";
            dropzone.innerHTML = `
                        <img src="${reader.result}" class="dropzone-image" alt="${file.name}">
                        <a class="btn-remove btn btn-sm btn-danger" onclick="removeFile('${file.name}', event)"><i class="bi bi-x-lg"></i></a>
                    `;
            dropzoneContainer.appendChild(dropzone);
        };
        reader.readAsDataURL(file);
    }

    function removeFile(filename, event) {
        event.stopPropagation();
        filesToUpload = filesToUpload.filter((file) => file.name !== filename);
        event.target.closest(".dropzone-item").remove();
    }
}
