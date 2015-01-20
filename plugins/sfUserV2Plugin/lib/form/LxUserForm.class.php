<?php

/**
 * LxUser form.
 *
 * @package    lynx
 * @subpackage form
 * @author     Your name here
 */
class LxUserForm extends BaseLxUserForm {
    public function configure() {
        
        $this->disableCSRFProtection();
        $request =  sfContext::getInstance()->getRequest();
        
        // Arma tipo de cadastro
        $typeCadastro = array();
        $items = TipoCadastroPeer::getListTypeCadastro();
        foreach($items as $item) {
            $typeCadastro[$item->getIdTipoCadastro()] = $item->getTipoCadastro();
        }
        // Arma tipo de usuario
        $typeUser = array();
        $items = TipoUsuarioPeer::getListTypeUser();
        foreach($items as $item) {
            $typeUser[$item->getIdTipoUsuario()] = $item->getTipoUsuario();
        }
        
        //Widgets
        $this->widgetSchema['id_tipo_cadastro']  = new sfWidgetFormChoice(array('choices' => $typeCadastro),  array('class' => 'validate[required]'));
        $this->widgetSchema['id_tipo_usuario']  = new sfWidgetFormChoice(array('choices' => $typeUser),  array('class' => 'validate[required]'));
        
        $this->widgetSchema['codigo']->setAttributes(array('class' => 'validate[required]','size' => '10','maxlength' => '30'));
        $this->widgetSchema['login']->setAttributes(array('class' => 'validate[required]','size' => '20','maxlength' => '30'));
        
        $this->widgetSchema->setNameFormat('user[%s]');
        if(!$request->getParameter('id_user')) {
            $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(),array('class' => 'validate[required]','size' => '20','maxlength' => '12'));
        }else {//Solo para editar no es requerido
            $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(),array('size' => '20','maxlength' => '12'));
        }

        if($this->getObject()->isNew())
        {
            $this->setDefault('status', '0');
        }
        
        $this->widgetSchema['email']->setAttributes(array('class' => 'validate[required,custom[email]]','size' => '68','maxlength' => '70'));
        $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices' => array('1' => 'Ativo', '0' => 'Inativo')));
        if($request->getParameter('id_user')==2) {
            $this->widgetSchema['id_profile'] = new sfWidgetFormChoice(array('choices' => array('2' => 'Administrator')));
        }else{
           $this->widgetSchema['id_profile'] = new sfWidgetFormPropelChoice(array('model' => 'LxProfile', 'peer_method' => 'getProfileWithoutAdmin')); 
        }


        //Validadores
        if(!$request->getParameter('id_user')) {
            $this->validatorSchema['password'] =
                    new sfValidatorString(
                    array('required' => true, 'max_length' =>12, 'min_length' => 6 ,'trim' => true),
                    array('max_length' => 'The new password must have less than 12 characters', 'min_length' => 'The new password must have more than 6 characters')
            );
        }else {//Solo para editar no es requerido
            $this->validatorSchema['password'] =
                    new sfValidatorString(
                    array('required' => false, 'max_length' =>12, 'min_length' => 6 ,'trim' => true),
                    array('max_length' => 'The new password must have less than 12 characters', 'min_length' => 'The new password must have more than 6 characters')
            );
        }
        $this->validatorSchema['email'] = new sfValidatorAnd(array($this->validatorSchema['email'], new sfValidatorEmail(),));
        $this->validatorSchema['id_profile']  = new sfValidatorPropelChoice(array('model' => 'LxProfile', 'column' => 'id_profile', 'required' => true));
        
        $this->validatorSchema['login'] = new sfValidatorString(array('required' => true, 'trim' => true));
        $this->validatorSchema['hola'] = new sfValidatorString(array('required' => true, 'trim' => true));

        //Etiquetas
        $this->widgetSchema->setLabels(array(
                'id_profile'    => 'Perfil Associado',
                'name'    => 'Nome',
                'login'    => 'Usuário',
                'password'    => 'Senha',
                'email'    => 'Email',
                'cpf'    => 'CPF',
                'rg'    => 'RG',
                'telefono'    => 'Telefone',
                'direccion'    => 'Endere&ccedil;o',

        ));
        
        //Solo para editar
        if($request->getParameter('id_user')) {
            $this->widgetSchema->setLabels(array(
                    'password'    => 'Password',
            ));
        }
        //Mensajes de ayuda
        $this->widgetSchema->setHelps(array(
                'password'    => 'A nova senha deve ter pelo menos 6 caracteres',
        ));
        //Validadores Post-Envio
        $this->validatorSchema->setPostValidator(
                new sfValidatorAnd(
                array(
                //Valida que el login sea unico
                        new sfValidatorPropelUnique(array('model' => 'LxUser', 'column' => 'login'), array('invalid'=>'Um usuário com o mesmo "%column%" já existe')),
                        //Ecripta el password
                        new sfValidatorCallback(array('callback' => array($this, 'md5Password')))
        )));
        
        unset($this['last_access'], $this['id_profile'], $this['photo']);
    }
    
    public function md5Password($validator, $values) {
        
        $request =  sfContext::getInstance()->getRequest();
        $objLynxValida = new lynxValida();
        
        if($values['login'] !=$objLynxValida->limpiaCadena($values['login'])) {
            $error = new sfValidatorError($validator, 'Este campo tem caracteres especiais');
            throw new sfValidatorErrorSchema($validator, array('login' => $error));
        }
        //Cambiar el valor a md5
        if(!empty($values['password'])) {
            $values['password'] = md5($values['password']);
        }
       //Mantiene la clave actual si el campo esta vacio y se esta editando un usuario
       if($request->getParameter('id_user') and empty($values['password'])) {
           $tmpPass = LxUserPeer::getCurrentPassword($request->getParameter('id_user'));
           $values['password'] = $tmpPass->getPassword();
       }

       return $values;
    }
}
