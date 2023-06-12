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

function editarServico() {
     var data = new FormData();
     data.append('acao', 'EditarServico');
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

function deletarServico(id) {
     Swal.fire({
          title: 'Deseja mesmo deletar o serviço?',
          showCancelButton: true,
          confirmButtonText: "Sim",
     }).then((result) => {
          if (result.isConfirmed) {
               $.ajax({
                    method: "POST",
                    datatype: "json",
                    url: "../../api/servicos/servicos.php",
                    data: {
                         'acao': 'DeletarServico',
                         'id': id,
                    },
                    success: function (response) {
                         response = JSON.parse(response);
                         if (response.flag) {
                              toastr['success'](response.msg);
                         } else {
                              toastr['warning'](response.msg);
                         }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                         toastr['error'](textStatus, errorThrown);
                    }
               });
          }
     });
}

function adicionarComentarioServico(id, usuario) {
     Swal.fire({
          title: 'Avalie nosso serviço',
          html: `
            <div>
              <input type="radio" id="star1" name="rating" value="1">
              <label for="star1"><i class="bi bi-star-fill rating-color me-2"></i>1 estrela</label>
            </div>
            <div>
              <input type="radio" id="star2" name="rating" value="2">
              <label for="star2"><i class="bi bi-star-fill rating-color me-2"></i>2 estrelas</label>
            </div>
            <div>
              <input type="radio" id="star3" name="rating" value="3">
              <label for="star3"><i class="bi bi-star-fill rating-color me-2"></i>3 estrelas</label>
            </div>
            <div>
              <input type="radio" id="star4" name="rating" value="4">
              <label for="star4"><i class="bi bi-star-fill rating-color me-2"></i>4 estrelas</label>
            </div>
            <div>
              <input type="radio" id="star5" name="rating" value="5">
              <label for="star5"><i class="bi bi-star-fill rating-color me-2"></i>5 estrelas</label>
            </div>
          `,
          showCancelButton: true,
          confirmButtonText: 'Confirmar',
          cancelButtonText: 'Cancelar',
          preConfirm: () => {
               const rating = document.querySelector('input[name="rating"]:checked');
               if (rating) {
                    return rating.value;
               } else {
                    Swal.showValidationMessage('Selecione uma avaliação!');
               }
          }
     }).then((result) => {
          if (result.isConfirmed) {
               const ratingValue = result.value;
               $.ajax({
                    method: "POST",
                    datatype: "json",
                    url: "../../api/servicos/servicos.php",
                    data: {
                         'acao': 'AdicionaComentarioServico',
                         'id': id,
                         'usuario': usuario,
                    },
                    success: function (response) {
                         response = JSON.parse(response);
                         if (response.flag) {
                              Swal.fire('Avaliação enviada!', `O comentário e a avaliação de ${ratingValue} estrela(s) foram armazenadas.`, 'success');
                              toastr['success'](response.msg);
                         } else {
                              toastr['warning'](response.msg);
                         }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                         toastr['error'](textStatus, errorThrown);
                    }
               });
               
          }
     });
}