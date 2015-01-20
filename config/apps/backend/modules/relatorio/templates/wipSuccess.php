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
<h2 class="titulo">Relatório WIP</h2>
<br />
<?php include_partial('filtro', array('status' => $status, 'statusSelected' => $statusSelected)) ?>

<div class="clear"></div>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th class="left-cel" style="padding-left: 10px;"> Projeto </th>
            <th class="left-cel"> Coef WIP </th>
            <th class="left-cel"> Valor Total </th>
            <th class="left-cel"> Disponível </th>
            <th class="left-cel"> Valor Faturado </th>
            <th class="left-cel">  Faturado WIP </th>
            <th class="left-cel">  Real HH  </th>
            <th class="left-cel">  Real Desp   </th>
            <th class="left-cel">  Total  </th>
            <th class="left-cel">  WIP  </th>
        </tr>
    </thead>
    <tbody>
        <?php
            $tValor = 0;
            $tDisponivle = 0;
            $tValorFaturado = 0;
            $tFacturadoWip = 0;
            $tRealHH = 0;
            $tRealDespesa = 0;
            $tTotalRR = 0;
            $tTotalWip = 0;
        ?>
        <?php foreach ($result as $rs): ?>
            <tr>
                <td style="padding-left: 10px;"><?php echo $rs->getCodigoSgwsProjeto() ?></td>
                <td class="left-cel"><?php echo $rs->getCoeficiente()  ?></td>
                <td class="left-cel">
                    R$ <?php echo aplication_system::monedaFormat($rs->getValor()) ?>
                    <?php $tValor = $tValor + $rs->getValor() ?>
                </td>
                <td class="left-cel">
                    <?php $disponivle = $rs->getValor() * $rs->getCoeficiente()  ?>
                    R$ <?php echo aplication_system::monedaFormat($disponivle)  ?>
                    <?php $tDisponivle = $tDisponivle + $disponivle ?>
                </td>
                <td class="left-cel">
                    <?php $valorFaturado = SaidasPeer::getValorFaturadoProjeto($rs->getCodigoProposta())  ?>
                    R$ <?php echo aplication_system::monedaFormat($valorFaturado)  ?>
                    <?php $tValorFaturado = $tValorFaturado + $valorFaturado ?>                     
                </td>
                <td class="left-cel">
                    <?php $facturadoWip = $valorFaturado * $rs->getCoeficiente() ?>
                    R$ <?php echo aplication_system::monedaFormat($facturadoWip)  ?>
                    <?php $tFacturadoWip = $tFacturadoWip + $facturadoWip ?>
                </td>
                <td class="left-cel">
                    <?php $realHH = TempotarefaPeer::getHorasBillabilityProjeto($rs->getCodigoProposta()) ?>
                    R$ <?php echo aplication_system::monedaFormat($realHH)  ?>
                    <?php $tRealHH = $tRealHH + $realHH ?>
                </td>
                <td class="left-cel">
                    <?php $realDespesa = SaidasPeer::getSumaDespesasRealesProjeto($rs->getCodigoProposta())  ?>
                    R$ <?php echo aplication_system::monedaFormat($realDespesa)  ?>
                    <?php $tRealDespesa = $tRealDespesa + $realDespesa ?>
                </td>
                <td class="left-cel">
                    <?php $totalRR = $realHH + $realDespesa ?>
                    R$ <?php echo aplication_system::monedaFormat($totalRR) ?>
                    <?php $tTotalRR = $tTotalRR + $totalRR ?>
                </td>
                <td class="left-cel">
                    <?php $totalWip = $facturadoWip - ($realHH + $realDespesa) ?>
                    R$ <?php echo aplication_system::monedaFormat($totalWip) ?>
                    <?php $tTotalWip =  $tTotalWip + $totalWip ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td>Totales</td>
            <td>R$ <?php echo aplication_system::monedaFormat($tValor) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tDisponivle) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tValorFaturado) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tFacturadoWip) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tRealHH) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tRealDespesa) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tTotalRR) ?></td>
            <td>R$ <?php echo aplication_system::monedaFormat($tTotalWip) ?></td>
        </tr>
    </tfoot>
</table>