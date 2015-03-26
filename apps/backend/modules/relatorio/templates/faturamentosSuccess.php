<?php use_stylesheet('tableRelatorio.css') ?>
<style>
    table#resultsList td{
        font-size: 11px;
    }
</style>
<h1 class="icono_projeto">Financiero</h1>
<br />
<?php include_partial('filtroAno', array('anos' => $anos, 'anoSelected' => $anoSelected)) ?>
<div class="clear"></div>
<ul id="tabRelatorio" class="tabRelatorio">
    <li><a href="<?php echo url_for('@default?module=relatorio&action=faturamentos') ?>"  class="selected" >Faturamentos</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=despesas') ?>" >Despesas</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=pagamentosEmAtraso') ?>" >Pagamentos em atraso</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=fluxoCaixa') ?>" >Fluxo de Caixa</a></li>
</ul>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th style="padding-left: 10px;">Faturamento</th>
            <?php for($i =  1; $i <=12; $i++): ?>
            <?php $nMes = globalFunctions::zerofill($i,2) ?>
            <th class="center"><?php echo lynxValida::nombreMes($nMes) ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $key => $value): ?>
        <tr>
            <td><?php echo $key ?></td>            
            <?php foreach ($value as $k => $v): ?>
                <td>R$ <?php echo $v ?></td>            
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
    
</table>
