<?php

/**
 * TipoUsuario form base class.
 *
 * @method TipoUsuario getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseTipoUsuarioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_tipo_usuario' => new sfWidgetFormInputHidden(),
      'tipo_usuario'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_tipo_usuario' => new sfValidatorPropelChoice(array('model' => 'TipoUsuario', 'column' => 'id_tipo_usuario', 'required' => false)),
      'tipo_usuario'    => new sfValidatorString(array('max_length' => 30)),
    ));

    $this->widgetSchema->setNameFormat('tipo_usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoUsuario';
  }


}
