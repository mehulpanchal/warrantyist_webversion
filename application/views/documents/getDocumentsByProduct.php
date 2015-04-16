<style>
    /*#productdetails .modal-dialog  {width:60%;}
    #addWarranty .modal-dialog { width: 60%;}
    #editWarranty .modal-dialog { width : 60%}*/


    .Expired { background-color: red;}
    .Expiring {  background-color: #f7dc6f;}
    .Active { background-color: green}
    /*#amcdetails .modal-dialog  {width:60%;}*/
 
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
                                        <div class="col-md-9">
                                            <select
                                                ng-model="selected"
                                                ng-options="item.label for item in sortitems"
                                                ng-click="gotoSelected()"
                                                ></select>
                                           <!--  <button ng-click="gotoSelected()">Go</button> -->
<!--                                            <pre>{{selected | json}}</pre>-->
                                        </div>                                                                           
                                     </div>
                                    <div class="col-lg-6">
                                        <div class="input-icon right">
                                             <i class="icon-magnifier"></i>
                                             <input type="text" class="form-control form-control-solid" ng-model="search" placeholder="Search...">
                                         </div>
                                    </div>
                                </div>                                
                            </div>								
                        </form>                       
                    </div>                                            
                </div																		                                    	<div class="inputs">
                    <ul class="nav nav-pills tools">       
                        <li><a ng-click="addDocumentView()" class="btn default">Add Record </a></li> 
                        
                        <li>
                         <a class="btn default yellow-stripe" href="#" data-toggle="dropdown">
                            <i class="fa fa-share"></i>
                            <span class="hidden-480">
                                Tools </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="#documents_import" tabindex="-1" data-toggle="tab">
                                    Import Documents </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>documents/export_csv">
                                    Export Documents </a>
                            </li>
                        </ul>
                        </li>
                    </ul>

                </div>                                               
            </div>				
        </div>
        <!-- END PORTLET-->
    </div>	


<!-- BEGIN Expiring-->
<div>
    <input type="checkbox" ng-model="selectedAllStatus" ng-change="checkAllStatus()" />
    <button type="button" ng-click="deleteLandingdocStatus()">Delete</button>
</div>


    
 
<div class="well" ng-repeat="doc in documentsProduct | offset: currentPage1 * itemsPerPage1 |  limitTo: itemsPerPage1 | filter:search">
    <div><!--  <input type="checkbox" class="checkboxes" value="1"/> -->
        <input type="checkbox" class="checkboxes" ng-model="doc.checkedStatus" ng-click="checkedvaluesStatus(doc.doc_id)" value="1"/>
    </div>
    <div style="height: 10px;" class="{{ doc.status | getStatus }}"></div>
    <h4>{{ doc.doc_name}} </h4>
            Category Name : {{ doc.cat_name }}<br>
            Start Date: {{ doc.start_date | date:'mediumDate' }}<br>
            End Date: {{ doc.expiry_date | date:'mediumDate' }}<br>
            Status: {{ doc.status | getStatus  }}
    <td>
        <a ng-click="docViewDetails(doc.doc_id)" class="btn grey-cascade">View Details</a> 
    </td>
    
</div> 
<tfoot>
    <td colspan="6">
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
    </td>
</tfoot>             
                                
