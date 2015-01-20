<script type="text/javascript">
    $(document).ready(function() {
        
        $("#pais").click(function() {
            if( $("#pais").val() == "BR" )
            {
                $("#dados_br").show();  
            }else{
                $("#dados_br").hide();  
            }
        });  
        
         $("#dados_br").show();  
        
          
    });
</script>
<table cellpadding="0" cellspacing="2" border="0" width="100%" id="register_user">
    <tr>
        <td style="padding-top: 10px;" colspan="6">
            <h3><?php echo __('DADOS PESSOA JURIDICA') ?></h3>
            <br />
        </td>
    </tr>
    <tr>
        <td style="width: 17%;"><label><?php echo __('Código') ?></label> <span class="required">*</span></td>
        <td colspan="5">

            <?php echo $form['codigo_cliente'] ?>
            <?php echo $form['codigo_cliente']->renderError() ?>                          
        </td>
    </tr>
    <tr>
        <td style="width: 17%;"><label><?php echo __('Nome Fantasia') ?></label> <span class="required">*</span></td>
        <td colspan="5">

            <?php echo $form['nome_fantasia'] ?>
            <?php echo $form['nome_fantasia']->renderError() ?>                          
        </td>
    </tr>
    <tr>
        <td style="width: 5%;"><?php echo $form['razao_social']->renderLabel() ?> <span class="required">*</span></td>
        <td colspan="5">

            <?php echo $form['razao_social'] ?>
            <?php echo $form['razao_social']->renderError() ?>                          
        </td>
    </tr>
    <tr>
        <td style="width: 5%;"><?php echo $form['email']->renderLabel() ?> <span class="required">*</span></td>
        <td colspan="5">

            <?php echo $form['email'] ?>
            <?php echo $form['email']->renderError() ?>                          
        </td>
    </tr>
    <tr>
        <td><?php echo $form['tipo_cadastro']->renderLabel() ?></td>
        <td colspan="5">
          <?php echo $form['tipo_cadastro'] ?>
          <?php echo $form['tipo_cadastro']->renderError() ?>
        </td>        
    </tr>
    <tr>
        <td><?php echo $form['cnpj']->renderLabel() ?></td>
        <td colspan="5">
          <?php echo $form['cnpj'] ?>
          <?php echo $form['cnpj']->renderError() ?>
        </td>        
    </tr>
    <tr>
        <td><?php echo $form['incripcao_estadual']->renderLabel() ?></td>
        <td colspan="5">
          <?php echo $form['incripcao_estadual'] ?>
          <?php echo $form['incripcao_estadual']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['incripcao_ccm']->renderLabel() ?></td>
        <td colspan="5">
          <?php echo $form['incripcao_ccm'] ?>
          <?php echo $form['incripcao_ccm']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['site']->renderLabel() ?></td>
        <td colspan="5">
          <?php echo $form['site'] ?>
          <?php echo $form['site']->renderError() ?>
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
        <td><?php echo $form['fax']->renderLabel() ?></td>
        <td colspan="5">                        
          <?php echo $form['ddi_fax'] ?>&nbsp;<?php echo $form['ddd_fax'] ?>&nbsp;<?php echo $form['fax'] ?>
          <?php echo $form['fax']->renderError() ?>
        </td>        
    </tr>
    <tr>
        <td><?php echo $form['endereco']->renderLabel() ?></td>
        <td colspan="5">
          <?php echo $form['endereco'] ?>
          <?php echo $form['endereco']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['numero']->renderLabel() ?></td>
        <td colspan="5">                        
          <?php echo $form['numero'] ?>
          <?php echo $form['numero']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form['complemento']->renderLabel() ?>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['complemento'] ?>
          <?php echo $form['complemento']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><label>País</label> &nbsp;</td>
        <td colspan="5">
          <?php echo $form['pais'] ?>
          <?php echo $form['pais']->renderError() ?>
        </td>
    </tr>
    <tr id="dados_br">
        <td><label>Estado</label></td>
        <td colspan="5">                        
          <?php echo $form['id_uf']->render(array('id' => 'id_uf', 'onchange' =>
                  jq_remote_function(array(
                    'update' => 'id_municipio',
                    'before' => '$("#id_municipio> option").remove();$("#id_municipio").append("<option>Cargando...</option>"); ',
                    'url'    => 'lxuser/getMunicipios',
                    'with'   => " 'id=' + this.value ",
                  ))))
          ?>
          <?php echo $form['id_uf']->renderError() ?>
        </td>
    </tr>
    <tr> 
        <td><label>Cidade</label>&nbsp;</td>
        <td colspan="5">
          <?php echo $form['id_municipio'] ?>
          <?php echo $form['id_municipio']->renderError() ?>
        </td>
    </tr>
    <tr>
        <td><label>Bairro</label></td>
        <td>                        
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
        <td><?php echo $form['observacoes']->renderLabel() ?></td>
        <td colspan="5">
            <?php echo $form['observacoes'] ?>
            <?php echo $form['observacoes']->renderError() ?>                          
        </td>
    </tr>
    <tr>
        <td><?php echo $form['status']->renderLabel() ?></td>
        <td colspan="5">
            <?php echo $form['status'] ?>
            <?php echo $form['status']->renderError() ?>                          
        </td>
    </tr>
</table>