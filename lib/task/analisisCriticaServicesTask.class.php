<?php

class analisisCriticaServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'analisis';
        // Agregamos una descripcion
        $this->briefDescription = "Crea los análisis criticos iniciales de los proyectos";
        $this->detailedDescription = <<<EOF
        Crea los análisis criticos iniciales de los proyectos
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
        
        $result = PropostaPeer::getAllOnlyProjetos();
        foreach ($result as $v) {
            // Crea el análisis critico
            $analisis = new Analisis();
            $analisis->setAnalisisPpal(1);
            $analisis->setIdProposta($v->getCodigoProposta());
            $analisis->setIdResponsavel($v->getGerente());
            $analisis->setIdCliente($v->getCliente());
            $analisis->setDataCreacion($v->getDataInicio());
            $analisis->setDataAprobacion($v->getDataIrProjeto());
            $analisis->setDescricao($v->getProposta());
            $analisis->setAprobacionCliente(1);
            $analisis->setAprobacionProposta($v->getStatus());
            $analisis->setStatus(1);
            $analisis->setPrecio($v->getValor());
            $analisis->save();
            $this->logSection('task', ' -- Creado el analisis- '.$analisis->getId());
        }
    
        
        
    }
}

?>
