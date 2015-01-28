<?php
include ("backend.php");

$username = $_GET["user"];
$screenWidth = $_GET["screenWidth"];
$screenHeight = $_GET["screenHeight"];
$userAgent = $_GET["userAgent"];

$insertStmt = "INSERT into clientInfo (username, screenWidth, screenHeight, userAgent, saveDate)
  VALUES ('" . $username . "', " . $screenWidth . ", " . $screenHeight .
    ", '" . urldecode($userAgent) . "', getdate())";

//$insertResult = dbQuery ($insertStmt) or die ("FATAL ERROR: Couldn't insert record into clientInfo.");
dbQuery($insertStmt);
?>