    <h1 class="icono_projeto">
        <a href="<?php echo url_for('@default_index?module=projeto') ?> ">Time Sheet</a> / Tarefas 
    </h1>

    <div class="frameForm">
        <!--cierre filtro-->
        <table width="100%" cellpadding='0' cellspacing="0" id="resultsList">
            <thead>
                <th>Data</th>
                <th>Prjeto</th>
                <th>Tarefa</th>
                <th>Hs. Trab</th>
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
                            <td> <?php echo $tarefa->getDataReal();?></td>
                            <td> 
                                   <?php $tare = TarefaPeer::retrieveByPK($tarefa->getCodigoTarefa()); ?> 
                                
                                   <?php if($tare){$prop = PropostaPeer::retrieveByPK($tare->getCodigoprojeto()); 
                                            if($prop){
                                                echo $prop->getNomeProposta();
                                                }
                                        }
                                    ?> 
                            </td>
                            <td>
                                <?php $tareDescripcion = TarefadescricaoPeer::retrieveByPK($tare->getDescricao()); ?> 
                                <?php echo $tareDescripcion->getTarefa();?>
                            </td>
                            <td>
                                <?php echo  $tarefa->getTempogasto();?>
                                <?php $suma =  $suma + $tarefa->getTempogasto();?>
                            </td>
                            <td class="borderBottomDarkGray" id="status_<?php echo $tarefa->getCodigoregistro() ?>">
                            <?php $st = $tarefa->getAutorizado() ? '1' : '0' ; ?>
                            <!-- Solo pueden aprobar las actividades el gerente del proyecto y todos los perfiles socios 13-01-2014  -->
                            <?php if(aplication_system::esSocio()): ?>
                                <?php echo jq_link_to_remote(image_tag($st.'.png','alt="" title="" border=0'), array(
                                    'update'  =>  'status_'.$tarefa->getCodigoregistro(),
                                    'url'     =>  'tarefa/autorizaActividad?id_actividad='.$tarefa->getCodigoregistro().'&status='.$tarefa->getAutorizado(),
                                    'script'  => true,
                                    'before'  => "$('#status_".$tarefa->getCodigoregistro()."').html('". image_tag('preload.gif','title="" alt=""')."');"
                                ));
                                ?>
                            <?php else: ?>
                                <?php echo image_tag($st.'.png','alt="" title="" border=0') ?>
                            <?php endif; //|| aplication_system::getUser() == $gerenteProyecto?>
                        </td>
                        <td class="borderBottomDarkGray">
                            <?php if((aplication_system::compareUserVsResponsable($tarefa->getCodigoFuncionario()) && !$tarefa->getAutorizado() ) || aplication_system::esSocio() ): ?>
                                <?php echo link_to(__('Editar'),'tarefa/activity?codigotarefa='.$tarefa->getCodigoTarefa().'&id_actividad='.$tarefa->getCodigoregistro() ) ?>
                            &nbsp;|&nbsp;<?php echo link_to(__('Delete'),'tarefa/deleteActivity?id_actividad='.$tarefa->getCodigoregistro(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que deseja excluir os dados selecionados?'))) ?>
                            <?php endif; ?>
                        </td>
                        </tr>
                     <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td colspan="3"> <h3>Total Hs. Trab:</h3></td>
                    <td><h3><?php echo $suma; ?></h3></td>
                </tr>
            </tbody>
        </table>
    </div>