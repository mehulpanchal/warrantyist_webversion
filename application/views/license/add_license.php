<!--Code for Upload warranties data through CSV files and save in to database's
    Code by mehul as on 10315
-->
<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="sub_row">
    <a class="pull-left back_left back_none">
        <img src="<?php echo base_url('assets/admin/layout/img/Back-icon.png'); ?>" />
    </a>

    <a class="pull-right close_right" ng-click="$modalCancel()">
        <img src="<?php echo base_url('assets/admin/layout/img/Close-Button-icon.png'); ?>" />
    </a>
</div>
<div class="portlet light" >

    <div class="portlet-body form" >

        <form class="form-horizontal" name="frm" role="form" ng-submit="proccesadd()">
            <div id="messages" class="alert alert-success" ng-show="message">{{ message}}</div>
            <div class="form-body">
                <!-- SHOW ERROR/SUCCESS MESSAGES -->
                <div class="warrenty-form-left">

                    <div class="form-group">
                        <!--                    <label class="col-md-3 control-label">Category</label>-->
                        <div class="col-md-9">
<!--                            <select class="form-control" ng-model="frm.category" ng-init="category" ng-options="cat.cat_id as cat.cat_name for cat in category" required>
                                <option value="">Category</option>
                            </select>-->
                            <select class="form-control" ng-model="formData.category" name="categoryid"  ng-options="cat.cat_id as cat.cat_name for cat in category" required>                               
                            </select>
                            <div class="custom-error" ng-show="frm.categoryid.$dirty && frm.categoryid.$invalid">
                                <span ng-show="frm.categoryid.$error.required">Select Category.</span>

                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : errorsoftwear_name }">
                        <!--                    <label class="col-md-3 control-label"></label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" name="softwear_name" 
                                   ng-model="formData.softwear_name" placeholder="License Description" ng-pattern="/^[A-Za-z0-9 -]+$/" required>
                            <div class="custom-error" ng-show="frm.softwear_name.$dirty && frm.softwear_name.$invalid">
                                <span ng-show="frm.softwear_name.$error.required">License Description is required.</span>
                                <span ng-show="frm.softwear_name.$error.pattern">No Special Character Allowed</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : errorsoftwear_version }">
                        <!--<label class="col-md-3 control-label"></label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="License Version" name="softwear_version" 
                                   ng-model="formData.softwear_version" required>
                            <div class="custom-error" ng-show="frm.softwear_version.$dirty && frm.softwear_version.$invalid">
                                <span ng-show="frm.softwear_version.$error.required">License Version is required.</span>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--                    <label class="col-md-3 control-label">Registered Email ID</label>-->
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" placeholder="Registered Email ID" name="registeremail" ng-model="formData.registeremail" required>
                            </div>
                            <div class="custom-error" ng-show="frm.registeremail.$dirty && frm.registeremail.$invalid">
                                <span ng-show="frm.registeremail.$error.required">Email ID required.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">No. of License</label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="No. of License" name="no_lincense" ng-model="formData.no_lincense" required>
                            <div class="custom-error" ng-show="frm.no_lincense.$dirty && frm.no_lincense.$invalid">
                                <span ng-show="frm.no_lincense.$error.required">License No. required.</span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">Duration in Months</label>-->
                        <div class="col-md-9">
                            <input type="number" class="form-control input-inline input-medium" placeholder="Duration in Months" name="validity_in_month" ng-model="formData.validity_in_month" required
                                   ng-pattern="/^[0-9]+$/"   />
                            <div class="custom-error" ng-show="frm.validity_in_month.$dirty && frm.validity_in_month.$invalid">
                                <span ng-show="frm.validity_in_month.$error.required">Duration in Months required.</span>
                                <span ng-show="frm.validity_in_month.$error.pattern">Only Numbers Allowed</span>
                            </div>



                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">Invoice Number</label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Invoice Number" name="invoice_number" ng-model="formData.invoice_number"  required
                                   ng-pattern="/^[A-Za-z0-9_-]+$/"   />
                            <div class="custom-error" ng-show="frm.invoice_number.$dirty && frm.invoice_number.$invalid">
                                <span ng-show="frm.invoice_number.$error.required">Invoice Number required.</span>
                                <span ng-show="frm.invoice_number.$error.pattern">No Special Character Allowed</span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            <p class="input-group">                               
                                <input type="text" class="form-control" datepicker-popup="{{ format}}" ng-model="formData.invoice_date" is-open="opened.openedStart" readonly="" is-open="opened" max-date="{{ frm.max_date}}" datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="Invoice Date"/>                                                                                             
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event, 'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>                   
                    </div>
                    <div class="form-group">
                        <!--                    <label class="col-md-3 control-label">Vendor Name</label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Vendor Name" name="vendor_name" ng-model="formData.vendor_name" required
                                   ng-pattern="/^[A-Za-z ]+$/"   />
                            <div class="custom-error" ng-show="frm.vendor_name.$dirty && frm.vendor_name.$invalid">
                                <span ng-show="frm.vendor_name.$error.required">Vendor Name required.</span>
                                <span ng-show="frm.vendor_name.$error.pattern">Numbers and Special Character not Allowed</span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">Purchase Amount</label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Purchase Amount" name="purchase_amt" ng-model="formData.purchase_amt" required
                                   ng-pattern="/^[0-9]+$/"   />
                            <div class="custom-error" ng-show="frm.purchase_amt.$dirty && frm.purchase_amt.$invalid">
                                <span ng-show="frm.purchase_amt.$error.required">Purchase Amount required.</span>
                                <span ng-show="frm.purchase_amt.$error.pattern">Alpha and Special Character not Allowed</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="warrenty-form-right">

                    <div class="form-group">
                        <!--<label for="exampleInputFile" class="col-md-3 control-label">Upload License Document</label>-->
                        <div class="col-md-9">

                            <span class="btn green fileinput-button">
                                <i class="fa fa-plus"></i>
                                <span>License Upload</span>
                                <input type="file" nv-file-select="" ng-model="formData.image_url" uploader="uploader" name="image_url" class="file-upload" required /><!--     Upload License Document-->
                            </span>

                            <div class="custom-error" ng-show="frm.image_url.$dirty && frm.image_url.$invalid">
                                <span ng-show="frm.image_url.$error.required">Image required.</span>

                            </div>


<!--<p>Queue length: {{ uploader.queue.length}}</p>-->

<!--                            <table class="table" id="upload-image" >
                                <thead>
                                    <tr>
                                        <th width="50%">Name</th>
                                        <th ng-show="uploader.isHTML5">Size</th>
                                        <th ng-show="uploader.isHTML5">Progress</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in uploader.queue">
                                        <td><strong>{{ item.file.name}}</strong></td>
                                        <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size / 1024 / 1024|number:2 }} MB</td>
                                        <td ng-show="uploader.isHTML5">
                                            <div class="progress" style="margin-bottom: 0;">
                                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
                                            <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
                                            <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
                                        </td>
                                        <td nowrap>
                                            <button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                                <span class="glyphicon glyphicon-upload"></span> Upload
                                            </button>
                                            <button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
                                                <span class="glyphicon glyphicon-ban-circle"></span> Cancel
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                                <span class="glyphicon glyphicon-trash"></span> Remove
                                            </button>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="progress" style="">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                            </div>
                            -->


                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-md-9">


                            <input type="checkbox" id="inlineCheckbox21" value="option1" placeholder="License Renewable?" name="is_renew" ng-model="formData.is_renew"> 
                            <label for="inlineCheckbox21">License Renewable?</label>

                            <input type="hidden" ng-model="formData.license_image"  name="license_image" value="{{ formData.license_image}}" />                               	



                        </div>

                    </div>
                    <div class="form-group">

                        <div class="col-md-9">
                            <select class="form-control" ng-model="formData.reminder" name="reminder">
                                <option value="0">None</option>
                                <option value="1">On expiry day</option>
                                <option value="7">7 days prior to expiry</option>
                                <option value="15">15 days prior to expiry</option>
                                <option value="30">30 days prior to expiry</option>
                                <option value="90">3 Months prior to expiry</option>
                            </select>
                            <!--                            <label class="col-md-3 control-label">Reminder</label>-->

                        </div>
                    </div>     
                    <div class="form-group">
                        <!--                    <label class="col-md-3 control-label">Add Note</label>-->
                        <div class="col-md-9">
                            <textarea class="form-control" rows="3" name="add_note" placeholder="Add Note" ng-model="formData.add_note" style="width: 254px;"></textarea>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block"  ng-disabled="
                        frm.softwear_name.$pristine || frm.softwear_name.$dirty && frm.softwear_name.$invalid ||
                                frm.softwear_version.$pristine || frm.softwear_version.$dirty && frm.softwear_version.$invalid ||
                                frm.registeremail.$pristine || frm.registeremail.$dirty && frm.registeremail.$invalid ||
                                frm.no_lincense.$pristine || frm.no_lincense.$dirty && frm.no_lincense.$invalid ||
                                frm.validity_in_month.$pristine || frm.validity_in_month.$dirty && frm.validity_in_month.$invalid ||
                                frm.invoice_number.$pristine || frm.invoice_number.$dirty && frm.invoice_number.$invalid ||
                                frm.invoice_date.$pristine || frm.invoice_date.$dirty && frm.invoice_date.$invalid ||
                                frm.vendor_name.$pristine || frm.vendor_name.$dirty && frm.vendor_name.$invalid ||
                                frm.purchase_amt.$pristine || frm.purchase_amt.$dirty && frm.purchase_amt.$invalid ||
                                frm.is_renew.$pristine || frm.is_renew.$dirty && frm.is_renew.$invalid ||
                                frm.reminder.$pristine || frm.reminder.$dirty && frm.reminder.$invalid ||
                                frm.reminder.$pristine || frm.reminder.$dirty && frm.reminder.$invalid

                            ">
                        <span class="glyphicon glyphicon-flash"></span> Submit!
                    </button>
                </div>
                <!--                {{ formData}}-->
        </form>

    </div>
</div>

<!-- END SAMPLE FORM PORTLET-->

