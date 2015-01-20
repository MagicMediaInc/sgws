/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Muestra las opciones Edit - Delete - Entre otras de los listados de los diferentes modulos
 */
var tmpStyle;
var url = 'http://'+location.hostname+'/backend_dev.php/';

function goBack()
{
    window.history.back();
}

    
function overRow(item)
{
    $(".row-actions_" + item).show();
    /*tmpStyle = $("#row_style_" + item).attr('class');
    $("#row_style_" + item).attr('class','bgList');*/
}
/**
 * Oculta las opciones Edit - Delete - Entre otras de los listados de los diferentes modulos
 */
function outRow(item)
{    
    $(".row-actions_" + item).hide();
    /*$("#row_style_" + item).attr('class',tmpStyle);*/
}
/**
 * Muestra los privilegios
 */
function viewInfoSection()
{
    $(".informationSection").show();
    $("#viewInfoSection").hide();
    $("#noViewInfoSection").show();
}

function noViewInfoSection()
{
    $(".informationSection").hide();
    $("#viewInfoSection").show();
    $("#noViewInfoSection").hide();
}


/**
 * Muestra los privilegios
 */
function showPrivileges(item)
{
    $(".permissions_" + item).show();
    $("#displayPrivActive_" + item).hide();
    $("#displayPrivDesactive_" + item).show();
}
/**
 * Oculta los privilegios
 */
function hidePrivileges(item)
{
    $(".permissions_" + item).hide();
    $("#displayPrivActive_" + item).show();
    $("#displayPrivDesactive_" + item).hide();
}
/**
 * Oculta el mensaje de actualizacion de privilegios
 */
function fadeMessage(secuence)
{
    $("#message_" + secuence).hide();

}

function fadeMessageSimple(secuence)
{
    $("#message").hide();

}
/**
 * Ajax para registrar los nuevos permisos
 */
function submitPermissions(module,priv,profile)
{
    // Detecto el status del check, checked o unchecked
    var checkSelected = $("#chk_" + module + "_" + priv + ":checked").val();
    var privPpal = 0;
    if(!checkSelected){
        checkSelected = 0;
    }
    // Si el privilegio seleccionado es distinto de 1(View), lo activo
    if(priv != 1)
        {
            $("#chk_" + module + "_1").attr('checked',true);
            privPpal = 1; // Me indica que en la accion debo agregar otra permisologia con id_privelege = 1
        }
    // Si el privilegio seleccionado es igual a 1(View) y lo estoy desactivando, entonces desactivo el resto
    if(priv == 1 && checkSelected !=1)
        {
            $("#chk_" + module + "_2").attr('checked',false);
            $("#chk_" + module + "_3").attr('checked',false);
            $("#chk_" + module + "_4").attr('checked',false);
        }
    // Ajax para guardar los cambios de permisologia
    $(function(){
        $.ajax({
          type: "POST",
          url: "lxprofile/changePrivileges?id_module=" + module + "&id_privilege=" + priv + "&id_profile=" + profile + "&status=" + checkSelected + "&privPpal=" + privPpal,
          dataType: "script",
          beforeSend: function(objeto){
                $("#message_" + module).html("Wait ...");
          },
          success: function(msg){
                $("#message_" + module).animate({width:150, height:10}, "slow");
                $("#message_" + module).html('<div>Saved &nbsp;&nbsp;&nbsp; <a href="#" onclick="fadeMessage(' + module + ' );">Hide</a></div>');                
          },
          error: function(objeto, quepaso, otroobj){
                $("#message_" + module).animate({width:150, height:10}, "slow");
                $("#message_" + module).html('<div>Error. Please update browser&nbsp;&nbsp;&nbsp; <a href="#" onclick="fadeMessage(' + module + ' );">Hide</a></div>');
          }

        });
    });
}


function submitPermissionsUser(module,iduser)
{
    // Detecto el status del check, checked o unchecked
    var checkSelected = $('input[name=chk_' + module + ']').is(':checked');
    var privPpal = 0;
    if(!checkSelected){
        checkSelected = 0;
    }else{
        checkSelected = 1;
    }
    // Ajax para guardar los cambios de permisologia del usuario
    $(function(){
        $.ajax({
          type: "POST",
          url: "lxuserpermission/changePermissionUser?id_module=" + module + "&id_user=" + iduser + "&status=" + checkSelected,
          dataType: "script",
          beforeSend: function(objeto){
                $("#message_" + module).html("Wait ...");
          },
          success: function(msg){
                $("#message_" + module).animate({width:150, height:10}, "slow");
                $("#message_" + module).html('<div>Dados armazenados &nbsp;&nbsp;&nbsp; <a href="#" onclick="fadeMessage(' + module + ' );">Ocultar</a></div>');                
          },
          error: function(objeto, quepaso, otroobj){
                $("#message_" + module).animate({width:150, height:10}, "slow");
                $("#message_" + module).html('<div>Error. Por favor, atualize navegador&nbsp;&nbsp;&nbsp; <a href="#" onclick="fadeMessage(' + module + ' );">Ocultar</a></div>');
          }

        });
    });
}

function setValPermissionModule(type, module){
    $("#val-perm-" + module).val(type);
    var permSelect = $("#val-perm-" + module).val();
    if(permSelect == 3)
    {
        $("#chk_" + module + "_1").attr('checked',false);            
        $("#chk_" + module + "_2").attr('checked',false);            
    }   
    // Ajax para guardar los cambios de permisologia del usuario
    $(function(){
        $.ajax({
          type: "POST",
          url: "updateTypeUser?id_module=" + module + "&type=" + type,
          dataType: "script",
          beforeSend: function(objeto){
                $("#message_" + module).show();
                $("#message_" + module).html("Processamento ...");
          },
          success: function(msg){
                //$("#message_" + module).animate({width:150, height:10}, "slow");
                $("#message_" + module).html('Privilégio atualizado&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" onclick="fadeMessage(' + module + ' );"><image src="/images/delete.png" border="0" style="position: relative;top: 3px;" /> </a>');                
          },
          error: function(objeto, quepaso, otroobj){
                //$("#message_" + module).animate({width:150, height:10}, "slow");
                $("#message_" + module).hide();                
                $("#message_" + module).html('Error. Por favor, atualize navegador&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" onclick="fadeMessage(' + module + ' );">Ocultar</a>');
          }

        });
    });
}

function submitPermissionsPessoa(module, priv, tipoPermiso)
{
    var url = 'http://'+location.hostname+'/backend_dev.php/';
    //var tipoPermiso = $("#val-perm-" + module).val();
    var tipoPermiso = tipoPermiso;
    // Detecto el status del check, checked o unchecked
    var checkSelected = $("#chk_" + module + "_" + priv + "_" + tipoPermiso + ":checked").val();

    if(!tipoPermiso)
    {
        $("#message_" + module).show();
        $("#message_" + module).html('Selecione privilégio &nbsp; <a href="javascript:void(0);" onclick="fadeMessage(' + module + ' );"><image src="/images/delete.png" border="0" style="position: relative;top: 3px;" /> </a>');
        //restauro el valor del check a su estado actual
        if(checkSelected)
        {
            $("#chk_" + module + "_" + priv).attr('checked',false);            
        }else{
            $("#chk_" + module + "_" + priv).attr('checked',true);
        }
    }else{
        var privPpal = 0;
        if(!checkSelected){
            checkSelected = 0;
        }
        // Si el privilegio seleccionado es distinto de 1(View), lo activo
        if(priv != 1 && tipoPermiso == 1)
            {
                $("#chk_" + module + "_1_1").attr('checked',true);
                privPpal = 1; // Me indica que en la accion debo agregar otra permisologia con id_privelege = 1
            }
        if(priv != 1 && tipoPermiso == 2)
            {
                $("#chk_" + module + "_1_2").attr('checked',true);
                privPpal = 1; // Me indica que en la accion debo agregar otra permisologia con id_privelege = 1
            }
        // Si el privilegio seleccionado es igual a 1(View) con VISION GENERal y lo estoy desactivando, entonces desactivo el resto
        if(priv == 1 && tipoPermiso == 1 && checkSelected !=1)
            {
                $("#chk_" + module + "_2_1").attr('checked',false);            
            }
        // Si el privilegio seleccionado es igual a 1(View) CON VISIO PROPIA y lo estoy desactivando, entonces desactivo el resto
        if(priv == 1 && tipoPermiso == 2 && checkSelected !=1)
            {
                $("#chk_" + module + "_2_2").attr('checked',false);            
            }
        // Ajax para guardar los cambios de permisologia del usuario
        $(function(){
            $.ajax({
              type: "POST",
              url: url + "permisos/changePermissionUser?id_module=" + module + "&id_privilege=" + priv + "&status=" + checkSelected + "&privPpal=" + privPpal + "&type=" + tipoPermiso,
              dataType: "script",
              beforeSend: function(objeto){
                    $("#message_" + module).show();
                    $("#message_" + module).html("Processamento ...");
              },
              success: function(msg){
                    //$("#message_" + module).animate({width:150, height:10}, "slow");
                    $("#message_" + module).html('Dados armazenados &nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" onclick="fadeMessage(' + module + ' );"><image src="/images/delete.png" border="0" style="position: relative;top: 3px;" /> </a>');                
              },
              error: function(objeto, quepaso, otroobj){
                    //$("#message_" + module).animate({width:150, height:10}, "slow");
                    $("#message_" + module).hide();                
                    $("#message_" + module).html('Error. Por favor, atualize navegador&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" onclick="fadeMessage(' + module + ' );">Ocultar</a>');
              }

            });
        });
    }    
}

function changeCategoryInNuclueByNews(idnucleo, idnews)
{
    // Detecto el status del check, checked o unchecked
    var category = $("#category").val();
    var url = 'http://'+location.hostname+'/backend_dev.php/';
    // Ajax para guardar los cambios de permisologia del usuario
    $(function(){
        $.ajax({
          type: "POST",
          url: url +"news/changeCategoryInNuclueByNews?id_news=" + idnews + "&id_nucleo=" + idnucleo + "&category=" + category,
          dataType: "script",
          beforeSend: function(objeto){
                $("#message").html("Wait ...");
          },
          success: function(msg){
                $("#message").animate({width:400, height:10}, "slow");
                $("#message").html('<div class="msn_ready">Dados armazenados</div>');       
                
          },
          error: function(objeto, quepaso, otroobj){
                $("#message").animate({width:400, height:10}, "slow");
                $("#message").html('<div class="msn_error">Error. Por favor, atualize navegador&nbsp;</div>');
          }
        });
    });
}

function uploadItem(moduleAction)
{
    var url = 'http://'+location.hostname+'/backend_dev.php/';
    var urlUpload = url + moduleAction;
    var btnUpload=$('#upload_image');
    var status=$('#mimeError');
    new AjaxUpload(btnUpload, {
    action: urlUpload,
    name: 'uploadfile',
    dataType: 'html',
    onSubmit: function(file,ext){
    //if there is an error
    if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
        status.show();
        status.animate({opacity: 5000}, 0)
        status.animate({opacity: 0}, 7000);
        return false;
    }
    $('#preLoad').show();
    btnUpload.css("display","none");
    $('#msg_upload').css("display","none");
    $('#wait').css("display","");
    $('#wait').html("&nbsp;&nbsp;Wait until the upload image...");
    },
    onComplete: function(file, response){
    $('#preLoad').hide();
    //Add uploaded file to list
    $('#image_poster').append(response);
    $('#preLoad').remove().appendTo("#image_poster");
    $('#no_foto').fadeOut('');
    btnUpload.css("display","");
    $('#wait').css("display","none");
    $('#msg_upload').css("display","");
    }
    });
}

function removeTableRow(trId){
    $('#fila-' + trId).remove();
}


function cargaTareas(fila, totfilas)
{
    $(".fila-" + fila).val('');
    $(".fila-" + fila).attr('disabled','disabled');
    var id_projeto = $("#cod_projeto_" + fila).val();
    getTarefas(fila, totfilas , id_projeto, '');        
}

function getTarefas(fila, totfilas , id_projeto, bydefault)
{
    $(function(){
        $.ajax({
          type: "POST",
          url: url + "tarefa/getTarefas",
          data: "id_projeto="+ id_projeto,
          dataType: "html",
          beforeSend: function(objeto){
                $("#cod_tarefa_" + fila).attr('disabled','disabled');  
                //$("#cod_tarefa_" + fila + " > option").remove();  
                //$("#cod_tarefa_" + fila).append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
                $("#cod_tarefa_" + fila).attr('disabled',false);  
                $("#cod_tarefa_" + fila + " > option").remove();  
                $("#cod_tarefa_" + fila).html(msg);    
                if(bydefault)
                {
                    $('#cod_tarefa_' + fila + ' option[value="' + bydefault + '"]').attr("selected", "selected");
                }
                ordenaComboTarea(fila, totfilas);
                calcular_total();
          }
        });
    });
}

function ordenaComboTarea(fila, totfilas)
{
    
    for(var i = 1; i <= totfilas ; i++){
        if(i != fila) // No valido la fila actual
            {
                /**
                 * Si el codigo de proyecto que se esta recogiendo es igual
                 * al que estoy manipulando, Remueve las tareas que ya tienen
                 */
                if($("#cod_projeto_" + i).val() == $("#cod_projeto_" + fila).val())
                {
                    if($('#cod_tarefa_' + i).val())
                    {
                        $("#cod_tarefa_" + fila + " option[value='"+ $('#cod_tarefa_' + i).val() +"']").remove();
                    }
                }
            }
    }   
}

function actualizaComboTarea(fila, totfilas)
{
    for(var i = 1; i <= totfilas ; i++){
        if(i != fila) // No valido la fila actual
            {
                /**
                 * Si el codigo de proyecto que se esta recogiendo es igual
                 * al que estoy manipulando, Remueve las tareas que ya tienen
                 */
//                if($("#cod_projeto_" + i).val() == $("#cod_projeto_" + fila).val())
//                {
                    var id_projeto = $("#cod_projeto_" + i).val();
                    var id_tarea = ($('#cod_tarefa_' + i).val());
                    getTarefas(i, totfilas , id_projeto, id_tarea);
                   
                        //$("#cod_tarefa_" + i + " option[value='"+ $('#cod_tarefa_' + fila).val() +"']").remove();
                    
//                }
                 
            }
    }   
}

function actualizaComboTareaDespesa(fila, totfilas, id_projeto)
{   
    for(var i = 1; i <= totfilas ; i++){
        if(i != fila) // No valido la fila actual
            {
                var id_tarea = ($('#cod_tarefa_' + i).val());
                
                getTarefas(i, totfilas , id_projeto, id_tarea);
            }
    }   
}

function cargaActividades(fila, totfilas)
{
    $(".fila-" + fila).val('');
    $(".fila-" + fila).attr('disabled','');
    var url = 'http://'+location.hostname+'/backend_dev.php/';
    var cod_tarefa = $("#cod_tarefa_" + fila).val();
    var fecha = $("#fecha-inicio-semana").val();
    var fechaFin = $("#fecha-fin-semana").val();
    if(cod_tarefa)
        {
            $(function(){
                $.ajax({
                  type: "POST",
                  url:  url + "tarefa/buscaActividad",
                  dataType: "script",
                  data: "cod_tarefa=" + cod_tarefa + "&fila=" + fila + "&fecha=" + fecha + "&fechaFin=" + fechaFin,
                  success: function(msg){
                      $("#result").html(msg)
                      calcular_total();
                      actualizaComboTarea(fila, totfilas);
                      cargaTerefasUser(fecha);
                  }
                });
            });
        }else{
            $(".fila-" + fila).attr('disabled','disabled');
            calcular_total();
            actualizaComboTarea(fila, totfilas);
        }
}


function cargaTerefasUser(fecha, valor)
{
            var url = 'http://'+location.hostname+'/backend_dev.php/';
            //$.get(url + "tarefa/horasTarefas/?fecha=" + fecha)        
//            function (data) {
//                $("#tarefas_user").html("data");
//         console.log("action.not.complete");
//            }
            $.get(url + "tarefa/horasTarefas/?fecha=" + fecha+"&val=" + valor, function( data ) {
            $("#tarefas_user").html(data);
            });


}

function calculaSubtotales()
{
    for(var i = 0; i <= 6; i++){
        totalCol = 0;
        $(".col-" + i).each(

            function(index, value) {
                totalCol = totalCol + Number($(this).val());
            }
        );
        $("#tot-" + i).html(totalCol);    
    } 
}
    

function calcular_total() {
    total = 0
    $(".tiempo-horas").each(
            function(index, value) {
                    total = total + Number($(this).val());
            }
    );
    
    $("#total_horas_semana").html(total);
    calculaSubtotales();
}

function guardaComentario(idnot)
{
    var comentario = $("#text-coment-" + idnot).val();
    var url_fun = 'http://'+location.hostname+'/backend_dev.php';
    $.ajax
    ({
        type: "POST",
        url:  url_fun + "/notificacion/criaResposta",
        data: "id_notificacion="+ idnot + "&texto=" + comentario,
        beforeSend: function(objeto){
            $("#list-comentarios-" + idnot).html("<img src='/images/loading.gif' border='0' /> ");
            $("#form-comentarios-" + idnot).hide();
        },
        success: function(msg){            
            totalRespostas(idnot);
            cargaRespostas(idnot);
            $("#text-coment-" + idnot).val('');
        },
        error: function(objeto, quepaso, otroobj){
            
        }
    });    
}

function cargaRespostas(idnot)
{
    var url_fun = 'http://'+location.hostname+'/backend_dev.php';
    $.ajax
    ({
        type: "GET",
        url:  url_fun + "/notificacion/listaRespostas?id_notificacion=" + idnot,
        beforeSend: function(objeto){
            $("#list-comentarios-" + idnot).html("<img src='/images/loading.gif' border='0' /> ");
        },
        success: function(msg){
            $("#list-comentarios-" + idnot).html(msg);
        }
    });    
}

function totalRespostas(idnot)
{
    var url_fun = 'http://'+location.hostname+'/backend_dev.php';
    $.ajax
    ({
        type: "GET",
        url:  url_fun + "/notificacion/totalRespostas?id_notificacion=" + idnot,
        beforeSend: function(objeto){
            //$("#tot-" + idnot).html("");
        },
        success: function(msg){
            $("#tot-" + idnot).html(msg);
            if(msg > 0)
                {
                    $("#toogle-" + idnot).show();
                }else{
                    $("#toogle-" + idnot).hide();
                }
        }
    });    
}


function deleteComentario(idresp, idnot)
{
    var url_fun = 'http://'+location.hostname+'/backend_dev.php';
    $.ajax
    ({
        type: "GET",
        url:  url_fun + "/notificacion/deleteResposta?id_resposta=" + idresp,
        beforeSend: function(objeto){
            $("#resposta-" + idresp).html('Comentario Deletado');
        },
        success: function(msg){
            $("#resposta-" + idresp).html('');
            $("#resposta-" + idresp).hide();
            totalRespostas(idnot);
        }
    });    
}

//Logica para tipos

function cargaTipos(id_default, operacao )
{
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getTipos",
          data: "operacao=" + operacao,
          dataType: "html",
          beforeSend: function(objeto){
              $('.tipos').each(function(){
                    $(this).append("<option value=''>Carregando...</option>");
              });
          },
          success: function(msg){
              $('.tipos').each(function(){
                    $(this).html(msg);
                    if(id_default > 0)
                        {
                            $('.tipos option[value="' + id_default + '"]').attr("selected", "selected");
                        }
                });
          }
        });
    });
}
function cargaSubTipos(obj)
{
    var tipo = obj.val();
    var fila = obj.attr('fila');
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getSubTipos",
          data: "id_tipo="+ tipo,
          dataType: "html",
          beforeSend: function(objeto){
              $("#subtipo-" + fila + " > option").remove();
              $("#subtipo-" + fila).append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#subtipo-" + fila).html(msg);
          }
        });
    });
}

function cargaSubTiposSimple(tipo, subtipo)
{
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getSubTipos",
          data: "id_tipo="+ tipo,
          dataType: "html",
          beforeSend: function(objeto){
              $("#subtipo > option").remove();
              $("#fornecedor > option").remove();
              $("#subtipo").append("<option value=''>Carregando...</option>");
              $("#fornecedor").append("<option value=''>Selecione...</option>");
          },
          success: function(msg){
            $("#subtipo").html(msg);
            if(subtipo)
            {
                $('#subtipo option[value="' + subtipo + '"]').attr("selected", "selected");
            }
          }
        });
    });
}

function cargaEmpresas(obj){
    var fila = obj.attr('fila');
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getEmpresas",
          data: "subtipo="+ obj.val(),
          dataType: "html",
          beforeSend: function(objeto){
              $("#fornecedor-" + fila + " > option").remove();
              $("#fornecedor-" + fila).append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#fornecedor-" + fila).html(msg);
          }
        });
    });
  
}

function cargaStatusProjeto(id){
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getStatusProjeto",
          data: "id_status_projeto="+ id,
          dataType: "html",
          beforeSend: function(objeto){
              $("#proposta_status > option").remove();
              $("#proposta_status").append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#proposta_status").html(msg);
          }
        });
    });
  
}

function cargaFornecedor(id, subtipo){  
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getEmpresas",
          data: "subtipo="+ subtipo,
          dataType: "html",
          beforeSend: function(objeto){
              $("#fornecedor > option").remove();
              $("#fornecedor").append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#fornecedor").html(msg);
              if(id)
              {
                $('#fornecedor option[value="' + id + '"]').attr("selected", "selected");
              }
          },
                  
          error: function(objeto, quepaso, otroobj){ alert(otroobj); } 
        });
    });
}

function cargaClientes(codigocadastro){    
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getClientes",
          data: {'codigocadastro' : codigocadastro},
          dataType: "html",
          beforeSend: function(objeto){
              $("#fornecedor > option").remove();
              $("#fornecedor").append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#fornecedor").html(msg);
              if(codigocadastro)
              {
                $('#fornecedor option[value="' + codigocadastro + '"]').attr("selected", "selected");
              }
          },
                  
          error: function(objeto, quepaso, otroobj){ alert(otroobj); }                  
        });
    });      
}

function cargaClienteProjeto(codigoprojeto){    
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getClienteProjeto",
          data: {'codigoprojeto' : codigoprojeto},
          dataType: "html",
          beforeSend: function(objeto){
              $("#fornecedor > option").remove();
              $("#fornecedor").append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#fornecedor").html(msg);
              if(codigoprojeto)
              {
                $('#fornecedor option[value="' + codigoprojeto + '"]').attr("selected", "selected");
              }
          },
                  
          error: function(objeto, quepaso, otroobj){ alert(otroobj); }                  
        });
    });      
}

function cargaCentros(operacao){  
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getCentros",
          data: "operacao="+ operacao,
          dataType: "html",
          beforeSend: function(objeto){
              $("#saidas_centro > option").remove();
              $("#saidas_centro").append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#saidas_centro").html(msg);              
              analisisImpuesto();
          },
                  
          error: function(objeto, quepaso, otroobj){ alert(otroobj); }                  
        });
    });    
  
}

 //ANALISIS DE IMPUESTOS
 function analisisImpuesto()
 {
    if ( ($('#saidas_operacao').val() === 'e') && 
         ($('#saidas_centro').val() === 'projeto' ))          
    {
         $('#imposto-tr').show();
         formatInputPercent($('#saidas_impostos'));
    }
    else $('#imposto-tr').hide();
 }

function cargaFuncionarios(id){
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getFuncionarios",
          dataType: "html",
          beforeSend: function(objeto){
              $("#funcionario > option").remove();
              $("#funcionario").append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#funcionario").html(msg);
              if(id)
              {
                    $('#funcionario option[value="' + id + '"]').attr("selected", "selected");
              }
          }
        });
    });
  
}

function cargaFuncionariosProjeto(projeto, id){
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getFuncionariosProjeto",
          data: "projeto="+ projeto,
          dataType: "html",
          beforeSend: function(objeto){
              $("#funcionario > option").remove();
              $("#funcionario").append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#funcionario").html(msg);
              if(id)
              {
                    $('#funcionario option[value="' + id + '"]').attr("selected", "selected");
              }
          }
        });
    });  
}

function clearSelectOptions(id)
{
    $("#" + id + " > option").remove();
    $("#" +  id).append("<option value=''>Selecione...</option>");
}

function cargaAdministradores(){
    $(function(){
        $.ajax({
          type: "POST",
          url:  url + "ajax/getAdministradores",
          dataType: "html",
          beforeSend: function(objeto){
              $("#funcionario > option").remove();
              $("#funcionario").append("<option value=''>Carregando...</option>");
          },
          success: function(msg){
              $("#funcionario").html(msg);
              if(id)
              {
                    $('#funcionario option[value="' + id + '"]').attr("selected", "selected");
              }
          }
        });
    });  
}


function formatInputMoneda(object)
{
    object.priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
}

function formatInputPercent(object)
{
    object.priceFormat({
            prefix: '',
            suffix: ' %',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
}

function formatInputTiempoHoras(object)
{
    object.priceFormat({
            prefix: '',
            thousandsSeparator: '.',
            decimals: 1
        });
}

function calculoTotalCompensacion()
    {        
        totalCol = 0;
        $(".compensacion").each(
            function() {
                 if ($(this).is(':checked')) {
                     totalCol = totalCol + Number($(this).attr('saldo'));
                 }
            }
        );
        $("#total-compensacion").html(totalCol);    
    }

function calculoTotalOperacao(classCal)
{        
        total = 0;
        $("." + classCal).each(
            function() {
                total = total + Number($(this).html());    
            }
        );
        $.ajax({
          type: "GET",
          url:  url + "ajax/formatNumber",
          data: {numero: total},
          dataType: "html",
          success: function(total_formato){
              $(".sum-" + classCal).html('R$ ' + total_formato);
          }
        });    
}