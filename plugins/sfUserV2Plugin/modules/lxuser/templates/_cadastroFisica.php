<?php $val_date = new lynxValida(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#data_nacimento, #data_emissao, #data_admissao").datepicker({
          dateFormat: 'dd-mm-yy',  
          yearRange: '-93:+1',
          changeMonth: true,
          changeYear: true
        });
        if($("#data_nacimento").val())
        {
            $("#data_nacimento").val('<?php echo $val_date->formatoFechaPTByMySql($form->getObject()->getDataNacimento()) ?>');
        } 
        if($("#data_emissao").val())
        {
            $("#data_emissao").val('<?php echo date("d-m-Y", strtotime($form->getObject()->getDataEmissao())) ?>');
        } 
        if($("#data_admissao").val())
        {
            $("#data_admissao").val('<?php echo date("d-m-Y", strtotime($form->getObject()->getDataAdmissao())) ?>');
        } 
        $("#pais").click(function() {
            if( $("#pais").val() == "BR" )
            {
                $("#dados-uf-br").show();  
                $("#dados-mu-br").show();  
            }else{
                $("#dados-uf-br").hide();  
                $("#dados-mu-br").hide();  
            }
        });  
        $("#dados-uf-br").show();  
        $("#dados-mu-br").show();  
        
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
                    name: nameId[0] + '-' + count,
                    value : ''
                });
                $(this).attr('fila', count);
            });
            
            $("#resultsList tbody").append($clone);
            $("a#click").click(function(){

                var ifila = $(this).parents('tr').data('uid');
                $('#fila-' + ifila).remove();
            });
            $("a#salva-contato").click(function(){
            
                var ifila = $(this).parents('tr').data('uid');
                salvaContacto(ifila);
            });
        });
        
        $("a#salva-contato").click(function(){
            
            var ifila = $(this).parents('tr').data('uid');
            salvaContacto(ifila);
        });
        
        $("a#click").click(function(){
            
            var ifila = $(this).parents('tr').data('uid');
            $('#fila-' + ifila).remove();
        });
    });
    
    function salvaContacto(ref)
    {
        $.ajax({
          type: "POST",
          url:  url + "ajax/salvaContacto",
          data: '{nome' : $("#nome-" + ref).val()}
          dataType: "html",
          beforeSend: function(objeto){
              //$("#subtipo-" + fila).append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#subtipo-" + fila).html(msg);
          }
        });
    }
</script>
<table cellpadding="0" cellspacing="2" border="0" width="100%" id="register_user">
    <tr>
        <td colspan="6">
            <h3>DADOS PESSOAIS</h3>
            <br />
        </td>
    </tr>
    <tr>
        <td style="width: 17%;"><label><?php echo __('Nome') ?></label> <span class="required">*</span></td>
        <td colspan="5">
            <?php echo $form['nome'] ?>
            <?php echo $form['nome']->renderError() ?>                          
        </td>
    </tr>
    <tr>
        <td><?php echo $form['cpf']->renderLabel() ?></td>
        <td width="30%">                        
          <?php echo $form['cpf'] ?>
          <?php echo $form['cpf']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['rg']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['rg'] ?>
          <?php echo $form['rg']->renderError() ?>
        </td>
        
    </tr>
    <tr>
        <td><?php echo $form['sexo']->renderLabel() ?></td>
        <td  colspan="5">
          <?php echo $form['sexo'] ?>
          <?php echo $form['sexo']->renderError() ?>
        </td>
     </tr>
    <tr>
        <td><?php echo $form['cargo']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['cargo'] ?>
          <?php echo $form['cargo']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['forma_contratacao']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['forma_contratacao'] ?>
          <?php echo $form['forma_contratacao']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['data_nacimento']->renderLabel() ?></td>
        <td colspan="5">
          <?php echo $form['data_nacimento'] ?>
          <?php echo $form['data_nacimento']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['data_registro']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['data_registro'] ?>
          <?php echo $form['data_registro']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['data_emissao']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['data_emissao'] ?>
          <?php echo $form['data_emissao']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['data_admissao']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['data_admissao'] ?>
          <?php echo $form['data_admissao']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['telefone']->renderLabel() ?></td>
        <td colspan="5">                        
          <?php echo $form['ddi_telefone'] ?>&nbsp;<?php echo $form['ddd_telefone'] ?>&nbsp;<?php echo $form['telefone'] ?>
          <?php echo $form['telefone']->renderError() ?>
        </td>        
    </tr>
    <tr>
        <td><?php echo $form['celular']->renderLabel() ?></td>
        <td colspan="5">                        
          <?php echo $form['ddi_celular'] ?>&nbsp;<?php echo $form['ddd_celular'] ?>&nbsp;<?php echo $form['celular'] ?>
          <?php echo $form['celular']->renderError() ?>
        </td>        
    </tr>
    <tr>
        <td><?php echo $form['endereco']->renderLabel() ?></td>
        <td >                        
          <?php echo $form['endereco'] ?>
          <?php echo $form['endereco']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['complemento']->renderLabel() ?>&nbsp;</td>
        <td>
          <?php echo $form['complemento'] ?>
          <?php echo $form['complemento']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['numero']->renderLabel() ?></td>
        <td>                        
          <?php echo $form['numero'] ?>
          <?php echo $form['numero']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><label>País</label> &nbsp;</td>
        <td>
          <?php echo $form['pais'] ?>
          <?php echo $form['pais']->renderError() ?>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr id="dados-uf-br">
        <td><label>Estado</label></td>
        <td >                        
          <?php echo $form['id_uf']->render(array('id' => 'id_uf', 'onchange' =>
                  jq_remote_function(array(
                    'update' => 'id_municipio',
                    'before' => '$("#id_municipio> option").remove();$("#id_municipio").append("<option>Cargando...</option>"); ',
                    'url'    => 'lxuser/getMunicipios',
                    'with'   => " 'id=' + this.value ",
                  ))))
          ?>
          <?php echo $form['id_municipio']->renderError() ?>
        </td>
    </tr>
    <tr id="dados-mu-br">
        <td><?php echo $form['id_municipio']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['id_municipio'] ?>
          <?php echo $form['id_municipio']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><label>Bairro</label></td>
        <td colspan="5" >                        
          <?php echo $form['barrio'] ?>
          <?php echo $form['barrio']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['cep']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['cep'] ?>
          <?php echo $form['cep']->renderError() ?>
        </td>
    </tr>
    
    <tr>
        <td><?php echo $form['dependentes']->renderLabel() ?></td>
        <td colspan="5">
            <?php echo $form['dependentes'] ?>
            <?php echo $form['dependentes']->renderError() ?>                          
        </td>
    </tr>
    <tr>
        <td><?php echo $form['observacoes']->renderLabel() ?></td>
        <td colspan="5">
            <?php echo $form['observacoes'] ?>
            <?php echo $form['observacoes']->renderError() ?>                          
        </td>
    </tr>
    <tr style="display: none;">
        <td colspan="6">
            <table id="resultsList">
                <thead>
                    <th>Nome</th>
                    <th>Relacao</th>
                    <th>Telefone</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                    <tr data-uid="0" id="fila-0" fila="0"   >
                        <td><input type="text" name="nome-0" id="nome-0" /></td>
                        <td><input type="text" name="relacao-0" id="relacao-0" /></td>
                        <td><input type="text" name="telefone-0" id="telefone-0" /></td>
                        <td><input type="text" name="celular-0" id="celular-0" /></td>
                        <td><input type="text" name="email-0" id="email-0" /></td>
                        <td>
                            <a href="javascript: void(0);" id="salva-contato">Salvar</a>
                            &nbsp;&nbsp;
                            <a href="javascript: void(0);" id="click" >
                                <?php echo image_tag('delete', array('style' => 'position: relative;top: 3px;right: 1px;')) ?>
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <div id="add" class="btn-adicionar-no-relative" style="float: left;">Adicionar Fila</div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="6"><?php echo $form->renderHiddenFields(false) ?></td>
    </tr>
</table>