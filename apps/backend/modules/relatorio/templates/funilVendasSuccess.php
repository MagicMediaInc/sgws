
<?php use_stylesheet('tableRelatorio.css') ?>

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
            <td style="vertical-align: bottom; padding-bottom: 4px;">
                <input type="submit" value="Filtrar" />
            </td>
        </tr>
    </table>
</form>

<br />
<div class="clear"></div>

<ul id="tabRelatorio" class="tabRelatorio">

    <li><a href="<?php echo url_for('@default?module=relatorio&action=consolidadoVendas') ?>" >Funil de Vendas</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=funilVendas') ?>" class="selected" >Backlog</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=hot') ?>" >Hot</a></li>

    <li><a href="<?php echo url_for('@default?module=relatorio&action=emNegociacao') ?>" >Em Negociação</a></li>
    
</ul>

<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th style="width: 8%; padding-left: 4px;">
                Data
                <?php #echo link_to('Data','@default?module=relatorio&action=funilVendas&sort=DATA_IR_PROJETO&by='.$by) ?>
                <?php #if($sort == "DATA_IR_PROJETO"){ echo image_tag($by_page); }?>
            </th>
            <th style="width: 6%;" class="">
                Projeto
                <?php #echo link_to('Projeto','@default?module=relatorio&action=funilVendas&sort=CODIGO_SGWS_PROJETO&by='.$by) ?>
                <?php #if($sort == "CODIGO_SGWS_PROJETO"){ echo image_tag($by_page); }?>
            </th>
            <th style="width: 20%;" class="">
                Cliente
                <?php #echo link_to('Cliente','@default?module=relatorio&action=funilVendas&sort=NOME_FANTASIA&by='.$by) ?>
                <?php #if($sort == "NOME_FANTASIA"){ echo image_tag($by_page); }?>
            </th>
            <th style="width: 20%;" class="">
                Gerente
                <?php #echo link_to('Gerente','@default?module=relatorio&action=funilVendas&sort=NAME&by='.$by) ?>
                <?php #if($sort == "NAME"){ echo image_tag($by_page); }?>
            </th>
            <th style="width: 20%;" class="">
                Gerente Comercial
                <?php #echo link_to('Gerente','@default?module=relatorio&action=funilVendas&sort=NAME&by='.$by) ?>
                <?php #if($sort == "NAME"){ echo image_tag($by_page); }?>
            </th>
            <!-- <th style="width: 30%;" class="">
                Gerente Comercial
                <?php #echo link_to('Gerente','@default?module=relatorio&action=funilVendas&sort=NAME&by='.$by) ?>
                <?php #if($sort == "NAME"){ echo image_tag($by_page); }?>
            </th> -->
            <th style="width: 20%;" class="">
                Tipo de Serviço
                <?php #echo link_to('Tipo de Serviço','@default?module=relatorio&action=funilVendas&sort=TIPO&by='.$by) ?>
                <?php #if($sort == "TIPO"){ echo image_tag($by_page); }?>
            </th>
            <th style="width: 10%;" class="">
                Valor R$
                <?php #echo link_to('Valor R$','@default?module=relatorio&action=funilVendas&sort=VALOR&by='.$by) ?>
                <?php #if($sort == "VALOR"){ echo image_tag($by_page); }?>
            </th>
        </tr>
    </thead>

    <tbody>

        <?php if($r): ?>

            <?php for ($i = 1 ; $i <=12 ; $i++) : ?>

                <?php if(isset($r[$i])): ?>

                    <?php $mes = $i; ?>
                    <?php $servicios = $r[$i]; ?>

                    <?php $nombreMes = lynxValida::nombreMes($mes).'<br>'; ?>

                    <tr>

                        <td><a href="javascript:void(0);" class="expandMes" id="<?php echo $mes ?>" >

                            + <?php echo $nombreMes ?></a></td>

                        <td><?php #var_dump($projeto) ?></td>
                        <td><?php #var_dump($projeto) ?></td>
                        <td><?php #var_dump($projeto) ?></td>
                        <td><?php #var_dump($projeto) ?></td>
                        <td><?php #var_dump($projeto) ?></td>

                    </tr>

                    <tr id="plus-<?php echo $mes ?>" style="display: none;">

                        <?php #$servicios = PropostaPeer::getTipoServicioAnoMes($ano, $mes); ?>
                        
                        <td colspan="7">

                            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%; margin-bottom: 25px;" id="servicios">

                                <?php if($servicios != null): ?>
                                <?php foreach ($servicios as $dato): ?>

                                <?php $pEmitidas = PropostaPeer::getPropostasEmitidas($ano, $mes, $dato['id']); ?>

                                <?php $pVendidas = PropostaPeer::getPropostasVendidas($ano, $mes, $dato['id']); ?>
                                <tr>

                                    <td style="width: 8%; padding-left: 4px;"><?php echo $dato['data'] ?></td>
                                    <td style="width: 6%;"><?php echo $dato['projeto'] ?></td>
                                    <td style="width: 20%;"><?php echo $dato['cliente'] ?></td>
                                    <td style="width: 20%;"><?php echo $dato['gerente'] ?></td>
                                    <td style="width: 20%;">
                                        <?php 
                                            $analisis = AnalisisPeer::getAnalisis($dato['id']);
                                            // if($analisis[0):                                                     # En caso de que sea la primera analisis critica
                                            if($analisis[count($analisis)-1]->getResponsableComercial() != 0):      # En caso de que sea la ultima analisis critica
                                                $responsable = LxUserPeer::retrieveByPK($analisis[count($analisis)-1]->getResponsableComercial());
                                                echo $responsable->getName();
                                            else:
                                                ?> --- <?php
                                            endif;
                                            
                                        ?>
                                    </td>
                                    <td style="width: 20%;"><?php echo $dato['tipo'] ?></td>
                                    <td style="width: 10%;"><?php echo $dato['valor'] ? 'R$ '.aplication_system::monedaFormat($dato['valor']) : '' ?></td>

                                    <!-- <td style="width: 20%">
                                    
                                        <?php echo $serv['tipo'] ?>
                                    
                                    </td>
                                    
                                    <td style="width: 13%"><?php echo $pEmitidas['cantidad'] ?></td>
                                    
                                    <td style="width: 12%"><?php echo 'R$ '.aplication_system::monedaFormat($pEmitidas['total']) ?></td>
                                    
                                    <td style="width: 14%">R$ <?php echo aplication_system::monedaFormat($pEmitidas['valor_medio_emitido']) ?></td>
                                    
                                    <td style="width: 14%"><?php echo $pVendidas['cantidad'] ?></td>
                                    
                                    <td style="width: 13%"><?php echo 'R$ '. aplication_system::monedaFormat($pVendidas['total']) ?></td>
                                    
                                    <td>R$ <?php echo aplication_system::monedaFormat($pVendidas['valor_medio_vendido']) ?></td> -->

                                </tr>

                                <?php endforeach; ?>
                                <?php endif; ?>
                            </table>

                            

                        </td>

                    </tr>

                <?php endif; ?>

            <?php endfor; ?>

        <?php endif; ?>

    </tbody>

</table>

<!-- <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
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
</table> -->