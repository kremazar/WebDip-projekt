function provjera_korisnickog() {
  jQuery.ajax({
    url: "registracija.php",
    data: "kime=" + $("#kime").val(),
    type: "POST",
    success: function(data) {
      $("#provjera").html(data);
    },
    error: function() {}
  });
}
