<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php $valida = new lynxValida() ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#notificacion").validationEngine()
})
</script>

<form id="notificacion" action="<?php echo url_for('notificacion/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_notificacion='.$form->getObject()->getIdNotificacion() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="left">
    <h2>Cadastro de Notificação</h2>
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
      <tbody>
            <tr>
                <td>               
                    <table cellpadding="0" cellspacing="2" border="0" width="100%">

                        <caption class="vinculados">
                           &nbsp;<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp; 
                           SELECIONAR DESTINATÁRIOS
                        </caption>
                        <tr>
                            <td style="padding-bottom: 10px;">
                                <div id="vinculados" style=" height: 220px;overflow-y: scroll; border: 1px solid #CCCCCC; ">
                                    <ul class="vinculados">
                                        <?php foreach ($vinculados as $user): ?>
                                        <?php if(!$form->getObject()->isNew()): ?>
                                            <?php $checked = NotificacionesDestinatariosPeer::getUserByNotificacion($form->getObject()->getIdNotificacion(),$user->getIdUser()) ?>
                                        <?php else: ?>
                                            <?php $checked = ''?>
                                        <?php endif; ?>
                                        
                                        <li>
                                            <input <?php echo $checked ?> type="checkbox" id="chk_<?php echo $user->getIdUser() ?>" name="chk[<?php echo $user->getIdUser() ?>]" value="<?php echo $user->getIdUser() ?>">&nbsp;
                                            <?php $nome = $valida->datosTipoUsuario($user->getIdUser(), $user->getIdTipoUsuario()) ?>
                                            <?php echo $nome['nome'] ?>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="2" border="0" width="100%">
                      <tr>
                          <td><label>Assunto</label><br />
                            <?php echo $form['asunto'] ?>
                            <?php echo $form['asunto']->renderError() ?>
                        </td>
                      </tr>
                      <tr>
                          <td><label>Conteúdo</label><br />
                            <?php echo $form['conteudo'] ?>
                            <?php echo $form['conteudo']->renderError() ?>
                        </td>
                      </tr>
                    </table>                
                </td>
            </tr>
      </tbody>
      <tfoot>
      <tr>
        <td>
            <?php echo $form->renderHiddenFields(false) ?>
            <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                    <?php echo link_to(__('Voltar à lista'), '@default?module=notificacion&action=index&'.$sf_user->getAttribute('uri_notificacion'), array('class' => 'button')) ?>
                                 </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Eliminar'), 'notificacion/delete?id_notificacion='.$form->getObject()->getIdNotificacion(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Enviar') ?>" />
                    </td>
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
  </table>
    </div>
</form>
