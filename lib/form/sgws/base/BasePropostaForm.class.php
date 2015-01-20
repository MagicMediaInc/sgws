<?php

/**
 * Proposta form base class.
 *
 * @method Proposta getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePropostaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo_proposta'     => new sfWidgetFormInputHidden(),
      'codigo_sgws'         => new sfWidgetFormInputText(),
      'codigo_projeto'      => new sfWidgetFormInputText(),
      'codigo_sgws_projeto' => new sfWidgetFormInputText(),
      'codigo_centro'       => new sfWidgetFormInputText(),
      'id_negociacao'       => new sfWidgetFormInputText(),
      'codigo_tipo'         => new sfWidgetFormInputText(),
      'data_inicio'         => new sfWidgetFormDate(),
      'data_final'          => new sfWidgetFormDateTime(),
      'data_ir_projeto'     => new sfWidgetFormDate(),
      'data_fr_projeto'     => new sfWidgetFormDate(),
      'nome_proposta'       => new sfWidgetFormInputText(),
      'cliente'             => new sfWidgetFormInputText(),
      'satisfacao_cliente'  => new sfWidgetFormInputText(),
      'nao_conformidade'    => new sfWidgetFormInputText(),
      'gerente'             => new sfWidgetFormInputText(),
      'status'              => new sfWidgetFormInputText(),
      'id_status_proposta'  => new sfWidgetFormInputText(),
      'status_analisis'     => new sfWidgetFormInputText(),
      'visualizacion'       => new sfWidgetFormInputText(),
      'apr'                 => new sfWidgetFormInputText(),
      'proposta'            => new sfWidgetFormTextarea(),
      'valor'               => new sfWidgetFormInputText(),
      'valor_prev_hh'       => new sfWidgetFormInputText(),
      'id_prioridade'       => new sfWidgetFormInputText(),
      'horas_vendidas'      => new sfWidgetFormInputText(),
      'horas_trabajadas'    => new sfWidgetFormInputText(),
      'coeficiente'         => new sfWidgetFormInputText(),
      'flag_projeto'        => new sfWidgetFormInputText(),
      'tipo'                => new sfWidgetFormInputText(),
      'codigo_velhio'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'codigo_proposta'     => new sfValidatorPropelChoice(array('model' => 'Proposta', 'column' => 'codigo_proposta', 'required' => false)),
      'codigo_sgws'         => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'codigo_projeto'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'codigo_sgws_projeto' => new sfValidatorString(array('max_length' => 10)),
      'codigo_centro'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_negociacao'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'codigo_tipo'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'data_inicio'         => new sfValidatorDate(array('required' => false)),
      'data_final'          => new sfValidatorDateTime(array('required' => false)),
      'data_ir_projeto'     => new sfValidatorDate(),
      'data_fr_projeto'     => new sfValidatorDate(),
      'nome_proposta'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cliente'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'satisfacao_cliente'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nao_conformidade'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'gerente'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'status'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'id_status_proposta'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'status_analisis'     => new sfValidatorString(),
      'visualizacion'       => new sfValidatorString(array('required' => false)),
      'apr'                 => new sfValidatorString(),
      'proposta'            => new sfValidatorString(array('required' => false)),
      'valor'               => new sfValidatorNumber(array('required' => true)),
      'valor_prev_hh'       => new sfValidatorNumber(array('required' => false)),
      'id_prioridade'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647,'required' => false)),
      'horas_vendidas'      => new sfValidatorNumber(),
      'horas_trabajadas'    => new sfValidatorNumber(),
      'coeficiente'         => new sfValidatorNumber(),
      'flag_projeto'        => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'tipo'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigo_velhio'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('proposta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proposta';
  }


}
