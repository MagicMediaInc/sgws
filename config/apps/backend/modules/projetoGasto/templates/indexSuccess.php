<script type="text/javascript"> 
$(document).ready(function() {
    formatInputMoneda($('.valorgasto'));
});
</script>
<h1 class="tit-principal">Gastos Previstos - Projeto <?php echo $projeto->getCodigoSgwsProjeto() ?></h1>
<div class="frameForm">
    <form action="" method="POST">
        <input type="hidden" name="id_projeto" value="<?php echo $sf_request->getParameter('id_projeto') ?>" />
        <?php if($tipos): ?>
            <?php $total = 0 ?>
            <?php foreach ($tipos as $tp) : ?>
            
                <?php $subtipos = SubtipoUserPeer::getSubTiposByParente($tp->getIdSubtipo()); ?>
                <?php if($subtipos): ?>
                    <h1><span style="text-transform: uppercase"><?php echo $tp->getSubtipo() ?></span></h1>
                    <br />
                    <table style="width: 100%; margin-left: 40px;">
                        
                        <?php foreach ($subtipos as $subt) : ?>
                            <?php $valor_gasto = ProjetoSubtipoGastoPeer::getValorProjetoSubtipo($projeto->getCodigoProposta(), $subt['id'] ) ?>
                            <?php $vv = $valor_gasto ? $valor_gasto->getValor() : 0  ?>
                            <?php $total = $total + $vv ?>
                            <tr>
                                <td style="width: 50%"><?php echo $subt['nome'] ?></td>
                                <td><input type="text" class="valorgasto" name="subtipo-<?php echo $subt['id'] ?>" value="<?php echo $valor_gasto ? $valor_gasto->getValor() : '' ?>  " size="8" /></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            
            <?php endforeach; ?>
                <table style="width: 100%; margin-left: 40px; margin-top: 10px; font-size: 17px; font-weight: bold;">
                    <tr>
                        <td style="width: 50%">TOTAL</td>
                        <td>R$ <?php echo aplication_system::monedaFormat($total) ?></td>
                    </tr>
                </table>
        
        <?php endif; ?>
        <input type="submit" value="Salvar" />
    </form>
</div>
