<?php
//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Modelo que trae la gestión predial
$predios = $this->InformesDAO->obtener_informe_gestion_predial(); 

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Predial - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Gestión predial")
	->setDescription("Gestión predial")
	->setKeywords("gestion predial predios")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); 

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0,90); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0,70); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0,70); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,90); //Abajo

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();

/**
 * Estilos
 */
//Estilo de los titulos
$titulo_centrado_negrita = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$titulo_centrado = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$titulo_izquierdo = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
	)
);

$titulo_derecho = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
	)
);

//Estilo de los bordes
$bordes = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'argb' => '000000'
            )
        ),
    ),
);

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(100);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
$objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
$objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
$objPHPExcel->getActiveSheet()->mergeCells('D1:D2');
$objPHPExcel->getActiveSheet()->mergeCells('E1:E2');
$objPHPExcel->getActiveSheet()->mergeCells('F1:F2');
$objPHPExcel->getActiveSheet()->mergeCells('G1:G2');
$objPHPExcel->getActiveSheet()->mergeCells('H1:H2');
$objPHPExcel->getActiveSheet()->mergeCells('I1:J1');
$objPHPExcel->getActiveSheet()->mergeCells('K1:N1');
$objPHPExcel->getActiveSheet()->mergeCells('O1:Q1');
$objPHPExcel->getActiveSheet()->mergeCells('R1:T1');
$objPHPExcel->getActiveSheet()->mergeCells('V1:V2');
$objPHPExcel->getActiveSheet()->mergeCells('U1:U2');
$objPHPExcel->getActiveSheet()->mergeCells('W1:W2');
$objPHPExcel->getActiveSheet()->mergeCells('X1:X2');
$objPHPExcel->getActiveSheet()->mergeCells('Y1:Y2');
$objPHPExcel->getActiveSheet()->mergeCells('Z1:Z2');
$objPHPExcel->getActiveSheet()->mergeCells('AA1:AA2');
$objPHPExcel->getActiveSheet()->mergeCells('AB1:AB2');

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:AB2')->applyFromArray($titulo_centrado_negrita);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Nro.');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Ficha');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Propietario');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Abscisa inicial');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Abscisa final');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Área total adquirida');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Área construcciones m2');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Fecha plano aprobado');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Avalúo');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Fecha de entrega del avalúo');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Valor avalúo');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Oferta');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Fecha de oferta');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Personal');
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'Edicto');
$objPHPExcel->getActiveSheet()->setCellValue('N2', 'Fecha vencimiento de la oferta');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Aceptación oferta');
$objPHPExcel->getActiveSheet()->setCellValue('O2', 'Si');
$objPHPExcel->getActiveSheet()->setCellValue('P2', 'No');
$objPHPExcel->getActiveSheet()->setCellValue('Q2', 'Fecha probable de enrega voluntaria del inmueble');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Expropiación');
$objPHPExcel->getActiveSheet()->setCellValue('R2', 'Resolución');
$objPHPExcel->getActiveSheet()->setCellValue('S2', 'Fecha de notificación');
$objPHPExcel->getActiveSheet()->setCellValue('T2', 'Fecha probable de entrega del inmueble');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Fecha promesa');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Valor anticipo');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'Saldo');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'Total pagado');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'Valor m2');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'No. escritura fecha notaria');
$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'Estado del proceso');
$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'Observaciones');

//Se declara fila
$fila = 3;
$numero = 1;

//Se recorren los predios
foreach ($predios as $predio) {
	//Estilos
	$objPHPExcel->getActiveSheet()->getStyle("J{$fila}")->getNumberFormat()->setFormatCode("$#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("V{$fila}")->getNumberFormat()->setFormatCode("$#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("W{$fila}")->getNumberFormat()->setFormatCode("$#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("X{$fila}")->getNumberFormat()->setFormatCode("$#,##0");
	$objPHPExcel->getActiveSheet()->getStyle("Y{$fila}")->getNumberFormat()->setFormatCode("$#,##0");
	
	// Para el abscisado inicial
	$ms_inicial = substr($predio->abscisa_inicial, -3);
	$kms_inicial = substr($predio->abscisa_inicial, 0, strlen($predio->abscisa_inicial) - 3);
	if($kms_inicial == "") {
		$kms_inicial = "0";
	}

	// Para el abscisado inicial
	$ms_final = substr($predio->abscisa_final, -3);
	$kms_final = substr($predio->abscisa_final, 0, strlen($predio->abscisa_final) - 3);
	if($kms_final == "") {
		$kms_final = "0";
	}

	// Fecha plano aprobado
	$fecha_plano_aprobado = explode(" ", $predio->fecha_plano_aprobado);
	if($fecha_plano_aprobado[0] != '0000-00-00') {
		$fecha_plano_aprobado = $fecha_plano_aprobado[0];
	}else{
		$fecha_plano_aprobado = "";
	}

	// Fecha de entrega del avalúo
	$fecha_entrega_avaluo = explode(" ", $predio->fecha_entrega_avaluo);
	if($fecha_entrega_avaluo[0] != '0000-00-00') {
		$fecha_entrega_avaluo = $fecha_entrega_avaluo[0];
	}else{
		$fecha_entrega_avaluo = "";
	}

	// Fecha de oferta
	$fecha_oferta = explode(" ", $predio->fecha_de_oferta);
	if($fecha_oferta[0] != '0000-00-00') {
		$fecha_oferta = $fecha_oferta[0];
	}else{
		$fecha_oferta = "";
	}

	// Fecha notificación
	$fecha_notificacion = explode(" ", $predio->fecha_notificacion);
	if($fecha_notificacion[0] != '0000-00-00') {
		$fecha_notificacion2 = $fecha_notificacion[0];
	}else{
		$fecha_notificacion2 = "";
	}
	
	// Fecha de vencimiento
	$fecha_vencimiento = explode(" ", $predio->fecha_vencimiento_oferta);
	if($fecha_vencimiento[0] != '0000-00-00') {
		$fecha_vencimiento = $fecha_vencimiento[0];
	}else{
		$fecha_vencimiento = "";
	}

	// Fecha de entrega
	$fecha_entrega_inmueble = explode(" ", $predio->fecha_entrega_inmueble);
	if($fecha_entrega_inmueble[0] != '0000-00-00' && $fecha_notificacion[0] == '0000-00-00') {
		$fecha_entrega_inmueble = $fecha_entrega_inmueble[0];
	}else{
		$fecha_entrega_inmueble = "";
	}

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $numero++);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $predio->no_predio);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, utf8_decode($predio->nombre));
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "K".$kms_inicial."+".$ms_inicial);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "K".$kms_final."+".$ms_final);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, number_format($predio->area_total_adquirida, 0, '', '.'));
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, number_format($predio->area_construcciones, 0, '', '.'));
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $fecha_plano_aprobado);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $fecha_entrega_avaluo);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $predio->valor_avaluo);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $fecha_oferta);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $predio->personal);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "");
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $fecha_vencimiento);
	if($fecha_notificacion[0] == '0000-00-00') {
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "X");
	}else{
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, "X");
	}
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $fecha_entrega_inmueble);
	$objPHPExcel->getActiveSheet()->setCellValue('R'.$fila, "");
	$objPHPExcel->getActiveSheet()->setCellValue('S'.$fila, $fecha_notificacion2);
	if($fecha_entrega_inmueble[0] != '0000-00-00' && $fecha_notificacion[0] != '0000-00-00') {
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$fila, $fecha_entrega_inmueble[0]);
	}
	$objPHPExcel->getActiveSheet()->setCellValue('U'.$fila, "");
	$objPHPExcel->getActiveSheet()->setCellValue('V'.$fila, $predio->valor_anticipo);
	$objPHPExcel->getActiveSheet()->setCellValue('W'.$fila, $predio->saldo);
	$objPHPExcel->getActiveSheet()->setCellValue('X'.$fila, $predio->total_pagado);
	$objPHPExcel->getActiveSheet()->setCellValue('Y'.$fila, $predio->valor_metro_cuadrado);
	$objPHPExcel->getActiveSheet()->setCellValue('Z'.$fila, $predio->numero_escritura);
	$objPHPExcel->getActiveSheet()->setCellValue('AA'.$fila, $predio->estado_proceso);
	$objPHPExcel->getActiveSheet()->setCellValue('AB'.$fila, utf8_decode($predio->observacion));

	//Se aumenta la fila y el contador
	$fila++;
} // foreach predios

//Bordes
$objPHPExcel->getActiveSheet()->getStyle("A1:AB2")->applyFromArray($bordes);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Gestión predial");


//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Gestión predial.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>