<?php

/**
 * SfSeccionAlbum form base class.
 *
 * @method SfSeccionAlbum getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfSeccionAlbumForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_seccion_album' => new sfWidgetFormInputHidden(),
      'id_seccion'       => new sfWidgetFormInputText(),
      'id_album'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_seccion_album' => new sfValidatorPropelChoice(array('model' => 'SfSeccionAlbum', 'column' => 'id_seccion_album', 'required' => false)),
      'id_seccion'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_album'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('sf_seccion_album[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfSeccionAlbum';
  }


}
