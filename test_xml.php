<?php

$xml = new XMLWriter();
$xml->openMemory();
$xml->setIndent(true);
$xml->setIndentString('	'); 
$xml->startDocument('1.0', 'UTF-8');
 
$xml->startElement("colegio"); //elemento colegio
   $xml->writeAttribute('Ciudad', 'Valencia');
   $xml->writeAttribute('Municipio', 'Puerto de Sagunto');
   $xml->writeAttribute('Nombre', 'Maestro Tarrazona');
 
   $xml->startElement("director"); //elemento director
   $xml->writeAttribute('edad', '38');
   $xml->text('Nombre del director');
   $xml->endElement(); //fin director
 
   $xml->startElement("curso"); //elemento curso
      $xml->writeAttribute('nivel', '4');
      $xml->writeElement("aulas", 3);
      $xml->writeElement("profesores", "4");
      $xml->writeElement("alumnos", "70");
      $xml->writeElement("profesores de refuerzo", 1);
 
      $xml->startElement("profesores"); //elemento profesores
         $xml->writeElement("nombre", "Nombre inventado 1");
         $xml->writeElement("nombre", "Nombre inventado 2");
         $xml->writeElement("nombre", "Nombre inventado 3");
         $xml->writeElement("nombre", "Nombre inventado 4");
      $xml->endElement(); //fin elemento profesores
 
      $xml->startElement("alumnos"); //elemento alumnos
         $xml->startElement("clase"); //elemento responsable
            $xml->writeAttribute('id', "Clase A");
            $xml->startElement("alumno"); //elemento alumno
               $xml->writeAttribute('dni', "xxxxxxxx-P");
               $xml->writeElement("Nombre", "Alumno nombre 1");
               $xml->writeElement("genero", "Masculino");
            $xml->endElement(); //fin alumno
            $writer->startElementNS('ex', 'dom', 'http://ws.apache.org/xmlrpc/namespaces/extensions');
            $xml->endElement(); //fin alumno	

         $xml->endElement(); //fin clase
 
         $xml->startElement("clase"); //elemento responsable
            $xml->writeAttribute('id', "Clase B");
            $xml->startElement("alumno"); //elemento alumno
               $xml->writeAttribute('dni', "xxxxxxxx-Z");
               $xml->writeElement("Nombre", "Alumno nombre 3");
               $xml->writeElement("genero", "Masculino");
            $xml->endElement(); //fin alumno
         $xml->endElement(); //fin clase
      $xml->endElement(); //fin elemento alumnos
   $xml->endElement(); //fin curso
$xml->endElement(); //fin colegio
 
$content = $xml->outputMemory();
ob_end_clean();
ob_start();
header('Content-Type: application/xml; charset=UTF-8');
header('Content-Encoding: UTF-8');
header("Content-Disposition: attachment;filename=ejemplo.xml");
header('Expires: 0');
header('Pragma: cache');
header('Cache-Control: private');
echo $content;

?>