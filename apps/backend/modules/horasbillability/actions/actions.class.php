<?php

/**
 * horasbillability actions.
 *
 * @package    sgws
 * @subpackage horasbillability
 * @author     Your name here
 */
class horasbillabilityActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' horasbillability - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  HorasBillabilityPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
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
					$c->addDescendingOrderByColumn(HorasBillabilityPeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(HorasBillabilityPeer::$this->getRequestParameter('sort'));
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
                		                                    $criterio = $c->getNewCriterion(HorasBillabilityPeer::CODIGO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::ANO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES1, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES2, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES3, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES4, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES5, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES6, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES7, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES8, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES9, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES10, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES11, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(HorasBillabilityPeer::MES12, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                					$c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('HorasBillability',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->HorasBillabilitys = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_horasbillability','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->HorasBillabilitys->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' horasbillability - Lynx Cms');
    $this->form = new HorasBillabilityForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' horasbillability - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("horasbillability/new");
    }
    

    $this->form = new HorasBillabilityForm();
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
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' horasbillability - Lynx Cms');
    $this->forward404Unless($HorasBillability = HorasBillabilityPeer::retrieveByPk($request->getParameter('codigo')), sprintf('Object HorasBillability does not exist (%s).', $request->getParameter('codigo')));
    $this->form = new HorasBillabilityForm($HorasBillability);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($HorasBillability = HorasBillabilityPeer::retrieveByPk($request->getParameter('codigo')), sprintf('Object HorasBillability does not exist (%s).', $request->getParameter('codigo')));
    $this->form = new HorasBillabilityForm($HorasBillability);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($HorasBillability = HorasBillabilityPeer::retrieveByPk($request->getParameter('codigo')), sprintf('Object HorasBillability does not exist (%s).', $request->getParameter('codigo')));
    $HorasBillability->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('horasbillability/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($HorasBillability = HorasBillabilityPeer::retrieveByPk($val), sprintf('Object HorasBillability does not exist (%s).', $request->getParameter('codigo')));
                    $HorasBillability->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('horasbillability/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $HorasBillability = $form->save();

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('codigo')){
        return $this->redirect('@default?module=horasbillability&action=index&'.$this->getUser()->getAttribute('uri_horasbillability'));
      }else{
        return $this->redirect('horasbillability/index');
      }
    }
  }
}
