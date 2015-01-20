<h1 class="icono_projeto">Editar Pedido <?php echo $Pedidos->getNumeroPedido() ?></h1>
<?php include_partial('producto/menu') ?>
<?php include_partial('form', array('form' => $form, 'items' => $items, 'edit' => $edit)) ?>
