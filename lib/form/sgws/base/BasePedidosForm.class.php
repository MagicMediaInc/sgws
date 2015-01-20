<?php

/**
 * Pedidos form base class.
 *
 * @method Pedidos getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePedidosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'id_cliente'      => new sfWidgetFormInputText(),
      'id_projeto'      => new sfWidgetFormInputText(),
      'numero_pedido'   => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormInputText(),
      'data'            => new sfWidgetFormDate(),
      'valor'           => new sfWidgetFormInputText(),
      'desconto'        => new sfWidgetFormInputText(),
      'forma_pagamento' => new sfWidgetFormInputText(),
      'peso'            => new sfWidgetFormInputText(),
      'cartao'          => new sfWidgetFormInputText(),
      'num_cartao'      => new sfWidgetFormInputText(),
      'venc_cartao'     => new sfWidgetFormInputText(),
      'nome_cartao'     => new sfWidgetFormInputText(),
      'cods_cartao'     => new sfWidgetFormInputText(),
      'parcelas'        => new sfWidgetFormInputText(),
      'data_pag'        => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'Pedidos', 'column' => 'id', 'required' => false)),
      'id_cliente'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'id_projeto'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'numero_pedido'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'status'          => new sfValidatorString(array('max_length' => 35, 'required' => false)),
      'data'            => new sfValidatorDate(array('required' => false)),
      'valor'           => new sfValidatorNumber(array('required' => false)),
      'desconto'        => new sfValidatorNumber(array('required' => false)),
      'forma_pagamento' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'peso'            => new sfValidatorNumber(array('required' => false)),
      'cartao'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'num_cartao'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'venc_cartao'     => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'nome_cartao'     => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'cods_cartao'     => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'parcelas'        => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'data_pag'        => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pedidos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pedidos';
  }


}
