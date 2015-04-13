<?php use_stylesheet('tableRelatorio.css') ?>
<h1 class="icono_projeto">Vendas</h1>
<br />
<?php #include_partial('filtroAno', array('anos' => $anos, 'anoSelected' => $anoSelected)) ?>

<form method="POST" action="">
    <table>
        <tr>
            <td>
                <label>Ano</label>&nbsp;
                <select id="by_ano" name="ano">
                    <?php foreach ($anos as $key => $value): ?>
                      <option value="<?php echo $key ?>" <?php echo $anoSelected == $key ? 'selected="selected"' : '' ?>  ><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td align="left" width="90%">
                <label>Palavra Chave</label>
                <span class="propiedades propiedades-extend" style="width: 450px; border-left: 1px #ccc dotted; height: 120px;">
                    <input type="text" style="width: 290px;" placeholder="Codigo Projeto, Cliente, Gerente, Serviço, etc" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" />
                    <input type="submit" name="search" id="busca" value="Buscar" />
                </span>
            </td>
        </tr>
    </table>
</form>

<br />
<div class="clear"></div>
<ul id="tabRelatorio" class="tabRelatorio">

    <li><a href="<?php echo url_for('@default?module=relatorio&action=consolidadoVendas') ?>" >Funil de Vendas</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=funilVendas') ?>" >Backlog</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=hot') ?>">Hot</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=emNegociacao') ?>" class="selected" >Em Negociação</a></li>
    
</ul>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList" >
    <thead>
        <tr>
            <th style="width: 10%; padding-left: 10px;">
                <?php echo link_to('Data Emissão','@default?module=relatorio&action=emNegociacao&sort=DATA_INICIO&by='.$by) ?>
                <?php if($sort == "DATA_INICIO"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Proposta','@default?module=relatorio&action=emNegociacao&sort=CODIGO_SGWS&by='.$by) ?>
                <?php if($sort == "CODIGO_SGWS"){ echo image_tag($by_page); }?>
            </th>
            <th class="" style="">
                <?php echo link_to('Cliente','@default?module=relatorio&action=emNegociacao&sort=NOME_FANTASIA&by='.$by) ?>
                <?php if($sort == "NOME_FANTASIA"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Gerente','@default?module=relatorio&action=emNegociacao&sort=NAME&by='.$by) ?>
                <?php if($sort == "NAME"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                Gerente Comercial
            </th>
            <th class="">
                <?php echo link_to('Tipo de Serviço','@default?module=relatorio&action=emNegociacao&sort=TIPO&by='.$by) ?>
                <?php if($sort == "TIPO"){ echo image_tag($by_page); }?>
            </th>
            <th class="">
                <?php echo link_to('Valor R$','@default?module=relatorio&action=emNegociacao&sort=VALOR&by='.$by) ?>
                <?php if($sort == "VALOR"){ echo image_tag($by_page); }?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if($result): ?>
            <?php foreach ($result as $dato) : ?>
                <tr>
                    
                    <td style="padding-left: 10px;" ><?php echo $dato['data'] ?></td>
                    <td style="padding-left: 10px;" ><?php echo $dato['proposta'] ?></td>
                    <td><?php echo $dato['cliente'] ?></td>
                    <td><?php echo $dato['gerente'] ?></td>
                    <td style="width: 20%;">
                        <?php 
                            if($analisis = AnalisisPeer::getAnalisis($dato['id'])):
                                // if($analisis[0):                                                     # En caso de que sea la primera analisis critica
                                if($analisis[count($analisis)-1]->getResponsableComercial() != 0):      # En caso de que sea la ultima analisis critica
                                    $responsable = LxUserPeer::retrieveByPK($analisis[count($analisis)-1]->getResponsableComercial());
                                    echo $responsable->getName();
                                else:
                                    ?> --- <?php
                                endif;
                            else:
                                ?> --- <?php
                            endif;
                            
                        ?>
                    </td>
                    <td><?php echo $dato['tipo'] ?></td>
                    <td>R$ <?php echo aplication_system::monedaFormat($dato['valor']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>