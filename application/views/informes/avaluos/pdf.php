<?php
//Tipo seleccionado
$tipo = $this->uri->segment(3);

//Modelo que trae los avalúos
$avaluos = $this->InformesDAO->obtener_avaluos($tipo); 

// Creacion del objeto de la clase heredada
$pdf = new FPDF('L','mm','Letter');

//Alias para el numero de paginas(numeracion)
$pdf->AliasNbPages();

//Se definen las margenes
$pdf->SetMargins(10, 5, 6);

//Anadir pagina
$pdf->AddPage();

//Fuente
$fuente = 'Arial';

//Parametros adicionales
$pdf->SetAuthor('John Arley Cano - Hatovial S.A.S.');
$pdf->SetTitle('Lista de avalúos - Hatovial S.A.S.');
$pdf->SetCreator('John Arley Cano');

//Títulos
$pdf->SetFont($fuente,'B',8);
$pdf->Cell(7,8, utf8_decode('No.'),1, 0, 'C', 0);
$pdf->Cell(25,8, utf8_decode('Ficha'),1, 0, 'C', 0);
$pdf->Cell(25,8, utf8_decode('Nro. Catastral'),1, 0, 'C', 0);
$pdf->Cell(45,8, utf8_decode('Primer propietario'),1, 0, 'C', 0);
$pdf->Cell(15,8, utf8_decode('Evaluador'),1, 0, 'C', 0);
$pdf->Cell(30,8, utf8_decode('Radicado'),1, 0, 'C', 0);
$pdf->Cell(15,8, utf8_decode('Fecha'),1, 0, 'C', 0);
$pdf->Cell(13,8, utf8_decode('Valor m2'),1, 0, 'C', 0);
$pdf->Cell(12,8, utf8_decode('Área'),1, 0, 'C', 0);
$pdf->Cell(20,8, utf8_decode('Valor terreno'),1, 0, 'C', 0);
$pdf->Cell(20,8, utf8_decode('Valor total'),1, 0, 'C', 0);
$pdf->Cell(28,8, utf8_decode('Estado'),1, 0, 'C', 0);
$pdf->Ln();

//Contenido
$pdf->SetFont($fuente,'',6);
$numero = 1;

//Se recorren los avalúos
foreach ($avaluos as $avaluo) {
	$pdf->Cell(7,5, utf8_decode($numero),1, 0, 'R', 0);
	$pdf->Cell(25,5, utf8_decode( substr($avaluo->ficha, 0, 18)),1, 0, 'L', 0);
	$pdf->Cell(25,5, utf8_decode( substr($avaluo->numero_catastral, 0, 18)),1, 0, 'L', 0);
	$pdf->Cell(45,5, utf8_decode( substr($avaluo->primer_propietario, 0, 30)),1, 0, 'L', 0);
	$pdf->Cell(15,5, utf8_decode( substr($avaluo->envio_avaluador, 0, 30)),1, 0, 'L', 0);
	$pdf->Cell(30,5, utf8_decode( substr($avaluo->radicado_envio, 0, 26)),1, 0, 'L', 0);
	$pdf->Cell(15,5, utf8_decode( substr($avaluo->fecha_recibo, 0, 30)),1, 0, 'L', 0);
	$pdf->Cell(13,5, utf8_decode( "$".number_format($avaluo->valor_metro, 0, ',', '.')),1, 0, 'R', 0);
	$pdf->Cell(12,5, utf8_decode( number_format($avaluo->area_total, 2, ',', '.')),1, 0, 'R', 0);
	$pdf->Cell(20,5, utf8_decode( "$".number_format($avaluo->valor_terreno, 0, ',', '.')),1, 0, 'R', 0);
	$pdf->Cell(20,5, utf8_decode( "$".number_format($avaluo->valor_total, 0, ',', '.')),1, 0, 'R', 0);
	$pdf->Cell(28,5, utf8_decode( substr($avaluo->estado, 0, 30)),1, 0, 'L', 0);
	$pdf->Ln();

	$numero++;
}//foreach










$pdf->Output('Avalúos.pdf', 'I');
?>