function criarServico() {
     var data = new FormData();
     data.append('acao', 'CriarServico');
     data.append('servico_cpf', $('#servico_cpf').val());
 
     data.append('servico_categoria', $('#servico_categoria').val());
     data.append('servico_preco', $('#servico_preco').val());
     data.append('servico_tipo', $('#servico_tipo').val());
     data.append('servico_descricao', $('#servico_descricao').summernote('code'));
 
     var files = $('#servico_imagens')[0].files;
     for (var i = 0; i < files.length; i++) {
         data.append('imagens[]', files[i]);
     }
 
     $.ajax({
         url: "../../api/servicos/servicos.php",
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
         url: "../../api/servicos/servicos.php",
         data: {
             'acao': 'GetServico',
             'id': id,
         },
         success: function (response) {
             response = JSON.parse(response);
             if (response.flag) {
                 service = response.service
                 $('#servico_categoria').find('option:contains("' + service.fk_idCategory + '")').prop('selected', true);
                 $('#servico_preco').val(service.valor);
                 $('#servico_tipo').find('option:contains("' + service.fk_idType + '")').prop('selected', true);
                 $('#servico_descricao').html(service.descricao);
                 $('#servico_descricao').summernote('code', service.descricao);
                 changeAccordionImage(response.imagens, 'service_accordion_image');
             } else {
                 toastr['warning'](response.msg);
             }
         },
         error: function (jqXHR, textStatus, errorThrown) {
             toastr['error'](textStatus, errorThrown);
         }
     });
 }