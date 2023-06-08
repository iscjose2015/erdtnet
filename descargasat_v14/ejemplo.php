<?php
include_once 'lib/vendor/autoload.php';
require_once 'lib/Descargasat.php';

/**
 * CONFIGURACIÓN DE CONEXIÓN AL SAT
 */
$rutaCer = "certificados/00001000000503367563.cer"; // ruta del certificado FIEL
$rutaKey = "certificados/CSD_Fijaciones_FIN180514K70_20200228_175112.key"; // ruta de la llave privada FIEL
$contrasenaFiel = "F1ja18K7"; // contraseña de la FIEL

// instanciamos la libreria DescargaSAT
$descargaSAT = new Descargasat();

// intentamos conectar al SAT mediante la FIEL
$descargaSAT->conectarPorFiel($rutaKey, $rutaCer, $contrasenaFiel);

/**
 * FILTROS DE BÚSQUEDA
 */
$fechaInicial = "2022-01-01"; // fecha inicial de la consulta en formato yyyy-mm-dd
$fechaFinal = "2022-01-05";
$tipoDescarga = "recibidos"; // opciones posibles [emitidos, recibidos]
$estatus = "todos"; // opciones posibles: [todos, vigentes, cancelados]

// preparamos la consulta
$consulta = $descargaSAT->consultarPorFecha($fechaInicial, $fechaFinal, $tipoDescarga, $estatus);

// obtenemos la lista
$lista = $descargaSAT->listaPorPeriodo($consulta);

// imprimimos en pantalla de cada uno de los cfdis consultados (aun no se descargan)
foreach ($lista as $cfdi) {
    dump($cfdi);
    // para leer cada registro:
    echo "El UUID es: " . $cfdi['uuid'];
    echo "<br>";
    echo $cfdi['emisor']['rfc'] . " - " . $cfdi['emisor']['nombre'];
    echo "<br>";
    echo $cfdi['receptor']['rfc'] . " - " . $cfdi['receptor']['nombre'];
}

/**
 * CONFIGURAMOS LAS RUTAS DE DESCARGA
 */
$rutas = array(
    'xmls'          => 'descargas',
    'pdfs'          => 'descargas',
    'solicitudes'   => 'solicitudes_cancelacion',
    'acuses'        => 'acuses_cancelacion'
);

// obtenemos la ruta del directorio donde descargamos los XMLs
$xmlsDescargados = $descargaSAT->descargarXMLs( $rutas['xmls'], 10 );

// obtenemos la ruta del directorio donde descargamos los PDFs
$pdfsDescargados = $descargaSAT->descargarPDFs( $rutas['pdfs'], 10 );

// obtenemos la ruta del directorio donde descargamos los recibos de solicitud de cancelación
$solicidesCancelacion = $descargaSAT->descargarSolicitudesCancelacion( $rutas['solicitudes'] );

// obtenemos la ruta del directorio donde descargamos los acuses de cancelación
$acusesCancelacion = $descargaSAT->descargarAcusesCancelacion( $rutas['acuses'] );

echo "<h4>Los XMLs descargados fueron:</h4>";
dump($xmlsDescargados);

echo "<h4>Los PDFs descargados fueron:</h4>";
dump($pdfsDescargados);

echo "<h4>Las solicitudes de cancelacion descargados fueron:</h4>";
dump($solicidesCancelacion);

echo "<h4>Los acuses de cancelacion descargados fueron:</h4>";
dump($acusesCancelacion);

/**
 * EJEMPLO PARA RECORRER LOS RESULTADOS DE DESCARGAS
 */
foreach ( $xmlsDescargados as $xml ) {
    echo "El UUID {$xml['uuid']} SE DESCARGÓ EN {$xml['ruta']}" . "<br>";
}

// happy coding :)