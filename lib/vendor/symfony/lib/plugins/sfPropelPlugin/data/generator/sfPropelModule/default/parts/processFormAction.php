  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $<?php echo $this->getSingularName() ?> = $form->save();

<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
      $this->redirect('@<?php echo $this->getUrlForAction('edit') ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>);
<?php else: ?>
      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if(<?php echo $this->getRetrieveByPkParamsForAction(43) ?>){
        return $this->redirect('@default?module=<?php echo $this->getModuleName() ?>&action=index&'.$this->getUser()->getAttribute('uri_<?php echo $this->getModuleName() ?>'));
      }else{
        return $this->redirect('<?php echo $this->getModuleName() ?>/index');
      }
<?php endif; ?>
    }
  }
