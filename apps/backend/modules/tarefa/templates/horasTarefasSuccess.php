<?php use_javascript('jq/jquery-1.4.2.min.js') ?>
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
                                    <input size="8" required="required" type="text" name="from_date" id="from_date" value="<?php echo $sf_request->getParameter('from_date') ?>" >
                                </td>
                                <td style="width: 9%;">
                                    <label style="color: #333; font-weight: bold;"> <?php echo __('Até') ?></label><br />
                                    <input size="8" required="required" type="text" name="to_date" id="to_date" value="<?php echo $sf_request->getParameter('to_date') ?>" >
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
                <?php $arrSemana = array(1 =>"Segunda",2 =>" Terça",3=>"Quarta",4=>"Quinta",5=>"Sexta",6=>"Sábado",7=>"Domingo");
                $i = 1; 
                $suma = 0;
                ?>
                
                <?php if($tarefas): ?>
                
                    <?php foreach ( $tarefas as $tarefa) : ?>
                        <tr>
                            <td class="borderBottomDarkGray"> <?php echo $valida->formatoFechaPT2($tarefa->getDataReal())?></td>
                            <td class="borderBottomDarkGray"> 
                                   <?php $tare = TarefaPeer::retrieveByPK($tarefa->getCodigoTarefa()); ?> 
                                
                                   <?php if($tare){$prop = PropostaPeer::retrieveByCodeProjecto($tare->getCodigoprojeto()); 
                                            if($prop){
                                               if($prop->getCodigoSgwsProjeto()){
                                               echo $prop->getCodigoSgwsProjeto() . "--";
                                               }
                                                echo $prop->getNomeProposta();
                                              }
                                        }
                                    ?> 
                            </td>
                            <td class="borderBottomDarkGray">
                                <?php $tareDescripcion = TarefadescricaoPeer::retrieveByPK($tare->getDescricao()); ?> 
                                <?php echo $tareDescripcion->getTarefa();?>
                            </td>
                            <td class="borderBottomDarkGray">
                                <?php echo  $tarefa->getTempogasto();?>
                                <?php $suma =  $suma + $tarefa->getTempogasto();?>
                            </td>
                            <td class="borderBottomDarkGray">
                            <?php echo substr($tarefa->getObservacoes(), 0,50)  ?>...
                             </td>
                            <td class="borderBottomDarkGray" id="status_<?php echo $tarefa->getCodigoregistro() ?>">
                            <?php $gerenteProyecto = PropostaPeer::getGerenteProjeto($tare->getCodigoprojeto());?>
                            <?php $st = $tarefa->getAutorizado() ? '1' : '0' ; ?>
                            <!-- Solo pueden aprobar las actividades el gerente del proyecto y todos los perfiles socios 13-01-2014  -->
                            <?php if(aplication_system::getUser() == $gerenteProyecto || aplication_system::esSocio()): ?>
                                <?php echo jq_link_to_remote(image_tag($st.'.png','alt="" title="" border=0'), array(
                                    'update'  =>  'status_'.$tarefa->getCodigoregistro(),
                                    'url'     =>  'tarefa/autorizaActividad?id_actividad='.$tarefa->getCodigoregistro().'&status='.$tarefa->getAutorizado(),
                                    'script'  => true,
                                    'before'  => "$('#status_".$tarefa->getCodigoregistro()."').html('". image_tag('preload.gif','title="" alt=""')."');"
                                ));
                                ?>
                            <?php else: ?>
                                <?php echo image_tag($st.'.png','alt="" title="" border=0') ?>
                            <?php endif; ?>
                        </td>
                        <td class="borderBottomDarkGray">
                            <?php if((aplication_system::compareUserVsResponsable($tarefa->getCodigoFuncionario()) && !$tarefa->getAutorizado() ) || aplication_system::getUser() == $gerenteProyecto || aplication_system::esSocio() ): ?>
                            <a class="fancybox fancybox.iframe"  href="<?php echo url_for('@default?module=tarefa&action=activity&codigotarefa='.$tarefa->getCodigoTarefa().'&id_actividad='.$tarefa->getCodigoregistro()) ?>">Editar</a>
                            &nbsp;|&nbsp;<?php echo link_to(__('Delete'),'tarefa/deleteActivity?id_actividad='.$tarefa->getCodigoregistro(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que deseja excluir os dados selecionados?'))) ?>
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
    //$("#filtroTimeShit").submit(); 
    
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