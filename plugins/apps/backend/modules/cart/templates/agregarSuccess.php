<script type="text/javascript">
    $(document).ready(function() {
        //$("#message-product-<?php echo $sf_request->getParameter('id') ?>", top.document).css('display', 'inline');
        $("#nbArticles", top.document).html(<?php echo $nbArticles ?>);
        $("#nbPiezas", top.document).html(<?php echo $nbPiezas ?>);
        $("#totalCart", top.document).html(<?php echo $totalShoppingCart ?>);
        
        parent.jQuery.fancybox.close();
    });
</script>