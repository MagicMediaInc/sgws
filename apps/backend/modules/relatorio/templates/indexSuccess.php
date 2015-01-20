<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
    
    });
</script>
<h1 class="icono_projeto">relatórios</h1>
<h2 class="titulo">Relatório de Propostas Consolidadas</h2>
<br />
<form method="POST" action="">
    <label>Ano</label>
    <select name="ano" id="ano" onchange="this.form.submit();" >
        <?php foreach ($years as $key => $val) : ?>
        <option value="<?php echo $key ?>" <?php echo $ano == $key ? 'selected="selected"' : '' ?>><?php echo $val ?></option>
        <?php endforeach; ?>
    </select>
</form>

<div class="clear"></div>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th style="padding-left: 10px;">Mês</th>
            <th class="center">Propostas Emitidas</th>
            <th class="center">Hot</th>
            <th class="center">Negociação</th>
            <th class="center">Total de Propostas Emitidas (R$)</th>
            <th class="center">Propostas Vendidas (Backlog)</th>
            <th class="center">Total de Propostas Vendidas (R$)</th>
        </tr>
    </thead>
    <tbody>
        <?php for($i =  1; $i <=12; $i++): ?>
            <?php $nMes = globalFunctions::zerofill($i,2) ?>
            <?php $pEmitidas = PropostaPeer::getRelatorioEmitidas($ano, $nMes); ?>
            <?php $pVendidas = PropostaPeer::getRelatorioVendidas($ano, $nMes); ?>
            <tr>
                <td style="padding-left: 10px;"><?php echo lynxValida::nombreMes($nMes) ?></td>
                <td class="center"><?php echo $pEmitidas['emitidas']?></td>
                <td class="center"><?php echo $pEmitidas['hot']?></td>
                <td class="center"><?php echo $pEmitidas['negociacao']?></td>
                <td class="center"><?php echo aplication_system::monedaFormat($pEmitidas['valor']) ?></td>
                <td class="center"><?php echo $pVendidas['emitidas']?></td>
                <td class="center"><?php echo aplication_system::monedaFormat($pVendidas['valor']) ?></td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>