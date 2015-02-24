<?php

class aplication_system {

  static function getUser() {
    return sfContext::getInstance()->getUser()->getAttribute('idUserPanel');
  }
  
  static function getNameUser() {
    return sfContext::getInstance()->getUser()->getAttribute('nameUser');
  }

        //Verifica si se esta logeado con el usuario root
  //retorna true ó false
  static function esUsuarioRoot() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('admin_lynx')) {
      return true;
    } else {
      return false;
    }
  }
  
 static function esAdministrador() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('admin_lynx')) {
      return true;
    } else {
      return false;
    }
  }
  
  static function esFuncionario() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('funcionario')) {
      return true;
    } else {
      return false;
    }
  }
  
  static function esEnviromaq() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('almoxarifado')) {
      return true;
    } else {
      return false;
    }
  }
  
  static function isAllAction() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('admin_lynx') || $user->hasCredential('gerente') || $user->hasCredential('socio')) 
    {
      return true;
    } else {
      return false;
    }
  }
  
    static function isALLGerente() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('gerente_tecnico') || $user->hasCredential('gerente') || $user->hasCredential('gerente_comercial')) 
    {
      return true;
    } else {
      return false;
    }
  }
  
    static function isGerenteTecnicoComercial() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('gerente_tecnico') || $user->hasCredential('gerente_comercial')) 
    {
      return true;
    } else {
      return false;
    }
  }
  
  static function compareUserVsResponsable($responsable) {
    $user = sfContext::getInstance()->getUser();
    if ($user->getAttribute('idUserPanel') == $responsable) 
    {
      return true;
    } else {
      return false;
    }
  }

  //Verifica si se esta logeado como usuario administrador
  //retorna true ó false
  static function esGerente() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('gerente') ) {
      return true;
    } else {
      return false;
    }
  }
  
    //Verifica si se esta logeado como usuario administrador
  //retorna true ó false
  static function esGerenteComercial() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('gerente_comercial') ) {
      return true;
    } else {
      return false;
    }
  }
  
  static function esSocio() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('socio')) {
      return true;
    } else {
      return false;
    }
  }
  
    static function esFabricio() {
    $user = sfContext::getInstance()->getUser();
    if ($user->getAttribute('idUserPanel') == 99) {
      return true;
    } else {
      return false;
    }
  }
  
    static function esRicardo() {
    $user = sfContext::getInstance()->getUser();
    if ($user->getAttribute('idUserPanel') == 42) {
      return true;
    } else {
      return false;
    }
  }


  //Verifica si se esta logeado como usuario franquicia
  //retorna true ó false
  static function esContable() {
    $user = sfContext::getInstance()->getUser();
    if ($user->hasCredential('financiero') || $user->hasCredential('admin_lynx')) {
      return true;
    } else {
      return false;
    }
  }
  
  static public function accessTaskHidratec($object, $gerente)
  {
      echo $object['visual'];
      if(self::esFuncionario() || self::isALLGerente() )
      {
          if(!$object['visual'])
          {
              // es publico
              return true;
          }else{
              // es privada la tarea, verifica si esta en el equipo
              if(aplication_system::compareUserVsResponsable($gerente) || EquipeTarefaPeer::getCheck($object['id'], self::getUser()))
              {
                   return true;
              }else{
                  return false;
                }
          }
      }
      if(self::esUsuarioRoot() || self::esContable() || self::esSocio())
      {
          return true;
      }
      return false;
  }
  
  static public function accessTask($object,$gerente)
  {
      if(self::esFuncionario() || self::isALLGerente() )
      {
        //echo "esFuncionario or isALLGerente";
          if(!$object->getVisualizacao())
          {
            //echo "getVisualizacao";
              // es publico
              return true;
          }else{
            //echo "NOT getVisualizacao";
              // es privada la tarea, verifica si esta en el equipo
              if(aplication_system::compareUserVsResponsable($gerente) || EquipeTarefaPeer::getCheck($object->getCodigoTarefa(), self::getUser()))
              {
                //echo "compareUserVsResponsable";
                  return true;
              }else{
                //echo "NOT compareUserVsResponsable";
                  return false;
                }
          }
      }
      if(self::esUsuarioRoot() || self::esContable() || self::esSocio())
      {
          return true;
      }
      return false;
  }
  
  static public function accessProject($object)
  {
      
      if(self::esFuncionario())
      {
          if(!$object->getVisualizacion())
          {
              // es publico
              return true;
          }else{
              // es privada la tarea, verifica si esta en el equipo
              if(EquipeTarefaPeer::getCheckProjeto($object->getCodigoProjeto(), self::getUser()))
              {
                  return true;
              }
          }
      }
      if(self::esUsuarioRoot() || self::esGerente() || self::esContable() || self::esSocio())
      {
          return true;
      }
      //return false;
      // Se podran ver todos los proyectos y propuestas 
      return true;
  }

  //Retorna el numero de dias que hay entre 2 fechas determinadas
  //Formato fecha date('Y-m-d')
  static function restaFechas($dFecIni, $dFecFin) {
    //86400 es el numero de segundos que hay en 1 dia
    return (strtotime($dFecFin) - strtotime($dFecIni)) / 86400;
  }
  
  /**
    * Validate a date
    *
    * @param    string    $data
    * @param    string    formato
    * @return    bool
  */
  static function validaData($data) {
    try {
        $dt = new DateTime( trim($data) );
    }
    catch( Exception $e ) {
        return false;
    }
    $month = $dt->format('m');
    $day = $dt->format('d');
    $year = $dt->format('Y');
    if( checkdate($month, $day, $year) ) {
        return true;
    }
    else {
        return false;
    }
  }

  //Retorna los archivos de un directorio solo si empiezan por la variable $admitir
  static function getArchivosDirectorio($admitir, $directorio) {
    $items = scandir($directorio);
    $archivos = array();
    foreach ($items as $item) {
      /* Esta instruccion descarta las 2 primeras posiciones del arreglo
        ya que estan traen como dato '.' y '..' */
      //Tambien se descartar los .svn
      if ($item != '.' && $item != '..' && $item != '.svn') {
        $nombre = explode('_', $item); //Separa el nombre del archivo por cada '_'
        if ($nombre[0] == $admitir) {
          $archivos[] = $item;
        } else {
          //Con este if se devuelven la imagenes q no tengan prefijo
          if ($admitir == null && $nombre[0] != 'P') {
            $archivos[] = $item;
          }
        }
      }
    }
    return $archivos;
  }

  //Cuenta los archivos del directorio dado, los divide entre un numero en caso de q se requiera
  //Por ejemplo: Se divide en el caso de las imagenes, se tiene 1 imagen pequeña y 1 grande, pero relmente se tiene 1 imgen en total. 2/2 = 1
  static function countArchivosDirectorio($directorio, $dividirEntre = null) {
    if (is_dir($directorio)) {
      $items = scandir($directorio);
      if ($dividirEntre) {
        //Retorna el numero de archivos encontrado en el directorio, -2 es quitandole el "." y ".."
        $result = (count($items) - 2) / $dividirEntre;
      } else {
        //Retorna el numero de archivos encontrado en el directorio, -2 es quitandole el "." y ".."
        $result = count($items) - 2;
      }

      //Si el resultado es mayor que 0 retorna el resultado del count()
      if ($result >= 0) {
        return $result;
      }
    }
    return 0; //Si no existe el directorio retorna 0
  }

  /*
   * Elimina el directorio $dir aunq este no este vacio
   * param string $dir
   */

  static function deleteDir($dir) {
    if (file_exists($dir)) {
      $iterator = new RecursiveDirectoryIterator($dir);
      foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
        if ($file->isDir()) {
          rmdir($file->getPathname());
        } else {
          unlink($file->getPathname());
        }
      }
      rmdir($dir);
    }
  }

  /*
   * Devuelve un numero segun el idioma en el que se encuentre la aplicacion, sin importar el pais donde se encuentre
   * 1 = español, 2 = ingles, 3 = portugues
   * param string $idioma
   */

  static function getNumeroIdiomaActual() {
    $request = sfContext::getInstance()->getRequest();

    switch ($request->getParameter('idioma')) {
      case 'es':
        return 1;
        break;
      case 'en':
        return 2;
        break;
      case 'pt':
        return 3;
        break;
    }
  }

  //Funcion que genera el permalink para el inmueble
  static function crearPermalink($text) {
    $text = ucwords(strtolower(trim($text)));
    // strip all non word chars
    //$text = preg_replace('/\W/', ' ', $text); BORRADO PORQUE NO FUNCIONABA EN PROD
    $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
    // replace all white space sections with a dash
    $text = preg_replace('/\ +/', '', $text);
    // trim dashes
    $text = preg_replace('/\-$/', '', $text);
    $text = preg_replace('/^\-/', '', $text);

    return $text;
  }

  static function zerofill($num, $zerofill = 3) {
    return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
  }

  //Verifica que una direccion de correo sea valida
  static function correo_valido($correo) {
    $correo = trim($correo);
    if (preg_match("/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/", $correo)) {
      return true;
    }
    return false;
  }

  //Genera una cadena aleatoria alfanumerica
  static function GenerateRandomString($longitud = 10) {

    /* Se valida la longitud proporcionada. Debe ser número y mayor de cero.
      Si es menor o igual a cero le asignamos la longitud por defecto.
      Si es mayor de 32 le asignamos 32.
     */
    if (!is_numeric($longitud) || $longitud <= 0) {
      $longitud = 8;
    }
    if ($longitud > 32) {
      $longitud = 32;
    }

    /* Asignamos el juego de caracteres al array $caracteres para generar la contraseña.
      Podemos añadir más caracteres para hacer más segura la contraseña.
     */
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /* Introduce la semilla del generador de números aleatorios mejorado */
    mt_srand(microtime() * 1000000);
    $cadena = "";
    for ($i = 0; $i < $longitud; $i++) {

      /* Genera un valor aleatorio mejorado con mt_rand, entre 0 y el tamaño del array
        $caracteres menos 1. Posteríormente vamos concatenando en la cadena $cadena
        los caracteres que se van eligiendo aleatoriamente.
       */
      $key = mt_rand(0, strlen($caracteres) - 1);
      $cadena = $cadena . $caracteres{$key};
    }
    return $cadena;
  }

  //Coloca la vista del navegador en el campo del formulario q tenga error
  public $hay_error_js = false;

  static function verificaHttp($texto_url) {
    $texto_exploded = explode('www.', $texto_url);

    if ($texto_exploded[0] == 'http://') {
      return $texto_url;
    } else {
      return 'http://' . $texto_url;
    }
  }
  
  static function monedaFormat($number)
  {
      return number_format($number, 2, ',', '.');
  }
  
  static function valorFormat($number)
  {
      return number_format($number, 0, ',', '.');
  }
  
  function is_negative($valor){
        if(is_int(strpos($x, "-"))) {
            return true;
        } else {
            return false;
        }
  }
  
  static function convierteDecimalFormat($valor)
  {
      $numero = trim($valor);
      $exp = explode(',', $numero);
      if($exp[1])
      {
        // Elimina Signor R$ 
        $numero = str_replace('R$ ', '', $numero);
        // Elimina punto
        $numero = str_replace('.', '', $numero);
        // Sobreescribe la coma por un punto
        $numero = str_replace(',', '.', $numero);
      }
      return $numero;
  }

}

?>