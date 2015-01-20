<?php

/**
 * CadastroFisica form base class.
 *
 * @method CadastroFisica getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseCadastroFisicaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_cadastro_fisica' => new sfWidgetFormInputHidden(),
      'id_user'            => new sfWidgetFormInputText(),
      'nome'               => new sfWidgetFormInputText(),
      'cpf'                => new sfWidgetFormInputText(),
      'rg'                 => new sfWidgetFormInputText(),
      'sexo'               => new sfWidgetFormInputText(),
      'cargo'              => new sfWidgetFormInputText(),
      'data_nacimento'     => new sfWidgetFormDate(),
      'ddi_telefone'       => new sfWidgetFormInputText(),
      'ddd_telefone'       => new sfWidgetFormInputText(),
      'telefone'           => new sfWidgetFormInputText(),
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
      'forma_contratacao'  => new sfWidgetFormInputText(),
      'data_registro'      => new sfWidgetFormDate(),
      'data_admissao'      => new sfWidgetFormDate(),
      'data_emissao'       => new sfWidgetFormDate(),
      'observacoes'        => new sfWidgetFormTextarea(),
      'dependentes'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_cadastro_fisica' => new sfValidatorPropelChoice(array('model' => 'CadastroFisica', 'column' => 'id_cadastro_fisica', 'required' => false)),
      'id_user'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'nome'               => new sfValidatorString(array('max_length' => 150)),
      'cpf'                => new sfValidatorString(array('max_length' => 20)),
      'rg'                 => new sfValidatorString(array('max_length' => 30)),
      'sexo'               => new sfValidatorString(),
      'cargo'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'data_nacimento'     => new sfValidatorDate(),
      'ddi_telefone'       => new sfValidatorString(array('max_length' => 4)),
      'ddd_telefone'       => new sfValidatorString(array('max_length' => 4)),
      'telefone'           => new sfValidatorString(array('max_length' => 15)),
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
      'forma_contratacao'  => new sfValidatorString(array('max_length' => 30)),
      'data_registro'      => new sfValidatorDate(),
      'data_admissao'      => new sfValidatorDate(),
      'data_emissao'       => new sfValidatorDate(),
      'observacoes'        => new sfValidatorString(),
      'dependentes'        => new sfValidatorString(array('max_length' => 10)),
    ));

    $this->widgetSchema->setNameFormat('cadastro_fisica[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CadastroFisica';
  }


}
