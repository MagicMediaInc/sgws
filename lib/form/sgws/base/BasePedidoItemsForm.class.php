<?php

/**
 * PedidoItems form base class.
 *
 * @method PedidoItems getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePedidoItemsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'id_pedido'       => new sfWidgetFormInputText(),
      'id_producto'     => new sfWidgetFormInputText(),
      'numero_pedido'   => new sfWidgetFormInputText(),
      'nome'            => new sfWidgetFormInputText(),
      'qt'              => new sfWidgetFormInputText(),
      'preco'           => new sfWidgetFormInputText(),
      'peso'            => new sfWidgetFormInputText(),
      'preco_boleto'    => new sfWidgetFormInputText(),
      'desconto'        => new sfWidgetFormInputText(),
      'desconto_boleto' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'PedidoItems', 'column' => 'id', 'required' => false)),
      'id_pedido'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'id_producto'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'numero_pedido'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'nome'            => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'qt'              => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'preco'           => new sfValidatorNumber(array('required' => false)),
      'peso'            => new sfValidatorNumber(array('required' => false)),
      'preco_boleto'    => new sfValidatorNumber(array('required' => false)),
      'desconto'        => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'desconto_boleto' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pedido_items[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PedidoItems';
  }


}
