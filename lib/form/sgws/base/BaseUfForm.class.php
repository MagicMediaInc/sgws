<?php

/**
 * Uf form base class.
 *
 * @method Uf getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUfForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_uf'   => new sfWidgetFormInputHidden(),
      'name_uf' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_uf'   => new sfValidatorPropelChoice(array('model' => 'Uf', 'column' => 'id_uf', 'required' => false)),
      'name_uf' => new sfValidatorString(array('max_length' => 150)),
    ));

    $this->widgetSchema->setNameFormat('uf[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Uf';
  }


}
