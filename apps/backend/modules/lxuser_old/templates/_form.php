<?php use_javascript('jq/jquery.tinyscrollbar.min.js') ?>        
<script type="text/javascript">
    $(document).ready(function() {
        $('#scrollbar1').tinyscrollbar();
    });
</script>
<style>
    /*#toggleSubTipo{width:500px; }
    #toggleSubTipo ul{width:450px;}
    #toggleSubTipo li:hover{background:#006599}
    #toggleSubTipo li{color: #FFF; list-style-type:none; cursor:pointer; -moz-border-radius:0 10px 0 10px; background-color: #006599; margin:2px; padding:5px 5px 5px 5px;}
    #toggleSubTipo ul div{color: #666666; cursor: auto; display: none; font-size: 13px; padding: 5px 0 5px 20px; text-decoration: none; }
    #toggleSubTipo ul div a{color:#000000; font-weight:bold;}
    #toggleSubTipo li div:hover{text-decoration:none !important;}
    #toggleSubTipo li:before {content: "+"; padding:10px 10px 10px 0; color:#FFF; font-weight:bold;}
    #toggleSubTipo li.active:before {content: "-"; padding:10px 10px 10px 0; color:#FFF; font-weight:bold;}
    */
</style>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="center">
    <h1 class="titulo"><?php echo __('Informações Pessoais') ?></h1>
    <table width="100%" >
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
      
    <tfoot>
      <tr>
        <td align="right">
            <?php echo $form->renderHiddenFields(false) ?>
            <table cellspacing="4">
                <tr>
                    <td>
                        <input type="submit" value="<?php echo __('Avançar') ?>" />
                    </td>
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>                
                <table cellpadding="0" cellspacing="2" border="0" width="100%" id="register_user">
                  <tr>
                      <td style="border-bottom: 1px solid #CCC; padding-bottom: 10px;" colspan="6">
                        <h3><?php echo __('SUB TIPOS') ?> </h3><br />
                        <div class="content-subT">
                            <div id="scrollbar1">
                                <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                <div class="viewport">
                                    <div class="overview">                                    
                                        <?php echo $html ?>
                                        <br /><br />
                                    </div>
                                </div>
                            </div>                                     
                        </div>
                      </td>
                  </tr>
                  <tr>
                        <td style="border-bottom: 1px solid #CCC; padding-bottom: 10px; padding-top: 10px;" colspan="6">
                            <h3><?php echo __('TIPOS DE CADASTRO') ?> </h3><br />
                            <?php echo $form['id_tipo_cadastro'] ?>
                            <?php echo $form['id_tipo_cadastro']->renderError() ?>
                        </td>
                  </tr>                  
                  <tr>
                      <td style="padding-top: 10px;border-bottom: 1px solid #CCC; padding-bottom: 10px;" colspan="6">
                            <h3><?php echo __('CATEGORIAS') ?></h3><br />
                            <?php echo $form['id_tipo_usuario'] ?>
                            <?php echo $form['id_tipo_usuario']->renderError() ?>
                      </td>
                  </tr>
                  <tr>
                      <td style="padding-top: 10px;" colspan="6">
                          <h3><?php echo __('DADOS DE CADASTRO') ?></h3>
                          <br />
                      </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['codigo']->renderLabel() ?> <span class="required">*</span></td>
                      <td colspan="5">                          
                          <?php echo $form['codigo'] ?>
                          <?php echo $form['codigo']->renderError() ?>                          
                      </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['login']->renderLabel() ?> <span class="required">*</span></td>
                      <td colspan="5">                          
                          <?php echo $form['login'] ?>
                          <?php echo $form['login']->renderError() ?>                          
                      </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['password']->renderLabel() ?> <span class="required">*</span></td>
                      <td colspan="5">                          
                          <?php echo $form['password'] ?>
                          <?php echo $form['password']->renderError() ?>     
                          <span class="msn_help"><?php echo $form['password']->renderHelp() ?></span>
                      </td>
                  </tr>
                  <tr>
                      <td><?php echo __('Nome') ?> <span class="required">*</span></td>
                      <td colspan="5">
                          
                          <?php echo $form['name'] ?>
                          <?php echo $form['name']->renderError() ?>                          
                      </td>
                  </tr>
                  <tr>
                      <td width="6%"><?php echo $form['cpf']->renderLabel() ?></td>
                      <td width="14%">                        
                        <?php echo $form['cpf'] ?>
                        <?php echo $form['cpf']->renderError() ?>
                      </td>
                      <td width="6%" align="right"><?php echo $form['rg']->renderLabel() ?>&nbsp;</td>
                      <td>
                        <?php echo $form['rg'] ?>
                        <?php echo $form['rg']->renderError() ?>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td width="6%"><?php echo $form['sexo']->renderLabel() ?></td>
                      <td width="14%">                        
                        <?php echo $form['sexo'] ?>
                        <?php echo $form['sexo']->renderError() ?>
                      </td>
                      <td width="6%"><?php echo $form['fecha_nacimiento']->renderLabel() ?></td>
                      <td>
                        <?php echo $form['fecha_nacimiento'] ?>
                        <?php echo $form['fecha_nacimiento']->renderError() ?>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td><?php echo __('Email') ?> <span class="required">*</span></td>
                      <td colspan="5">
                          
                          <?php echo $form['email'] ?>
                          <?php echo $form['email']->renderError() ?>                          
                      </td>
                  </tr>
                  <tr>
                      <td width="6%"><?php echo $form['telefono']->renderLabel() ?></td>
                      <td width="14%">                        
                        <?php echo $form['telefono'] ?>
                        <?php echo $form['telefono']->renderError() ?>
                      </td>
                      <td width="6%" align="right"><?php echo $form['celular']->renderLabel() ?>&nbsp;</td>
                      <td>
                        <?php echo $form['celular'] ?>
                        <?php echo $form['celular']->renderError() ?>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td width="6%"><?php echo $form['direccion']->renderLabel() ?></td>
                      <td width="14%">                        
                        <?php echo $form['direccion'] ?>
                        <?php echo $form['direccion']->renderError() ?>
                      </td>
                      <td width="6%" align="right"><?php echo $form['complemento']->renderLabel() ?>&nbsp;</td>
                      <td>
                        <?php echo $form['complemento'] ?>
                        <?php echo $form['complemento']->renderError() ?>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td width="6%"><?php echo $form['numero']->renderLabel() ?></td>
                      <td width="14%">                        
                        <?php echo $form['numero'] ?>
                        <?php echo $form['numero']->renderError() ?>
                      </td>
                      <td width="6%"  align="right"><?php echo $form['pais']->renderLabel() ?>&nbsp;</td>
                      <td>
                        <?php echo $form['pais'] ?>
                        <?php echo $form['pais']->renderError() ?>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td width="6%"><?php echo $form['estado']->renderLabel() ?></td>
                      <td width="14%">                        
                        <?php echo $form['estado'] ?>
                        <?php echo $form['estado']->renderError() ?>
                      </td>
                      <td width="6%" align="right"><?php echo $form['ciudad']->renderLabel() ?>&nbsp;</td>
                      <td>
                        <?php echo $form['ciudad'] ?>
                        <?php echo $form['ciudad']->renderError() ?>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td width="6%"><?php echo $form['barrio']->renderLabel() ?></td>
                      <td width="14%">                        
                        <?php echo $form['barrio'] ?>
                        <?php echo $form['barrio']->renderError() ?>
                      </td>
                      <td width="6%" align="right"><?php echo $form['cep']->renderLabel() ?>&nbsp;</td>
                      <td>
                        <?php echo $form['cep'] ?>
                        <?php echo $form['cep']->renderError() ?>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td width="6%"><?php echo $form['dependentes']->renderLabel() ?></td>
                      <td colspan="5">                        
                        <?php echo $form['dependentes'] ?>
                        <?php echo $form['dependentes']->renderError() ?>
                      </td>                      
                  </tr>
                  <tr>
                      <td><?php echo $form['observaciones']->renderLabel() ?></td>
                      <td colspan="5">
                          <?php echo $form['observaciones'] ?>
                          <?php echo $form['observaciones']->renderError() ?>                          
                      </td>
                  </tr>
                </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
