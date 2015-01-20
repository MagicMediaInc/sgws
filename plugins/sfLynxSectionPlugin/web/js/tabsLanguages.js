/*
 * Ext JS Library 3.2.0
 * Copyright(c) 2006-2010, Ext JS, LLC.
 * licensing@extjs.com
 *
 * http://extjs.com/license
 *
 * Henry Vallenilla - hvallenilla@aberic.com
 * Sistema de Pestañas por Language
 */

var dataUrl = 'http://'+location.hostname+'/backend.php/';

function sistemTabs(idSection,language)
    {
        var tab = 0;
        if(language == "es"){
            tab = 1;
        }
        
        Ext.onReady(function(){
            var tabsLanguages = new Ext.TabPanel({
                renderTo: 'tabsLanguages',
                activeTab: tab,
                cls: "auto-width-tab-strip",
                plain:true,
                defaults:{autoScroll: true},
                items:[{
                        title: 'Portugues',
                        autoLoad: {url:dataUrl+'lxsection/infoLanguage', params: 'id='+ idSection + '&language=pt'}
                    }/*,{
                        title: 'Spanish',
                        autoLoad: {url: url +  'lxsection/infoLanguage', params: 'id='+ idSection + '&language=es'}
                    }*/
                ]
            });

        });


    }
