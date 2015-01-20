<?php
/**
 * sendMail PHP 
 *
 * @package Inmobilia
 * @author Henry Vallenilla [hvallenilla@strappinc.net]
 * @copyright Strapp Soluciones Globales INC
 *
 */
class sendMail
{
    public function __construct() {
        sfProjectConfiguration::getActive()->loadHelpers("Partial");
    }
    
    static function mailNewSenha($mailClient, $nombre, $senha)
    {
        $message = sfContext::getInstance()->getMailer()->compose();
        $message->setSubject("Nova Senha - SGWS");
        $message->setTo('henryvallenilla@gmail.com');
        $message->setFrom(sfConfig::get('app_email_default_sender'));
        
        $parametros = array(
            'senha'         => $senha,
            'nombre'        => $nombre,
            'email'        => $mailClient            
        );
        
        $html = get_partial('mail/mailHeader');
        $html = $html.get_partial('mail/mailNewSenha', array('parametros' => $parametros));
        $html = $html.get_partial('mail/mailFooter');
        $message->setBody($html, 'text/html');
        echo $message->getBody(); exit();
        //sfContext::getInstance()->getMailer()->send($message);
        //Envio a infoweb
        //$message->setTo(sfConfig::get('app_email_administrador'));
        //sfContext::getInstance()->getMailer()->send($message);
    }
    
    
}
