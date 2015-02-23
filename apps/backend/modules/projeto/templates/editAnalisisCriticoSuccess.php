<?php use_javascript("jq/jquery-ui-1.8.16.custom/development-bundle/ui/i18n/jquery.ui.datepicker-br.js") ?>
<script type="text/javascript"> 
    var url_fun = 'http://'+location.hostname+'/backend_dev.php';
    $(document).ready(function() {
        $('.data_analisis').each(function(){
            $(this).datepicker({   
                defaultDate: "+1w",
                dateFormat: 'dd-mm-yy',        
                changeMonth: true,
                changeYear: true
            }); 
        });
        <?php if($Analisis->getDataCreacion()): ?>
            $("#emision").val('<?php echo date("d-m-Y", strtotime($Analisis->getDataCreacion()))?>');
        <?php endif; ?>
        <?php if($Analisis->getDataAprobacion()): ?>
            $("#data_aprobacion").val('<?php echo date("d-m-Y", strtotime($Analisis->getDataAprobacion()))?>');
            $("#data_aprobacion").attr('disabled', 'disabled');
        <?php endif; ?>
        $("#tercerizado_sim").click(function(){
            $("#id_fornecedor").removeAttr('disabled');
            $("#valor_proposta").removeAttr('disabled');
        });
        $("#tercerizado_nao").click(function(){
            $("#id_fornecedor").attr('disabled','disabled');
            $("#valor_proposta").attr('disabled','disabled');
        });
        <?php if($Analisis->getResponsableTecnico() == aplication_system::getUser()): ?>
            $("input[name='aprobado_rt']").attr('disabled',false);
        <?php else: ?>
           $("input[name='aprobado_rt']").attr('disabled',true);
        <?php endif; ?>
        
        $("#responsable_tecnico").change(function()
        {
            if($(this).val() == <?php echo aplication_system::getUser() ?>)
            {
                $("input[name='aprobado_rt']").removeAttr('disabled');
            }else{
                $("input[name='aprobado_rt']").attr('disabled',true);
            }
        });
        formatInputMoneda($("#precio"));
    })
</script>

<div class="frameForm" align="left">
    <?php //include_partial('global/menuProjeto') ?>
    <form id="analisis" action="<?php echo url_for('projeto/'.(!$sf_request->getParameter('id_analisis') ? 'createAnalisis' : 'updateAnalisis').($sf_request->getParameter('id_analisis') ? '?id_analisis='.$sf_request->getParameter('id_analisis') : '')) ?>" method="post" enctype="multipart/form-data" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-info">
  <tr>
    <td colspan="6"><div class="tit-principal" style="padding-bottom:15px; border-bottom:1px solid #ccc;">análise crítica de propostas</div></td>
  </tr>
  <tr><td colspan="6">&nbsp;</td></tr>
  <tr>
        <td width="8%"><label>Emissão</label></td>
        <td style="width: 8%;"><input type="text" name="emision" id="emision" size="6" class="data_analisis" value="<?php echo $Analisis->getDataCreacion()  ?>" /></td>
        <td style="width: 6%;"><label>Proposta</label></td>
        <td style="width: 9%;"><input name="id_proposta" type="text" id="id_proposta" readonly="readonly" size="10" value="<?php echo $Analisis->getIdProposta()  ?>" /></td>
        <td style="width: 6%;"><label>Revisão</label></td>
        <td><input name="revision" type="text" disabled="disabled" id="revision" size="7" readonly="readonly" value="<?php echo $Analisis->getId()  ?>"  /></td>
  </tr>
  <tr>
    <td><label>Cliente</label></td>
    <td colspan="5">
        <select name="id_cliente" id="id_cliente" style="width: 200px;">
            <?php foreach ($clientes as $id => $value): ?>
            <option value="<?php echo $id ?>" <?php echo $Analisis->getIdCliente()   == $id ? 'selected="selected"' : '' ?>  ><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>
    </td>
  </tr>
    <tr>
    <td><label>Nome da Proposta</label></td>
    <td colspan="6">
        <input type="text" name="nome" id="nome" size="23"  required="required"value="<?php echo $Analisis->getNome() ?>" />
    </td>
  </tr>
  <tr>
      <td><label>Descrição</label></td>
      <td colspan="6">
          <textarea name="descricao" id="descricao" cols="45" rows="5"><?php echo $Analisis->getDescricao()   ?></textarea>
      </td>
  </tr>
  <tr>
    <td><label>Prazo de Execução da Amostragem</label></td>
    <td colspan="6">
        <input type="text" name="plazo" id="plazo" size="5" value="<?php echo $Analisis->getPlazo()   ?>" /> dias.
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">
        <div class="tit-principal" style="padding-bottom:15px; padding-top:10px; border-bottom:1px solid #ccc;">amostragem in loco</div>
    </td>
  </tr>
  <tr>
    <td colspan="7" bgcolor="#F2F2F2" style="padding:10px;">
        <label>VIABILIDADE TÉCNICA?</label><br />
        <input name="viabilidade_tecnica" type="radio" value="1" <?php echo $Analisis->getViabilidadeTecnica()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
        <input name="viabilidade_tecnica" type="radio" value="0" <?php echo !$Analisis->getViabilidadeTecnica()   ? 'checked="checked"' : '' ?> />Não
    </td>
  </tr>
  <tr>
      <td colspan="7" style="padding:10px;"><label>EQUIPAMENTOS APROPRIADOS?</label><br />
          <input name="equipamento_apropiado" type="radio" value="1" <?php echo $Analisis->getEquipamentoApropiado()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
          <input name="equipamento_apropiado" type="radio" value="0" <?php echo !$Analisis->getEquipamentoApropiado()   ? 'checked="checked"' : '' ?> />Não
      </td>
  </tr>
  <tr>
  <td colspan="7" bgcolor="#F2F2F2" style="padding:10px;">
      <label>METODOLOGIAS VALIDADAS?</label><br />
      <input name="metodologia_validada" type="radio" value="1" <?php echo $Analisis->getMetodologiaValidada()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
      <input name="metodologia_validada" type="radio" value="0" <?php echo !$Analisis->getMetodologiaValidada()    ? 'checked="checked"' : '' ?> />Não
  </td>
  </tr>
  <tr>
    <td colspan="7" style="padding:10px;"><label>QUANTIDADE DE AMOSTRA SUFICIENTE?</label><br />
        <input name="quantidade_amostra" type="radio" value="1" <?php echo $Analisis->getQuantidadeAmostra()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
        <input name="quantidade_amostra" type="radio" value="0" <?php echo !$Analisis->getQuantidadeAmostra()   ? 'checked="checked"' : '' ?>/>Não
    </td>
  </tr>
  <tr>
    <td colspan="7" bgcolor="#F2F2F2" style="padding:10px;"><label>VIABILIDADE OPERACIONAL?</label><br />
        <input name="viabilidade_operacional" type="radio" value="1" <?php echo $Analisis->getViabilidadeOperacional()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
        <input name="viabilidade_operacional" type="radio" value="0" <?php echo !$Analisis->getViabilidadeOperacional()   ? 'checked="checked"' : '' ?> />Não
    </td>
  </tr>
  <tr>
      <td colspan="7" style="padding:10px;"><label>TÉCNICO HABILITADO?</label><br />
          <input name="tecnico_habilitado" type="radio" value="1" <?php echo $Analisis->getViabilidadeTecnica()   ?  'checked="checked"' : '' ?> />Sim &nbsp;
          <input name="tecnico_habilitado" type="radio" value="0" <?php echo !$Analisis->getViabilidadeTecnica()   ?  'checked="checked"' : '' ?> />Não
      </td>
  </tr>
  
  <tr>
    <td colspan="7" style="padding:10px;"><label>MÃO-DE-OBRA DISPONÍVEL?</label><br />
        <input name="mano_obra" type="radio" value="1" <?php echo $Analisis->getManoObra()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
        <input name="mano_obra" type="radio" value="0" <?php echo !$Analisis->getManoObra()   ? 'checked="checked"' : '' ?> />Não
    </td>
  </tr>
  <tr>
  <td colspan="7" bgcolor="#F2F2F2" style="padding:10px;"><label>PRAZO EXEQUÍVEL?</label><br />
      <input name="plazo_exequivel" type="radio" value="1" <?php echo $Analisis->getPlazoExequivel()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
      <input name="plazo_exequivel" type="radio" value="0" <?php echo !$Analisis->getPlazoExequivel()   ? 'checked="checked"' : '' ?> />Não
  </td>
  </tr>
  <tr>
    <td colspan="7" style="padding:10px;"><label>VIABILIDADE FINANCEIRA?</label><br />
        <input name="viabilidade_financiera" type="radio" value="1" <?php echo $Analisis->getViabilidadeFinanciera()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
        <input name="viabilidade_financiera" type="radio" value="0" <?php echo !$Analisis->getViabilidadeFinanciera()   ? 'checked="checked"' : '' ?> />Não
    </td>
  </tr>
  <tr>
  <td colspan="7" bgcolor="#F2F2F2" style="padding:10px;"><label>VALOR ADEQUADO?</label><br />
      <input name="valor_adecuado" type="radio" value="1" <?php echo $Analisis->getValorAdecuado()   ? 'checked="checked"' : '' ?> />Sim &nbsp;
      <input name="valor_adecuado" type="radio" value="0" <?php echo !$Analisis->getValorAdecuado()   ? 'checked="checked"' : '' ?> />Não
  </td>
  </tr>
  <tr>
    <td colspan="7" style="padding:10px;"><label>PRAZO DE PAGAMENTO ADEQUADO?</label><br />
        <input name="plazo_pagamento" type="radio" value="1" <?php echo $Analisis->getPlazoPagamento()   ? 'checked="checked"' : '' ?>  />Sim &nbsp;
        <input name="plazo_pagamento" type="radio" value="0" <?php echo !$Analisis->getPlazoPagamento()   ? 'checked="checked"' : '' ?> />Não
    </td>
  </tr>
  <tr>
    <td colspan="7"></td>
  </tr>
</table>
    
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-info">
  <tr>
    <td colspan="7"><div class="tit-principal" style="padding-bottom:5px; padding-top:10px; border-bottom:1px solid #ccc;">terceirização de serviços (amostragem)</div></td>
  </tr>
  <tr>
    <td colspan="7" style="padding: 10px;">
        <p>Possibilidade de Subcontratação ou de Terceirização para os serviços de Amostragem?</p><br />
        <input name="tercerizado" id="tercerizado_sim" type="radio" value="1" <?php echo $Analisis->getTercerizado() ? 'checked="checked"' : '' ?>/>Sim &nbsp;
        <input name="tercerizado" id="tercerizado_nao" type="radio" value="0" <?php echo !$Analisis->getTercerizado() ? 'checked="checked"' : '' ?> />Não
    </td>
  </tr>
  <tr>
    <td colspan="7"><table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
            <td style="width: 5%"><label>Empresa:</label></td>
            <td style="width: 5%">
                <select name="id_fornecedor" id="id_fornecedor" style="width: 200px;">
                <?php foreach ($fornecedor as $id => $value): ?>
                    <option value="<?php echo $id ?>" <?php echo $Analisis->getIdFornecedor()   == $id ? 'selected="selected"' : '' ?>><?php echo $value ?></option>
                <?php endforeach; ?>
                </select>
            </td>
            <td style="width: 9%"><label>Valor da Proposta</label></td>
            <td><input name="valor_proposta" value="<?php echo $Analisis->getValidadeProposta()   ?>" type="text" id="valor_proposta" size="15"  /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="7" style="padding: 10px;"><p>APROVADO PELO CLIENTE?</p><br />
        <input name="aprobacion_cliente" type="radio" value="1" <?php echo $Analisis->getAprobacionCliente() ? 'checked="checked"' : '' ?> />Sim &nbsp;
        <input name="aprobacion_cliente" type="radio" value="0" <?php echo !$Analisis->getAprobacionCliente() ? 'checked="checked"' : '' ?> />Não
    </td>
  </tr>
</table>
    
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-info">
  <tr>
    <td colspan="7"><div class="tit-principal" style="padding-bottom:5px; padding-top:10px; border-bottom:1px solid #ccc;">APROVAÇÃO DA ANÁLISE CRÍTICA</div></td>
  </tr>
  <tr>
      <td style="width: 20%"><label>Responsável Comercial</label></td>
        <td colspan="6">
                <select name="responsable_comercial" id="responsable_comercial">
                <?php foreach ($funcionarios as $id => $value): ?>
                    <option value="<?php echo $id ?>" <?php echo $Analisis->getResponsableComercial() == $id   ? 'selected="selected"' : '' ?> ><?php echo $value ?></option>
                <?php endforeach; ?>
                </select>
        </td>
  </tr>
  <tr>
    <td colspan="7" style="padding:10px;"><p>APROVADO PELO RESPONSÁVEL COMERCIAL?</p><br />
        <input name="aprobado_rc" type="radio" value="1" <?php echo $Analisis->getAprobadoResponsableComercial()  ? 'checked="checked"' : '' ?> />Sim &nbsp;
        <input name="aprobado_rc" type="radio" value="0" <?php echo !$Analisis->getAprobadoResponsableComercial()  ? 'checked="checked"' : '' ?> />Não
    </td>
  </tr>
    <tr>
        <td><label>Gerente e Responsável Técnico</label></td>
    <td colspan="6">
      <select name="responsable_tecnico" id="responsable_tecnico">
            <?php foreach ($responsable  as $id => $value): ?>
          <option value="<?php echo $id ?>" <?php echo $id == $Analisis->getResponsableTecnico() ? 'selected="selected"' : '' ?> ><?php echo $value ?></option>
            <?php endforeach; ?>
            </select>
    </td>
  </tr>
  <tr>
    <td colspan="7" style="padding: 10px;"><p>APROVADO PELO RESPONSÁVEL TÉCNICO?</p><br />
        <input name="aprobado_rt" id="aprobado_rt" type="radio" value="1" <?php echo $Analisis->getAprobadoResponsableTecnico()  ? 'checked="checked"' : '' ?> />Sim &nbsp;
        <input name="aprobado_rt" id="aprobado_rt" type="radio" value="0" <?php echo !$Analisis->getAprobadoResponsableTecnico()  ? 'checked="checked"' : '' ?>  />Não
    </td>
  </tr>
  
    <tr>
      <td colspan="7"><div class="tit-principal" style="padding-bottom:5px; padding-top:10px; border-bottom:1px solid #ccc;">APROVAÇÃO DA proposta</div></td>
    </tr>
    <tr>
        <td><label>Status da Proposta</label></td>
        <td colspan="6" style="padding:0px;">
          <input name="aprobacion_proposta" type="hidden" value="<?php echo $Analisis->getAprobacionProposta() ?>" />
          <?php $status = StatusPeer::retrieveByPK($Analisis->getAprobacionProposta()) ?>
          
          <div class="mask-imput" style="margin-bottom: 10px; padding: 6px;width: 110px;margin-left: 3px;margin-top: 8px;">
              <?php echo $status->getIdstatus() ?>
          </div>
        </td>
    </tr>
  
  <tr>
    <td><p>Proposta final</p></td>
    <td colspan="2" style="width: 15%;"><input name="codigo_proposta_final" type="text" disabled="disabled" id="codigo_proposta_final" value="<?php echo $proposta_final ?>" readonly="readonly" /></td>
    <td style="width: 22%;">Validade da Proposta (dias)</td>
    <td><input type="text" name="validade_proposta" id="validade_proposta" value="<?php echo $Analisis->getValidadeProposta()  ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>Data da Aprovação</p></td>
    <td colspan="2"><input type="text" class="data_analisis" name="data_aprobacion"  disabled="disabled" id="data_aprobacion" value="<?php echo $Analisis->getDataAprobacion()   ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>Valor</p></td>
    <td colspan="2"><input type="text" disabled="disabled" name="precio" id="precio" value="<?php echo $Analisis->getPrecio()   ?>" /></td>
    <td>Forma de Pagamento</td>
    <td>
        <select name="forma_pagamento" id="forma_pagamento">
            <option value="Dinheiro" <?php echo $Analisis->getFormaPagamento() == 'Dinheiro' ? 'selected="selected"' : '' ?> >Dinheiro</option>
            <option value="Cheque" <?php echo $Analisis->getFormaPagamento() == 'Cheque' ? 'selected="selected"' : '' ?>>Cheque</option>
            <option value="Cartão" <?php echo $Analisis->getFormaPagamento() == 'Cartão' ? 'selected="selected"' : '' ?>>Cartão</option>
            <option value="Transferência" <?php echo $Analisis->getFormaPagamento() == 'Transferência' ? 'selected="selected"' : '' ?>>Transferência Bancária</option>
        </select>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    
<!--    <td><input type="submit" name="search" id="busca" value="Imprimir Análise Crítica" /></td>-->
    <td align="left"><input type="submit" name="search" id="busca" value="Concluir" /></td>
    <?php if($sf_request->getParameter('by_analisis')): ?>
    <td>
      <div class="button">
          <a href="<?php echo url_for('@default?module=projeto&action=edit&codigo_proposta='.$Analisis->getIdProposta()) ?>"  >Voltar à lista</a>    
      </div>
    </td>
    <?php endif; ?>
    <td colspan="5">&nbsp;</td>
    
  </tr>
</table>
    </form>
</div>