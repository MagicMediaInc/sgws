<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>

<?php use_javascript('fancybox/jquery.fancybox.js') ?>

<?php use_javascript('jq/jQuery.print.js') ?>



<script type="text/javascript">

    $(document).ready(function() {

        

        $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false});

        $('#resultsList td').addClass('borderBottomDarkGray');

	$("#from_date").datepicker({   

            defaultDate: "+1w",

            dateFormat: 'dd-mm-yy',        

            changeMonth: true,

            changeYear: true,

            onClose: function( selectedDate ) {

                $( "#to_date" ).datepicker( "option", "minDate", selectedDate );

            }

        });    

        $("#to_date").datepicker({

            defaultDate: "+1w",

            dateFormat: 'dd-mm-yy',          

            changeMonth: true,

            changeYear: true,

            onClose: function( selectedDate ) {

                $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );

                if(!$("#from_date").val())

                    {

                        $( "#from_date" ).val($("#to_date").val());

                    }

            }

        });

        

        $('.compensacion').hide();

        $('.compensacion_all').hide();

        $('.footer-list').hide();

        $('#prestacao_contas').click(function() {

            $("#filtro-contable").submit();

        });

        $('#compensar').click(function() {

            if ($(this).is(':checked')) {

                //return confirm("Are you sure?");

                if($("#funcionario").val())

                    {

                        $('.compensacion').show();

                        $('.compensacion_all').show();

                        $('.footer-list').show();

                        $('.msn_info').show();

                        $('.msn_error').hide();

                        $('.no_compensa').hide();

                    }else{

                        $('.no_compensa').show();

                        $('.msn_error').show();

                        $(this).attr('checked', false);

                    }

            }else{

                $('.no_compensa').show();

                $('.compensacion').hide();

                $('.compensacion_all').hide();

                $('.footer-list').hide();

                $('.msn_info').hide();

            }

        });

        $(".chk_saida").click(function() {

            calculoTotalCompensacion();

        });

        $("#funcionario").change(function() {

            if($(this).val())

            {

                $('.msn_error').hide();

            }

            

        });

         $("#hrefPrint").click(function() {

            // Print the DIV.

            $(".no_print").hide();

            $("#printdiv").print();

            return (false);

        });

        $(".frameForm").mouseover(function(){

            $('.no_print').show();

            

            $('#datos-func').hide();

        });



    });

     

    

    

</script>

<style type="text/css">

    @import url("/css/main.css");

</style>

<h1 class="icono_projeto"><?php echo __('Prestações de Contas') ?></h1>

<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/newFinanciero') ?>">Inclusão de Entradas/Saídas</a>



<?php if ($sf_user->hasFlash('listo')): ?>

    <div class="msn_ready" ><?php echo $sf_user->getFlash('listo') ?></div>

<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>

    <div class="msn_error" ><?php echo $sf_user->getFlash('error') ?></div>

<?php endif; ?>

    

<div class="frameForm">

    

    <!--filtro de busqueda-->

    <table cellpadding="0" cellspacing="0" border="0" width="100%">

        <tr>

            <td>

                <form action="" method="POST" id="filtro-contable">

                    <div class="propiedades propiedades-extend" style="width: 100%; border: 0px; height: 80px;">

                        <h2 class="titulo"><?php echo __('Filtros') ?></h2>

                        <table width="100%" >

                            <tr>

                                <td style="width: 9%;">

                                    <label style="color: #333; font-weight: bold;"> <?php echo __('De') ?></label><br />
                                    <input size="8" type="text" name="from_date" id="from_date" value="<?php echo $sf_request->getParameter('from_date') != null ? $sf_request->getParameter('from_date') : '' ?>" >

                                </td>

                                <td style="width: 9%;">

                                    <label style="color: #333; font-weight: bold;"> <?php echo __('Até') ?></label><br />

                                    <input size="8" type="text" name="to_date" id="to_date" value="<?php echo $sf_request->getParameter('to_date') != null ? $sf_request->getParameter('to_date') : '' ?>" >

                                </td>

                                <td align="left"><br />

                                    <input type="submit" name="buscar" id="buscar" value="Buscar" />

                                    <a href="<?php echo url_for('despesa/saidas') ?> "><?php echo __('Veja todo') ?></a>

                                </td>

                            </tr>            

                        </table>

                    </div>

                </form>

            </td>

        </tr>

    </table>

    <!--cierre filtro de busqueda-->

    <br />

    <div id="printdiv" class="printable">

    <form action="<?php echo url_for('@default?module=despesa&action=compensar') ?>" method="POST">

    <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">

        <thead>

            <tr>

            <tr>

                <th style="background-color: #5092bd; width: 1%;">&nbsp;</th>

                <th style="width: 40%;">Funcionario</th>



                <th style="width: 20%;">Entradas</th>
                <th style="width: 20%;">Saidas</th>
                <th style="width: 20%;">Total</th>



                <!-- <th style="width: 3%;">&nbsp;</th> -->

            </tr>

        </thead>

        <tbody>

            <?php if(count($result)): ?>

                <?php $totalE = 0; ?>
                <?php $totalS = 0; ?>
                <?php $total = 0; ?>

                <?php foreach ($result as $valor): ?>

                <tr>

                    <td>&nbsp;</td>

                    <td>

                        <?php echo $valor['funcionario'] ?>

                    </td>

                    <td>

                    	<?php $totalE += $valor['entradas'] ?>
                        R$ <?php echo aplication_system::monedaFormat($valor['entradas'],2,",",".") ?>

                    </td>

                    <td>

                    	<?php $totalS += $valor['saidas'] ?>
                        R$ <?php echo aplication_system::monedaFormat($valor['saidas'],2,",",".") ?>

                    </td>

                    <td>
	
                    	<?php $total += $valor['entradas']-$valor['saidas'] ?>
                        R$ <?php echo aplication_system::monedaFormat($valor['entradas']-$valor['saidas'],2,",",".") ?>

                    </td>

       
					<!-- 
                    <td class="no_print">                        

                        <a href="<?php echo url_for('@default?module=despesa&action=editFinanciero&id='.$valor['id']) ?>">

                            <?php echo image_tag('icons/informacoe','width=20') ?>

                        </a>

                    </td> -->

                </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="10"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>

                </tr>

            <?php endif; ?>

        </tbody>

        <tfoot>

            <tr>

                <td class="right">&nbsp;</td>

                <td class="sum-entrada sum">TOTAL </td>

                <td class="sum-saida sum">R$ <?php echo aplication_system::monedaFormat($totalE) ?></td>
                <td class="sum-saida sum">R$ <?php echo aplication_system::monedaFormat($totalS) ?></td>
                <td class="sum-saida sum">R$ <?php echo aplication_system::monedaFormat($total) ?></td>

                <td class="sum">&nbsp;</td>

            </tr>

            

        </tfoot>

    </table>

    </form>

    </div>

    <div class="space-print">

        <a href="#" id="hrefPrint" rel="content-area-print">Imprimir <?php echo image_tag('icons/print','width="30" style="position: relative; top: 9px;"') ?></a>

    </div>

</div>