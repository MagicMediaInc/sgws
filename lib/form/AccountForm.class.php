<?php

class AccountForm extends BaseLxUserForm {
    public function configure() {
        $this->disableCSRFProtection();
        // widgets
        $this->widgetSchema['name']->setAttributes(array('class' => 'validate[required]','size' => '30','maxlength' => '30'));
        $this->widgetSchema['login']->setAttributes(array('readonly' => 'readonly','size' => '30'));
        $this->widgetSchema['email']->setAttributes(array('class' => 'validate[required,custom[email]]','size' => '30','maxlength' => '70'));
        $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(),array('size' => '20','maxlength' => '12'));
        $this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
            'file_src' => sfConfig::get('sf_upload_dir').'/users/'.$this->getObject()->getPhoto(),
            'is_image'  => true,
            'edit_mode' => false,
        ));

        //Validores
        $this->validatorSchema['name']->setOption('required', true);
        $this->validatorSchema['email']->setOption('required', true);
        $this->validatorSchema['email'] = new sfValidatorAnd(array($this->validatorSchema['email'], new sfValidatorEmail(),));
        $this->validatorSchema['password'] =
                    new sfValidatorString(
                    array('required' => false, 'max_length' =>12, 'min_length' => 6 ,'trim' => true),
                    array('max_length' => 'A nova senha deve ter menos de 12 caracteres', 'min_length' => 'A nova senha deve ter mais de 6 caracteres')
            );
        
        $this->validatorSchema['photo'] = new sfValidatorFile(array(
            'required'   => false,
            'max_size'   => sfConfig::get('app_image_size'),
            'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/gif'),
           ));
        $this->validatorSchema['photo']->setMessage('max_size','The max value is %max_size% Kb.');
        $this->validatorSchema['photo']->setMessage('mime_types','Error mime types %mime_type%.');
        //Labels
        $this->widgetSchema->setLabels(array(
            'login'     => 'Usuário',
            'name'      => 'Nome Usuario',
            'email'     => 'Email',                
            'photo'     => 'Foto',                
        ));
        //Validadores Post-Envio
        $this->validatorSchema->setPostValidator(
                new sfValidatorAnd(
                array(
                    //Ecripta el password
                    new sfValidatorCallback(array('callback' => array($this, 'md5Password')))
        )));
        
        //Excluidos
        unset($this['id_user'], $this['id_profile'], $this['last_access'], $this['status'], $this['id_tipo_cadastro'], $this['id_tipo_usuario'], $this['codigo'], $this['cpf'], $this['rg'], $this['sexo'], $this['fecha_nacimiento'], $this['telefono'], $this['celular'], $this['direccion'], $this['numero'], $this['complemento'], $this['pais'], $this['estado'], $this['ciudad'], $this['barrio'], $this['cep'], $this['dependentes'], $this['observaciones'] , $this['codigo_velhio']);
    }
    
    public function md5Password($validator, $values) {
        
        $request =  sfContext::getInstance()->getRequest();
        $objLynxValida = new lynxValida();
        
        //Cambiar el valor a md5
        if($values['password']) {
            $values['password'] = md5($values['password']);
        }
       //Mantiene la clave actual si el campo esta vacio y se esta editando un usuario
       if(empty($values['password'])) {
           $tmpPass = LxUserPeer::getCurrentPassword(aplication_system::getUser());
           $values['password'] = $tmpPass->getPassword();
       }
       
       return $values;
    }
    
    protected function doSave($con = null)
    {
      $module = 'users';
      $appYml = sfConfig::get('app_upload_images_lxaccount');
      // Si hay un nuevo archivo por subir y ya mi registro tiene un archivo asociado entonces,
      if ($this->getObject()->getPhoto() && $this->getValue('photo'))
      {
          // recorro y elimino
          for($i=1;$i<=$appYml['copies'];$i++)
          {
              // Elimino las fotos de la carpeta
              if(is_file(sfConfig::get('sf_upload_dir').'/'.$module.'/'.$appYml['size_'.$i]['pref_'.$i].'_'.$this->getObject()->getPhoto()))
              {
                unlink(sfConfig::get('sf_upload_dir').'/'.$module.'/'.$appYml['size_'.$i]['pref_'.$i].'_'.$this->getObject()->getPhoto());
              }
          }
      }
      return parent::doSave($con);
   }

}
?>
