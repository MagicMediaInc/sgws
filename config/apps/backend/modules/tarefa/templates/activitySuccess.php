<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript"> 
$(document).ready(function() {
      $("#activity").validationEngine();
      
      
      $("#reg_activity_data").datepicker({   
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',        
            changeMonth: true,
            changeYear: true
      });    
      
      formatInputTiempoHoras($('#reg_activity_horas_trabajadas'));
        
});
</script>
<h1 class="tit-principal">Inclusão de Atividade</h1>
<form id="activity" action="<?php echo url_for('tarefa/regActivity'.($sf_request->getParameter('id_actividad') ? '?id_actividad='.$sf_request->getParameter('id_actividad').'&codigotarefa='.$sf_request->getParameter('codigotarefa') : '?codigotarefa='.$sf_request->getParameter('codigotarefa') )) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<div class="frameForm" align="left">
  <table width="100%">
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
                            <?php echo link_to(__('Voltar à lista de atividades'), '@default?module=tarefa&action=listActivity&codigotarefa='.$sf_request->getParameter('codigotarefa'), array('class' => 'button')) ?>
                        </div>
                    </td>            
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
                <table cellpadding="0" cellspacing="2" border="0" width="100%">
                  
                  <tr>
                      <td colspan="2"><label>Tarefa</label><br />
                          <div class="mask-imput" style="width: 300px;">
                             <?php echo $descricao->getTarefa() ?>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2"><?php echo $form['funcionario']->renderLabel() ?><br />
                        <?php echo $form['funcionario'] ?>
                        <?php echo $form['funcionario']->renderError() ?>
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 4%;"><?php echo $form['data']->renderLabel() ?><br />
                        <?php echo $form['data']->render(array('value' => $dataActividad)) ?>
                        <?php echo $form['data']->renderError() ?>
                      </td>
                      
                  </tr>
                  <tr>
                      <td><?php echo $form['horas_trabajadas']->renderLabel() ?><br />
                        <?php echo $form['horas_trabajadas'] ?>
                        <?php echo $form['horas_trabajadas']->renderError() ?>
                      </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['descricao']->renderLabel() ?><br />
                        <?php echo $form['descricao'] ?>
                        <?php echo $form['descricao']->renderError() ?>
                      </td>
                  </tr>
                  
                </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
