<?php
function giveImage($url)
{
return "<img src='http://i3.ytimg.com/vi/".str_replace("/watch?v=","",$url)."/hqdefault.jpg' height='100' width='150'>";
}
function giveTitle($url)
{
$url = "https://www.youtube.com".$url;
$html = file_get_contents($url);
preg_match('/<title>(.*?)<\/title>/', $html, $titleMatches);
$title = isset($titleMatches[1]) ? $titleMatches[1] : '';
return $title;
}
function giveDescription($url)
{
$url = "https://www.youtube.com".$url;
$html = file_get_contents($url);
preg_match('/<meta name="description" content="(.*?)">/', $html, $descriptionMatches);
$description = isset($descriptionMatches[1]) ? $descriptionMatches[1] : '';
return $description;
}
function generateresult($url)
{
$x = "";
$x=$x."<table>";
$x=$x."<tr>";
$x=$x."<td style='width: 10%;'><a href='https://youtube.com".$url."' target='_blank'>".giveImage($url)."</a></td>";
$x=$x."<td style='width: 90%;vertical-align: top;'><a href='https://youtube.com".$url."' target='_blank'><b>".giveTitle($url)."</b></a>"."<br>".giveDescription($url)."</td>";
$x=$x."</tr>";
$x=$x."</table>";
return $x;
}
//$url = "/watch?v=0x6X0t_W3lY";
//echo generateresult($url);
//echo giveImage($url);
//echo giveTitle($url);
//echo giveDescription($url);

?>
