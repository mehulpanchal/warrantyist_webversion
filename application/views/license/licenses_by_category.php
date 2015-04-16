
<!-- BEGIN PAGE BREADCRUMB -->
<!--<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="#dashboard">Home</a><i class="fa fa-circle"></i>
    </li>

    <li class="active">
        Licenses By Category
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
                    <span class="caption-subject bold uppercase">License Category Listing</span>
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
            <br>

            <div class="portlet box blue-madison" ng-if="valueNew !== 'E'"  ng-repeat="(key,value) in getlicensesbycategory">
                <div class="portlet-title">
                    <div class="caption">
                        {{key}}
                    </div>

                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-hover" id="sample_1">

                        <tbody>
                            <tr class="odd gradeX"  ng-repeat="row in value">
                                <td>
                                    <input type="checkbox" ng-model="row.checked" ng-click="checkedvalues(row.id)" />
                                </td>
                                <td ng-class="{greenstatus: row.status=='active',yellowstatus: row.status=='expiring', redstatus: row.status=='expired'}"> </td>
                                <td> <img src="{{ row.image_url}}" width="70" height="70" />
                                    </td>
                                    <td>
                                        {{ row.cat_name}} 
                                        <br />
                                        {{ row.start_date | date:'MMM d, y' }}
                                        ,  Expired Date : {{ row.expiry | date:'MMM d, y' }}
                                        <br />
                                        Vendor: {{ row.vendor_name}}<br>
                                        Version Name:  {{ row.softwear_name}}<br />
                                        Version:  {{ row.softwear_version}}
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
                    </table>
                </div>                                        
            </div>
        </div>
    </div>
</div>



