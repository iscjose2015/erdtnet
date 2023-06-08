<?php

function redondear_dos_decimal($valor) {
   $float_redondeado=round($valor * 100) / 100;
   return $float_redondeado;
}


echo redondear_dos_decimal(327773.643);


?>