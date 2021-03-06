<?php


/**
 * Skeleton subclass for performing query and update operations on the 'sf_news_album' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 29/08/2012 15:54:50
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    plugins.sfLynxNewsPlugin.lib.model
 */
class SfNewsAlbumPeer extends BaseSfNewsAlbumPeer {
    
      public static function getAlbumNews($idNews)
    {
        //Obtengo el idioma principal
        $c = new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Se Agregan las Columnas necesarias        
        $c->addSelectColumn(self::ID_NEWS_ALBUM);
        $c->addSelectColumn(self::ID_ALBUM);
        $c->addSelectColumn(SfAlbumPeer::ALBUM_NAME);
        
        $c->addJoin(self::ID_ALBUM, SfAlbumPeer::ID_ALBUM, Criteria::INNER_JOIN);
        //Filtros
        $c->add(self::ID_NEWS,$idNews, Criteria::EQUAL);
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        while($res = $rs->fetch())
        {
            $dato['id_news_album'] = $res['ID_NEWS_ALBUM'];
            $dato['id_album'] = $res['ID_ALBUM'];
            $dato['album'] = $res['ALBUM_NAME'];
            $datos[] = $dato;
        }
        if (!empty($datos)){
            return $datos;
        }else{
            return false;
        }
    }
    
    public static function checkAlbumNews($idNews, $id_album) {

        $c = new Criteria();
        $c->add(self::ID_NEWS,$idNews, Criteria::EQUAL);
        $c->add(self::ID_ALBUM,$id_album, Criteria::EQUAL);
        return self::doCount($c);
        
    }

} // SfNewsAlbumPeer
