<?php
// Code for Edit warranty
//Code by Amruta as on 190315
?>
<!-- BEGIN SAMPLE FORM PORTLET-->

<div class="row">
    <form class="form-horizontal" role="form" ng-submit="editDoc()" name="editDocuments" id="editDocuments">
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
                            <input type="text" class="form-control input-inline input-medium" placeholder="Document Name" ng-model="frm.doc_name" name="doc_name" ng-required="true" />
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Document Number" ng-model="frm.doc_number" name="doc_no" required>
                        </div>
                    </div>
                                
                    <div class="form-group">

                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            
                            <p class="input-group">                               
                                <input type="text" class="form-control" datepicker-popup="{{ format }}" ng-model="frm.start_date" is-open="opened.openedStart" max-date="{{ frm.max_date}}" datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="start date"/>                                                              
                               
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>                   
                    </div>

                     <div class="form-group">

                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            
                            <p class="input-group">                               
                                <input type="text" class="form-control" datepicker-popup="{{ format }}" ng-model="frm.expiry_date" is-open="opened.openedStart" max-date="{{ frm.max_date}}" datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="expiry date"/>                                                              
                               
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>                   
                    </div>
                                                 
                </div>       
            </div>    
        </div>

        <div class="col-md-6 col-sm-12">   
            <div class="form-group">
                <label class="col-md-3 control-label">Upload Document</label>
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
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                    <textarea class="form-control" rows="3" ng-model="frm.notes" name="notedesc">Add Note</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Reminder</label>
                <div class="col-md-9">
                    <select class="form-control" ng-model="frm.reminder_time" name="reminder_time">
                        <option value="0">None</option>
                        <option value="1">On expiry day</option>
                        <option value="7">7 days prior to expiry</option>
                        <option value="15">15 days prior to expiry</option>
                        <option value="30">30 days prior to expiry</option>
                        <option value="90">3 Months prior to expiry</option>
                    </select>
                </div>
            </div> 
                       
            <div class="form-group">                    
                <div class="col-md-9">
                    <button type="submit" value="Submit" class="btn btn-info">Submit</button>
                </div>
            </div>
        </div>    
    </form>                    
</div>