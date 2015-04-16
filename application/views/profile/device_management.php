<!-- BEGIN PAGE CONTENT-->
<div class="row"  >
    <div class="col-md-12">
        <!-- BEGIN TODO SIDEBAR -->
        <div class="todo-ui margin-top-10">

            <!-- BEGIN TODO CONTENT -->
            <div class="todo-content" >
                <div class="portlet light" style="min-height: 800px;">
                    <!-- PROJECT HEAD -->
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-helper"></span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase">Device Management</span>
                        </div>
                    </div>
                    <!-- end PROJECT HEAD -->
                    <!--Account Detail Start-->
                    <div class="portlet-body" style="padding:15px 15px;" >
                        <div class="alert alert-success message-animation" role="alert" ng-if="devicenotfound">
                            No Device(s) Found.
                        </div>
                        Want to Log out of a device? Click <strong>Forgot</strong> to disable access on device.    
                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <tbody>
                                    <tr ng-repeat="r in row" ng-init="loading = []">
                                        <td class="fit">
                                            <div class="device-circle">
                                                {{r.device_name}}
                                            </div>
                                        </td>
                                        <td>
                                            <h3>{{r.device_name}}</h3>
                                            <span>Last Activity on {{r.last_login_date | moment: 'utc' | moment: 'format': 'MMM Do @ HH:MM A' }}</span>
                                        </td>
                                        <td>
                                            <button class="btn" type="button" ng-disabled="isDisabled[r.id]" ng-click="forgetdevice(r.id, $index)" ng-if="r.status == '1'">Forget</button>
                                            <button class="btn" type="button" ng-disabled="isDisabledUn[r.id]" ng-click="unforgetdevice(r.id, $index)" ng-if="r.status == '0'">Unforget</button>
                                            <span ng-show="loading[$index]">Loading...</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!--BASic Information end-->
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTENT-->
