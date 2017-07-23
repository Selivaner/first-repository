<html>
<head>
<meta charset = "utf-8">
<title>Edit Segments</title>
<style type="text/css">
body {
	color: red;
}
td {
	color: white;
	background-color: silver;
	width: 20%;
	heght: 5 cm;
	text-align: center:
}
</style>
</head>
<body>
<?php
$room = $_POST['room'];
if (empty($room)) {
	$room = 0;
}
// echo $newId;
// echo $room;
//соединиться с базой данных
$conn = mysql_connect ("localhost", "user1", "s367BSG25Deu4");
$select = mysql_select_db ("chapter7", $conn);
//создать запрос
$sql = "SELECT * FROM enigmaAdventure WHERE id = $room";
$result = mysql_query ($sql, $conn);
$mainRow = mysql_fetch_assoc($result);
$theText = $mainRow["description"];
$roomName = $mainRow["name"];
$northList = makeList ("north", $mainRow["north"]);
$wesList = makeList ("west", $mainRow["west"] );
$eastList = makeList ("east", $mainRow["east"] );
$southList = makeList ("south", $mainRow["south"] );
$roomNum = $mainRow["id"];
echo "" . 
	"<form action = saveRoom.php method = POST>" . 
	"<center><table border = 1>" . 
	"<tr>" . 
		"<td colspan = 3>" . 
		"Room # $roomNum." .
		"<input type = text name = name value = $roomName>" .
		"<input type = hidden name = id value = $roomNum>" .
		"</td>" . 
	"</tr>" .	
	"<tr>" . 
		"<td></td>" . 
		"<td align = center>$northList</td>" . 
		"<td></td>" . 
	"</tr>" . 
	"<tr>" . 
		"<td align = center>$wesList</td>" . 
		"<td><textarea rows = 5 cols = 30 name = $description>$theText</textarea></td>" .	
		"<td align = center>$eastList</td>" . 		 
	"</tr>" .
	"<tr>" . 
		"<td></td>" . 
		"<td align = center>$southList</td>" . 
		"<td></td>" . 
	"</tr>" .
	"<tr>" .
		"<td colspan = 3><input type = submit value = 'save this room'></td>" .
	"</tr>" .
	"</table>" . 
	"</form>";
mysql_close ($conn);

function makeList ($dir, $current) {
	//создаёт список всех доступных мест системы
	global $conn;
	$listCode = "<select name = $dir>\n";
	$sql = "SELECT id, name FROM enigmaAdventure";
	$result = mysql_query ($sql, $conn);
	$rowNum = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$id = $row["id"];
		$placeName = $row["name"];
		$listCode .= "<option value = $id";
		//выбрать эту опцию, если она помечена
		if ($rowNum == $current) {
			$listCode .= " selected";
		}
		$listCode .= ">" . $placeName . "</option>";
		$rowNum++;
	}
	return $listCode;
}
?>
</body>
</html>