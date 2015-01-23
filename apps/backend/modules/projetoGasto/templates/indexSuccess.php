<script type="text/javascript"> 

$(document).ready(function() {

    formatInputMoneda($('.valorgasto'));

});

</script>

<h1 class="tit-principal">Gastos Previstos - Projeto <?php echo $projeto->getCodigoSgwsProjeto() ?></h1>

<div class="frameForm"><style>
  #contentPpal{
    min-width: 0px !important;
    width: 0% !important;
  }
  .requerido{
    display: block;
    height: 42px;
    padding:10px 5px;
  }
  .container{
    width: 100%;
  }
  .divtitles{
    margin-right: 10px;
    display: inline-block;
    width: 135px;
    vertical-align: middle !important;
  }
  .divcontens{
    display: inline-block;
  }
  .row{
    /*vertical-align: middle;*/
    /*margin-bottom: 10px;*/
    padding:5px 0px 5px 20px;
  }
  .grey{
    background: #eee;
  }
</style>

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
                                <?php if($sf_user->getAttribute('nomeProfile') == 'Socio' || $sf_user->getAttribute('nomeProfile') == 'Administrador' || $sf_user->getAttribute('nomeProfile') == 'Root' || $projeto->getGerente() == aplication_system::getUser()): ?>
                                    <td><input type="text" class="valorgasto" name="subtipo-<?php echo $subt['id'] ?>" value="<?php echo $valor_gasto ? $valor_gasto->getValor() : '' ?>  " size="8" /></td>
                                <?php else: ?>
                                    <td><input type="text" class="valorgasto" name="subtipo-<?php echo $subt['id'] ?>" value="<?php echo $valor_gasto ? $valor_gasto->getValor() : '' ?>  " size="8" readonly/></td>
                                <?php endif; ?>
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
            <?php if($sf_user->getAttribute('nomeProfile') == 'Socio' || $sf_user->getAttribute('nomeProfile') == 'Administrador' || $sf_user->getAttribute('nomeProfile') == 'Root' || $projeto->getGerente() == aplication_system::getUser()): ?>     
                <input type="submit" value="Salvar" />
            <?php endif; ?>

    </form>

</div>

