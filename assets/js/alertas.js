$(function () {
    $("#alerta-boton").click(function () {
        $("#alerta-normal").modal('hide');
    });

    $("#alerta-error-boton").click(function () {
        $("#alerta-error").modal('hide');
    });
});

function alerta(msj, etiqueta) {
    $('#alerta-normal .mensaje').html(msj);
    $('#alerta-normal .etiqueta').html(etiqueta);
    $('#alerta-normal').modal({ show: true, keyboard: true });
    ocultar_loader();
}

function alerta_error(msj, etiqueta) {
    $('#alerta-error .mensaje').html(msj);
    $('#alerta-error .etiqueta').html(etiqueta);
    $('#alerta-error').modal({ show: true, keyboard: true });
    ocultar_loader();
}

function loader(msj) {
        $('#loader .mensaje').html(msj);
        $('#loader').modal({ show: true, keyboard: false });
        ocultar_loader();
    }

function ocultar_loader() {
    $('#loader').modal('hide');    
}