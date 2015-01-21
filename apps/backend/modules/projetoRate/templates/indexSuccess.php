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

<div class="frameForm">

    <table id="resultsList">

        <thead>

            <tr>

                <th style="padding-left: 5px;width: 36%;">Funcionario</th>

                <th style="padding-left: 5px;width: 30%;">Cargo</th>

                <th style="padding-left: 5px; width: 12%;">Rate</th>

                <th style="width: 36%;">&nbsp;</th>

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

                        <td>

                            <?php if($rateFuncionario): ?>


                              <?php if($sf_user->getAttribute('nomeProfile') == 'Socio' || $sf_user->getAttribute('nomeProfile') == 'Administrador' || $sf_user->getAttribute('nomeProfile') == 'Root' || $projeto->getGerente() == aplication_system::getUser()): ?>     
                
                                <button name="save_rate_funcionario" id="save-<?php echo $rateFuncionario->getId() ?>" onclick="saveRate(<?php echo $rateFuncionario->getId() ?>)">Salvar</button>
            
                              <?php endif; ?>


                            <?php endif; ?>

                            

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="4"></td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div>

