<?php use_helper('Date') ?>
<?php use_javascript('jq/jquery.bpopup.min.js') ?>
<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>
<?php use_javascript('fancybox/jquery.fancybox.js') ?>
<script type="text/javascript" src="/js/jq/jquery.validationEngine.js"></script>
<script type="text/javascript" src="/js/jq/jquery.validationEngine-en_US.js"></script>
<script type="text/javascript" src="/js/jq/jquery.price_format.1.8.js"></script>

<script type="text/javascript"> 
$(document).ready(function() {
    
    $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false});
    $(".tiempo-horas").attr('disabled','disabled');
    formatInputTiempoHoras($(".tiempo-horas"));
    $("a.button-left, a.button-right").click(function () {
        var valor = $(this).attr("id");
        $("#val").val(valor);
        $("#recalcula_time").submit();
    }); 
    cargaTerefasUser($("#fecha-inicio-semana").val(),$("#val").val());
})
function openDes(id, fila)
{
    if($("#cod_tarefa_" + fila).val())
        {
            $('#popup-' + id).bPopup();
            
        }
}
</script>
<style type="text/css">
    .fancybox-custom .fancybox-skin {
            box-shadow: 0 0 50px #222;
    }
</style>
<h1 class="icono_projeto">
    <a href="<?php echo url_for('@default_index?module=projeto') ?> ">projetos</a> / Time Sheet</h1>

<?php include_partial('global/menuProjeto') ?>

<table style="width: 100%;">
    <caption style="text-align: right;">
        Última atualização da semana: <?php echo format_date($dateWeek, 'D', 'pt')  ?>
    </caption>
    <tr>
        <td>
            <form method="post" id="recalcula_time" action="<?php echo url_for('@default?module=tarefa&action=timeSheet') ?>" >
            <div class="filtro-semanas">                
                    <input type="hidden" name="val" id="val" value="<?php echo $start ?>" />
                    <div style="float: left; width: 40px; text-align: center;">
                        <a class="button-left" href="javascript:void(0);" id="dec_<?php echo $start ?>">
                            <?php echo image_tag('icons/navigation-left','width="20"') ?>
                        </a>
                    </div>
                    <div id="semana_activa" style="float: left">
                        Semana de <?php echo date("d-m-Y", strtotime($start)) ?> até <?php echo date("d-m-Y", strtotime($end)) ?>
                    </div>
                    <div style="float: left; width: 40px; text-align: center;">
                        <a class="button-right" href="javascript:void(0);" id="inc_<?php echo $start ?>" >
                            <?php echo image_tag('icons/navigation-right','width="20"') ?>
                        </a>
                    </div>
                
            </div>
            <div style="float: left; padding-top: 3px;" >    
                    <label>Número de linhas</label>
                    <select name="carga_filas" id="carga_filas" onchange="this.form.submit()">
                        <?php for($o = 1; $o <= 10; $o++): ?>
                            <option value="<?php echo $o; ?>" <?php echo $sf_request->getParameter('carga_filas') == $o ? 'selected="selected"' : '' ?> ><?php echo $o ?></option>
                        <?php endfor; ?>
                    </select>
                </form>
            </div>
            </form>                
        </td>
    </tr>
</table> 
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <caption>
      <div id="result"></div>
      <input type="hidden" name="fecha-inicio-semana" id="fecha-inicio-semana" value="<?php echo $start ?>" size="10" />
      <input type="hidden" name="fecha-fin-semana" id="fecha-fin-semana" value="<?php echo $end ?>" size="10" />
      <?php $fecha_inicio = $start ?>
  </caption>
  <thead>
    <tr>
        <th style="width: 8%; padding-left: 10px;">PROJETO</th>
        <th style="width: 18%;">TAREFA</th>
        <th style="width: 10%;">Segunda</th>
        <th style="width: 10%;">Terça</th>
        <th style="width: 10%;">Quarta</th>
        <th style="width: 10%;">Quinta</th>
        <th style="width: 10%;">Sexta</th>
        <th style="width: 10%;">Sábado</th>
        <th style="width: 10%;">Domingo</th>
    </tr>
  </thead>
  <tbody>
      <?php for($fl = 1; $fl <= $filas; $fl++): ?>
      <?php $start = $fecha_inicio; ?>
      <tr>
          <td class="borderBottomDarkGray">
              <select onchange="javascript:cargaTareas(<?php echo $fl ?>, <?php echo $filas ?>)" id="cod_projeto_<?php echo $fl ?>" name="cod_projeto_<?php echo $fl ?>" >
                <option value="">Selecione Projeto</option>
                <?php foreach ($projetosUsuario as $projet): ?>
                    <option value="<?php echo $projet['id_projeto'] ?>"><?php echo $projet['codigo_projeto'] ?></option>
                <?php endforeach; ?>
              </select>              
              <input type="hidden" name="cod_projeto" id="cod_projeto_<?php echo $fl ?>" value="1" />
          </td>
          
          <td class="borderBottomDarkGray">
              <select class="ct" onchange="javascript:cargaActividades(<?php echo $fl ?>, <?php echo $filas ?>);" style="width: 215px;" id="cod_tarefa_<?php echo $fl ?>" name="cod_tarefa_<?php echo $fl ?>" >
                <option value="">Selecione</option>
              </select>              
          </td>
          <td class="borderBottomDarkGray">
              <?php //echo $start ?>              
              <input type="text" name="h" id="h-0<?php echo $fl ?>" value="" size="5" class="tiempo-horas fila-<?php echo $fl ?> col-0"  />
              
              <a onclick="javascript:openDes('0<?php echo $fl ?>',<?php echo $fl ?>);" href="javascript:void(0);"><?php echo image_tag('icons/icon_obs') ?></a> 
              <div id="popup-0<?php echo $fl ?>" class="popup">
                <span class="button b-close"><span>X</span></span>
                <label><?php echo format_date($start, 'D', 'pt')  ?></label><br />
                <textarea cols="50" rows="4" id="descricao-0<?php echo $fl ?>">
                    
                </textarea><br />
                <button class="save" id="save_descricao-0<?php echo $fl ?>" onclick="$('#popup-0<?php echo $fl ?>').bPopup().close();" >Salvar</button>
             </div>
              <input type="hidden" name="fecha-0" id="fecha-0<?php echo $fl ?>" value="<?php echo $start ?>" size="3" />
              <script type="text/javascript">
                $(document).ready(function() {
                    $('#h-0<?php echo $fl ?>, #descricao-0<?php echo $fl ?>').blur(function(e) {
                        e.preventDefault();
                        calcular_total();
                        cargaTerefasUser($("#fecha-inicio-semana").val(),$("#val").val());
                        <?php echo jq_remote_function(array(
                          'update'   => 'h-0'.$fl,
                          'url'      => 'tarefa/registraTimeSheet',
                          'method'   => 'post',
                          'with'     => "'cod_projeto='+$('#cod_projeto_".$fl."').val() + '&cod_tarea=' + $('#cod_tarefa_".$fl."').val() +  '&horas='+$('#h-0".$fl."').val() + '&des=' + $('#descricao-0".$fl."').val() + '&fecha=' + $('#fecha-0".$fl."').val()",
                          'loading'  => "$('#loader').show();",
                          'complete' => "$('#loader').hide();"
                        )); ?>
                        
                    });
                })
              </script>
          </td>          
          <?php for($i = 1; $i <=6 ; $i++): ?>
            <?php $start = date("Y-m-d", strtotime("$start + 1 day")); ?>
            <td class="borderBottomDarkGray">
                <?php //echo $start ?>
                <div id="popup-<?php echo $i.$fl ?>" class="popup">
                    <span class="button b-close"><span>X</span></span>
                    <label><?php echo format_date($start, 'D', 'pt')  ?></label><br />
                    <textarea cols="50" rows="4" id="descricao-<?php echo $i.$fl ?>"></textarea>
                    <br />
                    <button class="save" id="save_descricao-<?php echo $i.$fl ?>" onclick="$('#popup-<?php echo $i.$fl ?>').bPopup().close();" >Salvar</button>
                </div>
                <input type="hidden" name="fecha-<?php echo $i.$fl ?>" id="fecha-<?php echo $i.$fl ?>" value="<?php echo $start ?>" size="3" />
                <input type="text" name="h" id="h-<?php echo $i.$fl ?>" value="" size="3" class="tiempo-horas fila-<?php echo $fl ?> col-<?php echo $i ?>" />
                <a onclick="javascript:openDes('<?php echo $i.$fl ?>',<?php echo $fl ?>);" href="javascript:void(0);"><?php echo image_tag('icons/icon_obs') ?></a>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#h-<?php echo $i.$fl ?>, #descricao-<?php echo $i.$fl ?>').blur(function() {
                            calcular_total();
                            cargaTerefasUser($("#fecha-inicio-semana").val(),$("#val").val());
                            <?php echo jq_remote_function(array(
                              'update'   => 'h-'.$i.$fl,
                              'url'      => 'tarefa/registraTimeSheet',
                              'method'   => 'post',
                              'with'     => "'cod_projeto='+$('#cod_projeto_".$fl."').val() + '&cod_tarea=' + $('#cod_tarefa_".$fl."').val() + '&horas='+$('#h-".$i.$fl."').val() + '&des=' + $('#descricao-".$i.$fl."').val() + '&fecha=' + $('#fecha-".$i.$fl."').val()",
                              'loading'  => "$('#loader').show();",
                              'complete' => "$('#loader').hide();"
                            )); ?>                            
                        });
                    })
                </script>
            </td>
          <?php endfor; ?>
      </tr>
      <?php endfor; ?>
      <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <?php for($sub = 0; $sub <= 6; $sub++): ?>
            <td><div class="subtotal-act" id="tot-<?php echo $sub ?>"></div></td>
          <?php   endfor; ?>
      </tr>
      <tr>
          <td class="borderBottomDarkGray" colspan="10" style="text-align: right;">
              <table style="float: right; margin-right: 30px;">
                  <tr>
                      <td>
                          <div id="loader" style="background-color: #006699; color: #FFF; display: none;">
                                Carregando
                          </div>
                          <h3> Total de Horas:</h3>
                      </td>
                      <td><div id="total_horas_semana">0</div></td>
                  </tr>
              </table>
          </td>
      </tr>
      <tr>
          <td class="borderBottomDarkGray" colspan="10" style="text-align: right; display: none;">
              <input type="submit" value="<?php echo __('Enviar') ?>" />
          </td>
      </tr>
  </tbody>
  <!--cierree timeShipt-->
<h1>
    <a href="<?php echo url_for('@default_index?module=projeto') ?> ">Time Sheet</a> / Tarefas 
</h1>

<div class="frameForm">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td>
                <form action="<?php echo url_for('tarefa/filtroTimeSheet') ?>" method="POST" id="filtroTimeShit">
                    <div class="propiedades propiedades-extend" style="width: 100%; border: 0px; height: 80px;">
                        <h2 class="titulo"><?php echo __('Filtros') ?></h2>
                        <table width="100%" >
                            <tr>
                                <td width="12%" style="padding-left: 15px;">
                                    <label style="color: #333; font-weight: bold;">Projeto</label><br />

                                    <select name="projeto" id="projeto">
                                        <option value="" >Todos os Projetos </option>
                                       <?php foreach ($projetos  as $projet): ?>
                                           <option value="<?php echo $projet['id_projeto'] ?>">
                                               <?php echo $projet['codigo_projeto'].' -- '. $projet['nombre_projeto']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="width: 9%;">
                                    <label style="color: #333; font-weight: bold;"> <?php echo __('De') ?></label><br />
                                    <input size="8" type="text" name="from_date" id="from_date" value="<?php echo $sf_request->getParameter('from_date') ?>" >
                                </td>
                                <td style="width: 9%;">
                                    <label style="color: #333; font-weight: bold;"> <?php echo __('Até') ?></label><br />
                                    <input size="8" type="text" name="to_date" id="to_date" value="<?php echo $sf_request->getParameter('to_date') ?>" >
                                </td>
                                <td align="left"><br />
                                    <input type="submit" name="buscar" id="buscar" value="Buscar" />
                                </td>
                            </tr>            
                        </table>
                    </div>
                </form>
            </td>
        </tr>
    </table>
    <br />
    <!--cierre filtro-->
    <table width="100%" cellpadding='0' cellspacing="0" id="resultsList">
        <thead>
        <th style="width: 10%;">Data</th>
        <th style="width: 25%;">Projeto</th>
        <th style="width: 10%;">Tarefa</th>
        <th style="width: 10%;">Hs. Trab</th>
        <th style="width: 25%;">Descrição</th>
        <th style="width: 5%;">GP</th>
        <th style="width: 15%;">Ações</th>
        </thead>
        <tbody>
            <?php
            $arrSemana = array(1 => "Segunda", 2 => " Terça", 3 => "Quarta", 4 => "Quinta", 5 => "Sexta", 6 => "Sábado", 7 => "Domingo");
            $i = 1;
            $suma = 0;
            ?>

            <?php if ($tarefas): ?>

    <?php foreach ($tarefas as $tarefa) : ?>
                    <tr>
                        <td class="borderBottomDarkGray"> <?php echo $valida->formatoFechaPT2($tarefa->getDataReal()) ?></td>
                        <td class="borderBottomDarkGray"> 
                            <?php $tare = TarefaPeer::retrieveByPK($tarefa->getCodigoTarefa()); ?> 
                            <?php
                            if($projeto != ""){
                            $prop = PropostaPeer::retrieveByCodeProjecto($projeto);
                            echo $prop->getCodigoSgwsProjeto() . "--";
                            echo $prop->getNomeProposta();
                            }else{
                                if($tare){$prop = PropostaPeer::retrieveByCodeProjecto($tare->getCodigoprojeto()); 
                                            if($prop){
                                               if($prop->getCodigoSgwsProjeto()){
                                               echo $prop->getCodigoSgwsProjeto() . "--";
                                               }
                                                echo $prop->getNomeProposta();
                                              }
                                        }
                            }
                            ?> 
                        </td>
                        <td class="borderBottomDarkGray">
                            <?php $tareDescripcion = TarefadescricaoPeer::retrieveByPK($tare->getDescricao()); ?> 
                            <?php echo $tareDescripcion->getTarefa(); ?>
                        </td>
                        <td class="borderBottomDarkGray">
                            <?php echo $tarefa->getTempogasto(); ?>
                            <?php $suma = $suma + $tarefa->getTempogasto(); ?>
                        </td>
                        <td class="borderBottomDarkGray">
                            <?php echo substr($tarefa->getObservacoes(), 0, 50) ?>...
                        </td>
                        <td class="borderBottomDarkGray" id="status_<?php echo $tarefa->getCodigoregistro() ?>">
                            <?php $gerenteProyecto = PropostaPeer::getGerenteProjeto($tare->getCodigoprojeto()); ?>
                            <?php $st = $tarefa->getAutorizado() ? '1' : '0'; ?>
                            <!-- Solo pueden aprobar las actividades el gerente del proyecto y todos los perfiles socios 13-01-2014  -->
                            <?php if (aplication_system::getUser() == $gerenteProyecto || aplication_system::esSocio()): ?>
                                <?php
                                echo jq_link_to_remote(image_tag($st . '.png', 'alt="" title="" border=0'), array(
                                    'update' => 'status_' . $tarefa->getCodigoregistro(),
                                    'url' => 'tarefa/autorizaActividad?id_actividad=' . $tarefa->getCodigoregistro() . '&status=' . $tarefa->getAutorizado(),
                                    'script' => true,
                                    'before' => "$('#status_" . $tarefa->getCodigoregistro() . "').html('" . image_tag('preload.gif', 'title="" alt=""') . "');"
                                ));
                                ?>
                            <?php else: ?>
                                <?php echo image_tag($st . '.png', 'alt="" title="" border=0') ?>
        <?php endif; ?>
                        </td>
                        <td class="borderBottomDarkGray">
        <?php if ((aplication_system::compareUserVsResponsable($tarefa->getCodigoFuncionario()) && !$tarefa->getAutorizado() ) || aplication_system::getUser() == $gerenteProyecto || aplication_system::esSocio()): ?>
                                <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=activity&codigotarefa=' . $tarefa->getCodigoTarefa() . '&id_actividad=' . $tarefa->getCodigoregistro()) ?>">Editar</a>
                                &nbsp;|&nbsp;<?php echo link_to(__('Delete'), 'tarefa/deleteActivity?id_actividad=' . $tarefa->getCodigoregistro(), array('method' => 'delete', 'class' => 'delete', 'confirm' => __('Tem certeza de que deseja excluir os dados selecionados?'))) ?>
                    <?php endif; ?>
                        </td>
                    </tr>
        <?php $i++; ?>
    <?php endforeach; ?>
<?php endif; ?>

            <tr>
                <td colspan="3" class="borderBottomDarkGray"> <h3>Total de horas trabalhadas na semana:</h3></td>
                <td class="borderBottomDarkGray"><h3><?php echo $suma; ?></h3></td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
</div>
<input type="hidden" id="idProje" value="<?php echo $sf_request->getParameter('projeto') ?>">
<script type="text/javascript">
    $(document).ready(function() {

    $("#buscar").click(function(data) {
    
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        
            $.post(formURL, function( data ) {
            $("#tarefas_user",{postData:postData}).html(data);
          });
            //e.preventDefault(); //STOP default action
            //e.unbind(); //unbind. to stop multiple form submit.
    });
    
        if ($('#idProje').val() != ""){
    var idProje = $('#idProje').val();
            $("#projeto option[value=" + idProje + "]").attr("selected", true);
    }
    $("#from_date").datepicker({
    defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            onClose: function(selectedDate) {
            $("#to_date").datepicker("option", "minDate", selectedDate);
            }
    });
            $("#to_date").datepicker({
    defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            onClose: function(selectedDate) {
            $("#from_date").datepicker("option", "maxDate", selectedDate);
                    if (!$("#from_date").val())
            {
            $("#from_date").val($("#to_date").val());
            }
            }
    });
});
</script>