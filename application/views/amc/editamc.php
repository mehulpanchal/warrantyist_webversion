
<div class="row">
    <form class="form-horizontal" role="form" ng-submit="editamcsave()" name="editAmc" id="editAmc">
        <div class="col-md-6 col-sm-12">
            <div class="portlet-body form">                                   
                <div class="form-body">
                    <div class="form-group">                    
                        <div class="col-md-9"> 
                          <select class="form-control" ng-model="frm.catid" ng-init="catid" ng-options="cat.cat_id as cat.cat_name for cat in category" required>                    
                              <option value="" ng-selected="selected">{{ frm.cat_name }}</option>                                                  
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Product Name" ng-model="frm.product_name" name="product_name" ng-required="true" />
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Amc Provider Name" ng-model="frm.amc_provider_name" name="amc_provider_name" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <div class="input-group">                            
                                <input type="text" class="form-control input-inline input-medium" placeholder="Provider Address" ng-model="frm.amc_provider_address" name="amc_provider_address" required>
                            </div>
                        </div>
                    </div>                   
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Provider Phone Number" ng-model="frm.amc_provider_phone" name="amc_provider_phone" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="email" class="form-control input-inline input-medium" placeholder="Provider Email Id" ng-model="frm.amc_provider_email" name="amc_provider_email"  ng-model="email.text" required>
                        </div>
                    </div>                               
                    <div class="form-group">

                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            
                            <p class="input-group">                               
                                <input type="text" class="form-control" datepicker-popup="{{ format }}" ng-model="frm.amc_start_date" is-open="opened.openedStart" max-date="{{ frm.max_date}}" datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="Amc start date"/>                                                                                             
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                            
                        </div>                   
                    </div>
                    <div class="form-group">

                        <div class="col-md-9">
                        <input type="text" class="form-control input-inline input-medium" placeholder="Duration in Months" ng-model="frm.duration" name="duration" required>
                        </div>
                    </div>
                </div>       
            </div>    
        </div>
        <div class="col-md-6 col-sm-12">                    
            <div class="form-group">
                <label class="col-md-3 control-label">Reminder</label>
                <div class="col-md-9">
                    <select class="form-control" ng-model="frm.reminder" name="reminder">
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
                <label class="col-md-3 control-label">Note</label>
                <div class="col-md-9">
                    <textarea class="form-control" rows="3" ng-model="frm.notedesc" name="notedesc"></textarea>
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
