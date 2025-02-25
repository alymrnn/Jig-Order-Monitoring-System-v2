<?php
include '../../process/conn.php';
$delimiter = ",";

if (
	!isset($_GET['history_date_from']) || !isset($_GET['history_date_to']) ||
	!isset($_GET['search_rfq']) || !isset($_GET['search_jigname']) ||
	!isset($_GET['search_carmaker'])
) {
	echo 'Query Parameters Not Set';
	exit;
}

$history_date_from = $_GET['history_date_from'];
$history_date_to = $_GET['history_date_to'];
$search_rfq = $_GET['search_rfq'];
$search_jigname = $_GET['search_jigname'];
$search_carmaker = $_GET['search_carmaker'];

$hdf = new DateTime($history_date_from);
$history_date_from = date_format($hdf, "Y-m-d h:i:s");

$hdt = new DateTime($history_date_to);
$history_date_to = date_format($hdt, "Y-m-d h:i:s");

$filename = "Closed Request History as of " . $history_date_from . " to " . $history_date_to . ".csv";

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
	'Item Code',
	'Date of Reply Quotation',
	'Validity of Quotation',
	'LEADTIME(based on quotation)',
	'Quotation No ',
	'Unit Price JPY ',
	'Unit Price USD',
	'Unit Price PHP',
	'Total Amount ',
	'FSIB No. ',
	'FSIB Code ',
	'Date sent to Internal Signatories ',
	'Target Approval date of quotation ',
	'RFQ Status ',
	'Approval date of quotation ',
	'Target Date Submission to Purchasing ',
	'Actual Date of Submission to Purchasing ',
	'Target PO Date',
	'Date Received PO Doc from Purchasing',
	'Date Issued to Requestor',
	'Issued To',
	'Date Returned By Requestor',
	'PO Date ',
	'PO No. ',
	'Supplier ',
	'ETD ',
	'ETA ',
	'Actual Arrival date ',
	'Invoice No',
	'Remarks '
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
	'Ex. Local/Imported',
	'Ex. YYYY-MM-DD',
	'Item Code',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'LEADTIME(based on quotation)',
	'Quotation No ',
	'Unit Price JPY ',
	'Unit Price USD',
	'Unit Price PHP',
	'Total Amount ',
	'FSIB No. ',
	'FSIB Code ',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'RFQ Status',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'Issued To',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'PO No. ',
	'Supplier ',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'Ex. YYYY-MM-DD',
	'Invoice No ',
	'Remarks'
);

fputcsv($f, $fields, $delimiter);
fputcsv($f, $fields_exp, $delimiter);

$sql = "SELECT joms_request.id,joms_request.request_id,joms_request.status, joms_request.carmaker, joms_request.carmodel, joms_request.product, joms_request.jigname, joms_request.drawing_no, joms_request.type, joms_request.qty, joms_request.purpose, joms_request.budget, joms_request.shipping_method,
joms_request.date_requested, joms_request.requested_by, joms_request.required_delivery_date, joms_request.remarks,
joms_rfq_process.date_of_issuance_rfq, joms_rfq_process.rfq_no, joms_rfq_process.rfq_remarks, joms_rfq_process.rfq_status,
joms_rfq_process.target_date_reply_quotation, joms_rfq_process.item_code, joms_rfq_process.date_reply_quotation, joms_rfq_process.validity_quotation, joms_rfq_process.leadtime, joms_rfq_process.quotation_no, joms_rfq_process.unit_price_jpy, joms_rfq_process.unit_price_usd,joms_rfq_process.unit_price_php, joms_rfq_process.total_amount, joms_rfq_process.fsib_no, joms_rfq_process.fsib_code, joms_rfq_process.date_sent_to_internal_signatories,
joms_rfq_process.target_approval_date_of_quotation, joms_po_process.approval_date_of_quotation, joms_po_process.target_date_submission_to_purchasing, joms_po_process.actual_date_of_submission_to_purchasing, joms_po_process.target_po_date, joms_po_process.date_received_po_doc_purchasing, joms_po_process.date_issued_to_requestor, joms_po_process.issued_to, joms_po_process.date_returned_by_requestor, joms_po_process.po_date, joms_po_process.po_no, joms_po_process.supplier, joms_po_process.etd, joms_po_process.eta, joms_po_process.actual_arrival_date, joms_po_process.invoice_no, joms_po_process.remarks AS remarks2,
joms_installation.installation_date
	FROM joms_request
	LEFT JOIN joms_rfq_process ON joms_rfq_process.request_id = joms_request.request_id
	LEFT JOIN joms_po_process ON joms_po_process.request_id = joms_request.request_id
	LEFT JOIN joms_installation ON joms_installation.request_id = joms_request.request_id
	WHERE joms_request.status = 'closed' AND (joms_po_process.date_updated >= '$history_date_from' AND joms_po_process.date_updated <= '$history_date_to') AND joms_rfq_process.rfq_no LIKE '$search_rfq%' AND joms_request.jigname LIKE '$search_jigname%'  AND joms_request.carmaker LIKE '$search_carmaker%' ";

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
			$row['shipping_method'],
			//full rfq
			$row['date_of_issuance_rfq'],
			$row['rfq_no'],
			$row['rfq_remarks'],
			$row['target_date_reply_quotation'],
			$row['item_code'],
			$row['date_reply_quotation'],
			$row['validity_quotation'],
			$row['leadtime'],
			$row['quotation_no'],
			$row['unit_price_jpy'],
			$row['unit_price_usd'],
			$row['unit_price_php'],
			$row['total_amount'],
			//rfq+add			
			$row['fsib_no'],
			$row['fsib_code'],
			$row['date_sent_to_internal_signatories'],
			$row['target_approval_date_of_quotation'],
			$row['rfq_status'],

			$row['approval_date_of_quotation'],
			$row['target_date_submission_to_purchasing'],
			$row['actual_date_of_submission_to_purchasing'],
			$row['target_po_date'],
			$row['date_received_po_doc_purchasing'],
			$row['date_issued_to_requestor'],
			$row['issued_to'],
			$row['date_returned_by_requestor'],
			$row['po_date'],
			$row['po_no'],
			$row['supplier'],
			$row['etd'],
			$row['eta'],
			$row['actual_arrival_date'],
			$row['invoice_no'],
			$row['remarks2']
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