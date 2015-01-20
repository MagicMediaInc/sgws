<?php

/**
 * SfAlbum form base class.
 *
 * @method SfAlbum getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfAlbumForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_album'    => new sfWidgetFormInputHidden(),
      'id_relation' => new sfWidgetFormInputText(),
      'album_name'  => new sfWidgetFormInputText(),
      'leyenda'     => new sfWidgetFormTextarea(),
      'fecha'       => new sfWidgetFormDate(),
      'status'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_album'    => new sfValidatorPropelChoice(array('model' => 'SfAlbum', 'column' => 'id_album', 'required' => false)),
      'id_relation' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'album_name'  => new sfValidatorString(array('max_length' => 100)),
      'leyenda'     => new sfValidatorString(),
      'fecha'       => new sfValidatorDate(),
      'status'      => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('sf_album[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfAlbum';
  }


}
