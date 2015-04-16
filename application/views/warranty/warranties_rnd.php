<style>
    #productdetails .modal-dialog  {width:60%;}
    #addWarranty .modal-dialog { width: 60%;}
    #editWarranty .modal-dialog { width : 60%}
    .Expired { background-color: red;}
    .Expiring {  background-color: #f7dc6f;}
    .Active { background-color: green}
</style>

   <div class="row">
      
       <div class="col-md-9" ng-controller="DatepickerCtrl">
                            
                            <p class="input-group">                               
                                <input type="text" class="form-control" datepicker-popup="{{ format }}" ng-model="frm.dt" is-open="opened.openedStart" max-date="{{ frm.max_date}}" datepicker-options="dateOptions"  ng-required="true" close-text="Close" placeholder="Warranty start date"/>                                                                                             
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event,'openedStart')"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                            <p>
                                
                                 
                            </p>
                        </div> 
       
       
       
   </div>             
<!-- END Active-->                                  
