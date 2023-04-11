function formatarCPF(input) {
    // Remove todos os caracteres que não são números
    input.value = input.value.replace(/\D/g, '');

    // Formata o CPF com a máscara XXX.XXX.XXX-XX
    input.value = input.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
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

function abrirModal(class_name) {
    var modal = document.getElementById(class_name); // obtém a modal
    var span = document.querySelector(".close"); // obtém o botão de fechar

    modal.style.display = "flex"; // exibe a modal quando o botão é clicado

    span.onclick = function() {
        modal.style.display = "none"; // esconde a modal quando o botão de fechar é clicado
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none"; // esconde a modal quando o usuário clica fora dela
        }
    }
}