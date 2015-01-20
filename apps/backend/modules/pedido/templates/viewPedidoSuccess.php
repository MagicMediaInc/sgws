<?php use_javascript('jq/jQuery.print.js') ?>
<script type="text/javascript">
    $(function() {
        $("#hrefPrint").click(function() {
        // Print the DIV.
        $("#printdiv").print();
        return (false);
        });
    });
</script>
<style type="text/css">
    @import url("/css/main.css");
    @import url("/css/cart.css");
    
</style>
<div id="printdiv" class="printable">
    
    
<h1 class="icono_projeto">Pedido <?php echo $Pedidos->getNumeroPedido() ?></h1>

<table id="cart" class="cart" cellspacing="0">
    <caption >
        pedido número: <?php echo $Pedidos->getNumeroPedido() ?>
        
    </caption>
    <thead>
        <tr>
            <th>Data da Compra: <?php echo date("d-m-Y", strtotime($infoPedido['data_compra'])) ?> </th>
            <th>Código do Projeto: <?php echo $infoPedido['codigo_projeto'] ?> <?php echo $infoPedido['nome_projeto'] ?> </th>
            <th>Gerente Responsável: <?php echo  $infoPedido['gerente'] ?></th>
        </tr>
        <tr>
            <th>Data do pedido: <?php echo date("d-m-Y", strtotime($Pedidos->getData()))  ?> </th>
            <th>Forma de Pagamento: <?php echo $Pedidos->getFormaPagamento()  ?> </th>
            <th>Status atual: <?php echo $status[$Pedidos->getStatus()] ?></th>
        </tr>
    </thead>
</table>

<?php include_partial('pedido/items', array('items' => $items)) ?>
</div>
<div class="space-print">
    <a href="#" id="hrefPrint" rel="content-area-print">Imprimir <?php echo image_tag('icons/print','width="30" style="position: relative; top: 9px;"') ?></a>
</div>