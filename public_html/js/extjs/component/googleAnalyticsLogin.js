var url = 'http://'+location.hostname+'/';

Ext.onReady(function(){
    var objDiv = Ext.get('GAlogin');
    Ext.QuickTips.init();
    // turn on validation errors beside the field globally
    Ext.form.Field.prototype.msgTarget = 'side';
    //Recupera los valores del Analytics
    var loginAnalytics = $('#loginAnalytics').val();
    var passwordAnalytics = $('#passwordAnalytics').val();
    //Valida que ya este logeado el usuario del Analytics
    if (loginAnalytics && passwordAnalytics){
        Ext.Ajax.request({
            url : url+'lxcomponent/analyticsLogin',
            waitMsg : 'Loanding...',
            method: 'POST',
            failure: function (response, request) {
                Ext.MessageBox.show({
                    title: 'Error',
                    msg: 'Incorrect User/Password combination',
                    buttons: Ext.MessageBox.OK,
                    icon: Ext.MessageBox.ERROR
                });
            },
            success: function (response, request) {
                //FormGAlogin.destroy();
                var responseData = Ext.util.JSON.decode(response.responseText);
                objDiv.update("");
                graphAnalytics(responseData);
            },
            timeout: 10000,
            params: {
                login: loginAnalytics,
                password: passwordAnalytics
            }
        });
    }else{
        var FormGAlogin = new Ext.FormPanel({
            labelWidth: 75, // label settings here cascade unless overridden
            bodyStyle:'padding:10px 5px 0',
            waitMsgTarget : true,
            frame:true,
            defaults: {
                width: 170
            },
            title: 'Google Analytics Login - UNDER CONSTRUCTION',
            width: 300,
            defaultType: 'textfield',
            items: [{
                fieldLabel: 'Login',
                name: 'login',
                allowBlank:false
            },{
                fieldLabel: 'Password',
                name: 'password',
                inputType: 'password',
                allowBlank:false
            }]
        });
        //Definicion del boton Login y funcionalidades
        var submitFormGAlogin = FormGAlogin.addButton({
            text : 'Login',
            disabled : false,
            handler : function() {
                FormGAlogin.getForm().submit({
                    url : url+'lxcomponent/analyticsLogin',
                    waitMsg : 'Loanding...',
                    failure: function (form, action) {
                        Ext.MessageBox.show({
                            title: 'Error',
                            msg: 'Incorrect User/Password combination',
                            buttons: Ext.MessageBox.OK,
                            icon: Ext.MessageBox.ERROR
                        });
                    },
                    success: function (form, request) {
                        FormGAlogin.destroy();
                        var responseData = Ext.util.JSON.decode(request.response.responseText);
                        objDiv.update("");
                        graphAnalytics(responseData);
                    }
                });
            }
        });

        FormGAlogin.render('GAlogin');
    }
    //Muestra la grafica correspondiente
    function graphAnalytics(objResponse){
        Ext.chart.Chart.CHART_URL = '../js/extjs/resources/charts.swf';
        var store = new Ext.data.JsonStore({
            fields:['name', 'visits', 'views'],
            data:  objResponse.data

        });

        // extra extra simple
        new Ext.Panel({
            title: 'ExtJS.com Visits Trend, 2007/2008 (No styling)',
            renderTo: 'GAlogin',
            width:500,
            height:300,
            layout:'fit',

            items: {
                xtype: 'linechart',
                store: store,
                xField: 'name',
                yField: 'visits',
                listeners: {
                    itemclick: function(o){
                        var rec = store.getAt(o.index);
                        Ext.example.msg('Item Selected', 'You chose {0}.', rec.get('name'));
                    }
                }
            }
        });
    }
    
    
});
