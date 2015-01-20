  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' <?php echo $this->getModuleName() ?> - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("<?php echo $this->getModuleName() ?>/new");
    }
<?php if (isset($this->params['with_propel_route']) && $this->params['with_propel_route']): ?>
<?php else: ?>
    

<?php endif; ?>
    $this->form = new <?php echo $this->getModelClass().'Form' ?>();
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }
