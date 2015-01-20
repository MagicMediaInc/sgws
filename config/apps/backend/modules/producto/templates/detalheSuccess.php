
<script type="text/javascript">
    $(document).ready(function() {
        $('.voltar').click(function() {
            history.back()
        });
        $('#addToCart').click(function() {
            $("#prForm").submit();
            
        });
    });
</script>    

<h1 class="icono_projeto">
    Detalhe -- Produto -- <?php echo $producto->getNome() ?>
</h1>

<div style="float: left; width: 410px; height: 300px; text-align: center; border: 1px solid #ccc; margin-right: 10px;">
    <?php if(file_exists(sfConfig::get('sf_upload_dir').'/productos/big_'.$producto->getFoto())): ?>
        <?php echo image_tag('/uploads/productos/big_'.$producto->getFoto(),'class="big" ') ?>
    <?php else: ?>
        <?php echo image_tag('semfoto.jpg', ' ') ?>
    <?php endif; ?>   
</div>
<div style="float: left; width: 398px;">
    <?php $valor_desconto = $producto->getPreco() - ($producto->getPreco() * $producto->getDesconto() / 100); ?>
    <h1><?php echo $producto->getNome() ?></h1>
    <br>
    <b>R$ <?php echo number_format($valor_desconto,2,',','.') ?></b>
    <hr>
    <h2>Dados técnicos</h2><br />
    <p>
        Código: <?php echo $producto->getCodigo() ?>
    </p>
    <p>
        Categoria: <?php echo $categoria->getNome() ?>
    </p>
    <p>
        Ano: <?php echo $producto->getAno() ?>
    </p>
    
    <p>
        Unidade Dimensional <?php echo $producto->getComprimento() ?> 
    </p>
    <p>
        Observações: <?php echo html_entity_decode($producto->getObservacoes()) ?> 
    </p>
    <div style="margin-top: 10px;">
        <form method="post" action="<?php echo url_for('@cart?action=agregar&id='.$producto->getId())?>" id="prForm">
            <a href="javascript:void();" class="voltar"><?php echo image_tag('btn_voltar_cad.gif') ?></a>
            <button style="border: none; background-color: white;" name="my-add-button" type="button" class="button red small" id="addToCart"><?php echo image_tag('btn_comprar.png') ?></button>
            <input type="hidden" name="id_producto" id="id_producto" value="<?php echo $producto->getId(); ?>" /> 
        </form>
    </div>
    
</div>
