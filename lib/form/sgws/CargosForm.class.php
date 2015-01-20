<?php

/**
 * Cargos form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class CargosForm extends BaseCargosForm
{
  public function configure()
  {
      $this->widgetSchema['nome'] = new sfWidgetFormInputText(array(), array('class' => 'validate[required]', 'size'=>'60'));
      $this->widgetSchema['meta'] = new sfWidgetFormInputText(array(), array('class' => '', 'size'=>'10'));
      
      $this->validatorSchema['meta']  = new sfValidatorString(array('required' => false, 'trim' => true));
  }
}
