<?php
ini_set("memory_limit", "-1");
include '../../process/conn.php';

$request_status = $_GET['request_status'] ?? '';
$request_date_from = $_GET['request_date_from'] ?? '';
$request_date_to = $_GET['request_date_to'] ?? '';
$request_section = $_GET['request_section'] ?? '';
$request_car_maker = $_GET['request_car_maker'] ?? '';
$request_car_model = $_GET['request_car_model'] ?? '';

$filename = 'Request-Monitoring_Record_' . date("Y-m-d") . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$f = fopen('php://output', 'w');

fputs($f, "\xEF\xBB\xBF");

$delimiter = ',';

$headers = array(
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
    'Remarks',
    'Shipping Method',
    'Uploaded By',

    'Date of Issuance of RFQ',
    'RFQ No',
    'RFQ Remarks',
    'Target Date of Reply Quotation',
    'Item Code',
    'Uploaded By',
    'Date of Reply Quotation',
    'Validity of Quotation',
    'LEADTIME(based on quotation)',
    'Quotation No',
    'Unit Price JPY',
    'Unit Price USD',
    'Unit Price PHP',
    'Total Amount',
    'FSIB No.',
    'FSIB Code',
    'Date sent to Internal Signatories',
    'Target Approval Date of Quotation',
    'RFQ Status',
    'Uploaded By',

    'Approval date of quotation',
    'Target Date Submission to Purchasing',
    'Actual Date of Submission to Purchasing',
    'Target PO Date',
    'Date Received PO Doc from Purchasing',
    'Date Issued to Requestor',
    'Issued To',
    'Date Returned By Requestor',
    'PO Date',
    'PO No.',
    'Supplier',
    'ETD',
    'ETA',
    'Invoice No',
    'Remarks',
    'Actual Arrival Date',
    'Uploaded By',

    'Line Number',
    'Installation Date',
    'Uploaded By'
);

fputcsv($f, $headers, $delimiter);

$query = "SELECT joms_request.status, joms_request.carmaker, joms_request.carmodel, joms_request.product, joms_request.jigname, joms_request.drawing_no, joms_request.type, joms_request.qty, joms_request.purpose, joms_request.budget, joms_request.date_requested, joms_request.requested_by , joms_request.required_delivery_date, joms_request.remarks, joms_request.shipping_method,joms_request.uploaded_by, joms_request.cancel_date, joms_request.cancel_reason, joms_request.cancel_by, joms_request.cancel_section,joms_request.section,
	joms_rfq_process.date_of_issuance_rfq, joms_rfq_process.rfq_no, joms_rfq_process.rfq_remarks,
    joms_rfq_process.target_date_reply_quotation,  joms_rfq_process.item_code, joms_rfq_process.date_reply_quotation, joms_rfq_process.validity_quotation, joms_rfq_process.leadtime, joms_rfq_process.quotation_no, joms_rfq_process.unit_price_jpy, joms_rfq_process.unit_price_usd,joms_rfq_process.unit_price_php, joms_rfq_process.total_amount, joms_rfq_process.fsib_no, joms_rfq_process.fsib_code, joms_rfq_process.date_sent_to_internal_signatories, joms_rfq_process.i_uploaded_by, joms_rfq_process.c_uploaded_by, 
	joms_rfq_process.target_approval_date_of_quotation, joms_rfq_process.rfq_status,
    joms_po_process.approval_date_of_quotation, joms_po_process.target_date_submission_to_purchasing, joms_po_process.actual_date_of_submission_to_purchasing, joms_po_process.target_po_date, joms_po_process.date_received_po_doc_purchasing, joms_po_process.date_issued_to_requestor, joms_po_process.issued_to, joms_po_process.date_returned_by_inspector, joms_po_process.po_date, joms_po_process.po_no, joms_po_process.supplier, joms_po_process.etd, joms_po_process.eta, joms_po_process.actual_arrival_date, joms_po_process.invoice_no, joms_po_process.po_uploaded_by, joms_po_process.remarks AS remarks2,
	joms_installation.installation_date, joms_installation.set_by, joms_installation.line_no
		 FROM joms_request
		LEFT JOIN joms_rfq_process ON joms_rfq_process.request_id = joms_request.request_id
		LEFT JOIN joms_po_process ON joms_po_process.request_id = joms_request.request_id
		LEFT JOIN joms_installation ON joms_installation.request_id = joms_request.request_id";

if ($request_status == 'ame2') {
    $query = $query . " WHERE joms_request.status = 'closed' AND joms_installation.installation_date != ''";
} else if ($request_status == 'ame3') {
    $query = $query . " WHERE joms_request.status = 'closed' AND joms_installation.installation_date IS NULL";
} else {
    $query = $query . " WHERE joms_request.status = '$request_status' AND joms_request.section= '$request_section'";

    // Only add carmaker or carmodel conditions if they are provided
    if (!empty($request_car_maker)) {
        $query = $query . " AND joms_request.carmaker = '$request_car_maker'";
    }

    if (!empty($request_car_model)) {
        $query = $query . " AND joms_request.carmodel = '$request_car_model'";
    }
}

$query = $query . " AND (joms_request.date_requested >= '$request_date_from' AND joms_request.date_requested <= '$request_date_to')";
$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data = array_values($row);

        fputcsv($f, $data, $delimiter);
    }
} else {
    echo 'NO RECORD FOUND';
    exit;
}

fclose($f);
exit;
?>