<?php

/**
 * Cadastro form base class.
 *
 * @method Cadastro getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCadastroForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigocadastro'    => new sfWidgetFormInputHidden(),
      'TipoCadastro'      => new sfWidgetFormInputText(),
      'RazaoSocial'       => new sfWidgetFormInputText(),
      'NomeFantasia'      => new sfWidgetFormInputText(),
      'CNPJ'              => new sfWidgetFormInputText(),
      'InscricaoEstadual' => new sfWidgetFormInputText(),
      'InscricaoCom'      => new sfWidgetFormInputText(),
      'Endereco'          => new sfWidgetFormInputText(),
      'Numero'            => new sfWidgetFormInputText(),
      'Complemento'       => new sfWidgetFormInputText(),
      'Bairro'            => new sfWidgetFormInputText(),
      'Cidade'            => new sfWidgetFormInputText(),
      'CEP'               => new sfWidgetFormInputText(),
      'Estado'            => new sfWidgetFormInputText(),
      'Pais'              => new sfWidgetFormInputText(),
      'Telefone'          => new sfWidgetFormInputText(),
      'Fax'               => new sfWidgetFormInputText(),
      'email'             => new sfWidgetFormInputText(),
      'Contato1'          => new sfWidgetFormInputText(),
      'TelefoneCon1'      => new sfWidgetFormInputText(),
      'CelularCon1'       => new sfWidgetFormInputText(),
      'EmailContato1'     => new sfWidgetFormInputText(),
      'Contato2'          => new sfWidgetFormInputText(),
      'TelefoneCon2'      => new sfWidgetFormInputText(),
      'CelularCon2'       => new sfWidgetFormInputText(),
      'EmailContato2'     => new sfWidgetFormInputText(),
      'Contato3'          => new sfWidgetFormInputText(),
      'TelefoneCon3'      => new sfWidgetFormInputText(),
      'CelularCon3'       => new sfWidgetFormInputText(),
      'EmailContato3'     => new sfWidgetFormInputText(),
      'Contato4'          => new sfWidgetFormInputText(),
      'TelefoneCon4'      => new sfWidgetFormInputText(),
      'CelularCon4'       => new sfWidgetFormInputText(),
      'EmailContato4'     => new sfWidgetFormInputText(),
      'Contato5'          => new sfWidgetFormInputText(),
      'TelefoneCon5'      => new sfWidgetFormInputText(),
      'CelularCon5'       => new sfWidgetFormInputText(),
      'EmailContato5'     => new sfWidgetFormInputText(),
      'EnderecoSite'      => new sfWidgetFormInputText(),
      'nivelprivacidade'  => new sfWidgetFormInputText(),
      'codigocliente'     => new sfWidgetFormInputText(),
      'subtipo'           => new sfWidgetFormInputText(),
      'categoria'         => new sfWidgetFormInputText(),
      'status'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'codigocadastro'    => new sfValidatorPropelChoice(array('model' => 'Cadastro', 'column' => 'codigocadastro', 'required' => false)),
      'TipoCadastro'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'RazaoSocial'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'NomeFantasia'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'CNPJ'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'InscricaoEstadual' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'InscricaoCom'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Endereco'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Numero'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Complemento'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Bairro'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Cidade'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CEP'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Estado'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Pais'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Telefone'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Fax'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Contato1'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'TelefoneCon1'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CelularCon1'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'EmailContato1'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Contato2'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'TelefoneCon2'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CelularCon2'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'EmailContato2'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Contato3'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'TelefoneCon3'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CelularCon3'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'EmailContato3'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Contato4'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'TelefoneCon4'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CelularCon4'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'EmailContato4'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Contato5'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'TelefoneCon5'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CelularCon5'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'EmailContato5'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'EnderecoSite'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'nivelprivacidade'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigocliente'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'subtipo'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'categoria'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'status'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cadastro[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cadastro';
  }


}
