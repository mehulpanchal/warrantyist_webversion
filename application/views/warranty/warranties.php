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
                </div																		                                    	<div class="inputs">
                    <ul class="nav nav-pills tools">       
                        <li><a ng-click="addWarrantyView()" class="btn default">Add a Record </a></li>
                        <li class="dropdown">
                            <a href="javascript:;" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="myTabDrop1">
                                <li>
                                    <a href="#warranties_import" tabindex="-1" data-toggle="tab">
                                        Import Warranties </a>                                     
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>warranties/export_csv" tabindex="-1">
                                        Export Warranties </a>
                                </li>									
                            </ul>
                        </li>                        
                    </ul>
                </div>                                               
            </div>				
        </div>

        <!-- BEGIN WELLS PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption bold">
                    Warranties
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
                    <button type="button" ng-click="deletewarranties()">Delete</button>
                </div>
                <div class="well" ng-repeat="a in warranties| offset: currentPage1 * itemsPerPage1 |  limitTo: itemsPerPage1">                   
                    <div style="height: 110px; width: 20px; float: left;" class="{{ a.status | getStatus }}"></div>
                    <div><input type="checkbox" ng-model="a.checked" ng-click="checkedvalues(a.product_id)" /></div>                    
                    <h4>{{ a.product_name}}</h4>
                    Start Date: {{ a.warranty_start_date | date:'dd, MMMM yyyy' }}<br />
                    End Date: {{ a.warranty_expiry_date | date:'dd, MMMM yyyy' }}<br />
                    {{ a.seller_name}}<br />
                    {{ a.support_email}}<br />
                    Status: {{ a.status | getStatus }}<br />
                    <button type="button" ng-click="launchObjectModal(a.product_id)" class="btn default">View Details</button>
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
        </div>
        <!-- END WELLS PORTLET--> 
    </div>	 

    <!-- END Active-->                                  
