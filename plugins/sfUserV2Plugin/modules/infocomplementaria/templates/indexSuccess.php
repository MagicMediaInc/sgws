<?php use_helper('Date') ?>
<h1 class="icono_user"><?php echo __('Pessoas') ?></h1>
<div id="title_module">
    
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    <div id="renglon">
        <?php include_partial('global/menu') ?>
    </div>
    <div id="vinculos">
        <h1 class="titulo"><?php echo __('Informações Complementarias') ?></h1>
        <h2>Módulo de Construção</h2>
        <a href="<?php echo url_for('lxuser/index') ?>" >Voltar</a>
        
    </div>
    
</div>
</div>
