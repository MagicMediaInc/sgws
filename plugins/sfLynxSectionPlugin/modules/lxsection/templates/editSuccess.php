<!--
* Template editSuccess.php
* @package    lynx4
* @subpackage lxsection
* @author     Henry Vallenilla - hvallenilla@aberic.com
-->
<div id="title_module">
    <div class="frameForm"><style>
  #contentPpal{
    min-width: 0px !important;
    width: 0% !important;
  }
  .requerido{
    display: block;
    height: 42px;
    padding:10px 5px;
  }
  .container{
    width: 100%;
  }
  .divtitles{
    margin-right: 10px;
    display: inline-block;
    width: 135px;
    vertical-align: middle !important;
  }
  .divcontens{
    display: inline-block;
  }
  .row{
    /*vertical-align: middle;*/
    /*margin-bottom: 10px;*/
    padding:5px 0px 5px 20px;
  }
  .grey{
    background: #eee;
  }
</style>
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('lxsection/index') ?>" ><?php echo __('Se&ccedil;&otilde;es')  ?> do <?php echo $nombreNucleo->getNameProfile() ?></a> - <?php echo __('Editar sess&atilde;o') ?> </h1>
    </div>
    <?php include_partial('form', array('form' => $form)) ?>
</div>
