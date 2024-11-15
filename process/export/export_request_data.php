<?php
include '../../process/conn.php';

$delimiter = ",";

$filename = 'Request Data Record_' . $server_date_only . '.csv';

// Create a file pointer 
$f = fopen('php://memory', 'w');

// Add UTF-8 BOM (For Any characters compatibility)
fputs($f, "\xEF\xBB\xBF");

// Set column headers 
$fields = array(
	'Request ID',
	'Status',
	'Car Maker',
	'Car Model',
	'Product',
	'Jig Name',
	'Drawing No',
	'Type',
	'Qty',
	'Purpose',
	'Kigyo Budget',
	'Date Requested',
	'Requested By',
	'Required Delivery Date',
	'Order Destination',
	'Shipping Method',
	'Date of Issuance of RFQ',
	'RFQ No',
	'RFQ Remarks',
	'Target Date of Reply Quotation',
	'Item Code'
);
$fields_exp = array(
	'Request ID',
	'Status',
	'Ex. Mazda',
	'Ex. J12SRHD',
	'Ex.123',
	'Ex. DA-123',
	'Ex.',
	'Ex.Assy jig',
	'Ex.123',
	'Ex. EV-MP Set up',
	'Ex.12345',
	'Ex. YYYY-MM-DD',
	'Ex. Juan',
	'Ex. YYYY-MM-DD',
	'Example',
	'Ex. AIR',
	'Ex. YYYY-MM-DD',
	'RFQ No',
	'RFQ Remarks',
	'Ex. YYYY-MM-DD',
	'Item Code'
);

fputcsv($f, $fields, $delimiter);
fputcsv($f, $fields_exp, $delimiter);

$sql = "SELECT * FROM joms_request WHERE status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->execute();
if ($stmt->rowCount() > 0) {
	foreach ($stmt->fetchALL() as $row) {
		$lineData = array(
			$row['request_id'],
			$row['status'],
			$row['carmaker'],
			$row['carmodel'],
			$row['product'],
			$row['jigname'],
			$row['drawing_no'],
			$row['type'],
			$row['qty'],
			$row['purpose'],
			$row['budget'],
			$row['date_requested'],
			$row['requested_by'],
			$row['required_delivery_date'],
			$row['remarks'],
			$row['shipping_method']
		);
		fputcsv($f, $lineData, $delimiter);
	}
} else {

	// Output each row of the data, format line as csv and write to file pointer 
	$lineData = array("NO DATA FOUND");
	fputcsv($f, $lineData, $delimiter);


}

// Move back to beginning of file 
fseek($f, 0);

// Set headers to download file rather than displayed 
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');

//output all remaining data on a file pointer 
fpassthru($f);

$conn = null;

?>