<?php use_stylesheet('tableRelatorio.css') ?>
<h1 class="icono_projeto">Vendas</h1>
<br />
<?php include_partial('filtroAno', array('anos' => $anos, 'anoSelected' => $anoSelected)) ?>
<br />
<div class="clear"></div>
<ul id="tabRelatorio" class="tabRelatorio">

    <li><a href="<?php echo url_for('@default?module=relatorio&action=consolidadoVendas') ?>" >Funil de Vendas</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=funilVendas') ?>" >Backlog</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=hot') ?>" class="selected" >Hot</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=emNegociacao') ?>" >Em Negociação</a></li>
    
</ul>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th style="width: 10%; padding-left: 10px;">
                <?php echo link_to('Data Emissão','@default?module=relatorio&action=hot&sort=DATA_INICIO&by='.$by) ?>
                <?php if($sort == "DATA_INICIO"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Proposta','@default?module=relatorio&action=hot&sort=CODIGO_SGWS&by='.$by) ?>
                <?php if($sort == "CODIGO_SGWS"){ echo image_tag($by_page); }?>
            </th>
            <th class="" style="">
                <?php echo link_to('Cliente','@default?module=relatorio&action=hot&sort=NOME_FANTASIA&by='.$by) ?>
                <?php if($sort == "NOME_FANTASIA"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Gerente','@default?module=relatorio&action=hot&sort=NAME&by='.$by) ?>
                <?php if($sort == "NAME"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Tipo de Serviço','@default?module=relatorio&action=hot&sort=TIPO&by='.$by) ?>
                <?php if($sort == "TIPO"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Valor R$','@default?module=relatorio&action=hot&sort=VALOR&by='.$by) ?>
                <?php if($sort == "VALOR"){ echo image_tag($by_page); }?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if($result): ?>
            <?php foreach ($result as $dato) : ?>
                <tr>
                    <td><?php echo date("d-m-Y", strtotime($dato['data'])); ?></td>
                    <td><?php echo $dato['proposta'] ?></td>
                    <td><?php echo $dato['cliente'] ?></td>
                    <td><?php echo $dato['gerente'] ?></td>
                    <td><?php echo $dato['tipo'] ?></td>
                    <td>R$ <?php echo aplication_system::monedaFormat($dato['valor']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
                <tr>
                    <td colspan="6" class="center erro_no_data">Nenhum resultado</td>
                </tr>
        <?php endif; ?>
    </tbody>
</table>