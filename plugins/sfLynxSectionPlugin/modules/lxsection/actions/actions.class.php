<?php

/**
 * lxsection actions.
 *
 * @package    lynx4
 * @subpackage lxsection
 * @author     Henry Vallenilla -  hvallenilla@aberic.com
 */
class lxsectionActions extends sfActions
{
    public function preExecute() {
        $this->nombreNucleo = LxProfilePeer::getNameProfile($this->getUser()->getAttribute('idProfile'));
    }

    public function executeProcessSortable(sfWebRequest $request)
    {
        foreach ($request->getParameter('listItem') as $position => $item) :
            $update = SfSectionPeer::retrieveByPK($item);
            $update->setPosition($position);
            $update->save();
                //echo "UPDATE `table` SET `position` = $position WHERE `id` = $item <br />";
        endforeach;
    }

    /**
     * Index
     * @param sfWebRequest $request Index
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' Sections - ABGE ');
        $this->nucleosActivos = LxProfilePeer::getProfileWithoutAdminAndRoot();
        $languagePrincipal = SfLanguagePeer::getLanguagePrincipal();
        $this->language = $languagePrincipal['language'];
	if (!$this->getRequestParameter('buscador')){
            $this->buscador = '';
        }else{
            $this->buscador = $this->getRequestParameter('buscador');
        }
        if(!$this->getRequestParameter('by'))
        {
            $this->by = 'desc';               // Variable para el orden de los registros
            $this->by_page = "asc";           // Variable para el paginador y las flechas de orden
            $sortTemp =  SfSectionPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
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
                                $c->addDescendingOrderByColumn(SfSectionPeer::$this->getRequestParameter('sort'));
                                $this->by = "asc";
                                $this->by_page = "desc";
                                break;
                        default:
                                $c->addAscendingOrderByColumn(SfSectionPeer::$this->getRequestParameter('sort'));
                                $this->by = "desc";
                                $this->by_page = "asc";
                                break;
                }
        }else{
                $c->addAscendingOrderByColumn($this->sort);
        }
        if($this->getRequestParameter('buscador'))
        {
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $criterio = $c->getNewCriterion(SfSectionPeer::ID, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::ID_PARENT, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::POSITION, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::CONTROL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::SW_MENU, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::STATUS, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::HOME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::SPECIAL_PAGE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::SHOW_TEXT, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::ONLY_COMPLEMENT, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SfSectionPeer::DELETE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $c->add($criterio);
            $buscador = "&buscador=".$this->buscador;
            $this->bus_pagi = "&buscador=".$this->buscador;
        }else{
            $buscador = "";
            $this->bus_pagi = "";
        }

        $c->addJoin(SfSectionPeer::ID, SfSectionI18nPeer::ID, Criteria::INNER_JOIN);
        $c->add(SfSectionI18nPeer::LANGUAGE,$languagePrincipal['language'], Criteria::EQUAL);
        if($this->getUser()->getAttribute('idProfile') > 2)
        {
            $c->add(SfSectionPeer::ID_PROFILE, $this->getUser()->getAttribute('idProfile'), Criteria::EQUAL);
        }
        if($this->getRequestParameter('searchByNucleo'))
        {
            $c->add(SfSectionPeer::ID_PROFILE, $this->getRequestParameter('searchByNucleo'), Criteria::EQUAL);
        }
        $pager = new sfPropelPager('SfSection',1000);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page',1));
        $pager->init();
        $this->SfSections = $pager;
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_lxsection','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->SfSections->getPage());
  
  }
    /**
     * New Section
     * @param sfWebRequest $request
     */
    public function executeNew(sfWebRequest $request)
    {
        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
        sfConfig::set('sf_escaping_strategy', false);
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' section - ABGE ');
        $this->form = new SfSectionForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    }
    /**
     * Create Section
     * @param sfWebRequest $request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar').' section - ABGE ');
        if (!$request->isMethod('post'))
        {
            $this->redirect("lxsection/new");
        }
        $this->form = new SfSectionForm();
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }
    /**
     * Edit Section
     * @param sfWebRequest $request
     */
    public function executeEdit(sfWebRequest $request)
    {
        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($SfSection = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->form = new SfSectionForm($SfSection);
        
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar').' section - ABGE ');        
    }
    /**
     * Funcion editar contenido de seccion por idioma separado por pestanas
     * @param sfWebRequest $request
     */
    public function executeEditContent(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_section = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->sf_section_parent = SfSectionI18nPeer::getNameSection($this->sf_section->getIdParent());
        $this->sf_section_select = SfSectionI18nPeer::getNameSection($this->sf_section->getId());
        $this->sf_section_i18n = new SfSectionI18n();
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar').' section - '.$this->sf_section_select['name_section'].' - ABGE ');
    }
    
    public function executeAsignFile(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_section = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = SfSectionI18nPeer::getNameSection($this->sf_section->getId());
        $this->form = new ArchivoSeccionForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        
        $this->archivosActuales = SfSeccionArchivosPeer::getFilesSection($request->getParameter('id'));
    }
    
    public function executeSaveAsingFile(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_section = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = SfSectionI18nPeer::getNameSection($this->sf_section->getId());
        
        if (!$request->isMethod('post'))
        {
            $this->redirect("lxsection/new");
        }
        $this->form = new ArchivoSeccionForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processFormAsignFile($request, $this->form);
        $this->archivosActuales = SfSeccionArchivosPeer::getFilesSection($request->getParameter('id'));
        $this->setTemplate('asignFile');
    }
    
    protected function processFormAsignFile(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $newFileSection = new SfSeccionArchivos();
            $newFileSection->setIdSeccion($form->getValue('id_seccion'));
            $newFileSection->setIdArchivo($form->getValue('archivo'));
            $newFileSection->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            return $this->redirect('lxsection/asignFile?id='.$form->getValue('id_seccion'));
        }
    }
    
    public function executeDeleteSectionFile(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($SfArchivosSeccion = SfSeccionArchivosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfArchivosSeccion does not exist (%s).', $request->getParameter('id')));
        $SfArchivosSeccion->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('lxsection/asignFile?id='.$SfArchivosSeccion->getIdSeccion());
    }
    /**
     * ALBUMES PARA LA SECCION*/
    
    public function executeAsignAlbum(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_section = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = SfSectionI18nPeer::getNameSection($this->sf_section->getId());
        $this->form = new AlbumSeccionForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        
        $this->albunesActuales = SfSeccionAlbumPeer::getAlbumSection($request->getParameter('id'));
    }
    
    public function executeSaveAsingAlbum(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_section = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = SfSectionI18nPeer::getNameSection($this->sf_section->getId());
        
        if (!$request->isMethod('post'))
        {
            $this->redirect("lxsection/new");
        }
        $this->form = new AlbumSeccionForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processFormAsignAlbum($request, $this->form);
        $this->albunesActuales = SfSeccionAlbumPeer::getAlbumSection($request->getParameter('id'));
        $this->setTemplate('asignAlbum');
    }
    
    public function executeDeleteSectionAlbum(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($SfArchivosAlbum = SfSeccionAlbumPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfArchivosAlbum does not exist (%s).', $request->getParameter('id')));
        $SfArchivosAlbum->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('lxsection/asignAlbum?id='.$SfArchivosAlbum->getIdSeccion());
    }
    
    protected function processFormAsignAlbum(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $newFileSection = new SfSeccionAlbum();
            $newFileSection->setIdSeccion($form->getValue('id_seccion'));
            $newFileSection->setIdAlbum($form->getValue('album'));
            $newFileSection->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            return $this->redirect('lxsection/asignAlbum?id='.$form->getValue('id_seccion'));
        }
    }
    /**
     * VIDEOS PARA LA SECCION*/
    
    public function executeAsignVideo(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_section = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = SfSectionI18nPeer::getNameSection($this->sf_section->getId());
        $this->form = new VideoSeccionForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->videosActuales = SfSeccionVideoPeer::getVideoSection($request->getParameter('id'));
    }
    
    public function executeSaveAsingVideo(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_section = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = SfSectionI18nPeer::getNameSection($this->sf_section->getId());
        
        if (!$request->isMethod('post'))
        {
            $this->redirect("lxsection/new");
        }
        $this->form = new VideoSeccionForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processFormAsignVideo($request, $this->form);
        $this->videosActuales = SfSeccionAlbumPeer::getAlbumSection($request->getParameter('id'));
        $this->setTemplate('asignVideo');
    }
    
    public function executeDeleteSectionVideo(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($SfArchivosVideo = SfSeccionVideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfArchivosAlbum does not exist (%s).', $request->getParameter('id')));
        $SfArchivosVideo->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('lxsection/asignVideo?id='.$SfArchivosVideo->getIdSeccion());
    }
    
    protected function processFormAsignVideo(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $newFileSection = new SfSeccionVideo();
            $newFileSection->setIdSeccion($form->getValue('id_seccion'));
            $newFileSection->setIdVideo($form->getValue('video'));
            $newFileSection->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            return $this->redirect('lxsection/asignVideo?id='.$form->getValue('id_seccion'));
        }
    }
    
    /**
     * Funcion de informacion de seccion por idioma
     * @param sfWebRequest $request
     */
    public function executeInfoLanguage(sfWebRequest $request)
    {
  	$this->setLayout(false);
        sfConfig::set('sf_escaping_strategy', false);       
  	$this->sf_section = SfSectionI18nPeer::retrieveByPK($request->getParameter('id'),$request->getParameter('language'));
        /*
  	 * Si falla es por que no tiene la seccion correspondiente a ese idioma
  	 * por lo tanto creo el registro
  	 */
        
  	if(!$this->sf_section)
  	{
            $this->sf_section = new SfSectionI18n();
            $this->sf_section->setId($request->getParameter('id'));
            $this->sf_section->setLanguage($request->getParameter('language'));
            $this->sf_section->setNameSection('Section '.$request->getParameter('id'));
            $this->sf_section->save();
            $this->sf_section = SfSectionI18nPeer::retrieveByPK($request->getParameter('id'),$request->getParameter('language'));
  	}        
        $this->form = new SfSectionI18nForm($this->sf_section);
    }
    /**
     * Funcion que guarda la informacion de un seccion dado su idioma
     * @param sfWebRequest $request
     */
    public function executeSaveInfoI18n(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($SfSectionI18n = SfSectionI18nPeer::retrieveByPk($request->getParameter('id'),
                     $request->getParameter('language')), sprintf('Object SfSectionI18n does not exist (%s).', $request->getParameter('id'),
                     $request->getParameter('language')));
        $this->form = new SfSectionI18nForm($SfSectionI18n);
        $this->processFormI18n($request, $this->form);
    }
    /**
     * Update principal information section
     *
     * @param sfWebRequest $request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($SfSection = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->form = new SfSectionForm($SfSection);

        $this->processForm($request, $this->form);
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->setTemplate('edit');
    }
    /**
     * Delete section
     * @param sfWebRequest $request
     * @return <redirect>
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $this->forward404Unless($SfSection = SfSectionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $profile = $SfSection->getIdProfile();
        if($SfSection->getHome())
        {
            $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__(sfConfig::get('mod_lxsection_msn_error_del_seccion_home')));
            return $this->redirect('section');
        }        
        $this->deleteChildren($SfSection->getId());        
        $sql = SfSectionPeer::sectionsNext($SfSection->getIdParent(),$SfSection->getPosition());
        if($sql)
        {
            foreach ($sql as $row_menores) {
                //Detecta posicion para evitar actualizar a -1                
                $actualPositionSection = SfSectionPeer::positionActualSection($row_menores['id']);
                echo $actualPositionSection['position']."<br>";
                if($actualPositionSection['position']!= 1 && $row_menores['posicion'] > 0)
                {
                    SfSectionPeer::updatePositionsxDelete($row_menores['id'],$actualPositionSection['position']-1);
                }
            };
            
        }
        $this->deleteInfoI18nSection($request->getParameter('id'));        
        $SfSection->delete();
        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('lxsection/index?searchByNucleo='.$profile);
    }
    /**
     * process Form: guarda los datos principales de una seccion
     * @param sfWebRequest $request
     * @param sfForm $form
     * @return <redirect>
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
          $SfSection = $form->save();
          if (!$this->getContext()->getUser()->hasCredential('admin_lynx')){
            $updateOption = SfSectionPeer::retrieveByPK($SfSection->getId());
            $updateOption->setDelete(1);
            $updateOption->setShowText(1);
            $updateOption->save();
          }
          $idParent = $form->getValue('id_parent');
          // Ahora verifica la ultima posicion del id_padre
          $position = SfSectionPeer::identifiesPosition($idParent);
          if (!$form->getValue('id'))
          {
            $languagePrincipal = SfLanguagePeer::getLanguagePrincipal();
            $SfSection = SfSectionPeer::retrieveByPK($SfSection->getId());
            $SfSection->setIdParent($idParent);
            $SfSection->setPosition($position['position']+1);
            $SfSection->save();
            // Luego inserto el registro en la tabla sfSeccionI18n
            $sf_seccion_i18n = new SfSectionI18n();
            $sf_seccion_i18n->setId($SfSection->getId());
            $sf_seccion_i18n->setNameSection($this->getContext()->getI18N()->__('Section').$SfSection->getId());
            $sf_seccion_i18n->setLanguage($languagePrincipal['language']);
            $sf_seccion_i18n->save();
          }

          $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
          if(!$request->getParameter('id')){
            $languagePpal = SfLanguagePeer::getLanguagePrincipal();
            return $this->redirect('lxsection/editContent?id='.$SfSection->getId().'&paso=2&language='.$languagePpal['language']);            
          }else{
            return $this->redirect('lxsection/index');
          }
        }
    }
    /**
     * process FormI18n: guarda los datos de una seccion por idioma
     * @param sfWebRequest $request
     * @param sfForm $form
     * @return <redirect>
     */
    protected function processFormI18n(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
          $SfSectionI18n = $form->save();
          // Guardo el contenido de la seccion dado su idioma
          $SfSectionI18n = SfSectionI18nPeer::retrieveByPK($request->getParameter('id'),$request->getParameter('language'));
          $SfSectionI18n->setDescripSection($request->getParameter('descrip_section_'.$request->getParameter('language')));
          $SfSectionI18n->save();
          $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
          if($request->getParameter('id')){
            return $this->redirect('lxsection/editContent?id='.$request->getParameter('id').'&language='.$request->getParameter('language'));
          }else{
            return $this->redirect('lxsection/index');
          }
        }
    }
    /**
     * Funcion que elimina los hijos de una seccion padre
     * @param <integer> $idParent
     */
    private function deleteChildren($idParent)
    {
        //busca los hijos
        $delete = SfSectionPeer::checkExistPaterns($idParent);
        if($delete)
        {
            foreach ($delete as $row) {
                $deleteChildren = SfSectionPeer::retrieveByPK($row['id']);
                $deleteChildren->delete();
                $this->deleteInfoI18nSection($row['id']);
                $this->deleteChildren($row['id']);
            };
        }
    }
    /**
     * Elimina la informacion por idioma de una sección
     * @param <integer> $idSection
     */
    private function deleteInfoI18nSection($idSection)
    {
        $languages = SfLanguagePeer::listLanguages();
        foreach ($languages as $language) {
            $sf_section_i18n = SfSectionI18nPeer::retrieveByPK($idSection,$language->getLanguage());
            if($sf_section_i18n){
                   $sf_section_i18n->delete();
            }
        }
    }
    /**
     * Building Sections Tree
     * @param sfWebRequest $request 
     */
    public function executeTreeSections(sfWebRequest $request)
    {
  	$this->nodes = array();
  	// retrieve all children of $parent
	$node = $this->getRequestParameter('node');
	if (  $node == 0){
		$node = 0; // Initial node.
	}
        
	$result = SfSectionI18nPeer::displaySections($node, $this->getUser()->getAttribute('idProfile'));
	$languagePpal = SfLanguagePeer::getLanguagePrincipal();
	// display each child
        if($result){
            foreach ($result as $row) {
                // Response parameters.
                $path['text']		= $row['nameSection'];
                $path['id']             = $row['id'];
                $path['position']	= $row['position'];
                if($row['home'])
                {
                        $path['disabled']	= true;
                }else{
                        $path['disabled']	= false;
                }                
                $server = "http://".$_SERVER['HTTP_HOST'].'/backend.php/';
                $path['href']	    = $server.'lxsection/editContent/id/'.$row['id'].'/language/'.$languagePpal['language'].'/paso/2';
                // Check if node is a leaf or a folder.
                $cCount = SfSectionPeer::countSections($row['id']);
                //$cCount = count($cCount);
                if($cCount > 0){
                        $path['leaf']	= false;
                        $path['cls']	= 'folder';
                        $path['nextSibling'] = false;
                }else{
                        $path['leaf']	= false;
                        $path['cls']	= 'folder';
                        $path['nextSibling'] = false;
                }
                // call this function again to display this
                // child's children
                $this->nodes[] = $path;
            }
        }
    }
    /**
     * Funcion que actualiza la posicion de una seccion al detectar que cambio de posicion
     *
     */
    public function executeListenerMove(sfWebRequest $request)
    { 
  	$id_seccion = $this->getRequestParameter('id_seccion');
	$padre_antes = $this->getRequestParameter('padre_antes');
	$padre_nuevo = $this->getRequestParameter('padre_nuevo');
	$posicion = $this->getRequestParameter('posicion');        
	/*****************************************************************/
	$posicion_actual = SfSectionPeer::positionSection($id_seccion);
	$posicion_actual = $posicion_actual['posicion'];
	if ($padre_antes==$padre_nuevo)
	{
            if ($posicion < $posicion_actual)
            {
                for($i=$posicion_actual;$i>=$posicion;$i--)
                {
                    $nueva_pos=$i+1;
                    if($nueva_pos==0)
                    {
                        $nueva_pos = 1;
                    }
                    SfSectionPeer::updatePosition($nueva_pos,$padre_antes,$i);
                }
            }else{
                for($i=$posicion_actual;$i<=$posicion;$i++)
                {
                    $nueva_pos=$i-1;
                    if($nueva_pos==0)
                    {
                            $nueva_pos = 1;
                    }
                    SfSectionPeer::updatePosition($nueva_pos,$padre_antes,$i);
                }
            }
            SfSectionPeer::updatePrincipalPosition($posicion,$id_seccion);
	}else{
            $result = SfSectionI18nPeer::displaySections($padre_nuevo, $this->getUser()->getAttribute('idProfile'));
            $total = count($result);
            if ($total==0)
            {
                SfSectionPeer::updatePaternSection($padre_nuevo,$id_seccion);
            }else{
                if($result){
                    foreach ($result as $row)
                    {
                        if($row['position']>=$posicion)
                        {
                                $pos_nueva=$row['position']+1;
                                SfSectionPeer::updatePrincipalPosition($pos_nueva,$row['id']);
                        }
                        if ($posicion>$total)
                        {
                                SfSectionPeer::updatePrincipalPosition($posicion,$id_seccion);
                        }
                    }
                }
            }
            // Lee las siguientes secciones a partir de la posicion de la seccion seleccionada
            $siguientes = SfSectionPeer::sectionsNext($padre_antes,$posicion_actual);
            if(count($siguientes))
            {
                $posicion_actual = $posicion_actual - 1;
                if($siguientes)
                {
                    foreach ($siguientes as $dato_seccion) {
                        $posicion_actual++;
                        SfSectionPeer::updatePrincipalPosition($posicion_actual,$dato_seccion['id']);
                    }
                }
            }
            SfSectionPeer::updatePaternSectionPosition($padre_nuevo,$posicion,$id_seccion);
            // Verifica si queda un solo padre para inicializarle la posicion
            $verifica = SfSectionPeer::checkExistPaterns(0);
            if(count($verifica)==1)
            {
                SfSectionPeer::updatePrincipalPosition(1,$verifica['id']);
            }
	}
    }
}
