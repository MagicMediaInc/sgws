<?php

/**
 * LxProfileModule form base class.
 *
 * @method LxProfileModule getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseLxProfileModuleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_profile_module' => new sfWidgetFormInputHidden(),
      'id_privilege'      => new sfWidgetFormInputText(),
      'id_profile'        => new sfWidgetFormInputText(),
      'id_module'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_profile_module' => new sfValidatorPropelChoice(array('model' => 'LxProfileModule', 'column' => 'id_profile_module', 'required' => false)),
      'id_privilege'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_profile'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_module'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'LxProfileModule', 'column' => array('id_privilege', 'id_module', 'id_profile')))
    );

    $this->widgetSchema->setNameFormat('lx_profile_module[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LxProfileModule';
  }


}
