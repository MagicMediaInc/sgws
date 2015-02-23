<?php use_stylesheet('tableRelatorio.css') ?>
<h1 class="icono_projeto">Financiero</h1>
<div class="clear"></div>
<ul id="tabRelatorio" class="tabRelatorio">
    <li><a href="<?php echo url_for('@default?module=relatorio&action=faturamentos') ?>"   >Faturamentos</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=despesas') ?>" >Despesas</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=pagamentosEmAtraso') ?>" class="selected" >Pagamentos em atraso</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=fluxoCaixa') ?>" >Fluxo de Caixa</a></li>
</ul>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th style="padding-left: 10px;">
                <?php echo link_to('Projeto','@default?module=relatorio&action=pagamentosEmAtraso&sort=CODIGO_SGWS_PROJETO&by='.$by) ?>
                <?php if($sort == "CODIGO_SGWS_PROJETO"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Cliente','@default?module=relatorio&action=pagamentosEmAtraso&sort=NOME_FANTASIA&by='.$by) ?>
                <?php if($sort == "NOME_FANTASIA"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Gerente','@default?module=relatorio&action=pagamentosEmAtraso&sort=NAME&by='.$by) ?>
                <?php if($sort == "NAME"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Valor','@default?module=relatorio&action=pagamentosEmAtraso&sort=SAIDAPREVISTA&by='.$by) ?>
                <?php if($sort == "SAIDAPREVISTA"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Data Vencimento','@default?module=relatorio&action=pagamentosEmAtraso&sort=DATARECEBIMENTOPRE&by='.$by) ?>
                <?php if($sort == "DATARECEBIMENTOPRE"){ echo image_tag($by_page); }?>
            </th>
            <th class="">Dias de Atraso</th>

        </tr>
    </thead>
    <tbody>
        <?php if($result): ?>
            <?php foreach ($result as $v) : ?>
                <tr>
                    <td style="padding-left: 10px;"><?php echo $v['projeto'] ?></td>
                    <td style="width: 30%;"><?php echo $v['cliente'] ?></td>
                    <td><?php echo $v['gerente'] ?></td>
                    <td>R$ <?php echo aplication_system::monedaFormat($v['valor']) ?></td>
                    <td><?php echo $v['fecha'] ?></td>
                    <td><?php echo $v['dias_atraso'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>