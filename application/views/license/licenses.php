
<!-- BEGIN PAGE BREADCRUMB -->
<!--<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="#dashboard">Home</a><i class="fa fa-circle"></i>
    </li>

    <li class="active">
        Licenses
    </li>
</ul>-->
<!-- END PAGE BREADCRUMB -->

<!-- BEGIN MAIN CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!--        <div class="note note-danger note-bordered">
                    <p>
                        NOTE: The below datatable is not connected to a real database so the filter and sorting is just simulated for demo purposes only.
                    </p>
                </div>-->
        <!-- Begin: life time stats -->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="icon-settings font-green-sharp"></i>
                    <span class="caption-subject bold uppercase">License Listing</span>
                </div>
                <div class="actions">
                    <a href="#" ng-click="launchAddLicenseObjectModal()" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">
                            New License </span>
                    </a>
                    <div class="btn-group">
                        <a class="btn default yellow-stripe" href="#" data-toggle="dropdown">
                            <i class="fa fa-share"></i>
                            <span class="hidden-480">
                                Tools </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="#licenses_import" tabindex="-1" data-toggle="tab">
                                    Import License </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>licenses/export_csv">
                                    Export License </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>	
            <div class="warrenty-data-filter">
                <div class="caption caption-md">
                    <div class="portlet-body form" >
                        <div class="portlet-input input-small input-inline " style="width: 200px; float: left;">
                            <div class="input-icon right">
                                <i class="icon-magnifier"></i>
                                <input type="text" class="form-control form-control-solid" placeholder="search...">
                            </div>
                        </div>
                        <div style="width: 500px; height: 50px; float: left;">
                            <form class="form-horizontal" role="form">
                                <div class="form-body">					
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"> Sort By</label>
                                        <div class="col-md-9">
                                            <select
                                                ng-model="selected"
                                                ng-options="item.label for item in sortitems"
                                                ></select>
                                            <button ng-click="gotoSelected()">Go</button>
<!--                                            <pre>{{selected | json}}</pre>-->
                                        </div>
                                    </div>									
                                </div>								
                            </form>
                        </div> 


                    </div>

                </div>
            </div>

            <div>
                <input type="checkbox" ng-model="selectedAll" ng-change="checkAll()" />
                <button type="button" ng-click="delete_licenses()" class="btn default yellow-stripe">Delete</button>
            </div>
            <div style="color:#000;">
                <div>Selected: <span>{{suggestionselected}}</span></div>
                <div><input type="text" ng-model="suggestionselected" typeahead="name.softwear_name for name in states | filter:suggestionselected"></div>
            </div>
            <br>

            <!-- BEGIN Expired-->
            <div class="portlet box red-intense" >
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Expired
                    </div>

                </div>

                <div class="portlet-body"  >
                    <table class="table table-striped table-hover" id="sample_1" ng-if="licensesexpired != 'D'">

                        <tbody>
                            <tr class="odd gradeX" ng-repeat="row in licensesexpired| offset: currentPage1 * itemsPerPage1 |  limitTo: itemsPerPage1">
                                <td>
                                    <input type="checkbox" ng-model="row.checked" ng-click="checkedvalues(row.id)" />
                                </td>
                                <td>
                                    <img src="{{ row.image_url}}" width="70" height="70" />
                                </td>
                                <td>
                                    {{ row.cat_name}} 
                                    <br />
                                    {{ row.start_date | date:'MMM d, y' }}
                                    ,  Expired Date : {{ row.start_date | date:'dd, MMMM yyyy' }}
                                    ,  updated : {{ row.start_date | date:'MMM d, y' }}
                                    <br />
                                    Vendor: {{ row.vendor_name}}<br>
                                    Version {{ row.softwear_name}}<br />
                                    Version {{ row.softwear_version}}
                                </td>
                                <td>

                                </td>
                                <td class="center">

                                </td>
                                <td>
                                    <a ng-click="launchObjectModal(row.id)" class="btn grey-cascade">View Details</a> 
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
                    <div ng-show="licensesexpired == 'D'">
                        <h4>No License(s) found</h4>
                    </div>
                </div>     

            </div>                
            <!-- END Expired-->

            <!-- BEGIN Expiring-->
            <div class="portlet box blue-madison" >
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Expiring
                    </div>

                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-hover" id="sample_1" ng-if="licensesexpiring != 'D'">
                        <tbody>
                            <tr class="odd gradeX" ng-repeat="row in licensesexpiring| offset: currentPage2 * itemsPerPage2 |  limitTo: itemsPerPage2">
                                <td>
                                    <input type="checkbox" ng-model="row.checked" ng-click="checkedvalues(row.id)" />
                                </td>
                                <td>
                                    <img src="{{ row.image_url}}" width="70" height="70" />
                                </td>
                                <td>
                                    {{ row.cat_name}} 
                                    <br />
                                    Expired Date : {{ row.start_date | date:'dd, MMMM yyyy' }}
                                    <br />
                                    Vendor: {{ row.vendor_name}}<br>
                                    {{ row.softwear_name}}<br />
                                    Version {{ row.softwear_version}}
                                </td>
                                <td>

                                </td>
                                <td class="center">

                                </td>
                                <td>
                                    <a ng-click="launchObjectModal(row.id)" class="btn grey-cascade">View Details</a> 
                                </td>
                            </tr>
                        </tbody>
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
                    </table>
                    <div ng-show="licensesexpiring == 'D'">
                        <h4>No License(s) found</h4>
                    </div>
                </div>                                        
            </div>
            <!-- END Expiring-->

            <!-- BEGIN Active-->
            <div class="portlet box green-haze" >
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Active
                    </div>

                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-hover" id="sample_1" ng-if="licensesactive != 'D'">
                        <tbody>
                            <tr class="odd gradeX" ng-repeat="row in licensesactive| offset: currentPage3 * itemsPerPage3 |  limitTo: itemsPerPage3">
                                <td>
                                    <input type="checkbox" ng-model="row.checked" ng-click="checkedvalues(row.id)" />
                                </td>
                                <td>
                                    <img src="{{ row.image_url}}" width="70" height="70" />
                                </td>
                                <td>
                                    {{ row.cat_name}} 
                                    <br />
                                    {{ row.start_date | date:'MMM d, y' }}
                                    , Expired Date : {{ row.start_date | date:'dd, MMMM yyyy' }}
                                    <br />
                                    Vendor: {{ row.vendor_name}}<br>
                                    {{ row.softwear_name}}<br />
                                    Version {{ row.softwear_version}}
                                </td>
                                <td>

                                </td>
                                <td class="center">

                                </td>
                                <td>
                                    <a ng-click="launchObjectModal(row.id)" class="btn grey-cascade">View Details</a> 
                                </td>
                            </tr>
                        </tbody>

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


                    </table>
                    <div ng-show="licensesactive == 'D'">
                        <h4>No License(s) found</h4>
                    </div>

                </div>                                        
            </div>
            <!-- END Active-->

        </div>
    </div>
</div>



