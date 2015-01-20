<?php

/**
 * permisos actions.
 *
 * @package    sgws
 * @subpackage permisos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class permisosActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
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
       echo $request->getParameter('status');
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
               LxUserModulePeer::registerPermission($request->getParameter('id_privilege'), $this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'),$request->getParameter('type'));
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

   public function executeChangePermissionUserByPessoa(sfWebRequest $request)
   {
     $this->setLayout(false);
     if($request->getParameter('status'))
     {
         //Debo registrar los permisos
         if(!LxUserModulePeer::valPrivilegeUser($request->getParameter('id_privilege'), $this->getUser()->getAttribute('new_user') , $request->getParameter('id_module'), $request->getParameter('type')))
         {
             if($request->getParameter('privPpal'))
             {
                 // Si no existe, entonces lo registro
                 if(!LxUserModulePeer::valPrivilegeUser($request->getParameter('privPpal'), $this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'),$request->getParameter('type'))){
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
             LxUserModulePeer::deleteAllPermissionsByType($this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'),$request->getParameter('type'));
         }else{
             /* Es otro privilegio que no tiene dependencia jerarquica*/
             LxUserModulePeer::eliminaPermisoPorVista($request->getParameter('id_privilege'), $this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'), $request->getParameter('type'));
         }          
     }    
     return sfView::NONE;

   }


  
  
}
