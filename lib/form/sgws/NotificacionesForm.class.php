<?php

/**
 * Notificaciones form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class NotificacionesForm extends BaseNotificacionesForm
{
  public function configure()
  {
      //Widgets
      
      $this->widgetSchema['id_user']    = new sfWidgetFormInputHidden();
      $this->widgetSchema['fecha']       = new sfWidgetFormInputHidden();
      $this->widgetSchema['asunto'] = new sfWidgetFormInputText(array(), array('class' => 'validate[required]','size' => '50','maxlength' => '100'));
      $this->widgetSchema['conteudo']  = new sfWidgetFormTextarea(array(), array('class' => 'validate[required]', 'cols' => '60' , 'rows' => '8'));
      $this->setDefault('id_user', sfContext::getInstance()->getUser()->getAttribute('idUserPanel'));
      $this->setDefault('fecha', date("Y-m-d"));
      
      //Validators
      $this->validatorSchema['id_user'] = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['asunto'] = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['conteudo'] = new sfValidatorString(array('required' => true, 'trim' => true));
      
      unset($this['status']);
  }
}
