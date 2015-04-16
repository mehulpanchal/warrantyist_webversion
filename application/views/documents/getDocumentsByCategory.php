<style>
    #productdetails .modal-dialog  {width:60%;}
    #addWarranty .modal-dialog { width: 60%;}
    #editWarranty .modal-dialog { width : 60%}
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
                                             <input type="text" class="form-control form-control-solid" placeholder="Search...">
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

<div class="portlet box red-intense" ng-if="documentsexpired != 'E'">
    <div class="portlet-title">
        <div class="caption">
            Expired
        </div>

    </div>
    <div class="portlet-body">                           
        <table class="table table-striped table-hover" id="sample_1">

            <tbody>
                <!--  <tr class="odd gradeX" ng-repeat="doc in documentsexpired">  -->
                <tr class="odd gradeX" ng-repeat="doc in documentsexpired | offset: currentPage1 * itemsPerPage1 |  limitTo: itemsPerPage1"> 
                    <td>
                       <!--  <input type="checkbox" class="checkboxes" value="1"/> -->
                        <input type="checkbox" class="checkboxes" ng-model="doc.checkedStatus" ng-click="checkedvaluesStatus(doc.doc_id)" value="1"/>
                    </td>
                    <td>
                        {{ doc.doc_name}} 
                        <br />
                        Passport Expired on {{ doc.expiry_date | date:'dd, MMMM yyyy' }}
                    </td>
                    
                    <td class="center">

                    </td>
                    <td>
                        <a ng-click="docViewDetails(doc.doc_id)" class="btn grey-cascade">View Details</a> 
                    </td>
                </tr>
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
            </tbody>
        </table>

    </div>                                        
</div>


<!-- END Expiring-->    
<!-- BEGIN Expiring-->
<div class="portlet box blue-madison" ng-if="documentsexpiring !== 'E'">
    <div class="portlet-title">
        <div class="caption">
            Expiring
        </div>

    </div>
    <div class="portlet-body">
        <table class="table table-striped table-hover" id="sample_1">

            <tbody>
                <!-- <tr class="odd gradeX" ng-repeat="doc in documentsexpiring"> -->
                     <tr class="odd gradeX" ng-repeat="doc in documentsexpiring| offset: currentPage2 * itemsPerPage2 |  limitTo: itemsPerPage2">
                    <td>
                        <input type="checkbox" class="checkboxes" ng-model="doc.checkedStatus" ng-click="checkedvaluesStatus(doc.doc_id)" value="1"/>
                    </td>
                    
                    <td>
                        {{ doc.doc_name}} 
                        <br />
                        Passport Expires on {{ doc.expiry_date | date:'dd, MMMM yyyy' }}

                    </td>
                   
                    <td class="center">

                    </td>
                    <td>
                        <a ng-click="docViewDetails(doc.doc_id)" class="btn grey-cascade">View Details</a>                                    
                    </td>
                </tr>
                 <tfoot>
                            <td colspan="6">
                                <div class="dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination">
                                        <li ng-class="prevPageDisabled2()" class="paginate_button">
                                            <a href ng-click="prevPage2()">« Prev</a>
                                        </li>
                                        <li ng-repeat="n in range2()" class="paginate_button"
                                            ng-class="{active: n == currentPage2}" ng-click="setPage2(n)">
                                            <a href="#">{{n + 1}}</a>
                                        </li>
                                        <li ng-class="nextPageDisabled2()" class="paginate_button">
                                            <a href ng-click="nextPage2()">Next »</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            </tfoot>
            </tbody>
        </table>
    </div>                                        
</div>
<!-- END Expiring-->                 
<!-- BEGIN Active-->
<div class="portlet box green-haze" ng-if="documentsactive != 'E'">
    <div class="portlet-title">
        <div class="caption">
            Active
        </div>

    </div>
    <div class="portlet-body">                         
        <table class="table table-striped table-hover" id="sample_1">

            <tbody>
                <!-- <tr class="odd gradeX" ng-repeat="doc in documentsactive"> -->
                <tr class="odd gradeX" ng-repeat="doc in documentsactive| offset: currentPage3 * itemsPerPage3 |  limitTo: itemsPerPage3">
                    <td>
                        <input type="checkbox" class="checkboxes" ng-model="doc.checkedStatus" ng-click="checkedvaluesStatus(doc.doc_id)" value="1"/>
                    </td>
                   
                    <td>
                       {{ doc.doc_name}} 
                        <br />
                        Passport Expiring on {{ doc.expiry_date | date:'dd, MMMM yyyy' }}
                    </td>
                  
                    <td class="center">

                    </td>
                    <td>
                        <a ng-click="docViewDetails(doc.doc_id)" class="btn grey-cascade">View Details</a> 
                    </td>
                </tr>
                <tfoot>
                    <td colspan="6">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <li ng-class="prevPageDisabled3()" class="paginate_button">
                                    <a href ng-click="prevPage3()">« Prev</a>
                                </li>
                                <li ng-repeat="n in range3()" class="paginate_button"
                                    ng-class="{active: n == currentPage3}" ng-click="setPage3(n)">
                                    <a href="#">{{n + 1}}</a>
                                </li>
                                <li ng-class="nextPageDisabled3()" class="paginate_button">
                                    <a href ng-click="nextPage3()">Next »</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tfoot>
            </tbody>
        </table>                             
    </div>                                        
</div>               
<!-- END Active-->                 
                                
