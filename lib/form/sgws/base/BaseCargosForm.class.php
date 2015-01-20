<?php

/**
 * Cargos form base class.
 *
 * @method Cargos getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCargosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'   => new sfWidgetFormInputHidden(),
      'nome' => new sfWidgetFormInputText(),
      'meta' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'   => new sfValidatorPropelChoice(array('model' => 'Cargos', 'column' => 'id', 'required' => false)),
      'nome' => new sfValidatorString(array('max_length' => 100)),
      'meta' => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('cargos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cargos';
  }


}
