<?php use_helper('Date') ?>
<?php use_javascript('jq/jquery-1.4.2.min.js') ?>
<script type="text/javascript" src="/js/jq/jquery.validationEngine.js"></script>
<script type="text/javascript" src="/js/jq/jquery.validationEngine-en_US.js"></script>
<script type="text/javascript" src="/js/jq/jquery.price_format.1.8.js"></script>
<?php use_javascript('jq/jquery.bpopup.min.js') ?>

<script type="text/javascript"> 
$(document).ready(function() {
    
    $(".tiempo-horas").attr('disabled','disabled');
    formatInputTiempoHoras($(".tiempo-horas"));
    $("a.button-left, a.button-right").click(function () {
        var valor = $(this).attr("id");
        $("#val").val(valor);
        $("#recalcula_time").submit();
        
    }); 
    
})
function openDes(id, fila)
{
    if($("#cod_tarefa_" + fila).val())
        {
            $('#popup-' + id).bPopup();
            
        }
}
</script>

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
                          Total de horas trabalhadas na semana: 
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
</table>