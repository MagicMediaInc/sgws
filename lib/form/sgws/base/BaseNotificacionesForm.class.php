<?php

/**
 * Notificaciones form base class.
 *
 * @method Notificaciones getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNotificacionesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_notificacion' => new sfWidgetFormInputHidden(),
      'id_user'         => new sfWidgetFormInputText(),
      'asunto'          => new sfWidgetFormInputText(),
      'conteudo'        => new sfWidgetFormTextarea(),
      'fecha'           => new sfWidgetFormDate(),
      'status'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_notificacion' => new sfValidatorPropelChoice(array('model' => 'Notificaciones', 'column' => 'id_notificacion', 'required' => false)),
      'id_user'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'asunto'          => new sfValidatorString(array('max_length' => 100)),
      'conteudo'        => new sfValidatorString(),
      'fecha'           => new sfValidatorDate(),
      'status'          => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('notificaciones[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Notificaciones';
  }


}
