<script type="text/javascript"> 
$(document).ready(function() {
      $('#voltar-lista').click(function(){
        parent.jQuery.fancybox.close();
      });
      $("#tarefa").validationEngine();
      $("#tarefa_DataIRTarefa").datepicker({   
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',        
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#tarefa_DataFRTarefa" ).datepicker( "option", "minDate", selectedDate );
            }
        });    
        $("#tarefa_DataFRTarefa").datepicker({
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',          
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#tarefa_DataIRTarefa" ).datepicker( "option", "maxDate", selectedDate );
                if(!$("#tarefa_DataIRTarefa").val())
                    {
                        $( "#tarefa_DataIRTarefa" ).val($("#tarefa_DataFRTarefa").val());
                    }
            }
        });
        <?php if(!$form->getObject()->isNew()): ?>
            $("#tarefa_DataIRTarefa").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataIrTarefa())) ?>');
            $("#tarefa_DataFRTarefa").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataFrTarefa())) ?>');
            <?php if(!$form->getObject()->getDataIrTarefa()) : ?>
                $("#tarefa_DataIRTarefa").val('');
            <?php endif; ?>
            <?php if(!$form->getObject()->getDataFrTarefa()) : ?>
                $("#tarefa_DataFRTarefa").val('');
            <?php endif; ?>
            
        <?php endif; ?>
	$('#add').click(function() {  
            return !$('#select1 option:selected').remove().appendTo('#select2');  
        });  
	$('#select1').dblclick(function() {  
            return !$('#select1 option:selected').remove().appendTo('#select2');  
        });  
	
        $('#remove').click(function() {  
            return !$('#select2 option:selected').remove().appendTo('#select1');  
        }); 
        
        $('#select2').dblclick(function() {  
            return !$('#select2 option:selected').remove().appendTo('#select1');  
        }); 
        <?php if(!$form->getObject()->isNew() && !$form->getObject()->getVisualizacao()): ?>
            $("#equipe-tarefa").hide();
        <?php elseif($form->getObject()->isNew()): ?>
            $("#equipe-tarefa").hide();
        <?php else: ?>
            $("#equipe-tarefa").show();
        <?php endif; ?>
        $('#tarefa_visualizacao').change(function() {  
            if($(this).val()==1){
                $("#equipe-tarefa").show();
            }else{
                $("#equipe-tarefa").hide();
            }
        });  
        
   
        $('#tarefa').submit(function() {  
            $('#select2 option').each(function() {  
                $(this).attr("selected", "selected");  
            });  
        
            $('#inline').click(function(){
                $.fancybox.close();
            });
        });  

       formatInputTiempoHoras($('#tarefa_HorasPrevistas'));
//       $('#tarefa_HorasPrevistas').keyup(function(){
//        if($(this).val().indexOf('.')!=-1){         
//            if($(this).val().split(".")[1].length > 1){                
//                if( isNaN( parseFloat( this.value ) ) ) return;
//                this.value = parseFloat(this.value).toFixed(1);
//            }  
//         }            
//         return this; //for chaining
//    });
        formatInputMoneda($('#tarefa_DespesaPrevista'));
        

        
})
</script>
<h1 class="tit-principal">edição de tarefa #<?php echo $sf_request->getParameter('codigotarefa') ?></h1>
<h2>Projeto <?php echo $codigoProjeto ?> </h2>
<div class="clear"></div>

<form id="tarefa" action="<?php echo url_for('tarefa/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?codigotarefa='.$form->getObject()->getCodigotarefa() : '')
    .($sf_request->getParameter('status_projeto') ? '&status_projeto=' . $sf_request->getParameter('status_projeto') : '')
    .($sf_request->getParameter('codigo_projeto') ? '&codigo_projeto=' . $sf_request->getParameter('codigo_projeto') : '')) ?>"
    method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="left">
  <br />
  <table width="100%">
      <tr>
        <td>
           &nbsp;<?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos')?>
        </td>
      </tr>
      <tr>
        <td id="errorGlobal">
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
      <?php if($edit): ?>
    <tfoot>
      <tr>
        <td>
            <?php echo $form->renderHiddenFields(false) ?>
            <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                            <a href="javascript:void(0);" id="voltar-lista" >Voltar à lista</a>    
                        </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                            <?php echo link_to(__('Eliminar'), 'tarefa/delete?codigotarefa='.$form->getObject()->getCodigotarefa(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Salvar') ?>" />
                    </td>
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <?php endif; ?>
    <tbody>
        <tr>
            <td>           
                <table cellpadding="0" cellspacing="2" border="0" width="100%" id="table-info">
                  <tr>
                      <?php if(count($arrayProjeto)>0):?>
                      <td><?php echo $form['tarefa_parent']->renderLabel() ?></td>
                      <td>
                        <?php echo $form['tarefa_parent'] ?>
                        <?php echo $form['tarefa_parent']->renderError() ?>
                      </td>
                      <?php endif; ?>
                      <td><?php echo $form['Descricao']->renderLabel() ?></td>
                      <td>
                            <?php echo $form['Descricao'] ?>
                            <?php echo $form['Descricao']->renderError() ?>
                      </td>
                  </tr>
                  
                  
                  <tr>
                      <td><?php echo $form['DataIRTarefa']->renderLabel() ?></td>
                      <td>
                            <?php echo $form['DataIRTarefa'] ?>
                            <?php echo $form['DataIRTarefa']->renderError() ?>
                      </td>
                      <td><?php echo $form['DataFRTarefa']->renderLabel() ?></td>
                      <td>
                        <?php echo $form['DataFRTarefa'] ?>
                        <?php echo $form['DataFRTarefa']->renderError() ?>
                      </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['id_prioridade']->renderLabel() ?></td>
                      <td>
                        <?php echo $form['id_prioridade'] ?>
                        <?php echo $form['id_prioridade']->renderError() ?>
                      </td>
<!--                  </tr>
                  <tr>
                      <td><?php // echo $form['DespesaPrevista']->renderLabel() ?></td>
                      <td>
                        <?php // echo $form['DespesaPrevista'] ?>
                        <?php // echo $form['DespesaPrevista']->renderError() ?>
                      </td>-->
                      <td><?php echo $form['Status']->renderLabel() ?></td>
                      <td>
                        <?php echo $form['Status'] ?>
                        <?php echo $form['Status']->renderError() ?>
                       </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['HorasPrevistas']->renderLabel() ?></td>
                      <td>
                        <?php echo $form['HorasPrevistas'] ?>
                        <?php echo $form['HorasPrevistas']->renderError() ?>
                      </td>
                      <td><?php echo $form['visualizacao']->renderLabel() ?></td>
                      <td>
                        <?php echo $form['visualizacao'] ?>
                        <?php echo $form['visualizacao']->renderError() ?>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="4">
                          <h3>Equipe da Tarefa</h3>
                          <div id="equipe-tarefa">
                            <?php $funcionarios = LxUserPeer::getFuncionarios($sf_user->getAttribute('idUserPanel')) ?>
                            <div class="op_select" style="float: left; margin-right: 15px;">  
                                <label>Funcionarios</label><br />
                                  <select class="select-func" multiple id="select1">  
                                      <?php foreach ($funcionarios as $fun) : ?>
                                          <?php if(!EquipeTarefaPeer::getCheck($sf_request->getParameter('codigotarefa'), $fun->getIdUser())): ?>
                                              <option value="<?php echo $fun->getIdUser() ?>"><?php echo $fun->getName() ?></option>  
                                          <?php endif; ?>
                                      <?php endforeach; ?>                                    
                                  </select>  
                                  <a href="#" id="add">Adicionar &gt;&gt;</a>  
                             </div>  
                             <div class="op_select" style="float: left;">  
                                 <label>Associados á Tarefa</label><br />
                                 <?php $equipo = EquipeTarefaPeer::getEquipeTarefa($sf_request->getParameter('codigotarefa')) ?>
                                 <select class="select-func" multiple id="select2" name="select2[]">
                                      <?php foreach ($equipo as $fun) : ?>
                                          <?php $usu = LxUserPeer::retrieveByPK($fun->getCodigofuncionario()) ?>
                                          <option value="<?php echo $usu->getIdUser() ?>"><?php echo $usu->getName() ?></option>  
                                      <?php endforeach; ?>  
                                 </select>  
                                 <a href="#" id="remove">&lt;&lt; Excluir</a>  
                             </div> 
                           </div>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="4"><?php echo $form['informacoes']->renderLabel() ?><br />
                        <?php echo $form['informacoes'] ?>
                        <?php echo $form['informacoes']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td colspan="4">
                          &nbsp;
                      </td>
                  </tr>
                </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
