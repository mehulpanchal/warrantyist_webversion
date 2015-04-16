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
        <form class="form-horizontal" name="frm" role="form" ng-submit="proccesedit()">
            <div id="messages" class="alert alert-success" ng-show="message">{{ message}}</div>
            <div class="form-body">
                <!-- SHOW ERROR/SUCCESS MESSAGES -->
                <div class="warrenty-form-left">

                    <div class="form-group">
                        <!--                    <label class="col-md-3 control-label">Category</label>-->
                        <div class="col-md-9"> 
                            
                            <select class="form-control" ng-model="formData.category" ng-init="category" name="categoryid" 
                                    ng-options="cat.cat_id as cat.cat_name for cat in category" required>
                            </select>
                            <div class="custom-error" ng-show="formData.categoryid.$dirty && formData.categoryid.$invalid">
                                <span ng-show="formData.categoryid.$erroformData.required">Select Category.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : errorsoftwear_name }">
                        <!--                    <label class="col-md-3 control-label"></label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" name="softwear_name" value="{{ formData.softwear_name}}" 
                                   ng-model="formData.softwear_name" placeholder="License Description" ng-pattern="/^[A-Za-z0-9]+$/" required>
                            <div class="custom-error" ng-show="formData.softwear_name.$dirty && formData.softwear_name.$invalid">
                                <span ng-show="formData.softwear_name.$erroformData.required">User id is required.</span>
                                <span ng-show="formData.softwear_name.$erroformData.pattern">No Special Character Allowed</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : errorsoftwear_version }">
                        <!--<label class="col-md-3 control-label"></label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="License Version" name="softwear_version"  value="{{ formData.softwear_version}}" 
                                   ng-model="formData.softwear_version" required>
                            <div class="custom-error" ng-show="formData.softwear_version.$dirty && formData.softwear_version.$invalid">
                                <span ng-show="formData.softwear_version.$erroformData.required">License Version is required.</span>

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
                                <input type="email" class="form-control" placeholder="Registered Email ID" name="registeremail" ng-model="formData.registeremail" required  value="{{ formData.registeremail}}" >
                            </div>
                            <div class="custom-error" ng-show="formData.registeremail.$dirty && formData.registeremail.$invalid">
                                <span ng-show="formData.registeremail.$erroformData.required">Email ID required.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">No. of License</label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="No. of License" name="no_lincense" ng-model="formData.no_lincense" required  value="{{ formData.no_lincense}}" >
                            <div class="custom-error" ng-show="formData.no_lincense.$dirty && formData.no_lincense.$invalid">
                                <span ng-show="formData.no_lincense.$erroformData.required">License No. required.</span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">Duration in Months</label>-->
                        <div class="col-md-9">
                            <input type="number" class="form-control input-inline input-medium" placeholder="Duration in Months" name="validity_in_month" ng-model="formData.validity_in_month" required  value="{{ formData.validity_in_month}}" 
                                   ng-pattern="/^[0-9]+$/"   />
                            <div class="custom-error" ng-show="formData.validity_in_month.$dirty && formData.validity_in_month.$invalid">
                                <span ng-show="formData.validity_in_month.$erroformData.required">Duration in Months required.</span>
                                <span ng-show="formData.validity_in_month.$erroformData.pattern">Only Numbers Allowed</span>
                            </div>



                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">Invoice Number</label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Invoice Number" name="invoice_number" ng-model="formData.invoice_number"  required  value="{{ formData.invoice_number}}" 
                                   ng-pattern="/^[A-Za-z0-9_-]+$/"   />
                            <div class="custom-error" ng-show="formData.invoice_numbeformData.$dirty && formData.invoice_numbeformData.$invalid">
                                <span ng-show="formData.invoice_numbeformData.$erroformData.required">Invoice Number required.</span>
                                <span ng-show="formData.invoice_numbeformData.$erroformData.pattern">No Special Character Allowed</span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            <p class="input-group">                               
                                <input type="text" class="form-control" datepicker-popup="{{format}}" value="{{ frm.invoice_date}}" ng-model="formData.invoice_date" is-open="opened.openedStart" readonly="" is-open="opened" max-date="{{ frm.max_date}}" datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="Invoice Date"/>                                                                                             
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                                </p>
                        </div>                   
                    </div>
                    <div class="form-group">
                        <!--                    <label class="col-md-3 control-label">Vendor Name</label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Vendor Name" name="vendor_name" ng-model="formData.vendor_name" required
                                   ng-pattern="/^[A-Za-z ]+$/"   value="{{ formData.vendor_name}}"   />
                            <div class="custom-error" ng-show="formData.vendor_name.$dirty && formData.vendor_name.$invalid">
                                <span ng-show="formData.vendor_name.$erroformData.required">Vendor Name required.</span>
                                <span ng-show="formData.vendor_name.$erroformData.pattern">Numbers and Special Character not Allowed</span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">Purchase Amount</label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Purchase Amount" name="purchase_amt" ng-model="formData.purchase_amt" required
                                   ng-pattern="/^[0-9]+$/"   value="{{ formData.purchase_amt}}"   />
                            <div class="custom-error" ng-show="formData.purchase_amt.$dirty && formData.purchase_amt.$invalid">
                                <span ng-show="formData.purchase_amt.$erroformData.required">Purchase Amount required.</span>
                                <span ng-show="formData.purchase_amt.$erroformData.pattern">Alpha and Special Character not Allowed</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="warrenty-form-right">

                    <div class="form-group">
                        <!--<label for="exampleInputFile" class="col-md-3 control-label">Upload License Document</label>-->
                        <div class="col-md-9">

                            <span class="fileinput-button">
                                <img src="{{formData.image_url}}" width="100px" height="100px" />
                                <br>
                                <span>Click Image to Edit License Copy</span>
                                <input type="file" nv-file-select=""  uploader="uploader" name="image_url" class="file-upload" /><!--     Upload License Document-->
                            </span>

                            <div class="custom-error" ng-show="formData.image_url.$dirty && formData.image_url.$invalid">
                                <span ng-show="formData.image_url.$erroformData.required">Image required.</span>

                            </div>


<!--<p>Queue length: {{ uploadeformData.queue.length}}</p>-->

<!--                            <table class="table" id="upload-image" >
                                <thead>
                                    <tr>
                                        <th width="50%">Name</th>
                                        <th ng-show="uploadeformData.isHTML5">Size</th>
                                        <th ng-show="uploadeformData.isHTML5">Progress</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in uploadeformData.queue">
                                        <td><strong>{{ item.file.name}}</strong></td>
                                        <td ng-show="uploadeformData.isHTML5" nowrap>{{ item.file.size / 1024 / 1024|number:2 }} MB</td>
                                        <td ng-show="uploadeformData.isHTML5">
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
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploadeformData.progress + '%' }"></div>
                            </div>
                            -->


                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-md-9">


                            <input type="checkbox" id="inlineCheckbox21" value="option1" placeholder="License Renewable?" name="is_renew" ng-model="formData.is_renew" ng-true-value="y" ng-false-value="n"> 
                            <label for="inlineCheckbox21" >License Renewable?</label>

                            <input type="hidden" ng-model="formData.license_image"  name="license_image" value="{{formData.image_url}}" />                               	



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
                            <textarea class="form-control" rows="3" name="notedesc" placeholder="Add Note"  ng-model="formData.notedesc" style="width: 254px;"> {{ formData.notedesc}} </textarea>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block"  ng-disabled="
                                    formData.softwear_name.$pristine || formData.softwear_name.$dirty && formData.softwear_name.$invalid ||
                                    formData.softwear_version.$pristine || formData.softwear_version.$dirty && formData.softwear_version.$invalid ||
                                    formData.registeremail.$pristine || formData.registeremail.$dirty && formData.registeremail.$invalid ||
                                    formData.no_lincense.$pristine || formData.no_lincense.$dirty && formData.no_lincense.$invalid ||
                                    formData.validity_in_month.$pristine || formData.validity_in_month.$dirty && formData.validity_in_month.$invalid ||
                                    formData.invoice_numbeformData.$pristine || formData.invoice_numbeformData.$dirty && formData.invoice_numbeformData.$invalid ||
                                    formData.invoice_date.$pristine || formData.invoice_date.$dirty && formData.invoice_date.$invalid ||
                                    formData.vendor_name.$pristine || formData.vendor_name.$dirty && formData.vendor_name.$invalid ||
                                    formData.purchase_amt.$pristine || formData.purchase_amt.$dirty && formData.purchase_amt.$invalid ||
                                    formData.is_renew.$pristine || formData.is_renew.$dirty && formData.is_renew.$invalid ||
                                    formData.remindeformData.$pristine || formData.remindeformData.$dirty && formData.remindeformData.$invalid

                            ">
                        <span class="glyphicon glyphicon-flash"></span> Edit!
                    </button>
                    <br>
                   
                </div>
                <!--                {{ formData}}-->
            </div>
        </form>    
    </div>
</div>

<!-- END SAMPLE FORM PORTLET-->

