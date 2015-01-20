<?php

/**
 * Negociacao form base class.
 *
 * @method Negociacao getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNegociacaoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_negociacao' => new sfWidgetFormInputHidden(),
      'nome'          => new sfWidgetFormInputText(),
      'status'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_negociacao' => new sfValidatorPropelChoice(array('model' => 'Negociacao', 'column' => 'id_negociacao', 'required' => false)),
      'nome'          => new sfValidatorString(array('max_length' => 50)),
      'status'        => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('negociacao[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Negociacao';
  }


}
