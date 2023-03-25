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
