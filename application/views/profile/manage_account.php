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
                            <span class="caption-helper"></span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase">Account Details</span>
                        </div>
                    </div>
                    <!-- end PROJECT HEAD -->
                    <!--Account Detail Start-->
                        <div class="portlet-body" style="width: 50%; float: left; clear: both; padding:15px 15px;" >
                            <div class="alert alert-success message-animation" role="alert" ng-if="ShowSuccessMessageInAccountDetails">
                                Account Details Updated Successfully.
                            </div>
                            <form name="editaccountdetails" ng-submit="editaccountdetailsupdate()" novalidate>
                                <div class="form-group">
                                    <label for="username">Account Name</label>
                                    <input id="username" name="username" class="form-control input-lg" type="text" value="{{row.account_name}}" ng-model="row.accountname" >
                                </div>
                                <div class="form-group" >
                                    <label for="firstname">Timezone</label>
                                    <select name="timezone" id="timezone" class="form-control input-lg" ng-model="row.timezone">
                                        <option value="">Select Timezone</option>
                                        <?php 
                                        foreach ($gmt as $key => $value) {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        ?>
                                        
                                    </select>
                                </div>
<!--                                <div class="form-group" >
                                    <label for="dateformate">Date Formate</label>
                                    <select name="dateformate" id="dateformate" class="form-control input-lg" ng-model="row.dateformate">
                                        <option value="">Select Date Formate</option>
                                        <option value="d/m/Y"><?php echo date('d/m/Y'); ?></option>
                                        <option value="j, n, Y"><?php echo date('j, n, Y'); ?></option>
                                        <option value="D M j G:i:s Y"><?php echo date('D M j G:i:s Y'); ?></option>
                                        <option value="F j, Y, g:i a"><?php echo date('F j, Y, g:i a'); ?></option>
                                    </select>
                                </div>-->
                                <div class="form-group" >
                                    <label for="typeofcompany">Types of Company</label>
                                    <select name="typeofcompany" id="typeofcompany" class="form-control input-lg" ng-model="row.typeofcompany">
                                        <option value="">Select Types</option>
                                        <option value="Software and Web App">Software and Web App</option>
                                        <option value="Option2">Option2</option>
                                        <option value="Option3">Option3</option>
                                        <option value="Option4">Option4</option>
                                    </select>
                                </div>
                                <div class="form-group" >
                                    <label for="howmanyorg">How many people are in your Organization?</label>
                                    <select name="howmanyorg" id="howmanyorg" class="form-control input-lg" ng-model="row.peoplesincompany">
                                        <option value="">Select Peoples</option>
                                        <option value="1-5">1-5</option>
                                        <option value="6-10">6-10</option>
                                        <option value="11-20">11-20</option>
                                        <option value="21-50">21-50</option>
                                        <option value="51-100">51-100</option>
                                        <option value="101-150">101-150</option>
                                        <option value="150-300">150-300</option>
                                        <option value="301-500">301-500</option>
                                        <option value="501-1000">501-1000</option>
                                        <option value="1000+">1000+</option>
                                    </select>
                                </div>
                                <div class="form-group" >
                                    <label for="howoldorg">How Old is your organization?</label>
                                    <select name="howoldorg" id="howoldorg" class="form-control input-lg" ng-model="row.howoldcompany">
                                        <option value="">Select How Old</option>
                                        <option value="1">< 1 Year</option>
                                        <option value="1-2">1-2 Year</option>
                                        <option value="3-5">3-5 Year</option>
                                        <option value="6-10">6-10 Year</option>
                                        <option value="11+">11+ Year</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Save</button>
                            </form>
                        </div>
                        <!--BASic Information end-->
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
        <!-- END PAGE CONTENT-->
