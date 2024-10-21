<div class="modal fade" id="add_single_item_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"> Add Single Item Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mt-2">
                <div class="row mb-4">
                    <div class="col-2">
                        <label style="font-weight: normal;">Car Maker</label>
                        <!-- <input type="text" class="form-control" id="req_car_maker"> -->
                        <select name="req_car_maker" id="req_car_maker" class="form-control">
                            <option value="" selected disabled>Select car maker</option>
                            <option value="ALL">ALL</option>
                            <option value="MAZDA">MAZDA</option>
                            <option value="DAIHATSU">DAIHATSU</option>
                            <option value="HONDA">HONDA</option>
                            <option value="TOYOTA">TOYOTA</option>
                            <option value="SUZUKI">SUZUKI</option>
                            <option value="NISSAN">NISSAN</option>
                            <option value="SUBARU">SUBARU</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <label style="font-weight: normal;">Car Model</label>
                        <input type="text" class="form-control" id="req_car_model">
                    </div>
                    <div class="col-2">
                        <label style="font-weight: normal;">Product</label>
                        <input type="text" class="form-control" id="req_product">
                    </div>
                    <div class="col-3">
                        <label style="font-weight: normal;">Jig Name</label>
                        <textarea class="form-control" rows="2" maxlength="100" id="req_jig_name"></textarea>
                    </div>
                    <div class="col-3">
                        <label style="font-weight: normal;">Drawing No.</label>
                        <textarea class="form-control" rows="2" maxlength="100" id="req_drawing_no"></textarea>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-3">
                        <label style="font-weight: normal;">Type</label>
                        <input type="text" class="form-control" id="req_type">
                    </div>
                    <div class="col-3">
                        <label style="font-weight: normal;">Quantity</label>
                        <input type="int" class="form-control" id="req_qty">
                    </div>
                    <div class="col-3">
                        <label style="font-weight: normal;">Purpose</label>
                        <input type="text" class="form-control" id="req_purpose">
                    </div>
                    <div class="col-3">
                        <label style="font-weight: normal;">Kigyo Budget</label>
                        <input type="text" class="form-control" id="req_kigyo_budget">
                    </div>

                </div>
                <div class="row mb-4">
                    <div class="col-3">
                        <label style="font-weight: normal;">Date Requested</label>
                        <input type="date" class="form-control" id="req_date_requested">
                    </div>
                    <div class="col-3">
                        <label style="font-weight: normal;">Requested by</label>
                        <input type="text" class="form-control" id="req_requested_by">
                    </div>
                    <div class="col-3">
                        <label style="font-weight: normal;">Required Delivery Date</label>
                        <input type="date" class="form-control" id="req_delivery_date">
                    </div>
                    <div class="col-3">
                        <label style="font-weight: normal;">Shipping Method</label>
                        <!-- <input type="text" class="form-control" id="req_shipping_method"> -->
                        <select name="req_shipping_method" id="req_shipping_method" class="form-control">
                            <option value="" selected disabled>Select shipping method</option>
                            <option value="AIR">AIR</option>
                            <option value="LAND">LAND</option>
                            <option value="SEA">SEA</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label style="font-weight: normal;">Order Destination</label>
                        <input type="text" class="form-control" id="req_remarks">
                    </div>
                </div>

                <!-- status, added by (AUTO) -->
            </div>
            <div class="modal-footer mt-3" style="background:#e9e9e9;">
                <div class="col-12">
                    <div class="float-left">
                        <button class="btn btn-block btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-block btn-primary" onclick="add_single_item_record()">Add Item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>