<?

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['file'])) {
  $emailto = $emailfrom = $_POST['email'];
  $name = $_POST['name'];
  $file = (int)$_POST['file'];
  $subject = 'Photo by '.$name;

  $separator = md5(time());
  $eol = PHP_EOL;

  $filename = $file.".jpg";
  $attachment = chunk_split(base64_encode(file_get_contents('cache/result'.$file.'.jpg')));

  $headers  = "From: ".$emailfrom.$eol;
  $headers .= "MIME-Version: 1.0".$eol; 
  $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

  $body = "--".$separator.$eol;
  $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
  $body .= "This is a MIME encoded message.".$eol;

  $body .= "--".$separator.$eol;
  $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
  $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
  $body .= 'Your image'.$eol;

  $body .= "--".$separator.$eol;
  $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
  $body .= "Content-Transfer-Encoding: base64".$eol;
  $body .= "Content-Disposition: attachment".$eol.$eol;
  $body .= $attachment.$eol;
  $body .= "--".$separator."--";

  if (mail($emailto, $subject, $body, $headers)) {
  $mail_sent=true;
    echo "The letter was sent";
  } else {
    $mail_sent=false;
    echo "Error, The letter was not sent";
 }
}