$(function() {
  // Nos conectamos al server, esto emite un
  // mensaje de "connection"
  var socket = io.connect("http://localhost:8080");

  // Cuando la conección es exitosa le preguntamos al user
  // su nick mediante un prompt y lo emitimos al servidor
  socket.on("connect", function() {
      socket.emit("nick", prompt("Nick?"));
  });

  $('#msg-input input').keypress(function(e) {
      if (e.which == 13) {
          // Cuando se presiona enter en el input
          // emitimos el contenido de dicho input
          socket.emit("msg", $(this).val());
          $(this).val('');
      }
  });

  // Cuando el cliente recibe un mensaje, creamos un div
  // Ponemos el nick y el mensaje dentro y lo agregamos
  // a la lista de mensajes
  socket.on("msg", function(nick, msg) {
      $(document.createElement("div"))
      .html("<strong>" + nick + ": </strong>" + msg)
      .appendTo("#messages");

      // Esto nos permite mantener visible el último mensaje
      $('#messages-container').scrollTop($('#messages').height());
  });

  // Cuando el cliente recibe una lista de nicks
  socket.on("nicks", function(nicks) {
      $("#users").html('');
      for (var i = 0; i < nicks.length; i++) {
          $(document.createElement("li")).text(nicks[i]).appendTo("#users");
      }
  });

});