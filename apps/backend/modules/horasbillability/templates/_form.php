<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#horasbillability").validationEngine()
})
</script>

<form id="horasbillability" action="<?php echo url_for('horasbillability/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?codigo='.$form->getObject()->getCodigo() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

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
                                                            <?php echo link_to(__('Voltar à lista'), '@default?module=horasbillability&action=index&'.$sf_user->getAttribute('uri_horasbillability'), array('class' => 'button')) ?>
                                                    </div>
                    </td>
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                                            <?php echo link_to(__('Eliminar'), 'horasbillability/delete?codigo='.$form->getObject()->getCodigo(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
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
                                               <?php echo link_to(__('Voltar à lista'), '@default?module=horasbillability&action=index&'.$sf_user->getAttribute('uri_horasbillability'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'horasbillability/delete?codigo='.$form->getObject()->getCodigo(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
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
                      <td><?php echo $form['Ano']->renderLabel() ?><br />
                        <?php echo $form['Ano'] ?>
                        <?php echo $form['Ano']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes1']->renderLabel() ?><br />
                        <?php echo $form['Mes1'] ?>
                        <?php echo $form['Mes1']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes2']->renderLabel() ?><br />
                        <?php echo $form['Mes2'] ?>
                        <?php echo $form['Mes2']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes3']->renderLabel() ?><br />
                        <?php echo $form['Mes3'] ?>
                        <?php echo $form['Mes3']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes4']->renderLabel() ?><br />
                        <?php echo $form['Mes4'] ?>
                        <?php echo $form['Mes4']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes5']->renderLabel() ?><br />
                        <?php echo $form['Mes5'] ?>
                        <?php echo $form['Mes5']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes6']->renderLabel() ?><br />
                        <?php echo $form['Mes6'] ?>
                        <?php echo $form['Mes6']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes7']->renderLabel() ?><br />
                        <?php echo $form['Mes7'] ?>
                        <?php echo $form['Mes7']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes8']->renderLabel() ?><br />
                        <?php echo $form['Mes8'] ?>
                        <?php echo $form['Mes8']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes9']->renderLabel() ?><br />
                        <?php echo $form['Mes9'] ?>
                        <?php echo $form['Mes9']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes10']->renderLabel() ?><br />
                        <?php echo $form['Mes10'] ?>
                        <?php echo $form['Mes10']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes11']->renderLabel() ?><br />
                        <?php echo $form['Mes11'] ?>
                        <?php echo $form['Mes11']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['Mes12']->renderLabel() ?><br />
                        <?php echo $form['Mes12'] ?>
                        <?php echo $form['Mes12']->renderError() ?>
                    </td>
                  </tr>
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
