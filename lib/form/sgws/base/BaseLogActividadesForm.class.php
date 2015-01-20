<?php

/**
 * LogActividades form base class.
 *
 * @method LogActividades getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLogActividadesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_log'  => new sfWidgetFormInputHidden(),
      'id_user' => new sfWidgetFormInputText(),
      'ip'      => new sfWidgetFormInputText(),
      'modulo'  => new sfWidgetFormInputText(),
      'fecha'   => new sfWidgetFormDate(),
      'hora'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_log'  => new sfValidatorPropelChoice(array('model' => 'LogActividades', 'column' => 'id_log', 'required' => false)),
      'id_user' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'ip'      => new sfValidatorString(array('max_length' => 50)),
      'modulo'  => new sfValidatorString(array('max_length' => 50)),
      'fecha'   => new sfValidatorDate(),
      'hora'    => new sfValidatorString(array('max_length' => 15)),
    ));

    $this->widgetSchema->setNameFormat('log_actividades[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LogActividades';
  }


}
