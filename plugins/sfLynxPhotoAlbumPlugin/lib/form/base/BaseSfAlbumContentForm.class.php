<?php

/**
 * SfAlbumContent form base class.
 *
 * @method SfAlbumContent getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfAlbumContentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_content' => new sfWidgetFormInputHidden(),
      'id_album'   => new sfWidgetFormInputText(),
      'image'      => new sfWidgetFormInputText(),
      'position'   => new sfWidgetFormInputText(),
      'status'     => new sfWidgetFormInputText(),
      'caption'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_content' => new sfValidatorPropelChoice(array('model' => 'SfAlbumContent', 'column' => 'id_content', 'required' => false)),
      'id_album'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'image'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'position'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'status'     => new sfValidatorString(),
      'caption'    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_album_content[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfAlbumContent';
  }


}
