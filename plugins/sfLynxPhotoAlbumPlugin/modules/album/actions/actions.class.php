<?php

/**
 * album actions.
 *
 * @package    perigen
 * @subpackage album
 * @author     Your name here
 */
class albumActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->getUser()->setAttribute('idAlbum', '');
    $this->getUser()->setAttribute('items', '');

    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' photo albums - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  SfAlbumPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
      		//PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = 'album_name';      // Nombre del campo que por defecto se ordenara
		}
		//Criterios de busqueda
		$c = new Criteria();
                if($this->getUser()->getAttribute('idProfile') > 2)
                {
                    $c->add(SfAlbumPeer::ID_RELATION, sfContext::getInstance()->getUser()->getAttribute('idProfile'));
                }
		if($this->getRequestParameter('sort'))
		{
                    $this->sort = $this->getRequestParameter('sort');
                    switch ($this->getRequestParameter('by')) {
                        case 'desc':
                                $c->addDescendingOrderByColumn(SfAlbumPeer::$this->getRequestParameter('sort'));
                                $this->by = "asc";
                                $this->by_page = "desc";
                                break;
                        default:
                                $c->addAscendingOrderByColumn(SfAlbumPeer::$this->getRequestParameter('sort'));
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
                $criterio = $c->getNewCriterion(SfAlbumPeer::ALBUM_NAME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                $c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('SfAlbum',15);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->SfAlbums = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_album','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->SfAlbums->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' photo album - Lynx Cms');
    $this->form = new SfAlbumForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' photo album - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("album/new");
    }
    $this->form = new SfAlbumForm();
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
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' photo album - Lynx Cms');
    $this->forward404Unless($SfAlbum = SfAlbumPeer::retrieveByPk($request->getParameter('id_album')), sprintf('Object SfAlbum does not exist (%s).', $request->getParameter('id_album')));

    //Paso los itmes de la galeria al formulario
    $c = new Criteria();
    $c->addAscendingOrderByColumn('position');
    $c->add(SfAlbumContentPeer::ID_ALBUM, $request->getParameter('id_album'));
    $items = SfAlbumContentPeer::doSelect($c);
    $this->getUser()->setAttribute('items', $items);
    $this->getUser()->setAttribute('idAlbum', $SfAlbum->getIdAlbum());

    $this->form = new SfAlbumForm($SfAlbum);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($SfAlbum = SfAlbumPeer::retrieveByPk($request->getParameter('id_album')), sprintf('Object SfAlbum does not exist (%s).', $request->getParameter('id_album')));
    $this->form = new SfAlbumForm($SfAlbum);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($SfAlbum = SfAlbumPeer::retrieveByPk($request->getParameter('id_album')), sprintf('Object SfAlbum does not exist (%s).', $request->getParameter('id_album')));

    //Delete images process
    $c = new Criteria();
    $c->add(SfAlbumContentPeer::ID_ALBUM, $request->getParameter('id_album'));
    $items = SfAlbumContentPeer::doSelect($c);
    if ($items)
    {
        $appYml = sfConfig::get('app_upload_images_album');
        $uploadDir = sfConfig::get('sf_upload_dir').'/photo_album/';
        foreach ($items as $item)
        {
            for($i=1;$i<=$appYml['copies'];$i++)
            {
              //Delete images from uploads directory
              if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$item->getImage()))
              {
                unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$item->getImage());
              }
            }
        }
    }

    //Album and album content delete (Cascade)
    $SfAlbum->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('album/index');
  }

public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($SfAlbum = SfAlbumPeer::retrieveByPk($val), sprintf('Object SfAlbum does not exist (%s).', $request->getParameter('id_album')));

                    //Delete images process
                    $c = new Criteria();
                    $c->add(SfAlbumContentPeer::ID_ALBUM, $SfAlbum->getIdAlbum());
                    $items = SfAlbumContentPeer::doSelect($c);
                    if ($items)
                    {
                        $appYml = sfConfig::get('app_upload_images_album');
                        $uploadDir = sfConfig::get('sf_upload_dir').'/photo_album/';
                        foreach ($items as $item)
                        {
                            for($i=1;$i<=$appYml['copies'];$i++)
                            {
                              //Delete images from uploads directory
                              if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$item->getImage()))
                              {
                                unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$item->getImage());
                              }
                            }
                        }
                    }

                    //Album and albunContents delete (Cascade)
                    $SfAlbum->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('album/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $SfAlbum = $form->save();

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_album')){
        return $this->redirect('@default?module=album&action=index&'.$this->getUser()->getAttribute('uri_album'));
      }else{
        return $this->redirect('album/index');
      }
    }
  }

  public function executeChangeStatus(sfWebRequest $request)
  {
      $this->forward404Unless($this->item = SfAlbumPeer::retrieveByPK($request->getParameter('id')), sprintf('Object News does not exist (%s).', $request->getParameter('id')));
      $this->field = $request->getParameter('field');
      if ($request->getParameter('field') == 'status')
      {
          if($request->getParameter('status'))
          {
            $this->item->setStatus(0);
          }else{
            $this->item->setStatus(1);
          }
          $this->item->save();
      }
  }

  public function executeSaveAlbum(sfWebRequest $request)
  {
      if ($request->getParameter('edit') == 'true')
      {
          $id = $this->getUser()->getAttribute('idAlbum');
          $this->forward404Unless($item = SfAlbumPeer::retrieveByPK($id), sprintf('Object News does not exist (%s).', $id));
          $form = new SfAlbumForm($item);
          $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
          if ($form->isValid())
          {
            $SfAlbum = $form->save();
            return true;
          }
          
      }else{
          $form = new SfAlbumForm();
          $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
          if ($form->isValid())
          {
            $SfAlbum = $form->save();
            $this->getUser()->setAttribute('idAlbum', $SfAlbum->getIdAlbum());
            return true;
          }
      }
      return false;
  }

  public function executeUploadImage(sfWebRequest $request)
  {
    $this->setLayout('layoutErrorImage');
    sfProjectConfiguration::getActive()->loadHelpers('uploadFile');
    // Subo la imagen
    $this->errorImage = false;
    if($_FILES['uploadfile']['size'] >  sfConfig::get('app_image_size_max'))
    {
        $this->errorImage = true;

    }else{
        $this->errorImage = false;

        $idAlbum = $this->getUser()->getAttribute('idAlbum');

        $c = new Criteria();
        $c->addDescendingOrderByColumn('position');
        $c->add(SfAlbumContentPeer::ID_ALBUM, $idAlbum);
        $items = SfAlbumContentPeer::doSelect($c);

        $this->item = new SfAlbumContent();
        $this->item->setIdAlbum($idAlbum);
        //Position assignment
        if ($items)
        {
            $this->item->setPosition($items[0]->getPosition() + 1);
        }else{
            $this->item->setPosition(0);
        }
        $this->item->setStatus(1);
        $this->item->save();

        // Now, upload new file and save data
        $this->fileUploaded = loadFiles($_FILES['uploadfile']['name'], $_FILES['uploadfile']['tmp_name'], 0, sfConfig::get('sf_upload_dir').'/photo_album/', $this->item->getIdContent(), false);
        $this->item->setImage($this->fileUploaded);
        $this->item->save();
    }
  }

  public function executeDeleteImage(sfWebRequest $request)
  {
    $this->forward404Unless($Model = SfAlbumContentPeer::retrieveByPK($this->getRequestParameter('id')), sprintf('Object Model does not exist (%s).', $request->getParameter('id')));

    //Delete images process
    $appYml = sfConfig::get('app_upload_images_album');
    $uploadDir = sfConfig::get('sf_upload_dir').'/photo_album/';
    for($i=1;$i<=$appYml['copies'];$i++)
    {
      //Delete images from uploads directory
      if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getImage()))
      {
        unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getImage());
      }
    }
    $Model->delete();
    return true;
  }

  public function executeChangePosition(sfWebRequest $request)
  {
    foreach ($request->getParameter('item') as $position => $id)
    {
        /** Update position **/
        $item = SfAlbumContentPeer::retrieveByPK($id);
        $item->setPosition($position);
        $item->save();
    }
    return true;
  }
  
  public function executeVisualizacionNucleo(sfWebRequest $request)
  {
      $this->setLayout('layoutSimple');
      $this->forward404Unless($this->album = SfAlbumPeer::retrieveByPk($request->getParameter('id_album')), sprintf('Object Model does not exist (%s).', $request->getParameter('id_album')));
      
      $this->nucleos = LxProfilePeer::getProfileWithoutAdminAndRoot();
      
  }
  
  /**
   * Cambia el status del nucleo para la noticia
   *
   * @param sfWebRequest $request
   */
  public function executeChangeStatusAccess(sfWebRequest $request)
  {
      $this->nucleo = SfAlbumAccessPeer::getSelectActiveNucleo($request->getParameter('id_nucleo'),$request->getParameter('id_album'));
      $this->forward404If(!$request->getParameter('id_nucleo') && !$request->getParameter('id_album'));
      if($request->getParameter('status'))
      {
        $this->editAccess = SfAlbumAccessPeer::retrieveByPk($this->nucleo->getIdAccessAlbum());
        $this->editAccess->delete();
        $this->status = 0;
        
      }else{
        $this->editAccess = new SfAlbumAccess();
        $this->editAccess->setIdNucleo($request->getParameter('id_nucleo'));
        $this->editAccess->setIdAlbum($request->getParameter('id_album'));
        $this->editAccess->save();
        $this->status = 1;
      }
  }
}
