if (window.navigator.userAgent.indexOf("Trident/") > 0) {
    alert("Internet Explorer não é mais suportado.\n\n Por favor utilize outro navegador.");
    location.href = servidor + "../../not_support.php";
}

$(document).ready(function() {
    $("#div-cadastro").css("display", "none");
});

function switchLogin (page) {
    if (page == "" || page == "login") {
        $("#div-login").css("display", "flex");
        $("#div-cadastro").css("display", "none");
        $("#div-esqueceu-senha").css("display", "none");

        $(".msg_cadastro").html("");
        $(".msg_esqueceu_senha").html("");
    } else if (page == "cadastro") {
        $("#div-login").css("display", "none");
        $("#div-cadastro").css("display", "flex");
        $("#div-esqueceu-senha").css("display", "none");

        $(".msg_login").html("");
        $(".msg_esqueceu_senha").html("");
    } else if (page == "esqueceu_senha") {
        $("#div-login").css("display", "none");
        $("#div-cadastro").css("display", "none");
        $("#div-esqueceu-senha").css("display", "flex");

        $(".msg_login").html("");
        $(".msg_cadastro").html("");
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

function createUser(div_form) {
    const form = div_form;
    fields = {};
    fields['acao'] = "Cadastro";

    function validateFormCadastro(form) {
        const requiredFields = form.querySelectorAll('[required]');


        console.log(requiredFields);
        let passwordValue = null;
        let confirmPasswordValue = null;

        for (let i = 0; i < requiredFields.length; i++) {
            const field = requiredFields[i];
            if (field.id === 'password') passwordValue = field.value;
            if (field.id === 'confirm_password') confirmPasswordValue = field.value;

            fields[field.name] = field.value;

            if (!field.value) {
                toastr.warning(`Por favor, preecha o campo "${field.dataset.name}".`, "Atenção");
                field.focus();
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
                toastr.warning("Senhas não coincidem!");
                return false;
            }
            return true;
        }

        if (!validateFormPassword()) {
            return false;
        }

        return true;
    }


    if (!validateFormCadastro(form)) {
        toastr.error("Suas informações de cadastro não estão corretas e/ou está faltando informação!");
        event.preventDefault();
        return null;
    } else {
        console.log("cheguei aq");
        console.log(fields);
        $.ajax({
            method: "POST",
            datatype: "json",
            url: "../../ajax/login_cadastro/cadastro.php",
            data: fields,
            success: function (response) {
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    }
}

