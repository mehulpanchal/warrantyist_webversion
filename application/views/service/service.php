<style>
    .Expired { background-color: red;}
    .Expiring {  background-color: #f7dc6f;}
    .Active { background-color: green}
     #servicedetails .modal-dialog  {width:60%;}
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
                                            <option value="product">Product</option>
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
                
             <!-- BEGIN WELLS PORTLET-->
                                        <div class="portlet light">
						<div class="portlet-body">
							<div class="caption bold">
                                                            Service Schedule
							</div>
<!--							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>-->
						</div>
						<div class="portlet-body">
                                                    <div>
                                                        <input type="checkbox" ng-model="selectedAll" ng-change="checkAll()" />
                                                        <button type="button" ng-click="deleteservice()">Delete</button>
                                                    </div>
                                                    <div class="well" ng-repeat="a in services | offset: currentPage1 * itemsPerPage1 |  limitTo: itemsPerPage1">
                                                        <div><input type="checkbox" ng-model="a.checked" ng-click="checkedvalues(a.service_id)" /></div> 
                                                        <hr class="{{ a.status | getStatus}}" style="height: 60px; width: 8px;">                                         
								<h4>{{ a.product_name }}</h4>
                                                                Provider : &nbsp; {{ a.provider_name }}<br>
                                                                <div ng-if="a.next_service_date">Next Service Date: {{ a.next_service_date | date:'dd, MMMM yyyy' }}<br> </div>
                                                                <div ng-if="!a.next_service_date">Service Expired on : {{ a.expiry_date | date:'dd, MMMM yyyy' }}<br> </div>
                                                                <button type="button" ng-click="serviceviewdetails(a.service_id)" class="btn default">View Details</button>
                                                    </div>							
						</div>
					</div>
              <div class="dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination">
                                        <li ng-class="prevPageDisabled1()" class="paginate_button">
                                            <a href ng-click="prevPage1()">« Prev</a>
                                        </li>
                                        <li ng-repeat="n in range1()" class="paginate_button"
                                            ng-class="{active: n == currentPage1}" ng-click="setPage1(n)">
                                            <a href="#">{{n + 1}}</a>
                                        </li>
                                        <li ng-class="nextPageDisabled1()" class="paginate_button">
                                            <a href ng-click="nextPage1()">Next »</a>
                                        </li>
                                    </ul>
                                </div>
					<!-- END WELLS PORTLET-->
            </div>				
            
        </div>
        <!-- END PORTLET-->       
    </div>	  
   