<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
        <script type="text/javascript">
        $(document).ready(function() {
            var nomeProfile = "<?php echo $sf_user->getAttribute('nomeProfile') ?>";
            if(nomeProfile != 'Gerente e Responsável Técnico')
                $('#proposta_nao_conformidade').attr('readonly', 'readonly');
        });
                var fancybox = $(".frameForm").length;
                    console.log(fancybox);
                if(fancybox==0){
                    $("#contentPpal").removeAttr("style");
                }
        </script>
    </head>
    <body style="background-color: #FFF; background: none;">
        <div id="contentPpal" style="margin-top: 5px; border: 0px; width: 100% !important; margin-bottom: 0px;">
            <div id="conteint">                
                <div style="margin: auto; width: 100%; height: 500px;">
                    <div id="content" align="center">
                        <div id="main">
                            <?php echo $sf_content ?>
                        </div>
                        <br />                        
                    </div>
                </div>                
            </div>
            
        </div>
    </body>
</html>
