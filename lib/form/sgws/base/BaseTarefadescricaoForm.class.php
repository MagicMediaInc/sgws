<?php

/**
 * Tarefadescricao form base class.
 *
 * @method Tarefadescricao getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTarefadescricaoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Descricao' => new sfWidgetFormInputHidden(),
      'Tarefa'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'Descricao' => new sfValidatorPropelChoice(array('model' => 'Tarefadescricao', 'column' => 'Descricao', 'required' => false)),
      'Tarefa'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tarefadescricao[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tarefadescricao';
  }


}
