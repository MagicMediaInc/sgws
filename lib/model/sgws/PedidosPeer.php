<?php


/**
 * Skeleton subclass for performing query and update operations on the 'pedidos' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 07/01/2014 15:05:30
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model.sgws
 */
class PedidosPeer extends BasePedidosPeer {
    
    public static function getPedidos($idGerente, $palabra, $status, $from_date, $to_date)
    {
        $c = new Criteria();
        
        if($idGerente)
        {
            $c->add(self::ID_CLIENTE, $idGerente, Criteria::EQUAL);
        }
        if($palabra)
        {
            $c->addJoin(self::ID_PROJETO, PropostaPeer::CODIGO_PROPOSTA, Criteria::INNER_JOIN);
            $criterio = $c->getNewCriterion(self::NUMERO_PEDIDO, '%'.$palabra.'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%'.$palabra.'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::NOME_PROPOSTA, '%'.$palabra.'%', Criteria::LIKE));
            $c->add($criterio);
        }
        if($from_date)
        {
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));
            $cFecha = $c->getNewCriterion(self::DATA, $from_date,Criteria::GREATER_EQUAL);
            $cFecha->addAnd($c->getNewCriterion(self::DATA, $to_date, Criteria::LESS_EQUAL));
            $c->add($cFecha);
        }
        if($status)
        {
            $c->add(self::STATUS, $status, Criteria::EQUAL);
        }
        $c->addDescendingOrderByColumn(self::DATA);
        return self::doSelect($c);
    }
    
    public static function getStatusPedido($id)
    {
        $c = new Criteria();
        $c->add(self::ID, $id, Criteria::EQUAL);
        $rs = self::doSelectOne($c);
        return $rs->getStatus();
    }
    
    public static function getInfoPedido($id)
    {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::DATA);
        $c->addSelectColumn(PropostaPeer::CODIGO_SGWS_PROJETO);
        $c->addSelectColumn(PropostaPeer::NOME_PROPOSTA);
        $c->addSelectColumn(LxUserPeer::NAME);

        //Condicion
        $c->addJoin(self::ID_PROJETO, PropostaPeer::CODIGO_PROPOSTA, Criteria::INNER_JOIN);
        $c->addJoin(self::ID_CLIENTE, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
        $c->add(self::ID, $id, Criteria::EQUAL);
        
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        
        while($res = $rs->fetch()) {
            $dato['data_compra'] = $res['DATA'];
            $dato['codigo_projeto'] = $res['CODIGO_SGWS_PROJETO'];
            $dato['nome_projeto'] = $res['NOME_PROPOSTA'];
            $dato['gerente'] = $res['NAME'];
        }
        return $dato;
    }

} // PedidosPeer
