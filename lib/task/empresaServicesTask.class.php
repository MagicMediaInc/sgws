<?php

class empresaServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'empresa';
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
       
        $empresas = CadastroPeer::getAll();
        foreach ($empresas as $v) {
            // Info usuario fisica
            $emp = new CadastroJuridica();
            $emp->setIdUser(0);
            $emp->setCodigoCliente($v->getCodigocliente());
            $emp->setTipoCadastro($v->getTipocadastro());
            $emp->setEmail($v->getEmail());
            $emp->setNomeFantasia($v->getNomefantasia());
            $emp->setRazaoSocial($v->getRazaosocial());
            $emp->setCnpj($v->getCnpj());
            $emp->setIncripcaoEstadual($v->getInscricaoestadual());
            $emp->setIncripcaoCcm($v->getInscricaocom());
            $emp->setSite($v->getEnderecosite());
            $emp->setTelefone($v->getTelefone());
            $emp->setFax($v->getFax());
            $emp->setEndereco($v->getEndereco());
            $emp->setNumero($v->getNumero());
            $emp->setComplemento($v->getComplemento());
            $emp->setIdUf($v->getEstado());
            $emp->setIdMunicipio($v->getCidade());
            $emp->setBarrio($v->getBairro());
            $emp->setCep($v->getCep());
            $emp->setCodigoVelhio($v->getCodigocadastro());            
            $emp->save();
            $this->logSection('task', 'Nueva Empresa  - '.$emp->getNomeFantasia());
        }
    
        
        
    }
}

?>
