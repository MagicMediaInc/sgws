<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
    $(document).ready(function() {
         $("#lxpassword").validationEngine();
         $("#frmBuscar").hide()
    })
</script>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<form id="lxpassword" action="<?php echo url_for('@default_index?module=lxchangePassword') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <div class="frameForm" align="left" style="margin-top: 5px;">
        <table width="100%" border="0">
            <tr>
                <td >
                    &nbsp;<?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos')?>
                </td>
            </tr>
            <tr>
                <td  id="errorGlobal">
                    <?php echo $form->renderGlobalErrors() ?>
                </td>
            </tr>
            <tr>
                <td >
                    <table cellspacing="4">
                        <tr>
                            <td>
                                <?php echo $form->renderHiddenFields(false) ?>
                                <input type="submit" value="<?php echo __('Salvar') ?>" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tfoot>
                <tr>
                    <td >
                        <table cellspacing="4">
                            <tr>
                                <td>
                                    <input type="submit" value="<?php echo __('Salvar') ?>" />
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
                                    
                                     <?php echo $form['login']->renderLabel(__('Login')) ?><br />
                                    <?php echo $form['login'] ?>
                                    <?php echo $form['login']->renderError() ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                     <?php echo $form['current_password']->renderLabel() ?> <span class="required">*</span><br />
                                    <?php echo $form['current_password'] ?>
                                    <?php echo $form['current_password']->renderError() ?>
                                     
                                </td>
                            </tr>
                            <tr>
                                <td>
                                     <?php echo $form['password']->renderLabel() ?> <span class="required">*</span><br />
                                    <?php echo $form['password'] ?>
                                    <?php echo $form['password']->renderError() ?>
                                    <span class="msn_help"><?php echo $form['password']->renderHelp() ?></span>
                                     
                                </td>
                            </tr>
                             <tr>
                                <td>
                                     <?php echo $form['confir_password']->renderLabel() ?> <span class="required">*</span><br />
                                    <?php echo $form['confir_password'] ?>
                                    <?php echo $form['confir_password']->renderError() ?>
                                </td>
                            </tr>

                           
                        </table>
                         
                    </td>
                </tr>
            </tbody>
       </table>
    </div>
</form>
