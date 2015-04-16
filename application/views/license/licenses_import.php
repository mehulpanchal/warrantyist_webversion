<script type="text/javascript" src="<?php echo base_url('assets/js/import/ajaxupload.js') ?>"></script>
<script src="<?php echo base_url('assets/js/import/update_event.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/import/update_class.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/import/common.js') ?>" type="text/javascript"></script>
<script type="text/javascript">

    jQuery(document).ready(function ($) {

        var button = $('#uploadbanner'), interval;

        new AjaxUpload(button, {
            action: '<?php echo base_url() . 'licenses/csv_file_upload'; ?>',
            onSubmit: function (file, ext)
            {
                button.text('Uploading');
                this.disable();
                interval = window.setInterval(function () {
                    var text = button.text();
                    if (text.length < 13)
                    {
                        button.text(text + '.');
                    }
                    else
                    {
                        button.text('Uploading');
                    }
                }, 200);
            },
            onComplete: function (file, response) {
                button.text('Upload File');
                window.clearInterval(interval);
                var resp_arr = response.split('#@#');
                this.enable();
                if (resp_arr[0] != "error")
                {
                    $("#current_imagebanner").append('<div class="row"><div class="col-md-12"><input type="checkbox" value="' + resp_arr[2] + '" name="student_check" id="stud_' + resp_arr[2] + '">&nbsp;&nbsp;<a href="' + resp_arr[1] + '" target="_blank">' + resp_arr[0] + '</a></div></div>');
                }
                else
                {
                    alert(resp_arr[1]);
                }
            }
        });
    });

    function check_matching()
    {
        var c = $("#current_imagebanner input:checkbox:checked").map(function () {
            return $(this).val()
        }).get();
        if (escape(c) == '')
        {
            alert("Please select atleast one file");
        }
        else
        {
            $('#responsive').show();
            $('#responsive').addClass("modal fade in");
            $('#FilesI').val(c);
        }
    }

    function done_it()
    {
        var categoryid = $('#categoryid').val();
        var softwear_name = $('#softwear_name').val();
        var softwear_version = $('#softwear_version').val();
        var registeremail = $('#registeremail').val();
        var no_lincense = $('#no_lincense').val();
        var validity_in_month = $('#validity_in_month').val();
        var invoice_number = $('#invoice_number').val();
        var invoice_date = $('#invoice_date').val();
        var vendor_name = $('#vendor_name').val();
        var purchase_amt = $('#purchase_amt').val();
        var is_renew = $('#is_renew').val();
        var reminder = $('#reminder').val();
        var add_note = $('#add_note').val();
        var FilesI = $('#FilesI').val();

        SendData = "categoryid=" + categoryid + "&softwear_name=" + softwear_name + "&softwear_version=" + softwear_version + "&registeremail=" + registeremail +
                "&no_lincense=" + no_lincense + "&validity_in_month=" + validity_in_month + "&invoice_number=" + invoice_number +
                "&invoice_date=" + invoice_date + "&vendor_name=" + vendor_name + "&purchase_amt=" + purchase_amt + "&is_renew=" + is_renew +
                "&reminder=" + reminder + "&add_note=" + add_note + "&FilesI=" + FilesI;

        $.ajax({
            url: '<?php echo base_url() . 'licenses/add_csv_file'; ?>',
            type: "POST",
            data: SendData,
            dataType: "json",
            success: function (d) {
                $("#msg_txt_file").show();
                $("#msg_txt_file").html("Licenses added successfully");
                setTimeout("$('#msg_txt_file').hide()", 10000);
                setTimeout("$('#msg_txt_file').html('')", 10000);
                hide_popup(1);
            }
        })
    }

    function hide_popup(val)
    {
        if (val == 1)
        {
            $('#responsive').hide();
            $('#responsive').addClass("modal fade");

            $("#categoryid").val('');
            $("#softwear_name").val('');
            $("#softwear_version").val('');
            $("#registeremail").val('');
            $("#no_lincense").val('');
            $("#validity_in_month").val('');
            $("#invoice_number").val('');
            $("#invoice_date").val('');
            $("#vendor_name").val('');
            $("#purchase_amt").val('');
            $("#is_renew").val('');
            $("#add_note").val('');
            $("#FilesI").val('');
        }
    }
</script>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <div class="container">

            <!-- BEGIN PAGE TOOLBAR -->

            <!-- END PAGE TOOLBAR -->
        </div>
    </div>
    <!-- END PAGE HEAD -->
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE BREADCRUMB -->
<!--            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="#dashboard">Home</a><i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#licenses">Licenses</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li class="active">
                    Import Licenses
                </li>
            </ul>-->
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs font-green-sharp"></i>
                            <span class="caption-subject font-green-sharp bold uppercase">Import Licenses </span>
                        </div>
                    </div>
                    <br>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="note note-danger">
                                <p>
                                    CSV File Upload widget.
                                </p>
                            </div>
                            <div class="downloadcsv-class"><a class="btn green" href="javascript:;">Download CSV Sample File</a></div>
                            
<!--                            <div class="tab-content">-->
<!--                                <div class="tab-pane active" id="tab_6_1">-->
                                    <div class="upload-button">
                                        <div id="csv_upload" style="display:noe;">
                                            <div class="">

                                                <input type="hidden" name="imagebanner" value=""/>
                                                <div class="parent_current_image"></div>
                                                <div id="uploadsbanner" class="uploadsbanner">
                                                    <div id="uploadbanner" class="btn blue">Upload CSV File</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="csv_upload_files" class="row" style="padding-top:10px;display:non;">
                                        <div class="col-md-12 alert alert-success" style="display:none;" id="msg_txt_file"></div>

                                        <div class="col-md-12" style="margin-bottom:20px;"><b>Uploaded Files</b></div>	
                                        <div class="col-md-12">
                                            <div id="parent_current_imagebanner">
                                                <div id="current_imagebanner">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top:20px;"><a href="javascript:void(0);" onclick="check_matching();" class="btn blue">Use Selected Files</a></div>
                                    </div>
<!--                                </div>-->
                                <div class="tab-pane fade" id="tab_6_2">
                                    <div id="list_table_header"></div>
                                    <div id="list_table"></div>
                                    <div id="details_table" style="display:none;"></div>
                                </div>
<!--                            </div>-->
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->
    <!-- END PAGE CONTENT-->
</div>
<!-- END PAGE CONTAINER-->
</div>
<!-- BEGIN CONTENT -->
</div>


<!-- /.modal -->
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="hide_popup(1);"></button>
                <h4 class="modal-title">Field Matching</h4>
            </div>
            <div class="modal-body">
                <div class="scroller" style="height:400px" data-always-visible="1" data-rail-visible1="1">
                    <div class="row">
                        <p class="col-md-3">Category</p>
                        <p class="col-md-7">
                            <select name="categoryid" id="categoryid">
                                <!--<option>None</option>-->
                                <?php
                                foreach ($categories as $key)
                                    echo '<option value="' . base64_encode($key["cat_id"]) . '">' . $key["cat_name"] . '</option>';
                                ?>
                            </select>
                        </p>
                    </div>
                    <input type="hidden" name="FilesI" id="FilesI" value="">
                    <div class="row">
                        <p class="col-md-3">License Description</p>
                        <p class="col-md-7">
                            <select name="softwear_name" id="softwear_name" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                        </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">License Version</p>
                        <p class="col-md-7">
                            <select name="softwear_version" id="softwear_version" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                        </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">Registered Email ID</p>
                        <p class="col-md-7">
                            <select name="registeremail" id="registeremail" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                        </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">No. of License</p>
                        <p class="col-md-7">
                            <select name="no_lincense" id="no_lincense" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                        </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">Duration in Months</p>
                         <p class="col-md-7">
                            <select name="validity_in_month" id="validity_in_month" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                         </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">Invoice Number</p>
                         <p class="col-md-7">
                            <select name="invoice_number" id="invoice_number" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                         </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">Invoice Date</p>
                         <p class="col-md-7">
                            <select name="invoice_date" id="invoice_date" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                         </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">Vendor Name</p>
                         <p class="col-md-7">
                            <select name="vendor_name" id="vendor_name" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                         </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">Purchase Amount</p>
                         <p class="col-md-7">
                            <select name="purchase_amt" id="purchase_amt" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                         </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">License Renewable?</p>
                         <p class="col-md-7">
                            <select name="is_renew" id="is_renew" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                         </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">Reminder</p>
                         <p class="col-md-7">
                            <select name="reminder" id="reminder" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>

                            </select>
                         </p>
                    </div>
                    <div class="row">
                        <p class="col-md-3">Add Note</p>
                         <p class="col-md-7">
                            <select name="add_note" id="add_note" class="form-control">
                                <option value="">Select Matching Field from Uploaded File</option>
                                <option value="0">Field 1</option>
                                <option value="1">Field 2</option>
                                <option value="2">Field 3</option>
                                <option value="3">Field 4</option>
                                <option value="4">Field 5</option>
                                <option value="5">Field 6</option>
                                <option value="6">Field 7</option>
                                <option value="7">Field 8</option>
                                <option value="8">Field 9</option>
                                <option value="9">Field 10</option>
                                <option value="10">Field 11</option>
                                <option value="11">Field 12</option>
  
                            </select>
                         </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding:8px 20px 5px;">
                <button type="button" data-dismiss="modal" class="btn default" onclick="hide_popup(1);">Close</button>
                <button type="button" class="btn green" onclick="done_it();">Done</button>
            </div>
        </div>
    </div>
</div>
