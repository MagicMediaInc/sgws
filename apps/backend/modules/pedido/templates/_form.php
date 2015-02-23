<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php $cliente = LxUserPeer::getCurrentPassword($form->getObject()->getIdCliente()) ?>
<?php $projeto = PropostaPeer::retrieveByPK($form->getObject()->getIdProjeto()) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#pedido").validationEngine();
      $("#pedidos_data").datepicker({   
            defaultDate: "+1w",
            dateFormat: 'dd-mm-yy',        
            changeMonth: true,
            changeYear: true
        }); 
      <?php if(!$form->getObject()->isNew()): ?>
            <?php if($form->getObject()->getData()): ?>
                  $("#pedidos_data").val('<?php echo date('d-m-Y', strtotime($form->getObject()->getData())) ?>');
            <?php endif; ?>        
      <?php endif; ?>        
      formatInputMoneda($("#pedidos_valor"));
})
</script>

<form id="pedido" action="<?php echo url_for('pedido/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="left">
  <table width="100%">
      <tr>
        <td id="errorGlobal">
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
    <tfoot>
      <tr>
        <td>
                                  <?php echo $form->renderHiddenFields(false) ?>
                        <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                               <?php echo link_to(__('Voltar à lista'), '@default?module=pedido&action=index&'.$sf_user->getAttribute('uri_pedido'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if($edit): ?>
                    <?php if (!$form->getObject()->isNew() && aplication_system::esUsuarioRoot()): ?>
                    <td>
                        <div class="button">
                            <?php echo link_to(__('Eliminar'), 'pedido/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Salvar') ?>" />
                    </td>
                    <?php endif; ?>
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
            <td style="width: 30%;">                
                <table cellpadding="0" cellspacing="2" border="0" width="100%" id="table-info">
                  <tr>
                      <td><label>Número Pedido</label><br />
                          <div class="mask-imput" style="width: 100px;font-size: 19px">
                            <?php echo $form->getObject()->getNumeroPedido() ?>
                          </div>
                    </td>
                  </tr>  
                  <tr>
                      <td><?php echo $form['id_cliente']->renderLabel() ?><br />
                          <div class="mask-imput" style="width: 300px;">
                              <?php echo $cliente->getName() ?>
                          </div>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['id_projeto']->renderLabel() ?><br />
                          <div class="mask-imput" style="width: 300px;">
                              <?php echo $projeto->getCodigoSgwsProjeto()?> - <?php echo $projeto->getNomeProposta() ?>
                          </div>
                    </td>
                  </tr>
                  
                              <tr>
                      <td><?php echo $form['status']->renderLabel() ?><br />
                        <?php echo $form['status'] ?>
                        <?php echo $form['status']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['data']->renderLabel() ?><br />
                        <?php echo $form['data'] ?>
                        <?php echo $form['data']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['valor']->renderLabel() ?><br />
                        <?php echo $form['valor'] ?>
                        <?php echo $form['valor']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['forma_pagamento']->renderLabel() ?><br />
                        <?php echo $form['forma_pagamento'] ?>
                        <?php echo $form['forma_pagamento']->renderError() ?>
                    </td>
                  </tr>
                </table>                
            </td>
            <td style="vertical-align: top; border-left: 1px dotted #ccc; padding-left: 20px;">
                <?php include_partial('pedido/items', array('items' => $items,'edit' => $edit)) ?>
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
