<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php if( $form->hasErrors() || $form->hasGlobalErrors() ) : ?>
    <?php $errors = $form->getErrorSchema()->getErrors() ?>
    <?php if ( count($errors) > 0 ) : ?>
        <?php foreach( $errors as $name => $error ) :
            if($name=='_csrf_token') :?>
                <script type="text/javascript">
                    document.location = '/';
                </script>
            <?php exit();?>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
<?php endif ?>

<script type="text/javascript"> 
    $(document).ready(function() {
         $("#lxlogin").validationEngine()
    })
</script>
<form id="lxlogin" action="<?php echo url_for('@default_index?module=lxlogin') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <div style="padding-top: 10px;" align="center">
        <table border="0" cellpadding="0" cellspacing="5">
            <tbody>
                <tr>
                    <td align="center">
                        
                        <div id="frmLogin">
                            <div style="padding: 10px; text-align: left !important;">
                                <h1>acesso dos usuários</h1>
                            </div>
                            <?php
                                if( $form->hasErrors() || $form->hasGlobalErrors() ) : ?>
                            <br />
                            <ul class="error_list" >
                                                <?php $errors = $form->getErrorSchema()->getErrors() ?>
                                                <?php if ( count($errors) > 0 ) : ?>
                                                    <?php foreach( $errors as $name => $error ) :?>
                                            <li><?php echo $name ?> : <?php echo $error ?></li>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                        </ul>

                            <?php endif ?>

                            <?php if ($sf_user->hasFlash('msn_error')): ?>
                            <div class="msn_error"><?php echo $sf_user->getFlash('msn_error') ?></div>
                        <?php endif; ?>
                            <table cellpadding="0" cellspacing="3" border="0" style="margin-top: 20px;margin-bottom: 20px; width: 100%"   >
                                
                                <tr align="left">
                                    <td width="30%" align="right"><?php echo $form['login']->renderLabel(__('Usuario')) ?></td>
                                    <td>
                                        <?php echo $form['login']->render(array('class' => 'validate[required]')) ?>
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td align="right"><?php echo $form['password']->renderLabel(__('Senha')) ?></td>
                                    <td>                                        
                                        <?php echo $form['password']->render(array('class' => 'validate[required]')) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="2">
                                        <?php echo $form->renderHiddenFields(false) ?>
                                        <input type="submit" value="<?php echo __('Login') ?>" />
                                    </td>
                                </tr>
                                
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</form>
