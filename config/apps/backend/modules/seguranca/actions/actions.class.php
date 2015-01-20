<?php

/**
 * seguranca actions.
 *
 * @package    sgws
 * @subpackage seguranca
 * @author     Your name here
 */
class segurancaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new SegurancaForm();
    
      
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Lista').' Segurança - SGWS');
    if (!$this->getRequestParameter('buscador')){
            $this->buscador = '';
    }else{
            $this->buscador = $this->getRequestParameter('buscador');
    }
    if(!$this->getRequestParameter('by'))
    {
                $this->by = 'desc';               // Variable para el orden de los registros
                $this->by_page = "asc";           // Variable para el paginador y las flechas de orden
                $sortTemp =  LogActividadesPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->sort = $sortTemp[0];      // Nombre del campo que por defecto se ordenara
    }
    //Criterios de busqueda
    $c = new Criteria();
    if($request->isMethod('post'))
    {
        if($this->getRequestParameter('from_date') > $this->getRequestParameter('to_date') && $this->getRequestParameter('to_date'))
        {
            $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('Data inicial deve ser inferior ou igual à data de final'));
            return $this->redirect('seguranca/index');
        }else{
            // Find reservations beginning between the search period
            $criterion1 = $c->getNewCriterion(
              LogActividadesPeer::FECHA, $this->getRequestParameter('from_date'), Criteria::GREATER_EQUAL
            )->addAnd($c->getNewCriterion(
              LogActividadesPeer::FECHA, $this->getRequestParameter('to_date'), Criteria::LESS_EQUAL
            ));

            // Find reservations ending between the search period
            $criterion2 = $c->getNewCriterion(
              LogActividadesPeer::FECHA, $this->getRequestParameter('from_date'), Criteria::GREATER_EQUAL
            )->addAnd($c->getNewCriterion(
              LogActividadesPeer::FECHA, $this->getRequestParameter('to_date'), Criteria::LESS_EQUAL
            ));

            // Find reservations beginning before the search period and ending after
            $criterion3 = $c->getNewCriterion(
              LogActividadesPeer::FECHA, $this->getRequestParameter('to_date'), Criteria::GREATER_EQUAL
            )->addAnd($c->getNewCriterion(
              LogActividadesPeer::FECHA, $this->getRequestParameter('from_date'), Criteria::LESS_EQUAL
            ));

            // Combine all that with a OR
            $c->add($criterion1->addOr($criterion2)->addOr($criterion3));
        }       
        
    }
    $c->addJoin(LogActividadesPeer::ID_USER, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
    if($this->getRequestParameter('sort'))
    {
        $this->sort = $this->getRequestParameter('sort');
        switch ($this->getRequestParameter('by')) {
            case 'desc':
                $c->addDescendingOrderByColumn(LogActividadesPeer::$this->getRequestParameter('sort'));
                $this->by = "asc";
                $this->by_page = "desc";
                break;
            default:
                $c->addAscendingOrderByColumn(LogActividadesPeer::$this->getRequestParameter('sort'));
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
        $criterio = $c->getNewCriterion(LogActividadesPeer::ID_LOG, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
        $criterio->addOr($c->getNewCriterion(LogActividadesPeer::ID_USER, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
        $criterio->addOr($c->getNewCriterion(LogActividadesPeer::IP, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
        $criterio->addOr($c->getNewCriterion(LogActividadesPeer::MODULO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
        $c->add($criterio);
        $buscador = "&buscador=".$this->buscador;
        $this->bus_pagi = "&buscador=".$this->buscador;
    }else{
        $buscador = "";
        $this->bus_pagi = "";
    }
    
    
    $pager = new sfPropelPager('LogActividades',20);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page',1));
    $pager->init();
    $this->LogActividadess = $pager;                
    // Crea sesion de la uri al momento
    $this->getUser()->setAttribute('uri_seguranca','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->LogActividadess->getPage());
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' seguranca - SGWS');
    $this->form = new LogActividadesForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' seguranca - SGWS');
    if (!$request->isMethod('post'))
    {
        $this->redirect("seguranca/new");
    }
    

    $this->form = new LogActividadesForm();
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
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' seguranca - SGWS');
    $this->forward404Unless($LogActividades = LogActividadesPeer::retrieveByPk($request->getParameter('id_log')), sprintf('Object LogActividades does not exist (%s).', $request->getParameter('id_log')));
    $this->form = new LogActividadesForm($LogActividades);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($LogActividades = LogActividadesPeer::retrieveByPk($request->getParameter('id_log')), sprintf('Object LogActividades does not exist (%s).', $request->getParameter('id_log')));
    $this->form = new LogActividadesForm($LogActividades);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($LogActividades = LogActividadesPeer::retrieveByPk($request->getParameter('id_log')), sprintf('Object LogActividades does not exist (%s).', $request->getParameter('id_log')));
    $LogActividades->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('seguranca/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($LogActividades = LogActividadesPeer::retrieveByPk($val), sprintf('Object LogActividades does not exist (%s).', $request->getParameter('id_log')));
                    $LogActividades->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('seguranca/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $LogActividades = $form->save();

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_log')){
        return $this->redirect('@default?module=seguranca&action=index&'.$this->getUser()->getAttribute('uri_seguranca'));
      }else{
        return $this->redirect('seguranca/index');
      }
    }
  }
}
