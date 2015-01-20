<?php

/**
 * LxProfile form base class.
 *
 * @method LxProfile getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseLxProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_profile'   => new sfWidgetFormInputHidden(),
      'name_profile' => new sfWidgetFormInputText(),
      'permalink'    => new sfWidgetFormInputText(),
      'status'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_profile'   => new sfValidatorPropelChoice(array('model' => 'LxProfile', 'column' => 'id_profile', 'required' => false)),
      'name_profile' => new sfValidatorString(array('max_length' => 150)),
      'permalink'    => new sfValidatorString(array('max_length' => 30)),
      'status'       => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lx_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LxProfile';
  }


}
