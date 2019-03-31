<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>


<!-- Simple PHP URL Shortner by Yusha Ibn Yakub

Website: https://yusha.me

-->

<head>
   <title>Simple PHP URL Shortner</title>
  
     <link href="style.css" rel="stylesheet" type="text/css" /> 
       
 <style>
.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
     

</head>
<body>

  <script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("copy");
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied: " + copyText.value;
}

function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
}
</script>


<?php 

$servername = 'localhost';
$username = '';
$password = ''; // on localhost by default there is no password
$dbname = '';
$base_url=''; // it is your application url




if (isset($_GET['url']) && $_GET['url']!="")
{ 
$url=urldecode($_GET['url']);
if (filter_var($url, FILTER_VALIDATE_URL)) 
{
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} 
$slug=GetShortUrl($url);
$conn->close();

//echo $base_url.$slug;

?>
<center>
<h1>Paste Your Url Here</h1>
<form>
<p><input style="width: 500px; height: 22px;" type="url" name="url" required /></p>
<p><input class="button" type="submit" /></p>
</form><br/>
<?php
  
 echo 'Here is the short <a href="'; echo $base_url; echo"/"; echo $slug;
  echo '" target="_blank">'; echo 'link</a>: ';
  
  ?><input type="text" value="<?php echo $base_url; echo"/"; echo $slug; ?>" id="myInput">
  
  <div class="tooltip"><button onclick="myFunction()" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip" >Copy to clipboard</span>Copy URL</button></div></center>
 <?php

} 
else 
{
die("$url is not a valid URL");
}

}
else
{
?>
<center>
<h1>Paste Your Url Here</h1>
<form>
<p><input style="width: 500px; height: 22px;" type="url" name="url" required /></p>
<p><input class="button" type="submit" /></p>
</form>
</center>
<?php
}


function GetShortUrl($url){
 global $conn;
 $query = "SELECT * FROM url_shorten WHERE url = '".$url."' "; 
 $result = $conn->query($query);
 if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
 return $row['short_code'];
} else {
$short_code = generateUniqueID();
$sql = "INSERT INTO url_shorten (url, short_code, hits)
VALUES ('".$url."', '".$short_code."', '0')";
if ($conn->query($sql) === TRUE) {
return $short_code;
} else { 
die("Unknown Error Occured");
}
}
}



function generateUniqueID(){
 global $conn; 
 $token = substr(md5(uniqid(rand(), true)),0,3); // creates a 3 digit unique short id. You can maximize it but remember to change .htacess value as well
 $query = "SELECT * FROM url_shorten WHERE short_code = '".$token."' ";
 $result = $conn->query($query); 
 if ($result->num_rows > 0) {
 generateUniqueID();
 } else {
 return $token;
 }
}


if(isset($_GET['redirect']) && $_GET['redirect']!="")
{ 
$slug=urldecode($_GET['redirect']);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$url= GetRedirectUrl($slug);
$conn->close();
header("location:".$url);
exit;
}


function GetRedirectUrl($slug){
 global $conn;
 $query = "SELECT * FROM url_shorten WHERE short_code = '".addslashes($slug)."' "; 
 $result = $conn->query($query);
 if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
// increase the hit
$hits=$row['hits']+1;
$sql = "update url_shorten set hits='".$hits."' where id='".$row['id']."' ";
$conn->query($sql);
return $row['url'];
}
else 
 { 
die("Invalid Link!");
}
}

?>
  </body>
  
