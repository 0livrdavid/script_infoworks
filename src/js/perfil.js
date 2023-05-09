function salvarPerfil() {
    data = {};
    data['acao'] = 'SalvarPerfil';
    data['cpf'] = $('#cpf').val();

    data['cep'] = $('#cep').val();
    data['cidade'] = $('#cidade').val();
    data['estado'] = $('#estado').val();
    data['rua'] = $('#rua').val();
    data['numero'] = $('#numero').val();
    data['bairro'] = $('#bairro').val();

    data['sobre_mim'] = $('#sobre_mim').val();
    data['formacao'] = $('#formacao').val();

    data['telefone'] = $('#telefone').val();
    data['whatsapp'] = $('#whatsapp').val();
    data['instagram'] = $('#instagram').val();
    data['facebook'] = $('#facebook').val();

    $.ajax({
        method: "POST",
        datatype: "json",
        url: "../../ajax/perfil/perfil.php",
        data: data,
        success: function (response) {
            response = JSON.parse(response);
            if (response.flag) {
                toastr["success"](response.msg);
            } else {
                toastr['warning'](response.msg);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr['error'](textStatus, errorThrown);
        }
    });
}

function deslogarUsuario() {
    $.ajax({
        method: "POST",
        datatype: "json",
        url: "../../ajax/perfil/perfil.php",
        data: {'acao': 'DeslogarUsuario'},
        success: function (response) {
            response = JSON.parse(response);
            if (response.flag) {
                window.location.href = "../dashboard/index.php";
            } else {
                toastr['warning'](response.msg);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr['error'](textStatus, errorThrown);
        }
    });
}

function criarServico() {
    data = {};
    data['acao'] = 'CriarServico';
    data['servico_idusuario'] = $('servico_idusuario').val();

    data['servico_categoria'] = $('servico_categoria').val();
    data['servico_preco'] = $('servico_preco').val();
    data['servico_tipo'] = $('servico_tipo').val();

    $.ajax({
        method: "POST",
        datatype: "json",
        url: "../../ajax/perfil/perfil.php",
        data: data,
        success: function (response) {
            response = JSON.parse(response);
            if (response.flag) {
                toastr["success"](response.msg);
            } else {
                toastr['warning'](response.msg);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr['error'](textStatus, errorThrown);
        }
    });
}