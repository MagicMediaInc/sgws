<?php

/**
 * lxuserpermission actions.
 *
 * @package    lynx4
 * @subpackage lxuserpermission
 * @author     Henry Vallenilla
 */
class lxuserpermissionActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  
      $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Lista usuários').'  - '.sfConfig::get('app_name_app'));
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			//PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = 'name';      // Nombre del campo que por defecto se ordenara
		}
		//Criterios de busqueda
		$c = new Criteria();
		if($this->getRequestParameter('sort'))
		{
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
		}else{
			$c->addAscendingOrderByColumn($this->sort);
		}
		if($this->getRequestParameter('buscador'))
		{
                //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $criterio = $c->getNewCriterion(LxUserPeer::ID_USER, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                $criterio->addOr($c->getNewCriterion(LxUserPeer::NAME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                $c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('LxUser',20);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->LxProfiles = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_lxuser_per','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->LxProfiles->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Agregar novo núcleo').' - '.sfConfig::get('app_name_app'));
    $this->form = new LxProfileForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar núcleo').' - '.sfConfig::get('app_name_app'));
    if (!$request->isMethod('post'))
    {
        $this->redirect("lxprofile/new");
    }
    $this->form = new LxProfileForm();
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar núcleo').' - '.sfConfig::get('app_name_app'));
    $this->forward404Unless($LxProfile = LxProfilePeer::retrieveByPk($request->getParameter('id_profile')), sprintf('Object LxProfile does not exist (%s).', $request->getParameter('id_profile')));
    $this->forward404If($this->getUser()->getAttribute('idProfile')==$request->getParameter('id_profile') or $LxProfile->getIdProfile() == 1);
    $this->form = new LxProfileForm($LxProfile);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($LxProfile = LxProfilePeer::retrieveByPk($request->getParameter('id_profile')), sprintf('Object LxProfile does not exist (%s).', $request->getParameter('id_profile')));
    $this->forward404If($this->getUser()->getAttribute('idProfile')==$request->getParameter('id_profile') or $LxProfile->getIdProfile() == 1);
    $this->form = new LxProfileForm($LxProfile);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($LxProfile = LxProfilePeer::retrieveByPk($request->getParameter('id_profile')), sprintf('Object LxProfile does not exist (%s).', $request->getParameter('id_profile')));
    $this->forward404If($this->getUser()->getAttribute('idProfile')==$request->getParameter('id_profile') or $LxProfile->getIdProfile() == 1);
    $LxProfile->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('lxprofile/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $LxProfile = $form->save();

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_profile')){
        return $this->redirect('lxprofile/index');
      }else{
        // Crea los permisos por defecto de Account Information y Change Password
        for($i=2;$i<=3;$i++)
        {
            $LxProfileModule = new LxProfileModule();
            $LxProfileModule->setIdPrivilege(1); // Privilegio View
            $LxProfileModule->setIdProfile($LxProfile->getIdProfile());
            $LxProfileModule->setIdModule($i); // Modulo Account Information(2) y ChangePassword(3)
            $LxProfileModule->save();
        }
        return $this->redirect('lxprofile/index');
      }
    }
  }
  /**
   * Muestra Listado de los módulos para asignarles los permisos CRUD
   * El módulo Modules no se visualiza, este por defecto tiene los permisos solo para el administrador
   * Los perfiles que no sean Administrator o Administrator Cliente solo visualizan los módulos Account Information,
   * Change Password; Y aquellos módulos que no sean default del Lynx y que haya creado el Administrador Principal
   *
   * @param sfWebRequest $request
   */
  public function executePermission(sfWebRequest $request)
  {
      // Verifica si el usuario tiene una credencial
    if(!$this->getUser()->hasCredential('lx_profile_update')){
        echo '<div class="ppalText">'.$this->getContext()->getI18N()->__(sfConfig::get('mod_lxprofile_msn_no_permissions')).'</div>';
        exit();
    }
    
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Permissões').' profile - Lynx Cms');
    $this->forward404Unless($LxProfile = LxProfilePeer::retrieveByPk($request->getParameter('id_profile')), sprintf('Object LxProfile does not exist (%s).', $request->getParameter('id_profile')));
    $this->forward404If($this->getUser()->getAttribute('idProfile')==$request->getParameter('id_profile') or $LxProfile->getIdProfile() == 1);
    
    //Identifica el modulo padre
    //$idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    
    
    $this->modulesNucleo = LxProfileModulePeer::getModuleByProfile($request->getParameter('id_profile'));
    //$this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

    
    //$this->LxModules = LxModulePeer::getOnlyChildren();
    $this->idProfile = $request->getParameter('id_profile');
    $this->idUser = $request->getParameter('id_user');
    //$this->LxModules = $this->Modulos($this->idProfile);
    
    $this->nameProfile = $LxProfile->getNameProfile();
    $this->statusProfile = $LxProfile->getStatus();
  }

  public function Modulos($idProfile) {
        //$this->modulesParents = LxModulePeer::getUserModule($this->getUser()->getAttribute('idProfile'));
        $LxPrivileges = LxPrivilegePeer::getAllPrivileges();
        $modulesParents = LxModulePeer::getParents('0');
        $this->html='<table width="100%" cellpadding="0" cellspacing="3" border="0" >';
		foreach ($modulesParents as $modulesParent):
			$this->html.='<tr><td><b>'.$modulesParent['module_name'].'</b>';
               
			$this->html.= $this->ArmarArbolHijo($modulesParent['module_id'],$idProfile,'20');
			$this->html.='</td></tr>';
		endforeach;
		$this->html.='</table><br style="clear: left" />';
                return $this->html;
    }

   public function ArmarArbolHijo($id_padre="", $idProfile, $tab="")
   {
       $LxPrivileges = LxPrivilegePeer::getAllPrivileges();
	$htm_axu="";
        $tab = $tab + $tab ;
	$children = LxModulePeer::getOnlyChildrenPermissions($id_padre);
	if($children)
	{
		$htm_axu.='<table width="100%" cellpadding="0" cellspacing="3" border="0" align="left" >';
		foreach ($children as $subTmp)
		{
                    $hijosModulo = LxModulePeer::validaHijosModulo($subTmp['module_id']);
                    if(LxProfileModulePeer::valPrivilege(1, $idProfile, $subTmp['module_id'])){
                        $style = "inline";
                        $desactive = "inline";
                        $active = "none";
                    }else{
                        $style = "none";
                        $desactive = "none";
                        $active = "inline";
                    }
                    $htm_axu.='<tr><td>
                    <table width="100%" cellpadding="0" cellspacing="3" border="0" style="padding-left:'.$tab.'px;" >
                         <tr>
                            <td>
                                <div class="displayTitle">                                      
                                      <a class="asc" href="javascript://" id="displayPrivDesactive_'.$subTmp['module_id'].'" style="display: '.$desactive.';"  onclick="hidePrivileges('.$subTmp['module_id'].')"><image src="../images/asc_roll.png" border="0" /></a>
                                      <a class="desc" href="javascript://" id="displayPrivActive_'.$subTmp['module_id'].'" style="display: '.$active.';" onclick="showPrivileges('.$subTmp['module_id'].')"><image src="../images/desc_roll.png" border="0" /> </a>
                                      ';
                                      if($hijosModulo):
                                      $htm_axu.='
                                          <span class="tituloPermission">
                                          '.$subTmp['module_name'].'
                                          </span>';
                                      else:
                                      $htm_axu.='                                          
                                          '.$subTmp['module_name'].'';
                                      endif;
                                $htm_axu.='
                                </div>
                            </td>
                         </tr>
                         <tr>
                            <td>
                                ';
                                    
                                    $htm_axu.='
                                    <div class="permissions_'.$subTmp['module_id'].'" style="display: '.$style.';" align="left">
                                        <form name="privileges_module_'.$subTmp['module_id'].'" method="post" action="">
                                            <table width="200" cellpadding="0" cellspacing="3" border="0" align="left" >
                                                <tr>';
                                                    foreach ($LxPrivileges as $privilege):
                                                        if($subTmp['module_id'] == 2 || $subTmp['module_id'] == 3):
                                                            if($privilege['id_privilege'] == 1 ):
                                                    $htm_axu.='<td align="right" width="25">'.$privilege['name_privilege'].'</td>';
                                                            if(LxProfileModulePeer::valPrivilege($privilege['id_privilege'], $idProfile, $subTmp['module_id'])){
                                                                $checked = " checked";
                                                            }else{
                                                                $checked = " ";
                                                            }
                                                            $htm_axu.='<td align="left"><input '.$checked.' type="checkbox" id="chk_'.$subTmp['module_id'].'_'.$privilege['id_privilege'].'" name="chk_'.$subTmp['module_id'].'_['.$privilege['id_privilege'].']" value="'.$privilege['id_privilege'].'" onclick="submitPermissions('.$subTmp['module_id'].','.$privilege['id_privilege'].','.$idProfile.');"></td>';
                                                            endif;
                                                        else:
                                                            $htm_axu.='<td align="right">'.$privilege['name_privilege'].'</td>';
                                                                if(LxProfileModulePeer::valPrivilege($privilege['id_privilege'], $idProfile, $subTmp['module_id'])){
                                                                    $checked = " checked";
                                                                }else{
                                                                    $checked = " ";
                                                                }
                                                            $htm_axu.='<td align="left"><input '.$checked.' type="checkbox" id="chk_'.$subTmp['module_id'].'_'.$privilege['id_privilege'].'" name="chk_'.$subTmp['module_id'].'_['.$privilege['id_privilege'].']" value="'.$privilege['id_privilege'].'" onclick="submitPermissions('.$subTmp['module_id'].','.$privilege['id_privilege'].','.$idProfile.');"></td>';
                                                        endif;
                                                    endforeach;
                                                    $htm_axu.='<td><div id="message_'.$subTmp['module_id'].'" class="msjPermissions"  ></div></td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                                ';
                            $htm_axu.='</td>
                         </tr>
                    </table>
                    </td></tr><tr><td>
                    ';
                    
                    $htm_axu.= $this->ArmarArbolHijo($subTmp['module_id'], $idProfile, $tab);
                    
                    $htm_axu.="</td></tr>";
		}
		$htm_axu.="</table>";
	}
	return $htm_axu;
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
    //Debo registrar los permisos
    if(!LxUserModulePeer::valPermissionUser($request->getParameter('id_module'), $request->getParameter('id_user')))
    {
        if($request->getParameter('status'))
        {
            // Registro el privilegio principal
            LxUserModulePeer::newPermission($request->getParameter('id_user'), $request->getParameter('id_module'));
        }
    }else{
        if(!$request->getParameter('status'))
        {            
            LxUserModulePeer::deletePermission($request->getParameter('id_user'), $request->getParameter('id_module'));
        }
    }       
        
    return sfView::NONE;
  }
  /**
   * Cambia el status del perfil
   *
   * @param sfWebRequest $request
   */
  public function executeChangeStatus(sfWebRequest $request)
  {
      $this->forward404Unless($this->LxProfile = LxProfilePeer::retrieveByPk($request->getParameter('id_profile')), sprintf('Object LxProfile does not exist (%s).', $request->getParameter('id_profile')));
      $this->forward404If($this->getUser()->getAttribute('idProfile')==$request->getParameter('id_profile') or $this->LxProfile->getIdProfile() == 1);
      if($request->getParameter('status'))
      {
        $this->LxProfile->setStatus(0);
      }else{
        $this->LxProfile->setStatus(1);
      }
      $this->LxProfile->save();
  }
}
