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
                        $('.no_compensa').hide();
                    }else{
                        $('.no_compensa').show();
                        $('.msn_error').show();
                        $(this).attr('checked', false);
                    }
            }else{
                $('.no_compensa').show();
                $('.compensacion').hide();
                $('.compensacion_all').hide();
                $('.footer-list').hide();
                $('.msn_info').hide();
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

    });
     
    
    
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
<style type="text/css">
    @import url("/css/main.css");
</style>


<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready" ><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<?php if ($sf_user->hasFlash('error')): ?>
    <div class="msn_error" ><?php echo $sf_user->getFlash('error') ?></div>
<?php endif; ?>
    <h1 class="tit-principal">Faturamentos</h1>
    <br><br>
    <?php $projeto = PropostaPeer::getDataByCodProjeto($id); ?>
    <?php if($sf_user->getAttribute('nomeProfile') == 'Socio' || $sf_user->getAttribute('nomeProfile') == 'Administrador' || $sf_user->getAttribute('nomeProfile') == 'Root' || $projeto->getGerente() == aplication_system::getUser()): ?>     
        <!-- <input type="submit" value="Salvar" /> -->
        <a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/newFinancieroEntrada?id_projeto='.$id.'') ?>">Inclusão de Entradas</a>
    <?php endif; ?>
<div class="frameForm">
    
    <div id="printdiv" class="printable">
    <form action="<?php echo url_for('@default?module=despesa&action=compensar') ?>" method="POST">
    <table cellpadding="0" cellspacing="0" border="0"  id="resultsList" width="100%">
        <thead>
            <tr>
            <tr>
                <th style="background-color: #5092bd; width: 1%;">&nbsp;</th>
                <th style="width: 8%;">Data Prevista</th>
                <th style="width: 10%;">Data Faturamento</th>
                <th style="width: 7%;">Projeto</th>
                <th style="width: 40%;">Descrição</th>
                <th style="width: 17%;">Cliente</th>

                <th style="width: 12%;">Entrada</th>

                <th style="width: 3%;">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($result)): ?>
                <?php $totalEntrada = 0; ?>
                <?php $statusPedido = 0; ?>
                <?php foreach ($result as $valor): ?>
                <?php $monto = $valor->getSaidaprevista() ?>
                <?php $total = $total + $monto ?>
                <?php if($valor->getIdPedido()): ?>
                    <?php $iPedido = PedidosPeer::retrieveByPK($valor->getIdPedido()); ?>
                    <?php $statusPedido = PedidosPeer::getStatusPedido($valor->getIdPedido()); ?>
                <?php endif; ?>
                <?php if($valor->getOperacao() == 's' && !$valor->getConfirmacao()): ?>
                    <?php $classFila = 'for_compensa' ?>
                <?php endif; ?>
                <?php if($valor->getCentro() == 'adiantamento'): ?>
                    <?php $clsAdiantamento = 'adiantamento' ?>
                <?php endif; ?>
                <?php if($valor->getCentro() == 'compensação'): ?>
                    <?php $clsCompensacao = 'iscompensacao' ?>
                <?php endif; ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo date('d/m/Y', strtotime($valor->getDataprevista())) ?></td>
                    <td><?php echo $valor->getDataemissao() ? date('d/m/Y', strtotime($valor->getDataemissao())) : '' ?></td>
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
                        <?php if($func): ?>
                         - <?php echo $func->getName() ?> -<br />
                         <?php endif; ?>
                        <?php if($valor->getIdPedido()): ?>
                            Compra em Almoxarifado #<?php echo $iPedido->getNumeroPedido() ?> <br />
                            <span style="color: #CC0000;">(<?php echo $status[$statusPedido] ?>)</span>
                            <br />
                        <?php endif; ?>
                        <?php echo html_entity_decode($valor->getDescricaosaida()) ?>                        
                    </td>
                    <td attr="cliente">
                        <?php $Proposta = PropostaPeer::retrieveByPK($projeto->getCodigoProjeto()) ?>
                        <?php $cliente = CadastroJuridicaPeer::getNameJuridico($Proposta->getCliente()); ?>
                        <?php if($cliente): ?>
                            <?php echo $cliente['nome'] ?>
                        <?php endif; ?>
                        <?php $tipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoTipo()) ?>
                        <?php echo $tipo ? $tipo->getSubtipo() : '' ?>   
                        <?php $subtipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoSubtipo()) ?>
                        <?php echo $subtipo ? ' - '.$subtipo->getSubtipo() : '' ?>
                    </td>
                    <td>
                        R$ <?php echo aplication_system::monedaFormat($monto,2,",",".") ?>
                        <span class="entrada hide"><?php echo $monto ?></span>
                    </td>
       
                    <td class="no_print">                        
                        <a href="<?php echo url_for('@default?module=despesa&action=editFinancieroEntrada&id='.$valor->getCodigoSaida().'&id_projeto='.$projeto->getCodigoProjeto()) ?>">
                            <?php echo image_tag('icons/informacoe','width=20') ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="right">&nbsp;</td>
                <td class="sum-entrada sum">TOTAL </td>
                <td class="sum-saida sum">R$ <?php echo aplication_system::monedaFormat($total) ?></td>
                <td class="sum">&nbsp;</td>
            </tr>
            
        </tfoot>
    </table>
    </form>
    </div>
    <div class="space-print">
        <a href="#" id="hrefPrint" rel="content-area-print">Imprimir <?php echo image_tag('icons/print','width="30" style="position: relative; top: 9px;"') ?></a>
    </div>
</div>