$(document).ready(function() {
    $("#div-cadastro").css("display", "none");
});

function switchLogin () {
    if ($("#div-cadastro").css("display") == "none") {
        $("#div-login").css("display", "none");
        $("#div-cadastro").css("display", "block");
    } else if ($("#div-cadastro").css("display") == "block") {
        $("#div-login").css("display", "block");
        $("#div-cadastro").css("display", "none");
    }
}