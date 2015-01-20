<?php

class globalFunctions {
    /**
     * Dada una fecha devuelve la semana donde esta esa fecha
     * @param string $date
     * @return array
     */
    static function getInicioFimSemana($date)
    {
        $start = $date;
        while( date( 'w', $start ) > 1 ) {
            $start -= 86400; // One day
        }
        // End of the week is simply 6 days from the start
        $end = date( 'Y-m-d', $start + ( 6 * 86400 ) );
        $start = date( 'Y-m-d', $start );
        $arr['inicio'] = $start;
        $arr['fin'] = $end;
        $data[] = $arr;        
        return $data;
    }

        //Completa con ceros un int dado
    static function zerofill($num, $zerofill = 3)
    {
      return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
    }

    //Genera una cadena aleatoria alfanumerica
    static function GenerateRandomString($longitud = 8){

      /* Se valida la longitud proporcionada. Debe ser número y mayor de cero.
      Si es menor o igual a cero le asignamos la longitud por defecto.
      Si es mayor de 32 le asignamos 32.
      */
      if(!is_numeric( $longitud ) || $longitud <= 0){
        $longitud = 8;
      }
      if( $longitud > 32 ){
        $longitud = 32;
      }

      /* Asignamos el juego de caracteres al array $caracteres para generar la contraseña.
      Podemos añadir más caracteres para hacer más segura la contraseña.
      */
      $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

      /* Introduce la semilla del generador de números aleatorios mejorado */
      mt_srand(microtime() * 1000000);
      $cadena = "";
      for($i = 0; $i < $longitud; $i++){

        /* Genera un valor aleatorio mejorado con mt_rand, entre 0 y el tamaño del array
              $caracteres menos 1. Posteríormente vamos concatenando en la cadena $cadena
              los caracteres que se van eligiendo aleatoriamente.
        */
        $key = mt_rand(0,strlen($caracteres)-1);
        $cadena = $cadena . $caracteres{$key};
      }
      return $cadena;
    }

    //Funcion que genera un permalink
    static function crearPermalink($text){
      $text = ucwords(strtolower(trim($text)));
      // strip all non word chars

      //cambios en acentos, dieresis y enies
      $text = str_replace('á','a',$text);
      $text = str_replace('é','e',$text);
      $text = str_replace('í','i',$text);
      $text = str_replace('ó','o',$text);
      $text = str_replace('ú','u',$text);
      $text = str_replace('ç','c',$text);
      $text = str_replace('ñ','n',$text);

      $text = preg_replace('/[^a-zA-Z0-9\s]/', '-', $text);
      // replace all white space sections with a dash
      $text = preg_replace('/\ +/', '-', $text);
      // trim dashes
      $text = preg_replace('/\-$/', '-', $text);
      $text = preg_replace('/^\-/', '-', $text);

      return $text;
    }

    //Trunca un texto por palabra
    static function trunkTextByword($text, $num_caracteres = 100){
      if (strlen($text) > $num_caracteres){
        $text_trun = preg_replace('/\s+?(\S+)?$/', '', substr($text, 0, $num_caracteres));
        return $text_trun.'...';
      }

      return $text;
    }
  
    static function getCodigoProjeto($id)
    {
        if($infoProjeto = PropostaPeer::getDataByCodProjeto($id))
        {
            $rs = PropostaPeer::retrieveByPK($infoProjeto->getCodigoProposta()); 
        }else{
            $rs = PropostaPeer::retrieveByPK($id); 
        }
        return $rs;
    }
    
    static function getNomeProjeto($id)
    {
        if($infoProjeto = PropostaPeer::getDataByCodProjeto($id))
        {
            $rs = PropostaPeer::retrieveByPK($infoProjeto->getCodigoProposta()); 
        }else{
            $rs = PropostaPeer::retrieveByPK($id); 
        }
        return $rs->getNomeProposta();
    }
}
?>