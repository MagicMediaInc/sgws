<?php

class baixaControlServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'control';
        // Agregamos una descripcion
        $this->briefDescription = "";
        $this->detailedDescription = <<<EOF
        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
       
        $result = SaidasPeer::getAll();
        foreach ($result as $v) {
            
            $update = SaidasPeer::retrieveByPK($v->getCodigoSaida());
            $update->setConfirmacao($v->getControl());            
            $update->save();
            $this->logSection('task', 'Actualizada Reg - '.$v->getCodigoSaida());
            
        }
    
        
        
    }
}

?>
