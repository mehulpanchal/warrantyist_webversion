<div class="row">
    <div class="col-md-12 portlet-title">                
               <p class="text-right"><button type="button" ng-click="editServiceView(frm.service_id)"  class="btn red">Edit</button></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light form-fit">	
            <div class="portlet-body form">
                <!-- BEGIN VIEW-->						                                                            
                <div>                                                            
                    <div>Product name {{ frm.product_name}}</div>
                    <div>model_no : {{ frm.model_no}}</div>
                    <div>serial_no : {{ frm.serial_no}}</div>
                    <div>Status : {{ frm.status | getStatus }}</div>
                    <div>Starts on  : {{ frm.sdates[0] | date:'dd, MMMM yyyy' }}</div>
                    <div>Valid Upto : {{ frm.sdates[frm.sdates.length-1] | date:'dd, MMMM yyyy' }}</div>
                    <div>Provider name : {{ frm.provider_name}}</div>
                    <div>Provider Address : {{ frm.provider_address}}</div>
                    <div>Provider Phone : {{ frm.provider_phon}}</div>
                    <div>Provider Email : {{ frm.provider_mail}}</div>                    
                    <div>Note: {{ frm.notes }}</div>
                </div>
                <!-- END VIEW-->
            </div>
        </div>
        <!-- END PORTLET-->
    </div> 
    <div class="col-md-6 col-sm-12">
        <div ng-repeat="img in frm.simages ">
            Image   : {{ img }} <img src="{{ img }}" width="120" height="120" />
        </div>
    </div>
</div>    
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div ng-repeat="dt in frm.sdates ">
            Service Date {{ $index + 1 }} : {{ dt | date:'dd, MMMM yyyy' }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 portlet-title">                
               <p class="text-left"><button type="button" ng-click="deleteservice(frm.service_id)"  class="btn red">Delete Service</button></p>
    </div>
</div>


<!--{"amc_id":"345","product_id":"305","product_name":"Iphone 6","catid":"5","userid":"82","amc_provider_name":"Apple","amc_provider_address":"Apple","amc_provider_phone":"1234567890","amc_provider_email":"support@apple.com","amc_start_date":"1994-02-07","duration":"24","reminder":"7","created_date":"0000-00-00 00:00:00","is_deleted":"0","notedesc":"Test"}-->