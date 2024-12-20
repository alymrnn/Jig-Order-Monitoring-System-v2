<script type="text/javascript">
    $(function () {
        let role = '<?= $_SESSION['role'] ?>';
        if (role == 'user') {
            $('#accounts_bar').hide();
        };

        $("#upload_request_btn").click(function () {
            $('#import_request').modal('hide');
            Swal.fire({
                icon: 'info',
                title: 'Please Wait!!',
                text: '',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
        });

        search_request();
        setInterval(search_request, 10000);

        // var currentDate = new Date().toISOString().split('T')[0];
        // $('#req_date_requested').val(currentDate);

        document.getElementById('req_date_requested').value = '<?= $server_date_only ?>';
    });

    const search_request = () => {
        $('#spinner').css('display', 'block');
        $.ajax({
            url: '../../process/requester/request.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'fetch_requested_processed',
            }, success: function (response) {
                document.getElementById('list_of_uploaded_request').innerHTML = response;
                $('#spinner').fadeOut();
                let count = $('#list_of_uploaded_request_table tbody tr').length;
                $('#count_view').html(count);
            }
        });
    }

    const add_single_item_record = () => {
        var car_maker = document.getElementById('req_car_maker').value;
        var car_model = document.getElementById('req_car_model').value;
        var product = document.getElementById('req_product').value;
        var jig_name = document.getElementById('req_jig_name').value;
        var drawing_no = document.getElementById('req_drawing_no').value;
        var type = document.getElementById('req_type').value;
        var quantity = document.getElementById('req_qty').value;
        var purpose = document.getElementById('req_purpose').value;
        var kigyo_budget = document.getElementById('req_kigyo_budget').value;
        var date_requested = document.getElementById('req_date_requested').value;
        var requested_by = document.getElementById('req_requested_by').value;
        var delivery_date = document.getElementById('req_delivery_date').value;
        var shipping_method = document.getElementById('req_shipping_method').value;
        var remarks = document.getElementById('req_remarks').value;

        let hasError = false;

        const highlightIfEmpty = (elementId, value) => {
            const element = document.getElementById(elementId);
            if (!value) {
                element.style.border = '1px solid red'; 
                hasError = true;
            } else {
                element.style.border = ''; 
            }

            element.addEventListener('input', function () {
                if (this.value) {
                    this.style.border = ''; 
                }
            });
        };

        highlightIfEmpty('req_car_maker', car_maker);
        highlightIfEmpty('req_car_model', car_model);
        highlightIfEmpty('req_product', product);
        highlightIfEmpty('req_jig_name', jig_name);
        highlightIfEmpty('req_drawing_no', drawing_no);
        highlightIfEmpty('req_type', type);
        highlightIfEmpty('req_qty', quantity);
        highlightIfEmpty('req_purpose', purpose);
        highlightIfEmpty('req_kigyo_budget', kigyo_budget);
        highlightIfEmpty('req_date_requested', date_requested);
        highlightIfEmpty('req_requested_by', requested_by);
        highlightIfEmpty('req_delivery_date', delivery_date);
        highlightIfEmpty('req_shipping_method', shipping_method);
        highlightIfEmpty('req_remarks', remarks);

        if (hasError) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'Please fill in the required fields.',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        $.ajax({
            url: '../../process/requester/request.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_single_item_record',
                car_maker: car_maker,
                car_model: car_model,
                product: product,
                jig_name: jig_name,
                drawing_no: drawing_no,
                type: type,
                quantity: quantity,
                purpose: purpose,
                kigyo_budget: kigyo_budget,
                date_requested: date_requested,
                requested_by: requested_by,
                delivery_date: delivery_date,
                shipping_method: shipping_method,
                remarks: remarks
            },
            success: function (response) {
                response = response.trim();

                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully Recorded',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#req_car_maker').val('');
                    $('#req_car_model').val('');
                    $('#req_product').val('');
                    $('#req_jig_name').val('');
                    $('#req_drawing_no').val('');
                    $('#req_type').val('');
                    $('#req_qty').val('');
                    $('#req_purpose').val('');
                    $('#req_kigyo_budget').val('');
                    $('#req_date_requested').val('');
                    $('#req_requested_by').val('');
                    $('#req_delivery_date').val('');
                    $('#req_shipping_method').val('');
                    $('#req_remarks').val('');

                    $('#add_single_item_record').modal('hide');

                    search_request();
                } else {
                    console.error("Unexpected response from the server:", response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    };

    // const add_single_item_record = () => {
    //     var car_maker = document.getElementById('req_car_maker').value;
    //     var car_model = document.getElementById('req_car_model').value;
    //     var product = document.getElementById('req_product').value;
    //     var jig_name = document.getElementById('req_jig_name').value;
    //     var drawing_no = document.getElementById('req_drawing_no').value;
    //     var type = document.getElementById('req_type').value;
    //     var quantity = document.getElementById('req_qty').value;
    //     var purpose = document.getElementById('req_purpose').value;
    //     var kigyo_budget = document.getElementById('req_kigyo_budget').value;
    //     var date_requested = document.getElementById('req_date_requested').value;
    //     var requested_by = document.getElementById('req_requested_by').value;
    //     var delivery_date = document.getElementById('req_delivery_date').value;
    //     var shipping_method = document.getElementById('req_shipping_method').value;
    //     var remarks = document.getElementById('req_remarks').value;

    //     if (!car_maker || !car_model || !product || !jig_name || !drawing_no || !type ||
    //         !quantity || !purpose || !kigyo_budget || !date_requested || !requested_by ||
    //         !delivery_date || !shipping_method || !remarks) {
    //         Swal.fire({
    //             icon: 'warning',
    //             title: 'Missing Information',
    //             showConfirmButton: false,
    //             timer: 1500
    //         });
    //         return;
    //     }

    //     $.ajax({
    //         url: '../../process/requester/request.php',
    //         type: 'POST',
    //         cache: false,
    //         data: {
    //             method: 'add_single_item_record',
    //             car_maker: car_maker,
    //             car_model: car_model,
    //             product: product,
    //             jig_name: jig_name,
    //             drawing_no: drawing_no,
    //             type: type,
    //             quantity: quantity,
    //             purpose: purpose,
    //             kigyo_budget: kigyo_budget,
    //             date_requested: date_requested,
    //             requested_by: requested_by,
    //             delivery_date: delivery_date,
    //             shipping_method: shipping_method,
    //             remarks: remarks
    //         },
    //         success: function (response) {
    //             response = response.trim();

    //             if (response == 'success') {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Successfully Recorded',
    //                     showConfirmButton: false,
    //                     timer: 1500
    //                 });

    //                 $('#req_car_maker').val('');
    //                 $('#req_car_model').val('');
    //                 $('#req_product').val('');
    //                 $('#req_jig_name').val('');
    //                 $('#req_drawing_no').val('');
    //                 $('#req_type').val('');
    //                 $('#req_qty').val('');
    //                 $('#req_purpose').val('');
    //                 $('#req_kigyo_budget').val('');
    //                 $('#req_date_requested').val('');
    //                 $('#req_requested_by').val('');
    //                 $('#req_delivery_date').val('');
    //                 $('#req_shipping_method').val('');
    //                 $('#req_remarks').val('');

    //                 $('#add_single_item_record').modal('hide');

    //                 search_request();

    //                 // setTimeout(function () {
    //                 //     location.reload();
    //                 // }, 500);
    //             }
    //             else {
    //                 console.error("Unexpected response from the server:", response);
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error',
    //                     text: 'Error',
    //                     showConfirmButton: false,
    //                     timer: 2000
    //                 });
    //             }
    //         }
    //     });
    // }


</script>