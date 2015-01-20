<?php

/**
 * SfSection form.
 *
 * @package    lynx4
 * @subpackage form
 * @author     Your name here
 */
class SfSectionForm extends BaseSfSectionForm
{
  public function configure()
  {
      // Obtengo el Id de la seccion, si es que existe !!
      $idSection = sfContext::getInstance()->getRequest()->getParameter('id');
      $idProfile = sfContext::getInstance()->getUser()->getAttribute('idProfile');
      
      // Idioma Principal
      $languagePpal = SfLanguagePeer::getLanguagePrincipal();

      // Modulos Padres
      if($idProfile > 2)
      {
          $modulesPaterns = SfSectionPeer::findSectionsPaternsByNucleo($languagePpal['language'],$idSection,$idProfile);
      }else{
          $modulesPaterns = SfSectionPeer::findSectionsPaterns($languagePpal['language'],$idSection);
      }
      
      $profiles = LxProfilePeer::findProfilesCombo();
      
      // Widgets
      
      if($idProfile > 2)
      {
          $this->widgetSchema['id_profile'] = new sfWidgetFormInputHidden();
          $this->setDefault('id_profile',$idProfile);
      }else{
          //$this->setDefault('id_profile',0);
          $this->widgetSchema['id_profile'] = new sfWidgetFormChoice(array('choices'  => $profiles,'expanded' => false),array('size' => '10'));
      }
      
      $this->widgetSchema['id_parent'] = new sfWidgetFormChoice(array('choices'  => $modulesPaterns,'expanded' => false),array('size' => '10'));
      $this->widgetSchema['show_text'] = new sfWidgetFormChoice(array('choices' => array('1' => 'Mostrar a descri&ccedil;&atilde;o na pagina', '0' => 'N&atilde;o mostrar a descri&ccedil;&atilde;o na pagina')));
      if (!sfContext::getInstance()->getUser()->hasCredential('admin_lynx')){
        $this->widgetSchema['show_text']->setAttributes(array('disabled' => 'disabled'));
        $this->setDefault('show_text', 1);
      }

      $this->widgetSchema['control'] = new sfWidgetFormChoice(array('choices' => array('1' => 'Sim', '0' => "Não")));
      $this->widgetSchema['special_page'] = new sfWidgetFormInput(array(),array('size' => '25','maxlength' => '20'));
      if (!sfContext::getInstance()->getUser()->hasCredential('admin_lynx')){
          $this->widgetSchema['special_page']->setAttributes(array('disabled' => 'disabled'));
      }
      $this->widgetSchema['sw_menu'] = new sfWidgetFormInput(array(),array('class' => 'validate[required]','size' => '25','maxlength' => '20'));
      $this->widgetSchema['delete'] = new sfWidgetFormChoice(array('choices' => array("0" => "N&atilde;o",'1' => 'Sim')));
      if (!sfContext::getInstance()->getUser()->hasCredential('admin_lynx')){
          $this->widgetSchema['delete']->setAttributes(array('disabled' => 'disabled'));
          $this->validatorSchema['delete']->setOption('required', false);
      }
      $this->widgetSchema['only_complement'] = new sfWidgetFormChoice(array('choices' => array('1' => 'Sim', '0' => "N&atilde;o")));
      $this->widgetSchema['home'] = new sfWidgetFormChoice(array('choices' => array('1' => 'Sim', '0' => "N&atilde;o")));
      $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices' => array('1' => 'Habilitado no menu', '0' => "Deshabilitado",'2' => "Habilitado")));
      $this->widgetSchema['position'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['url_externa']->setAttributes(array('class' => '', 'size' => '35'));
      $this->validatorSchema['url_externa'] = new sfValidatorString(array('required' => false, 'trim' => true));

      // Default values
      $this->setDefault('delete', 1);
      $this->setDefault('status', 1);
      $this->setDefault('control', 1);

      //Validadores
      $this->validatorSchema['id_parent']  = new sfValidatorChoice(array('choices' => array_keys($modulesPaterns)));
      $this->validatorSchema['sw_menu']->setOption('required', true);
      
      //Etiquetas
      $this->widgetSchema->setLabels(array(
        'id_profile'        => 'Núcleos <span class="required">*</span>',
        'id_parent'         => 'Seção Pai <span class="required">*</span>',
        'show_text'         => 'Mostrar a descri&ccedil;&atilde;o na pagina',
        'control'           => 'Tem link?',
        'special_page'      => 'P&aacute;gina ',
        'sw_menu'           => 'Sess&atilde;o url <span class="required">*</span>',
        'delete'            => 'Pode deletar a seção?',
        'only_complement'   => 'Ocultar t&iacute;tulo',
        'home'              => 'Es Principal',
        'status'            => 'Status',
      ));

       //Mensajes de ayuda
      $this->widgetSchema->setHelps(array(
        'show_text'     => 'Mostrar a descri&ccedil;&atilde;o na pagina',
        'sw_menu'       => 'N&atilde;o pode usar caracteres especiais. Exemplo:  Outros-produtos&rsquo;',

      ));


    // Agrega un post validador personalizado
    $this->validatorSchema->setPostValidator(
            new sfValidatorCallback(array('callback' => array($this, 'checkSection')))
    );
  }

  public function checkSection($validator, $values) {
    $lyxnValida = new lynxValida();
    if (!$values['id'])
    {
        // Valida que no haya ingresado una URL Seccion repetida
	if(SfSectionPeer::checkSwitcheMenu($values['sw_menu']))
	{
            $error = new sfValidatorError($validator, sfConfig::get('mod_lxsection_msn_error_url_duplicate'));
            throw new sfValidatorErrorSchema($validator, array('Error' => $error));            
	}
        if($values['home'])
    	{
            // Si la opcion de seccion en Home es 1, desactiva todas las secciones.
	    // Solo debe haber una seccion como principal en el home
	    SfSectionPeer::desactivateSectionHome();
    	}
        // Valida que si es seccion principal no puede ser un hijo
        if($values['home'] && $values['id_padre']!=0)
        {
            $error = new sfValidatorError($validator, sfConfig::get('mod_section_msn_error_seccion_home_padre'));
            throw new sfValidatorErrorSchema($validator, array('Error' => $error));            
        }
        if(!sfContext::getInstance()->getUser()->hasCredential('admin_lynx'))
        {
            $values['delete'] = 1;
        }
    }else{
        $sf_section = SfSectionPeer::retrieveByPk($values['id']);       
        // Valida que no haya ingresado una URL Seccion repetida
	if(SfSectionPeer::validateSwitcheMenuUpdate($values['sw_menu'],$values['id']))
	{
            $error = new sfValidatorError($validator, sfConfig::get('mod_lxsection_msn_error_url_duplicate'));
            throw new sfValidatorErrorSchema($validator, array('Error' => $error));                        
	}
        // Valida que si el valor de home es 1 y el usuario lo ha cambiado a 0, impide la actualizacion
        // enviando un mensaje que no puede dejar la pagina de home vacia
        if($sf_section->getHome()==1 && !$values['home'])
    	{
            $error = new sfValidatorError($validator, sfConfig::get('mod_lxsection_msn_error_home'));
            throw new sfValidatorErrorSchema($validator, array('Error' => $error));
    	}elseif (!$sf_section->getHome() && $values['home']){
            // Primero valida que la seccion sea padre para poder asignarla como principal
            $valSectionPatern = SfSectionPeer::validatePaternSection($sf_section->getId());
            if($valSectionPatern['parent_id']==0)
            {
                // Si la opcion de seccion en Home es 1, desactiva todas las secciones.
	    	// Solo debe haber una seccion como principal en el home
	    	SfSectionPeer::desactivateSectionHome();
            }else{
                $error = new sfValidatorError($validator, sfConfig::get('mod_lxsection_msn_error_seccion_home'));
                throw new sfValidatorErrorSchema($validator, array('Error' => $error));                
            }
    	}
    }
    // Valida que sw_menu haya sido escrito correctamente, sin espacios en blanco, ni caracteres especiales
    if($values['sw_menu'] != $lyxnValida->limpiaCadena(utf8_decode($values['sw_menu']),0))
    {
        $error = new sfValidatorError($validator, sfConfig::get('mod_lxsection_msn_error_url'));
        throw new sfValidatorErrorSchema($validator, array('Error' => $error));    	
    }
    // Valida que si la seccion tiene activado el campo HOME debe obligatoriamente estar en Status 1 o 2
    if($values['home'] &&  $values['status']==0){
        $error = new sfValidatorError($validator, sfConfig::get('mod_lxsection_msn_error_seccion_home_visible'));
        throw new sfValidatorErrorSchema($validator, array('Error' => $error));    	
    }
    return $values;
  }

}
