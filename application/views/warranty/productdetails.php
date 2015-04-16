<div class="row">
    <div class="col-md-12 portlet-title">                
               <p class="text-right"><button type="button" ng-click="editWarrantyView(product.product_id)"  class="btn red">Edit</button></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light form-fit">	
            <div class="portlet-body form">
                <!-- BEGIN VIEW-->						                                                            
                                                                  
                    <div>{{ product.product_name}}</div>
                    <div>Model number{{ product.model_number}}</div>
                    <div>Serial Number{{ product.serial_number}}</div>
                    <div>Support email{{ product.support_email}}</div>
                    <div>Support phone{{ product.support_phone}}</div>
                    <div>Seller name{{ product.seller_name}}</div>
                    <div>Manufacturer Name{{ product.manufacturer_name}}</div>
                    <div ng-if="product.warranty_card">Warranty Card <div ng-if="product.warranty_card"><img src="{{ product.warranty_card }}" width="150" height="120" /></div></div>                 
                    <div ng-if="product.purchase_invoice">Purchase Invoice  <div ng-if="product.purchase_invoice"><img src="{{ product.purchase_invoice }}" height="120" width="150" /></div></div>
                    <div>Note: {{ product.desc }}</div>
              
                <!-- END VIEW-->
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
    <div class="col-md-6 col-sm-12">
        <div ng-if="services!==''">
            <!-- BEGIN PORTLET-->
            <div class="portlet light form-fit">	
                <div class="portlet-body form">
                    <!-- BEGIN VIEW-->	
                    <div class="caption-subject theme-font bold uppercase">Service schedule </div>                    
                        <div>{{ services.product_name}}</div>
                        <div>Status : {{ services.product_name}}</div>
                        <div>Provider Name :  {{ services.provider_name}}</div>
                        <div>Provider Phone : {{ services.provider_phone}}</div>
                        <div>Starts : {{services.warranty_start_date}}</div>
                        <div>Valid Upto :  {{ services.extended_expiry}}</div>
                        <div>Email  : {{ services.provider_email}}</div>                                                                                
                    <!-- END VIEW-->
                </div>
            </div>
            <!-- END PORTLET-->
            <div class="col-md-9">
                    <a ng-click="editservice(product.product_id)" class="btn grey-cascade">Edit Service Schedule</a> 
                </div>
        </div>
        <div ng-if="amc!==''">
            <!-- BEGIN PORTLET-->
            <div class="portlet light form-fit" >	
                <div class="portlet-body form">
                    <!-- BEGIN VIEW-->						 
                        <div class="caption-subject theme-font bold uppercase">AMC's Details</div>                  
                        <div>{{ amc.product_name}}</div>
                        <div>Status : {{ amc.product_name}}</div>
                        <div>Provider Name :  {{ amc.amc_provider_name}}</div>
                        <div>Provider Phone : {{ amc.amc_provider_phone}}</div>
                        <div>Provider Address : {{ amc.amc_provider_address }}</div>
                        <div>Starts : {{ amc.amc_start_date}}</div>
                        <div>Valid Upto :  {{ amc.amc_expiry}}</div>
                        <div>Email  : {{ amc.amc_provider_email}}</div>                        
                    <!-- END VIEW-->
                </div>
            </div>            
            <!-- END PORTLET-->
                <div class="col-md-9">
                    <a ng-click="editamc(product.product_id)" class="btn grey-cascade">Edit AMC</a> 
                </div>
        </div>       
            <div class="form-group" ng-if="services ===''">                    
                <div class="col-md-9">
                    <a ng-click="openservice(product.product_id)" class="btn grey-cascade">Add Service Schedule</a> 
                </div>
            </div>
            <div class="form-group" ng-if="amc ===''">                    
                <div class="col-md-9">
                    <a ng-click="openamc(product.product_id)" class="btn grey-cascade">Add AMC</a> 
                </div>
            </div>     
    </div>
</div>      
<div class="row">
    <div class="col-md-12 portlet-title">                
               <p class="text-left"><button type="button" ng-click="proccesdelete(product.product_id)"  class="btn red">Delete Product</button></p>
    </div>
</div>

