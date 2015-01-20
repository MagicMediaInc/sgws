<?php

/**
 * Rate form base class.
 *
 * @method Rate getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRateForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'funcionario'   => new sfWidgetFormInputText(),
      'cargo'         => new sfWidgetFormInputText(),
      'rate'          => new sfWidgetFormInputText(),
      'codigoprojeto' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'Rate', 'column' => 'id', 'required' => false)),
      'funcionario'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'cargo'         => new sfValidatorString(array('max_length' => 29, 'required' => false)),
      'rate'          => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'codigoprojeto' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rate[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rate';
  }


}
