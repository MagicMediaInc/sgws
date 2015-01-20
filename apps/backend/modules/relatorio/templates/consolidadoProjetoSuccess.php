<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
    
    });
</script>
<style>
    tfoot tr td{
        font-weight: bold;
        font-size: 13px;
    }
</style>
<h1 class="icono_projeto">relatórios</h1>
<h2 class="titulo">Consolidado Projetos</h2>
<br />
<?php include_partial('filtro', array('status' => $status, 'statusSelected' => $statusSelected)) ?>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th class="left-cel" style="padding-left: 5px; width: 6%"> Projeto </th>
            <th class="left-cel" style="width: 7%;"> Cliente </th>
            <th class="left-cel" style="width: 8%;"> Gerente </th>
            <th class="left-cel"> Valor da Venda </th>
            <th class="left-cel"> Faturado </th>
            <th class="left-cel"> Saldo </th>
            <th class="left-cel"> Previsto HH </th>
            <th class="left-cel">  Real HH </th>
            <th class="left-cel">  Previsto Despesa  </th>
            <th class="left-cel">  Real Desp  </th>
            <th class="left-cel">  Resultado </th>
            <th class="left-cel">  Resultado % </th>
            <th class="left-cel">  &nbsp; </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $tValor = 0;
            $tValorFaturado = 0;
            $tSaldo = 0;
            $tValorHH = 0;
            $tRealHH = 0;
            $tPrevDesp = 0;
            $tRealDesp = 0;
            $tResultado = 0;
        ?>
        <?php foreach ($result as $rs): ?>
            <tr>
                <td style="padding-left: 10px;">
                    <a href="<?php echo url_for('@default?module=relatorio&action=fluxo&id='.$rs['id']) ?>">
                        <?php echo $rs['codigo_sgws_projeto'] ?>
                    </a>
                </td>
                <td class="left-cel"><?php echo $rs['cliente'] ?></td>
                <td class="left-cel"><?php echo $rs['gerente'] ?></td>
                <td class="left-cel">
                    R$ <?php echo aplication_system::monedaFormat($rs['valor']) ?>
                    <?php $tValor = $tValor + $rs['valor'] ?>
                </td>
                <td class="left-cel">
                    <?php $valorFaturado = SaidasPeer::getValorFaturadoProjeto($rs['id'])  ?>
                    R$ <?php echo aplication_system::monedaFormat($valorFaturado)  ?>
                    <?php $tValorFaturado = $tValorFaturado + $valorFaturado ?>
                </td>
                <td class="left-cel">
                    <?php $saldo = $rs['valor'] - $valorFaturado ?>
                    R$ <?php echo aplication_system::monedaFormat($saldo) ?>
                    <?php $tSaldo = $tSaldo +  $saldo ?>
                </td>
                <td class="left-cel">
                    R$ <?php echo aplication_system::monedaFormat($rs['valor_hh']) ?>
                    <?php $tValorHH = $tValorHH + $rs['valor_hh'] ?>
                </td>
                <td class="left-cel">
                    <?php $realHH = TempotarefaPeer::getHorasBillabilityProjeto($rs['id']) ?>
                    R$ <?php echo aplication_system::monedaFormat($realHH) ?>
                    <?php $tRealHH = $tRealHH + $realHH ?>
                </td>
                <td class="left-cel">
                    <?php $prevDespesa = ProjetoSubtipoGastoPeer::getPrevistoDespesa($rs['id']) ?>
                    R$ <?php echo aplication_system::monedaFormat($prevDespesa)  ?>
                    <?php $tPrevDesp = $tPrevDesp + $prevDespesa ?>
                </td>
                <td class="left-cel">
                    <?php $realDespesa = SaidasPeer::getSumaDespesasRealesProjeto($rs['id'])  ?>
                    R$ <?php echo aplication_system::monedaFormat($realDespesa)  ?>
                    <?php $tRealDesp = $tRealDesp + $realDespesa ?>
                </td>
                <td class="left-cel">
                    <?php $resultado = ($rs['valor_hh'] - $realHH) + ($prevDespesa + $realDespesa) ?>
                    <?php echo aplication_system::monedaFormat($resultado) ?>
                    <?php $tResultado = $tResultado + $resultado ?>
                </td>
                <td class="left-cel">
                    <?php $divisor = $realHH + $realDespesa ?>
                    <?php $resultadoPer = $divisor > 0 ? $resultado / $divisor : 0 ?> 
                    <?php echo aplication_system::monedaFormat($resultadoPer) ?> %
                    
                </td>
                <td>
                    <a href="<?php echo url_for('@default?module=relatorio&action=fluxo&id='.$rs['id']) ?>">
                        Fluxo
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td>TOTALES</td>
            <td>R$ <?php echo aplication_system::monedaFormat($tValor) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tValorFaturado) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tSaldo) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tValorHH) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tRealHH) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tPrevDesp) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tRealDesp) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tResultado) ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>