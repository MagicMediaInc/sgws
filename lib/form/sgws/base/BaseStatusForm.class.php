<?php

/**
 * Status form base class.
 *
 * @method Status getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseStatusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Status'   => new sfWidgetFormInputHidden(),
      'IdStatus' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'Status'   => new sfValidatorPropelChoice(array('model' => 'Status', 'column' => 'Status', 'required' => false)),
      'IdStatus' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('status[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Status';
  }


}
