<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
    $(document).ready(function() {
         $("#lxaccount").validationEngine();
         $("#frmBuscar").hide()
    })
</script>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<form id="lxaccount" action="<?php echo url_for('@default_index?module=lxaccount') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <div class="frameForm" align="left" style="margin-top: 5px;">
        <table width="100%">
            
            <tr>
                <td>
                    <?php echo $form->renderGlobalErrors() ?>
                </td>
            </tr>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <table cellspacing="4">
                            <tr>
                                <td>
                                    <input type="submit" value="<?php echo __('Salvar Dados') ?>" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="2" border="0" width="100%">
                            <tr>
                                <td>
                                     <?php echo $form['name']->renderLabel() ?><br />
                                    <?php echo $form['name'] ?>
                                    <?php echo $form['name']->renderError() ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                     <?php echo $form['login']->renderLabel() ?><br />
                                    <?php echo $form['login'] ?>
                                    <?php echo $form['login']->renderError() ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                     <?php echo $form['email']->renderLabel() ?> <span class="required">*</span><br />
                                    <?php echo $form['email'] ?>
                                    <?php echo $form['email']->renderError() ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php $module = 'lxaccount'; ?>
                                    <?php  $appYml = sfConfig::get('app_upload_images_lxaccount'); ?>
                                    <table cellpadding="0" cellspacing="0" border="0" width="80%" style="margin-top: 15px; margin-bottom: 15px;">
                                        <tr>
                                            <td width="3%" align="left" >
                                                <div id="imageFIELD" style="min-height: 110px; min-width: 170px;">
                                                    <?php if($form->getObject()->getPhoto()):  ?>
                                                        <?php echo image_tag('/uploads/users/'.$appYml['size_3']['pref_3'].'_'.$form->getObject()->getPhoto(), 'class="borderImage" width="95"')?>
                                                    <?php else:?>
                                                        <?php echo image_tag('user.jpg', 'border=0 width="106" class="borderImage"');?>
                                                    <?php endif;?>
                                                </div>
                                            </td>
                                            <td width="67%" valign="bottom" style="padding-left:7px">
                                                <?php echo $form['photo']->renderLabel() ?><br />
                                                <?php echo $form['photo'] ?>
                                                <?php echo $form['photo']->renderError() ?>
                                                <span class="msn_help"><?php echo $form['photo']->renderHelp() ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php if($form->getObject()->getPhoto()):?>
                                                <div id="deleteImage" style="margin-left: 40px;" >
                                                        <?php echo jq_link_to_remote(__('Eliminar imagen'), array(
                                                        'update'  =>  'imageFIELD',
                                                        'url'     =>  $module.'/deleteImage?id='.$form->getObject()->getIdUser(),
                                                        'script'  => true,
                                                        'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'),
                                                        'before'  => "$('#imageFIELD').html('<div>". image_tag('preload.gif','title="" alt=""')."</div>');",
                                                        'complete'=> "$('#deleteImage').html('');"
                                                        ));
                                                        ?>
                                                </div>
                                                <?php endif;?>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
       </table>
    </div>
</form>
