<!DOCTYPE html>
<html>
<head>
  <title>Hover Effect on Tables</title>
  <style>
    .hidden {
      display: none;
    }
	.table-container {
      float: left;
      margin-right: 20px; /* Add some spacing between the tables */
    }

    /* Alternatively, you can use display: inline-block */
    .table-container {
      display: inline-block;
      margin-right: 20px; /* Add some spacing between the tables */
	  }
  </style>
</head>
<body>
<?php
for($i=1;$i<11;$i++)
{
echo "<div class='table-container'>";
echo "<br><br>";
echo "<table width='300' border='1' bordercolor='#000000' id='table".$i."'>";
echo "<tr>";
echo "<td>Hello World</td>";
echo "</tr>";
echo "<tr class='hidden'>";
echo "<td>&nbsp;</td>";
echo "</tr>";
echo "<tr class='hidden'>";
echo "<td>&nbsp;</td>";
echo "</tr>";
echo "<tr class='hidden'>";
echo "<td>&nbsp;</td>";
echo "</tr>";
echo "<tr class='hidden'>";
echo "<td>&nbsp;</td>";
echo "</tr>";
echo "<tr class='hidden'>";
echo "<td>&nbsp;</td>";
echo "</tr>";
echo "</table>";
echo "</div>";
}
?>
<!-- Repeat the above table structure for tables 2 to 6 with unique IDs -->

<script>
  function handleTableHover(tableId) {
    const table = document.querySelector(`#${tableId}`);
    const firstRow = table.querySelector("tr:first-child");
    const otherRows = table.querySelectorAll("tr:not(:first-child)");

    firstRow.addEventListener("mouseenter", () => {
      otherRows.forEach(row => {
        row.classList.remove("hidden");
      });
    });

    table.addEventListener("mouseleave", () => {
      otherRows.forEach(row => {
        row.classList.add("hidden");
      });
    });
  }

  // Call the function for each table
  handleTableHover("table1");
  handleTableHover("table2");
  handleTableHover("table3");
  handleTableHover("table4");
  handleTableHover("table5");
  handleTableHover("table6");
  handleTableHover("table7");
  handleTableHover("table8");
  handleTableHover("table9");
  handleTableHover("table10");
</script>

</body>
</html>
