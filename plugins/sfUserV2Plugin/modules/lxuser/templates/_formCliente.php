<?php use_javascript('jq/jquery.tinyscrollbar.min.js') ?>       
<script src="/js/jq/jquery-ui-1.8.16.custom/development-bundle/ui/i18n/jquery.ui.datepicker-br.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#scrollbar1').tinyscrollbar();
    });
</script>
<?php $tiposCadastro = SubtipoUserPeer::getListParentTypeCadastroCliente($sf_user->getAttribute('tc_empresa'));?>
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
    <?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot() || aplication_system::isALLGerente()): ?>
    <tfoot>
      <tr>
        <td align="left">
            <?php echo $form->renderHiddenFields(false) ?>
            <table cellspacing="4" style="margin-left: 375px;">
                <tr>
                    <td>
                        <div class="button">
                            <a href="javascript:history.back(1)">Volver Atrás</a>
                        </div>
                    </td>
                    <td>
                        <input type="submit" value="<?php echo __('Avançar') ?>" />
                    </td>
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <?php endif;?>
    <tbody>
        <tr>
            <td>                
                <table cellpadding="0" cellspacing="2" border="0" width="100%" id="register_user">
                  <tr>
                      <td colspan="6">
                          <table style="width: 100%">
                              <caption>
                                  <h3><?php echo __('TIPOS DE CADASTROS') ?> </h3>
                              </caption>
                              <tbody>
                                  <tr>
                                      <td>
                                          <br />
                                          <ol>
                                          <?php $activeTC = 0; ?>
                                          <?php foreach ($tiposCadastro as $tc): ?>
                                            <?php $subtipo = SubtipoUserPeer::getTiposTipoCadastro($sf_user->getAttribute('tc_empresa'), $tc->getIdSubtipo()); ?>
                                            <?php if($subtipo): ?>
                                            <li>
                                                <div style="float: left; width: 200px; height: 170px;  margin-right: 5px;">
                                                    <input type="checkbox" id="tipo_<?php echo $tc->getIdSubtipo() ?>" name="chktipo[<?php echo $tc->getIdSubtipo() ?>]" value="<?php echo $tc->getIdSubtipo() ?>" onclick="javascript:enable_cb(<?php echo $tc->getIdSubtipo() ?>);" >
                                                    <label><?php echo $tc->getSubtipo() ?></label>
                                                    <?php if($subtipo): ?>
                                                        <ol style=" height: 150px; overflow-y: scroll; border: 1px solid #CCCCCC;" id="subtipos_<?php echo $tc->getIdTipoCadastro() ?>">
                                                        <?php foreach ($subtipo as $st): ?>
                                                            
                                                            <?php $validate = FornecedorSubtipoPeer::checkSubTipoByUser($sf_request->getParameter('id'), $st->getIdSubtipo()); ?>
                                                            <?php $check = $validate ? 'checked="checked"' : ''?>
                                                            <?php $activeTC = $validate ? '1' : '0' ?>
                                                            <li style="margin-left: 15px; margin-top: 5px; margin-bottom: 5px; text-transform: capitalize;">
                                                                <input <?php echo $check ?> type="checkbox" id="pp_<?php echo $tc->getIdSubtipo() ?>" class="pp_<?php echo $tc->getIdSubtipo().'-'.$st->getIdSubtipo() ?>" name="chk-<?php echo $tc->getIdSubtipo() ?>[<?php echo $st->getIdSubtipo() ?>]" value="<?php echo $st->getIdSubtipo() ?>" onclick="javascript:check_enable_tc(<?php echo $tc->getIdSubtipo()?>, <?php echo $st->getIdSubtipo() ?>);" >
                                                                <?php echo $st->getSubtipo() ?>
                                                            </li>
                                                            <script type="text/javascript">
                                                                <?php if($activeTC): ?>                                                                        
                                                                        $("input#tipo_" + <?php echo $tc->getIdSubtipo() ?>).attr("checked", true);
                                                                <?php endif; ?>
                                                            
                                                            </script>
                                                        <?php endforeach; ?>
                                                        
                                                        </ol>
                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                            <?php endif; ?>
                                          <?php endforeach; ?>
                                          </ol>
                                      </td>
                                  </tr>
                              </tbody>
                              
                          </table>
                      </td>
                  </tr>
                </table>
                <?php include_partial('cadastroJuridica',  array('form' => $form)) ?>
                </table>
                </div>
            </td>
        </tr>
    </tbody>
  </table>
</div>

