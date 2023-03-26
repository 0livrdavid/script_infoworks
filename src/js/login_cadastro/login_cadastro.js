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


$('input[type="password"]').keyup(function() {
    senhaValida(this.value, this);
});

function senhaValida(s, input = false){
    var retorno = false,
        points = 0;
    $(".senha_msg_error").html("");

    const verify = {
        "auxMaiuscula": false,
        "auxMinuscula": false,
        "auxNumero": false,
        "auxEspecial": false,
        "auxEspecial2": true,
        "auxTamanho": false
    };

    const color = {
        "forte": '#009A44',
        "ok": '#EAAA00',
        "medio": '#F68D2E',
        "fraco": '#BC204B'
    }

    // define letras maiusculas e minisculas, numeros e caracteres especiais
    const letrasMaiusculas = /[A-Z]/,
        letrasMinusculas = /[a-z]/,
        numeros = /[0-9]/,
        caracteresEspeciais = /[!@#$%^&*]/,
        caracteresEspeciais2 = /^(?=.*[!@#$%^&*])$/;

    var auxMaiuscula = 0,
        auxMinuscula = 0,
        auxNumero = 0,
        auxEspecial = 0;

    // quantifica letras maiusculas e minisculas, numeros e caracteres especiais
    for(let i=0; i<s.length; i++){
        if(letrasMaiusculas.test(s[i]))
            auxMaiuscula++;
        else if(letrasMinusculas.test(s[i]))
            auxMinuscula++;
        else if(numeros.test(s[i]))
            auxNumero++;
        else if(caracteresEspeciais.test(s[i]))
            auxEspecial++;
        else if (!(caracteresEspeciais2.test(s[i])) && verify.auxEspecial2 == true) {
            let msg;
            if (/\s/.test(s[i])) {
                msg = 'Caracter invalido detectado: "ESPAÇO"<br>';
            } else if (/'|"/.test(s[i])) {
                msg = 'Caracter invalido detectado: "ASPAS"<br>';
            } else {
                msg = 'Caracter invalido detectado: "' + s[i] +'"<br>';
            }
            $(".senha_msg_error").append(msg);
            verify.auxEspecial2 = false;
        }
    }


    // verifica a quantidade de letras maiusculas e minisculas, numeros e caracteres especiais
    if (auxMaiuscula > 0){
        $('.senha_letra_maiuscula').css("color","green");
        points++;
        verify.auxMaiuscula = true;
    } else {
        $('.senha_letra_maiuscula').css("color","red")
    }

    if (auxMinuscula > 0){
        $('.senha_letra_minuscula').css("color","green");
        points++;
        verify.auxMinuscula = true;
    } else {
        $('.senha_letra_minuscula').css("color","red")
    }

    if (auxNumero > 0){
        $('.senha_número').css("color","green");
        points++;
        verify.auxNumero = true;
    } else {
        $('.senha_número').css("color","red");
    }

    if (auxEspecial > 0) {
        $('.senha_caracteres_especiais').css("color","green");
        points++;
        verify.auxEspecial = true;
    } else {
        $('.senha_caracteres_especiais').css("color","red");
    }

    if(s.length >= 8){
        $('.senha_quantidade_caracteres').css("color","green");
        points++;
        verify.auxTamanho = true;

    } else {
        $('.senha_quantidade_caracteres').css("color","red");
    }

    if (verify.auxMaiuscula) {
        if (verify.auxMinuscula) {
            if (verify.auxNumero) {
                if (verify.auxEspecial && verify.auxEspecial2) {
                    if (verify.auxTamanho) {
                        retorno = true;
                    }
                }
            }
        }
    }

    if(points == 5){
        $(input).attr('style','border-color: '+color.forte+' !important');
    } else if(points >= 4){
        $(input).attr('style','border-color: '+color.ok+' !important');
    } else if(points >= 3){
        $(input).attr('style','border-color: '+color.medio+' !important');
    } else if(points <= 2){
        $(input).attr('style','border-color: '+color.fraco+' !important');
    } else{
        $(input).attr('style','border-color: '+color.fraco+' !important');
    }

    return retorno;
}