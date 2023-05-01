if (window.navigator.userAgent.indexOf("Trident/") > 0) {
  alert("Internet Explorer não é mais suportado.\n\n Por favor utilize outro navegador.");
  location.href = servidor + "../../not_support.php";
}

$(document).ready(function() {
    $("#filter_todos").addClass("active");
});

function switchLoginDashboard(user) {
  if (user != 'null') {
      $(".header-menu-logged").css("display", "flex");
      $(".header-menu-logout").css("display", "none");
  } else {
      $(".header-menu-logged").css("display", "none");
      $(".header-menu-logout").css("display", "flex");
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