<?php

/**
 * VinculoUserTipoCadastro form base class.
 *
 * @method VinculoUserTipoCadastro getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseVinculoUserTipoCadastroForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_vinculo'       => new sfWidgetFormInputHidden(),
      'id_user'          => new sfWidgetFormInputText(),
      'id_tipo_cadastro' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_vinculo'       => new sfValidatorPropelChoice(array('model' => 'VinculoUserTipoCadastro', 'column' => 'id_vinculo', 'required' => false)),
      'id_user'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_tipo_cadastro' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('vinculo_user_tipo_cadastro[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VinculoUserTipoCadastro';
  }


}
