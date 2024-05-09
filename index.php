<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/table.css">
  <style>
    /* CSS for the search bar */
    .search-container {
      display: flex;
      align-items: center;
      width: 100%;
      height: 40px;
      border: 1px solid #ccc;
      border-radius: 20px;
      overflow: hidden;
    }
    
    .search-input {
      flex: 1;
      border: none;
      outline: none;
      padding: 10px;
      font-size: 16px;
    }
    
    .search-button {
      background-color: #4285f4;
      color: #fff;
      border: none;
      padding: 10px;
      border-radius: 0 20px 20px 0;
      cursor: pointer;
      font-size: 16px;
    }
    
    .search-button:hover {
      background-color: #3367d6;
    }
  </style>
<title>Base Line Search Engine</title>
</head>
<body>
  <form id="search" name="search" action="index.php" method="GET">
    <div class="search-container">
      <input id="query" name="query" class="search-input" type="text" <?php if(!isset($_GET["query"])){echo 'placeholder="Search..."';} else {echo 'value="'.$_GET["query"].'"';}?> >
      <button class="search-button" type="submit">Search</button>
    </div>
  </form>
  <table>
        <tr>
            <th>Traditional Cross Vertical Aggregated Search</th>
            <th>Proposed Summarized Snippet Based Search</th>
        </tr>
        <tr>
		<?php if(isset($_GET["query"]))
		{
        echo "<td><iframe src='CVASBSR/index.php?query=".$_GET["query"]."' width='100%' height='500px'></iframe></td>";
		echo "<td><iframe src='textsr.php?query=".$_GET["query"]."' width='100%' height='500px'></iframe></td>";
		}
		?>
        </tr>
    </table>
<br>
<?php //if(isset($_GET["query"])){include("vertical_buttons.php");}?>
</body>
</html>
