// Efectos visuales
  $("#info_cliente input[type='button']").click(function(){
  status_web("Actualizando tus datos ...");
  $(this).parent().fadeOut(function(){
    console.log("Termino.");
    $("#msg_pop_compra").html("");
    $("#info_compra").fadeIn();
  });
  //Guardando/Actualizando datos del cliente
  $(".popup-detalle-contacto form input[name='origen']").val("save_info_cliente");
  datos=$(".popup-detalle-contacto form#enviar_compra").serialize();
  $.ajax({
    url:"/ajax-productos",
    data:datos,
    type:"POST",
    success:function(res){
      $(".popup-detalle-contacto form input[name='origen']").val("enviar_compra");
      status_web("Si tienes un <b>cupon de descuento</b> pegalo en el cuadro amarillo de abajo y da clic en aplicar ^^");
    }
  });
// Fin efectos visuales

  });
// General
  effects=Array("tada", "bounce", "wobble", "bounceIn", "flip");
  window.setInterval(function(){
    animation=effects[Math.floor(Math.random() * effects.length)];//aleatorio
    element = $(".btn-comprar");
    element.addClass('animated ' + animation);
    //wait for animation to finish before removing classes
    window.setTimeout( function(){
        element.removeClass('animated ' + animation);
    }, 2000);
  }, 4000);

  $(document).ready(function() {
    ajustarPopupDetalleContacto(520);
  	$(".items-fotos").owlCarousel({
        autoPlay: 3000,
        items : 1,
        itemsDesktop : [1199,1],
        itemsDesktopSmall : [979,1]
  	});

    precio=$(".field-name-field-precio .field-item").html();
    precio=numberWithCommas(precio);
    $(".field-name-field-precio .field-item").html(precio);
    $("#enviar_compra .precio").html(precio);
	});
// Fin general

// Compras
  var clienteID;
  var bonoCODIGO;
  var bonoID;
  var bonoVAL;
  var precioTotal=<?php echo $node->field_precio["und"][0]["value"]?>;
  var productoID=<?php echo $node->nid?>;
  var tiendaID=<?php echo $node->field_vendedor['und'][0]['nid']?>;

  function validarEmail(email) {
    if (email=="") {
      alert("Escribe tu correo electronico.");
      return false;
    }
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
      alert("Correo electronico no valido.")
      return false;
    } else{
      return true;
    }
  }

  function recordar_contrasena(){
    email=$("#inp_correo").val();
    res=validarEmail(email);
    if (res==false) {
      return false;
    }
    
    $.ajax({
      dataType: "html",
      url:"/ajax-productos",
      data:{
        "correo": $("#inp_correo").val(),
        "origen": "recordar_pass"
      },
      type:"POST",
      success:function(res){
        alert(res);
      }
    });
  }

  function aplicar_bono(){
    status_web("Cargando ...");
    datos="bono="+$("#bono").val()+"&origen=aplicar_bono&cedula="+$("#inp_cedula").val()+"&inp_tienda="+$("#inp_tienda").val()+"&productoID="+productoID;
    $.ajax({
      url:"/ajax-productos",
      data:datos,
      type:"POST",
      success:function(res){
        console.log(res);
        res=JSON.parse(res);
        console.log(res);
        if (res.id!=0) {
          bonoID=res.id;
          bonoVAL=res.valor;
          bonoCODIGO=res.codigo;
          status_web("Se aplico un descuento a tu compra.");
          precio=$("#enviar_compra .precio").html();
          precio=precio.replace(".", "");
          if (precio>bonoVAL) {
            precio=precio-bonoVAL;
          } else{
            precio=0;
          }
          precioTotal=precio;
          precio=numberWithCommas(precio);
          $("#enviar_compra .precio").html(precio);
          $("#bono").attr("disabled", "disabled");
          $("#bono").css("background", "#efefef");
          $(".aplicar_bono").fadeOut();
          get_valor_bono(bonoCODIGO);
          $("tr.bono").fadeIn();
        } else{
          status_web("No se ha podido conjear tu bono.");
        }
      }
    });
  }

  function get_valor_bono(codigo_bono){
    datos="origen=get_valor_bono&codigo_bono="+codigo_bono;
    $.ajax({
      url:"/ajax-productos",
      data:datos,
      type:"POST",
      success:function(res){
        
        $("tr.bono .val").html("- $"+numberWithCommas(res));
      }
    });
  }

  function btn_registrate(){
    $("#crear_cliente").fadeIn();
    $("#login_cliente").hide();
  }

  function status_web(e){
    $("#status_web").html(e)
    .addClass('animated tada');
    window.setTimeout( function(){
    $("#status_web").removeClass('animated tada');
    }, 1000);
  }

  function crear_cliente(){
    status_web("Enviando correo ...")
    datos=$("#crear_cliente").serialize();
    $.ajax({
      url:"/ajax-productos",
      data:datos,
      type:"POST",
      success:function(res){
        status_web("Se ha creado tu cuenta ^^");
        $("#crear_cliente").hide();
        $("#login_cliente").fadeIn();
      }
    });
  }

  function check_correo(msg){
    email=$("#inp_correo").val();
    res=validarEmail(email);
    if (res==false) {
      alert("Correo electronico no valido.")
      return false;
    }

    $("#btn_recordarpass").show();
    //$(".popup-detalle-contacto form input[name='origen']").val("check_cliente");
    //status_web("Ingresa tu contraseña");
    status_web("Cargando...");
    datos=$(".popup-detalle-contacto form").serialize();
    $.ajax({
      url:"/ajax-productos",
      data:datos,
      type:"POST",
      success:function(res){
        if (res==1) {
          if (msg=="" || msg==null) {
            status_web("Ahora ingresa tu pin ^^");
          } else{
            status_web(msg);
          }
          $(".popup-detalle-contacto input[name='correo']").addClass('animated fadeOutLeftBig').parent().hide();
          $(".popup-detalle-contacto input[type='password']").show().addClass('animated fadeInLeftBig');
          // $(".popup-detalle-contacto input[type='password']").fadeIn();
          $("#login_cliente input[type='button']").attr("onclick", "check_cliente()");
        } else{
          status_web("Se ha enviado tu pin a tu correo electronico ^^");
          check_correo("Se ha enviado tu pin a tu correo electronico ^^");
        }
      }
    });
  }

  function check_cliente(){
    if ($(".popup-detalle-contacto #login_cliente input").val()=="") {
      status_web("Ingresa tus datos ^^");
      return false;
    }

    status_web("Comprobando PIN ...");
    // Origen: 
    $(".popup-detalle-contacto form input[name='origen']").val("check_cliente");
    datos=$(".popup-detalle-contacto form").serialize();
    $.ajax({
      url:"/ajax-productos",
      data:datos,
      type:"POST",
      success:function(res){
        
        $("#msg_pop_compra").html("Verifica que tu información sea correcta");
        $(".popup-detalle-contacto form input[name='origen']").val(res);
        if (res=="check_cliente") {
          status_web("Bah ... Intentalo nuevamente ^^");
        } else{
          status_web("^^ Correcto.");
          info_cliente();
        }
      }
    });
  }
  
  function enviar_compra(){
    status_web("Guardando tu compra ...");
    datos=$(".popup-detalle-contacto form#enviar_compra").serialize();
    datos=datos+"&bonoVAL="+bonoVAL+"&bonoCODIGO="+bonoCODIGO;
    $.ajax({
      url:"/ajax-productos",
      data:datos,
      type:"POST",
      success:function(res){
        console.log(res);
        status_web("Compra finalizada ^^");
        $("#enviar_compra input[name='origen']").val("check_cliente");
        $("#info_compra").fadeOut();
        html="\
        <p><b>Detalle de la compra:</b></p>\
        <p><strong>Producto</strong> <?php echo $title ?></p>\
        <p><strong>Tipo de entrega</strong> Personal</p><strong>Valor total</strong> $"+numberWithCommas(precioTotal)+"\
        <p>* Recordar presentar documento de identidad a la hora de realizar la compra.</p>\
        <p>* El valor del domicilio no esta incluido en la compra.</p>";
        $(".popup-detalle-contacto .nota-2").html(html);
        $(".popup-detalle-contacto .nota-2").addClass('animated tada').show();
        //info_cliente();
      }
    });
  }

  function info_cliente(){
    // Origen: get_informacion_cliente
    status_web("Cargando tu información ...");
    datos=$(".popup-detalle-contacto form").serialize();
    console.log(datos);
    $.ajax({
      url:"/ajax-productos",
      data:datos,
      type:"POST",
      cache: false,
      dataType: "json",
      success:function(res){
        console.log(res);
        ajustarPopupDetalleContacto(500);
        clienteID=res.id;
        $(".popup-detalle-contacto form input[name='nombre']").val(res.nombre);
        $(".popup-detalle-contacto form input[name='apellidos']").val(res.apellidos);
        $(".popup-detalle-contacto form input[name='telefono']").val(res.telefono);
        $(".popup-detalle-contacto form input[name='celular']").val(res.celular);
        $(".popup-detalle-contacto form input[name='cedula']").val(res.cedula);
        $(".popup-detalle-contacto form input[name='direccion']").val(res.direccion);
        $(".popup-detalle-contacto form input[name='puntos']").val(res.puntos);
        $(".popup-detalle-contacto form input[name='origen']").val("enviar_compra");
        console.log(res);
        $("#login_cliente").fadeOut();
        $("#info_cliente").fadeIn();
        status_web("Bienvenido(a) "+res.nombre+" ^^");
      }
    });
  }

  function ajustarPopupDetalleContacto(height, width){
    $(".popup-detalle-contacto").css("height", height+"px");
    height=height-23;
    $(".popup-detalle-contacto .fondo_blanco").css("height", height+"px");
    if (width!="") {
      $(".popup-detalle-contacto").css("width", width+"px");
      width=width-23;
      $(".popup-detalle-contacto .fondo_blanco").css("width", width+"px");
    }
  }
// Fin compras