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