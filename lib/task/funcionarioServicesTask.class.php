<?php

class funcionarioServicesTask extends sfBaseTask
{
    public function configure()
    {
        $this->namespace    = 'task';
        $this->name         = 'funcionario';
        // Agregamos una descripcion
        $this->briefDescription = "Actualiza los funcionario";
        $this->detailedDescription = <<<EOF
        Actualiza los funcionario
        
EOF;
        
    }
        
    public function execute($arguments =  array(), $options =  array())
    {
        // Acceder a la Base de Datos
        $databaseManager = new sfDatabaseManager($this->configuration);
        $databaseManager->loadConfiguration();
       
        $funcionarios = FuncionarioPeer::getAll();
        foreach ($funcionarios as $func) {
            $this->logSection('task', 'Usuario '.$func->getCargo());
            // Registro el usuario
            $usu = new LxUser();
            $usu->setIdProfile($func->getNivel() <= 2 ? 4 : 3);
            $usu->setIdTipoUsuario(2);
            $usu->setName($func->getNomefuncionario());
            $usu->setLogin($func->getNomeusuario());
            $usu->setPassword(md5($func->getSenha()));
            $usu->setEmail($func->getEmail());
            $usu->setStatus($func->getStatus() == 'Inativo' ? 0 : 1);
            $usu->setCodigoVelhio($func->getCodigofuncionario());
            $usu->save();
            // Vincula user tipo cadastro
            $vinc = new VinculoUserTipoCadastro();
            $vinc->setIdUser($usu->getIdUser());
            $vinc->setIdTipoCadastro(4);
            $vinc->save();
            // Info usuario fisica
            
            $fis = new CadastroFisica();
            $fis->setIdUser($usu->getIdUser());
            $fis->setNome($func->getNomefuncionario());
            $fis->setCpf($func->getCpf());
            $fis->setRg($func->getRg());
            $fis->setSexo($func->getSexo() == 'Masculino' ? 'M' : 'F');
            $fis->setCargo($func->getCargo());
            $fis->setDataNacimento($func->getDatanascimento());
            $fis->setTelefone($func->getTelefone());
            $fis->setCelular($func->getCelular());
            $fis->setEndereco($func->getEndereco());
            $fis->setNumero($func->getNumero());
            $fis->setComplemento($func->getComplemento());
            $fis->setIdUf($func->getEstado());
            $fis->setIdMunicipio($func->getCidade());
            $fis->setBarrio($func->getBairro());
            $fis->setCep($func->getCep());
            $fis->setFormaContratacao($func->getFormacontratacao());
            $fis->setDataAdmissao($func->getDataadmissao());
            $fis->setDataEmissao($func->getDatademissao());
            $fis->setDependentes($func->getNumerodependentes());
            $fis->save();
            $this->logSection('task', 'Nuevo usuario '.$usu->getIdUser().' - '.$fis->getNome());
        }
    
        
        
    }
}

?>
