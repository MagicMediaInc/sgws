<?php use_stylesheet('tableRelatorio.css') ?>
<h1 class="icono_projeto">Vendas</h1>
<br />
<?php include_partial('filtroAno', array('anos' => $anos, 'anoSelected' => $anoSelected)) ?>
<br />
<div class="clear"></div>

<ul id="tabRelatorio" class="tabRelatorio">
    <li><a href="<?php echo url_for('@default?module=relatorio&action=consolidadoVendas') ?>" >Consolidado de Vendas</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=funilVendas') ?>" class="selected" >Funil de Vendas</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=hot') ?>" >Hot</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=emNegociacao') ?>" >Em Negociação</a></li>
</ul>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th style="width: 10%; padding-left: 4px;">
                <?php echo link_to('Data','@default?module=relatorio&action=funilVendas&sort=DATA_IR_PROJETO&by='.$by) ?>
                <?php if($sort == "DATA_IR_PROJETO"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Projeto','@default?module=relatorio&action=funilVendas&sort=CODIGO_SGWS_PROJETO&by='.$by) ?>
                <?php if($sort == "CODIGO_SGWS_PROJETO"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Cliente','@default?module=relatorio&action=funilVendas&sort=NOME_FANTASIA&by='.$by) ?>
                <?php if($sort == "NOME_FANTASIA"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Gerente','@default?module=relatorio&action=funilVendas&sort=NAME&by='.$by) ?>
                <?php if($sort == "NAME"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Tipo de Serviço','@default?module=relatorio&action=funilVendas&sort=TIPO&by='.$by) ?>
                <?php if($sort == "TIPO"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Valor R$','@default?module=relatorio&action=funilVendas&sort=VALOR&by='.$by) ?>
                <?php if($sort == "VALOR"){ echo image_tag($by_page); }?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if($result): ?>
            <?php foreach ($result as $dato) : ?>
                <tr>
                    <td><?php echo $dato['data'] ?></td>
                    <td><?php echo $dato['projeto'] ?></td>
                    <td><?php echo $dato['cliente'] ?></td>
                    <td><?php echo $dato['gerente'] ?></td>
                    <td><?php echo $dato['tipo'] ?></td>
                    <td><?php echo $dato['valor'] ? 'R$ '.aplication_system::monedaFormat($dato['valor']) : '' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>