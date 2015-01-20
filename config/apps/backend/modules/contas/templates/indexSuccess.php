<?php use_javascript('jq/jQuery.print.js') ?>
<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>
<?php use_javascript('fancybox/jquery.fancybox.js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
        $("#from_date").datepicker({   
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',        
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
            }
        });    
        $("#to_date").datepicker({
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',          
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
                if(!$("#from_date").val())
                    {
                        $( "#from_date" ).val($("#to_date").val());
                    }
            }
        });
        $("#hrefPrint").click(function() {
            // Print the DIV.
            $('.no_for_print').hide();
            $('#chkTodos').hide();
            $('#datos-func').show();
            $("#printdiv").print();
            return (false);
        });
        $(".frameForm").mouseover(function(){
            $('.no_for_print').show();
            $('#chkTodos').show();
            $('#datos-func').hide();
        });
        
        $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false}); 
    });
</script>

<h1 class="icono_projeto"><?php echo __('Prestação de contas') ?></h1>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for('@default?module=projeto&action=analisisCritico') ?>"> Incluir Proposta</a>    
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready" style="position: relative; top: 0px;"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm" style="position: relative; top: 0px;">
    <div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="javascript:void();" onclick="noSelectedItem();" style="color: #FFF;">X</a> </div>
    <?php include_partial('global/menuProjeto') ?>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td>
                <form action="" method="POST">
                    <div class="propiedades propiedades-extend" style="width: 100%; border: 0px; height: 80px;">
                        <h2 class="titulo"><?php echo __('Filtros') ?></h2>
                        <table width="100%" >
                            <tr>
                                <td width="13%"><input type="text" placeholder="Palavra Chave" style="width: 100px;" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" /></td>
                                <td width="20%">
                                    <label style="color: #333; font-weight: bold;">
                                        
                                        Tipo de Despesa</label>
                                    <select name="status" id="status">
                                        <option value="1" <?php echo $sf_request->getParameter('status') == '1' ? 'selected="selected"' : ''  ?> >Pagas</option>
                                        <option value="0" <?php echo $sf_request->getParameter('status') == '0' ? 'selected="selected"' : ''  ?> >Pendentes</option>
                                        <option value="2" <?php echo $sf_request->getParameter('status') == '2' ? 'selected="selected"' : ''  ?> >Processados</option>
                                    </select>
                                </td>
                                <td style="width: 20%;">
                                    <label style="color: #333; font-weight: bold;"> <?php echo __('De') ?></label>
                                    <input size="8" type="text" name="from_date" id="from_date" value="<?php echo $from ?>" >
                                    &nbsp;&nbsp;
                                    <label style="color: #333; font-weight: bold;"> <?php echo __('Até') ?></label>
                                    <input size="8" type="text" name="to_date" id="to_date" value="<?php echo $to ?>" >
                                </td>
                                <td align="left">
                                    <input type="submit" name="buscar" id="buscar" value="Buscar" />
                                    <a href="<?php echo url_for('contas/index') ?> "><?php echo __('Veja todo') ?></a>
                                </td>
                                
                                <?php if($sf_request->getParameter('status') == 2): ?>
                                <td style="text-align: right; width: 20%">
                                    <a href="#" class="print" id="hrefPrint" rel="content-area-print">Imprimir <?php echo image_tag('icons/print','width="30" style="position: relative; top: 9px;"') ?></a>
                                </td>
                                <?php endif; ?>
                            </tr>            
                        </table>
                    </div>
                </form>
            </td>
            
        </tr>
    </table>
    <br />
    <div id="printdiv" class="printable">
    
        <form id="frm-process" name="frm-process" action="<?php echo url_for('@default?module=contas&action=marcaConta') ?>" method="POST">
        <table cellpadding="0" cellspacing="0" border="0"  id="resultsList" style="width: 100%; border: 1px solid #DDD; border-bottom: 0px solid;">
            <caption id="datos-func" style="display: none;">
                PRESTAÇÃO DE CONTAS<br />
                FUNCIONARIO: <span style="text-transform: uppercase;"><?php echo aplication_system::getNameUser() ?></span>
                <br />
            </caption>
            <thead>
                <th style="background-color: #5092bd; border-bottom: 1px #DDD solid;">&nbsp;<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;</th>
                <th style="width: 6%; border-bottom: 1px #DDD solid; font-size: 11px; background-color: #5092bd; color: #FFF;">Data Real</th>
                <th style="width: 6%; border-bottom: 1px #DDD solid; font-size: 11px; background-color: #5092bd; color: #FFF;">Projeto</th>
                <th style="width: 15%; border-bottom: 1px #DDD solid; font-size: 11px; background-color: #5092bd; color: #FFF;">Descrição</th>
                <th style="font-size: 11px; border-bottom: 1px #DDD solid; background-color: #5092bd; color: #FFF;">Fornecedor / Cliente</th>
                <th style="font-size: 11px; border-bottom: 1px #DDD solid; background-color: #5092bd; color: #FFF;">Pagamento</th>
                <th style="font-size: 11px; border-bottom: 1px #DDD solid; background-color: #5092bd; color: #FFF;">Entrada</th>
                <th style="font-size: 11px; border-bottom: 1px #DDD solid; background-color: #5092bd; color: #FFF;">Saídas</th>
                <th style="font-size: 11px; border-bottom: 1px #DDD solid; background-color: #5092bd; color: #FFF;">Saldo</th>
                <th class="no_for_print" style="border-bottom: 1px #DDD solid;">GP</th>
                <th class="no_for_print" style="border-bottom: 1px #DDD solid;">ADM</th>
                <th class="no_for_print" style="border-bottom: 1px #DDD solid;" >&nbsp;</th>
            </thead>
            <tbody>
                <?php if(count($result)): ?>
                    <?php $total = 0; ?>
                    <?php $totalGral = 0; ?>
                    <?php $totalEntrada = 0; ?>
                    <?php $procesaSeleccionados = false; ?>
                    <?php $totalSalida = 0; ?>
                    <?php foreach ($result as $valor): ?>
                    <?php $monto = $valor->getSaidas() ?>
                    <?php $total = $valor->getOperacao() == 'e' ? $total + $monto : $total - $monto ?>
                    <?php $totalGral = $total + $monto  ?>
                    <tr>
                        <td style="font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; ">&nbsp;
                            <?php if($valor->getBaixa() && !$valor->getConfirmacao() && aplication_system::compareUserVsResponsable($valor->getCodigofuncionario())): ?>
                            <?php $procesaSeleccionados = true; ?>
                            <input type="checkbox" id="chk_<?php echo $valor->getCodigoSaida() ?>" name="chk[<?php echo $valor->getCodigoSaida() ?>]" value="<?php echo $valor->getCodigoSaida() ?>">
                            <?php endif; ?>
                        </td>
                        <td style="font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; "><?php echo date('d/m/Y', strtotime($valor->getDatareal())) ?></td>
                        <td style="font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; ">
                            <?php $projeto = PropostaPeer::getDataByCodProjeto($valor->getCodigoprojeto()) ?>
                            <?php echo $projeto ? $projeto->getCodigoSgwsProjeto() : '' ?>
                        </td>
                        <td style="width: 250px; font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; ">
                            <!-- Descripcion -->
                            <?php $func =  lynxValida::datosTipoUsuario($valor->getCodigofuncionario() ? $valor->getCodigofuncionario() : $valor->getConfirmadopor(), 2) ?>
                            (<?php echo $valor->getCentro() ?>) - <?php echo $func['nome'] ?> - <?php echo html_entity_decode($valor->getDescricaosaida()) ?>

                        </td>
                        <td style="font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; ">
                            <?php $fornecedor =  lynxValida::datosTipoUsuario($valor->getCodigocadastro(), 3) ?>
                            <?php if($fornecedor): ?>
                            <span style="font-weight: bold;"><?php echo $fornecedor['nome'] ?></span> <br >
                            <?php endif; ?>
                            <?php $tipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoTipo()) ?>
                            <?php echo $tipo ? $tipo->getSubtipo() : '' ?>  
                            <?php $subtipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoSubtipo()) ?>
                            <?php echo $subtipo ? ' - '.$subtipo->getSubtipo() : '' ?>
                        </td>
                        <td style="font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; ">
                             <?php echo ucfirst($valor->getFormapagamento())  ?>
                        </td>
                        <td style="font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; ">
                            <?php echo $valor->getOperacao() == 'e' ? 'R$ '.aplication_system::monedaFormat($monto,2,",",".")  : '' ?>&nbsp;
                            <?php $valor->getOperacao() == 'e' ? $totalEntrada = $totalEntrada + $monto : '' ?>
                        </td>
                        <td style="font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; ">
                            <?php echo $valor->getOperacao() == 's' ? 'R$ '.aplication_system::monedaFormat($monto,2,",",".")  : '' ?>&nbsp;
                            <?php $valor->getOperacao() == 's' ? $totalSalida = $totalSalida + $monto : '' ?>
                        </td>
                        <td style="font-size: 12px; vertical-align: top; border-bottom: 1px #DDD solid; border-right: 1px #DDD solid; ">R$ <?php echo aplication_system::monedaFormat($total,2,",",".");?></td>
                        <td id="status_<?php echo $valor->getCodigoSaida() ?>" class="no_for_print" >
                            <?php if(aplication_system::esGerente() && !$valor->getConfirmacao()): ?>
                                <?php echo jq_link_to_remote(image_tag($valor->getBaixa().'.png','alt="" title="" border=0'), array(
                                    'update'  =>  'status_'.$valor->getCodigoSaida(),
                                    'url'     =>  'despesa/darBaixa?id='.$valor->getCodigoSaida().'&baixa='.$valor->getBaixa(),
                                    'script'  => true,
                                    'before'  => "$('#status_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"
                                ));
                                ?>
                            <?php else: ?>
                                <?php echo image_tag($valor->getBaixa().'.png','alt="" title="" border=0') ?>
                            <?php endif; ?>
                        </td>
                        <td id="confirma_<?php echo $valor->getCodigoSaida() ?>" class="no_for_print" >
                            
                            <?php if(aplication_system::esContable()): ?>
                                <?php echo jq_link_to_remote(image_tag($valor->getConfirmacao().'.png','alt="" title="" border=0'), array(
                                    'update'  =>  'confirma_'.$valor->getCodigoSaida(),
                                    'url'     =>  'despesa/confirmacion?id='.$valor->getCodigoSaida().'&confirma='.$valor->getConfirmacao(),
                                    'script'  => true,
                                    'before'  => "$('#confirma_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');
                                        $('#status_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');
                                            "
                                ));
                                ?>
                            <?php else: ?>
                                <?php echo image_tag($valor->getConfirmacao().'.png','alt="" title="" border=0') ?>
                            <?php endif; ?>
                        </td>
                        <td class="no_for_print" >
                            <?php if(aplication_system::esContable()  || (!$valor->getBaixa() &&  aplication_system::compareUserVsResponsable($valor->getCodigofuncionario()))): ?>
                                <?php if(aplication_system::esContable()): ?>
                                    <a href="<?php echo url_for('@default?module=despesa&action=editFinanciero&id='.$valor->getCodigoSaida().'&ref=contas') ?>">
                                        <?php echo image_tag('icons/informacoe','width=20') ?>
                                    </a>
                                <?php else: ?>
                                    <?php if(!$valor->getBaixa() && !$valor->getConfirmacao()): ?>
                                    <a href="<?php echo url_for('@default?module=despesa&action=edit&id='.$valor->getCodigoSaida()) ?>">
                                        <?php echo image_tag('icons/informacoe','width=20') ?>
                                    </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="font-size: 13px;font-weight: bold;">
                        <td colspan="6">&nbsp;</td>
                        <td>R$ <?php echo aplication_system::monedaFormat($totalEntrada) ?></td>
                        <td>R$ <?php echo aplication_system::monedaFormat($totalSalida) ?></td>
                        <td colspan="3">&nbsp;</td>
                        
                    </tr>
                    <tr style="font-size: 13px;font-weight: bold;">
                        <td colspan="11" style="text-align: right; padding-right: 48px;">
                            Total Global: R$ <?php echo aplication_system::monedaFormat($total_global)  ?>
                        </td>
                        
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="12"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <?php if( count($result)): ?>
                <tfoot class="no_for_print">
                    <tr>
                        <td colspan="12" class="center">
                            <?php if($procesaSeleccionados): ?>
                            <br />
                            <a style="margin: 10px; background-color: #5092bd; color: #FFF; padding: 10px; " name="commit" href="#" onclick="return existItemsPrint(this);">Procesar Selecionados</a>
                            <br /><br />
                            <?php endif; ?>
                        </td>
                    </tr>
                </tfoot>
            <?php endif; ?>
        </table>
        </form>
    </div>
</div>