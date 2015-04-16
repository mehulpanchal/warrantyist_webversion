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
        <form class="form-horizontal" name="frm" role="form" ng-submit="proccesrenewaledit()">
            <div id="messages" class="alert alert-success" ng-show="message">{{message}}</div>
            <div class="form-body">
                <!-- SHOW ERROR/SUCCESS MESSAGES -->
                <div class="warrenty-form-left">

                    <div class="form-group" ng-class="{ 'has-error' : errorsupliername }">
                        <!--                    <label class="col-md-3 control-label"></label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" name="supliername_renewal"  
                                   ng-model="formData.supliername_renewal" placeholder="Supplier Name" ng-pattern="/^[A-Za-z0-9]+$/" required>
                            <div class="custom-error" ng-show="formData.supliername_renewal.$dirty && formData.supliername.$invalid">
                                <span ng-show="formData.supliername_renewal.$erroformData.required">Supplier Name is required.</span>
                                <span ng-show="formData.supliername_renewal.$erroformData.pattern">No Special Character Allowed</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : errorrenewalreceiptno }">
                        <!--                    <label class="col-md-3 control-label"></label>-->
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" name="renewalreceiptno_renewal"  
                                   ng-model="formData.renewalreceiptno_renewal" placeholder="Renewal Receipt Number" ng-pattern="/^[A-Za-z0-9]+$/" required>
                            <div class="custom-error" ng-show="formData.renewalreceiptno_renewal.$dirty && formData.renewalreceiptno.$invalid">
                                <span ng-show="formData.renewalreceiptno_renewal.$erroformData.required">Renewal Receipt Number is required.</span>
                                <span ng-show="formData.renewalreceiptno_renewal.$erroformData.pattern">No Special Character Allowed</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            <p class="input-group">                               
                                <input type="text" 
                                       class="form-control" name="renewal_purchase_date_renewal" 
                                       datepicker-popup="{{format}}" ng-model="formData.renewal_purchase_date_renewal" is-open="opened.openedStart" 
                                       readonly="" is-open="opened" max-date="{{ frm.max_date}}" 
                                       datepicker-options="dateOptions"  ng-required="true" date-disabled="disabled(date, mode)" close-text="Close" placeholder="Renewal Purchase Date"/>                                                                                             
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>                   
                    </div>
                    <div class="form-group">
                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            <p class="input-group">                               
                                <input type="text" class="form-control" name="start_date_renewal"
                                       datepicker-popup="{{format}}" ng-model="formData.start_date_renewal" is-open="opened.openedStart" 
                                       readonly="" is-open="opened" max-date="{{ frm.max_date}}" 
                                       datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="Start Date"/>                                                                                             
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>                   
                    </div>
                    
                    <div class="form-group">
                        <!--<label class="col-md-3 control-label">Invoice Number</label>-->
                        <div class="col-md-9">
                            <input type="number" class="form-control input-inline input-medium" placeholder="Duration in Month" name="validity_in_month_renewal" ng-model="formData.validity_in_month_renewal"  required  ng-pattern="/^[0-9]+$/"   />
                            <div class="custom-error"
                                 ng-show="formData.validity_in_month_renewal.$dirty && formData.validity_in_month_renewal.$invalid">
                                <span ng-show="formData.validity_in_month_renewal.$erroformData.required">Invoice Number required.</span>
                                <span ng-show="formData.validity_in_month_renewal.$erroformData.pattern">No Special Character Allowed</span>
                            </div>

                        </div>
                    </div>
                    
                </div>
                <div class="warrenty-form-right">

                    <div class="form-group">
                        <!--                    <label class="col-md-3 control-label">Add Note</label>-->
                        <div class="col-md-9">
                            <textarea class="form-control" rows="3" name="notedesc_renewal" placeholder="Add Note" ng-model="formData.notedesc_renewal"  style="width: 254px;"></textarea>

                        </div>
                    </div>
                    <input type="hidden" name="userid" ng-model="formData.userid" />
                    <input type="hidden" name="id" ng-model="formData.id" />
                    <button type="submit" class="btn btn-success btn-lg btn-block"  ng-disabled="
                                formData.supliername_renewal.$pristine || formData.supliername_renewal.$dirty && formData.supliername_renewal.$invalid ||
                                formData.renewalreceiptno_renewal.$pristine || formData.renewalreceiptno_renewal.$dirty && formData.renewalreceiptno_renewal.$invalid ||
                                formData.renewal_purchase_date_renewal.$pristine || formData.renewal_purchase_date_renewal.$dirty && formData.renewal_purchase_date_renewal.$invalid ||
                                formData.start_date_renewal.$pristine || formData.start_date_renewal.$dirty && formData.start_date_renewal.$invalid ||
                                formData.validity_in_month_renewal.$pristine || formData.validity_in_month_renewal.$dirty && formData.validity_in_month_renewal.$invalid

                            ">
                        <span class="glyphicon glyphicon-flash"></span> Edit!
                    </button>
                </div>
                <!--                {{ formData}}-->
            </div>
        </form>    
    </div>
</div>

<!-- END SAMPLE FORM PORTLET-->

