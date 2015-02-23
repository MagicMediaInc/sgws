<?php

/**
 * mail actions.
 *
 * @package    sgws
 * @subpackage mail
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mailActions extends sfActions
{
 public function executeRetrievePassword()
    {
        $this->setLayout(false);
        
        $i18n = sfContext::getInstance()->getI18N();
        $this->dom='http://'.$this->getRequest()->getHost().'/images/';
        //Asigna plantilla
        $tpl = new XTemplate(sfConfig::get('sf_app_module_dir').'/mail/templates/retrievePassword.tpl');
        $tpl->assign('LINK','dominio');
        $tpl->assign('URL',$this->dom);
        
        $tpl->assign('IP',$_SERVER['REMOTE_ADDR']);
        $tpl->assign('COPYRIGHT',  sfConfig::get('app_name_app'));
        $nameUser = LxUserPeer::getNameUserByEmail($this->getRequest()->getAttribute('email'));
        $fullname = $nameUser['name_user'];
        $tpl->assign('full_name',$fullname);
        $tpl->assign('new_password_temporary',$this->getRequest()->getAttribute('new_password'));
        $tpl->parse('retrievepassword');
        $asunto = $i18n->__("Retrieve Password");
        $message = $this->getMailer()->compose(array(sfConfig::get('app_mail_info') => "Stocksys"),$this->getRequest()->getAttribute('email'),$asunto,$tpl->text('retrievepassword'));
        $headers = $message->getHeaders();
        $subj = $headers->get('Content-Type');
        $subj->setValue('text/html');
        $this->getMailer()->send($message);
        $this->getUser()->setFlash('ready',sfConfig::get('app_msn_retrieve_pass'));
        $this->getContext()->getController()->redirect('@default?module=lxlogin');
    }
}
