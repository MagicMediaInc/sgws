<?php
// auto-generated by sfViewConfigHandler
// date: 2015/01/20 17:12:06
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html; charset=utf-8', false);
  $response->addMeta('title', 'SGWS', false, false);

  $response->addStylesheet('main.css', '', array ());
  $response->addStylesheet('jq/jqueryslidemenu.css', '', array ());
  $response->addStylesheet('validationEngineBackend.jquery.css', '', array ());
  $response->addStylesheet('/js/extjs/resources/css/ext-all.css', '', array ());
  $response->addStylesheet('cupertino/jquery-ui-1.8.1.custom.css', '', array ());
  $response->addJavascript('main', '', array ());
  $response->addJavascript('jq/jq.ajaxupload.js', '', array ());
  $response->addJavascript('jq/jqueryslidemenu.js', '', array ());
  $response->addJavascript('lynxCms.js', '', array ());
  $response->addJavascript('/js/extjs/adapter/ext/ext-base', '', array ());
  $response->addJavascript('/js/extjs/ext-all', '', array ());
  $response->addJavascript('jq/jquery-ui-1.8.1.custom.min.js', '', array ());
  $response->addJavascript('jq/jquery.ui.widget.js', '', array ());
  $response->addJavascript('jq/jquery.ui.mouse.js', '', array ());
  $response->addJavascript('jq/jquery.ui.sortable.js', '', array ());
  $response->addJavascript('jq/jquery.validationEngine.js', '', array ());
  $response->addJavascript('jq/jquery.validationEngine-en_US.js', '', array ());
  $response->addJavascript('jq/jquery.price_format.1.8.js', '', array ());


