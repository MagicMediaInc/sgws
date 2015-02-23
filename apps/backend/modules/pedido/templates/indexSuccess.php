<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
        $("#from_date").datepicker({   
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',        
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
            }
        });    
        $("#to_date").datepicker({
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',          
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
                if(!$("#from_date").val())
                    {
                        $( "#from_date" ).val($("#to_date").val());
                    }
            }
        });
    });
</script>
<h1 class="icono_projeto"><?php echo __('Meus Pedidos') ?></h1>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<?php include_partial('producto/menu') ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td>
            <form action="" method="POST">
                <div class="propiedades propiedades-extend" style="width: 100%; border: 0px; height: 50px;">
                    <h2 class="titulo"><?php echo __('Filtros') ?></h2>
                    <table width="100%" >
                        <tr>
                            <td width="11%"><input type="text" placeholder="Palavra Chave" style="width: 100px;" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" /></td>
                            <td width="20%">
                                <label style="color: #333; font-weight: bold;">Status do Pedido</label>
                                <select name="status" id="status">
                                    <?php foreach ($status as $k => $st): ?>
                                        <option value="<?php echo $k ?>" <?php echo $sf_request->getParameter('status') == $k ? 'selected="selected"' : ''  ?> ><?php echo $st ?></option>
                                    <?php endforeach; ?>                                    
                                </select>
                            </td>
                            <td style="width: 20%;">
                                <label style="color: #333; font-weight: bold;"> <?php echo __('De') ?></label>
                                <input size="8" type="text" name="from_date" id="from_date" value="<?php echo $sf_request->getParameter('from_date') ?>" >
                                &nbsp;&nbsp;
                                <label style="color: #333; font-weight: bold;"> <?php echo __('Até') ?></label>
                                <input size="8" type="text" name="to_date" id="to_date" value="<?php echo $sf_request->getParameter('to_date') ?>" >
                            </td>
                            <td align="left">
                                <input type="submit" name="buscar" id="buscar" value="Buscar" />
                                <a href="<?php echo url_for('pedido/index') ?> "><?php echo __('Veja todo') ?></a>
                            </td>
                            <?php if($sf_request->getParameter('status') == 2): ?>
                            <td style="text-align: right; width: 20%">
                                <a href="#" class="print" rel="content-area-print">Imprimir <?php echo image_tag('icons/print','width="30" style="position: relative; top: 9px;"') ?></a>
                            </td>
                            <?php endif; ?>
                        </tr>            
                    </table>
                </div>
            </form>
        </td>

    </tr>
</table>    
    
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Número Pedido</th>
            <th>Data do Pedido</th>
            <th>Projeto</th>
            <th>Gerente</th>
            <th>Status</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($pedidos): ?>
            <?php foreach ($pedidos as $item) : ?>
                <tr>
                    <td>&nbsp;<a href="<?php echo url_for('@default?module=pedido&action=edit&id='.$item->getId()) ?>" class="titulo">Detalhe Pedido <?php echo image_tag('icons/zoom', 'width="16"') ?> </a></td>
                    <td><?php echo $item->getNumeroPedido() ?></td>
                    <td><?php echo date("d-m-Y", strtotime($item->getData())) ?></td>
                    <td>
                        <?php $proyecto = PropostaPeer::retrieveByPK($item->getIdProjeto())  ?>
                        <?php echo $proyecto->getCodigoSgwsProjeto() ?> - <?php echo $proyecto->getNomeProposta() ?>
                        <?php unset($proyecto) ?>
                    </td>
                    <td>
                        <?php $gerente = LxUserPeer::retrieveByPK($item->getIdCliente())  ?>
                        <?php echo $gerente->getName()  ?>
                        <?php unset($gerente) ?>
                    </td>
                    <td><?php echo $status[$item->getStatus()]  ?></td>
                    <td>R$ <?php echo number_format(($item->getValor() + $item->getDesconto()),2,',','.'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
 </table>
    

