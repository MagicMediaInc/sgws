<?php

class cargosServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'cargos';
        // Agregamos una descripcion
        $this->briefDescription = "Cargos";
        $this->detailedDescription = <<<EOF
        Cargos
        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
       
        //$cargos = CadastroFisicaPeer::getCargos();
        $cargos = CargosPeer::getCargos();
        foreach ($cargos as $cargo) {
            
            $this->logSection('task', 'Cargo '.$cargo['cargo']);
            //CargosPeer::actualizaCargo($cargo['cargo']);
            // registro el cargo
//            $new = new Cargos();
//            $new->setNome(ucwords($cargo['cargo']));
//            $new->save();
            // actualizo cadastro_fisica con el valor del id del cargo
            CadastroFisicaPeer::actualizaCargo($cargo['cargo'], $cargo['id']);
//            unset($new);
        }
    
        
        
    }
}

?>
