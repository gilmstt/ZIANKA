
var asInitVals = new Array();
$(document).ready(function () {
    //CLIENTES..
    var oTableUsers = $('#dataUser').dataTable({//CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "language": {"url": raiz_url+"assets/plugins/dataTables/Spanish.json"},
        "iDisplayLength": 25,
        "aLengthMenu": [[15, 25, 50, 100, -1], [15, 25, 50, 100, "Todos"]],
        "bDestroy": true,
        "bServerSide": false,
        "bProcessing": true,
        "dom": "<'row'<'col-lg-6 col-mdx-6 col-sm-12'fB><'col-lg-6 col-mdx-6 col-sm-12 text-right'l>><'row op'<'col-md-12 p-dt't>><'row'<'col-md-12 p-dt'i>><'row'<'col-md-12 p-dt'p>>",
        buttons: [
            {
                extend: 'csv',
                text: 'Excel',
                title: 'Clientes',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    }
                }
            }
        ],           
    });
    $("#li_Tarifas").click(function(){        
        $("#btnNewTarifa").removeClass('hidex');
        $("#btnAddUser").addClass('hidex');
        $("#btnNewMembresia").addClass('hidex');
        $("#btnNewPerfil").addClass('hidex');
        $("#btnAddCasa").addClass('hidex');
    })    
    $("#li_Users").click(function(){        
        $("#btnNewTarifa").addClass('hidex');
        $("#btnAddUser").removeClass('hidex');
        $("#btnNewMembresia").addClass('hidex');
        $("#btnNewPerfil").addClass('hidex');
        $("#btnAddCasa").addClass('hidex');
    })
    $("#li_Membresias").click(function(){        
        $("#btnNewTarifa").addClass('hidex');
        $("#btnAddUser").addClass('hidex');
        $("#btnNewMembresia").removeClass('hidex');
        $("#btnNewPerfil").addClass('hidex');
        $("#btnAddCasa").addClass('hidex');
    })
    $("#li_Perfil").click(function(){        
        $("#btnNewTarifa").addClass('hidex');
        $("#btnAddUser").addClass('hidex');
        $("#btnNewMembresia").addClass('hidex');
        $("#btnNewPerfil").removeClass('hidex');
        $("#btnAddCasa").addClass('hidex');
    })
    $("#li_Casas").click(function(){        
        $("#btnNewTarifa").addClass('hidex');
        $("#btnAddUser").addClass('hidex');
        $("#btnNewMembresia").addClass('hidex');
        $("#btnNewPerfil").addClass('hidex');
        $("#btnAddCasa").removeClass('hidex');
    })
    
    //Tarifas
    $("body").on('click', '#btnNewTarifa', function(e){
        e.preventDefault();
        $(".space").hide();
        $(".form-tarifas").show();
        $(".table-tarifas").removeClass('col-lg-12').addClass('col-lg-6');
        $(".formEdit-tarifas").hide();
        $('input[name="RG_NOMBRE_TARIFA"]').val('');
        $('input[name="RG_PORCENTAJE_TARIFA"]').val('');
    })

    $("body").on('click', '#btnEditTarifa', function(e){
        var id = $(this).attr('data-id-tarifa');
        var name = $(this).attr('data-name-tarifa');
        var per = $(this).attr('data-per-tarifa');
        var conTax = $(this).attr('data-con-tax');
        var urgTax = $(this).attr('data-urg-tax');

        $(".space").hide();
        $(".formEdit-tarifas").show();
        $(".form-tarifas").hide();

        $('#RG_ID_TARIFA').val(id);
        $(".table-tarifas").removeClass('col-lg-12').addClass('col-lg-6');
        $('input[name="RG_NOMBRE_TARIFA"]').val(name);
        $('input[name="RG_PORCENTAJE_TARIFA"]').val(per);
        $('input[name="RG_CONSULTA_TARIFA"]').val(conTax);
        $('input[name="RG_URGENCIA_TARIFA"]').val(urgTax);
    })

    $("body").on('click', '.btn-cancel', function(e){
        $(".space").show();
        $(".form-tarifas").hide();
        $(".formEdit-tarifas").hide();
        $(".table-tarifas").addClass('col-lg-12').removeClass('col-lg-6');

    })

    //Membresias
    $("body").on('click', '#btnNewMembresia', function(e){
        $(".space").hide();
        $(".form-membresia").show();
        $(".table-membresias").removeClass('col-lg-12').addClass('col-lg-6');
        $(".formEdit-membresias").hide();
        $('input[name="RG_NOMBRE_MEMBRESIA"]').val('');
    });

    $("body").on('click', '#btnEditMembresia', function(e){
        var id = $(this).attr('data-id-membresia');
        var name = $(this).attr('data-name-membresia');

        $(".space").hide();
        $(".formEdit-membresias").show();
        $(".form-membresia").hide();

        $('#RG_ID_MEMBRESIA').val(id);
        $(".table-membresias").removeClass('col-lg-12').addClass('col-lg-6');
        $('input[name="RG_NOMBRE_MEMBRESIA"]').val(name);
    });

    $("body").on('click', '.btn-cancel-mem', function(e){
        $(".space").show();
        $(".form-membresia").hide();
        $(".formEdit-membresias").hide();
        $(".table-membresias").addClass('col-lg-12').removeClass('col-lg-6');

    });
    
    //Perfiles
    $("body").on('click', '#btnNewPerfil', function(e){
        $(".space").hide();
        $(".form-perfil").show();
        $(".table-perfiles").removeClass('col-lg-12').addClass('col-lg-6');
        $(".formEdit-perfil").hide();
        $('input[name="RG_NOMBRE_PERFIL"]').val('');
    });
    
    $("body").on('click', '#btnEditPerfil', function(e){
        var id = $(this).attr('data-id-perfil');
        var name = $(this).attr('data-name-perfil');

        $(".space").hide();
        $(".formEdit-perfil").show();
        $(".form-perfil").hide();

        $('#RG_ID_PERFIL').val(id);
        $(".table-perfiles").removeClass('col-lg-12').addClass('col-lg-6');
        $('input[name="RG_NOMBRE_PERFIL"]').val(name);
    });
    
    $("body").on('click', '.btn-cancel-per', function(e){
        $(".space").show();
        $(".form-perfil").hide();
        $(".formEdit-perfil").hide();
        $(".table-perfiles").addClass('col-lg-12').removeClass('col-lg-6');

    });
    
    //Casas
    $("body").on('click', '#btnAddCasa', function(e){
        $(".space").hide();
        $(".form-house").show();
        $(".table-house").removeClass('col-lg-12').addClass('col-lg-6');
        $(".formEdit-house").hide();
        $('input[name="RG_NOMBRE_CASA"]').val('');
    });
    
    $("body").on('click', '#btnEditHouse', function(e){
        var id = $(this).attr('data-id-house');
        var name = $(this).attr('data-name-house');
        var membership_id = $(this).attr('data-id-membresia');

        $(".space").hide();
        $(".formEdit-house").show();
        $(".form-house").hide();

        $('#RG_ID_CASA').val(id);
        $(".table-house").removeClass('col-lg-12').addClass('col-lg-6');
        $('input[name="RG_NOMBRE_CASA"]').val(name);
        $('#RG_ID_MEMBRESIA_E').val(membership_id);
    });

    $("body").on('click', '.btn-cancel-add-house', function(e){
        $(".space").show();
        $(".form-house").hide();
        $(".formEdit-house").hide();
        $(".table-house").addClass('col-lg-12').removeClass('col-lg-6');

    });
    
    //filtros--
    $("thead input").keyup(function () {
        /* Filter on the column (the index) of this element */
        oTableUsers.fnFilter(this.value, $("thead input").index(this));
    });
    /*
    
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
     * the footer
     */
    

    $("thead input").each(function (i) {
        asInitVals[i] = this.value;
    });

    $("thead input").focus(function () {
        if (this.className == "search_init")
        {
            this.className = "";
            this.value = "";
        }
    });

    $("thead input").blur(function (i) {
        if (this.value == "")
        {
            this.className = "search_init";
            this.value = asInitVals[$("thead input").index(this)];
        }
    });

    //Tarifas
    $('#addTarifa').on('submit', function(e){
        if (e.isDefaultPrevented()) {
            
        } else {
            e.preventDefault();
            $.ajax({
                url: raiz_url + 'config/ajax_add_tarifa',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    if (data > 0) {                      
                        Swal.fire({
                            title: 'Tarifa Registrada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/tarifas";
                            }
                        });
                    } else {
                        $('.add-name-error').html('Esta tarifa ya esta definida');
                    }
                }
            });
        }
    });

    $('#editTarifa').on('submit', function(e){
        if (e.isDefaultPrevented()) {
            
        } else {
            e.preventDefault();

            $.ajax({
                url: raiz_url + 'config/ajax_edit_tarifa',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    console.log(data);
                    if (data > 0) {                    
                        Swal.fire({
                            title: 'Información Actualizada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/tarifas";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'No hubo ningun cambio!',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500,                            
                        });
                    }
                },
                error: function(e){
                    console.log(e);
                }
            });        
        }
    });

    $('body').on("click", ".btn-delete-tarifa", function (e) {
        var ID_TARIFA = $(this).attr('data-id-tarifa');
        //console.log('ID_CLIENTE CLICKEADO: '+ID_CLIENTE);
        if (ID_TARIFA > 0) {
         
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: raiz_url + "config/ajax_delete_tarifa",
                        type: 'POST',
                        data: {ID_TARIFA: ID_TARIFA},
                    })
                    .done(function (data) {
                        if (data > 0) {
                            Swal.fire({
                            title: 'Tarifa eliminada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/tarifas";
                            }
                            });
                        }else{
                            Swal.fire({
                                title: 'Error al eliminar!',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500,                           
                            });
                        }
                    });                  
                }
            });
        }
    });

    //Membresias
    $('#addMembresia').on('submit', function(e){
        if (e.isDefaultPrevented()) {
            
        } else {
            e.preventDefault();
            $.ajax({
                url: raiz_url + 'config/ajax_add_membresia',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    if (data > 0) {                      
                        Swal.fire({
                            title: 'Membresia Registrada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/membresias";
                            }
                        });
                    } else {
                        $('.add-name-error').html('Esta membresia ya esta definida');
                    }
                }
            });
        }
    });

    $('#editMembresia').on('submit', function(e){
        if (e.isDefaultPrevented()) {
            
        } else {
            e.preventDefault();

            $.ajax({
                url: raiz_url + 'config/ajax_edit_membresia',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    console.log(data);
                    if (data > 0) {                    
                        Swal.fire({
                            title: 'Información Actualizada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/membresias";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'No hubo ningun cambio!',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500,                            
                        });
                    }
                }
            });        
        }
    });

    $('body').on("click", ".btn-delete-membresia", function (e) {
        var ID_MEMBRESIA = $(this).attr('data-id-membresia');
        if (ID_MEMBRESIA > 0) {
         
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: raiz_url + "config/ajax_delete_membresia",
                        type: 'POST',
                        data: {ID_MEMBRESIA: ID_MEMBRESIA},
                    })
                    .done(function (data) {
                        if (data > 0) {
                            Swal.fire({
                            title: 'Membresia eliminada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/membresias";
                            }
                            });
                        }else{
                            Swal.fire({
                                title: 'Error al eliminar!',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500,                           
                            });
                        }
                    });                  
                }
            });
        }
    });
    
    //Perfiles
    $('#addPerfil').on('submit', function(e){
        if (e.isDefaultPrevented()) {
            
        } else {
            e.preventDefault();
            $.ajax({
                url: raiz_url + 'config/ajax_add_perfil',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    if (data > 0) {                      
                        Swal.fire({
                            title: 'Perfil Registrado!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/perfiles";
                            }
                        });
                    } else {
                        $('.add-name-error').html('Este perfil ya esta definido');
                    }
                }
            });
        }
    });
    
    $('#editPerfil').on('submit', function(e){
        if (e.isDefaultPrevented()) {
            
        } else {
            e.preventDefault();

            $.ajax({
                url: raiz_url + 'config/ajax_edit_perfil',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    console.log(data);
                    if (data > 0) {                    
                        Swal.fire({
                            title: 'Información Actualizada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/perfiles";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'No hubo ningun cambio!',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500,                            
                        });
                    }
                }
            });        
        }
    });
    
    $('body').on("click", ".btn-delete-perfil", function (e) {
        var ID_PERFIL = $(this).attr('data-id-perfil');
        if (ID_PERFIL > 0) {
         
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: raiz_url + "config/ajax_delete_perfil",
                        type: 'POST',
                        data: {ID_PERFIL: ID_PERFIL},
                    })
                    .done(function (data) {
                        if (data > 0) {
                            Swal.fire({
                            title: 'Perfil eliminado!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/perfiles";
                            }
                            });
                        }else{
                            Swal.fire({
                                title: 'Error al eliminar!',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500,                           
                            });
                        }
                    });                  
                }
            });
        }
    });
    
    //Usuarios
    $('#formRecordUser').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {
            // everything looks good!
            e.preventDefault();
            
            $.ajax({
                url: raiz_url + "config/ajax_add_user",
                type: 'POST',
                data: $(this).serialize(),
                success: function (data) {

                    if (data > 0) {
                        Swal.fire({
                            title: 'Usuario Registrado!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error al Registrar!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,                          
                        });
                    }
                }
            });
         
        }
    });

    ///btnDeleteUser..
    $('body').on("click", ".btn-delete-user", function (e) {
        var ID_USUARIO = $(this).attr('data-id-user');
        //console.log('ID_CLIENTE CLICKEADO: '+ID_CLIENTE);
        if (ID_USUARIO > 0) {  
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: raiz_url + "config/ajax_disable_user",
                        type: 'POST',
                        data: 'ID_USUARIO=' + ID_USUARIO,
                    })
                    .done(function (data) {
                        if (data > 0) {
                            Swal.fire({
                            title: 'Usuario eliminado!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.reload();
                            }
                            });
                        }else{
                            Swal.fire({
                                title: 'Error al eliminar!',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500,                           
                            });
                        }
                    });                  
                }
            });
        }
    });


    $('#btnCancelEditUser').on('click', function () {
        window.location.href = raiz_url + "config/index";
    });

    $('body').on("click", ".btn-edit-user", function (e) {
        var ID_USUARIO = $(this).attr('data-id-user');
        window.location.href = raiz_url + "config/form_config_edit_user/" + ID_USUARIO;
    });

    //EDIT USUARIO...
    $('#formEditdUser').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {
            // everything looks good!
            e.preventDefault();

            $.ajax({
                url: raiz_url + "config/ajax_edit_user",
                type: 'POST',
                data: $(this).serialize(),
                success: function (data) {

                    if (data > 0) {                     
                        Swal.fire({
                            title: 'Información Actualizada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "config/index";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error al actualizar!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,                           
                        });
                    }
                }
            });       
        }
    });
    
    //Casas
    $('#addHouse').on('submit', function(e){
        if (e.isDefaultPrevented()) {
            
        } else {
            e.preventDefault();
            $.ajax({
                url: raiz_url + 'config/ajax_add_house',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    if (data > 0) {                      
                        Swal.fire({
                            title: 'Casa Registrada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/casas";
                            }
                        });
                    } else {
                        $('.add-name-error').html('Esta casa ya esta definida');
                    }
                }
            });
        }
    });
    
    $('#editHouse').on('submit', function(e){
        if (e.isDefaultPrevented()) {
            
        } else {
            e.preventDefault();

            $.ajax({
                url: raiz_url + 'config/ajax_edit_house',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    //console.log(data);
                    if (data > 0) {                    
                        Swal.fire({
                            title: 'Información Actualizada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/casas";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'No hubo ningun cambio!',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500,                            
                        });
                    }
                },
                error: function(e){
                    Swal.fire({
                        title: 'Ocurrió un error!',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500,                            
                    });
                }
            });        
        }
    });

    $('body').on("click", ".btn-delete-house", function (e) {
        var ID_CASA = $(this).attr('data-id-house');
        if (ID_CASA > 0) {
         
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: raiz_url + "config/ajax_delete_house",
                        type: 'POST',
                        data: {ID_CASA: ID_CASA},
                    })
                    .done(function (data) {
                        if (data > 0) {
                            Swal.fire({
                            title: 'Casa eliminada!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: function () {
                                window.location.href = raiz_url + "Config/index/tarifas";
                            }
                            });
                        }else{
                            Swal.fire({
                                title: 'Error al eliminar!',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500,                           
                            });
                        }
                    });                  
                }
            });
        }
    });


    /* $('#btnCancelAddUser').on('click', function () {
     var autoridad = $(this).attr('data-autoridad');
     if (autoridad == 3)
     window.location.href = raiz_url + "vendedores";
     else
     window.location.href = raiz_url + "config/config_user";
     });*/
    
    //FIN USUARIO...//
});
///FUNCIONES JS..