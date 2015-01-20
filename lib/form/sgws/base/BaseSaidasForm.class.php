<?php

/**
 * Saidas form base class.
 *
 * @method Saidas getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSaidasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo_saida'       => new sfWidgetFormInputHidden(),
      'id_compensacao'     => new sfWidgetFormInputText(),
      'id_pedido'          => new sfWidgetFormInputText(),
      'documentos'         => new sfWidgetFormInputText(),
      'centro'             => new sfWidgetFormInputText(),
      'operacao'           => new sfWidgetFormInputText(),
      'tipo'               => new sfWidgetFormInputText(),
      'codigoprojeto'      => new sfWidgetFormInputText(),
      'codigotarefa'       => new sfWidgetFormInputText(),
      'codigo_tipo'        => new sfWidgetFormInputText(),
      'codigo_subtipo'     => new sfWidgetFormInputText(),
      'codigocadastro'     => new sfWidgetFormInputText(),
      'codigofuncionario'  => new sfWidgetFormInputText(),
      'formapagamento'     => new sfWidgetFormInputText(),
      'saidas'             => new sfWidgetFormInputText(),
      'saidaprevista'      => new sfWidgetFormInputText(),
      'impostos'           => new sfWidgetFormInputText(),
      'datareal'           => new sfWidgetFormDate(),
      'dataprevista'       => new sfWidgetFormDate(),
      'dataemissao'        => new sfWidgetFormDate(),
      'datarecebimentopre' => new sfWidgetFormDate(),
      'descricaosaida'     => new sfWidgetFormTextarea(),
      'for_print'          => new sfWidgetFormInputText(),
      'data_print'         => new sfWidgetFormDate(),
      'baixa'              => new sfWidgetFormInputText(),
      'confirmacao'        => new sfWidgetFormInputText(),
      'confirmadopor'      => new sfWidgetFormInputText(),
      'observacoes'        => new sfWidgetFormTextarea(),      
      'codigoregistro'     => new sfWidgetFormInputText(),
      'parcelas'           => new sfWidgetFormInputText(),
      'fs'                 => new sfWidgetFormInputText(),
      'detalhe'            => new sfWidgetFormInputText(),
      'protocolo'          => new sfWidgetFormInputText(),
      'parcela'            => new sfWidgetFormInputText(),
      'categoria'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'codigo_saida'       => new sfValidatorPropelChoice(array('model' => 'Saidas', 'column' => 'codigo_saida', 'required' => false)),
      'id_compensacao'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'id_pedido'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'documentos'         => new sfValidatorString(array('max_length' => 49, 'required' => false)),
      'centro'             => new sfValidatorString(array('max_length' => 12, 'required' => false)),
      'operacao'           => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'tipo'               => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'codigoprojeto'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigotarefa'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigo_tipo'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigo_subtipo'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigocadastro'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigofuncionario'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'formapagamento'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'saidas'             => new sfValidatorNumber(array('required' => false)),
      'saidaprevista'      => new sfValidatorNumber(array('required' => false)),
      'impostos'           => new sfValidatorNumber(array('required' => false)),
      'datareal'           => new sfValidatorDate(array('required' => false)),
      'dataprevista'       => new sfValidatorDate(array('required' => false)),
      'dataemissao'        => new sfValidatorDate(array('required' => false)),
      'datarecebimentopre' => new sfValidatorDate(array('required' => false)),
      'descricaosaida'     => new sfValidatorString(array('required' => false)),
      'for_print'          => new sfValidatorString(array('required' => false)),
      'data_print'         => new sfValidatorDate(array('required' => false)),
      'baixa'              => new sfValidatorString(array('required' => false)),
      'confirmacao'        => new sfValidatorString(array('required' => false)),
      'confirmadopor'      => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'observacoes'        => new sfValidatorString(array('required' => false)),      
      'codigoregistro'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'parcelas'           => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'fs'                 => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'detalhe'            => new sfValidatorString(array('max_length' => 31, 'required' => false)),
      'protocolo'          => new sfValidatorString(array('max_length' => 7, 'required' => false)),
      'parcela'            => new sfValidatorString(array('max_length' => 17, 'required' => false)),
      'categoria'          => new sfValidatorString(array('max_length' => 2, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('saidas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Saidas';
  }


}
