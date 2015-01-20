<?php

class actualizaRateServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'rate';
        // Agregamos una descripcion
        $this->briefDescription = "Actualiza los id de los funcionarios";
        $this->detailedDescription = <<<EOF
        Actualiza los Subtipos        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
       
//        $result = RatePeer::getAll();
//        foreach ($result as $v) {
//            $func = LxUserPeer::getCodigoVelhio($v->getFuncionario());
//            
//            if($func)
//            {
//                
//                RatePeer::actualizaFuncionario($v->getFuncionario(), $func->getIdUser(), $v->getId());
//                $this->logSection('task', $v->getId().' -- Actualizado Funcionario - '.$v->getFuncionario().' por '.$func->getIdUser());
//            }
//            
//        }
        
        $result = RatePeer::getAllProjeto();
        foreach ($result as $v) {
            $pp = PropostaPeer::getCodigoVelhio($v->getCodigoprojeto());
            
            if($pp)
            {
                
                RatePeer::actualizaProjeto($v->getCodigoprojeto(), $pp->getCodigoProposta(), $v->getId());
                $this->logSection('task', $v->getId().' -- Actualizado Projeto - '.$v->getCodigoprojeto().' por '.$pp->getCodigoProposta());
            }
            
        }
    
        
        
    }
}

?>
