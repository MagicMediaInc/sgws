<?php

/**
 * Projetotipo form base class.
 *
 * @method Projetotipo getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProjetotipoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CodigoTipo' => new sfWidgetFormInputHidden(),
      'Tipo'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'CodigoTipo' => new sfValidatorPropelChoice(array('model' => 'Projetotipo', 'column' => 'CodigoTipo', 'required' => false)),
      'Tipo'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('projetotipo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Projetotipo';
  }


}
