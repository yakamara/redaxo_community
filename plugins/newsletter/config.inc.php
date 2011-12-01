<?php

/** 
 * Config . Zuständig für den Newsletter 
 * @author jan@kristinus
 * @version 1.0
 */ 

if ($REX["REDAXO"] && $REX['USER'] && $REX['USER']->isAdmin("rights","admin[]"))
{
  $REX['ADDON']['community']['SUBPAGES'][] = array('plugin.newsletter','Newsletter');
}

$REX['ADDON']['NEWSLETTER_TEXT'] = FALSE;

// Feld festlegen, nicht lschbar
$REX["ADDON"]["community"]["ff"][] = "last_newsletterid";


// ---------- Funktion fuer den Newsletter-Versand

function rex_newsletter_sendmail($userinfo, $mail_from_email, $mail_from_name, $mail_subject, $mail_body_text, $mail_body_html, $mail_attachments = null)
{

  global $REX;

  if(trim($userinfo["email"]) == "")
    return FALSE;

  $mail = new rex_mailer();
  $mail->AddAddress($userinfo["email"]);
  $mail->From = $mail_from_email;
  $mail->FromName = $mail_from_name;

  $mail->Subject = $mail_subject;
  
  ## Adding attachments
  if($mail_attachments != null)
  {
	$mail_attachments = explode(",",$mail_attachments);
    foreach($mail_attachments as $attachment)
    {
    	$mail->AddAttachment($REX["INCLUDE_PATH"].'/../../files/'.$attachment, $attachment);
    }  
  }

  if(trim($mail_body_html) != "")
  {
    $mail->Body = $mail_body_html;
    $mail->AltBody = $mail_body_text;
    foreach($userinfo as $k => $v)
    {
      $mail->Body = str_replace( "###".$k."###",$v,$mail->Body);
      $mail->Body = str_replace( "###".strtoupper($k)."###",$v,$mail->Body);
      $mail->Body = str_replace( "+++".$k."+++",urlencode($v),$mail->Body);
      $mail->Body = str_replace( "+++".strtoupper($k)."+++",urlencode($v),$mail->Body);
      $mail->Subject = str_replace( "###".$k."###",$v,$mail->Subject);
      $mail->Subject = str_replace( "###".strtoupper($k)."###",$v,$mail->Subject);
      $mail->Subject = str_replace( "+++".$k."+++",urlencode($v),$mail->Subject);
      $mail->Subject = str_replace( "+++".strtoupper($k)."+++",urlencode($v),$mail->Subject);
      $mail->AltBody = str_replace( "###".$k."###",$v,$mail->AltBody);
      $mail->AltBody = str_replace( "###".strtoupper($k)."###",$v,$mail->AltBody);
      $mail->AltBody = str_replace( "+++".$k."+++",urlencode($v),$mail->AltBody);
      $mail->AltBody = str_replace( "+++".strtoupper($k)."+++",urlencode($v),$mail->AltBody);
    }
  }else
  {
    $mail->Body = $mail_body_text;
    foreach($userinfo as $k => $v)
    {
      $mail->Body = str_replace( "###".$k."###",$v,$mail->Body);
      $mail->Body = str_replace( "###".strtoupper($k)."###",$v,$mail->Body);
      $mail->Body = str_replace( "+++".$k."+++",urlencode($v),$mail->Body);
      $mail->Body = str_replace( "+++".strtoupper($k)."+++",urlencode($v),$mail->Body);
      $mail->Subject = str_replace( "###".$k."###",$v,$mail->Subject);
      $mail->Subject = str_replace( "###".strtoupper($k)."###",$v,$mail->Subject);
      $mail->Subject = str_replace( "+++".$k."+++",urlencode($v),$mail->Subject);
      $mail->Subject = str_replace( "+++".strtoupper($k)."+++",urlencode($v),$mail->Subject);
    }
  } 

  return $mail->Send();
}