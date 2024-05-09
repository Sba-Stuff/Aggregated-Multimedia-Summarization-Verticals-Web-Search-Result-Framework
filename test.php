<?php
function starter()
{
$x = "[";
$x=$x.'{';
$x=$x.'"name": "Search Results",';
$x=$x.'"id": 1';
$x=$x.'},';
return $x;
}
function ResultGen($res,$id,$title)
{
$x = "";
$x=$x.'{';
$x=$x.'"name": "Result '.$res.'",';
$x=$x.'"id": '.$id.',';
$x=$x.'"summary": "Titled: '.$title.'",';
$x=$x.'"parent":1';
$x=$x.'},';
return $x;
}

function SummaryGen($id,$parentid,$summary)
{
$x = "";
$x=$x.'{';
$x=$x.'"name": "Summary",';
$x=$x.'"id": '.$id.',';
$x=$x.'"parent":'.$parentid.',';
$x=$x.'"summary": "'.$summary.'",';
$x=$x.'"value": 219';
$x=$x.'},';
return $x;
}
function ImageGen($id,$parentid,$images)
{
$x = "";
$x=$x.'{';
$x=$x.'"name": "Images",';
$x=$x.'"id": '.$id.',';
$x=$x.'"parent":'.$parentid.',';
$x=$x.'"Images": "'.$images.'",';
$x=$x.'"value": 219';
$x=$x.'},';
return $x;
}
function VideoGen($id,$parentid,$videos)
{
$x = "";
$x=$x.'{';
$x=$x.'"name": "Videos",';
$x=$x.'"id": '.$id.',';
$x=$x.'"parent":'.$parentid.',';
$x=$x.'"Videos": "'.$videos.'",';
$x=$x.'"value": 219';
$x=$x.'},';
return $x;
}
function ender($json)
{
$x = substr($json, 0, -1)."]";
return $x;
}

function makeJson()
{
$id=1;
$res=1;
$x = starter();
//a:
$x = $x.ResultGen($res,$id+1);
$x = $x.SummaryGen($id+2,$id+1,"Bol Na Aunty Aun Kia?");
$x = $x.ImageGen($id+3,$id+1,"<img src='https://www.php.net/images/logos/php-logo.svg'>");
$x = $x.VideoGen($id+4,$id+1,"Video 1, Video 2");
//$id=$id+4;
//$res=$res+1;
//if($res<10){goto a;}
$x = ender($x);
return $x;
}
//Global ID And Res
//echo makeJson();

?>
