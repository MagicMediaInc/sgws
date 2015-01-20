<?php

class updateProjetoServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'projetos';
        // Agregamos una descripcion
        $this->briefDescription = "Actualiza los projetos en relacion a las propuestas";
        $this->detailedDescription = <<<EOF
        Actualiza los projetos en relacion a las propuestas
        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
       
        $propostas = PropostaPeer::getAll();
        foreach ($propostas as $prop) {
            $datos_projeto = ProjetoPeer::getData($prop->getCodigoProposta());
            $this->logSection('task', $prop->getNomeProposta());
            $update = PropostaPeer::retrieveByPK($prop->getCodigoProposta());
            if($datos_projeto)
            {
                $update->setCodigoVelhio($datos_projeto->getCodigoProjeto());
                $update->setGerente($datos_projeto->getGerente());
                $update->setCodigoProjeto($prop->getCodigoProposta());
                $update->setCodigoSgwsProjeto($datos_projeto->getCodigoSgws());
                $update->setCodigoTipo($datos_projeto->getCodigoTipo());
                $update->setDataIrProjeto($datos_projeto->getDataIpProjeto());
                $update->setDataFrProjeto($datos_projeto->getDataFrProjeto());
                $update->setStatus($datos_projeto->getStatus());
                $update->setIdStatusProposta(2);                
                $update->setVisualizacion(1); 
               $this->logSection('task', '    ! La propuesta '.$prop->getCodigoProposta().' fue vendida !');
            }else{
                $update->setIdStatusProposta(1);
            }
            $update->setIdPrioridade(2);
            $update->setIdNegociacao(3);
//            $update->save();
            
        }
    }
}

?>
