<?php

/**
 * Formulario form base class.
 *
 * @method Formulario getObject() Returns the current form's model object
 *
 * @package    Geografia
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFormularioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_formulario' => new sfWidgetFormInputHidden(),
      'nome'          => new sfWidgetFormInputText(),
      'conteudo'      => new sfWidgetFormInputText(),
      'arquivo'       => new sfWidgetFormInputText(),
      'status'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_formulario' => new sfValidatorPropelChoice(array('model' => 'Formulario', 'column' => 'id_formulario', 'required' => false)),
      'nome'          => new sfValidatorString(array('max_length' => 100)),
      'conteudo'      => new sfValidatorString(array('max_length' => 150)),
      'arquivo'       => new sfValidatorString(array('max_length' => 50)),
      'status'        => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('formulario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Formulario';
  }


}
