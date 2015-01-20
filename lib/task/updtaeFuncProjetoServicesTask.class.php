<?php

class updtaeFuncProjetoServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'actualizaAll';
        // Agregamos una descripcion
        $this->briefDescription = "Actualiza las empresa";
        $this->detailedDescription = <<<EOF
        Actualiza las empresa        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
//        // Actualiza gerentes
//        $rs  = PropostaPeer::getAllRegistros();
//        foreach ($rs as $v) {
//            // Info usuario fisica
//            $cod = LxUserPeer::getCodigoVelhio($v->getGerente());
//            $emp = CadastroJuridicaPeer::getCodigoVelhio($v->getCliente());
//            
//            
//            $this->logSection('task', 'Actualizado ID de Gerente  - PROP: '.$v->getCodigoProposta() .' -- '.$cod->getIdUser().'--'.$v->getGerente());
//            $up = PropostaPeer::retrieveByPK($v->getCodigoProposta());
//            $up->setGerente($cod->getIdUser());
//            $up->setCliente($emp ? $emp->getIdEmpresa(): 0);
//            $up->save();
//        }
//        unset($rs,$v,$cod, $up, $emp);
        
        
//        // actualiza los funcionarios en la tareas
//        $rs = TarefaPeer::getTodosLosFuncionarios();
//        foreach ($rs as $v) {
//            $cod = LxUserPeer::getCodigoVelhio($v->getResponsavel());
//            $projeto = PropostaPeer::getCodigoVelhio($v->getCodigoprojeto());
//            
//            $this->logSection('task', 'Actualizado ID de Responsable  - TAREFA '.$v->getCodigotarefa().' - '.  $v->getResponsavel().' -- '.$cod->getIdUser());
//            $up = TarefaPeer::retrieveByPK($v->getCodigotarefa());
//            $up->setResponsavel($cod->getIdUser());
//            $up->setCodigoprojeto($projeto ? $projeto->getCodigoProposta() : 0);
//            $up->save();
//        }
//        unset($rs,$v,$cod, $up, $projeto);
//        
//        // Actualiza usuario
//        $rs = TempotarefaPeer::getAllFuncionariosTask();
//        foreach ($rs as $v) {
//            $cod = LxUserPeer::getCodigoVelhio($v->getCodigofuncionario());
//            $aut = LxUserPeer::getCodigoVelhio($v->getAutorizadopor());
//            
//            
//            $this->logSection('task', 'Actualizado ID de Responsable  - '.$v->getCodigofuncionario().' -- '.$cod->getIdUser());
//            $up = TempotarefaPeer::retrieveByPK($v->getCodigoregistro());
//            $up->setCodigofuncionario($cod->getIdUser());
//            $up->setAutorizadopor($aut->getIdUser());
//            $up->save();
//        }
//        unset($rs,$v,$cod, $up, $aut);
//        
//
//        
//        
//        // Actualiza Id de los Funcionarios
//        $rs = EquipeTarefaPeer::getAllFuncionarios();
//        
//        foreach ($rs as $v) {
//            $cod = LxUserPeer::getCodigoVelhio($v->getCodigofuncionario());
//            if($cod)
//            {
//                $this->logSection('task', 'Funcionario  - '.$v->getId().'--'.$v->getCodigofuncionario().'--'.$cod->getIdUser());
//                //$this->logSection('task', 'Actualizado ID de Responsable  - '.$v->getCodigofuncionario().' -- '.$cod->getIdUser());
//                $up = EquipeTarefaPeer::retrieveByPK($v->getId());
//                $up->setCodigofuncionario($cod->getIdUser());
//                $up->save();
//            }
//            
//        }
//        unset($rs,$v,$cod, $up);
        
        // Actualiza Salidas
        $rs = SaidasPeer::getAll();
        foreach ($rs as $v) {
            $funcionario = LxUserPeer::getCodigoVelhio($v->getCodigofuncionario());
            $funcionarioConfirmador = LxUserPeer::getCodigoVelhio($v->getConfirmadopor());
            $cliente = CadastroJuridicaPeer::getCodigoVelhio($v->getCodigocadastro());
            $projeto = PropostaPeer::getCodigoVelhio($v->getCodigoprojeto());
            $this->logSection('task', 'Actualizada Informacion de SAIDA - '.$v->getCodigoSaida());
            
            $upSaida = SaidasPeer::retrieveByPK($v->getCodigoSaida());
            $upSaida->setCodigoprojeto($projeto ? $projeto->getCodigoProposta() : 0);
            $upSaida->setCodigocadastro($cliente ? $cliente->getIdEmpresa() : 0);
            $upSaida->setCodigofuncionario($funcionario->getIdUser());
            $upSaida->setConfirmadopor($funcionarioConfirmador->getIdUser());
            
            $upSaida->save();
        }
        
    }
}

?>
