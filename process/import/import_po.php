<?php
session_start();
// error_reporting(0);
require '../conn.php';

function validate_date($date)
{
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
        return true;
    } else {
        return false;
    }
}

function check_csv($file, $conn)
{
    // READ FILE
    $csvFile = fopen($file, 'r');
    // SKIP FIRST LINE MAIN
    fgetcsv($csvFile);
    // SKIP 2ND LINE HEADER EXAMPLE
    fgetcsv($csvFile);

    $hasError = 0;
    $hasBlankError = 0;
    $hasBlankErrorArr = array();

    $row_valid_arr = array(0, 0, 0, 0, 0, 0);

    $notValidApprovalDateOfQuotation = array();
    $notValidTargetDateSubmissionPurchasing = array();
    $notValidActualDateSubmissionPurchasing = array();
    $notValidTargetPODate = array();
    $notValidPODate = array();
    $notValidActualArrivalDate = array();

    $notValidDateReceivedPODocPurchasing = array();
    $notValidDateIssuedToRequestor = array();
    $notValidDateETD = array();
    $notValidDateETA = array();

    $notValidDateReturnedByRequestor = array();

    $message = "";
    $check_csv_row = 2;

    while (($line = fgetcsv($csvFile)) !== false) {
        $check_csv_row++;

        // Check if the row is blank or consists only of whitespace
        if (empty(implode('', $line))) {
            continue; // Skip blank lines
        }

        $date_adoq = str_replace('/', '-', $line[34]);
        $approval_date_of_quotation = validate_date($date_adoq);

        $date_tdstp = str_replace('/', '-', $line[35]);
        $target_date_submission_to_purchasing = validate_date($date_tdstp);

        $date_adostp = str_replace('/', '-', $line[36]);
        $actual_date_of_submission_to_purchasing = validate_date($date_adostp);

        $date_tpd = str_replace('/', '-', $line[37]);
        $target_po_date = validate_date($date_tpd);

        $date_pd = str_replace('/', '-', $line[42]);
        $po_date = validate_date($date_pd);

        // CHECK IF BLANK DATA
        if (!empty($line[34])) {
            if (
                $line[0] == '' || $line[34] == '' || $line[35] == '' || $line[36] == '' || $line[37] == '' ||
                $line[38] == '' || $line[39] == '' || $line[40] == '' || $line[41] == '' || $line[42] == '' ||
                $line[43] == '' || $line[44] == '' || $line[45] == '' || $line[46]
            ) {
                // IF BLANK DETECTED ERROR
                $hasBlankError++;
                $hasError = 1;
                array_push($hasBlankErrorArr, $check_csv_row);
            }
        } else {
            if (
                $line[0] == '' || $line[34] == '' || $line[35] == '' || $line[36] == '' || $line[37] == '' ||
                $line[38] == '' || $line[39] == '' || $line[40] == '' || $line[41] == '' || $line[42] == '' ||
                $line[43] == '' || $line[44] == '' || $line[45] == '' || $line[46]
            ) {
                // IF BLANK DETECTED ERROR
                $hasBlankError++;
                $hasError = 1;
                array_push($hasBlankErrorArr, $check_csv_row);
            }
        }

        //Check row validation
        if ($approval_date_of_quotation == false) {
            $hasError = 1;
            $row_valid_arr[0] = 1;
            array_push($notValidApprovalDateOfQuotation, $check_csv_row);
        }
        if ($target_date_submission_to_purchasing == false) {
            $hasError = 1;
            $row_valid_arr[1] = 1;
            array_push($notValidTargetDateSubmissionPurchasing, $check_csv_row);
        }
        if ($actual_date_of_submission_to_purchasing == false) {
            $hasError = 1;
            $row_valid_arr[2] = 1;
            array_push($notValidActualDateSubmissionPurchasing, $check_csv_row);
        }
        if ($target_po_date == false) {
            $hasError = 1;
            $row_valid_arr[3] = 1;
            array_push($notValidTargetPODate, $check_csv_row);
        }
        if ($po_date == false) {
            $hasError = 1;
            $row_valid_arr[4] = 1;
            array_push($notValidPODate, $check_csv_row);
        }
        if (!empty($line[47])) {
            $date_aad = str_replace('/', '-', $line[46]);
            $actual_arrival_date = validate_date($date_aad);
            if ($actual_arrival_date == false) {
                $hasError = 1;
                $row_valid_arr[5] = 1;
                array_push($notValidActualArrivalDate, $check_csv_row);
            }
        }

        if (!empty($line[38])) {
            $date_rpdp = str_replace('/', '-', $line[38]);
            $date_received_po_doc_purchasing = validate_date($date_rpdp);
            if ($date_received_po_doc_purchasing == false) {
                $hasError = 1;
                $row_valid_arr[6] = 1;
                array_push($notValidDateReceivedPODocPurchasing, $check_csv_row);
            }
        }
        if (!empty($line[39])) {
            $date_itr = str_replace('/', '-', $line[39]);
            $date_issued_to_requestor = validate_date($date_itr);
            if ($date_issued_to_requestor == false) {
                $hasError = 1;
                $row_valid_arr[7] = 1;
                array_push($notValidDateIssuedToRequestor, $check_csv_row);
            }
        }
        if (!empty($line[45])) {
            $date_etd = str_replace('/', '-', $line[44]);
            $etd = validate_date($date_etd);
            if ($etd == false) {
                $hasError = 1;
                $row_valid_arr[8] = 1;
                array_push($notValidDateETD, $check_csv_row);
            }
        }

        if (!empty($line[46])) {
            $date_eta = str_replace('/', '-', $line[45]);
            $eta = validate_date($date_eta);
            if ($eta == false) {
                $hasError = 1;
                $row_valid_arr[9] = 1;
                array_push($notValidDateETA, $check_csv_row);
            }
        }

        if (!empty($line[41])) {
            $date_rbr = str_replace('/', '-', $line[45]);
            $date_returned_by_requestor = validate_date($date_rbr);
            if ($date_returned_by_requestor == false) {
                $hasError = 1;
                $row_valid_arr[10] = 1;
                array_push($notValidDateReturnedByRequestor, $check_csv_row);
            }
        }
    }
    ;
    fclose($csvFile);

    if ($hasError == 1) {
        if ($row_valid_arr[0] == 1) {
            $message = $message . 'INVALID DATE FORMAT: Approval Date of Quotation on row/s ' . implode(", ", $notValidApprovalDateOfQuotation) . '. ';
        }
        if ($row_valid_arr[1] == 1) {
            $message = $message . 'INVALID DATE FORMAT: Target Date Submission to Purchasing on row/s ' . implode(", ", $notValidTargetDateSubmissionPurchasing) . '. ';
        }
        if ($row_valid_arr[2] == 1) {
            $message = $message . 'INVALID DATE FORMAT: Actual Date of Submission to Purchasing on row/s ' . implode(", ", $notValidActualDateSubmissionPurchasing) . '. ';
        }
        if ($row_valid_arr[3] == 1) {
            $message = $message . 'INVALID DATE FORMAT: Target PO Date on row/s ' . implode(", ", $notValidTargetPODate) . '. ';
        }
        if ($row_valid_arr[4] == 1) {
            $message = $message . 'INVALID DATE FORMAT: PO Date on row/s ' . implode(", ", $notValidPODate) . '. ';
        }
        if ($row_valid_arr[5] == 1) {
            $message = $message . 'INVALID DATE FORMAT: Actual Arrival Date on row/s ' . implode(", ", $notValidActualArrivalDate) . '. ';
        }

        if ($row_valid_arr[6] == 1) {
            $message = $message . 'INVALID DATE FORMAT: Date Received PO Doc from Purchasing on row/s ' . implode(", ", $notValidDateReceivedPODocPurchasing) . '. ';
        }
        if ($row_valid_arr[7] == 1) {
            $message = $message . 'INVALID DATE FORMAT: Date Issued To Requestor on row/s ' . implode(", ", $notValidDateIssuedToRequestor) . '. ';
        }
        if ($row_valid_arr[8] == 1) {
            $message = $message . 'INVALID DATE FORMAT: ETD on row/s ' . implode(", ", $notValidDateETD) . '. ';
        }
        if ($row_valid_arr[9] == 1) {
            $message = $message . 'INVALID DATE FORMAT: ETA on row/s ' . implode(", ", $notValidDateETA) . '. ';
        }

        if ($row_valid_arr[10] == 1) {
            $message = $message . 'INVALID DATE FORMAT: Date Returned By Requestor on row/s ' . implode(", ", $notValidDateReturnedByRequestor) . '. ';
        }

        if ($hasBlankError >= 1) {
            $message = $message . 'Blank Cell Exists on row/s ' . implode(", ", $hasBlankErrorArr) . '. ';
        }
    }
    return $message;
}
if (isset($_POST['upload'])) {
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $chkCsvMsg = check_csv($_FILES['file']['tmp_name'], $conn);

            if ($chkCsvMsg == '') {
                //READ FILE
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                // SKIP FIRST LINE
                fgetcsv($csvFile);
                // SKIP 2ND LINE HEADER EXAMPLE
                fgetcsv($csvFile);
                // PARSE
                $error = 0;

                while (($line = fgetcsv($csvFile)) !== false) {
                    // Check if the row is blank or consists only of whitespace
                    if (empty(implode('', $line))) {
                        continue; // Skip blank lines
                    }

                    $request_id = $line[0];
                    $status = $line[1];
                    $carmaker = $line[2];
                    $carmodel = $line[3];
                    $product = $line[4];
                    $jigname = $line[5];
                    $drawing_no = $line[6];
                    $type = $line[7];
                    $qty = $line[8];
                    $purpose = $line[9];
                    $budget = $line[10];
                    $date_requested = $line[11];
                    $requested_by = $line[12];
                    $required_delivery_date = $line[13];
                    $remarks = $line[14];
                    $shipping_method = $line[15];

                    //rfq
                    $date_of_issuance_rfq = $line[16];
                    $rfq_no = $line[17];
                    $rfq_remarks = $line[18];
                    $target_date_reply_quotation = $line[19];
                    $item_code = $line[20];
                    $date_reply_quotation = $line[21];
                    $validity_quotation = $line[22];
                    $leadtime = $line[23];
                    $quotation_no = $line[24];
                    $unit_price_jpy = $line[25];
                    $unit_price_usd = $line[26];
                    $unit_price_php = $line[27];
                    $total_amount = $line[28];
                    $fsib_no = $line[29];
                    $fsib_code = $line[30];
                    $date_sent_to_internal_signatories = $line[31];
                    $target_approval_date_of_quotation = $line[32];
                    $rfq_status = $line[33];

                    // PO fields
                    $approval_date_of_quotation = $line[34];
                    $target_date_submission_to_purchasing = $line[35];
                    $actual_date_of_submission_to_purchasing = $line[36];
                    $target_po_date = $line[37];
                    $date_received_po_doc_purchasing = $line[38];
                    $date_issued_to_requestor = $line[39];
                    $issued_to = $line[40];
                    $date_returned_by_requestor = $line[41];
                    $po_date = $line[42];
                    $po_no = $line[43];
                    $supplier = $line[44];
                    $etd = $line[45];
                    $eta = $line[46];
                    $actual_arrival_date = $line[47];
                    $invoice_no = $line[48];
                    $remarks2 = $line[49];

                    // CHECK IF BLANK DATA
                    $date_adoq = str_replace('/', '-', $approval_date_of_quotation);
                    $approval_date_of_quotation = date("Y-m-d", strtotime($date_adoq));

                    $date_tdstp = str_replace('/', '-', $target_date_submission_to_purchasing);
                    $target_date_submission_to_purchasing = date("Y-m-d", strtotime($date_tdstp));

                    $date_adostp = str_replace('/', '-', $actual_date_of_submission_to_purchasing);
                    $actual_date_of_submission_to_purchasing = date("Y-m-d", strtotime($date_adostp));

                    $date_tpd = str_replace('/', '-', $target_po_date);
                    $target_po_date = date("Y-m-d", strtotime($date_tpd));

                    $date_pd = str_replace('/', '-', $po_date);
                    $po_date = date("Y-m-d", strtotime($date_pd));

                    if (!empty($actual_arrival_date)) {
                        $date_aad = str_replace('/', '-', $actual_arrival_date);
                        $actual_arrival_date = date("Y-m-d", strtotime($date_aad));
                    }

                    if (!empty($date_received_po_doc_purchasing)) {
                        $date_rpdp = str_replace('/', '-', $date_received_po_doc_purchasing);
                        $date_received_po_doc_purchasing = date("Y-m-d", strtotime($date_rpdp));
                    }

                    if (!empty($date_issued_to_requestor)) {
                        $date_itr = str_replace('/', '-', $date_issued_to_requestor);
                        $date_issued_to_requestor = date("Y-m-d", strtotime($date_itr));
                    }

                    if (!empty($etd)) {
                        $date_etd = str_replace('/', '-', $etd);
                        $etd = date("Y-m-d", strtotime($date_etd));
                    }

                    if (!empty($eta)) {
                        $date_eta = str_replace('/', '-', $eta);
                        $eta = date("Y-m-d", strtotime($date_eta));
                    }

                    if (!empty($date_returned_by_requestor)) {
                        $date_rbr = str_replace('/', '-', $date_returned_by_requestor);
                        $date_returned_by_requestor = date("Y-m-d", strtotime($date_rbr));
                    }

                    // CHECK DATA
                    $prevQuery = "SELECT joms_request.id, joms_po_process.request_id FROM joms_request 
                         LEFT JOIN joms_rfq_process ON joms_rfq_process.request_id = joms_request.request_id 
                         LEFT JOIN joms_po_process ON joms_po_process.request_id = joms_request.request_id 
                         WHERE joms_request.request_id = '$request_id' AND joms_request.status = 'open' AND joms_rfq_process.date_of_issuance_rfq != ''";

                    $res = $conn->prepare($prevQuery);
                    $res->execute();
                    if ($res->rowCount() > 0) {

                        // OPEN REQUEST

                        foreach ($res->fetchALL() as $row) {
                            $id = $row['id'];
                            $request_id_po = $row['request_id'];
                        }

                        if (!empty($request_id_po)) {

                            $po_uploaded_by = $_SESSION['fullname'];

                            // UPDATE OPEN REQUEST ON PO TABLE

                            $query = "UPDATE joms_po_process SET 
                               
                                approval_date_of_quotation = '$approval_date_of_quotation',
                                target_date_submission_to_purchasing = '$target_date_submission_to_purchasing',
                                actual_date_of_submission_to_purchasing = '$actual_date_of_submission_to_purchasing',
                                target_po_date = '$target_po_date',
                                date_received_po_doc_purchasing = '$date_received_po_doc_purchasing',
                                date_issued_to_requestor = '$date_issued_to_requestor',
                                issued_to = '$issued_to',
                                date_returned_by_requestor = '$date_returned_by_requestor',
                                po_date = '$po_date',
                                po_no = '$po_no',
                                -- ordering_additional_details = '$ordering_additional_details',
                                supplier = '$supplier',
                                etd = '$etd', 
                                eta = '$eta'";

                            if (!empty($actual_arrival_date)) {
                                $query = $query . ", actual_arrival_date = '$actual_arrival_date', invoice_no = '$invoice_no', remarks = '$remarks2'";
                            } else {
                                $query = $query . ", invoice_no = '$invoice_no', remarks = '$remarks2'";
                            }

                            $query = $query . ", po_uploaded_by = '$po_uploaded_by' WHERE request_id = '$request_id'";

                            $stmt = $conn->prepare($query);
                            if ($stmt->execute()) {

                                // UPDATE STATUS
                                if (!empty($actual_arrival_date)) {
                                    // $error = 0;
                                    $stmt = NULL;

                                    $query = "UPDATE joms_request SET status = 'closed' WHERE id = '$id'";
                                    $stmt = $conn->prepare($query);
                                    if ($stmt->execute()) {
                                        $error = 0;
                                    } else {
                                        $error = $error + 1;
                                    }
                                }
                            } else {
                                $error = $error + 1;
                            }
                        } else {

                            $po_uploaded_by = $_SESSION['fullname'];

                            // INSERT OPEN REQUEST TO PO TABLE

                            $insert = "INSERT INTO joms_po_process(
                                `request_id`, `approval_date_of_quotation`, `target_date_submission_to_purchasing`, 
                                `actual_date_of_submission_to_purchasing`, `target_po_date`, `date_received_po_doc_purchasing`, 
                                `date_issued_to_requestor`, `issued_to`, `date_returned_by_requestor`, `po_date`, `po_no`, `supplier`, `etd`, `eta`";

                            // Add conditional columns for non-empty optional dates
                            if (!empty($actual_arrival_date)) {
                                $insert .= ", `actual_arrival_date`, `invoice_no`, `remarks`";
                            } else {
                                $insert .= ", `invoice_no`, `remarks`";
                            }

                            $insert .= ", `po_uploaded_by`)";

                            if (!empty($actual_arrival_date)) {
                                $insert = $insert . " VALUES ('$request_id', '$approval_date_of_quotation', '$target_date_submission_to_purchasing', '$actual_date_of_submission_to_purchasing', '$target_po_date', '$date_received_po_doc_purchasing', '$date_issued_to_requestor', '$issued_to', '$date_returned_by_requestor', '$po_date', '$po_no',  '$supplier', '$etd', '$eta', '$actual_arrival_date', '$invoice_no', '$remarks2', '$po_uploaded_by')";
                            } else {
                                $insert = $insert . " VALUES ('$request_id', '$approval_date_of_quotation', '$target_date_submission_to_purchasing', '$actual_date_of_submission_to_purchasing', '$target_po_date', '$date_received_po_doc_purchasing', '$date_issued_to_requestor', '$issued_to', '$date_returned_by_requestor', '$po_date', '$po_no',  '$supplier', '$etd', '$eta', '$invoice_no', '$remarks2', '$po_uploaded_by')";
                            }

                            $stmt = $conn->prepare($insert);
                            if ($stmt->execute()) {

                                // UPDATE STATUS
                                if (!empty($actual_arrival_date)) {
                                    // $error = 0;
                                    $stmt = NULL;

                                    $query = "UPDATE joms_request SET status = 'closed' WHERE id = '$id'";
                                    $stmt = $conn->prepare($query);
                                    if ($stmt->execute()) {
                                        $error = 0;
                                    } else {
                                        $error = $error + 1;
                                    }
                                }
                            } else {
                                $error = $error + 1;
                            }
                        }

                    } else {
                    }
                }

                fclose($csvFile);
                if ($error == 0) {
                    echo '<script>
                        var x = confirm("SUCCESS!");
                        if(x == true){
                            location.replace("../../page/purchasing/set_rfq_po.php");
                        }else{
                            location.replace("../../page/purchasing/set_rfq_po.php");
                        }
                    </script>';
                } else {
                    echo '<script>
                    var x = confirm("WITH ERROR! # OF ERRORS ' . $error . '");
                    if(x == true){
                        location.replace("../../page/purchasing/set_rfq_po.php");
                    }else{
                        location.replace("../../page/purchasing/set_rfq_po.php");
                    }
                </script>';
                }
            } else {
                echo '<script>
                var x = confirm("' . $chkCsvMsg . '");
                            if(x == true){
                                location.replace("../../page/purchasing/set_rfq_po.php");
                            }else{
                                location.replace("../../page/purchasing/set_rfq_po.php");
                            }
                        </script>';
            }

        } else {
            echo '<script>
                        var x = confirm("CSV FILE NOT UPLOADED!");
                        if(x == true){
                            location.replace("../../page/purchasing/set_rfq_po.php");
                        }else{
                            location.replace("../../page/purchasing/set_rfq_po.php");
                        }
                    </script>';
        }
    } else {
        echo '<script>
                        var x = confirm("INVALID FILE FORMAT!");
                        if(x == true){
                            location.replace("../../page/purchasing/set_rfq_po.php");
                        }else{
                            location.replace("../../page/purchasing/set_rfq_po.php");
                        }
                    </script>';
    }
}

// KILL CONNECTION
$conn = null;
?>