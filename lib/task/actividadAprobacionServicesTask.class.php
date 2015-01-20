<?php

class actividadAprobacionServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'actualizaHorasTrabajadas';
        // Agregamos una descripcion
        $this->briefDescription = "Actualiza las Horas trabajadas de los proyectos de acuerdo a las actividades aprobadas";
        $this->detailedDescription = <<<EOF
        Actualiza las Horas trabajadas de los proyectos de acuerdo a las actividades aprobadas        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
       
        $result = TempotarefaPeer::getActividadesAprobadas();
        foreach ($result as $v) {
            // Busca el proyecto de la tarea
            $pro = TarefaPeer::getCodProjetoByCodTarefa($v->getCodigotarefa());
            $rs = PropostaPeer::retrieveByPK($pro['cod_projeto']);
            if($rs)
            {
                $rs->setHorasTrabajadas($rs->getHorasTrabajadas() + $v->getTempogasto());
                //$rs->save();
            }
            unset($rs);
            $this->logSection('task', 'Actividad - '.$v->getCodigoregistro().' - Projeto: '.$pro['cod_projeto']. ' - Horas: '.$v->getTempogasto());
        }
    
        
        
    }
}

?>
