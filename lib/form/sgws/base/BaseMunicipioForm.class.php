<?php

/**
 * Municipio form base class.
 *
 * @method Municipio getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMunicipioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_municipio'   => new sfWidgetFormInputHidden(),
      'id_uf'          => new sfWidgetFormInputText(),
      'name_municipio' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_municipio'   => new sfValidatorPropelChoice(array('model' => 'Municipio', 'column' => 'id_municipio', 'required' => false)),
      'id_uf'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'name_municipio' => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('municipio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Municipio';
  }


}
