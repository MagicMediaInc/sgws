<div id="title_module">
        <div class="frameForm" >
        <h1>[?php echo __($moduleParent['parent_name'])?] - <a href="[?php echo url_for('<?php echo $this->getUrlForAction('index') ?>') ?]" >[?php echo __('<?php echo $this->getModuleName() ?>')  ?]</a> - [?php echo __('Editar <?php echo $this->getModuleName() ?>') ?] </h1>
        
        </div>
[?php include_partial('form', array('form' => $form)) ?]
</div>
