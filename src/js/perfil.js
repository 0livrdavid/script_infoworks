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

     data['sobre_mim'] = $('#sobre_mim').summernote('code');

     data['telefone'] = $('#telefone').val();
     data['whatsapp'] = $('#whatsapp').val();
     data['instagram'] = $('#instagram').val();
     data['facebook'] = $('#facebook').val();

     $.ajax({
          method: "POST",
          datatype: "json",
          url: "../../api/perfil/perfil.php",
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
          url: "../../api/perfil/perfil.php",
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
          url: '../../api/perfil/perfil.php',
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