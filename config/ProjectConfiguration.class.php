<?php
  require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
  sfCoreAutoload::register();

  class ProjectConfiguration extends sfProjectConfiguration
  {
    public function setup()
    {
      $this->setWebDir($this->getRootDir().'/public_html');
      // set region values
      setlocale(LC_ALL, "pt_BR@BRL", "pt_BR", "ptb");

      $this->enablePlugins(
        'sfPropelPlugin',
        'sfJqueryPlugin',
        'sfImageTransformPlugin',
        'sfLynxLanguagePlugin',
        'sfLynxSectionPlugin',
        'sfLynxNewsPlugin',
        'sfFormExtraPlugin',
        'sfLynxUploadFilePlugin',
        'sfThumbnailPlugin',
        'sfLynxPhotoAlbumPlugin',
        'sfShoppingCartPlugin',
        'sfUserV2Plugin'
      );
    }
  }
