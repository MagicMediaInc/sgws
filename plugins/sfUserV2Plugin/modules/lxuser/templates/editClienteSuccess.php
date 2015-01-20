<h1 class="icono_user"><a href="<?php echo url_for('lxuser/index') ?>" ><?php echo __('Usuários')  ?></a> - 
    <?php echo __('Editar ').($sf_user->getAttribute('tc_empresa') == 2 ? 'Cliente' : 'Fornecedor' ) ?>
</h1>
<div id="title_module">
    <div id="renglon">
        <?php include_partial('menuCliente') ?>
    </div>
    <form id="lxuser" action="<?php echo url_for('lxuser/'.($form->getObject()->isNew() ? 'createCliente' : 'updateCliente').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getIdEmpresa() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <div id="info_pessoais">
            <?php include_partial('formCliente', array('form' => $form, 'html' => $html, 'tipoUser' => $tipoUser)) ?>
        </div>
    </form>        
</div>
