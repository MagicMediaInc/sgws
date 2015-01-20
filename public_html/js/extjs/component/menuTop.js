//Cambiar al implementar
// PENDING: AQUI ME QUEDE HAY QUE HACER que reconosca el ambiente y cargar estilo para los iconos del menu
var url = 'http://'+location.hostname+'/backend_dev.php/';

Ext.onReady(function(){
    Ext.QuickTips.init();
  
    // Redirecciona para el Dashboard
    function onDashClick(btn){
        document.location = url;
    }

    //Carga los modulos padres en el menu
    Ext.Ajax.request({
        url : url+'lxcomponent/menuParent',
        waitMsg : 'Loanding...',
        method: 'POST',
        failure: function (response, request) {
            alert ('mal');
        },
        success: function (response, request) {
            responseData = Ext.util.JSON.decode(response.responseText);
            var tb = new Ext.Toolbar();
            tb.render('toolbar');
            tb.add({
                text:'Dashboard',
                //iconCls: 'bmenu',  // <-- icon
                handler: onDashClick
            },'-',
            responseData
            );
              
            tb.doLayout();

        },
        timeout: 10000
            
    });
});
   
