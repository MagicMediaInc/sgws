<?php

/**
 * LxPrivilege form base class.
 *
 * @method LxPrivilege getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseLxPrivilegeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_privilege'          => new sfWidgetFormInputHidden(),
      'privilege_name'        => new sfWidgetFormInputText(),
      'sf_privilege'          => new sfWidgetFormInputText(),
      'privilege_description' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_privilege'          => new sfValidatorPropelChoice(array('model' => 'LxPrivilege', 'column' => 'id_privilege', 'required' => false)),
      'privilege_name'        => new sfValidatorString(array('max_length' => 20)),
      'sf_privilege'          => new sfValidatorString(array('max_length' => 20)),
      'privilege_description' => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('lx_privilege[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LxPrivilege';
  }


}
