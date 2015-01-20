<?php

/**
 * TipoCadastro form base class.
 *
 * @method TipoCadastro getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseTipoCadastroForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_tipo_cadastro' => new sfWidgetFormInputHidden(),
      'tipo_cadastro'    => new sfWidgetFormInputText(),
      'sign_in'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_tipo_cadastro' => new sfValidatorPropelChoice(array('model' => 'TipoCadastro', 'column' => 'id_tipo_cadastro', 'required' => false)),
      'tipo_cadastro'    => new sfValidatorString(array('max_length' => 20)),
      'sign_in'          => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('tipo_cadastro[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoCadastro';
  }


}
