<?php

/**
 * FornecedorSubtipo form base class.
 *
 * @method FornecedorSubtipo getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFornecedorSubtipoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'id_empresa' => new sfWidgetFormPropelChoice(array('model' => 'CadastroJuridica', 'add_empty' => false)),
      'id_tipo'    => new sfWidgetFormInputText(),
      'id_subtipo' => new sfWidgetFormPropelChoice(array('model' => 'SubtipoUser', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'FornecedorSubtipo', 'column' => 'id', 'required' => false)),
      'id_empresa' => new sfValidatorPropelChoice(array('model' => 'CadastroJuridica', 'column' => 'id_empresa')),
      'id_tipo'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_subtipo' => new sfValidatorPropelChoice(array('model' => 'SubtipoUser', 'column' => 'id_subtipo')),
    ));

    $this->widgetSchema->setNameFormat('fornecedor_subtipo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FornecedorSubtipo';
  }


}
