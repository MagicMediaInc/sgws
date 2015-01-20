<?php

/**
 * Tarefa form base class.
 *
 * @method Tarefa getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTarefaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CodigoTarefa'    => new sfWidgetFormInputHidden(),
      'tarefa_parent'   => new sfWidgetFormInputText(),
      'Responsavel'     => new sfWidgetFormInputText(),
      'CodigoProjeto'   => new sfWidgetFormInputText(),
      'visualizacao'    => new sfWidgetFormInputText(),
      'Descricao'       => new sfWidgetFormInputText(),
      'tipo_tarefa'     => new sfWidgetFormInputText(),
      'DataIRTarefa'    => new sfWidgetFormDate(),
      'DataFRTarefa'    => new sfWidgetFormDate(),
      'Status'          => new sfWidgetFormInputText(),
      'DespesaPrevista' => new sfWidgetFormInputText(),
      'HorasPrevistas'  => new sfWidgetFormInputText(),
      'observacoes'     => new sfWidgetFormTextarea(),
      'informacoes'     => new sfWidgetFormTextarea(),
      'id_prioridade'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'CodigoTarefa'    => new sfValidatorPropelChoice(array('model' => 'Tarefa', 'column' => 'CodigoTarefa', 'required' => false)),
      'tarefa_parent'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'Responsavel'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'CodigoProjeto'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'visualizacao'    => new sfValidatorString(array('required' => false)),
      'Descricao'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => true)),
      'tipo_tarefa'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => true)),
      'DataIRTarefa'    => new sfValidatorDate(array('required' => false)),
      'DataFRTarefa'    => new sfValidatorDate(array('required' => false)),
      'Status'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'DespesaPrevista' => new sfValidatorNumber(array('required' => false)),
      'HorasPrevistas'  => new sfValidatorNumber(array('required' => false)),
      'observacoes'     => new sfValidatorString(array('required' => false)),
      'informacoes'     => new sfValidatorString(array('required' => false)),
      'id_prioridade'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tarefa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tarefa';
  }


}
