<?php

/**
 * LxUserModule form base class.
 *
 * @method LxUserModule getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseLxUserModuleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_user_module' => new sfWidgetFormInputHidden(),
      'id_privilege'   => new sfWidgetFormInputText(),
      'id_user'        => new sfWidgetFormInputText(),
      'id_module'      => new sfWidgetFormInputText(),
      'type_vision'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_user_module' => new sfValidatorPropelChoice(array('model' => 'LxUserModule', 'column' => 'id_user_module', 'required' => false)),
      'id_privilege'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_user'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_module'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'type_vision'    => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('lx_user_module[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LxUserModule';
  }


}
