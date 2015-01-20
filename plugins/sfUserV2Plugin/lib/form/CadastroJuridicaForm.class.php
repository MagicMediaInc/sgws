<?php

/**
 * CadastroJuridica form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class CadastroJuridicaForm extends BaseCadastroJuridicaForm
{
  public function configure()
  {
    $this->disableCSRFProtection();
    $request =  sfContext::getInstance()->getRequest();
    // Arma tipo de cadastro
    $typeCadastro = array();
    $items = TipoCadastroPeer::getListTypeCadastro('noall');
    foreach($items as $item) {
        $typeCadastro[$item->getTipoCadastro()] = $item->getTipoCadastro();
    }
    $municipios = array();
    //Arma Municipios
    if($this->getObject()->getIdUf())
    {        
        $items = MunicipioPeer::getMunicipiosXEstado($this->getObject()->getIdUf());
        foreach($items as $item) {
          $municipios[$item->getIdMunicipio()] = $item->getNameMunicipio();
        }
        $this->widgetSchema['id_municipio']  = new sfWidgetFormChoice(array('choices' => $municipios),  array('id' => 'id_municipio', 'class' => ''));      
      }else{      
        //Se definen los valores de los campos si se esta creando un objeto nuevo
        $municipios = array('' => 'Selecione Municipio...');
    }
    // Datos de acceso del usuario
    $this->widgetSchema['tipo_cadastro']  = new sfWidgetFormChoice(array('choices' => $typeCadastro),  array('class' => 'validate[required]'));
//    $this->widgetSchema['id_tipo_usuario']  = new sfWidgetFormInputHidden(array(), array('value' => '3'));
    //$this->widgetSchema['login'] = new sfWidgetFormInputText(array(), array('class' => '','size' => '20','maxlength' => '30'));
    $this->widgetSchema['email'] = new sfWidgetFormInputText(array(), array('class' => 'validate[required,custom[email]]','size' => '68','maxlength' => '70'));
//    if(!$request->getParameter('id_user')) 
//    {
//        //$this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(),array('class' => 'validate[required]','size' => '20','maxlength' => '12'));
//    }else {//Solo para editar no es requerido
//        //$this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(),array('size' => '20','maxlength' => '12'));
//    }
//    if($request->getParameter('id_user')==2) {
//        $this->widgetSchema['id_profile'] = new sfWidgetFormChoice(array('choices' => array('2' => 'Administrator')));
//    }else{
//       $this->widgetSchema['id_profile'] = new sfWidgetFormPropelChoice(array('model' => 'LxProfile', 'peer_method' => 'getProfileWithoutAdmin', 'add_empty' => 'Selecione'),array('class' => 'validate[required]')); 
//    }
    
    // DADOS JURIDICA
    $this->widgetSchema['codigo_cliente']->setAttributes(array('class' => 'validate[required]','size' => '15','maxlength' => '20'));
    $this->widgetSchema['nome_fantasia']->setAttributes(array('class' => 'validate[required]','size' => '68','maxlength' => '150'));
    $this->widgetSchema['razao_social']->setAttributes(array('class' => 'validate[required]','size' => '68','maxlength' => '150'));
    $this->widgetSchema['cnpj']->setAttributes(array('class' => '','size' => '68','maxlength' => '20'));
    $this->widgetSchema['incripcao_estadual']->setAttributes(array('class' => '','size' => '68','maxlength' => '30'));
    $this->widgetSchema['incripcao_ccm']->setAttributes(array('class' => '','size' => '68','maxlength' => '30'));
    $this->widgetSchema['endereco'] = new sfWidgetFormInputText(array(),array('class' => '','size' => '68','maxlength' => '150'));
    $this->widgetSchema['site']->setAttributes(array('class' => '','size' => '68','maxlength' => '150'));
    $this->widgetSchema['status'] = new sfWidgetFormSelect(array('choices' => array('1' => 'Ativo', '0' => 'Inativo')));
    $this->widgetSchema['pais'] = new sfWidgetFormI18nChoiceCountry(array(), array('id' => 'pais'));
    $this->widgetSchema['ddi_telefone'] = new sfWidgetFormInputText(array(),array('class' => '','size' => '2'));
    $this->widgetSchema['ddd_telefone'] = new sfWidgetFormInputText(array(),array('class' => '','size' => '2'));
    $this->widgetSchema['ddi_fax'] = new sfWidgetFormInputText(array(),array('class' => '','size' => '2'));
    $this->widgetSchema['ddd_fax'] = new sfWidgetFormInputText(array(),array('class' => '','size' => '2'));
    $this->widgetSchema['ddi_celular'] = new sfWidgetFormInputText(array(),array('class' => '','size' => '2'));
    $this->widgetSchema['ddd_celular'] = new sfWidgetFormInputText(array(),array('class' => '','size' => '2'));
    $this->widgetSchema['observaciones'] = new sfWidgetFormTextarea(array(),array('cols' => 50, 'rows' => 6,'style' => 'width:437px' ));
    $this->widgetSchema['id_uf'] = new sfWidgetFormPropelChoice(array('model' => 'Uf', 'peer_method' => 'getTodosUf', 'add_empty' => true)); 
    $this->widgetSchema['id_municipio']  = new sfWidgetFormChoice(array('choices' => $municipios),  array('id' => 'id_municipio', 'class' => ''));
    $this->widgetSchema['cep']->setAttributes(array('class' => '','size' => '8','maxlength' => '10'));
    
    // Default    
    $this->setDefault('pais', 'BR');
//    if($request->getParameter('id_user'))
//    {
//        $dadosLogin = LxUserPeer::getCurrentPassword($request->getParameter('id_user'));
//        if($dadosLogin)
//        {
//            $this->setDefault('login', $dadosLogin->getLogin());
//            $this->setDefault('email', $dadosLogin->getEmail());
//            $this->setDefault('id_profile', $dadosLogin->getIdProfile());
//            //$this->setDefault('tipo_cadastro', $dadosLogin->getIdTipoCadastro());
//            $this->setDefault('id_tipo_usuario', $dadosLogin->getIdTipoUsuario());
//        }
//    }
    // Validadores
    $this->validatorSchema['email'] = new sfValidatorString(array('required' => true, 'trim' => true));
    
    $this->validatorSchema['email'] = new sfValidatorAnd(array($this->validatorSchema['email'], new sfValidatorEmail(array(),array('invalid'=>'L\'adresse email est invalide'))),
      array('required'=>false)
    );
//    $this->validatorSchema['id_profile']  = new sfValidatorPropelChoice(array('model' => 'LxProfile', 'column' => 'id_profile', 'required' => true));
//    $this->validatorSchema['id_tipo_usuario'] = new sfValidatorString(array('required' => true, 'trim' => true));
    //$this->validatorSchema['login'] = new sfValidatorString(array('required' => true, 'trim' => true));
    $this->validatorSchema['codigo_cliente'] = new sfValidatorString(array('required' => true, 'trim' => true));
    $this->validatorSchema['nome_fantasia'] = new sfValidatorString(array('required' => true, 'trim' => true));
    $this->validatorSchema['razao_social'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['cnpj'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['incripcao_estadual'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['incripcao_ccm'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['site'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['ddi_telefone'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['ddd_telefone'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['telefone'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['ddi_fax'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['ddd_fax'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['fax'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['ddi_celular'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['ddd_celular'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['celular'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['endereco'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['complemento'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['numero'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['id_uf'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['id_municipio'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['barrio'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['cep'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['observacoes'] = new sfValidatorString(array('required' => false, 'trim' => true));
    
//    if(!$request->getParameter('id_user')) {
//        $this->validatorSchema['password'] =
//                new sfValidatorString(
//                array('required' => true, 'max_length' =>12, 'min_length' => 6 ,'trim' => true),
//                array('max_length' => 'The new password must have less than 12 characters', 'min_length' => 'The new password must have more than 6 characters')
//        );
//    }else {//Solo para editar no es requerido
//        $this->validatorSchema['password'] =
//                new sfValidatorString(
//                array('required' => false, 'max_length' =>12, 'min_length' => 6 ,'trim' => true),
//                array('max_length' => 'The new password must have less than 12 characters', 'min_length' => 'The new password must have more than 6 characters')
//        );
//    }
    
    //Etiquetas 
    $this->widgetSchema->setLabels(array(
            'codigo_cliente'          => 'Código',
            'razao_social'          => 'Razão Social',
            'cnpj'                  => 'CNPJ',
            'telefone'              => 'Telefone',
            'endereco'              => 'Endere&ccedil;o',
            'id_uf'                 => 'UF',
            'id_municipio'          => 'Municipio',
            'cep'                   => 'CEP',
            'incripcao_estadual'    => 'Inscrição Estadual',
            'incripcao_ccm'         => 'Inscrição CCM',
            'numero'                => 'Número',
            'pais'                  => 'País',
            'observacoes'           => 'Observações',
            'tipo_cadastro'           => 'Tipo Cadastro',

    ));
    
    //Validadores Post-Envio
    $this->validatorSchema->setPostValidator(
            new sfValidatorAnd(
            array(
                // Valida dados
                new sfValidatorCallback(array('callback' => array($this, 'validateDados')))
    )));
    
    unset($this['id_user'], $this['codigo_velhio']);
  }
  
  public function validateDados($validator, $values) {
    $request =  sfContext::getInstance()->getRequest();
    $objLynxValida = new lynxValida();
    
//    if($values['login'] !=$objLynxValida->limpiaCadena($values['login'])) {
//        
//        $error = new sfValidatorError($validator, 'Este campo tem caracteres especiais');
//        throw new sfValidatorErrorSchema($validator, array('login' => $error));
//    }
    
    //$validaLogin = LxUserPeer::validateLogin($values['login'], $request->getParameter('id_user'));
    $validaEmail = CadastroJuridicaPeer::validateEmail($values['email'], $request->getParameter('id'));
//    if($validaLogin)
//    {
//        $error = new sfValidatorError($validator, 'Um usuário com o mesmo login já existe');
//        throw new sfValidatorErrorSchema($validator, array('login' => $error));
//    }
    if($validaEmail)
    {
        $error = new sfValidatorError($validator, 'Um usuário com o mesmo email já existe');
        throw new sfValidatorErrorSchema($validator, array('login' => $error));
    }
    
    //Cambiar el valor a md5
//    if(!empty($values['password'])) {
//        $values['password'] = md5($values['password']);
//    }
//   
//    //Mantiene la clave actual si el campo esta vacio y se esta editando un usuario
//    if($request->getParameter('id_user') and empty($values['password'])) {
//       $tmpPass = LxUserPeer::getCurrentPassword($request->getParameter('id_user'));
//       $values['password'] = $tmpPass->getPassword();
//    }
   
    return $values;
        
  }
}
