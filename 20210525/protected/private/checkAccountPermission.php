<?php
function getAccountPermission($local_permission, $local_accountID)	{
	include(dirname(getcwd()) . "/protected/private/mysqli_database.php");
	$local_dbc = $mysqliConnectValue;
	$local_stmt = mysqli_prepare($local_dbc, "SELECT " . $local_permission . "_permission FROM staff WHERE id=?");
	mysqli_stmt_bind_param($local_stmt, "i", $local_accountID);
	if(mysqli_stmt_execute($local_stmt))    {
		mysqli_stmt_bind_result($local_stmt, $local_permission);
		mysqli_stmt_fetch($local_stmt);
	}
	mysqli_stmt_close($local_stmt);
	mysqli_close($local_dbc);
	return $local_permission;
}
?>