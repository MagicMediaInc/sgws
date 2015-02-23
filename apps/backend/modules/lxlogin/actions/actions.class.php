<?php

/**
 * lxlogin actions.
 *
 * @package    lynx4
 * @subpackage lxlogin
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class lxloginActions extends sfActions
{
  /**
   * Preexecute
   */
  public function preExecute ()
  {
      
    $this->setLayout('layoutLogin');
  }
  /**
   * Index Login
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    //Si esta autentificado ingresa al sistema
    //$this->redirectIf($this->getUser()->isAuthenticated(),'@default_index?module=home');
    $this->redirectIf($this->getUser()->hasCredential('backend_activo'), '@default_index?module=home');
    $this->frmLogin = new LoginForm();

    if($request->isMethod('post'))
    {
      $this->frmLogin->bind($request->getParameter('wdLogin'));
      if ($this->frmLogin->isValid())
      {
        $this->executeLogin();
      }
    }
  }

    /**
     * Login User
     *
     */
    public function executeLogin()
    {
        //Asigna los datos del usuario a variable de sesion
        $perfil = LxProfilePeer::retrieveByPK($this->frmLogin->dataUser->getIdProfile());
        $this->getUser()->setAttribute('idUserPanel', $this->frmLogin->dataUser->getIdUser());
        $this->getUser()->setAttribute('idProfile',$this->frmLogin->dataUser->getIdProfile());
        $this->getUser()->setAttribute('nomeProfile', $perfil->getNameProfile());
        $this->getUser()->setAttribute('loginUser', $this->frmLogin->dataUser->getLogin());
        $this->getUser()->setAttribute('nameUser',$this->frmLogin->dataUser->getName());
        $this->getUser()->setAttribute('emailUser',$this->frmLogin->dataUser->getEmail());
        
        //Agrega credencial para verificar conflictos con sesion del frontend
        $this->getUser()->addCredential('backend_activo');
        
        //Agrega la credencial de administrador
        lynxValida::setCredentialUser($this->frmLogin->dataUser->getIdUser());
        
        
        //consulta las credencial
//        if($this->frmLogin->dataUser->getIdProfile() == 1 or $this->frmLogin->dataUser->getIdProfile() == 2)
//        {
            $credentials = LxProfileModulePeer::getCredencialUser($this->frmLogin->dataUser->getIdProfile());
            if($credentials) {
                foreach ($credentials as $credential) {
                    //Asigna las credenciales
                    $this->getUser()->addCredential($credential['credential']);
                }
            }
//        }else{
//            $credentials = LxUserModulePeer::getCredencialUser($this->frmLogin->dataUser->getIdUser());
//            if($credentials) {
//                foreach ($credentials as $credential) {
//                    //Asigna las credenciales
//                    $this->getUser()->addCredential($credential['credential'].'_view_'.$credential['type_vision']);
//                    $this->getUser()->addCredential($credential['credential'].'_update_'.$credential['type_vision']);
//                    $this->getUser()->addCredential($credential['credential'].'_insert_'.$credential['type_vision']);
//                    $this->getUser()->addCredential($credential['credential'].'_delete_'.$credential['type_vision']);
//                }
//            }
//        }
        
        if($credentials) {
          //Autentica al usuario
          $this->getUser()->setAuthenticated(true);
          $this->redirect('@default_index?module=home');
        }else {
          ///En caso de no existir credenciales no logea al usuario
          $this->getUser()->setFlash('msn_error', $this->getContext()->getI18N()->__('You do not have privileges to access the system'));
          $this->redirect('@homepage');
        }
    }
/**
 * Cierra la sesion del usuario
 *
 */
public function executeClose() {
  //Si el usuario no esta autenticado en backend, se cierra la sesion del usuario
  if($this->getUser()->hasCredential('asociado_activo')){
    $this->getUser()->clearCredentials();
    $this->getUser()->addCredential('asociado_activo');
  }else{
    $this->getUser()->getAttributeHolder()->clear();
    $this->getUser()->clearCredentials();
    $this->getUser()->setAuthenticated(false);
  }
    
  //Direcciona al login
  $this->redirect('@default_index?module=lxlogin');
}

public function executeChangeLanguage(sfWebRequest $request) {
     if ($request->getParameter('idi') and ($request->getParameter('idi')=='es_ES' or $request->getParameter('idi') =='en_US')) {
       
        $this->getUser()->setCulture($request->getParameter('idi'));
        $this->redirect('@homepage');
    }
}
}
