$(document).ready(function () {

    // Guarda la receta, medicamentos e indicaciones

    $("#addReceta").click(function () {

        $.ajax({
            url: raiz_url + "Receta/ajax_guardar_receta",
            type: 'POST',
            dataType: 'json',

            success: function (data) {
                if (data>0){
                    $('#ID_RECETA').val(data);
                    Swal.fire({
                        title: '¡Nueva Receta!',
                        text: 'Se ha registrado la receta',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2500,
                    });
                }
                    else{
                        Swal.fire({
                        title: '¡Nueva Receta!',
                        text: 'hubo un error al realizar la operación',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2500,
                    });
                        
                    }
            }
        });
    });

    // Guardar indicacion en la sesion

    $('#formAddReceta').validator().on('submit', function (e) {
        if (!e.isDefaultPrevented())
            e.preventDefault();

        $.ajax({
            url: raiz_url + "Receta/ajax_guardar_indicacion",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
                crearTabla();
                $('#formAddReceta')[0].reset();
            }
        });
    });

    // Borrar indicaciones de la sesion y tabla

    $("body").on("click", "#borrar-receta", function (e) {

        if (!e.isDefaultPrevented())
            e.preventDefault();

        var id = $(this).data('indicacion');

        $.ajax({
            type: "POST",
            url: raiz_url + 'Receta/ajax_borrar_indicacion',
            dataType: 'json',
            data: 'id=' + id,

            success: function (data) {
                crearTabla();
            }
        });
    });


    /*  Trae los nombres de medicamentos y productos (unicos),
            después autocompleta el siguiente input
        */
    $.ajax({
        type: "POST",
        url: raiz_url + 'Receta/ajax_obtener_nombres',
        dataType: 'json',

        success: function (respuesta) {
            var nombres = new Array();
            $.each(respuesta, function (x, nombre) {
                nombres.push(nombre);
            });

            $("#NOMBRE_MEDICAMENTO").autocomplete({
                source: nombres,
                select: function (event, ui) {
                    var nombre = ui.item.value;

                    /*  Trae los nombres comerciales de medicamentos ,
                            después autocompleta el siguiente input
                        */
                    $.ajax({
                        type: "POST",
                        url: raiz_url + 'Receta/ajax_obtener_nombres_comerciales',
                        dataType: 'json',
                        data: 'nombre=' + nombre,

                        success: function (respuesta) {
                            var nombresComerciales = new Array();
                            $.each(respuesta, function (x, nombreComercial) {
                                nombresComerciales.push(nombreComercial);
                            });

                            $("#NOMBRE_COMERCIAL").autocomplete({
                                source: nombresComerciales,
                                select: function (event, ui) {
                                    var nombreComercial = ui.item.value;

                                    /*  Trae las formulas en base de los nombres
                                     */
                                    $.ajax({
                                        type: "POST",
                                        url: raiz_url + 'Receta/ajax_obtener_formulas',
                                        dataType: 'json',
                                        data: 'nombre=' + nombre + '&nombreComercial=' + nombreComercial,

                                        success: function (respuesta) {
                                            var formulas = new Array();
                                            $.each(respuesta, function (x, formula) {
                                                formulas.push(formula);
                                            });

                                            $("#FORMULA").autocomplete({
                                                source: formulas,
                                                select: function (event, ui) {
                                                    var formula = ui.item.value;
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });

                }
            });
        }
    });

    // Agregar nueva receta a la consulta

    /*$("body").on("click", "#BTN_CONSULTA_RECETA", function (event) {
        let lastURL = "Consult";
        let id_patient = $(this).data('id_paciente');
        let id_consult = $(this).data('id_consulta');

        $.ajax({
            url: raiz_url + "Receta/ajax_guardar_ids_sesion",
            type: 'POST',
            data: 'LAST_URL=' + lastURL + '&ID_PACIENTE=' + id_patient + '&ID_CONSULTA=' + id_consult,

            success: function (data) {
                window.location.href = raiz_url + "Receta"
            }
        });
    });*/

    // Agregar nueva receta a la urgencia

    $("body").on("click", "#BTN_URGENCIA_RECETA", function (event) {
        var lastURL = "Urgency";
        var id_patient = $(this).data('id_paciente');
        var id_urgencia = $(this).data('id_urgencia');

        $.ajax({
            url: raiz_url + "Receta/ajax_guardar_ids_sesion",
            type: 'POST',
            data: 'LAST_URL=' + lastURL + '&ID_PACIENTE=' + id_patient + '&ID_URGENCIA=' + id_urgencia,

            success: function (data) {
                window.location.href = raiz_url + "Receta"
            }
        });
    });

    // Editar indicaciones de consulta

    $("body").on("click", "#EDIT_CONSULTA_RECETA", function (event) {
        var lastURL = "Consult";
        var id_patient = $(this).data('id_paciente');
        var id_receta = $(this).data('id_receta');
        var id_consult = $(this).data('id_consulta');

        $.ajax({
            url: raiz_url + "Receta/ajax_guardar_ids_sesion",
            type: 'POST',
            data: 'LAST_URL=' + lastURL + '&ID_PACIENTE=' + id_patient + '&ID_RECETA=' + id_receta +'&ID_CONSULTA=' + id_consult,

            success: function (data) {
                window.location.href = raiz_url + "Receta/editar"
            }
        });
    });

    // Editar indicaciones de urgencia

    $("body").on("click", "#EDIT_URGENCIA_RECETA", function (event) {
        var lastURL = "Urgency";
        var id_patient = $(this).data('id_paciente');
        var id_receta = $(this).data('id_receta');
        var id_urgencia = $(this).data('id_urgencia');

        $.ajax({
            url: raiz_url + "Receta/ajax_guardar_ids_sesion",
            type: 'POST',
            data: 'LAST_URL=' + lastURL + '&ID_PACIENTE=' + id_patient + '&ID_RECETA=' + id_receta + '&ID_URGENCIA=' + id_urgencia,

            success: function (data) {
                window.location.href = raiz_url + "Receta/editar"
            }
        });
    });
    $('#PrintReceta').on('click', function () {
      var ID_RECETA = $('#ID_RECETA').val();
      {
         window.open(raiz_url + "receta/pdfReceta/" + ID_RECETA);
      }

   });
   $("#btnAddItemBuy").click(function () {
      $("#addReceta").show();
   })
   $("#addReceta").click(function () {
       $(this).hide();
      $("#PrintReceta").show();
   })
});