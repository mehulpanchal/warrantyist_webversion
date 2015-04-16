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
                        <div class="caption clear">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-helper"></span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase">User Management</span>
                        </div>

                        <!-- end PROJECT HEAD -->
                        <!--Account Detail Start-->
                        <div class="portlet-body " style="padding:25px 0px;" ></div>
                        <div class="left clear text-left" style="width: 80%;"><h4> Users in <?php echo ucwords($this->session->userdata('username')); ?></h4></div>
                        <div class="right clear">
                            <a class="btn btn-lg grey-cascade" ng-click="LaunchInviteUserModal()" >Invite A User <i class="fa fa-plus"></i></a>
                        </div>
                        <div class="alert alert-success message-animation" role="alert" ng-if="usersnotfound">
                            No User(s) Found.
                        </div>
                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <tbody>
                                    <tr ng-repeat="r in row" ng-init="loading = []">
                                        <td class="fit" >
                                            <div ng-class="{'default-profile-image-medium-superadmin' : r.userid === '<?php echo $this->session->userdata('userid');?>', 'default-profile-image-medium' : r.role !== '0' || r.role !== '1'}" class="default-profile-image-medium">{{r.username| limitTo:1 | firstUpper}}</div>  
                                        </td>
                                        <td>
                                            {{r.firstname| firstUpper}} {{r.lastname| firstUpper}}   
                                            <span class="label" style="color: #4DC9D3; background-color: #F4F4F4;" ng-if="r.userid === '<?php echo $this->session->userdata('userid');?>'" > YOU </span> 
                                            <span class="label label-success" ng-if="r.role === '0'" > SUPER ADMIN </span> 
                                            <span class="label label-success" ng-if="r.role === '1'" > ADMIN </span> 
                                            <span class="label label-success" ng-if="r.role === '2'" > SUBSCRIBER </span> 
                                            <span class="label label-success" ng-if="r.role === '3'" > USER </span> 
                                            <br>
                                            <span>{{r.email}}</span>
                                            
                                        </td>
                                        <td class="fit-width">
                                            <div ng-if="r.role !== '0'">
                                            <button class="btn grey-cascade" type="button" ng-click="LaunchAccessLevelModal(r.userid)" ng-if="r.role != '4'" >Edit User Role</button>
                                            <button class="btn" type="button" ng-disabled="isDisabled[r.userid]" ng-click="LaunchAccessLevelModal(r.userid)" ng-if="r.role == '4'">Activate</button>
                                            <button class="btn" type="button" ng-disabled="isDisabledUn[r.userid]" ng-click="setUsertoDeactive(r.userid)" ng-if="r.role != '4'">Deactivate</button>
                                            <span ng-show="loading[$index]">Loading...</span>
                                            </div>
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
