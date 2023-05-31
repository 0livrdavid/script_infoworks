document.getElementById('button-discovery-cep').onclick = function () {
    var script = document.createElement('script');
    if ($('#cep').val() != '') {
        script.src = 'https://viacep.com.br/ws/' + $('#cep').val() + '/json/?callback=atualizarCEP';
        document.body.appendChild(script);
    } else {
        script.remove();
        toastr['warning']("Informe um CEP para utilizar a busca!");
    }
};

$('#img_input_perfil').click(function () {
    $('#img_input_perfil2').trigger('click');
});



function atualizarCEP(data) {
    $('#estado').val(data.uf);
    $('#cidade').find('option:contains("' + data.localidade + '")').prop('selected', true);
    $('#bairro').val(data.bairro);
    $('#rua').val(data.logradouro);
    $('#numero').val('');
}

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
        error: function (jqXHR, textStatus, errorThrown) {
            toastr['error'](textStatus, errorThrown);
        }
    });
}

function deslogarUsuario() {
    $.ajax({
        method: "POST",
        datatype: "json",
        url: "../../ajax/perfil/perfil.php",
        data: {
            'acao': 'DeslogarUsuario'
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.flag) {
                window.location.href = "../dashboard/";
            } else {
                toastr['warning'](response.msg);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr['error'](textStatus, errorThrown);
        }
    });
}

function salvarImagemPerfil() {
    var data = new FormData();
    data.append('acao', 'SalvarImagemPerfil');
    data.append('cpf', $('#perfil_cpf').val());
    data.append('imagem_base', $('#img_input_perfil2')[0].files[0]);
    data.append('imagem', $('#img_input_perfil3')[0].files[0]);

    $.ajax({
        url: '../../ajax/perfil/perfil.php',
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            response = JSON.parse(response);
            if (response.flag) {
                alert(response.msg);
                window.location.reload();
            } else {
                toastr['warning'](response.msg);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr['error'](textStatus, errorThrown);
        }
    });
}

function criarServico() {
    var data = new FormData();
    data.append('acao', 'CriarServico');
    data.append('servico_cpf', $('#servico_cpf').val());

    data.append('servico_categoria', $('#servico_categoria').val());
    data.append('servico_preco', $('#servico_preco').val());
    data.append('servico_tipo', $('#servico_tipo').val());
    data.append('servico_descricao', $('#servico_descricao').val());

    var files = $('#servico_imagens')[0].files;
    for (var i = 0; i < files.length; i++) {
        data.append('imagens[]', files[i]);
    }

    $.ajax({
        url: "../../ajax/perfil/perfil.php",
        type: "POST",
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            response = JSON.parse(response);
            if (response.flag) {
                alert(response.msg);
                window.location.reload();
            } else {
                toastr['warning'](response.msg);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr['error'](textStatus, errorThrown);
        }
    });
}

function getServico(id) {
    $.ajax({
        method: "POST",
        datatype: "json",
        url: "../../ajax/perfil/perfil.php",
        data: {
            'acao': 'GetServico',
            'id': id,
        },
        success: function (response) {
            response = JSON.parse(response);
            console.log(response.service)
            if (response.flag) {
                service = response.service
                $('#servico_categoria').find('option:contains("' + service.fk_idCategory + '")').prop('selected', true);
                $('#servico_preco').val(service.valor);
                $('#servico_tipo').find('option:contains("' + service.fk_idType + '")').prop('selected', true);
                $('#servico_descricao').val(service.descricao);
            } else {
                toastr['warning'](response.msg);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            toastr['error'](textStatus, errorThrown);
        }
    });
}