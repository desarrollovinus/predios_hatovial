<?php
date_default_timezone_set('America/Bogota');  
class Recordatorio extends CI_Controller{
    
    //Variables de quien envía el correo
    var $usuario_sistema = 'sistema.predios';
    var $correo_sistema = 'sistema.predios@hatovial.com';
    var $password_sistema = 'Spredial';
    
    //Correos de Plannex
    var $correos_plannex = array(
        'john.cano@hatovial.com',
        'adelaida.salazar@plannex.com.co',
        'carolina.gonzalez@plannex.com.co'
    );//$correos_plannex
 
    //var $correos_plannex = array('john.cano@hatovial.com');
 
    //Correos Hatovial
    var $correos_hatovial = array(
        'john.cano@hatovial.com',
        'german.velez@hatovial.com',
        'byron.arboleda@hatovial.com',
        'yadira.jaramillo@hatovial.com'
    );//$correos_hatovial

    //var $correos_hatovial = array('john.cano@hatovial.com');
	
    //Array de estados
    var $estados = array(
            'Identificacion',
            'Revision Identificacion',
            'En Avaluo',
            'Elaborando Oferta',
            'En aprobacion de oferta',
            'En notificacion'
    );//$estados
    
    function __construct() {
        parent::__construct();
    }//Constructor

    function enviar_recordatorio_nuevo()
    {
        //Cargar la librería email
        $this->load->library('email');
	
        //Configuraciones del correo
        $config['smtp_host'] = 'mail.hatovial.com';
        $config['smtp_user'] = $this->usuario_sistema;
        $config['smtp_pass'] = $this->password_sistema;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        
        //Carga de modelos
        $this->load->model('ContratistasDAO');
        $this->load->model('InformesDAO');		
        $avaluos_vencidos = $this->InformesDAO->obtener_avaluos_vencidos();
        $avaluos_en_proceso_de_vencimiento = $this->InformesDAO->obtener_avaluos_en_vencimiento();
        
        //-----------------------Construyendo la tabla de vencidos para Plannex-----------------------//
        $tabla_plannex = '<table border="1" cellspacing="0" width="100%">';

        $tabla_plannex .= "<thead>";
        $tabla_plannex .= "<tr>";
        $tabla_plannex .= "<th>Nro.</th>";
        $tabla_plannex .= "<th>Ficha predial</th>";
        $tabla_plannex .= "<th>Fecha vencimiento</th>";
        $tabla_plannex .= "<th>D&iacute;as vencido</th>";
        $tabla_plannex .= "<th>Estado</th>";
        $tabla_plannex .= "<th>Contratista</th>";
        $tabla_plannex .= "</tr>";
        $tabla_plannex .= "</thead>";

        $tabla_plannex .= "<tbody>";
        
        //se hace el recorrido para Plannex
        foreach ($avaluos_vencidos as $avaluo){
            if(trim($avaluo['contratista'])=='Plannex'){
                $numeracion_plannex++;
                $tabla_plannex .= "<tr>";
                $tabla_plannex .= "<td align='right'>$numeracion_plannex.</td>";
                $tabla_plannex .= "<td>".$avaluo['ficha_predial']."</td>";
                $tabla_plannex .= "<td>".$avaluo['fecha_expiracion']."</td>";
                $tabla_plannex .= "<td align='right'>".number_format($avaluo['dias_expirado'],0,",",".")."</td>";
                $tabla_plannex .= "<td>".utf8_decode($avaluo['estado'])."</td>";
                $tabla_plannex .= "<td>".$avaluo['contratista']."</td>";
                $tabla_plannex .= "</tr>";
                }//End if
        }//End foreach

        $tabla_plannex .= "</tbody>";
        $tabla_plannex .= "</table>";

        //Organizando el mensaje
        $mensaje = file_get_contents('application/views/recordatorio/plantilla_predios_vencidos.html');
        $mensaje = str_replace('{TITULO}', 'Recordatorio', $mensaje);
        $mensaje = str_replace('{MENSAJE}', 'A la fecha se reportan '.$numeracion_plannex.' aval&uacute;os vencidos. Este es el listado correspondiente: </br></br>'.$tabla_plannex, $mensaje) ;
        
        $this->email->from($this->correo_sistema, 'Hatopred - Listado de fichas vencidas');
        $this->email->to($this->correos_plannex);
        $this->email->bcc('johnarleycano@hotmail.com'); 
        $this->email->subject('Recordatorio avalúos vencidos');					
        $this->email->message($mensaje);	

        $this->email->send();
        echo "<br>El mensaje de aval&uacute;os vencidos ha sido enviado a Plannex correctamente";
        
        //-----------------------Construyendo la tabla de vencidos para Hatovial-----------------------// 
        $tabla_hatovial = '<table border="1" cellspacing="0" width="100%">';

        $tabla_hatovial .= "<thead>";
        $tabla_hatovial .= "<tr>";
        $tabla_hatovial .= "<th>Nro.</th>";
        $tabla_hatovial .= "<th>Ficha predial</th>";
        $tabla_hatovial .= "<th>Fecha vencimiento</th>";
        $tabla_hatovial .= "<th>D&iacute;as vencido</th>";
        $tabla_hatovial .= "<th>Estado</th>";
        $tabla_hatovial .= "<th>Contratista</th>";
        $tabla_hatovial .= "</tr>";
        $tabla_hatovial .= "</thead>";

        $tabla_hatovial .= "<tbody>";
        
        //se hace el recorrido para Hatovial
        foreach ($avaluos_vencidos as $avaluo){
            if(trim($avaluo['contratista'])!='Plannex'){
                $numeracion_hatovial++;
                $tabla_hatovial .= "<tr>";
                $tabla_hatovial .= "<td align='right'>$numeracion_hatovial.  </td>";
                $tabla_hatovial .= "<td>".$avaluo['ficha_predial']."</td>";
                $tabla_hatovial .= "<td>".$avaluo['fecha_expiracion']."</td>";
                $tabla_hatovial .= "<td align='right'>".number_format($avaluo['dias_expirado'],0,",",".")."</td>";
                $tabla_hatovial .= "<td>".utf8_decode($avaluo['estado'])."</td>";
                $tabla_hatovial .= "<td>".$avaluo['contratista']."</td>";
                $tabla_hatovial .= "</tr>";
                }//End if
        }//End foreach

        $tabla_hatovial .= "</tbody>";
        $tabla_hatovial .= "</table>";

        //Organizando el mensaje
        $mensaje = file_get_contents('application/views/recordatorio/plantilla_predios_vencidos.html');
        $mensaje = str_replace('{TITULO}', 'Recordatorio', $mensaje);
        $mensaje = str_replace('{MENSAJE}', 'A la fecha se reportan '.$numeracion_hatovial.' aval&uacute;os vencidos. Este es el listado correspondiente: </br></br>'.$tabla_hatovial, $mensaje) ;
        
        $this->email->from($this->correo_sistema, 'Hatopred - Listado de fichas vencidas');
        $this->email->to($this->correos_hatovial);
        $this->email->bcc('johnarleycano@hotmail.com'); 
        $this->email->subject('Recordatorio avalúos vencidos');					
        $this->email->message($mensaje);	

        $this->email->send();
        echo "<br>El mensaje de aval&uacute;os vencidos ha sido enviado a Hatovial correctamente";
        
        //-----------------------Construyendo tabla en vencimiento para Plannex-----------------------//
        $tabla_plannex_en_vencimiento = '<table border="1" cellspacing="0" width="100%">';
        
        $tabla_plannex_en_vencimiento .= "<thead>";
        $tabla_plannex_en_vencimiento .= "<tr>";
        $tabla_plannex_en_vencimiento .= "<th>Nro.</th>";
        $tabla_plannex_en_vencimiento .= "<th>Ficha predial</th>";
        $tabla_plannex_en_vencimiento .= "<th>Fecha vencimiento</th>";
        $tabla_plannex_en_vencimiento .= "<th>D&iacute;as restantes</th>";
        $tabla_plannex_en_vencimiento .= "<th>Estado</th>";
        $tabla_plannex_en_vencimiento .= "<th>Contratista</th>";
        $tabla_plannex_en_vencimiento .= "</tr>";
        $tabla_plannex_en_vencimiento .= "</thead>";
        
        $tabla_plannex_en_vencimiento .= "<tbody>";
        
        
        
        //se hace el recorrido para Plannex
        foreach ($avaluos_en_proceso_de_vencimiento as $avaluo_en_proceso_de_vencimiento){
            if(trim($avaluo_en_proceso_de_vencimiento['contratista'])=='Plannex'){
                $numeracion_plannex_en_vencimiento++;
                $tabla_plannex_en_vencimiento .= "<tr>";
                $tabla_plannex_en_vencimiento .= "<td align='right'>$numeracion_plannex_en_vencimiento.</td>";
                $tabla_plannex_en_vencimiento .= "<td>".$avaluo_en_proceso_de_vencimiento['ficha_predial']."</td>";
                $tabla_plannex_en_vencimiento .= "<td>".$avaluo_en_proceso_de_vencimiento['fecha_expiracion']."</td>";
                $tabla_plannex_en_vencimiento .= "<td align='right'>".number_format($avaluo_en_proceso_de_vencimiento['dias_expirado'],0,",",".")."</td>";
                $tabla_plannex_en_vencimiento .= "<td>".utf8_decode($avaluo_en_proceso_de_vencimiento['estado'])."</td>";
                $tabla_plannex_en_vencimiento .= "<td>".$avaluo_en_proceso_de_vencimiento['contratista']."</td>";
                $tabla_plannex_en_vencimiento .= "</tr>";
            }//End if
        }//End foreach
        
        $tabla_plannex_en_vencimiento .= "</tbody>";
        $tabla_plannex_en_vencimiento .= "</table>";
        
        //Organizando el mensaje
        $mensaje = file_get_contents('application/views/recordatorio/plantilla_predios_vencidos.html');
        $mensaje = str_replace('{TITULO}', 'Recordatorio', $mensaje);
        if($numeracion_plannex_en_vencimiento > 0){
            $mensaje = str_replace('{MENSAJE}', 'A la fecha se reportan '.$numeracion_plannex_en_vencimiento.' aval&uacute;os que est&aacute;n por vencerse. Este es el listado correspondiente: </br></br>'.$tabla_plannex_en_vencimiento, $mensaje) ;
        }else{
            $mensaje = str_replace('{MENSAJE}', 'A la fecha no se reportan aval&uacute;os por vencerse.</br></br>', $mensaje) ;
        }
        
        
        $this->email->from($this->correo_sistema, 'Hatopred - Listado de fichas por vencerse');
        $this->email->to($this->correos_plannex);
        $this->email->bcc('johnarleycano@hotmail.com'); 
        $this->email->subject('Recordatorio avalúos por vencerse');					
        $this->email->message($mensaje);	

        $this->email->send();
        echo "<br>El mensaje de aval&uacute;os por vencerse ha sido enviado a Plannex correctamente";
        
        //-----------------------Construyendo tabla en vencimiento para Hatovial-----------------------//
        $tabla_hatovial_en_vencimiento = '<table border="1" cellspacing="0" width="100%">';
        
        $tabla_hatovial_en_vencimiento .= "<thead>";
        $tabla_hatovial_en_vencimiento .= "<tr>";
        $tabla_hatovial_en_vencimiento .= "<th>Nro.</th>";
        $tabla_hatovial_en_vencimiento .= "<th>Ficha predial</th>";
        $tabla_hatovial_en_vencimiento .= "<th>Fecha vencimiento</th>";
        $tabla_hatovial_en_vencimiento .= "<th>D&iacute;as restantes</th>";
        $tabla_hatovial_en_vencimiento .= "<th>Estado</th>";
        $tabla_hatovial_en_vencimiento .= "<th>Contratista</th>";
        $tabla_hatovial_en_vencimiento .= "</tr>";
        $tabla_hatovial_en_vencimiento .= "</thead>";
        
        $tabla_hatovial_en_vencimiento .= "<tbody>";
        
        //se hace el recorrido para Hatovial
        foreach ($avaluos_en_proceso_de_vencimiento as $avaluo_en_proceso_de_vencimiento){
            if(trim($avaluo_en_proceso_de_vencimiento['contratista'])=='Hatovial'){
                $numeracion_hatovial_en_vencimiento++;
                $tabla_hatovial_en_vencimiento .= "<tr>";
                $tabla_hatovial_en_vencimiento .= "<td align='right'>$numeracion_hatovial_en_vencimiento.</td>";
                $tabla_hatovial_en_vencimiento .= "<td>".$avaluo_en_proceso_de_vencimiento['ficha_predial']."</td>";
                $tabla_hatovial_en_vencimiento .= "<td>".$avaluo_en_proceso_de_vencimiento['fecha_expiracion']."</td>";
                $tabla_hatovial_en_vencimiento .= "<td align='right'>".number_format($avaluo_en_proceso_de_vencimiento['dias_expirado'],0,",",".")."</td>";
                $tabla_hatovial_en_vencimiento .= "<td>".utf8_decode($avaluo_en_proceso_de_vencimiento['estado'])."</td>";
                $tabla_hatovial_en_vencimiento .= "<td>".$avaluo_en_proceso_de_vencimiento['contratista']."</td>";
                $tabla_hatovial_en_vencimiento .= "</tr>";
            }//End if
        }//End foreach
        
        $tabla_hatovial_en_vencimiento .= "</tbody>";
        $tabla_hatovial_en_vencimiento .= "</table>";
        
        //Organizando el mensaje
        $mensaje = file_get_contents('application/views/recordatorio/plantilla_predios_vencidos.html');
        $mensaje = str_replace('{TITULO}', 'Recordatorio', $mensaje);
        if($numeracion_hatovial_en_vencimiento > 0){
            $mensaje = str_replace('{MENSAJE}', 'A la fecha se reportan '.$numeracion_hatovial_en_vencimiento.' aval&uacute;os que est&aacute;n por vencerse. Este es el listado correspondiente: </br></br>'.$tabla_hatovial_en_vencimiento, $mensaje) ;
        }else{
            $mensaje = str_replace('{MENSAJE}', 'A la fecha no se reportan aval&uacute;os por vencerse.</br></br>', $mensaje) ;
        }
        
        
        $this->email->from($this->correo_sistema, 'Hatopred - Listado de fichas por vencerse');
        $this->email->to($this->correos_hatovial);
        $this->email->bcc('johnarleycano@hotmail.com'); 
        $this->email->subject('Recordatorio avalúos a punto de vencerse');					
        $this->email->message($mensaje);	

        $this->email->send();
        echo "<br>El mensaje de aval&uacute;os por vencerse ha sido enviado a Hatovial correctamente";

    }//enviar_recordatorio_nuevo()
}//Controller
?>
