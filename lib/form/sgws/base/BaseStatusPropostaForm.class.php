<?php

/**
 * StatusProposta form base class.
 *
 * @method StatusProposta getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseStatusPropostaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_status_proposta' => new sfWidgetFormInputHidden(),
      'nome'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_status_proposta' => new sfValidatorPropelChoice(array('model' => 'StatusProposta', 'column' => 'id_status_proposta', 'required' => false)),
      'nome'               => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('status_proposta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'StatusProposta';
  }


}
