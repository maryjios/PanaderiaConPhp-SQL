$(document).ready(iniciar);

function iniciar() {
  $('#agregar_cliente').hide();
  $('.btn_new_cliente').hide();
  $('#registrar_cliente').hide();


  $(".btn_new_cliente").on('click', crear_cliente);
  $("#id_cliente").keyup(buscar_cliente);
  $("#form_registrar_cliente").submit(nuevo_cliente);

  $("#cod_producto").keyup(buscar_producto);
  $("#txt_cant_producto").keyup(cant_cambiada);


  // boton agregar item a factura
  $("#agregar_a_factura").on('click', agregar_fila);


  // cargar factura de usuario logeado
  // cargar_items_factura();

}

function crear_cliente(e) {

  e.preventDefault();

  $('#nom_cliente').removeAttr('disabled');
  $('#tel_cliente').removeAttr('disabled');
  $('#dir_cliente').removeAttr('disabled');
  $('#email_cliente').removeAttr('disabled');


  $('#div_registro_cliente').slideDown();


}


function buscar_cliente() {


  var el_cliente = $(this).val();
  var action = 'BuscarCliente';

  $.ajax({

    url: 'factura.php',
    type: "POST",
    async: true,
    data: {
      action: action,
      cliente: el_cliente
    },

    success: function (resultado) {


      if (resultado == 0) {
        $('#nom_cliente').val('');
        $('#tel_cliente').val('');
        $('#dir_cliente').val('');
        $('#email_cliente').val('');


        // // Ocultarndo boton agregar cliente
        $('.btn_new_cliente').slideDown();
        $('#agregar_cliente').show();

      } else {

        var data = $.parseJSON(resultado);
        $('#id_cliente').val(data.id);
        $('#nom_cliente').val(data.nombre);
        $('#tel_cliente').val(data.telefono);
        $('#dir_cliente').val(data.direccion);
        $('#email_cliente').val(data.correo);


        $('.btn_new_cliente').slideUp();
        $('#agregar_cliente').hide();


        $('#nom_cliente').attr('disabled', 'disabled');
        $('#tel_cliente').attr('disabled', 'disabled');
        $('#dir_cliente').attr('disabled', 'disabled');
        $('#email_cliente').attr('disabled', 'disabled');

      }

    },

    error: function (error) {

    }

  });


}


function buscar_producto(e) {

  e.preventDefault();


  var el_producto = $(this).val();

  var action = 'DatosProducto';

  $.ajax({

    url: 'factura.php',
    type: "POST",
    async: true,
    data: {
      action: action,
      producto: el_producto
    },

    success: function (resultado) {


      if (resultado != 0) {

        var info = $.parseJSON(resultado);
        $('#txt_descripcion').html(info.nombre);
        $('#txt_existencia').html(info.cantidad);
        $('#txt_cant_producto').val('1');
        $('#txt_precio').html(info.precio);
        $('#txt_precio_total').html(info.precio);


        $('#txt_cant_producto').removeAttr('disabled');
        $('#agregar_a_factura').show();




      } else {


        $('#agregar_a_factura').hide();

        $('#txt_descripcion').html('');
        $('#txt_existencia').html('');
        $('#txt_cant_producto').val('');
        $('#txt_precio').html('');
        $('#txt_precio_total').html('');
        $('#txt_cant_producto').attr('disabled', 'disabled');

      }

    },

    error: function (error) {

    }

  });

}


// Validar cantidad y realizar cambios en valor total
function cant_cambiada(e) {

  e.preventDefault();

  var stock = parseInt($("#txt_existencia").html());

  var totalcito = $(this).val() * $("#txt_precio").html();

  $("#txt_precio_total").html(totalcito);

  if ($(this).val() < 1 || isNaN($(this).val()) || $(this).val() > stock) {
    $('#agregar_a_factura').hide();
  } else {

    $('#agregar_a_factura').show();

  }



}


function nuevo_cliente(e) {

  e.preventDefault();

  $.ajax({

    url: 'factura.php',
    type: "POST",
    async: true,
    data: $("#form_registrar_cliente").serialize(),
    success: function (resultado) {
      if (resultado != 'error') {

        $('#nom_cliente').attr('disabled', 'disabled');
        $('#tel_cliente').attr('disabled', 'disabled');
        $('#dir_cliente').attr('disabled', 'disabled');
        $('#email_cliente').attr('disabled', 'disabled');

        //oculta boton agregar
        $('.btn_new_cliente').slideUp();
        //oculta boton guardar
        $('#div_registro_cliente').slideUp();
      }

    },

    error: function (error) {

    }

  });


}

function agregar_fila(e) {


  e.preventDefault();

  var producto = $('#cod_producto').val();
  var cantidad = $('#txt_cant_producto').val();

  var cantidad = $('#txt_cant_producto').val();

  var action = 'AgregarProductoDetalle';

  $.ajax({

    url: 'factura.php',
    type: "POST",
    async: true,
    data: {

      action: action,
      producto: producto,
      cantidad: cantidad

    },

    success: function (info) {

      var acum = 0;
      var datos = '';
      var detalleTotal = '';

      if (info != 'error') {

        var resultado = $.parseJSON(info);

        for (var i = 0; i < resultado.length; i++) {

          datos += '<tr style="width:130%; height:150%;">';
          datos += '<input class="codProducto1" type="hidden" value="' + resultado[i].correlativo + '">';
          datos += '<td class="codProducto">' + resultado[i].codproducto + '</td>';
          datos += '<td class="nomProducto">' + resultado[i].nombre + '</td>';
          datos += '<td class="cantidadProducto">' + resultado[i].cantidad + '</td>';
          datos += '<td class="precio_ventaProducto">' + resultado[i].precio_venta + '</td>';
          datos += '<td>' + resultado[i].precio_venta * resultado[i].cantidad + '</td>';
          datos += "<td><button type='button' class='btn btn-danger eliminar'>Eliminar</button></td>";
          datos += '<input type="hidden" class="idItemDetalle">' + resultado[i].correlativo + '</td>';
          datos += '</tr>';

          acum += resultado[i].precio_venta * resultado[i].cantidad;


        }


        $('#detalle_venta').html(datos);

        var iva = acum * 0.19;
        var subtotal = acum - iva;


        detalleTotal += '<tr>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td class="textright">Subtotal:</td>';
        detalleTotal += '<td class="textright"><h5 class="mr-2 mb-0">$' + subtotal + '</h5></td>';
        detalleTotal += '</tr>';
        detalleTotal += '<tr>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td class="textright">Iva</td>';
        detalleTotal += '<td class="textright"><h5 class="mr-2 mb-0">$' + iva + '</h5></td>';
        detalleTotal += '</tr>';
        detalleTotal += '<tr>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td class="textright">Total:</td>';
        detalleTotal += '<td class="textright"><h5 class="mr-2 mb-0">$' + acum + '</h5></td>';
        detalleTotal += '</tr>';

        $('#detalle_totales').html(detalleTotal);

        // Ocultar boton agregar
        $('#add_product_venta').slideUp();

      } else {
        console.log('No hay dato');
      }

      $(".eliminar").click(eliminarItem);
    },
    error: function (error) {

    }
  });

}


function eliminarItem(e) {

  e.preventDefault();

  $(this).parents("tr").attr("id", "por_eliminar");

  var item = $(this).parents("tr").find(".codProducto1").val();

  var action = 'EliminarItemTabla';

  $.ajax({

    url: 'factura.php',
    type: "POST",
    async: true,
    data: {

      action: action,
      item: item


    },

    success: function (info) {
      var acum = 0;
      var datos = '';
      var detalleTotal = '';

      if (info != 'error') {

        var resultado = $.parseJSON(info);

        for (var i = 0; i < resultado.length; i++) {

          datos += '<tr style="width:130%; height:150%;">';
          datos += '<input class="codProducto1" type="hidden" value="' + resultado[i].correlativo + '">';
          datos += '<td class="codProducto">' + resultado[i].codproducto + '</td>';
          datos += '<td class="nomProducto">' + resultado[i].nombre + '</td>';
          datos += '<td class="cantidadProducto">' + resultado[i].cantidad + '</td>';
          datos += '<td class="precio_ventaProducto">' + resultado[i].precio_venta + '</td>';
          datos += '<td>' + resultado[i].precio_venta * resultado[i].cantidad + '</td>';
          datos += "<td><button type='button' class='btn btn-danger eliminar'>Eliminar</button></td>";
          datos += '<input type="hidden" class="idItemDetalle">' + resultado[i].correlativo + '</td>';
          datos += '</tr>';

          acum += resultado[i].precio_venta * resultado[i].cantidad;


        }


        $('#detalle_venta').html(datos);

        var iva = acum * 0.19;
        var subtotal = acum - iva;


        detalleTotal += '<tr>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td class="textright">Subtotal:</td>';
        detalleTotal += '<td class="textright"><h5 class="mr-2 mb-0">$' + subtotal + '</h5></td>';
        detalleTotal += '</tr>';
        detalleTotal += '<tr>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td class="textright">Iva:</td>';
        detalleTotal += '<td class="textright"><h5 class="mr-2 mb-0">$' + iva + '</h5></td>';
        detalleTotal += '</tr>';
        detalleTotal += '<tr>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td></td>';
        detalleTotal += '<td class="textright">Total:</td>';
        detalleTotal += '<td class="textright"><h5 class="mr-2 mb-0">$' + acum + '</h5></td>';
        detalleTotal += '</tr>';

        $('#detalle_totales').html(detalleTotal);


        // Ocultar boton agregar
        $('#add_product_venta').slideUp();


      } else {
        console.log('No hay dato');

      }

      $(".eliminar").click(eliminarItem);


    }
  });



}