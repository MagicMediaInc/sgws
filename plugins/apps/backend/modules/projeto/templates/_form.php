<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript"> 
$(document).ready(function() {
        var selectProp = $("#proposta_id_status_proposta option:selected").val();
        if(selectProp == 2){
             $("#dataFinalLine").show();
             $("#proposta_codigo_sgws_projeto").removeAttr('disabled');
        }else{
             $("#dataFinalLine").hide();
             $("#proposta_codigo_sgws_projeto").attr('disabled','disabled');
        }
        
        $('#resultsList td').addClass('borderBottomDarkGray');
        $("#projeto").validationEngine();
        $("#proposta_data_ir_projeto").datepicker({   
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',        
            changeMonth: true,
            changeYear: true
        });    
        $("#proposta_data_inicio").datepicker({   
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',        
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#proposta_data_fr_projeto" ).datepicker( "option", "minDate", selectedDate );
            }
        });    
        $("#proposta_data_fr_projeto").datepicker({
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',          
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#proposta_data_inicio" ).datepicker( "option", "maxDate", selectedDate );
                if(!$("#proposta_data_inicio").val())
                    {
                        $( "#proposta_data_inicio" ).val($("#proposta_data_fr_projeto").val());
                    }
            }
        }); 
        
        <?php if(!$form->getObject()->isNew()): ?>
        
            <?php if($form->getObject()->getIdStatusProposta() > 1): ?>
                $("#proposta_id_negociacao").hide();
                $("#back_log").show();
            <?php endif; ?>
        
            <?php if($form->getObject()->getDataInicio()): ?>
                $("#proposta_data_inicio").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataInicio())) ?>');
                $("#proposta_data_fr_projeto").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataFrProjeto())) ?>');
            <?php else: ?>
                $("#proposta_data_inicio").val('<?php echo date("d-m-Y") ?>');
            <?php endif; ?>
            <?php if($form->getObject()->getDataIrProjeto()): ?>
                $("#proposta_data_ir_projeto").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataIrProjeto())) ?>');
            <?php else: ?>
                $("#proposta_data_ir_projeto").val('');
            <?php endif; ?>
            <?php if(!$form->getObject()->getDataFrProjeto()): ?>
                $("#proposta_data_fr_projeto").val('');
            <?php endif; ?>
            
        <?php else: ?>
            $("#proposta_data_inicio").val('<?php echo date("d-m-Y") ?>');
        <?php endif; ?>
        $('#proposta_id_status_proposta').change(function(){
            cargaStatusProjeto($('#proposta_id_status_proposta').val());
            if($(this).val() == 2){ // Es projeto
                $("#proposta_id_negociacao").hide();
                $("#dataFinalLine").show();
                if($("#proposta_data_ir_projeto").val() == ""){
                    $('.proposta_data_ir_projetoformError').show();
                    $("#proposta_data_ir_projeto").addClass('validate[required] errorFound');
                }
                $("#proposta_codigo_sgws_projeto").removeAttr('disabled');
                $("#back_log").show();
            }else{
                $("#proposta_id_negociacao").show();
                $("#dataFinalLine").hide();
                $("#proposta_data_ir_projeto").removeClass('validate[required] errorFound');
                $('.proposta_data_ir_projetoformError').hide();
                $("#proposta_codigo_sgws_projeto").attr('disabled','disabled');
                $("#back_log").hide();
            }
        });
        
        $('#projeto').submit(function(event){
            //alert($("#proposta_id_status_proposta option:selected").val());
           if($("#proposta_id_status_proposta option:selected").val() == 1){
                if($("#proposta_data_ir_projeto").val() == "" || $("#proposta_data_ir_projeto").val() != ""){
                    return;
                }
             }else{
                if($("#proposta_data_ir_projeto").val() == ""){
                    $("#proposta_data_ir_projeto").addClass('validate[required] errorFound');
                    $('.proposta_data_ir_projetoformError').show();
                    event.preventDefault();
                    }
                }
        });
        
        
        $('#voltar-lista').click(function(){
            parent.jQuery.fancybox.close();
        });
        
        $('#nova_revision').click(function(){
            $("#r-new-revision").show();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        });
        
        formatInputTiempoHoras($('#proposta_coeficiente'));
        formatInputTiempoHoras($('#proposta_horas_vendidas'));
        formatInputMoneda($('#proposta_valor'));
        formatInputMoneda($('#proposta_valor_prev_hh'));
        <?php if(aplication_system::esUsuarioRoot() || aplication_system::esSocio()): ?>
            $("#cod-centro").show();
        <?php else: ?>
            $("#cod-centro").hide();
        <?php endif; ?>
        
        
})
</script>

    <div class="frameForm" align="left">
        <form id="projeto" action="<?php echo url_for('projeto/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?codigo_proposta='.$form->getObject()->getCodigoProposta() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <?php if (!$form->getObject()->isNew()): ?>
            <input type="hidden" name="sf_method" value="put" />
        <?php endif; ?>
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

            <?php if($edit): ?>
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
                                    <?php echo link_to(__('Eliminar'), 'projeto/delete?codigo_proposta='.$form->getObject()->getCodigoProposta(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => '')) ?>
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
            <?php endif;?>
            <tbody>
                <tr>
                    <td>                
                        <table cellpadding="0" cellspacing="2" border="0" width="100%" id="table-info">
                            
                            
                          <?php if(!$form->getObject()->isNew()): ?>
                            <tr>
                                <td colspan="4">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="position: relative;right: 3px;" >
                                        <tr>
                                            <td style="width: 15%;"><label>Código Sistema</label></td>
                                            <td style="width: 12%;">
                                                <input size="5" type="text" disabled="disabled" value="<?php echo $form->getObject()->getCodigoProposta() ?>" />
                                            </td>
                                            <td style="width: 15%;"><label>Código Proposta</label></td>
                                            <td style="width: 13%;">
                                                <?php echo $form['codigo_sgws'] ?>
                                                <?php echo $form['codigo_sgws']->renderError() ?>
                                            </td>
                                            <td style="width: 14%;"><label>Código Projeto</label></td>
                                            <td>
                                                <?php echo $form['codigo_sgws_projeto'] ?>
                                                <?php echo $form['codigo_sgws_projeto']->renderError() ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8"><hr style="border: 1px solid #09C;" /></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                          <?php else: ?>
                            <tr>
                              <td><?php echo $form['codigo_sgws']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['codigo_sgws'] ?>
                                <?php echo $form['codigo_sgws']->renderError() ?>
                              </td>
                          </tr>
                          <?php endif; ?>

                          <tr>
                              <td><?php echo $form['gerente']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['gerente'] ?>
                                <?php echo $form['gerente']->renderError() ?>
                              </td>
                          </tr>                          
                          <tr>
                              <td><?php echo $form['nome_proposta']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['nome_proposta'] ?>
                                <?php echo $form['nome_proposta']->renderError() ?>
                              </td>
                          </tr>
                          <tr>
                              <td><?php echo $form['cliente']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['cliente'] ?>
                                <?php echo $form['cliente']->renderError() ?>
                            </td>
                          </tr>
                          <tr id="cod-centro">
                              <td><?php echo $form['codigo_centro']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['codigo_centro'] ?>
                                <?php echo $form['codigo_centro']->renderError() ?>
                              </td>
                          </tr>
                          <tr>
                              <td style="width: 15%;"><?php echo $form['data_inicio']->renderLabel() ?></td>
                              <td style="width: 37%;">
                                <?php echo $form['data_inicio'] ?>
                                <?php echo $form['data_inicio']->renderError() ?>
                              </td>
                              <td style="width: 17%;"><?php echo $form['data_ir_projeto']->renderLabel() ?></td>
                              <td>
                                <?php echo $form['data_ir_projeto'] ?>
                                <?php echo $form['data_ir_projeto']->renderError() ?>
                              </td>
                          </tr>
                          <tr id='dataFinalLine'>
                              <td style="width: 4%;"><?php echo $form['data_fr_projeto']->renderLabel() ?></td>
                              <td style="width: 37%;">
                                <?php echo $form['data_fr_projeto'] ?>
                                <?php echo $form['data_fr_projeto']->renderError() ?>
                              </td>
                              <td colspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                              <td><?php echo $form['horas_vendidas']->renderLabel() ?></td>
                              <td><?php echo $form['horas_vendidas'] ?>
                                <?php echo $form['horas_vendidas']->renderError() ?>
                              </td>
                              <td><?php echo $form['horas_trabajadas']->renderLabel() ?></td>
                              <td>
                                <?php echo $form['horas_trabajadas'] ?>
                                <?php echo $form['horas_trabajadas']->renderError() ?>
                              </td>
                          </tr>
                          <tr>
                              <td><?php echo $form['id_prioridade']->renderLabel() ?></td>
                              <td>
                                <?php echo $form['id_prioridade'] ?>
                                <?php echo $form['id_prioridade']->renderError() ?>
                              </td>
                              <td><?php echo $form['coeficiente']->renderLabel() ?></td>
                              <td>
                                <?php echo $form['coeficiente'] ?>
                                <?php echo $form['coeficiente']->renderError() ?>
                              </td>
                          </tr>
                          <tr>
                              <td><?php echo $form['valor']->renderLabel() ?></td>
                              <td>
                                    <?php echo $form['valor'] ?>
                                    <?php echo $form['valor']->renderError() ?>
                              </td>
                              <td><?php echo $form['valor_prev_hh']->renderLabel() ?></td>
                              <td>
                                    <?php echo $form['valor_prev_hh'] ?>
                                    <?php echo $form['valor_prev_hh']->renderError() ?>
                              </td>
                          </tr>
                          <tr>
                              <td><?php echo $form['visualizacion']->renderLabel() ?></td>
                              <td>
                                    <?php echo $form['visualizacion'] ?>
                                    <?php echo $form['visualizacion']->renderError() ?>
                              </td>
                              <td><?php echo $form['apr']->renderLabel() ?></td>
                              <td>
                                    <?php echo $form['apr'] ?>
                                    <?php echo $form['apr']->renderError() ?>
                              </td>
                          </tr>
                          <tr>
                              <td><?php echo $form['codigo_tipo']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['codigo_tipo'] ?>
                                <?php echo $form['codigo_tipo']->renderError() ?>
                            </td>
                          </tr>
                          <tr>
                              <td><?php echo $form['id_negociacao']->renderLabel() ?></td>
                              <td>
                                <?php echo $form['id_negociacao'] ?>
                                <?php echo $form['id_negociacao']->renderError() ?>
                                  <div class="mask-imput hide" id="back_log" style="width: 100px;">
                                      Back Log
                                  </div>
                              </td>
                              <td><?php echo $form['id_status_proposta']->renderLabel() ?></td>
                              <td>
                                <?php echo $form['id_status_proposta'] ?>
                                <?php echo $form['id_status_proposta']->renderError() ?>
                              </td>                  
                          </tr>
                          <tr>
                              <td><?php echo $form['status']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['status'] ?>
                                <?php echo $form['status']->renderError() ?>
                              </td>
                          </tr>
                          <tr>
                              <td><?php echo $form['proposta']->renderLabel() ?></td>
                              <td colspan="3">
                                <?php echo $form['proposta'] ?>
                                <?php echo $form['proposta']->renderError() ?>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2"><?php echo $form['satisfacao_cliente']->renderLabel() ?>
                              <br />
                                    <?php echo $form['satisfacao_cliente'] ?>
                                    <?php echo $form['satisfacao_cliente']->renderError() ?>
                              </td>
                              <td><?php echo $form['nao_conformidade']->renderLabel() ?>
                                  <br />
                                    <?php echo $form['nao_conformidade'] ?>
                                    <?php echo $form['nao_conformidade']->renderError() ?>
                              </td>
                          </tr>
                          <tr style="display: none;">
                                <td><label>Secretarias</label></td>
                                <td colspan="3">
                                    
                                    <?php // $centros = CentroPeer::getList() ?>
                                    <?php // foreach ($centros as $c) : ?>
                                        <?php // $validate = ProjetoCentroPeer::checkCentroByProjeto($sf_request->getParameter('codigo_proposta'), $c->getId()); ?>
                                        <?php // $check = $validate ? 'checked="checked"' : ''?>
                                        <!--<input <?php // echo $check ?>  type="checkbox" id="tipo_<?php // echo $c->getId() ?>" name="chkCentro[<?php // echo $c->getId() ?>]" value="<?php // echo $c->getId() ?>" >-->
                                        <?php // echo $c->getCentro() ?><br />
                                    <?php // endforeach; ?>
                                    
                                    
                                </td>
                           </tr>
                           <tr>
                               <td colspan="4">&nbsp;</td>
                           </tr>
                        </table>                
                    </td>
                </tr>
            </tbody>
        </table>
        </form>    
        <?php if (!$form->getObject()->isNew() && (aplication_system::esUsuarioRoot() || aplication_system::esGerente() || aplication_system::esSocio())): ?>
        <br /><br />
        <?php $anexos = PropostaAnexoPeer::getAnexosProposta($form->getObject()->getCodigoProposta()); ?>
        <form id="revision_form" action="<?php echo url_for('projeto/creaAnalisisProposta?codigo_proposta='.$form->getObject()->getCodigoProposta()) ?>" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="cliente" id="cliente" value="<?php echo $form->getObject()->getCliente()?>" />
        <table width="100%" cellpadding='0' cellspacing="0" id="resultsList">
            <caption style="padding-bottom: 8px;">
                <div style="width:50% ; float: left"><h1>Registro de histórico de Análises</h1></div>
                
                    <div id="nova_revision" class="btn-adicionar-no-relative">Incluir Anexo</div>
                
            </caption>
            <thead>
                <th>&nbsp;</th>
                <th style="padding-left: 10px;">Data</th>
                <th>Responsável</th>
                <th>Situação</th>
                <th>Descrição</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
                <?php if($anexos): ?>
                    <?php foreach ($anexos as $revision) : ?>
                
                        
                        <?php $analise = AnalisisPeer::getAnexoProposta($revision->getId()) ?>
                        <tr>
                            <td>
                                <?php if($edit): ?>
                                    <?php echo link_to(image_tag('delete'), 'projeto/deleteAnexo?id='.$revision->getId(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => '')) ?>
                                <?php endif; ?>
                            </td>
                            <td style="padding-left: 10px;"><?php echo date("d-m-Y", strtotime($revision->getData())) ?></td>
                            <td>
                                <?php $respo = LxUserPeer::retrieveByPK($revision->getIdResponsable())  ?>
                                <?php echo $respo->getName() ?>
                            </td>
                            <td><?php //echo $revision->getStatus() ? 'Aprovado' : 'Não aprovado' ?></td>
                            <td><?php echo $revision->getDescricao() ?></td>
                            <td>
                                <a href="<?php echo url_for('@default?module=projeto&action=editAnexo&id='.$revision->getId()) ?>">
                                    <?php echo image_tag('icons/icon_obs', 'title="Editar Anexo" alt="Editar Anexo"') ?>
                                </a>
                                <?php if($analise): ?>
                                    <a href="<?php echo url_for('@default?module=projeto&action=editAnalisisCritico&id_analisis='.$analise->getId().'&by_analisis=1') ?>">
                                        <?php echo image_tag('icons/1389916284_list-accept','width="23" title="Análise Critica"') ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr id="r-new-revision" class="hide">
                    <td>&nbsp;</td>
                    <td style="padding-left: 10px; padding-right: 4px;"><input readonly="true" type="text" size="7" name="data_rev" id="data_rev" value="<?php echo date("d-m-Y") ?> "  /></td>
                    <td>
<!--                        <input type="text" readonly="true" size="15" name="responsavel_rev" id="responsavel_rev" value="<?php //echo aplication_system::getNameUser() ?>" />-->
                        <select name="responsavel" id="responsavel" style="width: 200px;">
                            <?php foreach ($responsables as $id => $value): ?>
                                <option value="<?php echo $id ?>" <?php //echo $Analisis->getResponsableComercial()   ? 'selected="selected"' : '' ?> ><?php echo $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="situacao_rev" id="situacao_rev" >
                            <option value="1">Não aprovado</option>
                        </select>
                    </td>
                    <td><textarea cols="30" rows="4" id="descricao_rev" name="descricao_rev"></textarea></td>
                    <td><input type="submit" value="Concluir" /></td>
                </tr>
            </tbody>
        </table>
        </form>
        <?php endif; ?>
    </div>

