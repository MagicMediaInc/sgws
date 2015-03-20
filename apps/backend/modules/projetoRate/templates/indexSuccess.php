<script type="text/javascript"> 

$(document).ready(function() {

    $('#resultsList td').addClass('borderBottomDarkGray');

    formatInputMoneda($('.valorgasto'));

});



function saveRate(id)

{

    var rate = $("#rate-" + id).val();

    $.ajax({

          type: "POST",

          url:  url + "ajax/updateRate",

          data: {id : id, rate : rate},

          dataType: "html",

          beforeSend: function(objeto){

              $("#save-" + id ).html("Salvando dados");

              $("#save-" + id ).attr('disabled', true);

          },

          success: function(msg){

              $("#save-" + id ).removeAttr('disabled');

              $("#save-" + id ).html("Salvar");

          }

        });

}

</script>

<h1 class="tit-principal">Registro de Rate para o Projeto <a href="<?php echo url_for('@default?module=projeto&action=edit&codigo_proposta='.$projeto->getCodigoProposta() ) ?>"><?php echo $projeto->getCodigoSgwsProjeto() ?></a></h1>

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

  <?php $totalHorasTrabajadas = 0; $totalValor = 0; ?>

    <table id="resultsList">

        <thead>

            <tr>

                <th style="padding-left: 5px;width: 26%;">Funcionario</th>

                <th style="padding-left: 5px;width: 20%;">Cargo</th>

                <th style="padding-left: 5px; width: 12%;">Rate</th>

                <th style="padding-left: 5px; width: 12%;">Horas Trabajadas</th>

                <th style="padding-left: 5px; width: 12%;">Valor</th>

                <th style="width: 6%;">&nbsp;</th>

            </tr>

        </thead>

        <tbody>

            <?php if($funcionarios): ?>

                <?php foreach ($funcionarios as $dato) : ?>

                    <?php $rateFuncionario = RatePeer::getRateFuncionarioProjeto($dato['funcionario'], $sf_request->getParameter('id_projeto')) ?>

                    <tr>

                        <td><?php echo $dato['name'] ?></td>

                        <td>

                            <?php echo $rateFuncionario ? $rateFuncionario->getCargo() : '' ?>

                        </td>

                        <td>

                            <?php if($rateFuncionario): ?>

                              <?php if($sf_user->getAttribute('nomeProfile') == 'Socio' || $sf_user->getAttribute('nomeProfile') == 'Administrador' || $sf_user->getAttribute('nomeProfile') == 'Root' || $projeto->getGerente() == aplication_system::getUser()): ?>    

                                <input size="8" class="valorgasto" type="text" name="rate" id="rate-<?php echo $rateFuncionario->getId() ?>" value="<?php echo $rateFuncionario ? $rateFuncionario->getRate() : '' ?>" />                            

                              <?php else: ?>

                                <input size="8" class="valorgasto" type="text" name="rate" id="rate-<?php echo $rateFuncionario->getId() ?>" value="<?php echo $rateFuncionario ? $rateFuncionario->getRate() : '' ?>" readonly/>                            

                              <?php endif; ?>

                            <?php else: ?>

                                <span style="color: red">Usuário não tem rate para este projeto</span>

                            <?php endif; ?>

                        </td>

                        <td style="text-align:right;">

                        <?php

                          $horasTrabajadas = TempotarefaPeer::getHorasTrabajadasFuncionarioProjeto($dato['funcionario'], $sf_request->getParameter('id_projeto'));
                          $horasTrabajadas != null ? $totalHorasTrabajadas += $horasTrabajadas : $totalHorasTrabajadas += 0;
                          echo number_format($horasTrabajadas != null ? $horasTrabajadas : 0, 1, ',', '.') ;

                        ?>

                        </td>

                        <td style="text-align:right;">

                            <?php if($rateFuncionario): ?>

                              R$ <?php echo $horasTrabajadas != null ? number_format($horasTrabajadas*$rateFuncionario->getRate(), 2, ',', '.') : '0,00' ?>
                              <?php $horasTrabajadas != null ? $totalValor += $horasTrabajadas*$rateFuncionario->getRate() : $totalValor += 0 ?>

                            <?php else: ?>

                                <span style="color: red">Usuário não tem rate para este projeto</span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php if($rateFuncionario): ?>


                              <?php if($projeto->getStatus() < 6 AND ($sf_user->getAttribute('nomeProfile') == 'Socio' || $sf_user->getAttribute('nomeProfile') == 'Administrador' || $sf_user->getAttribute('nomeProfile') == 'Root' || $projeto->getGerente() == aplication_system::getUser())): ?>     
                
                                <button name="save_rate_funcionario" id="save-<?php echo $rateFuncionario->getId() ?>" onclick="saveRate(<?php echo $rateFuncionario->getId() ?>)">Salvar</button>
            
                              <?php endif; ?>


                            <?php endif; ?>

                            

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="6"></td>

                </tr>

            <?php endif; ?>

            <tr>
              
              <td style="text-align:left;font-weight:bold;" colspan="3">Total: </td>
              <td style="text-align:right;font-weight:bold;"><?php echo number_format($totalHorasTrabajadas, 1, ',', '.') ?></td>
              <td style="text-align:right;font-weight:bold;">R$ <?php echo number_format($totalValor, 2, ',', '.') ?></td>
              <td></td>

            </tr>

        </tbody>

    </table>

</div>

