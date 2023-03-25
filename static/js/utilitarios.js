(function ($) {
   wbloc_obtener_hora_local();
})(jQuery);

function wbloc_obtener_hora_local() {
    var today = new Date();
    var hora = today.toLocaleString();
    var urlpagina =jQuery(location).attr('href');
    (function ($) {
        var url = SolicitudesAjax.url;
        jQuery.ajax({
            type: 'POST',
            url: url,
            data: {
                hora: hora,
                urlpagina: urlpagina,
                action: "wbloc_obtener_hora_local",
                nonce: SolicitudesAjax.seguridad,
            },
            success: function (datos) {
              console.log('ok');
              console.log(datos);
            },
            error: function (msg, xy) {
                console.log(msg);
                console.log(xy);
            }
        });
    })(jQuery);
}