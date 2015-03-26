<?php use_stylesheet('tableConsolidadoVendas.css') ?>

<script type="text/javascript"> 

$(document).ready(function() {

    $('.expandMes').click(function(){

        var id = $(this).attr('id');

        $("#plus-" + id).toggle('slow');

    });

        

})

</script>

<h1 class="icono_projeto">Vendas</h1>

<br />

<?php 
// var_dump($anos);

include_partial('filtroAno', array('anos' => $anos, 'anoSelected' => $anoSelected)) ?>

<div class="clear"></div>

<ul id="tabRelatorio" class="tabRelatorio">

    <li><a href="<?php echo url_for('@default?module=relatorio&action=consolidadoVendas') ?>" class="selected" >Consolidado de Vendas</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=funilVendas') ?>" >Funil de Vendas</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=hot') ?>" >Hot</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=emNegociacao') ?>" >Em Negociação</a></li>

</ul>

<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">

    <thead>

        <tr>

            <th style="padding-left: 10px; width: 20%;">Mês</th>

            <th class="">Propostas Emitidas</th>

            <th class="">Total Emitido ($$)</th>

            <th class="">Valor médio Emitido</th>

            <th class="">Propostas Vendidas</th>

            <th class="">Total Vendido ($$)</th>

            <th class="">Valor Médio Vendido</th>

        </tr>

    </thead>

    <tbody>

        <?php if($result): ?>

            <?php foreach ($result as $mes => $calculos) : ?>

                <?php $nombreMes = lynxValida::nombreMes($mes).'<br>'; ?>

                <tr>

                    <td><a href="javascript:void(0);" class="expandMes" id="<?php echo $mes ?>" >

                        + <?php echo $nombreMes ?></a></td>

                    <?php foreach ($calculos as $value) : ?>

                        <td><?php echo $value ?></td>

                    <?php endforeach; ?>

                </tr>

                <tr id="plus-<?php echo $mes ?>" style="display: none;">

                    <?php $servicios = PropostaPeer::getTipoServicioAnoMes($ano, $mes); ?>
                    
                    <td colspan="7">

                        <table cellpadding="0" cellspacing="0" border="0" style="width: 100%; margin-bottom: 25px;" id="servicios">

                            <?php if($servicios != null): ?>
                            <?php foreach ($servicios as $serv): ?>

                            <?php $pEmitidas = PropostaPeer::getPropostasEmitidas($ano, $mes, $serv['id']); ?>

                            <?php $pVendidas = PropostaPeer::getPropostasVendidas($ano, $mes, $serv['id']); ?>
                            <tr>

                                <td style="width: 20%">

                                    <?php echo $serv['tipo'] ?>

                                </td>

                                <td style="width: 13%"><?php echo $pEmitidas['cantidad'] ?></td>

                                <td style="width: 12%"><?php echo 'R$ '.aplication_system::monedaFormat($pEmitidas['total']) ?></td>

                                <td style="width: 14%">R$ <?php echo aplication_system::monedaFormat($pEmitidas['valor_medio_emitido']) ?></td>

                                <td style="width: 14%"><?php echo $pVendidas['cantidad'] ?></td>

                                <td style="width: 13%"><?php echo 'R$ '. aplication_system::monedaFormat($pVendidas['total']) ?></td>

                                <td>R$ <?php echo aplication_system::monedaFormat($pVendidas['valor_medio_vendido']) ?></td>

                            </tr>

                            <?php endforeach; ?>
                            <?php endif; ?>
                        </table>

                        

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

    </tbody>

</table>