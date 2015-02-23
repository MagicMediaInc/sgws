<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_javascript("jq/jquery-ui-1.8.16.custom/development-bundle/ui/i18n/jquery.ui.datepicker-br.js") ?>

<script type="text/javascript"> 
    var url_fun = 'http://'+location.hostname+'/backend_dev.php';
    $(document).ready(function() {
        cargaTipos(<?php echo $form->getObject()->getCodigoTipo() ?>);
        cargaSubTiposSimple(<?php echo $form->getObject()->getCodigoTipo() ?>, <?php echo $form->getObject()->getCodigoSubtipo() ?>);
        cargaFornecedor(<?php echo $form->getObject()->getCodigocadastro() ?>,<?php echo $form->getObject()->getCodigoSubtipo() ?>);
        
        <?php if(!$form->getObject()->getBaixa()): ?>
            $('.data-despesa').each(function(){
                $(this).datepicker({   
                    defaultDate: "+1w",
                    dateFormat: 'dd-mm-yy',        
                    changeMonth: true,
                    changeYear: true
                }); 
            });
            $('.tipos').change(function(){
                cargaSubTiposSimple($('#saidas_codigo_tipo').val(),'0');
            });
            $('#subtipo').change(function(){
                 cargaFornecedor('0',$("#subtipo").val());
            });
        <?php else: ?>
            
            $('#despesa').find('input, textarea, button, select').attr("disabled",true);
        <?php endif; ?>
        
        formatInputMoneda($('#saidas_saidaprevista'));
        formatInputMoneda($('#saidas_saidas'));
        
        <?php if(!$form->getObject()->isNew()): ?>
            
            $("#saidas_datareal").val('<?php echo $form->getObject()->getDatareal() ? date("d-m-Y", strtotime($form->getObject()->getDatareal())) : '' ?>');
            
        <?php endif; ?>
        
    })
    
</script>
<h1 class="icono_seguranca">
    Editar Despesa
</h1>
<div id="title_module">


<div class="frameForm" align="left">
<form id="despesa" action="<?php echo url_for('despesa/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getCodigoSaida() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <table width="100%">  
        <tfoot>
            <tr>
              <td>
                    <?php echo $form->renderHiddenFields(false) ?>
                  <table cellspacing="4" style="margin-top: 10px;">
                      <tr>
                          <td>
                              <div class="button">
                                  <?php echo link_to(__('Voltar à lista'), '@default?module=despesa&action=index&id_projeto='.$form->getObject()->getCodigoprojeto(), array('class' => 'button')) ?>
                              </div>
                          </td>            
                          <?php if (!$form->getObject()->isNew() && !$form->getObject()->getBaixa()): ?>
                          <?php if (aplication_system::esUsuarioRoot()): ?>
                          <td>
                              <div class="button">
                                  <?php echo link_to(__('Eliminar'), 'despesa/delete?id='.$form->getObject()->getCodigoSaida(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                              </div>
                          </td>
                          <?php endif; ?>
                          <td>
                            <input type="submit" value="<?php echo __('Salvar') ?>" />
                          </td>
                          <?php endif; ?>
                      </tr>
                  </table>
              </td>
            </tr>
        </tfoot>
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
        <tbody>
        <tr>
            <td>                
                <table cellpadding="0" cellspacing="2" border="0" width="100%" id="table-info">
                    <tr>
                        <td style="width: 12%;"><?php echo $form['documentos']->renderLabel() ?></td>
                        <td style="width: 19%;">
                          <?php echo $form['documentos'] ?>
                          <?php echo $form['documentos']->renderError() ?>
                        </td>
                        <td style="width: 115px;">
                            <?php if(!aplication_system::esFuncionario()): ?>
                                <?php echo $form['operacao']->renderLabel() ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!aplication_system::esFuncionario()): ?> 
                                <?php echo $form['operacao'] ?>
                                <?php echo $form['operacao']->renderError() ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;"><?php echo $form['codigoprojeto']->renderLabel() ?></td>
                        <td>
                          <?php echo $form['codigoprojeto'] ?>
                          <?php echo $form['codigoprojeto']->renderError() ?>
                        </td>
                        <td><?php echo $form['codigotarefa']->renderLabel() ?></td>
                        <td>
                          <?php echo $form['codigotarefa'] ?>
                          <?php echo $form['codigotarefa']->renderError() ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form['codigo_tipo']->renderLabel() ?></td>
                        <td>
                          <?php echo $form['codigo_tipo'] ?>
                          <?php echo $form['codigo_tipo']->renderError() ?>
                        </td>
                        <td><?php echo $form['codigo_subtipo']->renderLabel() ?></td>
                        <td>
                          <?php echo $form['codigo_subtipo'] ?>
                          <?php echo $form['codigo_subtipo']->renderError() ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form['codigocadastro']->renderLabel() ?></td>
                        <td colspan="3">
                          <?php echo $form['codigocadastro'] ?>
                          <?php echo $form['codigocadastro']->renderError() ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <?php if(!aplication_system::esFuncionario()): ?>
                        <td><?php echo $form['dataprevista']->renderLabel() ?></td>
                        <td>
                          <?php echo $form['dataprevista'] ?>
                          <?php echo $form['dataprevista']->renderError() ?>
                        </td>
                        <?php endif; ?>
                        <td><?php echo $form['datareal']->renderLabel() ?></td>
                        <td>
                          <?php echo $form['datareal'] ?>
                          <?php echo $form['datareal']->renderError() ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form['descricaosaida']->renderLabel() ?></td>
                        <td colspan="3">
                          <?php echo $form['descricaosaida'] ?>
                          <?php echo $form['descricaosaida']->renderError() ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form['formapagamento']->renderLabel() ?></td>
                        <td colspan="3">
                          <?php echo $form['formapagamento'] ?>
                          <?php echo $form['formapagamento']->renderError() ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <?php if(!aplication_system::esFuncionario()): ?>
                        <td><?php echo $form['saidaprevista']->renderLabel() ?></td>
                        <td>
                          <?php echo $form['saidaprevista'] ?>
                          <?php echo $form['saidaprevista']->renderError() ?>
                        </td>
                        <?php endif; ?>
                        <td><?php echo $form['saidas']->renderLabel() ?></td>
                        <td>
                          <?php echo $form['saidas'] ?>
                          <?php echo $form['saidas']->renderError() ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    


</form>
</div>
</div>