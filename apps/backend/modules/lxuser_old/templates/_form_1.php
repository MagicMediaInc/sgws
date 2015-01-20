<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="center">
    <h1 class="titulo"><?php echo __('Informações Pessoais') ?></h1>
    <table width="100%" style="border: 1px solid #000;">
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
                <table cellpadding="0" cellspacing="2" border="0" width="100%">
                    <tr>
                      <td><?php echo 'Perfil associado' ?> <span class="required">*</span><br />
                        <?php echo $form['id_profile'] ?>
                        <?php echo $form['id_profile']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo 'Nome do perfil' ?> <span class="required">*</span><br />
                        <?php echo $form['name'] ?>
                        <?php echo $form['name']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['login']->renderLabel() ?> <span class="required">*</span><br />
                        <?php echo $form['login'] ?>
                        <?php echo $form['login']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo 'Senha' ?> <span class="required">*</span><br />
                        <?php echo $form['password'] ?>

                        <?php echo $form['password']->renderError() ?>
                          <span class="msn_help"><?php echo $form['password']->renderHelp() ?></span>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['email']->renderLabel() ?> <span class="required">*</span><br />
                        <?php echo $form['email'] ?>
                        <?php echo $form['email']->renderError() ?>
                    </td>
                  </tr>
                  
                              <tr>
                      <td><?php echo $form['status']->renderLabel() ?><br />
                        <?php echo $form['status'] ?>
                        <?php echo $form['status']->renderError() ?>
                    </td>
                  </tr>
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
