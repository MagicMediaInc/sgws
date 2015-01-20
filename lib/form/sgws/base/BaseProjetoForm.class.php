<?php

/**
 * Projeto form base class.
 *
 * @method Projeto getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProjetoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo_projeto'         => new sfWidgetFormInputHidden(),
      'codigo_sgws'            => new sfWidgetFormInputText(),
      'codigo_proposta'        => new sfWidgetFormInputText(),
      'nome_projeto'           => new sfWidgetFormInputText(),
      'codigo_tipo'            => new sfWidgetFormInputText(),
      'gerente'                => new sfWidgetFormInputText(),
      'codigo_cadastro'        => new sfWidgetFormInputText(),
      'data_ir_projeto'        => new sfWidgetFormDateTime(),
      'data_fr_projeto'        => new sfWidgetFormDateTime(),
      'data_ip_projeto'        => new sfWidgetFormDateTime(),
      'data_fp_projeto'        => new sfWidgetFormDateTime(),
      'status'                 => new sfWidgetFormInputText(),
      'descricao_projeto'      => new sfWidgetFormTextarea(),
      'np'                     => new sfWidgetFormInputText(),
      'saida_prevista_projeto' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'codigo_projeto'         => new sfValidatorPropelChoice(array('model' => 'Projeto', 'column' => 'codigo_projeto', 'required' => false)),
      'codigo_sgws'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'codigo_proposta'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nome_projeto'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'codigo_tipo'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'gerente'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigo_cadastro'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'data_ir_projeto'        => new sfValidatorDateTime(array('required' => false)),
      'data_fr_projeto'        => new sfValidatorDateTime(array('required' => false)),
      'data_ip_projeto'        => new sfValidatorDateTime(array('required' => false)),
      'data_fp_projeto'        => new sfValidatorDateTime(array('required' => false)),
      'status'                 => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'descricao_projeto'      => new sfValidatorString(array('required' => false)),
      'np'                     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'saida_prevista_projeto' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('projeto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Projeto';
  }


}
