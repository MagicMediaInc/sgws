<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_javascript("jq/jquery-ui-1.8.16.custom/development-bundle/ui/i18n/jquery.ui.datepicker-br.js") ?>

<div class="frameForm" align="left">
    <form id="despesa" action="<?php echo url_for('despesa/' . ($form->getObject()->isNew() ? 'createFinanciero' : 'updateFinanciero') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getCodigoSaida() : '') . ($id_projeto ? '&id_projeto=' . $id_projeto : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <input type="hidden" name="referer" id="referer" value="<?php echo $ref ?>" />
        <table width="100%">  
            <tfoot>
                <tr>
                    <td>
                        <?php echo $form->renderHiddenFields(false) ?>
                        <table cellspacing="4">
                            <tr>
                                <td>
                                    <div class="button">
                                        <?php if ($id_projeto): ?>
                                            <?php echo link_to(__('Voltar à lista'), '@default?module=despesa&action=index&id_projeto=' . $id_projeto, array('class' => 'button')) ?>
                                        <?php else: ?>
                                            <?php echo link_to(__('Voltar à lista'), '@default?module=despesa&action=index', array('class' => 'button')) ?>
                                        <?php endif; ?>

                                    </div>
                                </td>            
                                <?php if (!$form->getObject()->isNew()): ?>
                                    <?php if ($form->getObject()->getCentro() != 'compensação'): ?>
                                        <td>
                                            <div class="button">
                                                <?php echo link_to(__('Eliminar'), 'despesa/delete?id=' . $form->getObject()->getCodigoSaida() . '&despro=1', array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <td>
                                    <input type="submit" value="<?php echo __('Salvar') ?>" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tfoot>
            <tr>
                <td>
                    &nbsp;<?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos') ?>
                </td>
            </tr>
            <tr>
                <td id="errorGlobal" colspan="2">
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
                                <td style="width: 115px;"><?php echo $form['operacao']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['operacao'] ?>
                                    <?php echo $form['operacao']->renderError() ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $form['centro']->renderLabel() ?></td>
                                <td colspan="3">
                                    <?php echo $form['centro'] ?>
                                    <?php echo $form['centro']->renderError() ?>
                                </td>
                            </tr>

                            <tr id="projeto-tr">
                                <td><?php echo $form['codigoprojeto']->renderLabel() ?></td>
                                <td colspan="3">
                                    <?php echo $form['codigoprojeto'] ?>
                                    <?php echo $form['codigoprojeto']->renderError() ?>
                                </td>
                            </tr>
                            <tr id="tipo-tr">
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
                            <tr id="fornecedor-tr">
                                <td><label><div id="lb-cadastro">
                                            <?php echo ( ($form->getObject()->getOperacao() == 's' ) ? 'Fornecedor' : 'Cliente'); ?>
                                        </div></label></td>
                                <td colspan="3">
                                    <?php echo $form['codigocadastro'] ?>
                                    <?php echo $form['codigocadastro']->renderError() ?>
                                </td>
                            </tr>
                            <tr id="funcionario-tr">
                                <td><?php echo $form['codigofuncionario']->renderLabel() ?></td>
                                <td colspan="3">
                                    <?php echo $form['codigofuncionario'] ?>
                                    <?php echo $form['codigofuncionario']->renderError() ?>
                                </td>
                            </tr>
                            <tr id="fecha-facturacion">
                                <td><?php echo $form['dataprevista']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['dataprevista'] ?>
                                    <?php echo $form['dataprevista']->renderError() ?>
                                </td>
                                <td><?php echo $form['dataemissao']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['dataemissao'] ?>
                                    <?php echo $form['dataemissao']->renderError() ?>
                                </td>
                            </tr>
                            <tr>
                                <td id="lb-prevista" style="font-weight: bolder"><?php echo $form['datarecebimentopre']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['datarecebimentopre'] ?>
                                    <?php echo $form['dataprevista']->renderError() ?>
                                </td>
                                <td id="lb-real" style="font-weight: bolder"><?php echo $form['datareal']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['datareal'] ?>
                                    <?php echo $form['datareal']->renderError() ?>
                                </td>                        
                            </tr>                    

                            <tr>
                                <td><?php echo $form['saidaprevista']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['saidaprevista'] ?>
                                    <?php echo $form['saidaprevista']->renderError() ?>
                                </td>
                                <td><?php echo $form['saidas']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['saidas'] ?>
                                    <?php echo $form['saidas']->renderError() ?>
                                </td>
                            </tr>

                            <tr id="imposto-tr">
                                <td><?php echo $form['impostos']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['impostos'] ?>
                                    <?php echo $form['impostos']->renderError() ?>
                                </td>
                                <td></td>
                                <td></td>
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
                                <td>
                                    <?php echo $form['formapagamento'] ?>
                                    <?php echo $form['formapagamento']->renderError() ?>
                                </td>
                                <td><?php echo $form['tipo']->renderLabel() ?></td>
                                <td>
                                    <?php echo $form['tipo'] ?>
                                    <?php echo $form['tipo']->renderError() ?>
                                </td>
                            </tr>
                            <tr>
                                <?php if (!aplication_system::esUsuarioRoot()): ?>
                                    <td><?php echo $form['baixa']->renderLabel() ?></td>
                                    <td>
                                        <?php echo $form['baixa'] ?>
                                        <?php echo $form['baixa']->renderError() ?>
                                    </td>
                                <?php endif; ?>
                                <?php if (aplication_system::esUsuarioRoot()): ?>
                                    <td><?php echo $form['confirmacao']->renderLabel() ?></td>
                                    <td>
                                        <?php echo $form['confirmacao'] ?>
                                        <?php echo $form['confirmacao']->renderError() ?>
                                    </td>
                                <?php endif; ?>
                            </tr>

                        </table>
                    </td>
                </tr>
        </table>
    </form>
</div>

<script type="text/javascript">
    var url_fun = 'http://' + location.hostname + '/backend_dev.php';

    $(document).ready(function() {

        $('.data-despesa').each(function() {
            $(this).datepicker({
                defaultDate: "+1w",
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true
            });
        });

        formatInputMoneda($('#saidas_saidaprevista'));
        formatInputMoneda($('#saidas_saidas'));
        analisisImpuesto();
   
        if ($('#saidas_operacao').val() === 'e')
        {
            $("#tipo-tr").hide();
            $("#fecha-facturacion").show();
            $("#lb-prevista").html('Data Prev. Recebimento');
            $("#lb-real").html('Data Recebimento');
        }
        else
        {
            $("#tipo-tr").show();
            $("#fecha-facturacion").hide();
            $("#lb-prevista").html('Data Prev. Pagamento');
            $("#lb-real").html('Data Pagamento');
        }

        // Saidas_centro                       
        switch ($('#saidas_centro').val())
        {
            case 'projeto':
                $("#fornecedor-tr").show();                
                break;

            case 'compensação':
                $("#fornecedor-tr").hide();
                $("#tipo-tr").hide();
                $("#fecha-facturacion").hide();
                break;

            case 'adiantamento':
                $("#tipo-tr").hide();
                $("#fornecedor-tr").hide();
                break;

            default:
                alert('coño!');
                break;
        }

<?php if (!$form->getObject()->isNew()): ?>  
                    
    $("#saidas_dataprevista").val('<?php echo $form->getObject()->getDataprevista() ? date("d-m-Y", strtotime($form->getObject()->getDataprevista())) : '' ?>');
    $("#saidas_datareal").val('<?php echo $form->getObject()->getDatareal() ? date("d-m-Y", strtotime($form->getObject()->getDatareal())) : '' ?>');
    $("#saidas_dataemissao").val('<?php echo $form->getObject()->getDataemissao() ? date("d-m-Y", strtotime($form->getObject()->getDataemissao())) : ''  ?>');
    $("#saidas_datarecebimentopre").val('<?php echo $form->getObject()->getDatarecebimentopre() ? date("d-m-Y", strtotime($form->getObject()->getDatarecebimentopre())) : ''  ?>');
    
    <?php if (($form->getObject()->getOperacao() == 's') and 
              (mb_convert_case($form->getObject()->getCentro(), MB_CASE_LOWER) == 'projeto')): ?>
                                      
             cargaTipos(<?php echo $form->getObject()->getCodigoTipo() ?>, $('#saidas_operacao').val());
             cargaSubTiposSimple(<?php echo $form->getObject()->getCodigoTipo() ?>, '<?php echo $form->getObject()->getCodigoSubtipo() ?>');
             cargaFornecedor('<?php echo $form->getObject()->getCodigocadastro() ?>','<?php echo $form->getObject()->getCodigoSubtipo() ?>');
             
    <?php elseif (($form->getObject()->getOperacao() == 'e') and 
              (mb_convert_case($form->getObject()->getCentro(), MB_CASE_LOWER) == 'projeto')): ?>
    
            cargaClientes(<?php echo $form->getObject()->getCodigocadastro() ?>);
           
    <?php endif; ?>  
    clearSelectOptions('funcionario');
    cargaFuncionarios('<?php echo $form->getObject()->getCodigofuncionario() ?>');
<?php else: ?>  
    cargaFuncionarios('<?php echo aplication_system::getUser() ?>');
    
<?php endif; ?>
    
    // RUTINAS AL CAMBIAR SELECTORES
    // CAMBIA OPERACAO
    $('#saidas_operacao').change(function(){
        
        if ($(this).val() === 'e')
        {
            $("#tipo-tr").hide();
            $("#fecha-facturacion").show();            
            $("#lb-cadastro").html('Cliente');
            $("#lb-prevista").html('Data Prev. Recebimento');
            $("#lb-real").html('Data Recebimento');
            cargaClienteProjeto($('#saidas_codigoprojeto').val());
        }
        else
        {
            $("#tipo-tr").show();
            $("#fecha-facturacion").hide();        
            $("#lb-cadastro").html('Fornecedor');
            $("#lb-prevista").html('Data Prev. Pagamento');
            $("#lb-real").html('Data Pagamento');
            //clearSelectOptions('funcionario');
            
            $("#saidas_codigo_tipo > option").remove();
            $("#subtipo > option").remove();
            $("#fornecedor > option").remove();
            $("#saidas_codigo_tipo").append("<option value=''>Carregando...</option>");
            $("#subtipo").append("<option value=''>Selecione...</option>");
            $("#fornecedor").append("<option value=''>Selecione...</option>");
            cargaTipos($("#saidas_codigo_tipo").val(), $('#saidas_operacao').val());
        }
        cargaCentros($(this).val());          
    });
    
    // CAMBIA TIPOS
    $('.tipos').change(function(){
            cargaSubTiposSimple($('#saidas_codigo_tipo').val(),'0');
      });
    
    $('#subtipo').change(function(){
            cargaFornecedor('0',$("#subtipo").val());
      });
      
    // CUANDO VARÍE saidas_centro                             
    $('#saidas_centro').change(function(){          
        switch ($(this).val())
        {
            case 'projeto':
                $("#fornecedor-tr").show();
                if ($('#saidas_operacao').val() === 's') $("#tipo-tr").show();
                else $("#tipo-tr").hide();
                break;

            case 'compensação':
                $("#fornecedor-tr").hide();
                $("#tipo-tr").hide();
                $("#fecha-facturacion").hide();                
                break;

            case 'adiantamento':
                $("#tipo-tr").hide();
                $("#fornecedor-tr").hide();                                   
                break;

            default:
                alert('coño!');
                break;
        }                   
        analisisImpuesto();
      });
      
      // CAMBIA PROJETO
      $('#saidas_codigoprojeto').change(function(){            
            if (($('#saidas_centro').val() === 'projeto') &&
                ($('#saidas_operacao').val() === 'e') )
                cargaClienteProjeto($(this).val());                
      });      
    
 });   
 
</script>