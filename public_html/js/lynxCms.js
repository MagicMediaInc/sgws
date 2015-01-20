var control = 0;

function existItems(obj)
{
    var cont = 0; 
    var tagsArray = new Array();
       $("input:checked").each(function(id) {
             cont = cont + $("input:checked").get(id);
       });
    if(cont){
        confirmation = confirm('Tem certeza de que quer apagar os dados selecionados?' );
        if(confirmation){
            $('#frmChk').submit();
        }

    }else{
        $("#no_select_item").show();
        return false;
    }    
}

function existItemsPrint(obj)
{
    var cont = 0; 
    var tagsArray = new Array();
       $("input:checked").each(function(id) {
             cont = cont + $("input:checked").get(id);
       });
    if(cont){
        confirmation = confirm('Tem certeza de que quer processar os dados selecionados?' );
        if(confirmation){
            $('#frm-process').submit();
        }

    }else{
        $("#no_select_item").show();
        return false;
    }    
}

function noSelectedItem()
{
    $('#no_select_item').hide();
}

function cambiaFlecha(elemento, imagen_abajo, imagen_arriba) {
	var src = $(elemento).readAttribute('src')
	if (src==imagen_arriba) {
		$(elemento).writeAttribute("src", imagen_abajo)
		control = 0;
	} else {
		$(elemento).writeAttribute("src", imagen_arriba)
		control = 1;
	}
}
function validaFrmPass(requerido,pass,pass_confir){
new Validation('frmPass', {immediate : true, stopOnFirst : true});
    Validation.addAllThese([
		['required', requerido, function(v) {
			return !Validation.get('IsEmpty').test(v);
		}],
		['validate-password', pass, {
			minLength : 7
		}],
		['validate-password-confirm', pass_confir, {
			equalToField : 'nuevaPass'
		}]
	]);
}
function checkTodos(obj){
    if($('#chkTodos').attr('checked')){
        $("INPUT[type='checkbox']").attr('checked',':checked');
    }else{
        $("INPUT[type='checkbox']").removeAttr('checked');
    }
}

function check_enable_tc(tipo_cadastro, subtipo)
{
  if ($("input.pp_" + tipo_cadastro + "-" + subtipo).attr('checked')) 
  {
    if (!$("#tipo_" + tipo_cadastro).attr('checked')) 
    {
        $("input#tipo_" + tipo_cadastro).attr("checked", true);
    }
  }
}