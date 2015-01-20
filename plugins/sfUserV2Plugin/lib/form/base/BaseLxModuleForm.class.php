<?php

/**
 * LxModule form base class.
 *
 * @method LxModule getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseLxModuleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_module'   => new sfWidgetFormInputHidden(),
      'name_module' => new sfWidgetFormInputText(),
      'sf_module'   => new sfWidgetFormInputText(),
      'credential'  => new sfWidgetFormInputText(),
      'status'      => new sfWidgetFormInputText(),
      'id_parent'   => new sfWidgetFormInputText(),
      'position'    => new sfWidgetFormInputText(),
      'delete'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_module'   => new sfValidatorPropelChoice(array('model' => 'LxModule', 'column' => 'id_module', 'required' => false)),
      'name_module' => new sfValidatorString(array('max_length' => 100)),
      'sf_module'   => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'credential'  => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'status'      => new sfValidatorString(array('required' => false)),
      'id_parent'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'position'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'delete'      => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('lx_module[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LxModule';
  }


}
