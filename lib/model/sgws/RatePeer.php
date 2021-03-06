<?php


/**
 * Skeleton subclass for performing query and update operations on the 'rate' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 25/02/2014 16:58:15
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model.sgws
 */
class RatePeer extends BaseRatePeer {
    
    public static function getAll()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::ID);
//        $c->addGroupByColumn(self::FUNCIONARIO);
        return self::doSelect($c);
    }
    
    public static function getAllProjeto()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::ID);
        $c->add(self::CODIGOPROJETO, 0, Criteria::GREATER_THAN);
//        $c->addGroupByColumn(self::CODIGOPROJETO);
        return self::doSelect($c);
    }
    
    public static function getProjetoCero()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::ID);
        $c->add(self::CODIGOPROJETO, 0, Criteria::EQUAL);

        return self::doSelect($c);
    }
    
    public static function getRateProjeto($projeto)
    {
        $c = new Criteria();        
        $c->add(self::CODIGOPROJETO, $projeto, Criteria::EQUAL);
        
        return self::doCount($c);
    }
    public static function getRateFuncionarioBase($funcionario)
    {
        $c = new Criteria();        
        $c->add(self::FUNCIONARIO, $funcionario, Criteria::EQUAL);
        $c->add(self::CODIGOPROJETO, 0, Criteria::EQUAL);
        return self::doSelectOne($c);
    }
    public static function getRateFuncionarioProjeto($funcionario,$projeto)
    {
        $c = new Criteria();
        $c->add(self::FUNCIONARIO, $funcionario, Criteria::EQUAL);
        $c->add(self::CODIGOPROJETO, $projeto, Criteria::EQUAL);
        
        return self::doSelectOne($c);
    }

    public static function actualizaFuncionario($cod_velhio, $nvo, $id)
    {
  	$con = Propel::getConnection();

	// select from...
	$c1 = new Criteria();
	//$c1->add(self::FUNCIONARIO,$cod_velhio, Criteria::EQUAL);
	$c1->add(self::ID,$id, Criteria::EQUAL);

	// update set
	$c2 = new Criteria();
	$c2->add(self::FUNCIONARIO, $nvo);

	BasePeer::doUpdate($c1, $c2, $con);
    }
    
    public static function actualizaProjeto($cod_velhio, $nvo, $id)
    {
  	$con = Propel::getConnection();

	// select from...
	$c1 = new Criteria();
	//$c1->add(self::CODIGOPROJETO,$cod_velhio, Criteria::EQUAL);
	$c1->add(self::ID, $id, Criteria::EQUAL);

	// update set
	$c2 = new Criteria();
	$c2->add(self::CODIGOPROJETO, $nvo);

	BasePeer::doUpdate($c1, $c2, $con);
    }
    
} // RatePeer
