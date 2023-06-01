var cropperInstance;
var cropImageBtn = document.getElementById("cropImageBtn");

function initializeCropper(img) {
    cropperInstance = new Cropper(img, {
        aspectRatio: 0,
        viewMode: 0,
    });
}

function turnAspectRatio(value) {
    switch (value) {
        case "0":
            cropperInstance.setAspectRatio(0);
            break;
        case "1 / 1":
            cropperInstance.setAspectRatio(1 / 1);
            break;
        case "4 / 3":
            cropperInstance.setAspectRatio(4 / 3);
            break;
        case "16 / 9":
            cropperInstance.setAspectRatio(16 / 9);
            break;
    }
}

function cropImage(input) {
    var CroppedCanvas = cropperInstance.getCroppedCanvas().toDataURL('image/jpeg');
    $('#' + input).attr('src', CroppedCanvas);

    cropperInstance.getCroppedCanvas().toBlob(function (blob) {
        // Cria um novo objeto File a partir do Blob
        var file = new File([blob], 'teste.jpg', {
            type: 'image/jpeg'
        });

        // Cria um novo objeto FileList
        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        // Cria um novo elemento input
        var newFileInput = document.createElement('input');
        newFileInput.id = input + '3';
        newFileInput.type = 'file';
        newFileInput.files = dataTransfer.files;
        newFileInput.classList.add('hidden');

        // Substitui o elemento input existente pelo novo
        var fileInput = document.getElementById(input + '3');
        fileInput.parentNode.replaceChild(newFileInput, fileInput);
    }, 'image/jpeg');
}

function changeInputImgToImg(input, img) {
    const previewImage = document.getElementById(img);
    const reader = new FileReader();
    reader.onload = function () {
        previewImage.src = reader.result;
    };
    reader.readAsDataURL(input.files[0]);
}

function changeFunctionBtnCrop(img) {
    cropImageBtn.onclick = null;
    cropImageBtn.onclick = function () {
        cropImage(img);
    };
}

function createAccordionElements(accordion, file, index, isFileList) {
    var accordionItem = document.createElement('div');
    accordionItem.className = 'accordion-item';

    var accordionHeader = document.createElement('h2');
    accordionHeader.className = 'accordion-header';
    accordionHeader.id = 'flush-heading-' + index;

    var accordionButton = document.createElement('button');
    accordionButton.className = 'accordion-button collapsed';
    accordionButton.type = 'button';
    accordionButton.setAttribute('data-bs-toggle', 'collapse');
    accordionButton.setAttribute('data-bs-target', '#flush-collapse-' + index);
    accordionButton.setAttribute('aria-expanded', 'false');
    accordionButton.setAttribute('aria-controls', 'flush-collapse-' + index);
    accordionButton.innerText = isFileList ? file.name : file.filename;

    var accordionCollapse = document.createElement('div');
    accordionCollapse.id = 'flush-collapse-' + index;
    accordionCollapse.className = 'accordion-collapse collapse';
    accordionCollapse.setAttribute('aria-labelledby', 'flush-heading-' + index);
    accordionCollapse.setAttribute('data-bs-parent', '#accordion_image');

    var accordionBody = document.createElement('div');
    accordionBody.className = 'accordion-body';

    var imageSrc = isFileList ? URL.createObjectURL(file) : file.filepath;
    accordionBody.innerHTML = `<img style="width: 100%; object-fit: cover;" src="${imageSrc}">`;

    accordion.appendChild(accordionItem);
    accordionItem.appendChild(accordionHeader);
    accordionHeader.appendChild(accordionButton);
    accordionItem.appendChild(accordionCollapse);
    accordionCollapse.appendChild(accordionBody);
}

function changeAccordionImage(input, div) {
    var files;
    var accordion = document.getElementById(div);
    accordion.innerHTML = '';

    if (input.length > 0) {
        if (input instanceof FileList) {
            files = input.files;
            Array.from(files).forEach((file, index) => createAccordionElements(accordion, file, index, true));
        } else if (Array.isArray(input)) {
            files = input;
            Array.from(files).forEach((file, index) => createAccordionElements(accordion, file, index, false));
        } else {
            console.error('Entrada inválida para changeAccordionImage');
            return;
        }
    }
}
