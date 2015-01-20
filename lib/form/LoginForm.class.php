<?php

class LoginForm extends sfForm {
    public function configure() {
        $this->setWidgets(array(
                'login'    => new sfWidgetFormInput(array(),array('maxlength' => 20)),
                'password' => new sfWidgetFormInputPassword(array(),array('maxlength' => 20)),
        ));

        $this->setValidators(array(
                'login' => new sfValidatorString(array('required' => true, 'trim' => true)),
                'password' => new sfValidatorString(array('required' => true, 'trim' => true)),
        ));

        $this->widgetSchema->setNameFormat('wdLogin[%s]');

        // Agrega un post validador personalizado
        $this->validatorSchema->setPostValidator(
                new sfValidatorCallback(array('callback' => array($this, 'checkUserAndPassword')))
        );


    }

    public function checkUserAndPassword($validator, $values) {


        if (!empty($values['login']) && !empty($values['password'])) {
            $this->dataUser = LxUserPeer::validateUserPanel($values['login'], md5($values['password']));
            if($this->dataUser) {
                $this->dataUser->setLastaccess(date('Y-m-d H:i:s'));
                $this->dataUser->save();
            }else {
                $error = new sfValidatorError($validator, sfContext::getInstance()->getI18N()->__('Incorreta combinação de usuário / senha'));
                throw new sfValidatorErrorSchema($validator, array('Error' => $error));
            }
        }
        return $values;
    }

}
?>
