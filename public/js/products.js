window.addEventListener('load', function () {



  /* Empieza */
  let selectOrder = document.getElementById('selectOrder');
  selectOrder.addEventListener('change', function(e){
    window.location.href = window.location.pathname+'?orderBy='+e.target.value;
  })
  /* Termina */
  var perros = document.querySelector('#perros');
    perros.addEventListener("hover", function() {
  })

  $("#heart--liked").click(function(e) {
  $(this).toggleClass("far").toggleClass("fas"); // Toggle the filling !
  });

});
