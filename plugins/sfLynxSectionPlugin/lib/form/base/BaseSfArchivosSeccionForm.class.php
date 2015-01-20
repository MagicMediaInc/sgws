<?php

/**
 * SfArchivosSeccion form base class.
 *
 * @method SfArchivosSeccion getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfArchivosSeccionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_archivo_seccion' => new sfWidgetFormInputHidden(),
      'id_seccion'         => new sfWidgetFormInputText(),
      'titulo_archivo'     => new sfWidgetFormInputText(),
      'archivo'            => new sfWidgetFormInputText(),
      'tipo_archivo'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_archivo_seccion' => new sfValidatorPropelChoice(array('model' => 'SfArchivosSeccion', 'column' => 'id_archivo_seccion', 'required' => false)),
      'id_seccion'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'titulo_archivo'     => new sfValidatorString(array('max_length' => 100)),
      'archivo'            => new sfValidatorString(array('max_length' => 150)),
      'tipo_archivo'       => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('sf_archivos_seccion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfArchivosSeccion';
  }


}
