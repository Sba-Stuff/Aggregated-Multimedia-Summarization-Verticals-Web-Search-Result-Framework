<?php
$query = "";
if(isset($_GET["query"])){$query="?query=".$_GET["query"];}

$webButton = '<a href="index.php'.$query.'"><button style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px;">Web</button></a>';

$imageButton = '<a href="images.php'.$query.'"><button style="background-color: #28a745; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px;">Images</button></a>';

$videoButton = '<a href="videos.php'.$query.'"><button style="background-color: #FFA500; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px;">Videos</button></a>';

echo "<center>".$webButton." | ".$imageButton." | ".$videoButton."</center>";
?>