<?php

/**
 * VinculoUserSubtipo form base class.
 *
 * @method VinculoUserSubtipo getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseVinculoUserSubtipoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_vinculo_subtipo' => new sfWidgetFormInputHidden(),
      'id_user'            => new sfWidgetFormInputText(),
      'id_tipo_cadastro'   => new sfWidgetFormInputText(),
      'id_subtipo'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_vinculo_subtipo' => new sfValidatorPropelChoice(array('model' => 'VinculoUserSubtipo', 'column' => 'id_vinculo_subtipo', 'required' => false)),
      'id_user'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_tipo_cadastro'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_subtipo'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('vinculo_user_subtipo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VinculoUserSubtipo';
  }


}
