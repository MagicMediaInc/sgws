<?php use_stylesheet('tableBilability.css') ?>
<style>
    .wmd-view-topscroll, .wmd-view {
        overflow-x: scroll;
        overflow-y: hidden;
        width: 100%;
        border: none 0px RED;
    }

    .wmd-view-topscroll { height: 20px; }
    .wmd-view { height: 2000px; overflow-y: auto;}
    .scroll-div1 { 
        width: 2000px; 
        overflow-x: scroll;
        overflow-y: hidden;
    }
    .scroll-div2 { 
        width: 2000px; 
        height:20px;
        
    }
</style>
<script type="text/javascript"> 
$(function(){
    $(".wmd-view-topscroll").scroll(function(){
        $(".wmd-view")
            .scrollLeft($(".wmd-view-topscroll").scrollLeft());
    });
    $(".wmd-view").scroll(function(){
        $(".wmd-view-topscroll")
            .scrollLeft($(".wmd-view").scrollLeft());
    });
});

</script>
<h1>Relatório Bilability</h1>
<br />
<?php include_partial('filtroAno', array('anos' => $anos, 'anoSelected' => $anoSelected)) ?>
<div class="wmd-view-topscroll">
    <div class="scroll-div1">
    </div>
</div>
<div class="wmd-view">
    <div class="scroll-div2">
<table cellpadding="0" cellspacing="0" border="0"  id="bilability" style="border: 1px solid #333; width: 1930px;">
    <thead>
        <tr>
            <th rowspan="2" style="width: 12%; padding-left: 4px;">                
                <?php echo link_to(__('Funcionários'),'@default?module=relatorio&action=bilability&sort=name&by='.$by) ?>
                <?php if($sort == "name"){ echo image_tag($by_page); }?>
            </th>
            <th rowspan="2" class="">
                <?php echo link_to(__('Cargo'),'@default?module=relatorio&action=bilability&sort=cargo&by='.$by) ?>
                <?php if($sort == "cargo"){ echo image_tag($by_page); }?>
            </th>
            <?php for($i =  1; $i <=12; $i++): ?>
            <?php $nMes = globalFunctions::zerofill($i,2) ?>
            <?php $horasBilability = HorasBillabilityPeer::getAnoHorasMes($ano); ?>
            <?php $getMes = 'getMes'.$i; ?>
            <th class="center" colspan="2"><?php echo lynxValida::nombreMes($nMes) ?> - <?php echo $horasBilability->$getMes() ?></th>
            <?php endfor; ?>
            
            <th colspan="2" rowspan="2" style="background-color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th colspan="2">Media <?php echo aplication_system::monedaFormat($media) ?></th>
            <th rowspan="2" >Meta</th>
            <th rowspan="2" >M. Atingida?</th>
        </tr>
        <tr>
            <?php for($i =  1; $i <=12; $i++): ?>
                <th>HT</th>
                <th>%</th>
            <?php endfor; ?>
            <th>HT</th>
            <th>%</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $k => $v): ?>
            <tr>
                <td><?php echo $k ?></td>
                
                <?php foreach ($v as $key => $val): ?>
                
                <td><?php echo $key ?></td>
                    <?php $i = 1; ?>
                    <?php foreach ($val as $cl): ?>
                        
                        <?php $bckColor = $i <= date("m") ? 'azure' : 'white' ?>
                        
                        
                        <?php if($i <= 13): ?>
                            <?php if($i == 13): ?>
                                <?php $pMedia = $cl[1] ?>
                            <?php endif; ?>
                            
                            <td style="background-color: <?php echo $bckColor ?>"><?php echo $cl[0]?></td>
                            <td style="background-color: <?php echo $bckColor ?>"><?php echo aplication_system::monedaFormat($cl[1]) ?></td>
                            <?php if($i == 12): ?>
                            <td colspan="2"></td>
                            <?php endif; ?>
                        <?php else: ?>
                            
                            <?php if($i == 14 ): ?>
                                    <?php $atingida = $pMedia > $cl ? 'Si' : 'Não' ?>
                                
                            <?php endif; ?>
                            
                            <td><?php echo $i == 14 ? $cl.'%' : $atingida;   ?></td>
                        <?php endif; ?>
                        
                        <?php $i++ ?>
                    <?php endforeach; ?>
                
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    </div>
</div>