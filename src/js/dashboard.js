$(document).ready(function () {
  $("#filter_todos").addClass("active");
});

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

function filterProduct(value) {
  //Button class code
  let buttons = document.querySelectorAll(".button-value");
  buttons.forEach((button) => {
    //check if value equals innerText
    if (value.toUpperCase() == button.innerText.toUpperCase()) {
      button.classList.add("active");
    } else {
      button.classList.remove("active");
    }
  });
}