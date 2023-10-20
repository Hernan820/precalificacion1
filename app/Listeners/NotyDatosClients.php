<?php

namespace App\Listeners;

use App\Events\MensajeEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class NotyDatosClients
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MensajeEvents  $event
     * @return void
     */
    public function handle(MensajeEvents $event)
    {

        $datos_cliente_array = json_decode($event->cliente_precalificacion, true);


        require base_path("vendor/autoload.php");
    
        $mail = new PHPMailer(true);   
    
        try {
                    
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->SMTPDebug = 2; 
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->Username ='hernanjosuebenitez@gmail.com'; 
            $mail->Password = 'gnvcryrridikdrfd'; 
            //Agregar destinatario
            $mail->setFrom('hernanjosuebenitez@gmail.com', 'ContigoMortgage');
            $mail->AddAddress('benitezhernan820@gmail.com');//A quien mandar email
            $mail->SMTPKeepAlive = true;  
            $mail->Mailer = "smtp"; 
            
            $mail->isHTML(true); 
            
            $mail->Subject = 'Cliente Pre-calificación ';
            $mensajededatos   = '<html dir="ltr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1=">
                <title>Conitgomortgage</title>
                <style type=" text/css"> p{ margin:10px 0; padding:0; } table{ border-collapse:collapse; } h1,h2,h3,h4,h5,h6{
                    display:block; margin:0; padding:0; } img,a img{ border:0; height:auto; outline:none; text-decoration:none; }
                    body,#bodyTable,#bodyCell{ height:100%; margin:0; padding:0; width:100%; } #outlook a{ padding:0; } img{
                    -ms-interpolation-mode:bicubic; } table{ mso-table-lspace:0pt; mso-table-rspace:0pt; } .ReadMsgBody{ width:100%;
                    } .ExternalClass{ width:100%; } p,a,li,td,blockquote{ mso-line-height-rule:exactly; }
                    a[href^=tel],a[href^=sms]{ color:inherit; cursor:default; text-decoration:none; }
                    p,a,li,td,body,table,blockquote{ -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; }
                    .ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.Ext=ernalClass span,.ExternalClass font{
                    line-height:100%; } a[x-apple-data-detectors]{ color:inherit !important; text-decoration:none !important;
                    font-size:inherit !important; font-family:inherit !important; font-weight:inherit !important;
                    line-height:inherit !important; } #bodyCell{ padding:50px 50px; } .templateContainer{ max-width:600px
                    !important; border:0; } a.mcnButton{ display:block; } .mcnTextContent{ word-break:break-word; } .mcnTextContent
                    img{ height:auto !important; } .mcnDividerBlock{ table-layout:fixed !important; } /***** Make theme edits below
                    if needed *****/ /* Page - Background Style */ body,#bodyTable{ background-color:#e9eaec; } /* Page - Heading 1
                    */ h1{ color:#202020; font-family: "Helvetica Neue" , Helvetica, Arial, "Lucida Grande" , sans-s=erif;
                    font-size:26px; font-style:normal; font-weight:bold; line-height:125%; letter-spacing:normal; } /* Page -
                    Heading 2 */ h2{ color:#202020; font-family: "Helvetica Neue" , Helvetica, Arial, "Lucida Grande" , sans-s=erif;
                    font-size:22px; font-style:normal; font-weight:bold; line-height:125%; letter-spacing:normal; } /* Page -
                    Heading 3 */ h3{ color:#202020; font-family: "Helvetica Neue" , Helvetica, Arial, "Lucida Grande" , sans-s=erif;
                    font-size:20px; font-style:normal; font-weight:bold; line-height:125%; letter-spacing:normal; } /* Page -
                    Heading 4 */ h4{ color:#202020; font-family: "Helvetica Neue" , Helvetica, Arial, "Lucida Grande" , sans-s=erif;
                    font-size:18px; font-style:normal; font-weight:bold; line-height:125%; letter-spacing:normal; } /* Header -
                    Header Style */ #templateHeader{ border-top:0; border-bottom:0; padding-top:0; padding-bottom:20px; text-align:
                    center; } /* Body - Body Style */ #templateBody{ background-color:#FFFFFF; border-top:0; border: 1px solid
                    #c1c1c1; padding-top:0; padding-bottom:0px; } /* Body -Body Text */ #templateBody .mcnTextContent, #templateBody
                    .mcnTextContent p{ color:#555555; font-family: "Helvetica Neue" , Helvetica, Arial, "Lucida Grande" ,
                    sans-s=erif; font-size:14px; line-height:150%; } /* Body - Body Link */ #templateBody .mcnTextContent a,
                    #templateBody .mcnTextContent p a{ color:#ff7f50; font-weight:normal; text-decoration:underline; } /* Footer -
                    Footer Style */ #templateFooter{ background-color:#e9eaec; border-top:0; border-bottom:0; padding-top:12px;
                    padding-bottom:12px; } /* Footer - Footer Text */ #templateFooter .mcnTextContent, #templateFooter
                    .mcnTextContent p{ color:#cccccc; font-family: "Helvetica Neue" , Helvetica, Arial, "Lucida Grande" ,
                    sans-s=erif; font-size:12px; line-height:150%; text-align:center; } /* Footer - Footer Link */ #templateFooter
                    .mcnTextContent a, #templateFooter .mcnTextContent p a{ color:#cccccc; font-weight:normal;
                    text-decoration:underline; } @media only screen and (min-width:768px){ .templateContainer{ width:600px
                    !important; } } @media only screen and (max-width: 480px){ body,table,td,p,a,li,blockquote{
                    -webkit-text-size-adjust:none !important; } } @media only screen and (max-width: 480px){ body{ width:100%
                    !important; min-width:100% !important; } } @media only screen and (max-width: 680px){ #bodyCell{ padding:20px
                    20px !important; } } @media only screen and (max-width: 480px){ .mcnTextContentContainer{ max-width:100%
                    !important; width:100% !important; } } /* Rich Text compatibility - image alignment. */ .mcnTextContentContainer
                    table tbody, .mcnTextContentContainer table tbody tr, .mcnTextContentContainer table tbody td { display: block;
                    } .mcnTextContentContainer p::after { content: "" ; clear: both; display: block; } .mcnTextContentContainer p
                    .alignleft { float: left; } .mcnTextContentContainer p .aligncenter { display: block; margin-left: auto;
                    margin-right: auto; } .mcnTextContentContainer p .alignright { float: right; } </style> </head>
            
                <body style="height:100%;margin:0;padding:0;width:100%;background-color:#=e9eaec">
                     <center>
                         <table align="center" border="0" cellpadding="0" cellspacing="0"=height="100%" width="100%" id="bodyTable"
                             style="border-collapse:co=llapse;height:100%;margin:0;padding:0;width:100%;background-color:#e9eaec">
                             <tr>
                                 <td align="center" valign="top" id="bodyCell"
                                     style="height:100=%;margin:0;padding:50px 50px;width:100%">
            
                                     <table border="0" cellpadding="0" cellspacing="0" width="100%"=class="templateContainer"
                                         style="border-collapse:collapse;border:0;max=-width:600px!important">
                                         <tr>
                                             <td valign="top" id="templateBody" style="background-color:#ff=ffff;border-top:0;border:1px solid #c1c1c1;padding-top:0;padding-bottom:0px=">
                                                 <table border=" 0" cellpadding="0" cellspacing="0" width="100%"
                                                     class="mcnTextBlock" style="min-width:100%;border-collapse:collapse=">
                                                     <tbody class=" mcnTextBlockOuter">
                                                         <tr>
                                                             <td valign="top" class="mcnTextBlockInner" style="mso-line=-height-rule:  exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust:=100%;">';
                                                            
                                                            foreach ($datos_cliente_array as $key => $value) {
                                                          
                                                                if( $value != ""){

                                                           $mensajededatos .= ' <table align="left" border="0" cellpadding="0" cellspacin=g="0"
                                                                     width="100%" style="min-width:100%;border-collapse:collapse"
                                                                     cl=ass="mcnTextContentContainer">
                                                                     <tbody>
                                                                         <tr>
                                                                             <td valign="top"
                                                                                 style="padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px"
                                                                                 class="mcnTextContent">
            
                                                                                 <table align="left" border="0" cellpadding="0"
                                                                                     cellspacing="0" widt=h="100%"
                                                                                     style="display:block;min-width:100%;border-collapse:collapse;w=idth:100%">
                                                                                     <tbody>
                                                                                         <tr>
                                                                                            <td style="color:#333333;padding-top:5px;padding-bottom:3px">
                                                                                                <strong>
                                                                                                '.$key.'
                                                                                                </strong>
                                                                                            </td>
                                                                                         </tr>
                                                                                         <tr>
                                                                                            <td style="color:#555555;padding-top:3px;padding-bottom:5px">
                                                                                                '.$value.'
                                                                                            </td>
                                                                                         </tr>
                                                                                     </tbody>
                                                                                 </table>
            
                                                                             </td>
                                                                         </tr>
                                                                     </tbody>
                                                                 </table>';
                                                                   }
                                                                }
            
                                                           $mensajededatos .=' </td>
                                                         </tr>
                                                     </tbody>
                                                 </table>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td valign="top" id="templateFooter"
                                                 style="background-color:#=e9eaec;border-top:0;border-bottom:0;padding-top:12px;padding-bottom:12px">
                                                 <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                     class="mcnTextBlock" style="min-width:100%;border-collapse:collapse=">
                                                     <tbody class=" mcnTextBlockOuter">
                                                         <tr>
                                                             <td valign="top" class="mcnTextBlockInner" style="mso-line=-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust:=100%;">
                                                                 <table align="left" border="0" cellpadding="0" cellspacin=g="0"
                                                                     width="100%" style="min-width:100%;border-collapse:collapse"
                                                                     cl=ass="mcnTextContentContainer">
                                                                     <tbody>
                                                                         <tr>
                                                                             <td valign="top" class="mcnTextContent"
                                                                                 style="padding=-top:9px;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break=:break-word;color:#aaa;font-family:Helvetica;font-size:12px;line-height:150=%;text-align:center">
                                                                                 Enviado desde <a href="https://contigomortgage.com"
                                                                                     style=="color:#bbbbbb">Conitgomortgage</a>
                                                                             </td>
                                                                         </tr>
                                                                     </tbody>
                                                                 </table>
                                                             </td>
                                                         </tr>
                                                     </tbody>
                                                 </table>
                                             </td>
                                         </tr>
                                     </table>
                                 </td>
                             </tr>
                         </table>
                     </center>
                 </body>
            </html>';
        
            $mail->Body = $mensajededatos ;

            if( !$mail->send() ) {

                Log::info("falloCorreo electrónico no enviado.");
             return "";
            }
                    
            else {
            //  return "";
                Log::info("éxito Se ha enviado el correo electrónico");
            }
    
        } catch (Exception $e) {
            Log::info("errorNo se pudo enviar el mensaje.");
            Log::info($e);
            return 'errorNo se pudo enviar el mensaje  '.$e;
        }
    }
}
