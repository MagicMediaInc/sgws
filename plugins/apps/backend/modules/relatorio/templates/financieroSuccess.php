<?php use_stylesheet('ajaxtabs.css') ?>
<?php use_javascript('ajaxtabs.js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
    
    });
</script>

<h1 class="icono_projeto">financeiro</h1>
<div class="clear"></div>
<ul id="countrytabs" class="shadetabs">
<!--    <li><a href="<?php //echo url_for('@default?module=relatorio&action=faturamentos') ?>" rel="#default" class="">Faturamentos</a></li>-->
    <li><a href="<?php echo url_for('@default?module=relatorio&action=faturamentos') ?>" rel="countrycontainer" class="selected" >Faturamentos</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=despesas') ?>" rel="countrycontainer">Despesas</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=pagamentosEmAtraso') ?>" rel="countrycontainer">Pagamentos em atraso</a></li>
    <li><a href="<?php echo url_for('@default?module=relatorio&action=fluxoCaixa') ?>" rel="countrycontainer">Fluxo de Caixa</a></li>
</ul>
<div id="countrydivcontainer" style="height: 600px; overflow-y: scroll; border:1px solid gray; width:98%; margin-bottom: 1em; padding: 1px; padding-top: 15px;">
    
</div>

<script type="text/javascript">

var countries=new ddajaxtabs("countrytabs", "countrydivcontainer")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>


