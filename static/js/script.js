(function ($) {
    wbloc_load_page(1, '', '');
})(jQuery);


function wbloc_buscar_slogan() {
    dato = jQuery('#txt_buscar').val();
    wbloc_load_page(1, dato, '');
}


function wbloc_load_page(pagina, dato, message) {
    (function ($) {
        var url = SolicitudesAjax.url;
        jQuery.ajax({
            type: 'POST',
            url: url,
            data: {
                dato: dato,
                pagina: pagina,
                action: "wbloc_page_table",
                nonce: SolicitudesAjax.seguridad,
            },
            beforeSend: function () {
                jQuery('#wbloc_message').html('Procesando...');
            },
            complete: function () {
                jQuery('#wbloc_message').html(message);
            },
            success: function (datos) {
                jQuery('#wbloc_load_seccion').html(datos);
                
            },
            error: function (msg, xy) {
                console.log(msg);
                console.log(xy);
            }
        });
    })(jQuery);
}

function wbloc_seleccionar() {
    if (jQuery('#check_all').prop('checked')) {
        var checked_status = this.checked;
        jQuery('.cbox1').prop("checked", true);
    } else {
        jQuery('.cbox1').prop("checked", false);
    }
}


function wbloc_selec_opcion() {
    var opcion_group = jQuery('#opcion_group').val();
    var codigo_slogan = '';
    var checkbox = jQuery('[name="cbox1[]"]:checked');
    for (var m = 0; m < checkbox.length; m++) {
        codigo_slogan = codigo_slogan + "," + checkbox[m].value;
    }
    codigo_slogan = codigo_slogan.substring(1);
    (function ($) {
        var url = SolicitudesAjax.url;
        jQuery.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                codigo_slogan: codigo_slogan,
                opcion_seleccion: opcion_group,
                action: "wbloc_opcion_group_item",
                nonce: SolicitudesAjax.seguridad,
            },
            success: function (datos) {
                wbloc_load_page(1, '', datos.message);
            },
            error: function (msg, xy) {
                console.log(msg);
                console.log(xy);
            }
        });
    })(jQuery);
}


function wbloc_delete_page(codigo, pagina) {
    (function ($) {
        var url = SolicitudesAjax.url;
        alertify.dialog('confirm').set({
            'labels': { cancel: 'Cancelar', ok: 'Sí estoy seguro' },
            'title': '¿Esta seguro?',
            'message': '¿Está seguro de que desea eliminar los datos? Una vez eliminado, no se puede recuperar. ',
            'onok': function () {
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: {
                        codigo: codigo,
                        action: "wbloc_delete_page",
                        nonce: SolicitudesAjax.seguridad,
                    },
                    success: function (datos) {
                        wbloc_load_page(pagina, '', datos.message);
                    },
                    error: function (msg, xy) {
                        console.log(msg);
                        console.log(xy);
                    }
                });
            }
        }).show();
    })(jQuery);
}