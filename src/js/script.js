if (window.navigator.userAgent.indexOf("Trident/") > 0) {
    alert("Internet Explorer não é mais suportado.\n\n Por favor utilize outro navegador.");
    location.href = servidor + "../../not_support.php";
}

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
}

function switchLoginDashboard(user) {
    if (user == 'logged') {
        $(".header-menu-logged").css("display", "flex");
        $(".header-menu-logout").css("display", "none");
    } else if (user == "logout") {
        $(".header-menu-logged").css("display", "none");
        $(".header-menu-logout").css("display", "flex");
    }
}

function formatarCPF(cpf) {
    // Remove todos os caracteres que não são números
    cpf.value = cpf.value.replace(/\D/g, '');

    // Formata o CPF com a máscara XXX.XXX.XXX-XX
    cpf.value = cpf.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

    return cpf.value;
}

function formatarCPF2(cpf) {
    // Remove todos os caracteres que não são números
    cpf = cpf.replace(/\D/g, '');

    // Formata o CPF com a máscara XXX.XXX.XXX-XX
    cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

    return cpf;
}



function formatarCEP(input) {
    // Remove todos os caracteres que não são números
    input.value = input.value.replace(/\D/g, '');

    // Formata o CEP com a máscara XXX.XXX.XXX-XX
    input.value = input.value.replace(/(\d{5})(\d{3})/, '$1-$2');
}

function formatarCEL(input) {
    // Remove todos os caracteres que não são números
    input.value = input.value.replace(/\D/g, '');

    // Formata o Telefone com a máscara (XX)XXXXX-XXXX
    input.value = input.value.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
}

function formatarData(input) {
    // Remove todos os caracteres que não são números
    input.value = input.value.replace(/\D/g, '');

    // Formata o Telefone com a máscara XX/XX/XXXX
    input.value = input.value.replace(/(\d{2})(\d{2})(\d{4})/, '$1/$2/$3');
}

function isValidDate(data, msg = "Data Nascimento") {
    if (!/^\d{2}\/\d{2}\/\d{4}$/.test(data)) {
        toastr["warning"](`O campo "${msg}" não fornece uma entrada de data valida.`, "Atenção");
        return false;
    }

    const [dia, mes, ano] = data.split('/');
    const date = new Date(`${ano}-${mes}-${dia}`);

    if (isNaN(date.getTime())) {
        toastr["warning"](`O campo "${msg}" não fornece uma entrada de data valida.`, "Atenção");
        return false;
    }

    const now = new Date();
    if (date.getTime() > now.getTime()) {
        toastr["warning"](`A data fornecida no campo "${msg}" não pode ser superior a data de hoje "${now}".`, "Atenção");
        return false;
    }

    const minDate = new Date();
    minDate.setFullYear(minDate.getFullYear() - 150);
    if (date.getTime() < minDate.getTime()) {
        toastr["warning"](`A data fornecida no campo "${msg}" não pode ser que "${minDate}".`, "Atenção");
        return false;
    }

    return true;
}


function isValidCPF(cpf, msg) {
    cpf = cpf.replace(/[^\d]+/g, ''); // remove caracteres não numéricos
    if (cpf.length !== 11) {
        toastr['warning'](`O campo "${msg}" deve ter 11 dígitos.`, "Atenção");
        return false; // o CPF deve ter 11 dígitos
    }
    // Calcula o primeiro dígito verificador
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let resto = 11 - (soma % 11);
    let digitoVerificador1 = (resto === 10 || resto === 11) ? 0 : resto;

    // Calcula o segundo dígito verificador
    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = 11 - (soma % 11);
    let digitoVerificador2 = (resto === 10 || resto === 11) ? 0 : resto;

    // Retorna true se os dígitos verificadores estão corretos, false caso contrário
    if ((digitoVerificador1 === parseInt(cpf.charAt(9)) && digitoVerificador2 === parseInt(cpf.charAt(10)))) {
        return true;
    } else {
        toastr["warning"](`O campo "${msg}" não fornece dados validos`, "Atenção");
        return false;
    }
}

function abrirModal(class_name) {
    var modal = document.getElementById(class_name); // obtém a modal
    var span = document.querySelector(".close"); // obtém o botão de fechar

    modal.style.display = "flex"; // exibe a modal quando o botão é clicado

    span.onclick = function () {
        modal.style.display = "none"; // esconde a modal quando o botão de fechar é clicado
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none"; // esconde a modal quando o usuário clica fora dela
        }
    }
}

