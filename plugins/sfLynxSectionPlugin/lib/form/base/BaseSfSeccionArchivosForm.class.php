<?php

/**
 * SfSeccionArchivos form base class.
 *
 * @method SfSeccionArchivos getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfSeccionArchivosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_seccion_archivo' => new sfWidgetFormInputHidden(),
      'id_seccion'         => new sfWidgetFormInputText(),
      'id_archivo'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_seccion_archivo' => new sfValidatorPropelChoice(array('model' => 'SfSeccionArchivos', 'column' => 'id_seccion_archivo', 'required' => false)),
      'id_seccion'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_archivo'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('sf_seccion_archivos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfSeccionArchivos';
  }


}
