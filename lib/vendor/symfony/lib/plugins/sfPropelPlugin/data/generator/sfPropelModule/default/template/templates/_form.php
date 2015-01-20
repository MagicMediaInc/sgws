[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]
<script type="text/javascript"> 
$(document).ready(function() {
      $("#<?php echo $this->getModuleName() ?>").validationEngine()
})
</script>

<?php $form = $this->getFormObject() ?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
[?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]
<?php else: ?>
<form id="<?php echo $this->getModuleName() ?>" action="[?php echo url_for('<?php echo $this->getModuleName() ?>/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?> : '')) ?]" method="post" [?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?]>

 [?php if (!$form->getObject()->isNew()): ?]
<input type="hidden" name="sf_method" value="put" />
[?php endif; ?]
<?php endif;?>
<div class="frameForm" align="left">
  <table width="100%">
      <tr>
        <td>
            &nbsp;[?php echo __('Os campos marcados com') ?] <span class="required">*</span> [?php echo __('são requeridos')?]
        </td>
      </tr>
      <tr>
        <td id="errorGlobal">
            [?php echo $form->renderGlobalErrors() ?]
        </td>
      </tr>
      <tr>
          <td>
              <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                            <?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                                <a href="[?php echo url_for('<?php echo $this->getUrlForAction('list') ?>') ?]" class="button">[?php echo __('Voltar à lista')?]</a>
                            <?php else: ?>
                                [?php echo link_to(__('Voltar à lista'), '@default?module=<?php echo $this->getModuleName() ?>&action=index&'.$sf_user->getAttribute('uri_<?php echo $this->getModuleName() ?>'), array('class' => 'button')) ?]
                            <?php endif; ?>
                        </div>
                    </td>
                    [?php if (!$form->getObject()->isNew()): ?]
                    <td>
                        <div class="button">
                            <?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                                [?php echo link_to(__('Eliminar'), '<?php echo $this->getUrlForAction('delete') ?>', $form->getObject(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?]
                            <?php else: ?>
                                [?php echo link_to(__('Eliminar'), '<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?>, array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?]
                            <?php endif; ?>
                        </div>
                    </td>
                    [?php endif; ?]
                    <td>
                    <input type="submit" value="[?php echo __('Salvar') ?]" />
                    </td>
                </tr>
            </table>
          </td>
      </tr>
    <tfoot>
      <tr>
        <td>
            <?php if (!isset($this->params['non_verbose_templates']) || !$this->params['non_verbose_templates']): ?>
                      [?php echo $form->renderHiddenFields(false) ?]
            <?php endif; ?>
            <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                    <?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                           <a href="[?php echo url_for('<?php echo $this->getUrlForAction('list') ?>') ?]" class="button">Voltar à lista</a>
                    <?php else: ?>
                           [?php echo link_to(__('Voltar à lista'), '@default?module=<?php echo $this->getModuleName() ?>&action=index&'.$sf_user->getAttribute('uri_<?php echo $this->getModuleName() ?>'), array('class' => 'button')) ?]
                    <?php endif; ?>
                        </div>
                    </td>            
                    [?php if (!$form->getObject()->isNew()): ?]
                    <td>
                        <div class="button">
                <?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                            [?php echo link_to(__('Eliminar'), '<?php echo $this->getUrlForAction('delete') ?>', $form->getObject(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?]
                <?php else: ?>
                            [?php echo link_to(__('Eliminar'), '<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?>, array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?]
                <?php endif; ?>
                        </div>
                    </td>
                    [?php endif; ?]
                    <td>
                    <input type="submit" value="[?php echo __('Salvar') ?]" />
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
            <?php if (isset($this->params['non_verbose_templates']) && $this->params['non_verbose_templates']): ?>
                  [?php echo $form ?]
            <?php else: ?>
            <?php foreach ($form as $name => $field): if ($field->isHidden()) continue ?>
                  <tr>
                      <td>[?php echo $form['<?php echo $name ?>']->renderLabel() ?]<br />
                        [?php echo $form['<?php echo $name ?>'] ?]
                        [?php echo $form['<?php echo $name ?>']->renderError() ?]
                    </td>
                  </tr>
            <?php endforeach; ?>
            <?php endif; ?>
                </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
