<?php use_javascript('jq/jquery.bpopup.min.js') ?>
<?php use_javascript("jq/jquery-ui-1.8.16.custom/development-bundle/ui/i18n/jquery.ui.datepicker-br.js") ?>
<script type="text/javascript"> 
    var url_fun = 'http://'+location.hostname+'/backend_dev.php';
    $(document).ready(function() {
        cargaTipos(0);
        inicializa();
        $('.proj').change(function(){
            $('#codigo_projeto_' + $(this).attr('fila')).val($(this).val());
        });
        $('#despesa-projeto').submit(function()          //whenever you click off an input element
        {                   
            var control = false;
            $('.despesa input[type="text"]').each(function(){
              if( !$(this).val() && $(this).attr('id') != 'des')  {//if it is blank. 
                    $("#no_select_item").show();  
                    control = true;
               }
            });
            if(!control)
            {
                return true;
            }else{
                return false;
            }
        });
        $("#add").click(function() {
            
            var count = $("#resultsList tbody tr:last").attr('fila');
            count++;
            $('#nFilas').val(count);
            var $clone = $("#resultsList tbody tr:first").clone();
            $clone.attr({
                id: "fila-" + count,
                name: "fila-" + count,
                style: "" // remove "display:none"
            });
            $clone.attr("fila",count);
            $clone.attr("data-uid",count);
            $clone.find("input,select").each(function(){
                var attrId = $(this).attr("id").split("-");
                var nameId = $(this).attr("name").split("-");
                
                $(this).attr({
                    id: attrId[0] + '-' + count,
                    name: nameId[0] + '-' + count
                });
                $(this).attr('fila', count);
            });
            // Reinicia datapicker
            $clone.find('.data_despesa').removeClass('hasDatepicker').datepicker();
            $clone.find('.valor_despesa').priceFormat({
                    prefix: 'R$ ',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
            $("#resultsList tbody").append($clone);
            inicializa();
            actualizaComboTareaDespesa(count, $('#nFilas').val(), <?php echo $sf_request->getParameter('id_projeto') ?>);
        });
        
        
    })
    function openDes(fila)
    {
        $('#popup-' + fila).bPopup();
    }
    function inicializa()
    {
        $('.data_despesa').each(function(){
            $(this).datepicker({   
                defaultDate: "+1w",
                dateFormat: 'dd-mm-yy',        
                changeMonth: true,
                changeYear: true
            }); 
        });
        
        $('.tipos').change(function(){
             cargaSubTipos($(this));
        });
        $('.subtipo').change(function(){
             cargaEmpresas($(this));
        });
        $('.ct').change(function(){
            actualizaComboTareaDespesa($(this).attr('fila'), $('#nFilas').val(), <?php echo $sf_request->getParameter('id_projeto') ?>);
            $('#codigo_tarefa-' + $(this).attr('fila')).val($(this).val());
        });
        $("a#click").click(function(){
            var ifila = $(this).parents('tr').data('uid');
            $('#fila-' + ifila).remove();
//            var rowCount = $('#resultsList tbody tr').length;
//            $('#nFilas').val(rowCount);
        })
        
        formatInputMoneda($('.valor_despesa'));
        

    }
    
</script>

<h1 class="icono_projeto">
    <a href="<?php echo url_for('@default_index?module=projeto') ?>">projetos</a> / 
    <?php echo __('DESPESAS DO PROJETO') ?> <?php echo $projeto->getCodigoSgwsProjeto() ?>
</h1>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="msn_error" id="no_select_item" style="display: none; height: 36px; text-align: center;">
    <?php echo __("Preencha os campos vazios"); ?>.&nbsp;&nbsp;
    <a style="color: white;" href="#" onclick="noSelectedItem();">X</a> 
</div>
<?php //include_partial('global/menuProjeto') ?>
<div class="frameForm" style="position: relative; top: 0px;">
<h2>
    Projeto <?php echo $projeto->getCodigoSgwsProjeto() ?>: 
    <?php echo $projeto->getNomeProposta() ?>
    <?php if($infoTarefa): ?>
        <br />
    Tarefa #<?php echo $infoTarefa['id'].' '.$infoTarefa['tarefa'] ?> 
    <?php endif; ?>
</h2>
<br />
    
<h2 class="titulo">Informações de Despesa</h2><br />
<form method="post" id="recalcula_time" action="<?php echo url_for('@default?module=despesa&action=new') ?>" >
<input type="hidden" name="id_projeto" id="id_projeto" value="<?php echo $sf_request->getParameter('id_projeto') ?>" />
<input type="hidden" name="id_tarefa" id="id_tarefa" value="<?php echo $sf_request->getParameter('id_tarefa') ?>" />

Quantos Lançamentos
<select name="carga_filas" id="carga_filas" >
    <?php for($o = 1; $o <= 10; $o++): ?>
        <option value="<?php echo $o; ?>" <?php echo $sf_request->getParameter('carga_filas') == $o ? 'selected="selected"' : '' ?> ><?php echo $o ?></option>
    <?php endfor; ?>
</select>
<input type="submit" id="lanza" name="lanza" value="OK" />
</form>
<div class="clear">&nbsp;</div>

<form method="post" id="despesa-projeto" action="<?php echo url_for('@default?module=despesa&action=saveDespesa') ?>" >
    <table cellpadding="0" cellspacing="0" border="0"  id="resultsList" class="despesa" style="border-bottom: 1px solid #DDD;">
    <thead>
        <tr>
            <th style="width: 10%; padding-left: 10px;">&nbsp;DATA</th>
            <?php if(!$sf_request->getParameter('id_projeto')): ?>
            <th>PROJETO</th>
            <?php endif; ?>
            <?php if(!$sf_request->getParameter('id_tarefa')): ?>
            <th>TAREFA</th>
            <?php endif; ?>
            <th style="">TIPO</th>
            <th style="">SUBTIPO</th>
            <th style="">FORNECEDOR</th>
            <th style="">TIPO PAGAMENTO</th>
            <th style="">VALOR</th>
            <th style="">OBS.</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php for($fl = 1; $fl <= $filas; $fl++): ?>
        
        <tr data-uid="<?php echo $fl ?>" id="fila-<?php echo $fl ?>" fila="<?php echo $fl ?>"   >
            <td>
                &nbsp;
                <input type="text" name="data-<?php echo $fl ?>" id="data-<?php echo $fl ?>" class="data_despesa" /> 
            </td>
            <?php if(!$sf_request->getParameter('id_projeto')): ?>
            <td>
                <select class="proj" onchange="javascript:cargaTareas(<?php echo $fl ?>, <?php echo $filas ?>)" id="cod_projeto_<?php echo $fl ?>" name="cod_projeto_<?php echo $fl ?>"  fila = "<?php echo $fl ?>">
                    <option value="">Selecione Projeto</option>
                    <?php foreach ($projetosUsuario as $projet): ?>
                        <option value="<?php echo $projet['id_projeto'] ?>"><?php echo $projet['codigo_projeto'] ?></option>
                    <?php endforeach; ?>
                </select>              
            </td>
            <?php endif; ?>
            <?php if(!$sf_request->getParameter('id_tarefa')): ?>
            <td>
                <select class="ct" style="width: 215px;" id="cod_tarefa-<?php echo $fl ?>" name="cod_tarefa-<?php echo $fl ?>" fila = "<?php echo $fl ?>" >
                    <option value="">Selecione</option>
                    <?php foreach ($tarefas as $tarefa): ?>
                        <option value="<?php echo $tarefa['id'] ?>"><?php echo $tarefa['tarefa'] ?></option>
                    <?php endforeach; ?>
                    
                </select>  
                <input type="hidden" name="codigo_tarefa-<?php echo $fl ?>" id="codigo_tarefa-<?php echo $fl ?>" value="" />
            </td>
            <?php else: ?>
                <input type="hidden" name="codigo_tarefa_<?php echo $fl ?>" id="codigo_tarefa_<?php echo $fl ?>" value="<?php echo $sf_request->getParameter('id_tarefa') ?>" />
            <?php endif; ?>
            <td>
                <select name="tipo-<?php echo $fl ?>" id="tipo-<?php echo $fl ?>" class="tipos" fila = "<?php echo $fl ?>">
                    <option></option>
                </select>
            </td>
            <td>
                 <select name="subtipo-<?php echo $fl ?>" id="subtipo-<?php echo $fl ?>" class="subtipo" fila = "<?php echo $fl ?>">
                     <option value="">Selecione</option>
                 </select>
            </td>
            <td>
                <select name="fornecedor-<?php echo $fl ?>" id="fornecedor-<?php echo $fl ?>" >
                    <option value="">Selecione</option>
                </select>
            </td>
            <td>
                <select name="pagamento-<?php echo $fl ?>" id="pagamento">
                    <?php foreach ($formaPagamento as $key => $value) : ?>
                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="text" name="valor-<?php echo $fl ?>" id="valor" class="valor_despesa" /></td>
            <td>
                <?php echo image_tag('icons/icon_obs') ?>
                <input type="text" name="des-<?php echo $fl ?>" id="des" style="width: 200px;"  />
            </td>
            <td>
                <a href="javascript: void(0);" id="click" >
                    <?php echo image_tag('delete', array('style' => 'position: relative;top: 7px;right: 20px;')) ?>
                </a>
            </td>
        </tr>
        <?php endfor; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; padding-right: 10px;" colspan="10">
                <?php if($sf_request->getParameter('id_projeto')): ?>
                <input type="hidden" name="codigo_projeto" id="codigo_projeto" value="<?php echo $sf_request->getParameter('id_projeto') ?>" />
                <input type="hidden" name="codigo_tarefa" id="codigo_tarefa" value="<?php echo $sf_request->getParameter('id_tarefa') ?>" />
                <?php endif; ?>
                <input type="hidden" id="nFilas" name="nFilas" value="<?php echo $filas ?>" />
                <div id="add" class="btn-adicionar-no-relative" style="float: left;">Adicionar Fila</div>
                <input type="submit" id="procesa" name="procesa" value="Concluir" />
            </td>
        </tr>
    </tfoot>
</table>
</form>
</div>    