<h1 class="tit-principal">Edição de tarefa #<?php echo $sf_request->getParameter('codigotarefa') ?></h1>

<h2>Projeto <?php echo $codigoProjeto ?> </h2>

<div class="clear"></div>



<form id="tarefa" action="<?php echo url_for('tarefa/delete'.(!$form->getObject()->isNew() ? '?codigotarefa='.$form->getObject()->getCodigotarefa() : '')) ?>"

    method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<style>
  #contentPpal{
    min-width: 0px !important;
    width: 0% !important;
  }
  .requerido{
    display: block;
    height: 42px;
    padding:10px 5px;
  }
  .container{
    width: 100%;
  }
  .divtitles{
    margin-right: 10px;
    display: inline-block;
    width: 135px;
    vertical-align: middle !important;
  }
  .divcontens{
    display: inline-block;
  }
  .row{
    /*vertical-align: middle;*/
    /*margin-bottom: 10px;*/
    padding:5px 0px 5px 20px;
  }
  .grey{
    background: #eee;
  }
</style>

	<label> ¿Deseja deletar esta tarefa?</label>
	<input id="sim" type="submit" value="Sim"/>
	<button id="nodeletar" >Não</button>

</form>

<script type="text/javascript">
	$(document).on('ready', function(){
		$('#nodeletar').on('click', function(e){
			e.preventDefault();
			console.log("click");
			console.log($('div#conteint').parent().parent().parent());
			console.log($('.fancybox-close'));
		});		
		$('.fancybox-close').click();
	});
</script>
