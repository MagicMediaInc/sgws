<?php

/**
 * SfSeccionVideo form base class.
 *
 * @method SfSeccionVideo getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfSeccionVideoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_seccion_video' => new sfWidgetFormInputHidden(),
      'id_seccion'       => new sfWidgetFormInputText(),
      'id_video'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_seccion_video' => new sfValidatorPropelChoice(array('model' => 'SfSeccionVideo', 'column' => 'id_seccion_video', 'required' => false)),
      'id_seccion'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_video'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('sf_seccion_video[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfSeccionVideo';
  }


}
