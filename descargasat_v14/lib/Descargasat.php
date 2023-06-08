<?php
use PhpCfdi\CfdiSatScraper\SatScraper;
use PhpCfdi\CfdiSatScraper\Sessions\Fiel\FielSessionManager;
use PhpCfdi\CfdiSatScraper\Sessions\Fiel\FielSessionData;
use PhpCfdi\Credentials\Credential;
use PhpCfdi\CfdiSatScraper\QueryByFilters;
use PhpCfdi\CfdiSatScraper\Filters\Options\ComplementsOption;
use PhpCfdi\CfdiSatScraper\Filters\DownloadType;
use PhpCfdi\CfdiSatScraper\Filters\Options\StatesVoucherOption;
use PhpCfdi\CfdiSatScraper\Filters\Options\RfcOption;
use PhpCfdi\CfdiSatScraper\ResourceType;
use PhpCfdi\CfdiSatScraper\Sessions\Ciec\CiecSessionManager;
use PhpCfdi\ImageCaptchaResolver\CaptchaResolverInterface;

include_once 'vendor/autoload.php';

class Descargasat
{

    public $credencial;
    public $controlador;
    public $listaRecursos;

    /**
     * @param $rutaKey string Ruta del archivo .key correspondiente a la FIEL
     * @param $rutaCer string Ruta del archivo .cer correspondiente a la FIEL
     * @param $password string Contraseña de la FIEL
     * @return void
     * @throws Exception
     */
    public function conectarPorFiel( $rutaKey = '', $rutaCer = '', $password = '' ) {
            $certificate = file_get_contents($rutaCer);
            $privateKey = file_get_contents($rutaKey);
            $this->credencial = Credential::create($certificate, $privateKey, $password);

            if (! $this->credencial->isFiel()) {
                throw new Exception('Los certificados no corresponden a una FIEL.');
            }
            if (! $this->credencial->certificate()->validOn()) {
                throw new Exception('El certificado no está vigente.');
            }

            $this->controlador = new SatScraper(FielSessionManager::create($this->credencial));
    }

    /**
     * @param $fechaInicial string Fecha inicial de la consulta en formato yyyy-mm-dd
     * @param $fechaFinal string Fecha final de la consulta en formato yyyy-mm-dd
     * @param $tipoDescarga string Indica la consulta de CFDIs emitidos o recibidos. Puedes utilizar: "emitidos" ó "recibidos"
     * @param $estatus string Permite el filtrado por estatus del CFDI. Puedes utilizar: "todos", "vigentes", "cancelados".
     * @return QueryByFilters
     * @throws Exception
     */
    public function consultarPorFecha( $fechaInicial, $fechaFinal, $tipoDescarga = "emitidos", $estatus = "todos" ) {
        $tipoConsulta = ($tipoDescarga == "emitidos") ? DownloadType::emitidos() : DownloadType::recibidos();

        $consulta = new QueryByFilters(
            new DateTimeImmutable($fechaInicial),
            new DateTimeImmutable($fechaFinal),
            $tipoConsulta
        );

        switch ($estatus) {
            case 'todos':
                $consulta->setStateVoucher( StatesVoucherOption::todos() );
                break;
            case 'vigentes':
                $consulta->setStateVoucher( StatesVoucherOption::vigentes() );
                break;
            case 'cancelados':
                $consulta->setStateVoucher( StatesVoucherOption::cancelados() );
                break;
            default:
                $consulta->setStateVoucher( StatesVoucherOption::todos() );
        }

        return $consulta;
    }

    /**
     * @param QueryByFilters $consulta
     * @return array
     */
    public function listaPorPeriodo( QueryByFilters $consulta ) {
        $this->listaRecursos = $this->controlador->listByPeriod($consulta);
        $arrLista = array();
        foreach ($this->listaRecursos as $cfdi) {
            $arrLista[] = array(
                'uuid' => $cfdi->uuid(),
                'emisor' => array(
                    'rfc' => $cfdi->get('rfcEmisor'),
                    'nombre' => $cfdi->get('nombreEmisor')
                ),
                'receptor' => array(
                    'rfc' => $cfdi->get('rfcReceptor'),
                    'nombre' => $cfdi->get('nombreReceptor')
                ),
                'fechaEmision' => $cfdi->get('fechaEmision'),
                'fechaCertificacion' => $cfdi->get('fechaCertificacion'),
                'pac' => $cfdi->get('pacCertifico'),
                'total' => $cfdi->get('total'),
                'efecto' => $cfdi->get('efectoComprobante'),
                'estadoComprobante' => $cfdi->get('estadoComprobante'),
                'cancelacion' => array(
                    'estatus' => $cfdi->get('estatusCancelacion'),
                    'estatusProceso' => $cfdi->get('estatusProcesoCancelacion'),
                    'fechaProceso' => $cfdi->get('fechaProcesoCancelacion'),
                    'urlSolicitud' => $cfdi->get('urlCancelRequest'),
                    'urlAcuse' => $cfdi->get('urlCancelVoucher')
                )
            );
        }

        return $arrLista;
    }

    /**
     * Descarga localmente los archivos correspondientes a la consulta
     * @param $rutaDescarga
     * @param $descargasSimultaneas
     * @return array
     */
    public function descargarXMLs( $rutaDescarga = "descargas", $descargasSimultaneas = 50 ) {
        if ( !is_dir( $rutaDescarga ) ) {
            mkdir( $rutaDescarga );
        }
        // descarga de cada uno de los CFDI, reporta los descargados en $downloadedUuids
        $listaUUIDs = $this->controlador->resourceDownloader(ResourceType::xml(), $this->listaRecursos)
            ->setConcurrency($descargasSimultaneas)            // cambiar a 50 descargas simultáneas
            ->saveTo($rutaDescarga);                 // ejecutar la instrucción de descarga
        return $this->convertirListaDescargas($listaUUIDs, $rutaDescarga, ".pdf");
    }

    /**
     * Descarga localmente los archivos correspondientes a la consulta
     * @param $rutaDescarga
     * @param $descargasSimultaneas
     * @return array
     */
    public function descargarPDFs( $rutaDescarga = "descargas", $descargasSimultaneas = 50 ) {
        if ( !is_dir( $rutaDescarga ) ) {
            mkdir( $rutaDescarga );
        }
        // descarga de cada uno de los CFDI, reporta los descargados en $downloadedUuids
        $listaUUIDs = $this->controlador->resourceDownloader(ResourceType::pdf(), $this->listaRecursos)
            ->setConcurrency($descargasSimultaneas)            // cambiar a 50 descargas simultáneas
            ->saveTo($rutaDescarga);                 // ejecutar la instrucción de descarga
        return $this->convertirListaDescargas($listaUUIDs, $rutaDescarga, ".pdf");
    }

    /**
     * Descarga localmente los archivos correspondientes a la consulta
     * @param $rutaDescarga
     * @param $descargasSimultaneas
     * @return array
     */
    public function descargarSolicitudesCancelacion( $rutaDescarga = "acuses", $descargasSimultaneas = 50 ) {
        if ( !is_dir( $rutaDescarga ) ) {
            mkdir( $rutaDescarga );
        }
        // descarga de cada uno de los CFDI, reporta los descargados en $downloadedUuids
        $listaUUIDs = $this->controlador->resourceDownloader(ResourceType::cancelRequest(), $this->listaRecursos)
            ->setConcurrency($descargasSimultaneas)            // cambiar a 50 descargas simultáneas
            ->saveTo($rutaDescarga);                 // ejecutar la instrucción de descarga
        return $this->convertirListaDescargas($listaUUIDs, $rutaDescarga, "-cancel-request.pdf");
    }

    /**
     * Descarga localmente los archivos correspondientes a la consulta
     * @param $rutaDescarga
     * @param $descargasSimultaneas
     * @return array
     */
    public function descargarAcusesCancelacion( $rutaDescarga = "acuses", $descargasSimultaneas = 50 ) {
        if ( !is_dir( $rutaDescarga ) ) {
            mkdir( $rutaDescarga );
        }
        // descarga de cada uno de los CFDI, reporta los descargados en $downloadedUuids
        $listaUUIDs = $this->controlador->resourceDownloader(ResourceType::cancelVoucher(), $this->listaRecursos)
            ->setConcurrency($descargasSimultaneas)            // cambiar a 50 descargas simultáneas
            ->saveTo($rutaDescarga);                 // ejecutar la instrucción de descarga
        return $this->convertirListaDescargas($listaUUIDs, $rutaDescarga, "-cancel-voucher.pdf");
    }

    /**
     * Descarga localmente los archivos correspondientes a la consulta
     * @param $rutaDescarga
     * @param $descargasSimultaneas
     * @return array
     */
    private function convertirListaDescargas( $listaUUIDs, $ruta, $sufijo ) {
        $arrLista = array();

        foreach( $listaUUIDs as $uuid ) {
            $arrLista[] = array(
                'uuid' => $uuid,
                'ruta' => $ruta . DIRECTORY_SEPARATOR . $uuid . $sufijo
            ) ;
        }

        return $arrLista;
    }

}