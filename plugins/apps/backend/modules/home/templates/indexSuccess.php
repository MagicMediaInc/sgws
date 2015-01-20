<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>
<?php use_javascript('fancybox/jquery.fancybox.js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false});
    });
</script>
<h1 class="icono_sistema"><?php echo __('inicio') ?></h1>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for('@default?module=projeto&action=analisisCritico') ?>"> Incluir Proposta</a>
<div id="title_module" style="margin-top:  0px;">
    <div class="home-span">
        <h2 style="margin-left: 31px;">ALERTAS E NOTIFICAÇÕES</h2>
         <div class="info alertas" style="font-size: 12px;">
             <span class="alert">Novas notificações </span><br />
             <span class="alert">Despesas a aprovar</span> <br />
             <span class="alert">Faturamentos</span> <br />
         </div>
        <div class="total">
             <span style="font-size: 13px;"><?php echo $notis ?></span><br />
             <span style="font-size: 13px;"><?php echo $alertaDespesa ?></span><br />
             <span style="font-size: 13px;"><?php echo $alertaFaturamentos ?></span><br />
         </div>
        <div class="see-more" style="margin-top: 0px;"><a href="<?php echo url_for('@default_index?module=notificacion') ?>">Ver mais</a></div>   
    </div>
    <div class="home-span">
        <h2>MEUS INDICADORES</h2>
         <div class="info alertas" style="font-size: 12px; padding-top: 13px;">
             <span class="alert">Billability do mês</span><br />
             <span class="alert">Media Anual</span> <br />
             <span class="alert">Meta Billability</span> <br />
         </div>
        <div class="total" style="padding-top: 13px;">
             <span style="font-size: 13px;"><?php echo $horasBilabilityMes ?></span><br />
             <span style="font-size: 13px;"><?php echo $mediaAnual ?></span><br />
             <span style="font-size: 13px;"><?php echo $meta ?></span><br />
         </div>
         
    </div>
    <div class="home-span">
         <div class="horas"></div>
         <div class="info">
             <span><?php echo $meusProjetos ?></span><br />
             projetos
         </div>
         <div class="see-more"><a href="<?php echo url_for('@default_index?module=projeto') ?>">Ver mais</a></div> 
    </div>
    <div class="home-span">
         <div class="despesa"></div>
         <div class="info">
             <span style="font-size: 27px;"><?php echo aplication_system::monedaFormat($minhasDespesas) ?></span><br />
             minhas despesas
         </div>
         <div class="see-more"><a href="<?php echo url_for('@default_index?module=contas') ?>">Ver mais</a></div>   
    </div>
    <?php if($lastUpdateTimeSheet): ?>
    <div class="home-span">
         
         <div class="info-date">
             <span><?php echo date('d-m-Y', strtotime($lastUpdateTimeSheet))  ?></span><br />
             última atualização timesheet 
         </div>
         
    </div>
    <?php endif; ?>
</div>

