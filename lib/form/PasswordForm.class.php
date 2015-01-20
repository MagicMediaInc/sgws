<?php

class PasswordForm extends BaseLxUserForm {
    /**
     *
     * @var string
     */
    protected static $currentPass;

    public function configure() {

        //Asigna la contrasena actual
        self::$currentPass = LxUserPeer::getCurrentPassword(sfContext::getInstance()->getUser()->getAttribute('idUserPanel'));
        
        // Widgets
        $this->widgetSchema['login']->setAttributes(array('readonly' => 'readonly','size' => '20'));
        $this->widgetSchema['current_password'] = new sfWidgetFormInputPassword(array(),array('class' => 'validate[required]','size' => '30','maxlength' => '12'));
        $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(),array('class' => 'validate[required]','size' => '30','maxlength' => '12'));
        $this->widgetSchema['confir_password'] = new sfWidgetFormInputPassword(array(),array('class' => 'validate[required]','size' => '30','maxlength' => '12'));

        //Validadores
        $this->validatorSchema['current_password'] = new sfValidatorString(array('required' => true, 'trim' => true));
        $this->validatorSchema['password'] =
                new sfValidatorString(
                array('required' => true, 'max_length' =>12, 'min_length' => 6 ,'trim' => true),
                array('max_length' => 'A nova senha deve ter menos de 12 caracteres', 'min_length' => 'A nova senha deve ter mais de 6 caracteres')
        );
        $this->validatorSchema['confir_password'] = new sfValidatorString(array('required' => true, 'trim' => true));


        //Etiquetas
        $this->widgetSchema->setLabels(array(
                'login'                => 'Usuário',
                'current_password'    => 'Senha atual',
                'password'    => 'Nova senha',
                'confir_password'    => 'Confirmar nova senha',

        ));
        //Mensajes de ayuda
        $this->widgetSchema->setHelps(array(
             'password'    => 'A nova senha deve ter mais de 6 caracteres',
        ));
        

        //Validadores Post-Envio
        $this->validatorSchema->setPostValidator(
                new sfValidatorAnd(
                array(
                //Compara el nuevo password con la confirmacion
                    new sfValidatorSchemaCompare('password', '==', 'confir_password',
                    array('throw_global_error' => true),
                    array('invalid' => 'Sua senha no coincide, Intente de novo')),
                    //El el nuevo password debe ser diferente al actual
                    new sfValidatorSchemaCompare('password', '!=', 'current_password',
                    array('throw_global_error' => true),
                    array('invalid' => 'A nova senha deve ser diferente a senha atual')),
                    //Valida que el password actual sea el correcto
                    new sfValidatorCallback(array('callback' => array($this, 'checkCurrentPassword')))
                )));

        unset($this['id_user'], $this['id_profile'], $this['name'], $this['email'], $this['last_access'], $this['status']);
    }
    /**
     * Valida que la contrasena actual sea igual al campo del formulario
     * @param objecto $validator
     * @param array $values
     * @return array
     */
    public function checkCurrentPassword($validator, $values) {
        if (!empty($values['current_password'])) {
            if(md5($values['current_password'])!=self::$currentPass->getPassword()) {
                $error = new sfValidatorError($validator, 'Sua senha atual é incorreta');
                throw new sfValidatorErrorSchema($validator, array('Error' => $error));
            }
        }

        return $values;
    }

}
?>
