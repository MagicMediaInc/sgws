<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#archivo").validationEngine()
})
</script>

<form id="archivo" action="<?php echo url_for('archivo/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_archivo_seccion='.$form->getObject()->getIdArchivoSeccion() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="left">
  <table width="100%">
      <tr>
        <td>
            &nbsp;<?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos')?>
        </td>
      </tr>
      <tr>
        <td id="errorGlobal">
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
      <tr>
          <td>
              <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                                            <?php echo link_to(__('Voltar na lista'), '@default?module=archivo&action=index&'.$sf_user->getAttribute('uri_archivo'), array('class' => 'button')) ?>
                                                    </div>
                    </td>
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                                            <?php echo link_to(__('Eliminar'), 'archivo/delete?id_archivo_seccion='.$form->getObject()->getIdArchivoSeccion(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                                                    </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Salvar') ?>" />
                    </td>
                </tr>
            </table>
          </td>
      </tr>
    <tfoot>
      <tr>
        <td>
                                  <?php echo $form->renderHiddenFields(false) ?>
                        <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                               <?php echo link_to(__('Voltar na lista'), '@default?module=archivo&action=index&'.$sf_user->getAttribute('uri_archivo'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'archivo/delete?id_archivo_seccion='.$form->getObject()->getIdArchivoSeccion(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                                        </div>
                    </td>
                    <?php endif; ?>
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
                      <td><?php echo $form['titulo_archivo']->renderLabel() ?><br />
                        <?php echo $form['titulo_archivo'] ?>
                        <?php echo $form['titulo_archivo']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                        <td width="63%" valign="bottom" colspan="2">
                            <?php echo $form['archivo']->renderLabel() ?><br />
                            <?php echo $form['archivo'] ?>
                            <?php echo $form['archivo']->renderError() ?>
                            <span class="msn_help"><?php echo $form['archivo']->renderHelp() ?></span>                                  
                        </td>
                  </tr>
                  <tr>
                        <td width="63%" valign="bottom" colspan="2">
                            <?php echo $form['tipo_archivo']->renderLabel() ?><br />
                            <?php echo $form['tipo_archivo'] ?>
                            <?php echo $form['tipo_archivo']->renderError() ?>
                            <span class="msn_help"><?php echo $form['tipo_archivo']->renderHelp() ?></span>                                  
                        </td>
                  </tr>
                  <tr>
                        <td width="63%" valign="bottom" colspan="2">
                            &nbsp;
                        </td>
                  </tr>
                  <tr>
                        <td align="left">
                            <?php if($form['archivo']->getValue()):?>
                            <div id="deleteImage" >
                                <?php echo jq_link_to_remote('Eliminar arquivo', array(
                                        'update'  =>  'imagePoster',
                                        'url'     =>  'archivo/deleteFile?id_archivo_seccion='.$form['id_archivo_seccion']->getValue(),
                                        'script'  => true,
                                        'confirm' => __('Tem certeza de que deseja excluir o arquivo associado?'),
                                        'before'  => "$('#imagePoster').html('<div align=center><br />". image_tag('loading.gif','title="" alt=""')."</div>');",
                                        'complete'=> "$('#deleteImage').html('');"
                                    ));
                                    ?>
                            </div>
                            <?php endif;?>                                 
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 15px; margin-bottom: 15px;">
                                <tr>
                                    <td width="37%" align="left">
                                        <div id="imagePoster" style="min-height: 110px; min-width: 150px;">
                                            <?php if($form['archivo']->getValue()):?>
                                                    <?php $ext = explode(".", $form['archivo']->getValue());$ext = $ext[1]; ?>
                                                    <?php if($ext == "jpg" || $ext == "jpeg" || $ext == "gif" || $ext == "png"): ?>
                                                            <?php echo image_tag('/uploads/arquivos/'.$form['archivo']->getValue(), 'class="borderImage" width="150" height="110"')?>
                                                    <?php else: ?>
                                                    <?php echo link_to(image_tag('file'),'/uploads/arquivos/'.$form['archivo']->getValue(), 'target=_blank')?>
                                            <?php endif;?>
                                        <?php else: ?>
                                            <?php echo image_tag('upload','class="borderImage"'); ?>
                                        <?php endif;?>
                                        </div>
                                    </td>
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
