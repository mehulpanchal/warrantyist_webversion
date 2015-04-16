
<div class="row">
    <form class="form-horizontal" role="form" ng-submit="procceseditservice()" name="editService" id="editService">
        <div class="col-md-6 col-sm-12">
            <div class="portlet-body form">                                   
                <div class="form-body">
                    <div class="form-group">                    
                        <div class="col-md-9"> 
                            <select class="form-control" ng-model="frm.category" ng-options="cat.cat_id as cat.cat_name for cat in category" required>
                                <option value="">Category</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Product Name" ng-model="frm.product_name" name="product_name" ng-="true"required ng-disabled="frm.product_id" />
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Model Number" ng-model="frm.model_no" name="model_no" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Serial Number" ng-model="frm.serial_no" name="serial_no" required>
                        </div>
                    </div> 
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Provider Name" ng-model="frm.provider_name" name="provider_name" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <div class="input-group">                            
                                <input type="text" class="form-control input-inline input-medium" placeholder="Provider Address" ng-model="frm.provider_address" name="provider_address" required>
                            </div>
                        </div>
                    </div>                   
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="text" class="form-control input-inline input-medium" placeholder="Provider Phone Number" ng-model="frm.provider_phon" name="provider_phon" required>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-md-9">
                            <input type="email" class="form-control input-inline input-medium" placeholder="Provider Email Id" ng-model="frm.provider_mail" name="provider_mail" required>
                        </div>
                    </div>                               
                    <div class="form-group">
                        <div class="col-md-9" ng-controller="DatepickerCtrl">
                            <p class="input-group" ng-repeat="(key,frm) in frm.old_items" ng-model="frm.old_items">                             
                                <input type="text"  placeholder="Start date" ng-model="frm" value="{{ frm | date:'MMM d, y' }}" ng-disabled="true"/>
                                    <button type="button" class="btn grey" ng-click="removeDate(key)">
                                        <i class="fa fa-times"></i>
                                    </button>
                            </p>                             
                            <p class="input-group" ng-repeat="frm in frm.items" ng-model="frm.items">                             
                                    <input type="text"  is-open="date_open"  ng-focus="date_open = true" datepicker-popup="{{ format}}"  ng-model="frm.start_date"  class="form-control" ng-="true" close-text="Close" placeholder="Start date" ng-model="frm.start_date" datepicker-options="dateOptions" />
                                    <button type="button" class="btn grey" ng-click="removeItem($index)">
                                        <i class="fa fa-times"></i>
                                    </button>
                            </p>                                                         
                            <button type="button" class="btn grey" ng-click="addItem()">
                                Add another service date
                            </button>                                                                                  	
                        </div>                   
                    </div>
<!--                    <div class="form-group">
                        <div class="col-md-9">
                        <input type="number" class="form-control input-inline input-medium" placeholder="Duration in Months" ng-model="frm.duration" name="duration" >
                        </div>
                    </div>-->
                </div>       
            </div>    
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Upload Image</label>
                <div class="col-md-9">
                    <input type="file" nv-file-select="" uploader="uploader" filters="imageFilter" multiple/>                                
                    <input type="hidden"  name="service_image" ng-model="frm.service_image"  />               
                    <div>
                            Can select Multiple files 
                    </div>
                    <div class="alert alert-danger" ng-show="isError">
                            Please select jpg or png or gif.
                    </div>
                </div>
<!--                            <button type="button" class="btn btn-icon-only grey" ng-click="addInputFile()">
                                <i class="fa fa-plus"></i>
                            </button>      -->
            </div>  
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
                    <textarea class="form-control" rows="3" ng-model="frm.notes" name="notes"></textarea>
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