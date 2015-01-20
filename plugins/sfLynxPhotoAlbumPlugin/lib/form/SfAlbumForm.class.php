<?php

/**
 * SfAlbum form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SfAlbumForm extends BaseSfAlbumForm
{
  public function configure()
  {
    $fieldSize = 69;
    
    $idProfile = sfContext::getInstance()->getUser()->getAttribute('idProfile');
    $nucleos = LxProfilePeer::findProfilesById($idProfile);
    // widgets
    $this->widgetSchema['edit'] = new sfWidgetFormInputHidden(array(), array('id' => 'edit', 'name' => 'edit', 'value' => 'false'));
    //$this->widgetSchema['id_relation']->setAttributes(array('class' => 'validate[required]'));
    $this->widgetSchema['leyenda'] = new sfWidgetFormRichTextarea(array('tool'=>'Custom','height' => '400'), array('class' => 'validate[required]'));
    $this->widgetSchema['leyenda'] = new sfWidgetFormTextarea(array(), array('class' => 'validate[required]'));
    if($idProfile <= 2)
    {
        $this->widgetSchema['id_relation'] = new sfWidgetFormPropelChoice(array('model' => 'LxProfile', 'add_empty' => true));
    }else{
        $this->widgetSchema['id_relation'] = new sfWidgetFormChoice(array('choices'  => $nucleos,'expanded' => false),array('size' => '4'));
        $this->setDefault('id_relation',$idProfile);
        $this->validatorSchema['id_relation']  = new sfValidatorChoice(array('choices' => array_keys($nucleos)));
    }
    
    $this->widgetSchema['album_name']->setAttributes(array('class' => 'validate[required]', 'size' => $fieldSize));

    $types = array('1' => 'Habilitado', '0' => 'Desabilitado');
    $this->widgetSchema['status'] = new sfWidgetFormSelect(array('choices' => $types));
    

    //Validators
    $this->validatorSchema['id_relation'] = new sfValidatorString(array('required' => false));
    $this->validatorSchema['album_name']  = new sfValidatorString(array('required' => true, 'trim' => true));
    $this->validatorSchema['edit']  = new sfValidatorString(array('required' => false));

    //Etiquetas
    $this->widgetSchema->setLabels(array(
        'album_name'  => 'Nome do álbum <span class="required">*</span>',
        'id_relation' => 'Notícia relacionada',
        'leyenda' => 'Leyenda',
    ));
  }
}
