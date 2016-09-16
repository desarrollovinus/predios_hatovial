<?php
class Recordatorio_old extends CI_Controller {
	var $usuario_sistema = 'sistema.predios';
	var $correo_sistema = 'sistema.predios@hatovial.com';
	var $password_sistema = 'Spredial';
	

	var $correos_plannex = array(
/*
		'adelaida.salazar@plannex.com.co',
		'carolina.gonzalez@plannex.com.co',
		'lina.zapata@plannex.com.co'
*/
	);
	
	var $correos_hatovial = array(
'john.cano@hatovial.com'
/*
		'john.cano@hatovial.com',
		'german.velez@hatovial.com',
		'byron.arboleda@hatovial.com',
		'yadira.jaramillo@hatovial.com'
*/
	);
	
	var $correo_prueba = array('');
	
	var $estados = array(
		'Identificacion',
		'Revision Identificacion',
		'En Avaluo',
		'Elaborando Oferta',
		'En aprobacion de oferta',
		'En notificacion'
	);
	
	function __construct() {
		parent::__construct();
		
	}
	
	function enviar_recordatorios() {
		
		$this->load->library('email');
		
		$config['smtp_host'] = 'mail.hatovial.com';
		$config['smtp_user'] = $this->usuario_sistema;
		$config['smtp_pass'] = $this->password_sistema;
		$config['mailtype'] = 'html';
				
		$this->email->initialize($config);
		
		$this->load->model('ContratistasDAO');
		
		$this->load->model('InformesDAO');		
		
		$avaluos_vencidos = $this->InformesDAO->obtener_avaluos_vencidos();
		
		foreach ($avaluos_vencidos as $avaluo) {
			//si el estado se encuentra en alguno de los estados del array
			if(in_array($avaluo['estado'], $this->estados)) {
				//se obtiene el nombre del contratista
				if(trim($avaluo['contratista']) != '') {
					$contratista = $this->ContratistasDAO->obtener_contratista($avaluo['contratista']);
					$avaluo['contratista'] = $contratista->nombre;
				}
				//se organiza el mensaje
				$mensaje = file_get_contents('application/views/recordatorio/plantilla_predios_vencidos.html');
				$mensaje = str_replace('{TITULO}', 'Recordatorio', $mensaje);
				$mensaje = str_replace('{MENSAJE}', "El aval&uacute;o de la ficha predial ".$avaluo['ficha_predial']." se venci&oacute. <br><strong>Fecha de vencimiento:</strong> ".$avaluo['fecha_expiracion'].", <br><strong>D&iacute;as que lleva vencido:</strong> ".$avaluo['dias_expirado']." <br><strong>Estado del aval&uacute;o</strong>: ".$avaluo['estado']."<br><strong>Contratista encargado de la gesti&oacute;n:</strong> ".$avaluo['contratista'], $mensaje);
				//se envia un correo a plannex si es el contratista
				if(trim($avaluo['contratista']) == 'Plannex'){
					$this->email->from($this->correo_sistema, 'Hatopred');
					$this->email->to($this->correos_plannex);
					$this->email->bcc('alexander.vivas@hatovial.com'); 
					$this->email->subject('Recordatorio avaluo vencido');					
					$this->email->message($mensaje);	
					
					$this->email->send();
					echo "<br><br>Mensaje enviado a Plannex: <br>El aval&uacute;o de la ficha predial ".$avaluo['ficha_predial']." se venci&oacute. <br><strong>Fecha de vencimiento:</strong> ".$avaluo['fecha_expiracion'].", <br><strong>D&iacute;as que lleva vencido:</strong> ".$avaluo['dias_expirado']." <br><strong>Estado del aval&uacute;o</strong>: ".$avaluo['estado']."<br><strong>Contratista encargado de la gesti&oacute;n:</strong> ".$avaluo['contratista'];
				}
				//se envia un correo a los de hatovial
				$this->email->clear();
				
				$this->email->from($this->correo_sistema, 'Hatopred');
				$this->email->to($this->correos_hatovial);
				$this->email->subject('Recordatorio avaluo vencido');
				$this->email->message($mensaje);	
				
				$this->email->send();
				echo "<br><br>Mensaje enviado a Hatovial: <br>El aval&uacute;o de la ficha predial ".$avaluo['ficha_predial']." se venci&oacute. <br><strong>Fecha de vencimiento:</strong> ".$avaluo['fecha_expiracion'].", <br><strong>D&iacute;as que lleva vencido:</strong> ".$avaluo['dias_expirado']." <br><strong>Estado del aval&uacute;o</strong>: ".$avaluo['estado']."<br><strong>Contratista encargado de la gesti&oacute;n:</strong> ".$avaluo['contratista'];

			} 
		}
		
		$avaluos_en_proceso_de_vencimiento = $this->InformesDAO->obtener_avaluos_en_vencimiento();
		foreach ($avaluos_en_proceso_de_vencimiento as $avaluo) {
			//si el estado se encuentra en alguno de los estados del array
			if(in_array($avaluo['estado'], $this->estados)) {
				//se obtiene el nombre del contratista
				if(trim($avaluo['contratista']) != '') {
					$contratista = $this->ContratistasDAO->obtener_contratista($avaluo['contratista']);
					$avaluo['contratista'] = $contratista->nombre;
				}
				//se organiza el mensaje
				$mensaje = file_get_contents('application/views/recordatorio/plantilla_predios_vencidos.html');
				$mensaje = str_replace('{TITULO}', 'Recordatorio', $mensaje);
				$mensaje = str_replace('{MENSAJE}', "El aval&uacute;o de la ficha predial ".$avaluo['ficha_predial']." est&aacute; a punto de expirar, <br><strong>Fecha de vencimiento:</strong> ".$avaluo['fecha_expiracion'].", <br><Strong>Restan</strong> ".$avaluo['dias_faltantes']." d&iacute;as.<br><strong>Estado del aval&uacute;o</strong>: ".$avaluo['estado']."<br><strong>Contratista encargado de la gesti&oacute;n:</strong> ".$avaluo['contratista'], $mensaje);
				//se envia un correo a plannex si es el contratista
				if($avaluo['contratista'] == 'Plannex'){
					$this->email->clear();
					
					$this->email->from($this->correo_sistema, 'Hatopred');
					$this->email->to($this->correos_plannex); 		
					$this->email->bcc('alexander.vivas@hatovial.com'); 
					$this->email->subject('Recordatorio avaluo a punto de expirar');					
					$this->email->message($mensaje);	
					
					$this->email->send();
				}
				//se envia un correo a los de hatovial
				$this->email->clear();
				
				$this->email->from($this->correo_sistema, 'Hatopred');
				$this->email->to($this->correos_hatovial); 		
				$this->email->bcc('alexander.vivas@hatovial.com'); 
				$this->email->subject('Recordatorio avaluo a punto de expirar');
				$this->email->message($mensaje);	
				
				$this->email->send();
					
			} 
		}
	}
}
