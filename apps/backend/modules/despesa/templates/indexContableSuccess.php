<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>

<?php use_javascript('fancybox/jquery.fancybox.js') ?>

<?php use_javascript('jq/jQuery.print.js') ?>



<script type="text/javascript">

    $(document).ready(function() {

        

        $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false});

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

        

        $('.compensacion').hide();

        $('.compensacion_all').hide();

        $('.footer-list').hide();

        $('#prestacao_contas').click(function() {

            $("#filtro-contable").submit();

        });

        $('#compensar').click(function() {

            if ($(this).is(':checked')) {

                //return confirm("Are you sure?");

                if($("#funcionario").val())

                    {

                        $('.compensacion').show();

                        $('.compensacion_all').show();

                        $('.footer-list').show();

                        $('.msn_info').show();

                        $('.msn_error').hide();

                        $('.adiantamento').hide();

                        $('.no_compensa').hide();

                        $('#totales_ppales').hide();

                    }else{

                        $('.adiantamento').show();

                        $('.msn_error').show();

                        $('#totales_ppales').show();

                        $(this).attr('checked', false);

                    }

                

            }else{

                $('.adiantamento').show();

                // $('.compensacion').hide();

                // $('.compensacion_all').hide();

                $('.footer-list').hide();

                $('.msn_info').hide();

                $('#totales_ppales').show();

                

            }

        });

        $(".chk_saida").click(function() {

            calculoTotalCompensacion();

        });

        $("#funcionario").change(function() {

            if($(this).val())

            {

                $('.msn_error').hide();

            }

            

        });

         $("#hrefPrint").click(function() {

            // Print the DIV.

            $(".no_print").hide();

            $("#printdiv").print();

            return (false);

        });

        $(".frameForm").mouseover(function(){

            $('.no_print').show();

            

            $('#datos-func').hide();

        });

//        calculoTotalOperacao('entrada');

//        calculoTotalOperacao('saida');

    });

     

    

    

</script>

<style type="text/css">

    @import url("/css/main.css");

</style>

<h1 class="icono_projeto"><?php echo __('Contabilidade') ?></h1>

<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/newFinanciero') ?>">Inclusão de Entradas/Saídas</a>



<?php if ($sf_user->hasFlash('listo')): ?>

    <div class="msn_ready" ><?php echo $sf_user->getFlash('listo') ?></div>

<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>

    <div class="msn_error" ><?php echo $sf_user->getFlash('error') ?></div>

<?php endif; ?>

    


</style>

    <table cellpadding="0" cellspacing="0" border="0" width="100%">

        <tr>

            <td>

                <form action="" method="POST" id="filtro-contable">

                    <div class="propiedades propiedades-extend" style="width: 100%; border: 0px; height: 80px;">

                        <h2 class="titulo"><?php echo __('Filtros') ?></h2>

                        <table width="100%" >

                            <tr>

                                <td width="13%"><input type="text" placeholder="Palavra Chave" style="width: 100px;" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" /></td>

                                <td width="12%">

                                    <label style="color: #333; font-weight: bold;">Tipo</label>

                                    <select name="status" id="status">

                                        <option value="1" <?php echo $sf_request->getParameter('status') == 1 ? 'selected="selected"' : ''  ?> >Aprovadas</option>

                                        <option value="0" <?php echo $sf_request->getParameter('status') == 0 ? 'selected="selected"' : ''  ?> >Pendentes</option>

                                    </select>

                                </td>

                                <td style="width: 21%;">

                                    <label style="color: #333; font-weight: bold;"> <?php echo __('De') ?></label>

                                    <input size="8" type="text" name="from_date" id="from_date" value="<?php echo $from ?>" >

                                    &nbsp;&nbsp;

                                    <label style="color: #333; font-weight: bold;"> <?php echo __('Até') ?></label>

                                    <input size="8" type="text" name="to_date" id="to_date" value="<?php echo $to ?>" >

                                </td>

                                <td style="width: 18%;">

                                    <label style="color: #333; font-weight: bold; position: relative; top: -10px;">Funcionarios</label>

                                    <select name="funcionario" id="funcionario" style="position: relative; top: -10px;">

                                        <option value="">Selecione</option>

                                        <?php foreach ($funcionarios as $fun): ?>

                                        <option value="<?php echo $fun['id'] ?>" <?php echo $fun['id'] == $sf_request->getParameter('funcionario') ? 'selected="selected"' : '' ?> ><?php echo $fun['nome'] ?></option>

                                        <?php endforeach; ?>

                                    </select>

                                </td>

                                <td align="left" style="width: 13%;">

                                    <input type="submit" name="buscar" id="buscar" value="Buscar" />

                                    <a href="<?php echo url_for('despesa/index') ?> "><?php echo __('Veja todo') ?></a>

                                </td>

                                

                                <td style="text-align: right; padding-right: 15px; clear:both;">
                                    <div style="float:right; display:block;">
                                        <label style="color: #333; font-weight: bold;">Prestação de Contas / Compensação</label>
                                        <input type="checkbox" name="compensar" id="compensar" value="99" onClick="" >
                                    </div>
                                    <div style="float:right; display:block;">
                                        <label style="color: #333; font-weight: bold;">Contas Prestadas</label>
                                        <input type="checkbox" name="prestacao_contas" id="prestacao_contas" value="98" <?php echo $sf_request->getParameter('prestacao_contas') ? 'checked="checked"' : ''  ?>  >
                                    </div>
                                </td>

                            </tr>            

                        </table>

                    </div>

                </form>

            </td>

        </tr>

    </table>

    <br />

    <div class="msn_info hide" >Selecione as saídas do funcionario, para fazer Compensação </div>

    <div class="msn_error hide" >Selecione Funcionario para fazer Compensação </div>

    <div id="printdiv" class="printable">

    <form action="<?php echo url_for('@default?module=despesa&action=compensar') ?>" method="POST">

    <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">

        <thead>

            <tr>

            <tr>

            <th style="width: 6%; padding-left: 4px;">Data Real</th>

            <th style="width: 5%;">Projeto</th>

            <th style="width: 21%;">Descrição</th>

            <th style="width: 22%;">Fornecedor / Cliente</th>

<!--            <th style="width: 7%;">Frequencia</th>-->

            <th style="width: 9%;">Pagamento</th>

            <th style="width: 9%;">Entrada</th>

            <th style="width: 9%;">Saídas</th>

            <th style="width: 9%;">Saldo</th>

            <th class="no_print" style="width: 2%;">GP</th>

            <th class="no_print" style="width: 2%;">ADM</th>

            <th style="background-color: #5092bd; padding-left: 0px; width: 3%;">&nbsp;<input class="compensacion_all" type="checkbox" id="chkTodos" value="checkbox" onclick="checkTodos(this); calculoTotalCompensacion();" style="display: none;">&nbsp;</th>

            <th style="width: 3%; padding-right: 20px;">&nbsp;</th>

        </tr>

        </thead>

        <tbody>

            <?php if(count($result)): ?>

                <?php $total = 0; ?>

                <?php $totalEntrada = 0; ?>

                <?php $totalSaida = 0; ?>

                <?php $totalGral = 0; ?>

                <?php $statusPedido = 0; ?>

                <?php foreach ($result as $valor): ?>
                <?php $valor ?>
                <?php $classFila = 'no_compensa' ?>

                <?php $clsAdiantamento = '' ?>

                <?php $clsCompensacao = '' ?>

                <?php $monto = $valor->getSaidas() ?>

                <?php $total = $valor->getOperacao() == 'e' && $valor->getCentro() != 'adiantamento' ? $total + $monto : $total - $monto ?>

                <?php $totalGral = $total + $monto  ?>

                <?php if($valor->getIdPedido()): ?>

                    <?php $iPedido = PedidosPeer::retrieveByPK($valor->getIdPedido()); ?>

                    <?php $statusPedido = PedidosPeer::getStatusPedido($valor->getIdPedido()); ?>

                <?php endif; ?>

                <?php if($valor->getOperacao() == 's' && !$valor->getConfirmacao() && ($valor->getCodigocadastro() != 1729 && $valor->getCodigocadastro() != 1730)): ?>

                    <?php $classFila = 'for_compensa' ?>

                <?php endif; ?>

                <?php if($valor->getCentro() == 'adiantamento'): ?>

                    <?php $clsAdiantamento = 'adiantamento' ?>

                <?php endif; ?>

                <?php if($valor->getCentro() == 'compensação'): ?>

                    <?php $clsCompensacao = 'iscompensacao' ?>

                <?php endif; ?>
                <tr class="<?php echo $classFila.' '.$clsAdiantamento.' '.$clsCompensacao ?>">

                    

                    <td style="padding-left: 4px;"><?php echo date('d/m/Y', strtotime($valor->getDatareal())) ?></td>

                    <td>

                        <?php $projeto = PropostaPeer::getDataByCodProjeto($valor->getCodigoprojeto()) ?>

                        <?php echo $projeto ? $projeto->getCodigoSgwsProjeto() : '' ?>

                    </td>

                    <td style="width: 250px;">

                        <!-- Descripcion -->
                        <?php $func = LxUserPeer::getCurrentPassword($valor->getCodigofuncionario() ? $valor->getCodigofuncionario() : $valor->getConfirmadopor()) ?>

                        <?php if($valor->getCentro() == 'compensação'): ?>

                            <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=despesa&action=verAsocCompensacion&id='.$valor->getCodigoSaida()) ?>">

                                (<?php echo $valor->getCentro() ?>)

                            </a>

                        <?php else: ?>

                            (<?php echo $valor->getCentro() ?>)

                        <?php endif; ?>

                        

                         - <?php echo $func->getName() ?> -<br />

                        <?php if($valor->getIdPedido()): ?>

                            Compra em Almoxarifado #<?php echo $iPedido->getNumeroPedido() ?> <br />

                            <span style="color: #CC0000;">(<?php echo $status[$statusPedido] ?>)</span>

                            <br />

                        <?php endif; ?>

                        <?php echo html_entity_decode($valor->getDescricaosaida()) ?>                        

                    </td>

                    <td>

                        <?php $fornecedor =  lynxValida::datosTipoUsuario($valor->getCodigocadastro(), 3) ?>

                        <?php if($fornecedor): ?>

                        <span style="font-weight: bold;"><?php echo $fornecedor['nome'] ?></span> <br >

                        <?php endif; ?>

                        <?php $tipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoTipo()) ?>

                        <?php echo $tipo ? $tipo->getSubtipo() : '' ?>   

                        <?php $subtipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoSubtipo()) ?>

                        <?php echo $subtipo ? ' - '.$subtipo->getSubtipo() : '' ?>

                    </td>

<!--                    <td><?php // echo $frecuencia[$valor->getTipo()] ?></td>-->

                    <td><?php echo ucfirst($valor->getFormapagamento())  ?></td>

                    <td>

                        <?php if($valor->getCentro() != 'adiantamento'): ?>

                            <?php if($valor->getOperacao() == 'e'): ?>

                                R$ <?php echo aplication_system::monedaFormat($monto,2,",",".") ?>

                                <span class="entrada hide"><?php echo $monto ?></span>

                                <?php $totalEntrada = $totalEntrada + $valor->getSaidas(); ?>

                            <?php endif; ?>

                        <?php endif; ?>

                        

                    </td>

                    <td>

                        <?php if($valor->getOperacao() == 's' && $valor->getCentro() != 'adiantamento'): ?>

                                R$ <?php echo aplication_system::monedaFormat($monto,2,",",".") ?>

                                <span class="saida hide"><?php echo $monto ?></span>

                                <?php $totalSaida = $totalSaida + $valor->getSaidas(); ?>

                        <?php endif; ?>

                        <?php if($valor->getCentro() == 'adiantamento'): ?>

                            <?php echo 'R$ '.aplication_system::monedaFormat($monto,2,",",".")  ?>&nbsp;

                            <span class="saida hide"><?php echo $monto ?></span>

                            <?php $totalSaida = $totalSaida + $valor->getSaidas(); ?>

                        <?php endif; ?>

                        

                    </td>

                    <td>

                        R$ <?php echo aplication_system::monedaFormat($total,2,",",".");?>

                        <?php $ultimoSaldoTotal = $total; ?>

                    </td>

                    <td class="no_print" id="status_<?php echo $valor->getCodigoSaida() ?>" >

                        <?php $dBaixa = $valor->getBaixa() ? $valor->getBaixa() : '0' ?>

                        <?php if(((aplication_system::esGerente()) && ($projeto ? aplication_system::compareUserVsResponsable($projeto->getGerente()) : 1)) || aplication_system::esSocio()): ?>

                            <?php echo jq_link_to_remote(image_tag($dBaixa.'.png','alt="" title="" border=0'), array(

                                'update'  =>  'status_'.$valor->getCodigoSaida(),

                                'url'     =>  'despesa/darBaixa?id='.$valor->getCodigoSaida().'&baixa='.$dBaixa,

                                'script'  => true,

                                'before'  => "$('#status_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"

                            ),array('class' => 'opcoe_adm'));

                            ?>

                        <?php else: ?>

                            <?php echo image_tag($dBaixa.'.png','alt="" title="" border=0') ?>

                        <?php endif; ?>

                    </td>

                    <td class="no_print" id="confirmado_<?php echo $valor->getCodigoSaida() ?>" >

                        <?php $dConfirmacao = $valor->getConfirmacao() ? $valor->getConfirmacao() : '0' ?>

                        <?php if(aplication_system::esContable() || aplication_system::esSocio()): ?>

                            <?php if($statusPedido == 4 || $statusPedido == 0): ?>

                                <?php echo jq_link_to_remote(image_tag($dConfirmacao.'.png','alt="" title="" border=0'), array(

                                    'update'  =>  'confirmado_'.$valor->getCodigoSaida(),

                                    'url'     =>  'despesa/confirmacion?id='.$valor->getCodigoSaida().'&confirmado='.$dConfirmacao,

                                    'script'  => true,

                                    'before'  => "$('#confirmado_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"

                                ),array('class' => 'opcoe_adm'));

                                ?>

                            <?php endif; ?>

                        <?php else: ?>

                            <?php echo image_tag($dConfirmacao.'.png','alt="" title="" border=0') ?>

                        <?php endif; ?>

                    </td>

                    <td style="padding-left: 3px;" class="no_print">

                        <input class="compensacion chk_saida" type="checkbox" saldo = "<?php echo $monto ?>"  id="chk_saida" name="chk[<?php echo $valor->getCodigoSaida() ?>]" value="<?php echo $valor->getCodigoSaida() ?>">

                    </td>

                    <td class="no_print">                        

                        <!-- <a href="<?php echo url_for('@default?module=despesa&action=editFinanciero&id='.$valor->getCodigoSaida()) ?>"> -->
                        <a href="<?php echo url_for('@default?module=despesa&action=editFinanciero&id='.$valor->getCodigoSaida().'&id_projeto='.$valor->getCodigoProjeto()) ?>">

                            <?php echo image_tag('icons/informacoe','width=20') ?>

                        </a>

                    </td>

                </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="12"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>

                </tr>

            <?php endif; ?>

        </tbody>

        <tfoot>

            <tr id="totales_ppales">

                <td colspan="5" class="right">&nbsp;</td>

                <td class="sum-entrada sum">R$ <?php echo aplication_system::monedaFormat($totalEntrada) ?></td>

                <td class="sum-saida sum">R$ <?php echo aplication_system::monedaFormat($totalSaida) ?></td>

                <td class="sum">R$ <?php echo aplication_system::monedaFormat($ultimoSaldoTotal) ?></td>

                <td colspan="4">

                    &nbsp;

                </td>

            </tr>

            <?php if($sf_request->getParameter('prestacao_contas')): ?>

            <tr class="hide">

                <td colspan="7" class="right">&nbsp;</td>

                <td>R$ <?php echo  $totalEntrada -  $totalSaida ?></td>

                <td colspan="6">

                    &nbsp;

                </td>

            </tr>

            <?php endif; ?>

            <tr class="footer-list">

                <td colspan="8" class="right">Total a Compensar:&nbsp;</td>

                <td colspan="6">R$ <span id="total-compensacion"></span></td>

                

                    

                    

                

            </tr>

            <tr class="footer-list">

                <td colspan="14" style="text-align: right;">

                    <input type="hidden" name="cod_funcionario" value="<?php echo $sf_request->getParameter('funcionario') ?>" />

                    <input type="submit" value="Fazer Compensação" />

                </td>

            </tr>

            

        </tfoot>

    </table>

    </form>

    </div>

    <div class="space-print">

        <a href="#" id="hrefPrint" rel="content-area-print">Imprimir <?php echo image_tag('icons/print','width="30" style="position: relative; top: 9px;"') ?></a>

    </div>

</div>