<div class="row">
    <div class="col-md-12 portlet-title">                
               <p class="text-right"><button type="button" ng-click="editAmcView(amcdetails.amc_id)"  class="btn red">Edit</button></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light form-fit">	
            <div class="portlet-body form">
                <!-- BEGIN VIEW-->						                                                            
                <div>                                                            
                    <div>{{ amcdetails.product_name}}</div>
                    <div>Provider name : {{ amcdetails.amc_provider_name}}</div>
                    <div>Provider Address : {{ amcdetails.amc_provider_address}}</div>
                    <div>Provider Phone : {{ amcdetails.amc_provider_phone}}</div>
                    <div>Provider Email : {{ amcdetails.amc_provider_email}}</div>
                    <div>Start Date : {{ amcdetails.amc_start_date}}</div>
<!--                    <div>Manufacturer Name : {{ amcdetails.manufacturer_name}}</div>-->
<!--                    <div ng-if="amcdetails.warranty_card">Warranty Card <div ng-if="amcdetails.warranty_card"><img src="{{ amcdetails.warranty_card }}" width="150" height="120" /></div></div>                 
                    <div ng-if="amcdetails.purchase_invoice">Purchase Invoice  <div ng-if="amcdetails.purchase_invoice"><img src="{{ amcdetails.purchase_invoice }}" height="120" width="150" /></div></div>-->
                    <div>Note: {{ amcdetails.notedesc }}</div>
                </div>
                <!-- END VIEW-->
            </div>
        </div>
        <!-- END PORTLET-->
    </div>   
</div>      
<div class="row">
    <div class="col-md-12 portlet-title">                
               <p class="text-left"><button type="button" ng-click="deleteamc(amcdetails.amc_id)"  class="btn red">Delete Amc</button></p>
    </div>
</div>


<!--{"amc_id":"345","product_id":"305","product_name":"Iphone 6","catid":"5","userid":"82","amc_provider_name":"Apple","amc_provider_address":"Apple","amc_provider_phone":"1234567890","amc_provider_email":"support@apple.com","amc_start_date":"1994-02-07","duration":"24","reminder":"7","created_date":"0000-00-00 00:00:00","is_deleted":"0","notedesc":"Test"}-->