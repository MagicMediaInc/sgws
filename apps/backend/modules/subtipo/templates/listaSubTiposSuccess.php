<div style="text-align: left !important; padding-left: 30px; padding-top: 10px;">
    <h3>Subtipos de <?php echo $tipo_cadastro->getTipoCadastro() ?> </h3><br />
    <?php if($subtipos): ?>
        <div style="font-size:12px; ">
            <?php echo html_entity_decode($html) ?>
        </div>
    <?php else: ?>
        <div style="text-align: center;" class="erro_no_data">
            Nenhum Subtipo associado
        </div>
    <?php endif; ?>
</div>