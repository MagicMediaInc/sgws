<?php

class subtiposCadastroServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'subtipos';
        // Agregamos una descripcion
        $this->briefDescription = "Subtipos Cadastro";
        $this->detailedDescription = <<<EOF
        Actualiza las empresa
        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
       
        $empresas = CadastroPeer::getAllSubtipos();
        foreach ($empresas as $v) {
            $arr = explode(';', $v->getSubtipo());
            $this->logSection('task', 'subtipo '.$v->getCodigocadastro());
            $codigoEmpresa = CadastroJuridicaPeer::getCodigoVelhio($v->getCodigocadastro());
            foreach ($arr as $val) {
                if(trim($val))
                {
                    $this->logSection('task', trim($val));
                    $id = trim($val);
                    // Busca el valor en subtipo
                    $dSt = SubtipoUserPeer::getDataByCodigoVelhio($id);
                    // Asocia el subtipo al fornecedor/cliente
                    $asoc = new FornecedorSubtipo();
                    $asoc->setIdEmpresa($codigoEmpresa->getIdEmpresa());
                    $asoc->setIdSubtipo($dSt->getIdSubtipo());
                    $asoc->setIdTipo($dSt->getIdParent());
//                    $asoc->save();
                }
                
            }            
            if($v->getCodigocadastro() == 634)
            {
                break;
            }
        }
    
        
        
    }
}

?>
