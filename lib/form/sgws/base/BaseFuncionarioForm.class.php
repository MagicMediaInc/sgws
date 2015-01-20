<?php

/**
 * Funcionario form base class.
 *
 * @method Funcionario getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFuncionarioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CodigoFuncionario' => new sfWidgetFormInputHidden(),
      'NomeFuncionario'   => new sfWidgetFormInputText(),
      'DataNascimento'    => new sfWidgetFormDate(),
      'Sexo'              => new sfWidgetFormInputText(),
      'Celular'           => new sfWidgetFormInputText(),
      'Telefone'          => new sfWidgetFormInputText(),
      'email'             => new sfWidgetFormInputText(),
      'Endereco'          => new sfWidgetFormInputText(),
      'Numero'            => new sfWidgetFormInputText(),
      'Complemento'       => new sfWidgetFormInputText(),
      'Bairro'            => new sfWidgetFormInputText(),
      'Cidade'            => new sfWidgetFormInputText(),
      'Estado'            => new sfWidgetFormInputText(),
      'Pais'              => new sfWidgetFormInputText(),
      'CEP'               => new sfWidgetFormInputText(),
      'NumeroDependentes' => new sfWidgetFormInputText(),
      'CodigoFerias'      => new sfWidgetFormInputText(),
      'Registro'          => new sfWidgetFormInputText(),
      'RG'                => new sfWidgetFormInputText(),
      'CPF'               => new sfWidgetFormInputText(),
      'Cargo'             => new sfWidgetFormInputText(),
      'NomeUsuario'       => new sfWidgetFormInputText(),
      'Senha'             => new sfWidgetFormInputText(),
      'Nivel'             => new sfWidgetFormInputText(),
      'FormaContratacao'  => new sfWidgetFormInputText(),
      'DataAdmissao'      => new sfWidgetFormDate(),
      'DataDemissao'      => new sfWidgetFormDate(),
      'Salario'           => new sfWidgetFormInputText(),
      'folha'             => new sfWidgetFormInputText(),
      'documento'         => new sfWidgetFormInputText(),
      'status'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'CodigoFuncionario' => new sfValidatorPropelChoice(array('model' => 'Funcionario', 'column' => 'CodigoFuncionario', 'required' => false)),
      'NomeFuncionario'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'DataNascimento'    => new sfValidatorDate(array('required' => false)),
      'Sexo'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Celular'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Telefone'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Endereco'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Numero'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Complemento'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Bairro'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Cidade'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Estado'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Pais'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CEP'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'NumeroDependentes' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CodigoFerias'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Registro'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'RG'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CPF'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Cargo'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'NomeUsuario'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Senha'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Nivel'             => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'FormaContratacao'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'DataAdmissao'      => new sfValidatorDate(array('required' => false)),
      'DataDemissao'      => new sfValidatorDate(array('required' => false)),
      'Salario'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'folha'             => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'documento'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'status'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('funcionario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Funcionario';
  }


}
