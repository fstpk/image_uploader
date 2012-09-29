<?php
 //e.g. http://server.tld/
 $url = ; 

 $blacklist = array(".php", ".phtml", ".php3", ".php4", ".pl", ".py", ".sh", ".exe");
 foreach ($blacklist as $item) {
  if(preg_match("/$item\$/i", $_FILES['userfile']['name'])) {
   echo "
	<!DOCTYPE html>
	 <html>
	  <head>
	  <title>Upload result :: fail</title>
	  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
          <meta name=\"generator\" content=\"cat /dev/urandom > index.html\" />
	  <link href=\"/css/upload.css\" rel=\"stylesheet\" media=\"all\" />
	  <link rel=\"icon\" href=\"/favicon.png\" type=\"image/x-png\" />
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
 if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
  echo "
	<!DOCTYPE html>
	 <html>
	  <head>
	   <title>Upload result :: fail</title>
	   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	   <meta name=\"generator\" content=\"cat /dev/urandom > index.html\" />
	   <link href=\"/css/upload.css\" rel=\"stylesheet\" media=\"all\" />
	   <link rel=\"icon\" href=\"/favicon.png\" type=\"image/x-png\" />
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
  $ext = pathinfo($uploadfile, PATHINFO_EXTENSION);
 
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
   $md5 = md5_file($uploadfile);
   rename("$uploadfile", "$uploaddir$md5.$ext"); 

     date_default_timezone_set("Asia/Omsk");
     $time = date("d.m.y");
     $filesize = filesize("$uploaddir$md5.$ext");
     $size = (int)($filesize/1024);
     /*$loadtime = (int)($filesize/20480);*/
     $loadtime = rand(10, 100);
     /* if($delay>10) 
	$delay = 10;
     sleep($delay);*/

echo "
	 <!DOCTYPE html>
	 <html>
	  <head>
	   <title>Upload result :: $md5.$ext</title>
	   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	   <meta name=\"generator\" content=\"cat /dev/urandom > index.html\" />
	   <link href=\"/css/upload.css\" rel=\"stylesheet\" media=\"all\" />
	   <link rel=\"icon\" href=\"/favicon.png\" type=\"image/x-png\" />
	  </head>
	  <body>
	   <a href=\"https://github.com/fastpoke/image_uploader\"><img style=\"z-index: -1; position: absolute; top: 0; right: 0; border: 0;\" src=\"https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png\" alt=\"Fork me on GitHub\"></a>
	   <div class=\"result\">
	    <div class=\"text\">Click on image for a direct link</div>
	    <div class=\"info\">
	     <div class=\"padding_left\">File name:</div>   <div><a href=\"http://up.fastpoke.org/img/$md5.$ext\" class=\"link\">$md5.$ext</a></div>
	     <div class=\"padding_left\">File size:</div>   <div><span class=\"bold\">$size</span> kb</div>
	     <div class=\"padding_left\">Upload date:</div> <div><span class=\"bold\">$time</span></div>
	     <div class=\"padding_left\">Upload time:</div> <div><span class=\"bold\">0.$loadtime</span> sec</div>
	    </div>
	    <div class=\"image\">
	     <a href=\"$url/img/$md5.ext\" class=\"link\"><img class=\"done\" src=\"$url/img/$md5.$ext\" title=\"$md5.$ext\"></a>
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
	   <link href=\"/css/upload.css\" rel=\"stylesheet\" media=\"all\" />
	   <link rel=\"icon\" href=\"/favicon.png\" type=\"image/x-png\" />
	  </head>
	  <body>
          <div class=\"error\">
           <div class=\"fail\">
            Oops~
           </div>
           <div class=\"message\">
            So much failed :(
           </div>
          </div>
          <div class=\"back\"><a href=\"$url\" target=\"_self\">back</a></div>
	  </body>
	 </html>
	";
}
?>
