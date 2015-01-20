<?php

/**
 * VinculoUser form base class.
 *
 * @method VinculoUser getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseVinculoUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_vinculo_user' => new sfWidgetFormInputHidden(),
      'id_user'         => new sfWidgetFormInputText(),
      'id_user_vinculo' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_vinculo_user' => new sfValidatorPropelChoice(array('model' => 'VinculoUser', 'column' => 'id_vinculo_user', 'required' => false)),
      'id_user'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_user_vinculo' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('vinculo_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VinculoUser';
  }


}
