<?php

/**
 * SfSectionI18n form.
 *
 * @package    lynx4
 * @subpackage form
 * @author     Your name here
 */
class SfSectionI18nForm extends BaseSfSectionI18nForm
{
  public function configure()
  {
      // widgets
      $language = sfContext::getInstance()->getRequest()->getParameter('language');      

      $this->widgetSchema['name_section']->setAttributes(array('class' => 'validate[required]','size' => '40','maxlength' => '30'));
      
      $this->widgetSchema['meta_title']->setAttributes(array('class' => '','size' => '40','maxlength' => '150'));
      $this->widgetSchema['meta_keyword']->setAttributes(array('class' => '','size' => '40','maxlength' => '150'));
      $this->widgetSchema['meta_description']->setAttributes(array('class' => '','size' => '40','maxlength' => '150'));

      //Etiquetas
      $this->widgetSchema->setLabels(array(
        'name_section'                   => 'Nome Sess&atilde;o<span class="required">*</span>',
        'descrip_section_'.$language     => 'Sess&atilde;o conte�do',        
      ));

      //Mensajes de ayuda
      $this->widgetSchema->setHelps(array(
        'meta_title'        => '',
        'meta_keyword'      => 'Example. company name, companys main activity, resources, tools',
        'meta_description'  => 'Example. ABGE is a software package developed by ABGE, designed specifically to manage the contents of a website.'

      ));
      unset($this['descrip_section']);
  }
}
