<?php
date_default_timezone_set('America/Bogota');
function tokenhmacsha1($susc_id){
$tiempo = floor(time()/30);
$arrTiempo = array(0,0,0,0,0,0,0,0);
$truncado = array(0,0,0,0,0,0,0,0);
$tiempoStr = dechex($tiempo);
while(strlen($tiempoStr) < 8){
$tiempoStr = '0'.$tiempoStr;
}
$arrTiempo[0] = 0;
$arrTiempo[1] = 0;
$arrTiempo[2] = 0;
$arrTiempo[3] = 0;
$arrTiempo[4] = hexdec(substr($tiempoStr,-8,2));
$arrTiempo[5] = hexdec(substr($tiempoStr,-6,2));
$arrTiempo[6] = hexdec(substr($tiempoStr,-4,2));
$arrTiempo[7] = hexdec(substr($tiempoStr,-2,2));
$tiempoStr = '';
foreach($arrTiempo as $valor){
$tiempoStr .= chr($valor);
}
$hash = hash_hmac('sha1',$tiempoStr,$susc_id);
$desfase = hexdec($hash[40 - 1]) * 2;
for ($j = 0; $j < 8; ++$j) {
$truncado[$j] = $hash[$desfase + $j];
}
$tokenStr = '';
$truncadoTemp = hexdec($truncado[0]) & 7;
$truncado[0] = dechex($truncadoTemp);
for($i = 0; $i < 8; $i++){
$tokenStr .= $truncado[$i];
}
//$cadenasel = $tokenStr;
$tokenInt = hexdec($tokenStr);
$tokenStr = bcmod($tokenInt, '1000000');
//$tokenStr = $tokenInt%1000000;
$tokenStr = sprintf("%06ld", $tokenStr);
137
$tokenStr = (string)$tokenStr;
return $tokenStr;
}
?>