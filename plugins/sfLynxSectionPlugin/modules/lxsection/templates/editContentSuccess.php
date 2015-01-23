<!--
* Template editContentSuccess.php
* @package    lynx4
* @subpackage lxsection
* @author     Henry Vallenilla - hvallenilla@aberic.com
* @description: Esta plantilla muestra los datos básicos de la sección y proporciona
                el acceso a la edición del contenido por idiomas
-->
<?php use_javascript('/sfLynxSectionPlugin/js/tabsLanguages.js'); ?>
<!-- Ejecuta Extjs TabPanel -->
<?php echo javascript_tag("sistemTabs(".$sf_request->getParameter('id').",'".$sf_request->getParameter('language')."');")?>
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
</style><h1><?php echo $nombreNucleo->getNameProfile() ?> - <?php echo __('Editar o conteúdo da seção') ?> - <?php echo $sf_section_select['name_section'] ?></h1></div>

<div class="frameForm" >
    <table width="100%">
        <tr>
            <td>&nbsp;&nbsp;
                <?php echo link_to(__('Voltar na lista'), '@default?module=lxsection&action=index&'.$sf_user->getAttribute('uri_lxsection'), array('class' => '')) ?>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="#" id="viewInfoSection" onclick="viewInfoSection();"><?php echo __('Ver informação da seção')?> </a>
                <a href="#" id="noViewInfoSection" style="display: none;" onclick="noViewInfoSection()"><?php echo __('No ver informação da seção')?> </a>
            </td>
        </tr>
        <tr>
            <td>                
                <div class="informationSection" style="display: none;  ">
                    <table width="95%" cellpadding="0" cellspacing="5" border="0">
                        <tr>
                            <td width="322" valign="top">
                                <label ><b><?php echo __('sess&atilde;o Pais').':' ?></b></label>
                                <?php if($sf_section->getIdParent()): ?>
                                <?php echo $sf_section_parent['name_section'] ?>
                                <?php else: ?>
                                <?php echo __('None') ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <label ><b><?php echo __('Inicio').':' ?></b></label>
                                <?php echo __(sfConfig::get('mod_lxsection_home_'.$sf_section->getHome().'')) ?>
                            </td>
                            <td>
                                <label ><b><?php echo __('Status').':' ?></b></label>
                                <?php echo __(sfConfig::get('mod_lxsection_status_'.$sf_section->getStatus().'')) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label><b><?php echo __('Tem link?').':' ?></b></label>
                                <?php echo __(sfConfig::get('mod_lxsection_control_'.$sf_section->getControl().'')) ?>
                            </td>
                            <td>
                                <label ><b><?php echo __('Ocultar título'.':') ?></b></label>
                                <?php echo __(sfConfig::get('mod_lxsection_cabecera_'.$sf_section->getOnlyComplement().'')) ?>
                            </td>
                            <td>
                                <label ><b><?php echo __('sess&atilde;o url').':' ?></b></label>
                                <?php if($sf_section->getSwMenu()): ?>
                                <?php echo $sf_section->getSwMenu() ?>
                                <?php else: ?>
                                <?php echo __('None') ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if ($sf_user->hasCredential('admin_lynx')): ?>
                                <label ><b><?php echo __('Página especial').':' ?></b></label>
                                <?php if($sf_section->getSpecialPage()):?>
                                <?php echo $sf_section->getSpecialPage(); ?>
                                <?php else:?>
                                <?php echo __('None') ?>
                                <?php endif;?>
                                <?php endif;?>
                            </td>
                            <td>
                                <?php if ($sf_user->hasCredential('admin_lynx')): ?>
                                <label><b><?php echo __('Mostrar a descrição na pagina'.':') ?></b></label>
                                <?php echo sfConfig::get('mod_lxsection_muestra_descripcion_'.$sf_section->getShowText().'') ?>
                                <?php endif;?>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><?php echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/edit.png','border=0 alt='.__('Editar informações').' title='.__('Editar informações').''), 'lxsection/edit?id='.$sf_section->getId().'&language='. $sf_request->getParameter('language').'&paso=1&back=1') ?></td>
                                        <td><?php echo link_to(__('Editar informações'), 'lxsection/edit?id='.$sf_section->getId().'&language='. $sf_request->getParameter('language').'&paso=1&back=1') ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>                    
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>
<table width="100%">
    <?php if($sf_user->hasFlash('listo')): ?>
        <tr>
            <td><div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td><br />
            <div id="tabsLanguages" style="width: 100%">
                <!-- Sistema de Pestañas ExtJs -->
            </div>
        </td>
    </tr>
</table>
</div>