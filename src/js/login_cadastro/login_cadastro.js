if (window.navigator.userAgent.indexOf("Trident/") > 0) {
    alert("Internet Explorer não é mais suportado.\n\n Por favor utilize outro navegador.");
    location.href = servidor + "../../not_support.php";
}

$(document).ready(function() {
    $("#div-cadastro").css("display", "none");
});

function switchLogin (page) {
    if (page == "" || page == "login") {
        $("#div-login").css("display", "block");
        $("#div-cadastro").css("display", "none");
        $("#div-esqueceu-senha").css("display", "none");
    } else if (page == "cadastro") {
        $("#div-login").css("display", "none");
        $("#div-cadastro").css("display", "flex");
        $("#div-esqueceu-senha").css("display", "none");
        $(".msg_login").html("");
    } else if (page == "esqueceu_senha") {
        $("#div-login").css("display", "none");
        $("#div-cadastro").css("display", "none");
        $("#div-esqueceu-senha").css("display", "block");
        $(".msg_login").html("");
    }
}

function login_switch() {
    if ($("#box-login-login").hasClass('hidde')) {
        $("#box-login-recupera").fadeOut(320);
        $("#box-login-login").removeClass('hidde');
        setTimeout(function () {
            $("#box-login-login").fadeIn(320);
        }, 325);
    } else {
        $("#box-login-login").addClass('hidde');
        $("#box-login-login").fadeOut(320);
        setTimeout(function () {
            $("#box-login-recupera").fadeIn(320);
        }, 325);
    }
}

function validateFormCadastro(event) {
    const form = event.target;
    const requiredFields = form.querySelectorAll('[required]');
    let passwordValue = null;
    let confirmPasswordValue = null;

    for (let i = 0; i < requiredFields.length; i++) {
        const field = requiredFields[i];
    
        if (field.id === 'password') {
            passwordValue = field.value;
        } else if (field.id === 'confirm_password') {
            confirmPasswordValue = field.value;
        }

        if (!field.value) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            },toastr["warning"](`Por favor, preecha o campo "${field.dataset.name}".`, "Atenção");
            field.focus();
            event.preventDefault();
            return false;
        }
        
        if (field.name == "data_nascimento") {
            if (!isValidDate(field.value, field.dataset.name)) {
                field.focus();
                return false;
            }
        }
        
        if (field.name == "cpf") {
            if (!isValidCPF(field.value, field.dataset.name)) {
                field.focus();
                return false;
            }
        }
    }

    function validateFormPassword(){
        if(passwordValue!==confirmPasswordValue) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            },toastr["warning"]("Senhas não coincidem!", "Atenção");
            event.preventDefault();
            return false;
        }
        return true;
    }

    if (!validateFormPassword()) {
        return false;
    }

    return true;
}