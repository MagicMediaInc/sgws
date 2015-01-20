<?php

/**
 * lxuser actions.
 *
 * @package    lynxcmsv4
 * @subpackage lxuser
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class lxuserActions extends sfActions {
    
    public function preExecute() {
        $this->log = new sfLogActivities();
    }
    
    public function executeIndex(sfWebRequest $request) {
        
        $this->log->registerLog();
        $this->getUser()->setAttribute('new_user', 0);
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Lista usuários').' - '.sfConfig::get('app_name_app'));
        if (!$this->getRequestParameter('buscador')) {
            $this->buscador = '';
        }else {
            $this->buscador = $this->getRequestParameter('buscador');
        }
        if(!$this->getRequestParameter('by')) {
            $this->by = 'desc';               // Variable para el orden de los registros
            $this->by_page = "asc";           // Variable para el paginador y las flechas de orden

            //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = 'name';      // Nombre del campo que por defecto se ordenara
        }
        //Criterios de busqueda
        $c = new Criteria();
        if($this->getRequestParameter('sort')) {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {

                case 'desc':
                    $c->addDescendingOrderByColumn(LxUserPeer::$this->getRequestParameter('sort'));
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $c->addAscendingOrderByColumn(LxUserPeer::$this->getRequestParameter('sort'));
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
        }else {
            $c->addAscendingOrderByColumn($this->sort);
        }
        if($this->getRequestParameter('buscador')) {
            sfConfig::set('sf_escaping_strategy', false);
            //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $criterio = $c->getNewCriterion(LxUserPeer::NAME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(LxUserPeer::LOGIN, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(LxUserPeer::EMAIL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $c->add($criterio);
            $buscador = "&buscador=".$this->buscador;
            $this->bus_pagi = "&buscador=".$this->buscador;
        }else {
            $buscador = "";
            $this->bus_pagi = "";
        }
	
        $pager = new sfPropelPager('LxUser',20);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page',1));
        $pager->setPeerMethod('doSelect');
        $pager->init();
        $this->LxUsers = $pager;
        // Lista de Tipos de Cadastros para la busqueda
        $this->tiposCadastro = TipoCadastroPeer::getListTypeCadastro();
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_lxuser','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->LxUsers->getPage());
	
    }

    public function executeNew(sfWebRequest $request) {
        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
        sfConfig::set('sf_escaping_strategy', false);
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Adicionar novo Usuário').' - '.sfConfig::get('app_name_app'));
        $this->form = new LxUserForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        
        $subtipos = SubtipoUserPeer::displayListSubTipos();
        $this->html = "";
        foreach ($subtipos as $st) :
            $this->html.= '<input type="checkbox" id="chk_'.$st['id'].'" name="chk['.$st['id'].']" value="'.$st['id'].'">&nbsp;';
            $this->html.= $st['subtipo'].'<br />';
            $this->html.= $this->findSubTiposChildren($st['id'],"&nbsp;");
        endforeach;
        
    }
    
    function findSubTiposChildren($id_padre=0,$tab="")
    {
        $htm = "";
        $tab.="&nbsp;&nbsp;&nbsp;&nbsp;";
        //echo $id_padre;exit();
        $result = SubtipoUserPeer::findSubTiposChildrenEdit($id_padre);
        if($result)
        {
            foreach ($result as $rs) {
                $htm.= $tab;
                $htm.= '<input type="checkbox" id="chk_'.$rs['id'].'" name="chk['.$rs['id'].']" value="'.$rs['id'].'">&nbsp;';
                $htm.= $rs['subtipo']."<br>";
                $htm.= $this->findSubTiposChildren($rs['id'],"&nbsp;");
            }
        }
        return $htm;
    }

    public function executeCreate(sfWebRequest $request) {
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar usuário').' - Lynx Cms');
        if (!$request->isMethod('post')) {
            $this->redirect("lxuser/new");
        }
        
        $this->form = new LxUserForm();
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request) {       
        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
        sfConfig::set('sf_escaping_strategy', false);
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar usuário').' - '.sfConfig::get('app_name_app'));
        $this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));
        //Evita que se pueda editar el usuario root y administrador del sistema
        $this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() == 1);
        $this->form = new LxUserForm($LxUser);
        $subtipos = SubtipoUserPeer::displayListSubTipos();
        
        $this->getUser()->setAttribute('new_user', $request->getParameter('id_user'));
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->html = "";
        foreach ($subtipos as $st) :
            $this->html.= '<input type="checkbox" id="chk_'.$st['id'].'" name="chk['.$st['id'].']" value="'.$st['id'].'">&nbsp;';
            $this->html.= $st['subtipo'].'<br />';
            $this->html.= $this->findSubTiposChildren($st['id'],"&nbsp;");
        endforeach;
    }

    public function executeUpdate(sfWebRequest $request) {

        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));
        //Evita que se pueda editar el usuario root y administrador del sistema
        $this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() == 1);
        $this->form = new LxUserForm($LxUser);
        
        $this->processForm($request, $this->form);
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        $this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));
        //Evita que se pueda editar el usuario root y administrador del sistema
        $this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() <= 2);
        $LxUser->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('lxuser/index');
    }


    public function executeDeleteAll(sfWebRequest $request) {
        if ($this->getRequestParameter('chk')) {
            foreach ($this->getRequestParameter('chk') as $gr => $val) {
                $this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($val), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));
                //Evita que se pueda editar el usuario root y administrador del sistema
                $this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() <= 2);
                $LxUser->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

        }
        return $this->redirect('lxuser/index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            if ($this->getRequestParameter('chk')) {
            foreach ($this->getRequestParameter('chk') as $gr => $val) {
                echo $val."<br>";
                //$this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($val), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));
            }
            

        }
        exit();
            $form->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            $this->getUser()->setAttribute('new_user', $request->getParameter('id_user'));
            return $this->redirect('lxuser/infoBancaria');            
        }
    }
    /**
   * Cambia el status del usuario
   *
   * @param sfWebRequest $request
   */
  public function executeChangeStatus(sfWebRequest $request)
  {
      $this->forward404Unless($this->LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));      
      $this->forward404If($this->getUser()->getAttribute('idUserPanel')==$request->getParameter('id_user') or $this->LxUser->getIdUser() == 1);
      if($request->getParameter('status'))
      {
        $this->LxUser->setStatus(0);
      }else{
        $this->LxUser->setStatus(1);
      }
      $this->LxUser->save();
  }
  
  public function executeChangeVinculo(sfWebRequest $request)
  {
      $this->forward404Unless($this->LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));
      $this->forward404If(!$this->getUser()->getAttribute('new_user'));
      
      if(VinculoUserPeer::getExistVinculo($this->getUser()->getAttribute('new_user'), $request->getParameter('id_user')))
      {
          VinculoUserPeer::deleteVinculo($this->getUser()->getAttribute('new_user'), $request->getParameter('id_user'));
      }else{
          $newVinculo = new VinculoUser();
          $newVinculo->setIdUser($this->getUser()->getAttribute('new_user'));
          $newVinculo->setIdUserVinculo($request->getParameter('id_user'));
          $newVinculo->save();
          // Agrega el vinculo alreves
          $newVinculo = new VinculoUser();
          $newVinculo->setIdUser($request->getParameter('id_user'));
          $newVinculo->setIdUserVinculo($this->getUser()->getAttribute('new_user'));
          $newVinculo->save();
      }
  }
  
  public function executeInfoBancaria(sfWebRequest $request)
  { 
    $this->redirectIf(!$this->getUser()->getAttribute('new_user'), 'lxuser/index');
    $this->forward404Unless($this->LxUser = LxUserPeer::retrieveByPk($this->getUser()->getAttribute('new_user')), sprintf('Object LxUser does not exist (%s).', $this->getUser()->getAttribute('new_user')));
    $this->bancos = BancoPeer::getListBancos();
    $this->contasPessoa = InfoBancoUserPeer::getListInfoBanco($this->getUser()->getAttribute('new_user'));
    if ($request->isMethod('post')) 
    {
          $id = $this->getRequestParameter('id_info_banco');
          $id_banco = $this->getRequestParameter('id_banco');
          $titular = $this->getRequestParameter('titular');
          $agencia = $this->getRequestParameter('agencia');
          $conta = $this->getRequestParameter('conta');
          foreach ($id as $k => $value) 
          {
                if ($id[$k]){                       
                    //echo "El registro " . $id[$k] . " " . $id_banco[$k] . " existe.";
                    $updateInfo = InfoBancoUserPeer::retrieveByPK($id[$k]);
                    $updateInfo->setIdBanco($id_banco[$k]);
                    $updateInfo->setTitular($titular[$k]);
                    $updateInfo->setAgencia($agencia[$k]);
                    $updateInfo->setNumeroConta($conta[$k]);
                    $updateInfo->save();
                } else {
                    //echo "Cuenta " . $titular[$k] . " - ". $id_banco[$k]. " - ". $agencia[$k]. " - ". $conta[$k]."  <br>.";
                    $newInfo = new InfoBancoUser();
                    $newInfo->setIdUser($this->getUser()->getAttribute('new_user'));
                    $newInfo->setIdBanco($id_banco[$k]);
                    $newInfo->setTitular($titular[$k]);
                    $newInfo->setAgencia($agencia[$k]);
                    $newInfo->setNumeroConta($conta[$k]);
                    $newInfo->save();
                }
          }
          return $this->redirect('lxuser/infoBancaria');
          //exit();
    }
  }
  
  public function executeDeleteInfoBanco(sfWebRequest $request)
  {
      $deleteInfo = InfoBancoUserPeer::retrieveByPK($request->getParameter('id_info'));
      $deleteInfo->delete();
      return sfView::NONE;
  }
  
  public function executeVinculos(sfWebRequest $request)
  {
      $this->redirectIf(!$this->getUser()->getAttribute('new_user'), 'lxuser/index');
      $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Lista usuários').' - '.sfConfig::get('app_name_app'));
        if (!$this->getRequestParameter('buscador')) {
            $this->buscador = '';
        }else {
            $this->buscador = $this->getRequestParameter('buscador');
        }
        if(!$this->getRequestParameter('by')) {
            $this->by = 'desc';               // Variable para el orden de los registros
            $this->by_page = "asc";           // Variable para el paginador y las flechas de orden

            //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = 'name';      // Nombre del campo que por defecto se ordenara
        }
        //Criterios de busqueda
        $c = new Criteria();
        if($this->getRequestParameter('sort')) {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {

                case 'desc':
                    $c->addDescendingOrderByColumn(LxUserPeer::$this->getRequestParameter('sort'));
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $c->addAscendingOrderByColumn(LxUserPeer::$this->getRequestParameter('sort'));
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
        }else {
            $c->addAscendingOrderByColumn($this->sort);
        }
        if($this->getRequestParameter('buscador')) {
            sfConfig::set('sf_escaping_strategy', false);
            //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $criterio = $c->getNewCriterion(LxUserPeer::NAME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(LxUserPeer::LOGIN, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(LxUserPeer::EMAIL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $c->add($criterio);
            $buscador = "&buscador=".$this->buscador;
            $this->bus_pagi = "&buscador=".$this->buscador;
        }else {
            $buscador = "";
            $this->bus_pagi = "";
        }
        if($this->getRequestParameter('radio-cad'))
        {
            $c->add(LxUserPeer::ID_TIPO_CADASTRO, $this->getRequestParameter('radio-cad'), Criteria::EQUAL);
        }
	$c->add(LxUserPeer::ID_USER, $this->getUser()->getAttribute('new_user'), Criteria::NOT_EQUAL);
        $pager = new sfPropelPager('LxUser',20);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page',1));
        $pager->setPeerMethod('doSelect');
        $pager->init();
        $this->LxUsers = $pager;
        // Lista de Tipos de Cadastros para la busqueda
        $this->tiposCadastro = TipoCadastroPeer::getListTypeCadastro();      
  }
  
  public function executePermisos(sfWebRequest $request)
  {
      $this->redirectIf(!$this->getUser()->getAttribute('new_user'), 'lxuser/index');
      $this->profiles = LxProfilePeer::getProfileWithoutAdminAndRoot();
      
      if ($request->isMethod('post')) 
      {
          $idprofile = $this->getRequestParameter('id_profile');
          $atribuiPerfil = LxUserPeer::retrieveByPK($this->getUser()->getAttribute('new_user'));
          $atribuiPerfil->setIdProfile($idprofile);
          $atribuiPerfil->save();   
          $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_perfil_confir')));
      }
      // Consulta datos del perfil del usuario
      $this->perfilActual = LxUserPeer::getPerfilActual($this->getUser()->getAttribute('new_user'));
      if($this->perfilActual)
      {
        //Modulos con permisologia
        $this->modules = LxModulePeer::getParents('0');      
      }
      $this->privileges = LxPrivilegePeer::getAllPrivileges();
  }
  
  /**
   * Status: indica si el check fue activado o desactivado
   * privPpal: Indica si el JS detectó que debe registrarse el Privilegio View (1)
   * Si se selecciona Insert ó Update ó Delete, automáticamente debo registrar View.
   * Si se desactiva View, debo eliminar todos los permisos para ese modulo de ese perfil   * 
   *
   * @param sfWebRequest $request
   * @return <NONE>
   */
  public function executeChangePermissionUser(sfWebRequest $request)
  {
    $this->setLayout(false);
    if($request->getParameter('status'))
    {
        //Debo registrar los permisos
        if(!LxUserModulePeer::valPrivilege($request->getParameter('id_privilege'), $this->getUser()->getAttribute('new_user') , $request->getParameter('id_module')))
        {
            if($request->getParameter('privPpal'))
            {
                // Si no existe, entonces lo registro
                if(!LxUserModulePeer::valPrivilege($request->getParameter('privPpal'), $this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'))){
                    // Registro el privilegio principal
                    LxUserModulePeer::registerPermission($request->getParameter('privPpal'), $this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'), $request->getParameter('type'));
                }
            }
            // Registro el privilegio seleccionado
            LxUserModulePeer::registerPermission($request->getParameter('id_privilege'), $this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'), $request->getParameter('type'));
        }         
    }else{
        /**
         * Debo eliminar los registros
         * Si el privilegio es 1 debo eliminar todos los permisos para ese modulo de ese perfil
         */        
        if($request->getParameter('id_privilege') == 1)
        {            
            LxUserModulePeer::deleteAllPermissions($this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'));
        }else{
            /* Es otro privilegio que no tiene dependencia jerarquica*/
            LxUserModulePeer::eliminaPermiso($request->getParameter('id_privilege'), $this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'));
        }          
    }    
    return sfView::NONE;
  
  }
  
  public function executeUpdateTypeUser(sfWebRequest $request)
  {
    $this->setLayout(false);   
    if(LxUserModulePeer::valPermissionUser($request->getParameter('id_module'), $this->getUser()->getAttribute('new_user')))
    {
        // Si el tipo de permiso es mayor a 2
        if($request->getParameter('type') > 2)
        {
            // Elimina todos los permisos para ese usuario sobre el modulo
            LxUserModulePeer::deleteAllPermissions($this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'));
        }else{
            LxUserModulePeer::updateTypeUserModule($this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'), $request->getParameter('type'));
        }
    }
    return sfView::NONE;
  }
}
