<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#producto").validationEngine();
      formatInputMoneda($("#productos_preco"));
})
</script>

<form id="producto" action="<?php echo url_for('producto/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

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
                                                            <?php echo link_to(__('Voltar à lista'), '@default?module=producto&action=index&'.$sf_user->getAttribute('uri_producto'), array('class' => 'button')) ?>
                                                    </div>
                    </td>
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                                            <?php echo link_to(__('Eliminar'), 'producto/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
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
                                               <?php echo link_to(__('Voltar à lista'), '@default?module=producto&action=index&'.$sf_user->getAttribute('uri_producto'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'producto/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
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
                      <td colspan="2">                          
                          <?php  $appYml = sfConfig::get('app_upload_images_producto'); ?>
                          <table cellpadding="0" cellspacing="0" border="0" width="80%" style="margin-top: 15px; margin-bottom: 15px;">
                              <tr>
                                  <td width="3%" align="left" >
                                      <div id="imageFIELD_1" style="min-height: 110px; min-width: 170px;">
                                          <?php if($form->getObject()->getFoto()):  ?>
                                            <?php echo image_tag('/uploads/productos/'.$appYml['size_1']['pref_1'].'_'.$form->getObject()->getFoto(), 'class="borderImage" width="130" ')?>
                                          <?php else:?>
                                            <?php echo image_tag('semfoto.jpg', 'border=0 class="borderImage"');?>
                                          <?php endif;?>
                                      </div>
                                  </td>
                                  <td width="67%" valign="bottom" style="padding-left:7px">
                                      <?php echo $form['foto']->renderLabel() ?><br />
                                      <?php echo $form['foto'] ?>
                                      <?php echo $form['foto']->renderError() ?>
                                      <span class="msn_help"><?php echo $form['foto']->renderHelp() ?></span>
                                  </td>
                              </tr>
                              <tr>
                                <td>
                                      <?php if($form->getObject()->getFoto()):?>
                                      <div id="deleteImage_1" style="margin-left: 40px;" >
                                          <?php echo jq_link_to_remote('Deletar Imagem', array(
                                                'update'  =>  'imageFIELD_1',
                                                'url'     =>  'productos/deleteImage?id='.$form->getObject()->getId(),
                                                'script'  => true,
                                                'confirm' => __('Are you sure you want to delete the selected data?'),
                                                'before'  => "$('#imageFIELD_1').html('<div>". image_tag('preload.gif','title="" alt=""')."</div>');",
                                                'complete'=> "$('#deleteImage_1').html('');"
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
                                          <tr>
                      <td><?php echo $form['codigo']->renderLabel() ?><br />
                        <?php echo $form['codigo'] ?>
                        <?php echo $form['codigo']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['destaque']->renderLabel() ?><br />
                        <?php echo $form['destaque'] ?>
                        <?php echo $form['destaque']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['nome']->renderLabel() ?><br />
                        <?php echo $form['nome'] ?>
                        <?php echo $form['nome']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['ano']->renderLabel() ?><br />
                        <?php echo $form['ano'] ?>
                        <?php echo $form['ano']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                    <td><label>Categoria</label><br />
                        <?php echo $form['id_categoria'] ?>
                        <?php echo $form['id_categoria']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                    <td><label>Unidade Dimensional</label><br />
                        <?php echo $form['comprimento'] ?>
                        <?php echo $form['comprimento']->renderError() ?>
                    </td>
                  </tr>
                              
                              <tr>
                      <td><?php echo $form['preco']->renderLabel() ?><br />
                        <?php echo $form['preco'] ?>
                        <?php echo $form['preco']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['estoque']->renderLabel() ?><br />
                        <?php echo $form['estoque'] ?>
                        <?php echo $form['estoque']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['min_estoque']->renderLabel() ?><br />
                        <?php echo $form['min_estoque'] ?>
                        <?php echo $form['min_estoque']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><label>Observações</label><br />
                        <?php echo $form['observacoes'] ?>
                        <?php echo $form['observacoes']->renderError() ?>
                    </td>
                  </tr>
                  
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
