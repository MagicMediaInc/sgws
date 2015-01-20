<?php

/**
 * Prioridade form base class.
 *
 * @method Prioridade getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePrioridadeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_prioridade' => new sfWidgetFormInputHidden(),
      'nome'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_prioridade' => new sfValidatorPropelChoice(array('model' => 'Prioridade', 'column' => 'id_prioridade', 'required' => false)),
      'nome'          => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('prioridade[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Prioridade';
  }


}
