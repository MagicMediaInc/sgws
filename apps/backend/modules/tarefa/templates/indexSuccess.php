<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>
<?php use_javascript('fancybox/jquery.fancybox.js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
        $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false});
    });
</script>
<h1 class="icono_projeto"><?php echo __('Minhas Tarefas') ?></h1>

<?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot() || aplication_system::isGerenteTecnicoComercial() ): ?>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for('@default?module=projeto&action=analisisCritico') ?>"> Incluir Proposta</a>
<?php endif; ?>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm" style="position: relative; top: 0px;">
    <?php include_partial('global/menuProjeto') ?>
    
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
        <th>&nbsp;</th>
        <th style="width: 155px;">Tarefa</th>
        <th>Codigo Projeto</th>
        <th>Data Início</th>
        <th>Data de Término</th>
        <th>Duração / Horas</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($tarefas): ?>
    <?php $i=0; ?>
    <?php foreach ($tarefas as $tarefa): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td  width="28" align="center">&nbsp;</td>
        <td >
            <div class="displayTitle">
               <div id="title">                               
                    <a href="<?php echo url_for('tarefa/edit?codigotarefa='.$tarefa['id_tarefa']) ?>" class="fancybox fancybox.iframe"><?php echo $tarefa['tarefa'] ?></a>
               </div>
                <div class="row-actions" style="width: 80px;">
                    <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                        <?php $_trf = TarefaPeer::retrieveByPK($tarefa['id_tarefa']); ?>
                        <?php if($_trf->getStatus() < 6): ?>

                            <a href="<?php echo url_for('tarefa/edit?codigotarefa='.$tarefa['id_tarefa'], $tarefa) ?>" class="fancybox fancybox.iframe"><?php echo __('Editar') ?></a>
                            &nbsp;&nbsp;
                        <?php endif; ?>
                        <?php //echo link_to(__('Excluir'),'tarefa/delete?codigotarefa='.$tarefa['id_tarefa'], array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                    </div>
                </div>
            </div>
        </td>
        <td ><?php echo $tarefa['codigo_projeto'] ?>&nbsp;</td>
        <td ><?php echo $tarefa['data_inicio'] ? date('d-m-Y', strtotime($tarefa['data_inicio'])) : '' ?>&nbsp;</td>
        <td ><?php echo $tarefa['data_fim'] ? date('d-m-Y', strtotime($tarefa['data_fim'])) : '' ?> &nbsp;</td>
        <td ><?php echo $tarefa['horas'] ?>&nbsp;</td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="12"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>
        </tr>
    <?php endif; ?>
  </tbody>
</table>
    

</div>

