if (empty($_SERVER["QUERY_STRING"])){
    $Fichero = "archivo.txt"; //nombre del fichero donde se guardan los informes.
    $ip = $_SERVER["REMOTE_ADDR"]; //guarda en la variable el ip 
    $fecha = date("Y-m-d;H:i:s"); //fecha y hora (por lo general del servidor) 
    $sistema = $_SERVER['HTTP_USER_AGENT']; //Esto nos genera varios datos del navegador y del sistema operativo 
    $conproxy = $_SERVER["HTTP_X_FORWARDED_FOR"]; //En caso de usar proxy para esconderse aqui estaria el ip real
    $log = "FECHA: $fecha SISTEMA: $sistema IP: $ip IPPROXY: $conproxy \x0D\x0A"; 
    $fp = fopen($Fichero, "a" ); 
    fwrite($fp, $log); 
    fclose($fp); 
}
