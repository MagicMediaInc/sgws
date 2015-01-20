<h1 class="icono_projeto">Consolidado do Projeto <?php echo $data->getCodigoSgwsProjeto() ?></h1>

<br />

<style>

    th{

        padding-left: 4px !important;

    }

</style>

<script type="text/javascript"> 

    console.log('script');

    $(document).ready(function() {

        console.log("ready");

        <?php if($Analisis->getResponsableTecnico() == aplication_system::getUser()): ?>

            $("#proposta_nao_conformidade").attr('readonly',true);

        <?php else: ?>

           $("#proposta_nao_conformidade").attr('readonly',false);

        <?php endif; ?>

    })

</script>

<table style="width: 70%; float: left; border-bottom: 1px solid #DDD;" id="resultsList">

    <thead>

    <tr>

        <th>Valor Venda</th>

        <th>Faturado</th>

        <th>Saldo (a Faturar)</th>

        <th colspan="3"></th>

        

    </tr>

    <tr>

        <td>R$ <?php echo aplication_system::monedaFormat($data->getValor()) ?></td>

        <td>

            <?php $valorFaturado = SaidasPeer::getValorFaturadoProjeto($data->getCodigoProposta())  ?>

            R$ <?php echo aplication_system::monedaFormat($valorFaturado)  ?>

        </td>

        <td>R$ <?php echo aplication_system::monedaFormat($data->getValor() - $valorFaturado) ?></td>

        <td></td>

        <td></td>

        <td></td>

        <td></td>

        <td></td>

    </tr>

    <tr>

        <td colspan="8">&nbsp;</td>

    </tr>

    <tr>

        <th>Previsto HH</th>

        <th>Real HH</th>

        <th>Saldo HH</th>

        <th>Previsto HH</th>

        <th>Real HH</th>

        <th>Saldo HH</th>

        

    </tr>

    <tr>

        <td><?php echo $data->getHorasVendidas() ?> HH</td>

        <td><?php echo $data->getHorasTrabajadas() ?> HH</td>

        <td><?php echo $data->getHorasVendidas() - $data->getHorasTrabajadas() ?> HH</td>

        <td>R$ <?php echo aplication_system::monedaFormat($data->getValorPrevHh()) ?></td>

        <td>

            <?php $realHH = TempotarefaPeer::getHorasBillabilityProjeto($data->getCodigoProposta()) ?>

            <?php echo aplication_system::monedaFormat($realHH) ?>

        </td>

        <td>

            <?php $saldoHH = $data->getValorPrevHh() - $realHH ?>

            <?php echo aplication_system::monedaFormat($saldoHH) ?>

        </td>

        <td></td>

        <td></td>

    </tr>

    <tr>

        <th colspan="3"></th>

        <th>Previsto Desp</th>

        <th>Real Desp</th>

        <th>Saldo Desp</th>

    </tr>

    <tr>

        <td></td>

        <td></td>

        <td></td>

        <td>

            <?php $prevDespesa = ProjetoSubtipoGastoPeer::getPrevistoDespesa($data->getCodigoProposta()) ?>

            R$ <?php echo aplication_system::monedaFormat($prevDespesa)  ?>

        </td>

        <td>

            <?php $realDespesa = SaidasPeer::getSumaDespesasRealesProjeto($data->getCodigoProposta())  ?>

            R$ <?php echo aplication_system::monedaFormat($realDespesa)  ?>

        </td>

        <td>

            <?php $saldoDespesa = $prevDespesa - $realDespesa  ?>

            R$ <?php echo aplication_system::monedaFormat($saldoDespesa)  ?>

        </td>

    </tr>

    </thead>

</table>



<table style="width: 15%; margin-left: 10px; float: left; border-bottom: 1px solid #DDD;" id="resultsList" >

    <thead>

        <tr>

            <th>Satisfação do Cliente</th>

        </tr>

        <tr>

            <td><?php echo $data->getSatisfacaoCliente() ? $data->getSatisfacaoCliente() : 0 ?></td>

        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr>

            <th>APR (saúde e segurança)</th>

        </tr>

        <tr>

            <td><?php echo $data->getApr() ? $data->getApr() : 0 ?></td>

        </tr>

        

        <tr>

            <th>Não Conformidades</th>

        </tr>

        <tr>

            <td><?php echo $data->getNaoConformidade() ?>&nbsp;</td>

        </tr>

    </thead>

</table>





<div style="margin: auto; width: 100%; height: 225px;"></div>

<h2 class="titulo">Despesas</h2>

<table style="width: 86%; position: relative; top: 15px;  " id="resultsList" >

    <thead>

        <th>Data Real</th>

        <th>Responsável</th>

        <th>Fornecedor / Cliente</th>

        <th>Pagamento</th>

        <th>Valor</th>

        <th>GP</th>

        <th>ADM</th>

    </thead>

    <tbody>

            <?php if(count($despesa)): ?>

                <?php $total = 0; ?>

                <?php $totalEntrada = 0; ?>

                <?php $totalSaida = 0; ?>

                <?php $totalGral = 0; ?>

                <?php $statusPedido = 0; ?>

                <?php foreach ($despesa as $valor): ?>

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

                <?php if($valor->getOperacao() == 's' && !$valor->getConfirmacao()): ?>

                    <?php $classFila = 'for_compensa' ?>

                <?php endif; ?>

                <?php if($valor->getCentro() == 'adiantamento'): ?>

                    <?php $clsAdiantamento = 'adiantamento' ?>

                <?php endif; ?>

                <?php if($valor->getCentro() == 'compensação'): ?>

                    <?php $clsCompensacao = 'iscompensacao' ?>

                <?php endif; ?>

                <tr class="<?php echo $classFila.' '.$clsAdiantamento.' '.$clsCompensacao ?>">

                    

                    <td><?php echo date('d/m/Y', strtotime($valor->getDatareal())) ?></td>

                    <td>

                        <?php $respo = LxUserPeer::getCurrentPassword($valor->getCodigofuncionario()) ?>

                        <?php echo $respo ? $respo->getName() : '' ?>

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

                    <td><?php echo ucfirst($valor->getFormapagamento())  ?></td>

                    <td>

                        R$ <?php echo aplication_system::monedaFormat($valor->getSaidas(),2,",",".");?>

                        <?php $ultimoSaldoTotal = $total; ?>

                    </td>

                    

                    <td class="no_print" id="status_<?php echo $valor->getCodigoSaida() ?>" >

                        <?php if((aplication_system::esGerente() && $projeto ? aplication_system::compareUserVsResponsable($projeto->getGerente()) : 1) || (aplication_system::esSocio()) && !$valor->getConfirmacao()): ?>

                            <?php echo jq_link_to_remote(image_tag($valor->getBaixa().'.png','alt="" title="" border=0'), array(

                                'update'  =>  'status_'.$valor->getCodigoSaida(),

                                'url'     =>  'despesa/darBaixa?id='.$valor->getCodigoSaida().'&baixa='.$valor->getBaixa(),

                                'script'  => true,

                                'before'  => "$('#status_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"

                            ),array('class' => 'opcoe_adm'));

                            ?>

                        <?php else: ?>

                            <?php echo image_tag($valor->getBaixa().'.png','alt="" title="" border=0') ?>

                        <?php endif; ?>

                    </td>

                    <td class="no_print" id="confirma_<?php echo $valor->getCodigoSaida() ?>" >

                        <?php $valConfi = $valor->getConfirmacao() ? 1 : 0 ?>

                        <?php if(aplication_system::esContable()): ?>

                            <?php if($statusPedido == 4 || $statusPedido == 0): ?>

                                <?php echo jq_link_to_remote(image_tag($valConfi.'.png','alt="" title="" border=0'), array(

                                    'update'  =>  'confirma_'.$valor->getCodigoSaida(),

                                    'url'     =>  'despesa/confirmacion?id='.$valor->getCodigoSaida().'&confirma='.$valConfi,

                                    'script'  => true,

                                    'before'  => "$('#confirma_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"

                                ),array('class' => 'opcoe_adm'));

                                ?>

                            <?php endif; ?>

                        <?php else: ?>

                            <?php echo image_tag($valConfi.'.png','alt="" title="" border=0') ?>

                        <?php endif; ?>

                    </td>

                    

                </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="12"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>

                </tr>

            <?php endif; ?>

        </tbody>

</table>

<br /><br />

<button onclick="goBack()" class="button red medium">VOLTAR</button>