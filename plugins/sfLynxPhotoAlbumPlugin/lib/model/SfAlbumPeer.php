<?php


/**
 * Skeleton subclass for performing query and update operations on the 'sf_album' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Mon May 10 08:39:38 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    plugins.sfLynxPhotoAlbunPlugin.lib.model
 */
class SfAlbumPeer extends BaseSfAlbumPeer {
    
    public static function findAlbunes($idSection)
      {
        $c = new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Se Agregan las Columnas necesarias
        $c->addSelectColumn(self::ID_ALBUM);        
        $c->addSelectColumn(self::ALBUM_NAME);        
        //Filtros
        $c->addAscendingOrderByColumn(self::ALBUM_NAME);
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        //$sections[0] = 'None';
        while($res = $rs->fetch())
        {
            if(!SfSeccionAlbumPeer::checkAlbumSeccion($idSection, $res['ID_ALBUM']))
            {
                $archivos[$res['ID_ALBUM']] = "&bull;&nbsp;".$res['ALBUM_NAME'];
            }            
        }
        if(!empty($archivos)){
            return $archivos;
        }else{
            $archivos[0] = '';
            return $archivos;
        }            
      }
    public static function findAlbunesForNews($idNews)
      {
        $c = new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Se Agregan las Columnas necesarias
        $c->addSelectColumn(self::ID_ALBUM);        
        $c->addSelectColumn(self::ALBUM_NAME);        
        //Filtros
        $c->addAscendingOrderByColumn(self::ALBUM_NAME);
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        //$sections[0] = 'None';
        while($res = $rs->fetch())
        {
            if(!SfNewsAlbumPeer::checkAlbumNews($idNews, $res['ID_ALBUM']))
            {
                $archivos[$res['ID_ALBUM']] = "&bull;&nbsp;".$res['ALBUM_NAME'];
            }            
        }
        if(!empty($archivos)){
            return $archivos;
        }else{
            $archivos[0] = '';
            return $archivos;
        }            
      }
      
    public static function findAlbunesForCursos($idCurso)
      {
        $c = new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Se Agregan las Columnas necesarias
        $c->addSelectColumn(self::ID_ALBUM);        
        $c->addSelectColumn(self::ALBUM_NAME);        
        //Filtros
        $c->addAscendingOrderByColumn(self::ALBUM_NAME);
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        //$sections[0] = 'None';
        while($res = $rs->fetch())
        {
            if(!CursoAlbumPeer::checkAlbumCurso($idCurso, $res['ID_ALBUM']))
            {
                $archivos[$res['ID_ALBUM']] = "&bull;&nbsp;".$res['ALBUM_NAME'];
            }            
        }
        if(!empty($archivos)){
            return $archivos;
        }else{
            $archivos[0] = '';
            return $archivos;
        }            
      }

} // SfAlbumPeer
