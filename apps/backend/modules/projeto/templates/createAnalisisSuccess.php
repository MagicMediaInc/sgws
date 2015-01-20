<div class="frameForm" style="text-align: center">
    <br /><br /><br /><br /><br /><br /><br />
    <?php if ($sf_user->hasFlash('listo')): ?>
        <h1 class="titulo" style="text-align: center; font-weight: normal; font-size: 38px !important;">
            <?php echo $sf_user->getFlash('listo') ?>
        </h1>
    <?php endif; ?>
    <br />
    <div class="button">
    <a href="javascript:void();" onclick="parent.location.reload();parent.jQuery.fancybox.close();">Fechar</a>
    </div>
</div>