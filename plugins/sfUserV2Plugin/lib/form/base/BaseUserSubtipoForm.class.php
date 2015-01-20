<?php

/**
 * UserSubtipo form base class.
 *
 * @method UserSubtipo getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseUserSubtipoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_user_subtipo' => new sfWidgetFormInputHidden(),
      'id_user'         => new sfWidgetFormPropelChoice(array('model' => 'LxUser', 'add_empty' => false)),
      'id_subtipo'      => new sfWidgetFormPropelChoice(array('model' => 'SubtipoUser', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_user_subtipo' => new sfValidatorPropelChoice(array('model' => 'UserSubtipo', 'column' => 'id_user_subtipo', 'required' => false)),
      'id_user'         => new sfValidatorPropelChoice(array('model' => 'LxUser', 'column' => 'id_user')),
      'id_subtipo'      => new sfValidatorPropelChoice(array('model' => 'SubtipoUser', 'column' => 'id_subtipo')),
    ));

    $this->widgetSchema->setNameFormat('user_subtipo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserSubtipo';
  }


}
