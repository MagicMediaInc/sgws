<?php

/**
 * ProjetoCentro form base class.
 *
 * @method ProjetoCentro getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProjetoCentroForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'id_projeto' => new sfWidgetFormInputText(),
      'id_centro'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'ProjetoCentro', 'column' => 'id', 'required' => false)),
      'id_projeto' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_centro'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('projeto_centro[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProjetoCentro';
  }


}
