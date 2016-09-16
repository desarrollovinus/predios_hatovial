<?php
//Tipo seleccionado
$tipo = $this->uri->segment(3);

//Modelo que trae los avalúos
$avaluos = $this->InformesDAO->obtener_avaluos($tipo); 

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Predial - Generado el ".$this->InformesDAO->formatear_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Listado de Avalúos")
	->setDescription("Listado de avalúos de predios requeridos y no requeridos")
	->setKeywords("avaluos requeridos no requeridos hatovial")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(7); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); 

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);

//Celdas a combinar
// $objPHPExcel->getActiveSheet()->mergeCells('A1:Q3');

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($titulo_centrado_negrita);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Nro.');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Ficha');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Número catastral');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Primer propietario');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Envío del evaluador');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Radicado');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Valor m2');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Área');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Valor terreno');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Valor total');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Estado');

//Se declara fila
$fila = 2;
$numero = 1;

//Se recorren los avalúos
foreach ($avaluos as $avaluo) {
	//Estilos
	$objPHPExcel->getActiveSheet()->getStyle("H{$fila}")->getNumberFormat()->setFormatCode("$#,##0.00");
	$objPHPExcel->getActiveSheet()->getStyle("J{$fila}")->getNumberFormat()->setFormatCode("$#,##0.00");
	$objPHPExcel->getActiveSheet()->getStyle("k{$fila}")->getNumberFormat()->setFormatCode("$#,##0.00");
	
	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $numero);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $avaluo->ficha);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $avaluo->numero_catastral);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $avaluo->primer_propietario);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $avaluo->envio_avaluador);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $avaluo->radicado_envio);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $avaluo->fecha_recibo);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $avaluo->valor_metro);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $avaluo->area_total);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $avaluo->valor_terreno);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $avaluo->valor_total);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $avaluo->estado);

	//Se aumenta la fila y el contador
	$fila++;
	$numero++;
}//foreach

$fila--;

//Bordes
$objPHPExcel->getActiveSheet()->getStyle("A1:L{$fila}")->applyFromArray($bordes);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Avalúos");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Avalúos.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>