<input type="text" id="txt-cliente" class="span6" />
<script type="text/javascript">
//$(function() {
	var separador = '{#####}';
	$('#txt-cliente').typeahead({
		minLength: 1,
		items: 10,
		source: function(query, process) {
			objects = [];
			clientes = {};
			var datos;

			$.post('<?php echo site_url("catalogos/catalogos/autocompletar_servicio"); ?>', { q: query, limit: 10 }, function(data) {
                datos = JSON.parse(data);

                if (datos != false) {
	                $.each(datos, function(i, object) {
						objects.push(object.id_cliente + separador + object.nombre);
						clientes[object.id_cliente] = object;
					});

					process(objects);
				}
            });
		},
		highlighter: function (item) {
			return item.split(separador)[1];
		},
		updater: function(item) {
			alert('ID del cliente: ' + clientes[item.split(separador)[0]].id_cliente);
			return item.split(separador)[1];
		}
	});
//});
</script>