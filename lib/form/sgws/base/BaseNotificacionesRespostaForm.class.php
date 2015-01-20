<?php

/**
 * NotificacionesResposta form base class.
 *
 * @method NotificacionesResposta getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNotificacionesRespostaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_resposta'     => new sfWidgetFormInputHidden(),
      'id_notificacion' => new sfWidgetFormInputText(),
      'id_user'         => new sfWidgetFormInputText(),
      'conteudo'        => new sfWidgetFormTextarea(),
      'data'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_resposta'     => new sfValidatorPropelChoice(array('model' => 'NotificacionesResposta', 'column' => 'id_resposta', 'required' => false)),
      'id_notificacion' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_user'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'conteudo'        => new sfValidatorString(),
      'data'            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('notificaciones_resposta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotificacionesResposta';
  }


}
