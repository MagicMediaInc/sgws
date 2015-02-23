<?php

/**
 * archivo actions.
 *
 * @package    fito
 * @subpackage archivo
 * @author     Your name here
 */
class archivoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' archivo - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  SfArchivosSeccionPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
      		//PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = $sortTemp[0];      // Nombre del campo que por defecto se ordenara
		}
		//Criterios de busqueda
		$c = new Criteria();
		if($this->getRequestParameter('sort'))
		{
			$this->sort = $this->getRequestParameter('sort');
			switch ($this->getRequestParameter('by')) {

				case 'desc':
					$c->addDescendingOrderByColumn(SfArchivosSeccionPeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(SfArchivosSeccionPeer::$this->getRequestParameter('sort'));
					$this->by = "desc";
					$this->by_page = "asc";
					break;
			}
		}else{
			$c->addAscendingOrderByColumn($this->sort);
		}
		if($this->getRequestParameter('buscador'))
		{
                //Desactiva temporalmente el metodo de escape para que funcionen los link de la paginacion
                sfConfig::set('sf_escaping_strategy', false);
                //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
                    $criterio = $c->getNewCriterion(SfArchivosSeccionPeer::ID_ARCHIVO_SECCION, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                    $criterio->addOr($c->getNewCriterion(SfArchivosSeccionPeer::ID_SECCION, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                    $criterio->addOr($c->getNewCriterion(SfArchivosSeccionPeer::TITULO_ARCHIVO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                    $criterio->addOr($c->getNewCriterion(SfArchivosSeccionPeer::ARCHIVO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                    $c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
                if($this->getRequestParameter('tipo'))
                {
                    if($criterio)
                    {
                        $criterio->addAnd($c->getNewCriterion(SfArchivosSeccionPeer::TIPO_ARCHIVO,$this->getRequestParameter('tipo'), Criteria::EQUAL));
                    }else{
                        $c->add(SfArchivosSeccionPeer::TIPO_ARCHIVO,$this->getRequestParameter('tipo'), Criteria::EQUAL);
                    }
                    
                } 
			
		$pager = new sfPropelPager('SfArchivosSeccion',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->SfArchivosSeccions = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_archivo','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->SfArchivosSeccions->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' archivo - Lynx Cms');
    $this->form = new SfArchivosSeccionForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' archivo - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("archivo/new");
    }
    

    $this->form = new SfArchivosSeccionForm();
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' archivo - Lynx Cms');
    $this->forward404Unless($SfArchivosSeccion = SfArchivosSeccionPeer::retrieveByPk($request->getParameter('id_archivo_seccion')), sprintf('Object SfArchivosSeccion does not exist (%s).', $request->getParameter('id_archivo_seccion')));
    $this->form = new SfArchivosSeccionForm($SfArchivosSeccion);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($SfArchivosSeccion = SfArchivosSeccionPeer::retrieveByPk($request->getParameter('id_archivo_seccion')), sprintf('Object SfArchivosSeccion does not exist (%s).', $request->getParameter('id_archivo_seccion')));
    $this->form = new SfArchivosSeccionForm($SfArchivosSeccion);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($SfArchivosSeccion = SfArchivosSeccionPeer::retrieveByPk($request->getParameter('id_archivo_seccion')), sprintf('Object SfArchivosSeccion does not exist (%s).', $request->getParameter('id_archivo_seccion')));
    $SfArchivosSeccion->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('archivo/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($SfArchivosSeccion = SfArchivosSeccionPeer::retrieveByPk($val), sprintf('Object SfArchivosSeccion does not exist (%s).', $request->getParameter('id_archivo_seccion')));
                    $SfArchivosSeccion->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('archivo/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $SfArchivosSeccion = $form->save();
      
      if($form->getValue('archivo'))
        {
                $file = $form->getValue('archivo');
                // Aqui cargo la imagen con la funcion loadFiles de mi Helper
                sfProjectConfiguration::getActive()->loadHelpers('upload');
                $fileUploaded = loadFile($file->getOriginalName(), $file->getTempname(), 0, sfConfig::get('sf_upload_dir').'/arquivos/' ,'archivoseccion_'.$SfArchivosSeccion->getIdArchivoSeccion(), true);
                $SfArchivosSeccion->setArchivo($fileUploaded);
                $SfArchivosSeccion->save();
        }
      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_archivo_seccion')){
        return $this->redirect('@default?module=archivo&action=index&'.$this->getUser()->getAttribute('uri_archivo'));
      }else{
        return $this->redirect('archivo/index');
      }
    }
  }
  
  /** Delete File
   * @param sfWebRequest $request
   */
  public function executeDeleteFile(sfWebRequest $request)
  {
    $this->forward404Unless($info = SfArchivosSeccionPeer::retrieveByPk($request->getParameter('id_archivo_seccion')), sprintf('Object Productos does not exist (%s).', $request->getParameter('id_archivo_seccion')));
    $dir = sfConfig::get('sf_upload_dir')."/arquivos";
    $dir_handle = opendir($dir);
    if ($dir_handle)
    {
        // Elimino las Productos de la carpeta
        if(is_file($dir."/".$info->getArchivo()))
        {
        	unlink($dir."/".$info->getArchivo());
        }
        closedir($dir_handle);
    }
    $info->setArchivo('');
    $info->save();
  }
}
