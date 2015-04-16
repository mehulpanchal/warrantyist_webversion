<!-- BEGIN PAGE CONTENT-->
<div class="row"  >
    <div class="col-md-12">
        <!-- BEGIN TODO SIDEBAR -->
        <div class="todo-ui margin-top-10">

            <!-- BEGIN TODO CONTENT -->
            <div class="todo-content" >
                <div class="portlet light" style="min-height: 550px;">
                    <!-- PROJECT HEAD -->
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-helper"></span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase">Export Data</span>
                        </div>
                    </div>
                    <!-- end PROJECT HEAD -->
                    <!--Account Detail Start-->
                    <div class="portlet-body" style="padding:15px 15px;" >
                        <h4>Your Data Backup</h4>
                        <p>Your data export will contain a csv file with all the data from selected fields below.</p>
                        <div class="alert alert-success message-animation" role="alert" ng-if="successmessagewhenexported">
                            Selected Backup Sent to your <?php echo $this->session->userdata('email'); ?> Email.
                        </div>
                        <div class="col-md-9">
                            <form name="backupform" ng-submit="sendbackupoptions()" novalidate >
                                <div>
                                    <ul style="list-style: none;">
                                        <!--                                        <li>
                                                                                    <label><input type="checkbox" ng-model="selectedAll" ng-change="checkAll()" /> All</label>
                                                                                </li>-->
                                        <li ng-repeat="row in Items">
                                            <!--<label> <input type="checkbox" ng-model="item.Value" id="{{item.Name}}" ng-checked="selection.indexOf(item.Name) > -1" ng-click="toggleSelection(item.Value)" value="{{item.Value}}"  /> {{item.Name}}</label>-->
                                            <label> <input type="checkbox" ng-model="row.checked" ng-click="checkedvalues(row.Name)" /> {{row.Name}}</label>
                                        </li>
                                    </ul>


                                </div>
                                <div class="col-md-12">
                                    <p>We'll bundle them into single zip file for you. this may take a little while if you have a lot of data.</p>
                                    <p>We'll send you an email at <?php echo $this->session->userdata('email'); ?> when the file is ready.</p>
                                </div>
                                
                                <button class="btn btn-primary" type="submit">Build My Data Backup </button>
                                <div class="loadingtillresponse" ng-if="loadingtillresponse" ></div>
                            </form>
                        </div>
                    </div>
                    <!--BASic Information end-->
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTENT-->
