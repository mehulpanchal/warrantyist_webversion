<?php
// Code for Edit warranty
//Code by Amruta as on 190315
?>
<!-- BEGIN SAMPLE FORM PORTLET-->

<div class="row">
    <form class="form-horizontal" role="form" ng-submit="proccesedit()" name="editWarranty" id="editWarranty">
        <div class="col-md-6 col-sm-12">
            <div class="portlet-body form">                                   
                <div class="form-body">
                    <div class="form-group">                    
                        <div class="col-md-9"> 
                            <select class="form-control" ng-model="frm.category" ng-options="cat.cat_id as cat.cat_name for cat in category" required>                               
                            </select>
                        </div>
                    </div>                                         
                    <div class="form-group">
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Product Name" ng-model="frm.product_name" name="product_name" ng-required="true" ng-disabled="true" />
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Warranty Provider Name" ng-model="frm.provider_name" name="provider_name" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <div class="input-group">                            
                                <input type="text" class="form-control input-inline input-medium" placeholder="User Name" ng-model="frm.user_name" name="user_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Manufacturer Name" ng-model="frm.manufacturer_name" name="manufacturer_name" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Support Phone Number" ng-model="frm.support_phone" name="support_phone_number" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="email" class="form-control input-inline input-medium" placeholder="Support Email Id" ng-model="frm.support_email" name="support_email"  ng-model="email.text" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Seller Name" ng-model="frm.seller_name" name="seller_name" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Model Number" ng-model="frm.model_number" name="model_number" required>
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Serial Number" ng-model="frm.serial_number" name="serial_number" required>
                        </div>
                    </div>                
                    <div class="form-group">

                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            
                            <p class="input-group">                               
                                <input type="text" class="form-control" datepicker-popup="{{ format }}" ng-model="frm.warranty_start_date" is-open="opened.openedStart" max-date="{{ frm.max_date}}" datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="Warranty start date"/>                                                              
                               
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>                   
                    </div>
                    <div class="form-group">

                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Duration in Months" ng-model="frm.warranty_duration" name="warranty_duration" required>
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Invoice Number" ng-model="frm.invoice_number" name="invoice_number" required>
                        </div>
                    </div>
                    <div class="form-group" ng-controller="DatepickerCtrl">                  
                          <div class="col-md-9">
<!--                            <input type="text" class="form-control input-inline input-medium" placeholder="Invoice Date" ng-model="frm.invoice_date" name="invoice_date" required>-->               
                            <p class="input-group">                               
                                <input type="text" class="form-control" datepicker-popup="{{ format }}" ng-model="frm.invoice_date" is-open="opened.openedEnd" max-date="{{ frm.max_date}}" datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="Invoice Date"/>                                                                                             
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedEnd')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                    </div>                                 
                </div>       
            </div>    
        </div>
        <div class="col-md-6 col-sm-12">   
            <div class="form-group">
                <label class="col-md-3 control-label">Upload Warranty Card</label>
                <div class="col-md-9">
                    <input type="file" nv-file-select="" uploader="uploader" filters="imageFilter"/>                                
                    <input type="hidden" ng-model="frm.warranty_card"  name="warrancty_card"  />               
                    <div class="alert alert-danger" ng-show="isError">
                            Please select jpg or png or gif.
                    </div>
                </div>
                <div ng-if="frm.warranty_card"><img src="{{ frm.warranty_card }}" width="150" height="120" /></div>
            </div>  
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Upload Purchase Invoice</label>
                <div class="col-md-9">
                    <input type="file" nv-file-select="" uploader="pur_uploader"/>    
                    <input type="hidden" ng-model="frm.purchase_invoice"  name="purchase_invoice"  />  
                    <div class="alert alert-danger" ng-show="isErrorpur">
			Please select jpg or png or gif.
                    </div>
                </div>
                <div ng-if="frm.purchase_invoice"><img src="{{ frm.purchase_invoice }}" height="120" width="150" /></div>
            </div>        
            <div class="form-group">
                <label class="col-md-3 control-label">Reminder</label>
                <div class="col-md-9">
                    <select class="form-control" ng-model="frm.reminder_time" name="reminder_time">
                        <option value="0" selected="selected">None</option>
                        <option value="1">On expiry day</option>
                        <option value="7">7 days prior to expiry</option>
                        <option value="15">15 days prior to expiry</option>
                        <option value="30">30 days prior to expiry</option>
                        <option value="90">3 Months prior to expiry</option>
                    </select>
                </div>
            </div>               
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                    <textarea class="form-control" rows="3" ng-model="frm.notedesc" name="notedesc">Add Note</textarea>
                </div>
            </div>
<!--            <div class="form-group">                    
                <div class="col-md-9">
                    <a ng-click="savewarranty_ser()" class="btn grey-cascade" ng-disabled="addWarranty.$invalid">Edit Service Schedule</a> 
                </div>
            </div>
            <div class="form-group">                    
                <div class="col-md-9">
                    <a ng-click="savewarranty_amc()" class="btn grey-cascade" ng-disabled="addWarranty.$invalid">Edit AMC</a> 
                </div>
            </div>               -->
            <div class="form-group">                    
                <div class="col-md-9">
                    <button type="submit" value="Submit" class="btn btn-info">Submit</button>
                </div>
            </div>
        </div>    
    </form>                    
</div>