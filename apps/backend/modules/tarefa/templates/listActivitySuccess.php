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

<h1 class="tit-principal">lista de atividades da tarefa</h1>
<?php if ($sf_user->hasFlash('listo')): ?>    
  <div class="msn_ready">
    <?php echo $sf_user->getFlash('listo') ?>
  </div>
<?php endif; ?>
<div class="frameForm" align="left" style="margin-bottom: 30px;">    
  <div>    
    <label>Tarefa</label>    
  </div>    
  <div class="mask-imput" style="width: 45%; float: left;" >
    <?php echo $descricao->getTarefa() ?>
  </div>
  <?php if(/*$projeto->getStatus() < 6 AND */$tarefa->getStatus() < 6): ?>
    <div style="width: 50%; float: left;" >
        <a class="btn-adicionar-no-relative" href="<?php echo url_for($this->getModuleName().'/activity?codigotarefa='.$sf_request->getParameter('codigotarefa')) ?>"><?php echo __('Nova Atividade')?></a>
    </div>    
  <?php endif; ?>
</div>
<div class="clear" style="margin-top: 15px;"></div>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">  
  <thead>    
    <tr>        
      <th>&nbsp;</th>        
      <th style="width: 10%;">Data</th>        
      <th style="width: 25%;">Responsável</th>        
      <th style="width: 10%;">Hs. Trab</th>        
      <th style="width: 35%;">Descrição</th>        
      <th style="width: 5%;">GP</th>        
      <th style="width: 15%;">Ações</th>    
    </tr>  
  </thead>  
  <tbody>    
    <?php if($lista): ?>       
      <?php foreach ($lista as $actividad): ?>        
        <tr>            
          <td class="borderBottomDarkGray">&nbsp;</td>            
          <td class="borderBottomDarkGray"><?php echo $valida->formatoFechaPT2($actividad->getDatareal())  ?></td>            
          <td class="borderBottomDarkGray">                <?php $usu = LxUserPeer::retrieveByPK($actividad->getCodigofuncionario())  ?>                <?php echo $usu->getName() ?>            </td>            
          <td class="borderBottomDarkGray"><?php echo $actividad->getTempogasto() ?></td>            
          <td class="borderBottomDarkGray">                <?php echo substr($actividad->getObservacoes(), 0,50)  ?>...            </td>            
          <td class="borderBottomDarkGray" id="status_<?php echo $actividad->getCodigoregistro() ?>">                
            <?php $st = $actividad->getAutorizado() ? '1' : '0' ; ?>                
            <!-- Solo pueden aprobar las actividades el gerente del proyecto y todos los perfiles socios 13-01-2014  -->                
            <?php if(aplication_system::getUser() == $gerenteProyecto || aplication_system::esSocio()): ?>                    
              <?php echo jq_link_to_remote(image_tag($st.'.png','alt="" title="" border=0'), array(                        
                'update'  =>  'status_'.$actividad->getCodigoregistro(),                        
                'url'     =>  'tarefa/autorizaActividad?id_actividad='.$actividad->getCodigoregistro().'&status='.$actividad->getAutorizado(),                        
                'script'  => true,                        
                'before'  => "$('#status_".$actividad->getCodigoregistro()."').html('". image_tag('preload.gif','title="" alt=""')."');"                    
                ));                    
              ?>                
            <?php else: ?>                    
              <?php echo image_tag($st.'.png','alt="" title="" border=0') ?>                
            <?php endif; ?>            
          </td>           
          <td class="borderBottomDarkGray">                
            <?php if((aplication_system::compareUserVsResponsable($actividad->getCodigoFuncionario()) && !$actividad->getAutorizado() )  || aplication_system::getUser() == $gerenteProyecto || aplication_system::esSocio() ): ?>                    
              <?php echo link_to(__('Editar'),'tarefa/activity?codigotarefa='.$sf_request->getParameter('codigotarefa').'&id_actividad='.$actividad->getCodigoregistro() ) ?>                
              &nbsp;|&nbsp;<?php echo link_to(__('Delete'),'tarefa/deleteActivity?id_actividad='.$actividad->getCodigoregistro(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que deseja excluir os dados selecionados?'))) ?>                
            <?php endif; ?>            
          </td>        
        </tr>      
      <?php endforeach; ?>    
    <?php else: ?>        
      <tr>            
        <td colspan="12"  class="center">
          <span class="erro_no_data" >Sua busca não gerou resultados</span>
        </td>        
      </tr>    
    <?php endif; ?>   
  </tbody>  
</table>