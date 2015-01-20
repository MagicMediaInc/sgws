<?php

class actualizaSubtiposServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'updateSubtipo';
        // Agregamos una descripcion
        $this->briefDescription = "Actualiza los Subtipos";
        $this->detailedDescription = <<<EOF
        Actualiza los Subtipos        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
       
        $result = SaidasPeer::getAll();
        foreach ($result as $v) {
            
            if($v->getCodigocadastro())
            {
                $this->logSection('task', 'Empresa  - '.$v->getCodigocadastro());
                $dt =  FornecedorSubtipoPeer::getPRimerSubtipo($v->getCodigocadastro());
                if($dt)
                {
                    $update = SaidasPeer::retrieveByPK($v->getCodigoSaida());
                    $update->setCodigoTipo($dt->getIdTipo());
                    $update->setCodigoSubtipo($dt->getIdSubtipo());
                    $update->save();
                }
            }
            
        }
    
        
        
    }
}

?>
