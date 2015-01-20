  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

<?php if (isset($this->params['with_propel_route']) && $this->params['with_propel_route']): ?>
    $this->getRoute()->getObject()->delete();
<?php else: ?>
    $this->forward404Unless($<?php echo $this->getSingularName() ?> = <?php echo constant($this->getModelClass().'::PEER') ?>::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForAction(43) ?>), sprintf('Object <?php echo $this->getSingularName() ?> does not exist (%s).', <?php echo $this->getRetrieveByPkParamsForAction(43) ?>));
    $<?php echo $this->getSingularName() ?>->delete();
<?php endif; ?>

<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
    $this->redirect('@<?php echo $this->getUrlForAction('index') ?>');
<?php else: ?>
    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('<?php echo $this->getModuleName() ?>/index');
<?php endif; ?>
  }
