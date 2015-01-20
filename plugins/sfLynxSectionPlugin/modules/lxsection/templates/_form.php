<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#lxsection").validationEngine()
})
</script>

<form id="lxsection" action="<?php echo url_for('lxsection/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="center">
  <table width="100%">
      <tr>
        <td>
            &nbsp;<?php echo __('Os campos marcados com ') ?> <span class="required">*</span> <?php echo __('são obrigatórios')?>
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
                            <?php if($sf_request->getParameter('back')):?>
                                <?php echo link_to(__('Voltar'), '@default?module=lxsection&action=editContent&id='.$sf_request->getParameter('id').'&language='.$sf_request->getParameter('language').'', array('class' => 'button')) ?>
                            <?php else:?>
                                <?php echo link_to(__('Voltar na lista'), '@default?module=lxsection&action=index&'.$sf_user->getAttribute('uri_lxsection'), array('class' => 'button')) ?>
                            <?php endif;?>
                        </div>
                    </td>
                    <?php if (!$form->getObject()->isNew() and $form->getObject()->getDelete()): ?>
                    <td>
                        <div class="button">
                                <?php echo link_to(__('Eliminar'), 'lxsection/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => __('Voc� tem certeza de que deseja excluir os dados selecionados?'), 'class' => 'button')) ?>
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
                           <?php if($sf_request->getParameter('back')):?>
                                <?php echo link_to(__('Voltar'), '@default?module=lxsection&action=editContenido&id='.$sf_request->getParameter('id').'&language='.$sf_request->getParameter('language').'', array('class' => 'button')) ?>
                            <?php else:?>
                                <?php echo link_to(__('Voltar na lista'), '@default?module=lxsection&action=index&'.$sf_user->getAttribute('uri_lxsection'), array('class' => 'button')) ?>
                            <?php endif;?>
                        </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew() and $form->getObject()->getDelete()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'lxsection/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => __('Voc� tem certeza de que deseja excluir os dados selecionados?'), 'class' => 'button')) ?>
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
                  <?php if($sf_user->getAttribute('idProfile') == 1 || $sf_user->getAttribute('idProfile') == 2):?>
                  <tr>
                      <td><?php echo $form['id_profile']->renderLabel() ?><br />
                        <?php echo $form['id_profile'] ?>
                        <?php echo $form['id_profile']->renderError() ?>
                    </td>
                  </tr>
                  <?php endif; ?>
                  <tr>
                      <td>
                        <?php echo $form['id_parent']->renderLabel() ?><br />
                        <?php echo $form['id_parent']->render(array('value' => 4)); ?>
                          
                        <?php echo $form['id_parent']->renderError() ?>
                    </td>
                  </tr>                  
                  <tr>
                      <td><?php echo $form['show_text']->renderLabel() ?><br />
                        <?php echo $form['show_text'] ?>
                        <?php echo $form['show_text']->renderError() ?>
                        <span class="msn_help"><?php echo $form['show_text']->renderHelp() ?></span>
                    </td>
                  </tr>                  
                  <tr>
                      <td><?php echo $form['control']->renderLabel() ?><br />
                        <?php echo $form['control'] ?>
                        <?php echo $form['control']->renderError() ?>
                    </td>
                  </tr>                  
                  <tr>
                      <td><?php echo $form['special_page']->renderLabel() ?><br />
                        <?php echo $form['special_page'] ?>
                        <?php echo $form['special_page']->renderError() ?>
                    </td>
                  </tr>                  
                  <tr>
                      <td><?php echo $form['url_externa']->renderLabel() ?><br />
                        <?php echo $form['url_externa'] ?>
                        <?php echo $form['url_externa']->renderError() ?>
                    </td>
                  </tr>                  
                  <tr>
                      <td><?php echo $form['sw_menu']->renderLabel() ?><br />
                        <?php echo $form['sw_menu'] ?>
                        <?php echo $form['sw_menu']->renderError() ?>
                        <span class="msn_help"><?php echo $form['sw_menu']->renderHelp() ?></span>
                    </td>
                  </tr>
                  <?php //if ($sf_user->hasCredential('admin_lynx')): ?>
                   <tr>
                      <td><?php echo $form['delete']->renderLabel() ?><br />
                        <?php echo $form['delete'] ?>
                        <?php echo $form['delete']->renderError() ?>
                    </td>
                  </tr>
                  <?php //endif;?>
                  <tr>
                      <td><?php echo $form['only_complement']->renderLabel() ?><br />
                        <?php echo $form['only_complement'] ?>
                        <?php echo $form['only_complement']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['home']->renderLabel() ?><br />
                        <?php echo $form['home'] ?>
                        <?php echo $form['home']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td>
                        <?php echo $form['status']->renderLabel() ?><br />                        
                        <?php echo $form['status'] ?>                        
                        <?php echo $form['status']->renderError() ?>
                    </td>
                  </tr>
                </table>
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>