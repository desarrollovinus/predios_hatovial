<div id="informacion" class="current"></div>
<script type="text/javascript">
	$(document).ready(function(){
		var texto = 'Posicione el cursor sobre el men&uacute; para conocer los detalles.';
		
		function poner_texto(texto) {
			$('#informacion').html(texto);
		}
		
		poner_texto(texto);
		
		$('a[rel=registro]').hover(
			function(){
				poner_texto('Ofrece una plantilla para el registro de nuevas fichas prediales.');
			}, 
			function(){
				poner_texto(texto);
			}
		);

		$('a[rel=gestion_predial]').hover(
			function(){
				poner_texto('Gestiona las fichas prediales existentes y la bit&aacute;cora asociada a cada ficha predial junto con sus archivos digitales, fotos, pagos, propietarios y actas de pago.');
			}, 
			function(){
				poner_texto(texto);
			}
		);

		$('a[rel=informes]').hover(
			function(){
				poner_texto('Presenta una lista de informes que se pueden exportar en los formatos: Excel y PDF');
			}, 
			function(){
				poner_texto(texto);
			}
		);

		$('a[rel=usuario]').hover(
			function(){
				poner_texto('Permite consultar y modificar la informaci&oacute;n relacionada con el usuario.');
			}, 
			function(){
				poner_texto(texto);
			}
		);

		$('a[rel=administracion]').hover(
			function(){
				poner_texto('Administraci&oacute;n general del sistema.');
			}, 
			function(){
				poner_texto(texto);
			}
		);
	});
</script>