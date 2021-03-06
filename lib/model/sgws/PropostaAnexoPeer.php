<?php


/**
 * Skeleton subclass for performing query and update operations on the 'proposta_anexo' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 16/01/2014 15:24:37
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model.sgws
 */
class PropostaAnexoPeer extends BasePropostaAnexoPeer {
    
    public static function getAnexosProposta($id)
    {
        $c = new Criteria();
        $c->add(self::ID_PROPOSTA, $id, Criteria::EQUAL);
        return self::doSelect($c);
    }
    

} // PropostaAnexoPeer
