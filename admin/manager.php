<?php
	include("cms.php");
	$tables = $mysqli->query("SHOW TABLES");
	while($table = $tables->fetch_array()) {
		echo("<h2>" . $table[0] . "<br></h2>");
		$columns = $mysqli->query("SHOW COLUMNS from {$table[0]}");
		echo "<table><thead><tr>";
		while($column = $columns->fetch_array()){
			echo "<th>" . $column[0] . "</th>";
		}
		echo "</tr></thead><tbody>";
		$rows = $mysqli->query("SELECT * FROM {$table[0]}");
		while ($row = $rows->fetch_array()){
			echo "<tr>";
			foreach($row as $value){
				echo htmlentities("<td>".$value."</td>");
			}
			echo "</tr>";
		}

		echo "</tbody></table>";
	}
?>