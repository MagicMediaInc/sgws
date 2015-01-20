<?php //use_javascript('jq/ddmenuMst.js') ?>
<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>
<?php use_javascript('fancybox/jquery.fancybox.js') ?>
<?php use_javascript('jq/accordionmenu.js') ?>
<?php use_stylesheet('projetos.css') ?>

<script type="text/javascript">
    $(document).ready(function() {
       var href = $(location).attr('href');
       var url = $(this).attr('title'); 
       var res = href.substring(href.length - 2 , href.length);
       
               
       if(res == "ll"  || res == "to" ) {
            $("#title_id").html("Consulta de Projetos");
            $(".icono_projeto").html("Projetos");
            $("#lista").html("Lista de Projetos");
        }
         if(res == "pj") {
             
            $("#title_id").html("Consulta de meus Projetos");
            $(".icono_projeto").html("Meus Projetos");
            $("#lista").html("Lista de Projetos");
        }
        
        if(res == "op") {
            $("#title_id").html("Consulta de Propostas");
            $(".icono_projeto").html("Propostas");
            $("#lista").html("Lista de Propostas");

        }

        
        $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false});
        // choose text for the show/hide link
        var showText="+";
        var hideText="-";
        // append show/hide links to the element directly preceding the element with a class of "toggle"
        $(".toggle").prev().append('<a href="#" class="toggleLink">'+showText+'</a>');
        // hide all of the elements with a class of 'toggle'
        $('.toggle').hide();
        // capture clicks on the toggle links
        $('a.toggleLink').click(function() {
            // change the link depending on whether the element is shown or hidden
            if ($(this).html()==showText) {
            $(this).html(hideText);
            }
            else {
            $(this).html(showText);
            }
            // toggle the display
            $(this).parent().next('.toggle').toggle('slow');
            // return false so any link destination is not followed
            return false;
        });
        $('#tipo_reg').change(function(){
            if($(this).val() == 'all')
            {
                $("#proposta_status > option").remove();
                $("#proposta_status").append("<option value=''></option>");
            }else{
                cargaStatusProjeto($('#tipo_reg').val());
            }
            
        });
    });
</script>
<style type="text/css">
    .fancybox-custom .fancybox-skin {
            box-shadow: 0 0 50px #222;
    }
</style>
<h1 class="icono_projeto"></h1>
<?php TempotarefaPeer::$instances; //if(aplication_system::isAllAction() || aplication_system::esContable()): ?>
<?php if( 1 == 2 ): ?>
    <a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Novo Projeto')?></a>
<?php endif; ?>
<?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot() || aplication_system::isGerenteTecnicoComercial() ): ?>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for('@default?module=projeto&action=analisisCritico') ?>"> Incluir Proposta</a>
<?php endif; ?>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm" style="position: relative; top: 0px;">
<?php echo form_tag('projeto/index',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <?php include_partial('global/menuProjeto') ?>
    <table width="100%" border="0" cellspacing="5" cellpadding="0" style="border-bottom: 1px solid #E5E5E5; margin-bottom: 2px;">
      <tr>
          <td width="318" colspan="3">
              <span id="title_id"class="tit-principal"></span>
              <br /><br />
          </td>        
      </tr>
      <tr>
         
           <!--  <table width="100%" border="0" cellspacing="3" cellpadding="0">
                <tr> -->
                  <td>
                      <label>Tipo</label><br />
                      <select id="tipo_reg" name="tipo_reg">
                          <option value="all" <?php echo $sf_request->getParameter('tipo_reg') == 'all' ? 'selected="selected"' : '' ?>>Todos</option>
                          <option value="2" <?php echo $sf_request->getParameter('tipo_reg') == 2 ? 'selected="selected"' : '' ?> >Projetos</option>
                          <option value="1" <?php echo $sf_request->getParameter('tipo_reg') == 1 || $sf_request->getParameter('q') == 'prop' ? 'selected="selected"' : '' ?>>Propostas</option>
                      </select>
                  </td>
                  <td >
                      <label>Status</label><br />
                      <select id="proposta_status" name="proposta_status">
                          <?php foreach ($statusFilter as $key => $value): ?>
                            <option value="<?php echo $key ?>" <?php echo $sf_request->getParameter('proposta_status') == $key ? 'selected="selected"' : '' ?>  ><?php echo $value ?></option>
                          <?php endforeach; ?>
                      </select>
                  </td>
                <!-- </tr>
            </table>    
          </td>
          <td> -->
           <td align="left" width="90%">
            <label>Palavra Chave</label><br />
            <span class="propiedades propiedades-extend" style="width: 450px; border-left: 1px #ccc dotted; height: 120px;">
                <input type="text" style="width: 290px;" placeholder="Codigo Projeto, Descrição, etc" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" />
                <input type="hidden" name="q" value="<?php echo $sf_request->getParameter('q') ?>" />
                <input type="submit" name="search" id="busca" value="Buscar" />
            </span>
          </td>
     </tr>
     <tr>
         <td colspan="3">&nbsp;</td>
     </tr>
    </table>    
</form>
<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
    <tbody>
        
        <tr>
            <td style="padding: 10px;">
                <img src="/images/legenda-projetos.jpg" width="931" height="25" />
                
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:100%; height:30px;  color:#FFF; line-height:30px;">
                    <h2 style="color: #058DC7;" id="lista"></h2>
                </div>
                <div id="caption-projetos">
                    <div style="width: 8%; text-align: center;">Código</div>
                    <div style="width: 45%;">Descrição</div>
                    <div style="width: 6%;">Progresso</div>
                    <div style="width: 111px;text-align: center;">Data</div>
                    <div style="width: 5%;text-align: center;">Duração</div>
                    <div style="width: 6%; text-align: center;">Trabalhado</div>
                </div>
                <?php $nPro = 0; ?>                                
                <?php if ($Propostas->getNbResults()): ?>                                
                    <?php foreach ($Propostas as $Proposta): ?>
                    <?php if($sf_request->getParameter('q')=='all' || ($sf_request->getParameter('q') != 'all' &&  aplication_system::accessProject($Proposta))): ?>
                    <?php $nPro ++; ?>                                
                    <?php $cod_projeto = $Proposta->getCodigoProjeto() ? $Proposta->getCodigoProjeto() : $Proposta->getCodigoProposta() ?> 
                    <?php $tarefas = TarefaPeer::getTarefasByProjeto($cod_projeto) ?>
                    <?php $analisis = AnalisisPeer::getAnalisis($Proposta->getCodigoProposta()); ?>  
                <?php if(count($analisis) == 0){
                        $idAnalisis = 'null';}
                        else{
                        $idAnalisis = $analisis[0]->getId();
                        }?>
                    <div class="data-project-fl">
                        <div class="codigo">
                            <a class="fancybox fancybox.iframe"
                               href="<?php echo url_for('@default?module=projeto&action=edit&codigo_proposta='.$Proposta->getCodigoProposta().'&id_analisis='.$idAnalisis) ?>">
                                <?php echo $Proposta->getCodigoSgwsProjeto() ? $Proposta->getCodigoSgwsProjeto() : $Proposta->getCodigoSgws() ?>
                            </a>
                        </div>
                        <div class="tit-projeto">
                            <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=projeto&action=edit&codigo_proposta='.$Proposta->getCodigoProposta().'&id_analisis='.$idAnalisis) ?>">
                                <?php $gerente = LxUserPeer::getCurrentPassword($Proposta->getGerente()); ?>
                                <?php $cliente = CadastroJuridicaPeer::getNameJuridico($Proposta->getCliente()); ?>
                                <?php if($Proposta->getNomeProposta()):  ?>
                                    <?php echo substr($Proposta->getNomeProposta(), 0, 90)  ?>
                                <?php else: ?>
                                    Análise Crítica
                                <?php endif; ?><br />
                                    <?php if($gerente): ?>
                                <b>Gerente:</b> <?php echo $gerente->getName() ?>
                                    <?php endif; ?>
                                    <?php if($cliente): ?>
                                    -<b>Cliente:</b> <?php echo $cliente['nome'] ?>
                                    <br /><br />
                                    <?php endif; ?>
                            </a>
                        </div>
                        <div class="horas">
                            <?php $horasTrabajadas = $Proposta->getHorasTrabajadas()  ?>
                            <?php if($Proposta->getHorasVendidas() > 0): ?>
                                <?php $porcentaje = $Proposta->getHorasVendidas() ? ($horasTrabajadas * 100) /  $Proposta->getHorasVendidas() : 0;?>
                            <?php else: ?>
                                <?php $porcentaje = 0 ;?>    
                            <?php endif; ?>
                            <?php echo aplication_system::monedaFormat($porcentaje) ; ?> %
                        </div>
                        <div class="data-projeto">
                            Início: <?php echo $val->formatoFechaPT2($Proposta->getDataInicio()) ?><br />
                            Fim: <?php echo $val->formatoFechaPT2($Proposta->getDataFrProjeto()) ?>
                        </div>
                        <div class="horas-duracion">
                            <?php echo $Proposta->getHorasVendidas() ?> 
                        </div>
                        <div class="horas-duracion" id="horas-trabajadas-<?php echo $Proposta->getCodigoProposta() ?>">
                            <?php echo $horasTrabajadas ?> 
                        </div>
                        <div class="herramientas" >
                            
                            <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=projeto&action=edit&codigo_proposta='.$Proposta->getCodigoProposta() .'&id_analisis='.$idAnalisis) ?>"><?php echo image_tag('icons/mas_info','title="Informações do projeto"') ?></a>&nbsp; 
                            <?php #if(aplication_system::compareUserVsResponsable($Proposta->getGerente()) && $Proposta->getIdStatusProposta() > 1 || ( aplication_system::esContable()  ) || aplication_system::esSocio() || aplication_system::esUsuarioRoot()): ?>
                            <?php if( $Proposta->getIdStatusProposta() > 1 && (aplication_system::compareUserVsResponsable($Proposta->getGerente()) || aplication_system::esContable() || aplication_system::esSocio() || aplication_system::esUsuarioRoot())): ?>
                                <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=new&codigo_projeto='.$cod_projeto.'&status_projeto='.$Proposta->getIdStatusProposta() ) ?>"><?php echo image_tag('icons/icon_tarefa_mini','title="Inclusão de tarefa."') ?></a>&nbsp;
                            <?php endif; ?>
                            <?php if($Proposta->getIdStatusProposta() > 1): ?>
                                <?php //if(aplication_system::compareUserVsResponsable($Proposta->getGerente()) || aplication_system::esUsuarioRoot() || aplication_system::esSocio() ): ?>
                                    <a href="<?php echo url_for('@default?module=despesa&action=index&id_projeto='.$cod_projeto ) ?>">
                                    <?php echo image_tag('icons/financeiro','width="24" title="Despesas"') ?>
                                    </a>
                                <?php //endif; ?>
                            <?php endif; ?>
                            <?php //echo image_tag('icons/gantt','width="24" title="Gráfico de Gantt"') ?>
                            <?php //echo image_tag('icons/notificacoes','width="22" title="Notificações"') ?>
                            <?php $ico_neg = $Proposta->getIdNegociacao() ? $Proposta->getIdNegociacao() : '1'; ?>
                            <?php if($Proposta->getIdStatusProposta() > 1): ?>
                                <?php echo image_tag('icons/neg_1',' title=""') ?></a>&nbsp;                            
                            <?php else: ?>
                                <?php if($Proposta->getStatus() == 3): ?>
                                <?php echo image_tag('icons/neg_4',' title=""') ?></a>&nbsp;
                                    <?php else: ?>
                                    <?php echo image_tag('icons/neg_'.$ico_neg,' title=""') ?></a>&nbsp; 
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($Proposta->getIdStatusProposta() > 1): ?>
                                <!-- <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=projetoGasto&action=index&id_projeto='.$Proposta->getCodigoProposta() ) ?>"> -->
                                <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=projetoGasto&action=index&id_projeto='.$Proposta->getCodigoProjeto() ) ?>">
                                    <?php echo image_tag('icons/status_pagamento',' title="Gastos Previstos do Projeto" style="width: 27px;"') ?>
                               </a>
                                <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=despesa&action=fatu&id_projeto='.$Proposta->getCodigoProjeto() ) ?>">
                                    <?php echo image_tag('icons/tipo_despesa',' title="Fatura do Projeto" style="width: 27px; position: relative; top: 2px; left: 4px;"') ?>
                                </a>
                                <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=projetoRate&action=index&id_projeto='.$Proposta->getCodigoProjeto() ) ?>">
                                    <?php echo image_tag('icons/rate',' title="Rate dos Funcionários" style="width: 27px; position: relative; top: 2px; left: 4px;"') ?>
                                </a>
                                
                            <?php endif; ?>
                        </div>
                    </div>
                        <?php if($Proposta->getIdStatusProposta() > 1): ?>
                            <?php if($tarefas): ?>

                                    <div class="toggle data-task-pr" style="display: none;">
                                    <?php $sumHT = 0 ?>
                                    <?php foreach ($tarefas as $tarefa): ?>                                                 
                                            <?php if(aplication_system::accessTask($tarefa,$Proposta->getGerente())): ?>
                                            <table id="tarefa" cellspacing="0" cellpadding="0" >
                                                <tr>
                                                    <td style="width: 49%; border-right:1px solid #ccc; padding-left: 13px;">
                                                        <?php $des = TarefadescricaoPeer::retrieveByPK($tarefa->getDescricao())  ?>
                                                        <?php echo $des->getTarefa() ?>
                                                    </td>
                                                    <td style="width: 5%; text-align: center; border-right:1px solid #ccc;">
                                                        <?php $horasTbj = TempotarefaPeer::getHorasTrabajadas($tarefa->getCodigotarefa()) ?>
                                                        <?php $porcentajeTarefa = $horasTbj ? ($horasTbj * 100) /  $tarefa->getHorasPrevistas() : 0;?>
                                                        <?php echo aplication_system::monedaFormat($porcentajeTarefa) ?> %
                                                    </td>
                                                    <td style="width: 11%; border-right:1px solid #ccc; padding: 4px;">
                                                        Início: <?php echo $val->formatoFechaPT2($tarefa->getDataIrTarefa()) ?><br />
                                                        Fim: <?php echo $val->formatoFechaPT2($tarefa->getDataFrTarefa()) ?>
                                                    </td>
                                                    <td style="border-right:1px solid #ccc; width: 6%;">

                                                        <?php echo $tarefa->getHorasPrevistas() ?> 
                                                    </td>
                                                    <td style="border-right:1px solid #ccc; width: 6%;">

                                                        <?php $horastrab = TempotarefaPeer::getHorasTrabajadas($tarefa->getCodigoTarefa()) ?>
                                                        <?php echo $horastrab ? $horastrab : 0 ?> 
                                                        <?php $sumHT = $sumHT + $horastrab ?>
                                                        <script>
                                                            $("#horas-trabajadas-<?php echo $Proposta->getCodigoProposta() ?>").html('<?php echo $sumHT ?>');
                                                        </script>
                                                    </td>
                                                    <td>
                                                        <?php if(aplication_system::accessTask($tarefa,$Proposta->getGerente())): ?>
                                                            <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=edit&codigotarefa='.$tarefa->getCodigoTarefa().'&status_projeto='.$Proposta->getIdStatusProposta().'&codigo_projeto='.$cod_projeto) ?>"><?php echo image_tag('icons/mas_info','title="Informações da tarefa"') ?></a>
                                                        <?php endif; ?>&nbsp;
                                                        <a href="<?php echo url_for('@default?module=despesa&action=index&id_projeto='.$cod_projeto.'&id_tarefa='.$tarefa->getCodigoTarefa() ) ?>">
                                                        <?php echo image_tag('icons/financeiro','width="24" title="Despesas"') ?>
                                                        </a>&nbsp;
                                                        <?php if($tarefa->getVisualizacao()): ?>
                                                            <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=equipe&codigotarefa='.$tarefa->getCodigoTarefa() ) ?>"><?php echo image_tag('icons/perm_1','width="26" title="Equipe da Tarefa."') ?></a>
                                                        <?php endif; ?>
                                                        <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=listActivity&codigotarefa='.$tarefa->getCodigoTarefa() ) ?>"><?php echo image_tag('icons/reg_activity_2','width="26" title="Registrar Atividade"') ?></a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php $tarefasHijas = TarefaPeer::getTarefasHijas($tarefa->getCodigoTarefa()) ?>
                                            
                                            <?php if($tarefasHijas): ?>
                                                <?php foreach ($tarefasHijas as $tarefahija): ?>                                                 
                                                    <?php if(aplication_system::accessTask($tarefahija,$Proposta->getGerente())): ?>
                                                    <table id="tarefa" cellspacing="0" cellpadding="0" style="width: 98%;margin-left: 31px;" >
                                                        <tr>
                                                            <td style="width: 48%; border-right:1px solid #ccc; padding-left: 13px;">
                                                                <?php $des = TarefadescricaoPeer::retrieveByPK($tarefahija->getDescricao())  ?>
                                                                <?php echo $des->getTarefa() ?>
                                                            </td>
                                                            <td style="width: 5%; text-align: center; border-right:1px solid #ccc;">
                                                                <?php $horasTbj = TempotarefaPeer::getHorasTrabajadas($tarefahija->getCodigotarefa()) ?>
                                                                <?php $porcentajeTarefa = $tarefahija->getHorasPrevistas() ? ($horasTbj * 100) /  $tarefahija->getHorasPrevistas() : 0;?>
                                                                <?php echo aplication_system::monedaFormat($porcentajeTarefa) ?> %
                                                            </td>
                                                            <td style="width: 11%; border-right:1px solid #ccc; padding: 4px;">
                                                                Início: <?php echo $val->formatoFechaPT2($tarefahija->getDataIrTarefa()) ?><br />
                                                                Fim: <?php echo $val->formatoFechaPT2($tarefahija->getDataFrTarefa()) ?>
                                                            </td>
                                                            <td style="border-right:1px solid #ccc; width: 6%;">

                                                                <?php echo $tarefahija->getHorasPrevistas() ?> horas
                                                            </td>
                                                            <td style="border-right:1px solid #ccc; width: 6%;">

                                                                <?php $horastrab = TempotarefaPeer::getHorasTrabajadas($tarefahija->getCodigoTarefa()) ?>
                                                                <?php echo $horastrab ? $horastrab : 0 ?> horas
                                                            </td>
                                                            <td>
                                                                <?php if(aplication_system::isAllAction() || aplication_system::esContable()): ?>
                                                                    <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=edit&codigotarefa='.$tarefahija->getCodigoTarefa().'&status_projeto='.$Proposta->getIdStatusProposta().'&codigo_projeto='.$cod_projeto) ?>"><?php echo image_tag('icons/mas_info','title="Informações da tarefa"') ?></a>
                                                                <?php endif; ?>&nbsp;
                                                                <a href="<?php echo url_for('@default?module=despesa&action=index&id_projeto='.$cod_projeto.'&id_tarefa='.$tarefahija->getCodigoTarefa() ) ?>">
                                                                <?php echo image_tag('icons/financeiro','width="24" title="Despesas"') ?>
                                                                </a>&nbsp;
                                                                <?php if($tarefahija->getVisualizacao()): ?>
                                                                    <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=equipe&codigotarefa='.$tarefahija->getCodigoTarefa() ) ?>"><?php echo image_tag('icons/perm_1','width="26" title="Equipe da Tarefa."') ?></a>
                                                                <?php endif; ?>
                                                                <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=listActivity&codigotarefa='.$tarefahija->getCodigoTarefa() ) ?>"><?php echo image_tag('icons/reg_activity_2','width="26" title="Inclusão de Atividade"') ?></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>

                            <?php endif; ?>
                        <?php endif; ?>                                            
                    <?php endif; ?>                                            
                    <?php endforeach; ?>    
                <?php else: ?>
                    <div style="width:100%; height:30px;  color:#FFF; line-height:30px;" class="center">
                        <span class="erro_no_data" >Nenhum projeto</span>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>
<?php if ($Propostas->haveToPaginate() ): ?>
<table width="100%" align="center" id="paginationTop" border="0" class="pagination" style="margin-top: 40px;">
	<tr>
    	<td align="left" ><i><?php echo $Propostas->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Propostas->getPage().' '.__('for').' ' ?> <?php echo $Propostas->getLastPage() ?></i> </td>
        <td align="left">	
        	<table>
                	<tr>
                		<?php if ($Propostas->getFirstPage()!=$Propostas->getPage()) :?><!-- 
                                                    <td><?php echo link_to('<<', '@default?module=projeto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Propostas->getFirstPage().$bus_pagi.html_entity_decode($bus_ps).html_entity_decode($bus_q).  html_entity_decode($bus_tipo_reg)) ?></td>
                                                        <td><?php echo link_to('<','@default?module=projeto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Propostas->getPreviousPage().$bus_pagi.html_entity_decode($bus_ps).html_entity_decode($bus_q).html_entity_decode($bus_tipo_reg)) ?></td> -->
                            <td><?php echo link_to('<<', '@default?module=projeto&action=index&page='.$Propostas->getFirstPage().$bus_pagi.html_entity_decode($bus_ps).html_entity_decode($bus_q).  html_entity_decode($bus_tipo_reg)) ?></td>
                                <td><?php echo link_to('<','@default?module=projeto&action=index&page='.$Propostas->getPreviousPage().$bus_pagi.html_entity_decode($bus_ps).html_entity_decode($bus_q).html_entity_decode($bus_tipo_reg)) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $Propostas->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php //echo ($page == $Propostas->getPage()) ? '<a class="active" href="#" >'.$page.'</a>' : link_to($page, '@default?module=projeto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.html_entity_decode($bus_ps).html_entity_decode($bus_q)) ?>
                            <?php echo ($page == $Propostas->getPage()) ? '<a class="active" href="#" >'.$page.'</a>' : link_to($page, '@default?module=projeto&action=index&page='.$page.html_entity_decode($bus_ps).html_entity_decode($bus_q)) ?>
		                        <?php if ($page != $Propostas->getCurrentMaxLink()): ?>
		                        
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($Propostas->getLastPage()!=$Propostas->getPage()) :?>
                		<td><?php echo link_to('>', '@default?module=projeto&action=index&page='.$Propostas->getNextPage().$bus_pagi.html_entity_decode($bus_ps).html_entity_decode($bus_q).  html_entity_decode($bus_tipo_reg)) ?></td>
                		<td><?php echo link_to('>>', 'projeto/index?page='.$Propostas->getLastPage().$bus_pagi.html_entity_decode($bus_ps).html_entity_decode($bus_q).  html_entity_decode($bus_tipo_reg)) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>

<div class="results">
    <i><?php echo $nPro.' '.__('resultados') ?></i>
</div>
<?php endif; ?>


 

</div>