<?php

/**
 * notificacion actions.
 *
 * @package    sgws
 * @subpackage notificacion
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class notificacionActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' notificacion - Lynx Cms');
    if (!$this->getRequestParameter('buscador')){
            $this->buscador = '';
    }else{
            $this->buscador = $this->getRequestParameter('buscador');
    }
    if(!$this->getRequestParameter('by'))
    {
        $this->by = 'desc';               // Variable para el orden de los registros
        $this->by_page = "asc";           // Variable para el paginador y las flechas de orden
        $sortTemp =  NotificacionesPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
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
                        $c->addDescendingOrderByColumn(NotificacionesPeer::$this->getRequestParameter('sort'));
                        $this->by = "asc";
                        $this->by_page = "desc";
                        break;
                default:
                        $c->addAscendingOrderByColumn(NotificacionesPeer::$this->getRequestParameter('sort'));
                        $this->by = "desc";
                        $this->by_page = "asc";
                        break;
            }
    }else{
            $c->addDescendingOrderByColumn($this->sort);
    }
    if($this->getRequestParameter('buscador'))
    {
    //Desactiva temporalmente el metodo de escape para que funcionen los link de la paginacion
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $criterio = $c->getNewCriterion(NotificacionesPeer::ID_NOTIFICACION, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
        $criterio->addOr($c->getNewCriterion(NotificacionesPeer::ID_USER, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
        $criterio->addOr($c->getNewCriterion(NotificacionesPeer::ASUNTO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
        $criterio->addOr($c->getNewCriterion(NotificacionesPeer::CONTEUDO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
        $criterio->addOr($c->getNewCriterion(NotificacionesPeer::FECHA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
        $criterio->addOr($c->getNewCriterion(NotificacionesPeer::STATUS, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
        $c->add($criterio);
        $buscador = "&buscador=".$this->buscador;
        $this->bus_pagi = "&buscador=".$this->buscador;
    }else{
        $buscador = "";
        $this->bus_pagi = "";
    }

    $pager = new sfPropelPager('Notificaciones',10);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page',1));
    $pager->init();
    $this->Notificacioness = $pager;             
    // Actualiza a ya vistas las notificaciones del usuario logeado
    NotificacionesDestinatariosPeer::actualizaStatus($this->getUser()->getAttribute('idUserPanel'),'0');
    // Crea sesion de la uri al momento
    $this->getUser()->setAttribute('uri_notificacion','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->Notificacioness->getPage());
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' notificacion - Lynx Cms');
    $this->form = new NotificacionesForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->vinculados = LxUserPeer::getOtrosUsuarios($this->getUser()->getAttribute('idUserPanel'));
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' notificacion - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("notificacion/new");
    }
    $this->form = new NotificacionesForm();
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->vinculados = LxUserPeer::getOtrosUsuarios($this->getUser()->getAttribute('idUserPanel'));
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' notificacion - Lynx Cms');
    $this->forward404Unless($Notificaciones = NotificacionesPeer::retrieveByPk($request->getParameter('id_notificacion')), sprintf('Object Notificaciones does not exist (%s).', $request->getParameter('id_notificacion')));
    $this->form = new NotificacionesForm($Notificaciones);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->vinculados = LxUserPeer::getOtrosUsuarios($this->getUser()->getAttribute('idUserPanel'));
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Notificaciones = NotificacionesPeer::retrieveByPk($request->getParameter('id_notificacion')), sprintf('Object Notificaciones does not exist (%s).', $request->getParameter('id_notificacion')));
    $this->form = new NotificacionesForm($Notificaciones);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->vinculados = LxUserPeer::getOtrosUsuarios($this->getUser()->getAttribute('idUserPanel'));
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Notificaciones = NotificacionesPeer::retrieveByPk($request->getParameter('id_notificacion')), sprintf('Object Notificaciones does not exist (%s).', $request->getParameter('id_notificacion')));
    $Notificaciones->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('notificacion/index');
  }

  public function executeDeleteResposta(sfWebRequest $request)
  {
    $this->forward404Unless($Resposta = NotificacionesRespostaPeer::retrieveByPk($request->getParameter('id_resposta')), sprintf('Object Respostas does not exist (%s).', $request->getParameter('id_resposta')));
    $Resposta->delete();
    return sfView::NONE;
  }

  public function executeDeleteAll(sfWebRequest $request)
  {
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($Notificaciones = NotificacionesPeer::retrieveByPk($val), sprintf('Object Notificaciones does not exist (%s).', $request->getParameter('id_notificacion')));
                    $Notificaciones->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('notificacion/index');
  }

  public function executeCriaResposta(sfWebRequest $request)
  {
        $id     = $request->getParameter('id_notificacion');
        $texto  = $request->getParameter('texto');
        $newComent = new NotificacionesResposta();
        $newComent->setIdUser($this->getUser()->getAttribute('idUserPanel'));
        $newComent->setIdNotificacion($id);
        $newComent->setConteudo($texto);
        $newComent->setData(date("Y-m-d h:i"));
        $newComent->save();
        // Actualiza status de la notificacion para el usuario
        $vinculados = NotificacionesDestinatariosPeer::getVinculados($id, $this->getUser()->getAttribute('idUserPanel'));
        if($vinculados)
        {
            foreach ($vinculados as $vinc) {
                NotificacionesDestinatariosPeer::actualizaStatusNotificacion($id, $vinc['id_user'], '1');
            }
        }
        return true;
    }

    public function executeListaRespostas(sfWebRequest $request)
    {
        $this->valida = new lynxValida();
        $this->forward404Unless($this->Notificacion = NotificacionesPeer::retrieveByPk($request->getParameter('id_notificacion')), sprintf('Object Notificaciones does not exist (%s).', $request->getParameter('id_notificacion')));
        $this->comentarios = NotificacionesRespostaPeer::listComentarios($request->getParameter('id_notificacion'));
    }

    public function executeTotalRespostas(sfWebRequest $request)
    {
        $this->valida = new lynxValida();
        $this->total = NotificacionesRespostaPeer::totalComentarios($request->getParameter('id_notificacion'));
        echo $this->total;
        return sfView::NONE;
    }

    public function executePessoasVinculadas(sfWebRequest $request)
    {
        $this->setLayout('layoutSimple');
        $this->valida = new lynxValida();
        $this->forward404Unless($this->Notificacion = NotificacionesPeer::retrieveByPk($request->getParameter('id_notificacion')), sprintf('Object Notificaciones does not exist (%s).', $request->getParameter('id_notificacion')));
        $this->vinculados = NotificacionesDestinatariosPeer::getVinculados($request->getParameter('id_notificacion'));
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
          $Notificaciones = $form->save();
          if ($this->getRequestParameter('chk'))
          {
            // Delete Notificaciones
            NotificacionesDestinatariosPeer::deleteVinculosNotificacionByUser($Notificaciones->getIdNotificacion());
            // Agrega Notificaciones
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                $vinculaPessoa = new NotificacionesDestinatarios();
                $vinculaPessoa->setIdNotificacion($Notificaciones->getIdNotificacion());
                $vinculaPessoa->setIdUser($val);
                $vinculaPessoa->save();
            }        
            // Se agrega el usuario logeado a los destinatarios
            $vinculaPessoa = new NotificacionesDestinatarios();
            $vinculaPessoa->setIdNotificacion($Notificaciones->getIdNotificacion());
            $vinculaPessoa->setIdUser($this->getUser()->getAttribute('idUserPanel'));
            $vinculaPessoa->save();
          }

          $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
          if($request->getParameter('id_notificacion')){
            return $this->redirect('@default?module=notificacion&action=index&'.$this->getUser()->getAttribute('uri_notificacion'));
          }else{
            return $this->redirect('notificacion/index');
          }
        }
    }
}
