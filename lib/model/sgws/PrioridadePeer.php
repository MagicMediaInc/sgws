<?php


/**
 * Skeleton subclass for performing query and update operations on the 'prioridade' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 24/09/2013 14:56:18
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model.sgws
 */
class PrioridadePeer extends BasePrioridadePeer {
    
    public static function getListPrioridad()
    {
        $c = new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Se Agregan las Columnas necesarias
        $c->addSelectColumn(self::ID_PRIORIDADE);
        $c->addSelectColumn(self::NOME);
        
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        $sections[0] = '';
        while($res = $rs->fetch())
        {
            $sections[$res['ID_PRIORIDADE']] = $res['NOME'];            
        }
        if(!empty($sections)){
            return $sections;
        }else{
            return false;
        }
    }

} // PrioridadePeer
