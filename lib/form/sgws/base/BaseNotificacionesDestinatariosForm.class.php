<?php

/**
 * NotificacionesDestinatarios form base class.
 *
 * @method NotificacionesDestinatarios getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNotificacionesDestinatariosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_destinatario' => new sfWidgetFormInputHidden(),
      'id_notificacion' => new sfWidgetFormInputText(),
      'id_user'         => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_destinatario' => new sfValidatorPropelChoice(array('model' => 'NotificacionesDestinatarios', 'column' => 'id_destinatario', 'required' => false)),
      'id_notificacion' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_user'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'status'          => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('notificaciones_destinatarios[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotificacionesDestinatarios';
  }


}
