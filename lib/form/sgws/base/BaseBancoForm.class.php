<?php

/**
 * Banco form base class.
 *
 * @method Banco getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseBancoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_banco'     => new sfWidgetFormInputHidden(),
      'nombre_banco' => new sfWidgetFormInputText(),
      'status'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_banco'     => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id_banco', 'required' => false)),
      'nombre_banco' => new sfValidatorString(array('max_length' => 70)),
      'status'       => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('banco[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banco';
  }


}
