<?php

/**
 * SfArchivosSeccion form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SfArchivosSeccionForm extends BaseSfArchivosSeccionForm
{
  public function configure()
  {
    $idProfile = sfContext::getInstance()->getUser()->getAttribute('idProfile');
    $tipo =  sfContext::getInstance()->getRequest()->getParameter('tipo');  	
    // Idioma Principal
    $languagePpal = SfLanguagePeer::getLanguagePrincipal();

    // Modulos Padres
    if($idProfile > 2)
    {
        $modulesPaterns = SfSectionPeer::findSectionsPaternsByNucleo($languagePpal['language'],"",$idProfile);
    }else{
        $modulesPaterns = SfSectionPeer::findSectionsPaterns($languagePpal['language'],"");
    }
    
    $this->widgetSchema['id_seccion'] = new sfWidgetFormChoice(array('choices'  => $modulesPaterns,'expanded' => false),array('size' => '10'));
    $this->widgetSchema['titulo_archivo']->setAttributes(array('class' => 'validate[required]','size' => '35','maxlength' => '150'));
    
    $types = array('1' => 'Arquivos de seções', '2' => 'Arquivos restritos para associados');
    $this->widgetSchema['tipo_archivo'] = new sfWidgetFormSelect(array('choices' => $types));
    
    // Widget File Editable
    $this->widgetSchema['archivo'] = new sfWidgetFormInputFileEditable(array(
      'file_src' => '',
      'is_image'  => false,
      'edit_mode' => !$this->isNew(),
      'with_delete' => false,
    ));
    $this->widgetSchema['id_seccion'] = new sfWidgetFormInputHidden();
    $this->setDefault('id_seccion', 0);
    
    // Labels
    $this->widgetSchema->setLabels(array(
      'id_seccion'  => 'Seção',
      'archivo'     => 'Arquivo associado',
      'titulo_archivo'     => 'Titulo Arquivo',
      'tipo_archivo'     => 'Selecione',
      
    ));
    // Validator para el File
    $this->validatorSchema['archivo'] = new sfValidatorFile(array(
       'required'   => false,
       'max_size'   => sfConfig::get('app_image_size_max'),
       'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/gif', 'application/vnd.ms-excel', 'text/plain', 'application/vnd.ms-powerpoint', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ),
    ));    
    
    //Mensajes de ayuda
    $this->widgetSchema->setHelps(array(
         'archivo'      => 'Arquivos permitidos: jpg, gif, png, txt, ppt, pdf, doc, xls.',	         
         'tipo_archivo' => 'Para os membros: apenas os membros podem visualizar o arquivo <br />
                            Para seções:  a ser atribuído a notícias, cursos e eventos.
                            ',	         
    ));
    
  }
  
  protected function doSave($con = null)
  {
  	// Si hay un nuevo archivo por subir y ya mi registro tiene un archivo asociado entonces,
    if ($this->getObject()->getArchivo() && $this->getValue('archivo'))
	{
    	// Elimino las fotos de la carpeta
        if(is_file(sfConfig::get('sf_upload_dir').'/arquivos/'.$this->getObject()->getArchivo()))
        {
        	unlink(sfConfig::get('sf_upload_dir').'/arquivos/'.$this->getObject()->getArchivo());
		}
	}
	return parent::doSave($con);
  }
  
}
