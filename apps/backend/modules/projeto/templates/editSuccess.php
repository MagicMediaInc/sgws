
    <input type="hidden" id="idResponsablesSelect" value=" <?php echo $responsableComercial;?>">
    <input type="hidden" id="idCodigoUltimo" value=" <?php echo $codigoUltimo;?>">
<script type="text/javascript"> 
$(document).ready(function() {
    
     var idResponsable = $('#idResponsablesSelect').val();
     var idCodigoUltimo = $('#idCodigoUltimo').val();
     $('#proposta_horas_trabajadas').val($('#h_trabajadas').val());
     $("#proposta_horas_trabajadas").attr('disabled','disabled');
     var suma = 0;
     $("#responsable option[value="+idResponsable+"]").attr("selected",true);
     
        var selectProp = $("#proposta_id_status_proposta option:selected").val();
        if(selectProp == 2){
             $("#title_pro").html("INFORMAÇÕES");
             $("#dataFinalLine").show();
             $("#proj_block").show();
             $("#proposta_codigo_sgws_projeto").removeAttr('disabled');
        }else{
             $("#title_pro").html("INFORMAÇÕES");
             $("#dataFinalLine").hide();
             $("#proj_block").hide();
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
                $("#title_pro").html("INFORMAÇÕES DO PROJETO");
                $("#proposta_id_negociacao").hide();
                $("#dataFinalLine").show();
                $("#proj_block").show();
                if($("#proposta_data_ir_projeto").val() == ""){
                    $('.proposta_data_ir_projetoformError').show();
                    $("#proposta_data_ir_projeto").addClass('validate[required] errorFound');
                }
                $("#proposta_codigo_sgws_projeto").removeAttr('disabled');
                $("#back_log").show();
                if($("#proposta_codigo_sgws_projeto").val() == ""){
                suma = eval(idCodigoUltimo) + 1;
                //trim(suma);
                $("#proposta_codigo_sgws_projeto").val("PJ"+suma);
             }
            }else{
                $("#title_pro").html("INFORMAÇÕES DO PROPOSTA");
                $("#proposta_id_negociacao").show();
                $("#dataFinalLine").hide();
                $("#proj_block").hide();
                $("#proposta_data_ir_projeto").removeClass('validate[required] errorFound');
                $('.proposta_data_ir_projetoformError').hide();
                $("#proposta_codigo_sgws_projeto").attr('disabled','disabled');
                $("#back_log").hide();
                $("#proposta_codigo_sgws_projeto").val("");
                suma = 0;
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
        
        formatInputPercent($('#proposta_coeficiente'));
        formatInputTiempoHoras($('#proposta_horas_vendidas'));
        //formatInputTiempoHoras($('#proposta_horas_trabajadas'));
        formatInputMoneda($('#proposta_valor'));
        formatInputMoneda($('#proposta_valor_prev_hh'));
        <?php if(aplication_system::esUsuarioRoot() || aplication_system::esSocio()): ?>
            $("#cod-centro").show();
        <?php else: ?>
            $("#cod-centro").hide();
        <?php endif; ?>
        
        
})
</script>

<style>
  #contentPpal{
    min-width: 0px !important;
    width: 0% !important;
  }
  .requerido{
    display: block;
    height: 42px;
    padding:10px 5px;
  }
  .container{
    width: 100%;
  }
  .divtitles{
    margin-right: 10px;
    display: inline-block;
    width: 135px;
    vertical-align: middle !important;
  }
  .divcontens{
    display: inline-block;
  }
  .row{
    /*vertical-align: middle;*/
    /*margin-bottom: 10px;*/
    padding:5px 0px 5px 20px;
  }
  .grey{
    background: #eee;
  }
</style>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
  <?php   
     $tarefas = TarefaPeer::getTarefasByProjeto($form->getObject()->getCodigoProjeto());
      foreach ($tarefas as $tarefa ){
          $horastrab = TempotarefaPeer::getHorasTrabajadas($tarefa->getCodigoTarefa());
          $horastrab ? $horastrab : 0;
          $sumHT = $sumHT + $horastrab ;
      }
      ?>
    <input type="hidden" id="h_trabajadas" value="<?php echo $sumHT;?>"/>
    
    <?php if(count($analisis) >0){
        $analisisId = $analisis->getId();   
    }else{$analisisId = 'null';}?>
    <div class="frameForm" align="left">
        <form id="projeto" 
              action="<?php echo url_for('projeto/'.($form->getObject()->isNew() ? 'create' : 'UpdateProposta').(!$form->getObject()->isNew() ? '?codigo_proposta='.$form->getObject()->getCodigoProposta() : '').'&id_analisis='.$analisisId ) ?>" 
              method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <?php if (!$form->getObject()->isNew()): ?>
            <input type="hidden" name="sf_method" value="put" />
        <?php endif; ?>
        <div class="mensajes">
              <div class="requerido"><?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos')?></div>
              <div id="errorGlobal">
                  <?php echo $form->renderGlobalErrors() ?>
              </div>
        </div>
            <?php if($edit): ?>
        <!-- Div que renderiza los botones de save, delete y back -->
        <div class="buttons">
            <div><?php echo $form->renderHiddenFields(false) ?></div>
              <div class="button">
                  <a href="javascript:void(0);" id="voltar-lista" >Voltar à lista</a>    
              </div>
               <?php if (!$form->getObject()->isNew() && aplication_system::esUsuarioRoot()): ?>
                    <div class="button">
                        <?php echo link_to(__('Eliminar'), 'projeto/delete?codigo_proposta='.$form->getObject()->getCodigoProposta(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => '')) ?>
                    </div>
                <?php endif; ?>
              <div class="button">
                <input type="submit" value="<?php echo __('Salvar') ?>" />
              </div>
        </div>
        <!-- Fin div botones -->
            <?php endif;?>
              <div class="container">
                <?php if(count($responsable) > 0): ?>
                  <h1 class="tit-principal">
                      PROPOSTA
                  </h1>
                  <div class="row">
                    <div class="divtitles"><label>Código Proposta</label></div>
                    <div class="divcontens">
                            <?php echo $form['codigo_sgws'] ?>
                            <?php echo $form['codigo_sgws']->renderError() ?>
                    </div>
                  </div>
                  <div class="row grey">
                    <div class="divtitles"><?php echo $form['valor']->renderLabel() ?></div>
                    <div class="divcontens">
                        <?php echo $form['valor'] ?>
                        <?php echo $form['valor']->renderError() ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="divtitles"><label>Gerente PP:</label></div>
                    <div class="divcontens">
                            <select name="responsable" id="responsable">
                                <?php foreach ($responsable as $id => $value): ?>
                                <option value="<?php echo $id ?>" ><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                    </div>
                  </div>
                  <div class="row grey">
                    <div class="divtitles"><?php echo $form['nome_proposta']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['nome_proposta'] ?>
                      <?php echo $form['nome_proposta']->renderError() ?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="divtitles"><?php echo $form['cliente']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['cliente'] ?>
                      <?php echo $form['cliente']->renderError() ?>
                    </div>
                    
                  </div>
                  
                  <div class="row grey">
                    <div class="divtitles"><?php echo $form['data_inicio']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['data_inicio'] ?>
                      <?php echo $form['data_inicio']->renderError() ?>
                    </div>
                    <div class="divtitles" style="margin-left:15px;"><?php echo $form['data_ir_projeto']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['data_ir_projeto'] ?>
                      <?php echo $form['data_ir_projeto']->renderError() ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="divtitles"><?php echo $form['status']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['status'] ?>
                      <?php echo $form['status']->renderError() ?>
                    </div>
                    <div class="divtitles" style="margin-left:70px;"><?php echo $form['id_negociacao']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['id_negociacao'] ?>
                      <?php echo $form['id_negociacao']->renderError() ?>
                        <div class="mask-imput hide" id="back_log" style="width: 100px;">
                            Back Log
                        </div>
                    </div>
                  </div>

                  <div class="row grey">
                    <div class="divtitles" style="vertical-align:top !important; padding-top:60px;"><?php echo $form['proposta']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['proposta'] ?>
                      <?php echo $form['proposta']->renderError() ?>
                    </div>
                    
                  </div>

                  <hr style="border: 1px solid #09C;">
                  <h1 class="tit-principal">
                    PROJETO
                  </h1>
                  <?php endif; ?>
                  <div class="row">
                    <div class="divtitles"><?php echo $form['id_status_proposta']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['id_status_proposta'] ?>
                      <?php echo $form['id_status_proposta']->renderError() ?>
                    </div>
                  </div>
                  <div class="row grey">
                    <div class="divtitles"><label>Código Projeto</label></div>
                    <div class="divcontens">
                      <?php echo $form['codigo_sgws_projeto'] ?>
                      <?php echo $form['codigo_sgws_projeto']->renderError() ?>
                    </div>
                    <div class="divtitles" style="margin-left:115px;"><?php echo $form['codigo_centro']->renderLabel() ?></div>
                    <div class="divcontens">
                      <?php echo $form['codigo_centro'] ?>
                      <?php echo $form['codigo_centro']->renderError() ?>
                    </div>
                  </div>
                  <div class="row">
                      <div class="divtitles"><?php echo $form['gerente']->renderLabel() ?></div>
                      <div class="divcontens">
                        <?php echo $form['gerente'] ?>
                        <?php echo $form['gerente']->renderError() ?>
                      </div>
                  </div>
                  <div class="row grey">
                       <div class="divtitles"><?php echo $form['codigo_tipo']->renderLabel() ?></div>
                      <div class="divcontens">
                        <?php echo $form['codigo_tipo'] ?>
                        <?php echo $form['codigo_tipo']->renderError() ?>
                    </div>
                  </div> 
                  <div class="row">
                      <div class="divtitles"><?php echo $form['horas_vendidas']->renderLabel() ?></div>
                      <div class="divcontens"><?php echo $form['horas_vendidas'] ?>
                        <?php echo $form['horas_vendidas']->renderError() ?>
                      </div>
                      <div class="divtitles" style="margin-left:117px;"><?php echo $form['horas_trabajadas']->renderLabel() ?></div>
                      <div class="divcontens">
                        <?php echo $form['horas_trabajadas'] ?>
                        <?php echo $form['horas_trabajadas']->renderError() ?>
                      </div>
                  </div>
                  <div class="row grey">
                      <div class="divtitles"><?php echo $form['valor_prev_hh']->renderLabel() ?></div>
                      <div class="divcontens">
                            <?php echo $form['valor_prev_hh'] ?>
                            <?php echo $form['valor_prev_hh']->renderError() ?>
                      </div> 
                      <div class="divtitles" style="margin-left:83px;"><?php echo $form['coeficiente']->renderLabel() ?></div>
                      <div class="divcontens">
                        <?php echo $form['coeficiente'] ?>
                        <?php echo $form['coeficiente']->renderError() ?>
                      </div>
                  </div>  
                  <div class="row" id='dataFinalLine'>
                      <div class="divtitles"><?php echo $form['data_fr_projeto']->renderLabel() ?></div>
                      <div class="divcontens">
                        <?php echo $form['data_fr_projeto'] ?>
                        <?php echo $form['data_fr_projeto']->renderError() ?>
                      </div>
                      <div class="divtitles" style="margin-left:15px;"><?php echo $form['apr']->renderLabel() ?></div>
                      <div class="divcontens">
                            <?php echo $form['apr'] ?>
                            <?php echo $form['apr']->renderError() ?>
                      </div>
                  </div>
                  <hr style="border: 1px solid #09C;" />
                  <?php $gerenteProyecto = PropostaPeer::getGerenteProjeto($form->getObject()->getCodigoProposta());?>
                  <div class="row">
                      <div class="divtitles"><?php echo $form['satisfacao_cliente']->renderLabel() ?></div>
                      <div class="divcontens">
                            <?php echo $form['satisfacao_cliente'] ?>
                            <?php echo $form['satisfacao_cliente']->renderError() ?>
                      </div>
                      <div class="divtitles" style="margin-left:15px;"><?php echo $form['nao_conformidade']->renderLabel() ?></div>
                      <div class="divcontens">
                            <?php echo $form['nao_conformidade'] ?>
                            <?php echo $form['nao_conformidade']->renderError() ?>
                      </div>
                  </div>
              </div>               

                          <!-- </tbody>
                          <tr>
                              <td colspan="8"></td>
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
                                    
                                    
                                <!--</td>
                           </tr>
                           <tr>
                               <td colspan="4">&nbsp;</td>
                           </tr>
                        </table>                
                    </td>
                </tr>
            </tbody>
        </table> -->
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

