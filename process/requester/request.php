<?php
session_start();
include '../conn.php';

$method = $_POST['method'];

if ($method == 'fetch_request') {
	// declated the name="";  filter with on-change code 
	$request_status = $_POST['request_status'];
	$request_date_from = $_POST['request_date_from'];
	$request_date_to = $_POST['request_date_to'];
	$request_section = $_POST['request_section'];
	$request_car_maker = $_POST['request_car_maker'];
	$request_car_model = $_POST['request_car_model'];

	//Select or check all the data in the table and combine Request+RFQ+PO+Installation
	$c = 0;
	$query = "SELECT joms_request.request_id, joms_request.status, joms_request.carmaker, joms_request.carmodel, joms_request.product, joms_request.jigname, joms_request.drawing_no, joms_request.type, joms_request.qty, joms_request.purpose, joms_request.budget, joms_request.date_requested, joms_request.requested_by , joms_request.required_delivery_date, joms_request.shipping_method,joms_request.remarks, joms_request.uploaded_by, joms_request.cancel_date, joms_request.cancel_reason, joms_request.cancel_by, joms_request.cancel_section,joms_request.section,
	joms_rfq_process.date_of_issuance_rfq, joms_rfq_process.rfq_no, joms_rfq_process.rfq_remarks, joms_rfq_process.target_date_reply_quotation,  joms_rfq_process.item_code, joms_rfq_process.date_reply_quotation, joms_rfq_process.leadtime, joms_rfq_process.quotation_no, joms_rfq_process.unit_price_jpy, joms_rfq_process.unit_price_usd,joms_rfq_process.unit_price_php, joms_rfq_process.total_amount, joms_rfq_process.fsib_no, joms_rfq_process.fsib_code, joms_rfq_process.date_sent_to_internal_signatories, joms_rfq_process.i_uploaded_by, joms_rfq_process.c_uploaded_by, 
	joms_rfq_process.target_approval_date_of_quotation, joms_rfq_process.rfq_status,
	joms_po_process.approval_date_of_quotation, joms_po_process.target_date_submission_to_purchasing, joms_po_process.actual_date_of_submission_to_purchasing, joms_po_process.target_po_date, joms_po_process.po_date, joms_po_process.po_no, joms_po_process.supplier, joms_po_process.etd, joms_po_process.eta, joms_po_process.actual_arrival_date, joms_po_process.invoice_no, joms_po_process.po_uploaded_by, joms_po_process.remarks AS remarks2,
	joms_installation.installation_date, joms_installation.set_by, joms_installation.line_no
		 FROM joms_request
		LEFT JOIN joms_rfq_process ON joms_rfq_process.request_id = joms_request.request_id
		LEFT JOIN joms_po_process ON joms_po_process.request_id = joms_request.request_id
		LEFT JOIN joms_installation ON joms_installation.request_id = joms_request.request_id";

	//process para sa mga table  kapag may date ang intallation  i-display ng data kay ame 3 if wala i-display ang data kay ame 3.
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

	//color for coding for the delay of date 
	$query = $query . " AND (joms_request.date_requested >= '$request_date_from' AND joms_request.date_requested <= '$request_date_to')";

	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $j) {
			$c++;
			$supplier = $j['supplier'];
			$date_requested = $j['date_requested']; // May 8 // server_date_only = Aug 14 (or Date Today)
			$date_of_issuance_rfq = $j['date_of_issuance_rfq']; // May 11
			$restriction_of_issuance_rfq = date('Y-m-d', (strtotime('+2 day', strtotime($date_requested)))); // May 8 + 2 days = May 10

			$date_reply_quotation = $j['date_reply_quotation']; // May 13
			$restriction_of_reply_quotation = date('Y-m-d', (strtotime('+14 day', strtotime($restriction_of_issuance_rfq)))); // May 10 + 14 days = May 24


			$approval_date_of_quotation = $j['approval_date_of_quotation']; // May 16
			$restriction_of_approval_date_of_quotation = date('Y-m-d', (strtotime('+7 day', strtotime($restriction_of_reply_quotation)))); // May 24 + 7 days = May 31

			$required_delivery_date = $j['required_delivery_date'];
			$color4 = "";

			if (!empty($required_delivery_date) && $required_delivery_date < $server_date_only) {
				$color4 = "background-color:#C83535; color:#FFF";
			}

			if ($supplier == 'Local') {

			} else if ($supplier == 'FAS' || $supplier == 'FAPV' || $supplier == 'FSKIP') {
				if ($date_of_issuance_rfq == '' && $server_date_only > $restriction_of_issuance_rfq || $date_of_issuance_rfq > $restriction_of_issuance_rfq) {
					$color = "color:red;";

				} else {
					$color = "";
				}

				if ($date_reply_quotation == '' && $server_date_only > $restriction_of_reply_quotation || $date_reply_quotation > $restriction_of_issuance_rfq) {
					$color2 = "color:orange";
				} else {
					$color2 = "";
				}

				if ($approval_date_of_quotation == '' || $server_date_only > $restriction_of_approval_date_of_quotation || $approval_date_of_quotation > $restriction_of_approval_date_of_quotation) {
					$color3 = "color:purple";
				} else {
					$color3 = "";
				}
			} else {
				$color = "";
				$color2 = "";
				$color3 = "";
			}
			//displaying the data
			echo '<tr>';
			echo '<td>';
			$disable_row = '';
			if ($request_status == 'cancelled') {
				$disable_row = 'disabled';
				$cursor = 'cursor:pointer';
				$class_mods = 'modal-trigger" data-toggle="modal" data-target="#cancel_info_modal';
			} else if ($request_status == 'open') {
				$disable_row = 'disabled';
				$cursor = '';
				$class_mods = '';
			} else if ($request_status == 'ame3') {
				$disable_row = 'disabled';
				$cursor = '';
				$class_mods = '';
			} else if ($request_status == 'ame2') {
				$disable_row = 'disabled';
				$cursor = '';
				$class_mods = '';
			} else {
				$cursor = "";
				$class_mods = "";
			}

			echo '<input type="checkbox" class="singleCheck bg-secondary" value="' . $j['request_id'] . '" onclick="get_checked_length()" ' . $disable_row . '>';
			echo '</td>';

			echo '<td style = "' . $color . '">' . $c . '</td>';
			echo '<td style = " ' . $color4 . $cursor . '"  class="' . $class_mods . '" onclick="get_cancel_details(&quot;' . $j['request_id'] . '~!~' . $j['cancel_date'] . '~!~' . $j['cancel_reason'] . '~!~' . $j['cancel_by'] . '~!~' . $j['cancel_section'] . '&quot;)">' . $j['status'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['carmaker'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['carmodel'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['product'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['jigname'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['drawing_no'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['type'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['qty'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['purpose'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['budget'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['shipping_method'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['date_requested'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['requested_by'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['required_delivery_date'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['remarks'] . '</td>';
			echo '<td style = "' . $color4 . '">' . $j['uploaded_by'] . '</td>';
			//rfq
			echo '<td style = "' . $color2 . '">' . $j['date_of_issuance_rfq'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['rfq_no'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['rfq_remarks'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['target_date_reply_quotation'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['item_code'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['i_uploaded_by'] . '</td>';

			echo '<td style = "' . $color2 . '">' . $j['date_reply_quotation'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['leadtime'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['quotation_no'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['unit_price_jpy'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['unit_price_usd'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['unit_price_php'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['total_amount'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['fsib_no'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['fsib_code'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['date_sent_to_internal_signatories'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['target_approval_date_of_quotation'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['rfq_status'] . '</td>';
			echo '<td style = "' . $color2 . '">' . $j['c_uploaded_by'] . '</td>';

			//po
			echo '<td style = "' . $color3 . '">' . $j['approval_date_of_quotation'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['target_date_submission_to_purchasing'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['actual_date_of_submission_to_purchasing'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['target_po_date'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['po_date'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['po_no'] . '</td>';
			// echo '<td style = "' . $color3 . '">' . $j['ordering_additional_details'] . '</td>';
			// echo '<td style = "'.$color3.'">'.$j['car_model_for_formula'].'</td>';
			echo '<td style = "' . $color3 . '">' . $j['supplier'] . '</td>';
			// echo '<td style = "'.$color3.'">'.$j['start_of_usage'].'</td>';
			// echo '<td style = "'.$color3.'">'.$j['required_delivery_date2'].'</td>';
			echo '<td style = "' . $color3 . '">' . $j['etd'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['eta'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['invoice_no'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['remarks2'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['actual_arrival_date'] . '</td>';
			echo '<td style = "' . $color3 . '">' . $j['po_uploaded_by'] . '</td>';

			echo '<td>' . $j['line_no'] . '</td>';
			echo '<td>' . $j['installation_date'] . '</td>';
			echo '<td>' . $j['set_by'] . '</td>';
			echo '</tr>';
		}
	}
}

//display all request data with all pending request in the Ame1 table or mppd1
if ($method == 'fetch_requested_processed') {
	$c = 0;
	$query = "SELECT * FROM joms_request WHERE status = 'pending'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchAll() as $j) {
			$c++;

			// Check if required delivery date is delayed
			$required_delivery_date = $j['required_delivery_date'];
			$color4 = "";

			// Check if required delivery date is delayed (before today's date)
			if (!empty($required_delivery_date) && $required_delivery_date < $server_date_only) {
				$color4 = "background-color:#C83535; color:#FFF";
			}

			echo '<tr>';
			echo '<td>' . $c . '</td>';
			echo '<td style="' . $color4 . '">' . $j['status'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['carmaker'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['carmodel'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['product'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['jigname'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['drawing_no'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['type'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['qty'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['purpose'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['budget'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['shipping_method'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['date_requested'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['requested_by'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['required_delivery_date'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['remarks'] . '</td>';
			echo '<td style="' . $color4 . '">' . $j['uploaded_by'] . '</td>';
			echo '</tr>';
		}
	}
}

if ($method == 'cancellation') {
	$id = [];
	$id = $_POST['id'];
	$cancel_date = $_POST['cancel_date'];
	$cancel_reason = $_POST['cancel_reason'];
	$count = count($id);
	foreach ($id as $j) {
		//echo $j;
		$query = "UPDATE joms_request 
		SET status = 'cancelled', cancel_date = '$cancel_date', cancel_reason = '$cancel_reason',
		cancel_by = '" . $_SESSION['fullname'] . "', cancel_section = '" . $_SESSION['section'] . "' WHERE request_id = '$j'";
		$stmt = $conn->prepare($query);
		if ($stmt->execute() > 0) {
			$count = $count - 1;
		}
	}
	if ($count == 0) {
		echo 'success';
	} else {
		echo 'fail';
	}
}

if ($method == 'fetch_opt_car_maker') {
	$query = "SELECT DISTINCT carmaker FROM joms_request ORDER BY carmaker ASC";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo '<option value="" selected>Select car maker</option>';
		foreach ($stmt->fetchAll() as $row) {
			echo '<option>' . htmlspecialchars($row['carmaker']) . '</option>';
		}
	} else {
		echo '<option value="">No car makers available</option>';
	}
}

if ($method == 'fetch_opt_car_model') {
	$query = "SELECT DISTINCT carmodel FROM joms_request ORDER BY carmodel ASC";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo '<option value="" selected>Select car model</option>';
		foreach ($stmt->fetchAll() as $row) {
			echo '<option>' . htmlspecialchars($row['carmodel']) . '</option>';
		}
	} else {
		echo '<option value="">No car models available</option>';
	}
}

function generate_joms_request_id($request_id)
{
	if ($request_id == "") {
		$request_id = date("ymdh");
		$rand = substr(md5(microtime()), rand(0, 26), 5);
		$request_id = 'JOMS:' . $request_id;
		$request_id = $request_id . '' . $rand;
	}
	return $request_id;
}

function update_notif_count_joms_request($conn)
{
	$sql = "UPDATE `notif_joms_request` SET `new_joms_request`= new_joms_request + 1 WHERE interface = 'AME3'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
}

if ($method == 'add_single_item_record') {
	$car_maker = trim($_POST['car_maker']);
	$car_model = trim($_POST['car_model']);
	$product = trim($_POST['product']);
	$jig_name = trim($_POST['jig_name']);
	$drawing_no = trim($_POST['drawing_no']);
	$type = trim($_POST['type']);
	$quantity = trim($_POST['quantity']);
	$purpose = trim($_POST['purpose']);
	$kigyo_budget = trim($_POST['kigyo_budget']);
	$date_requested = trim($_POST['date_requested']);
	$requested_by = trim($_POST['requested_by']);
	$delivery_date = trim($_POST['delivery_date']);
	$shipping_method = trim($_POST['shipping_method']);
	$remarks = trim($_POST['remarks']);

	$request_id = '';
	$request_id = generate_joms_request_id($request_id);

	$uploaded_by = $_SESSION['fullname'];
	$section = $_SESSION['section'];

	$query = "INSERT INTO joms_request(`request_id`, `carmaker`, `carmodel`, `product`, `jigname`, `drawing_no`, `type`, `qty`,`purpose`, `budget`, `date_requested`, `requested_by`, `required_delivery_date`, `shipping_method`,`remarks`, `uploaded_by`, `section`) 
	VALUES ('$request_id','$car_maker','$car_model','$product','$jig_name','$drawing_no','$type','$quantity','$purpose','$kigyo_budget','$date_requested','$requested_by','$delivery_date','$shipping_method','$remarks','$uploaded_by','$section')";

	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		update_notif_count_joms_request($conn);
		echo 'success';
	} else {
		echo 'error';
	}
}

$conn = NULL;
?>