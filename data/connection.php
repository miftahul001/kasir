<?php
function connect_db() {
	return new mysqli("mysql", "miftahul", "munir", "db_toko");
}
?>