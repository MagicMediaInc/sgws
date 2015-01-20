<?php

/**
 * Productos form base class.
 *
 * @method Productos getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProductosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'codigo'          => new sfWidgetFormInputText(),
      'destaque'        => new sfWidgetFormInputText(),
      'nome'            => new sfWidgetFormInputText(),
      'ano'             => new sfWidgetFormInputText(),
      'id_categoria'    => new sfWidgetFormInputText(),
      'escala'          => new sfWidgetFormInputText(),
      'peso'            => new sfWidgetFormInputText(),
      'observacoes'     => new sfWidgetFormTextarea(),
      'comprimento'     => new sfWidgetFormInputText(),
      'loja'            => new sfWidgetFormInputText(),
      'largura'         => new sfWidgetFormInputText(),
      'altura'          => new sfWidgetFormInputText(),
      'cor'             => new sfWidgetFormInputText(),
      'preco'           => new sfWidgetFormInputText(),
      'desconto'        => new sfWidgetFormInputText(),
      'desconto_boleto' => new sfWidgetFormInputText(),
      'max_parcelas'    => new sfWidgetFormInputText(),
      'estoque'         => new sfWidgetFormInputText(),
      'min_estoque'     => new sfWidgetFormInputText(),
      'credito'         => new sfWidgetFormInputText(),
      'data_cad'        => new sfWidgetFormDate(),
      'foto'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'Productos', 'column' => 'id', 'required' => false)),
      'codigo'          => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'destaque'        => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'nome'            => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'ano'             => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'id_categoria'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'escala'          => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'peso'            => new sfValidatorNumber(array('required' => false)),
      'observacoes'     => new sfValidatorString(array('required' => false)),
      'comprimento'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'loja'            => new sfValidatorString(array('max_length' => 10, 'required' => true)),
      'largura'         => new sfValidatorNumber(array('required' => false)),
      'altura'          => new sfValidatorNumber(array('required' => false)),
      'cor'             => new sfValidatorString(array('max_length' => 20)),
      'preco'           => new sfValidatorNumber(array('required' => false)),
      'desconto'        => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'desconto_boleto' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'max_parcelas'    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'estoque'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'min_estoque'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'credito'         => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'data_cad'        => new sfValidatorDate(array('required' => false)),
      'foto'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Productos', 'column' => array('id')))
    );

    $this->widgetSchema->setNameFormat('productos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Productos';
  }


}
