var cropper;
var cropImageBtn = document.getElementById("cropImageBtn");

function initializeCropper(img) {
    cropper = new Cropper(img, {
        aspectRatio: 0,
        viewMode: 0,
    });
}

function turnAspectRatio(value) {
    switch (value) {
        case "0":
            cropper.setAspectRatio(0);
            break;
        case "1 / 1":
            cropper.setAspectRatio(1 / 1);
            break;
        case "4 / 3":
            cropper.setAspectRatio(4 / 3);
            break;
        case "16 / 9":
            cropper.setAspectRatio(16 / 9);
            break;
    }
}

function cropImage(img) {
    document.getElementById(img).src = cropper.getCroppedCanvas().toDataURL('image/png');
}

function changeFunctionBtnCrop(img) {
    cropImageBtn.onclick = null;
    cropImageBtn.onclick = function() {
        cropImage(img);
    };
}