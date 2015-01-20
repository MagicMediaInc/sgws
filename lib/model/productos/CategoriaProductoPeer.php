<?php


/**
 * Skeleton subclass for performing query and update operations on the 'categoria_producto' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 06/01/2014 14:52:22
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model.productos
 */
class CategoriaProductoPeer extends BaseCategoriaProductoPeer {
    
    public static function getListSelect()
    {
        $c = new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Se Agregan las Columnas necesarias
        $c->addSelectColumn(self::ID);
        $c->addSelectColumn(self::NOME);
        
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        $sections[0] = '';
        while($res = $rs->fetch())
        {
            $sections[$res['ID']] = $res['NOME'];            
        }
        if(!empty($sections)){
            return $sections;
        }else{
            return false;
        }
    }

    
    public static function getLista(){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::NOME);
        return self::doSelect($c);
    }

} // CategoriaProductoPeer
