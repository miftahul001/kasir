<?php
require_once('connection.php');
ini_set('max_execution_time', '60');
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
	
	if (!isset($_GET['req'])) {
		echo json_encode(['status' => 400, 'req' => 'request not set!']);
		exit();
	}
	
	switch ($_GET['req']) {
		
		case 'dasboard':
			
			$db = connect_db();
			if (!$db) {
				echo json_encode(['status' => 500, 'data' => $db->connect_error]);
			} else {
				
				$data = '';
				$q = $db->query("SELECT * FROM
					(SELECT COUNT(*)AS j_barang, SUM(stok)AS j_stok FROM barang)AS t1
					INNER JOIN
					(SELECT COUNT(id_barang)AS j_terjual, SUM(jumlah)AS j_stok_terjual FROM penjualan)AS t2");
				
	            if ($a = $q->fetch_assoc()) { $data = $a; }
				$q->free_result();
				$db->close();
				
				echo json_encode(['status' => 200, 'data' => $data ]);
			}
		break;
		
		case 'barang':
			
			$db = connect_db();
			if (!$db) {
				echo json_encode(['status' => 500, 'data' => $db->connect_error]);
			} else {
				
				$data = [];
				$q = $db->query("SELECT * FROM barang");
				
	            while ($a = $q->fetch_assoc()) { $data[] = $a; }
				$q->free_result();
				$db->close();
				
				echo json_encode(['status' => 200, 'data' => $data ]);
			}
		break;
		
		default:
			echo json_encode(['status' => 400, 'data' => 'unknown request ' . $_GET['req']]);
		break;
	}
	
} else if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
	
	echo json_encode(['status' => 400, 'data' => 'Not set']);
	
} else { echo json_encode(['status' => 400, 'data' => 'Bad Request']); }

?>