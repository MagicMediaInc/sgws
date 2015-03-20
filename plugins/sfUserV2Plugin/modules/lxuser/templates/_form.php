<?php use_javascript('jq/jquery.tinyscrollbar.min.js') ?>       

<script src="/js/jq/jquery-ui-1.8.16.custom/development-bundle/ui/i18n/jquery.ui.datepicker-br.js"></script> 

<script type="text/javascript">

    $(document).ready(function() {

        $('#scrollbar1').tinyscrollbar();

        formatInputMoneda($('#cadastro_fisica_rate'));

        $("#data_registro, #data_emissao, #data_admissao, #data_nacimento").datepicker({   

            defaultDate: "+1w",

            dateFormat: 'dd-mm-yy',        

            changeMonth: true,

            changeYear: true

        });   

        <?php if(!$form->getObject()->isNew()): ?>

            <?php if($form->getObject()->getDataEmissao()): ?>

                $("#data_emissao").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataEmissao())) ?>');

            <?php endif; ?>

            <?php if($form->getObject()->getDataAdmissao()): ?>

                $("#data_admissao").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataAdmissao())) ?>');

            <?php endif; ?>

            <?php if($form->getObject()->getDataNacimento()): ?>

                $("#data_nacimento").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataNacimento())) ?>');

            <?php endif; ?>

            <?php if($form->getObject()->getDataRegistro()): ?>

                $("#data_registro").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getDataRegistro())) ?>');

            <?php endif; ?>

        <?php endif; ?>

    });

</script>

<?php $tiposCadastro = TipoCadastroPeer::getListTypeCadastro() ?>

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

    <?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot()): ?>  

    <tfoot>

      <tr>

        <td align="left">

            <?php echo $form->renderHiddenFields(false) ?>

            <table cellspacing="4" style="margin-left: 375px;">

                <tr>

                    <td>

                        <div class="button">

                            <a href="javascript:history.back(1)">Voltar à Lista</a>

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

    <?php endif; ?>

    <tbody>

        <tr>

            <td>                

                <table cellpadding="0" cellspacing="2" border="0" width="100%" id="register_user">

                  <tr>

                      <td colspan="6">

                          <table style="width: 100%; display: none;">

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

                                            <?php $subtipo = SubtipoUserPeer::getSubTiposByTipoCadastro($tc->getIdTipoCadastro()); ?>

                                            <?php if($subtipo): ?>

                                            <li>

                                                <div style="float: left; width: 200px; height: 170px;  margin-right: 5px;">

                                                    <input type="checkbox" id="tipo_<?php echo $tc->getIdTipoCadastro() ?>" name="chktipo[<?php echo $tc->getIdTipoCadastro() ?>]" value="<?php echo $tc->getIdTipoCadastro() ?>" onclick="javascript:enable_cb(<?php echo $tc->getIdTipoCadastro() ?>);" >

                                                    <label><?php echo $tc->getTipoCadastro() ?></label>

                                                    <?php if($subtipo): ?>

                                                        <ol style=" height: 150px; overflow-y: scroll; border: 1px solid #CCCCCC;" id="subtipos_<?php echo $tc->getIdTipoCadastro() ?>">

                                                        <?php foreach ($subtipo as $st): ?>

                                                            

                                                            <?php $validate = VinculoUserSubtipoPeer::checkSubTipoByUser($sf_request->getParameter('id_user'), $st->getIdSubtipo()); ?>

                                                            <?php $check = $validate ? 'checked="checked"' : ''?>

                                                            <?php $activeTC = $validate ? '1' : '0' ?>

                                                            <li style="margin-left: 15px; margin-top: 5px; margin-bottom: 5px;">

                                                                <input <?php echo $check ?> type="checkbox" id="pp_<?php echo $tc->getIdTipoCadastro() ?>" class="pp_<?php echo $tc->getIdTipoCadastro().'-'.$st->getIdSubtipo() ?>" name="chk-<?php echo $tc->getIdTipoCadastro() ?>[<?php echo $st->getIdSubtipo() ?>]" value="<?php echo $st->getIdSubtipo() ?>" onclick="javascript:check_enable_tc(<?php echo $tc->getIdTipoCadastro()?>, <?php echo $st->getIdSubtipo() ?>);" >

                                                                <?php echo $st->getSubtipo() ?>

                                                            </li>

                                                            <script type="text/javascript">

                                                                <?php if($activeTC): ?>                                                                        

                                                                        $("input#tipo_" + <?php echo $tc->getIdTipoCadastro() ?>).attr("checked", true);

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

                  

                  <tr>

                      <td style="padding-top: 10px;" colspan="6">

                          <h3><?php echo __('DADOS DE CADASTRO') ?></h3>

                          <br />

                      </td>

                  </tr>

                  <tr>

                        <td style="width: 17%;">

                            <label><?php echo __('Perfil') ?> </label>

                        </td>

                        <td colspan="5">

                            <?php echo $form['id_profile'] ?>

                            <?php echo $form['id_profile']->renderError() ?>

                        </td>

                  </tr>                  

                  <?php if(($sf_request->getParameter('id_user') &&  $tipoUser->getIdTipoUsuario() == 2)  ||  (sfContext::getInstance()->getActionName() == 'new' || sfContext::getInstance()->getActionName() == 'create')):?>

                  <tr>

                      <td style="width: 17%;"><?php echo $form['login']->renderLabel() ?> <span class="required">*</span></td>

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

                  <?php endif; ?>

                  <tr>

                      <td><label><?php echo __('Email') ?></label> <span class="required">*</span></td>

                      <td colspan="5">

                          

                          <?php echo $form['email'] ?>

                          <?php echo $form['email']->renderError() ?>        

                          

                      </td>

                  </tr>

                  <tr>

                      <td><label>Preço / Hora</label> <span class="required">*</span></td>

                      <td colspan="5">

                          

                          <?php echo $form['rate'] ?>

                          <?php echo $form['rate']->renderError() ?>        

                          

                      </td>

                  </tr>

                  <tr>

                      <td>

                          &nbsp;

                      </td>

                  </tr>

                </table>

                <?php if($sf_request->getParameter('id_user')):?>

                    <?php if($tipoUser->getIdTipoUsuario() == 2):?>

                        <?php include_partial('cadastroFisica',  array('form' => $form)) ?>

                    <?php else: ?>

                        <?php include_partial('cadastroJuridica',  array('form' => $form)) ?>

                    <?php endif; ?>

                <?php else: ?>

                    <?php if(sfContext::getInstance()->getActionName() == 'new' || sfContext::getInstance()->getActionName() == 'create'):?>

                        <?php include_partial('cadastroFisica',  array('form' => $form)) ?>

                    <?php else:?>

                        <?php include_partial('cadastroJuridica',  array('form' => $form)) ?>

                    <?php endif; ?>

                <?php endif; ?>                

                </table>

                </div>

            </td>

        </tr>

    </tbody>

  </table>

</div>



