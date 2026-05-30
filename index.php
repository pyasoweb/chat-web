function get_real_ip()
{
    $ip=FALSE;
         // IP del cliente o ninguno
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
         // Dirección IP real de múltiples servidores de proxy (posiblemente falsificación), si no usa el agente, este campo está vacío
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
        for ($i = 0; $i < count($ips); $i++) {
            if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
         // IP del cliente o (última) IP del servidor proxy
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
