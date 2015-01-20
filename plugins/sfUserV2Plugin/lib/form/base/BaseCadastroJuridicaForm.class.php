<?php

/**
 * CadastroJuridica form base class.
 *
 * @method CadastroJuridica getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseCadastroJuridicaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_empresa'         => new sfWidgetFormInputHidden(),
      'codigo_velhio'      => new sfWidgetFormInputText(),
      'status'             => new sfWidgetFormInputText(),
      'id_user'            => new sfWidgetFormInputText(),
      'codigo_cliente'     => new sfWidgetFormInputText(),
      'tipo_cadastro'      => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'nome_fantasia'      => new sfWidgetFormInputText(),
      'razao_social'       => new sfWidgetFormInputText(),
      'cnpj'               => new sfWidgetFormInputText(),
      'incripcao_estadual' => new sfWidgetFormInputText(),
      'incripcao_ccm'      => new sfWidgetFormInputText(),
      'site'               => new sfWidgetFormInputText(),
      'ddi_telefone'       => new sfWidgetFormInputText(),
      'ddd_telefone'       => new sfWidgetFormInputText(),
      'telefone'           => new sfWidgetFormInputText(),
      'ddi_fax'            => new sfWidgetFormInputText(),
      'ddd_fax'            => new sfWidgetFormInputText(),
      'fax'                => new sfWidgetFormInputText(),
      'ddi_celular'        => new sfWidgetFormInputText(),
      'ddd_celular'        => new sfWidgetFormInputText(),
      'celular'            => new sfWidgetFormInputText(),
      'endereco'           => new sfWidgetFormTextarea(),
      'numero'             => new sfWidgetFormInputText(),
      'complemento'        => new sfWidgetFormInputText(),
      'pais'               => new sfWidgetFormInputText(),
      'id_uf'              => new sfWidgetFormInputText(),
      'id_municipio'       => new sfWidgetFormInputText(),
      'barrio'             => new sfWidgetFormInputText(),
      'cep'                => new sfWidgetFormInputText(),
      'observacoes'        => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id_empresa'         => new sfValidatorPropelChoice(array('model' => 'CadastroJuridica', 'column' => 'id_empresa', 'required' => false)),
      'codigo_velhio'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'status'             => new sfValidatorString(array('required' => false)),
      'id_user'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'codigo_cliente'     => new sfValidatorString(array('max_length' => 20)),
      'tipo_cadastro'      => new sfValidatorString(array('max_length' => 50)),
      'email'              => new sfValidatorString(array('max_length' => 100)),
      'nome_fantasia'      => new sfValidatorString(array('max_length' => 150)),
      'razao_social'       => new sfValidatorString(array('max_length' => 150)),
      'cnpj'               => new sfValidatorString(array('max_length' => 20)),
      'incripcao_estadual' => new sfValidatorString(array('max_length' => 30)),
      'incripcao_ccm'      => new sfValidatorString(array('max_length' => 30)),
      'site'               => new sfValidatorString(array('max_length' => 150)),
      'ddi_telefone'       => new sfValidatorString(array('max_length' => 4)),
      'ddd_telefone'       => new sfValidatorString(array('max_length' => 4)),
      'telefone'           => new sfValidatorString(array('max_length' => 15)),
      'ddi_fax'            => new sfValidatorString(array('max_length' => 4)),
      'ddd_fax'            => new sfValidatorString(array('max_length' => 4)),
      'fax'                => new sfValidatorString(array('max_length' => 15)),
      'ddi_celular'        => new sfValidatorString(array('max_length' => 4)),
      'ddd_celular'        => new sfValidatorString(array('max_length' => 4)),
      'celular'            => new sfValidatorString(array('max_length' => 15)),
      'endereco'           => new sfValidatorString(),
      'numero'             => new sfValidatorString(array('max_length' => 10)),
      'complemento'        => new sfValidatorString(array('max_length' => 10)),
      'pais'               => new sfValidatorString(array('max_length' => 4)),
      'id_uf'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_municipio'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'barrio'             => new sfValidatorString(array('max_length' => 50)),
      'cep'                => new sfValidatorString(array('max_length' => 10)),
      'observacoes'        => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('cadastro_juridica[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CadastroJuridica';
  }


}
