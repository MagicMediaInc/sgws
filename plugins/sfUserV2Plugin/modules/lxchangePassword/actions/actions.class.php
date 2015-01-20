<?php

/**
 * lxchangePassword actions.
 *
 * @package    lynxcmsv2
 * @subpackage lxchangePassword
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class lxchangePasswordActions extends sfActions {
    /**
     * Executes index action
     *
     */
    public function executeIndex(sfWebRequest $request) {
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Trocar senha').' - '.sfConfig::get('app_name_app'));
        $this->forward404Unless($LxAccount = LxUserPeer::retrieveByPk($this->getUser()->getAttribute('idUserPanel')), sprintf('Object LxModule does not exist (%s).', $this->getUser()->getAttribute('idUserPanel')));
        $this->form = new PasswordForm($LxAccount);
        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
            if ($this->form->isValid())
            {
              $LxAccount->setPassword(md5($this->form->getValue('password'))) ;
              $LxAccount->save();
              $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
              return $this->redirect('@default_index?module=lxchangePassword');
            }
        }
        
    }
}
