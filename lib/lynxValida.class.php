<?php
class lynxValida {
    /**
     * Cadena de caracteres
     *
     * @var string
     */
    protected $cadena;
    /**
     * Asigna valor a la cadena
     *
     * @param string $cadena
     * @return Objeto
     */
    public function setCadena($cadena) {
        $this->cadena=$cadena;
        return $this;
    }
    /**
     * Retorna el valor de la cadena
     *
     * @return string
     */
    public function getCadena() {
        return $this->cadena;
    }
    /**
     * Funcion constructora
     *
     */
    function __construct() {
        $this->setCadena("");
    }
    /**
     * retrona una cadena sin caracteres especiales ni acentos
     *
     * @param string $textinput
     * @param integer $cleanup
     * @example
     * $cleanup == 0 solo numero y letras (default = 0)
     * $cleanup == 1 solo letras
     * $cleanup == 2 solo numeros
     * $cleanup == 3 sin espacios
     * $wrapspace_after == wraps strings after a specified stringlength if ask for (default = 5000)
     * bei $cleanup == 3 / no wrapping
     * @param unknown_type $wrapspace_after
     * @return unknown
     */
    public function limpiaCadena($textinput,$cleanup="0") {
        switch ($cleanup) {
            case 0:
                $textinput = str_replace(array('.'), "",$textinput);
                //$textinput = preg_replace('/\W/', ' ', $textinput);
                $clean = @eregi_replace("¿|!|¡|¼|À|Á|Â|Ã|Ä|Å|à|á|â|ã|ä|å|Ò|Ó|Ô|Õ|Ö|Ø|ò|ó|ô|õ|ö|ø|È|É|Ê|Ë|è|é|ê|ë|Ç|ç|Ì|Í|Î|Ï|ì|í|î|ï|Ù|Ú|Û|Ü|ù|ú|û|ü|ÿ|Ñ|ñ|#|:|;|,|'|%","",$textinput);
                $clean = @trim(eregi_replace("[[:space:]]", "",$clean));
                $clean = @eregi_replace ("/^[a-zd_-]","",$clean);
                return stripslashes($clean);
                break;
            case 1:
                $clean = eregi_replace ("[[:digit:][:punct:]]","",$clean);
                return stripslashes($clean);
                break;
            case 2:
                $clean = eregi_replace ("[[:alpha:][:punct:]]","",$textinput);
                return stripslashes($clean);
                break;
            case 3:
                $clean = trim(eregi_replace("[[:space:]]", "" , $textinput));
                return stripslashes($clean);
                break;
           
            default:
                return stripslashes($textinput);
                break;
        }
    }
    /** Retorna el numero de caracteres de una cadena
     *
     * @param sring $cadena
     * @return unknown
     */
    public function numCaracter($cadena) {
        $cadena = trim($cadena);
        $this->setCadena($cadena);
        $cadena = strlen($cadena);
        return $cadena;
    }
    /** Determina si la cadena esta vacia o no
     *
     * @param string $cadena
     * @return true/false TRUE si la cadena esta llena, FALSE si la cadena esta vacia
     */
    public function vacioCadena($cadena) {

        if ($this->numCaracter($cadena)!=0) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * Prepara el nombre de un archivo antes de ser subida al servidor
     *
     * @param string $nomb_imagen
     * @return string
     */
    public function preparaArchivo($nomb_imagen,$num_caracter=10) {
        $path_info = pathinfo($nomb_imagen);
        $ext = ".".$path_info["extension"];
        $nomb_nuevo = $nomb_imagen;
        $nomb_nuevo = str_replace($ext,'',$nomb_nuevo);
        $nomb_nuevo = $this->limpiaCadena($nomb_nuevo);
        $nomb_nuevo = substr($nomb_nuevo,0,$num_caracter);
        return  strtolower($nomb_nuevo).strtolower($ext);

    }
    /**
     * Generador de clave
     *
     * @return string
     */
    public function generadorClave() {
        return  $password = substr(md5(rand(100000, 999999)), 0, 6);
    }
    /**
     * Funcion cuenta palabras
     *
     * @param string $texto
     * @param integer $limit
     * @return array
     */
    public function cuentaPalabra($texto,$limit) {
        $text = "";
        $words = 0;
        $tok = strtok ($texto," ");
        while (printf(" %a",$tok)) {
            $text .= " $tok";
            $words++;
            if($words == $limit) {
                return $text; //imprime el texto
                break;
            }
            $tok = strtok (" ");
        }
    }
    /**
     * Eliminar una carpeta
     *
     * @param string $directorio
     */
    public function borraDirectorio($directorio) {
        $dir_handle = opendir($directorio);
        if ($dir_handle) {
            while($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($directorio."/".$file)) {
                        unlink($directorio."/".$file);
                    }else {
                        $a=$directorio.'/'.$file;
                        $this->borraDirectorio($a);
                        rmdir($a);
                    }
                }
            }
            closedir($dir_handle);
            rmdir($directorio);
        }
    }

    public function convierteEnUrl($cadena,$siUrl=true) {
        $cadena = ucwords(strtolower(trim($cadena)));
        if($siUrl) {
            //constantes de limpieza de titulo url
            $arr_busca = array(' ','á','à','â','ã','ª','Á','À',
                    'Â','Ã', 'é','è','ê','É','È','Ê','í','ì','î','Í',
                    'Ì','Î','ò','ó','ô', 'õ','º','Ó','Ò','Ô','Õ','ú',
                    'ù','û','Ú','Ù','Û','ç','Ç','Ñ','ñ',':','_','/','@','.','#','&',';','(',')','[',']','{','}','=','+','$','?','\'');
            $arr_susti = array('','a','a','a','a','a','A','A',
                    'A','A','e','e','e','E','E','E','i','i','i','I','I',
                    'I','o','o','o','o','o','O','O','O','O','u','u','u',
                    'U','U','U','c','C','N','n','-','','','','','','','');
        }else {
            //constantes de limpieza de titulo url
            $arr_busca = array(' ',':','_','/','@','.','#',',');
            $arr_susti = array('+','-','','','','.','','');
        }

        $nueva_cadena = str_replace($arr_busca,$arr_susti,$cadena);
        //return $nueva_cadena;
        return  $this->limpiaCadena($nueva_cadena);
    }

    public function quitaNumeros()
    {
        $cadena = ucwords(strtolower(trim($cadena)));        
        //constantes de limpieza de titulo url
        $arr_busca = array('1','2','3','4','5','6','7','8','9','0');
        $arr_susti = array('','','','','','','','','','');

        $nueva_cadena = str_replace($arr_busca,$arr_susti,$cadena);
        //return $nueva_cadena;
        return  $this->limpiaCadena($nueva_cadena);
    }


    public function extraerCodigoTitulo($titulo) {
        $arreglo = explode('-',$titulo);
        //print_r($arreglo);
        if(count($arreglo) > 2)
        {
            $ultimo_dato = count($arreglo) - 2;
            $codigo = $arreglo[0];
        }else{
            $ultimo_dato = count($arreglo) - 2;
            $codigo = $arreglo[$ultimo_dato];
        }
        
        //$ultimo_dato = count($arreglo) - 2;
        //$codigo = $arreglo[$ultimo_dato];
        //echo "<br>".$codigo ;
        //return $codigo = $arreglo[$ultimo_dato];
        return $codigo ;
    }
    
    function getYouTubeIdFromURL($url)
    {
      $url_string = parse_url($url, PHP_URL_QUERY);
      parse_str($url_string, $args);
      return isset($args['v']) ? $args['v'] : false;
    }
    
    function getYoutubeID($url) {
        $tube = parse_url($url);
        if ($tube["path"] == "/watch") {
            parse_str($tube["query"], $query);
            $id = $query["v"];
        } else {
            $id = "";   
        }
        return $id;
    }
    
    public static function formatoFechaPT($fecha)
    {
        $fecha = explode('/',$fecha);
        $fecha = $fecha['2'].'-'.$fecha['1'].'-'.$fecha['0'];
        return $fecha ;
    }
    
    function formatoFechaPT2($fecha)
    {
        $fecha = explode('-',$fecha);
        $fecha = $fecha['2'].'-'.$fecha['1'].'-'.$fecha['0'];
        if($fecha['2'])
        {
            return $fecha;
        }else{
            return '' ;
        }
    }
    function formatoFechaMySQL($fecha)
    {
        $fecha = explode('-',$fecha);
        $fecha = $fecha['2'].'-'.$fecha['1'].'-'.$fecha['0'];
        if($fecha)
        {
            return $fecha;
        }else{
            return '' ;
        }
    }
    
        
    function formatoFechaPTByMySql($fecha)
    {
        $fecha = explode('-',$fecha);
        $dia = $fecha['2'];
        $fecha = $fecha['2'].'-'.$fecha['1'].'-'.$fecha['0'];
        return $fecha;
    }
    
    function getRealIP() 
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }
    
    function getHoraActual()
    {
        $hora = getdate(time());
        return $hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"] ; 
    }
    
    public static function datosTipoUsuario($id_user, $tipo_usuario = '')
    {
        if(!$tipo_usuario)
        {
            $tipo_usuario = LxUserPeer::getCurrentPassword($id_user);
            $tipo_usuario = $tipo_usuario->getIdTipoUsuario();
        } 
        
        switch ($tipo_usuario) {
            case 2:
                $data = CadastroFisicaPeer::getNamePessoa($id_user);
                break;
            case 3:
                $data = CadastroJuridicaPeer::getNameJuridico($id_user);
                break;
        }
        return $data;
    }
    
    public function setCredentialUser($user)
    {
        $profile = LxProfilePeer::retrieveByPK(sfContext::getInstance()->getUser()->getAttribute('idProfile'));
        if($user == 1 || $user ==2) {
            sfContext::getInstance()->getUser()->addCredential('admin_lynx');           
        }else{
            sfContext::getInstance()->getUser()->addCredential($profile->getPermalink());
        }
    }
    
    public static function nombreMes($nMes)
    {
        switch ($nMes) {
                case "01":    $mes = Janeiro;     break;
                case "02":    $mes = Fevereiro;   break;
                case "03":    $mes = Março;       break;
                case "04":    $mes = Abril;       break;
                case "05":    $mes = Maio;        break;
                case "06":    $mes = Junho;       break;
                case "07":    $mes = Julho;       break;
                case "08":    $mes = Agosto;      break;
                case "09":    $mes = Setembro;    break;
                case "10":    $mes = Outubro;     break;
                case "11":    $mes = Novembro;    break;
                case "12":    $mes = Dezembro;    break; 
         }
         return $mes;
    }
    
    public static function nombreMesShort($nMes)
    {
        switch ($nMes) {
                case "01":    $mes = Jan;     break;
                case "02":    $mes = Fev;   break;
                case "03":    $mes = Mar;       break;
                case "04":    $mes = Abr;       break;
                case "05":    $mes = Maio;        break;
                case "06":    $mes = Jun;       break;
                case "07":    $mes = Jul;       break;
                case "08":    $mes = Ago;      break;
                case "09":    $mes = Set;    break;
                case "10":    $mes = Out;     break;
                case "11":    $mes = Nov;    break;
                case "12":    $mes = Dez;    break; 
         }
         return $mes;
    }
            
    
}

?>
