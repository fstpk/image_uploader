<?php
 //e.g. http://server.tld/
 $url = ""; 

 $file = $_FILES['userfile'];
 
 $error_text = true;
 define("UPLOAD_ERR_EMPTY",5);
   if($file['size'] == 0 && $file['error'] == 0){
     $file['error'] = 5;
   }
  $upload_errors = array(
    UPLOAD_ERR_OK		=> "No errors.",
    UPLOAD_ERR_INI_SIZE		=> "Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE	=> "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL		=> "Partial upload.",
    UPLOAD_ERR_NO_FILE		=> "No file.",
    UPLOAD_ERR_NO_TMP_DIR	=> "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE	=> "Can't write to disk.",
    UPLOAD_ERR_EXTENSION	=> "File upload stopped by extension.",
    UPLOAD_ERR_EMPTY		=> "File is empty."
  );
 $err = ($error_text) ? $upload_errors[$file['error']] : $file['error'] ;

 $blacklist = array(".php", ".phtml", ".php3", ".php4", ".pl", ".py", ".sh", ".exe");
 $item = null;
 foreach ($blacklist as $item) {
  if(preg_match("/$item\$/i", $_FILES['userfile']['name'])) {
   echo "
	<!DOCTYPE html>
	 <html>
	  <head>
	  <title>Upload result :: fail</title>
	  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
          <meta name=\"generator\" content=\"cat /dev/urandom > index.html\" />
	  <link href=\"css/upload.css\" rel=\"stylesheet\" media=\"all\" />
	  <link rel=\"icon\" href=\"favicon.png\" type=\"image/x-png\" />
	 </head>
	 <body>
	  <div class=\"error\">
	   <div class=\"fail\">
	    Nope
	   </div>
	   <div class=\"message\">
	    Prohibited file type
	    <br>
	    Allow only <span class=\"bold red\">.png</span>, <span class=\"bold red\">.jpg</span>, <span class=\"bold red\">.gif</span>
           </div>
          </div>
          <div class=\"back\"><a href=\"$url\" target=\"_self\">back</a></div>
	 </body>
	</html>
	";
   exit;
   }
  }

 $imageinfo = getimagesize($_FILES['userfile']['tmp_name']);
 if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png') {
  echo "
	<!DOCTYPE html>
	 <html>
	  <head>
	   <title>Upload result :: fail</title>
	   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	   <meta name=\"generator\" content=\"cat /dev/urandom > index.html\" />
	   <link href=\"css/upload.css\" rel=\"stylesheet\" media=\"all\" />
	   <link rel=\"icon\" href=\"favicon.png\" type=\"image/x-png\" />
	  </head>
	  <body>
          <div class=\"error\">
           <div class=\"fail\">
            Nope
           </div>
           <div class=\"message\">
            Prohibited file type
            <br>
            Allow only <span class=\"bold red\">.png</span>, <span class=\"bold red\">.jpg</span>, <span class=\"bold red\">.gif</span>
           </div>
          </div>
          <div class=\"back\"><a href=\"$url\" target=\"_self\">back</a></div>
	  </body>
	 </html>
	";
  exit;
 }
  
  $uploaddir = 'img/';
  $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
  
  $ext = strtolower(pathinfo($uploadfile, PATHINFO_EXTENSION));
  $extlen = strlen(utf8_decode($ext));
  $name = basename($_FILES['userfile']['name']);
  if (strlen(utf8_decode($name)) > 40) {
  	$name = substr($name, 0, 20)." ... ".substr($name, -15, -$extlen)."$ext";
  } elseif (strlen(utf8_decode($name)) < 40) {
  	$name;
  }

  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
   $md5 = md5_file($uploadfile);
   rename("$uploadfile", "$uploaddir$md5.$ext"); 

     date_default_timezone_set("Asia/Omsk");
     $time = date("d.m.y");
     $filesize = filesize("$uploaddir$md5.$ext");
     $size = (int)($filesize/1024);
     $type = $imageinfo['mime'];
     $resolution = getimagesize("$uploaddir$md5.$ext");
     $width  = $resolution [0];
     $height = $resolution [1];
     $loadtime = 0 . "." . rand(1, 10) . rand(0, 10);

echo "
	 <!-- current version: 1.7 -->
	 <!DOCTYPE html>
	 <html>
	  <head>
	   <title>Upload result :: $md5.$ext</title>
	   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	   <meta name=\"generator\" content=\"cat /dev/urandom > index.html\" />
	   <link href=\"css/upload.css\" rel=\"stylesheet\" media=\"all\" />
	   <link rel=\"icon\" href=\"favicon.png\" type=\"image/x-png\" />
	  </head>
	  <body>
	   <a href=\"https://github.com/fastpoke/image_uploader\"><img style=\"position: absolute; top: 0; right: 0; border: 0;\" src=\"forkme_right_gray_6d6d6d.png\" alt=\"Fork me on GitHub\"></a>
	   <div class=\"result\">
	    <div class=\"text\">$name</div>
	    <div class=\"info\">
	     <div class=\"padding_left\">File name:</div>   <div><a href=\"$url/img/$md5.$ext\" class=\"link\">$md5.$ext</a></div>
	     <div class=\"padding_left\">File resolution:</div>     <div><span class=\"bold\">$width px</span> &times; <span class=\"bold\">$height px</span></div>
	     <div class=\"padding_left\">File type:</div>           <div><span class=\"bold\">$type</span></div>
	     <div class=\"padding_left\">File size:</div>           <div><span class=\"bold\">$size</span> kb</div>
	     <div class=\"padding_left\">Upload date:</div>         <div><span class=\"bold\">$time</span></div>
	     <div class=\"padding_left\">Upload time:</div>         <div><span class=\"bold\">$loadtime</span> sec</div>
	    </div>
	    <div class=\"image\">
    	     <div class=\"popup\">Click on image for a direct link</div>
	     <a href=\"$url/img/$md5.$ext\" class=\"link\"><img class=\"done\" src=\"$url/img/$md5.$ext\" title=\"$md5.$ext\"></a>
	    </div>
	   </div>
           <div class=\"back\"><a href=\"$url\" target=\"_self\">back</a></div>
	  </body>
	 </html>
      ";
 exit; 
} 


 else {
   echo "
	 <!DOCTYPE html>
	 <html>
	  <head>
	   <title>Upload result :: fail</title>
	   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	   <meta name=\"generator\" content=\"cat /dev/urandom > index.html\" />
	   <link href=\"css/upload.css\" rel=\"stylesheet\" media=\"all\" />
	   <link rel=\"icon\" href=\"favicon.png\" type=\"image/x-png\" />
	  </head>
	  <body>
          <div class=\"error\">
           <div class=\"fail\">
            Oops~
           </div>
           <div class=\"message\">
            So much failed :(
            <br>
            Error: <span class=\"bold red\">$err</span>
           </div>
          </div>
          <div class=\"back\"><a href=\"$url\" target=\"_self\">back</a></div>
	  </body>
	 </html>
	";
}
?>
