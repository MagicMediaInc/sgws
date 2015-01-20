<?php

/**
 * infobancaria actions.
 *
 * @package    sgws
 * @subpackage infobancaria
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class infobancariaActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
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
          return $this->redirect('infobancaria/index');
          
    }
  }
  
  public function executeDeleteInfoBanco(sfWebRequest $request){
        $deleteInfo = InfoBancoUserPeer::retrieveByPK($request->getParameter('id_info'));
        $deleteInfo->delete();
        return sfView::NONE;
  }
  
}
