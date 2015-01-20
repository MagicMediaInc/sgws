<?php
/**
 * lxlogin actions.
 *
 * @package    lynx4
 * @subpackage lxaccount
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class lxaccountActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Informações da Conta').' - '.sfConfig::get('app_name_app'));

        $this->forward404Unless($LxAccount = LxUserPeer::retrieveByPk($this->getUser()->getAttribute('idUserPanel')), sprintf('Object LxModule does not exist (%s).', $this->getUser()->getAttribute('idUserPanel')));
        $this->form = new AccountForm($LxAccount);
        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
            if ($this->form->isValid())
            {
                
              $LxAccount = $this->form->save();
              //Image process
              if($this->form->getValue('photo'))
              {
                $file = $this->form->getValue('photo');
                
                $Model = LxUserPeer::retrieveByPK($LxAccount->getIdUser());
                // Aqui cargo la imagen con la funcion loadFiles de mi Helper
                sfProjectConfiguration::getActive()->loadHelpers('uploadFile');
                $fileUploaded = loadFiles($file->getOriginalName(), $file->getTempname(), 0, sfConfig::get('sf_upload_dir').'/users/', $Model->getIdUser(), false);
                $Model->setPhoto($fileUploaded);
                $Model->save();
              }
              //Actualiza los datos de la sesion
              $rs = new lynxValida();
              $nome = $rs->datosTipoUsuario($LxAccount->getIdUser(), $LxAccount->getIdTipoUsuario());
              $this->getUser()->setAttribute('nameUser',$nome['nome']);
              $this->getUser()->setAttribute('emailUser',$LxAccount->getEmail());
              $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
              return $this->redirect('lxaccount/index');
            }
        }
    }
    
    public function executeDeleteImage(sfWebRequest $request)
    {
      $this->forward404Unless($Model = LxUserPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Model does not exist (%s).', $request->getParameter('id')));


      //Delete images process
      if ($Model->getPhoto())
      {
        $appYml = sfConfig::get('app_upload_images_lxaccount');
        $uploadDir = sfConfig::get('sf_upload_dir').'/users/';
        for($i=1;$i<=$appYml['copies'];$i++)
        {
          //Delete images from uploads directory
          if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getPhoto()))
          {

            unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getPhoto());
          }
        }
      }
      $Model->setPhoto('');
      $Model->save();
    }
	
}