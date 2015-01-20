<?php

/**
 * SfAlbumAccess form base class.
 *
 * @method SfAlbumAccess getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfAlbumAccessForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_access_album' => new sfWidgetFormInputHidden(),
      'id_nucleo'       => new sfWidgetFormInputText(),
      'id_album'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_access_album' => new sfValidatorPropelChoice(array('model' => 'SfAlbumAccess', 'column' => 'id_access_album', 'required' => false)),
      'id_nucleo'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_album'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('sf_album_access[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfAlbumAccess';
  }


}
