<style>
    #productdetails .modal-dialog  {width:60%;}
    #addWarranty .modal-dialog { width: 60%;}
    #editWarranty .modal-dialog { width : 60%}
     .Expired { background-color: red;}
    .Expiring {  background-color: #f7dc6f;}
    .Active { background-color: green}
</style>
<div class="row">
    <div class="col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light tasks-widget">
            <div class="portlet-title">
                <div class="caption caption-md">						
                    <div class="portlet-body form">
                        <form class="form-horizontal" role="form">
                            <div class="form-body">					
                                <div class="form-group">                                    
                                    <div class="col-lg-6">
                                       <span class="caption-subject font-green-haze bold uppercase">Sort by</span>
                                        <select class="form-control" ng-model="sortval" ng-change="sortby(sortval)">
                                            <option value="service">Product</option>
                                            <option value="status">Status</option>                                            
                                            <option value="category">Category</option>
                                        </select>                                                                             
                                     </div>
                                    <div class="col-lg-6">
                                        <div class="input-icon right">
                                             <i class="icon-magnifier"></i>
                                             <input type="text" class="form-control form-control-solid" placeholder="Search...">
                                         </div>
                                    </div>
                                </div>                                
                            </div>								
                        </form>                       
                    </div>                                            
                </div>																	                                    	<div class="inputs">
                    <ul class="nav nav-pills tools">       
                        <li><a ng-click="addServiceView()" class="btn default">Add a Record </a></li>
                        <li class="dropdown">
                            <a href="javascript:;" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="myTabDrop1">
                                <li>
                                    <a href="#tab_2_3" tabindex="-1" data-toggle="tab">
                                        Export Services </a>
                                </li>
                                <li>
                                    <a href="#dashboard" tabindex="-1" data-toggle="tab">
                                        View Summary </a>
                                </li>									
                            </ul>
                        </li>
                    </ul>
                </div>            
                
            </div>
             <div class="inputs">
            <input type="checkbox" ng-model="selectedAll" ng-change="checkAll()" />
            <button type="button" ng-click="deleteservice()">Delete</button>
            </div>                     
            <!-- BEGIN Expired-->
<div class="portlet box red-intense" ng-if="serviceexpired != 'E'">
    <div class="portlet-title">
        <div class="caption">
            Expired
        </div>
    </div>
    <div class="portlet-body">                           
        <table class="table table-striped table-hover" id="sample_1">
            <tbody>
                <tr class="odd gradeX" ng-repeat="pr in serviceexpired">
                    <td>
                        <input type="checkbox" class="checkboxes" ng-model="pr.checked" ng-click="checkedvalues(pr.service_id)" value="1"/>
                    </td>                     
                    <td>
                        {{ pr.product_name}} 
                        <br />                       
                       Expired on {{ pr.service_expiry | date:'dd, MMMM yyyy' }}
                    </td>                    
                    <td class="center">
                    </td>
                    <td>
                        <a ng-click="serviceviewdetails(pr.service_id)" class="btn grey-cascade">View Details</a> 
                    </td>
                </tr>
            </tbody>                          								
        </table>
    </div>                                        
</div>                
<!-- END Expired-->
<!-- BEGIN Expiring-->
<div class="portlet box yellow-crusta" ng-if="serviceexpiring !== 'E'">
    <div class="portlet-title">
        <div class="caption">
            Expiring
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-hover" id="sample_1">
            <tbody>
                <tr class="odd gradeX" ng-repeat="pr in serviceexpiring">
                     <td>
                        <input type="checkbox" class="checkboxes" ng-model="pr.checked" ng-click="checkedvalues(pr.service_id)" value="1"/>
                    </td>                     
                    <td>
                        {{ pr.product_name}} 
                        <br />                       
                       Next Service Date: {{ pr.next_service_date | date:'dd, MMMM yyyy' }}
                    </td>                    
                    <td class="center">
                    </td>
                    <td>
                        <a ng-click="serviceviewdetails(pr.service_id)" class="btn grey-cascade">View Details</a> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>                                        
</div>
<!-- END Expiring-->                 
<!-- BEGIN Active-->
<div class="portlet box green-haze" ng-if="serviceactive != 'E'">
    <div class="portlet-title">
        <div class="caption">
            Active
        </div>
    </div>
    <div class="portlet-body">                         
        <table class="table table-striped table-hover" id="sample_1">
            <tbody>
                <tr class="odd gradeX" ng-repeat="pr in serviceactive">
                     <td>
                        <input type="checkbox" class="checkboxes" ng-model="pr.checked" ng-click="checkedvalues(pr.service_id)" value="1"/>
                    </td>                     
                    <td>
                        {{ pr.product_name}} 
                        <br />                                               
                       Next Service Date: {{ pr.next_service_date | date:'dd, MMMM yyyy' }}<br>
                    </td>                    
                    <td class="center">
                    </td>
                    <td>
                        <a ng-click="serviceviewdetails(pr.service_id)" class="btn grey-cascade">View Details</a> 
                    </td>
                </tr>
            </tbody>
        </table>                             
    </div>                                        
</div>               
<!-- END Active--> 
        </div>				
        </div>
        <!-- END PORTLET-->
    </div>	
</div>                                 