<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
        $("#anexo").validationEngine();
        $("#proposta_anexo_data").datepicker({   
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',        
            changeMonth: true,
            changeYear: true
        });    
        $('#voltar-lista').click(function(){
            history.back();
        });
        
        <?php if($form->getObject()->getData()): ?>
            $("#proposta_anexo_data").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getData())) ?>');
        <?php endif; ?>
})
</script>
<h1 class="tit-principal">
    INFORMAÇÕES DO ANEXO #<?php echo $sf_request->getParameter('id') ?>
</h1>
<h2>Proposta # <?php echo $form->getObject()->getIdProposta() ?></h2>
<div class="frameForm" align="left">
    <form id="anexo" action="<?php echo url_for('projeto/updateAnexo?id='.$form->getObject()->getId()) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
            <tfoot>
              <tr>
                <td>
                      <?php echo $form->renderHiddenFields(false) ?>
                      <table cellspacing="4">
                        <tr>
                            <td>
                                <div class="button">
                                    <a href="javascript:void(0);" id="voltar-lista" >Voltar à lista</a>    
                                </div>
                            </td>            
                            <?php if (!$form->getObject()->isNew()): ?>
                            <td>
                                <div class="button">
                                    <?php echo link_to(__('Eliminar'), 'projeto/deleteAnexo?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => '')) ?>
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
                        <table cellpadding="0" cellspacing="2" border="0" width="100%" id="table-info">
                            <tr>
                              <td><?php echo $form['data']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['data'] ?>
                                <?php echo $form['data']->renderError() ?>
                              </td>
                            </tr>
                            <tr>
                              <td><?php echo $form['id_responsable']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['id_responsable'] ?>
                                <?php echo $form['id_responsable']->renderError() ?>
                              </td>
                            </tr>
                            <tr>
                              <td><?php echo $form['descricao']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['descricao'] ?>
                                <?php echo $form['descricao']->renderError() ?>
                              </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>