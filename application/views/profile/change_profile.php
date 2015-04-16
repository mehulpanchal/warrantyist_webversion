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
                            <span class="caption-helper"></span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase">Profile</span>
                        </div>
                    </div>
                    <!-- end PROJECT HEAD -->
                    <div class="portlet-body" >
                        <div class="row">
                            <!-- Profile Image Change Ends here-->
                            <div class="col-md-12">
                                <div class="row"  nv-file-drop="" uploader="uploader" filters="queueLimit, customFilter">
                                    <div class="col-md-3">
                                        <!-- BEGIN: ACCORDION DEMO -->
                                        <div class="portlet light">
                                            <div class="portlet-body" style="padding-top: 0px !important;">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">

                                                    <div class="fileinput-preview fileinput-exists thumbnail"  style="width: 150px; height: 150px; border:0px; " >
                                                    </div>
                                                    <div>
                                                        <span class="btn default btn-file" style="background-color:#ffffff;">
                                                            <span class="fileinput-new">
                                                                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px; border:0px;" >
                                                                    <?php if ($this->session->userdata('profile_image')) { ?>
                                                                        <img src="{{row.profile_image}}" alt="" class="img-circle" />
                                                                    <?php } else { ?>
                                                                        <div class="default-profile-image"><?php echo ucwords(substr($this->session->userdata('username'), 0, 1)); ?></div>    
                                                                    <?php } ?>

                                                                </div> 
                                                                <span class="fileinput-exists">
                                                                    Change 
                                                                </span>
                                                            </span>
                                                            <input type="file" name="profile_image" nv-file-select="" uploader="uploader">
                                                        </span>
                                                        <a href="#" class="btn default fileinput-exists" data-dismiss="fileinput" ng-click="uploader.clearQueue()" ng-disabled="!uploader.queue.length">
                                                            Remove </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>		
                                        <!-- END: ACCORDION DEMO -->
                                    </div>
                                    <div class="col-md-8">
                                        <!-- BEGIN: ACCORDION DEMO -->
                                        <div class="portlet light">
                                            <strong>Upload Your Photo...</strong><br>
                                            Image Should be at least 360px * 360px <br>
                                            Last Modified : {{row.modified_date| date:'MMM d, y' }}
                                            <div class="portlet-body">
                                                <div>
                                                    <div class="progress progress-sm" style="width:100px; " ng-if="showprogressbar">
                                                        <div class="progress-bar progress-bar-info" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                                                    </div>
                                                </div>
                                                <div ng-if="showsuccessfullychanged"> Profile Photo Successfully Changed</div>
                                                <button type="button" class="btn btn-success btn-s" ng-click="uploader.uploadAll()" ng-disabled="!uploader.getNotUploadedItems().length">
                                                    <span class="glyphicon glyphicon-upload"></span> Upload Photo
                                                </button>
                                            </div>
                                        </div>		
                                        <!-- END: ACCORDION DEMO -->
                                    </div>
                                </div>
                            </div>
                            <!-- Profile Image Change Ends here-->
                        </div>


                        <!--BASic Information Start-->
                        <div class="portlet-body" style="width: 50%; float: left; clear: both; padding:15px 15px;" >
                            <p>Basic Information</p>
                            <div class="alert alert-success message-animation" role="alert" ng-if="showSubmittedPromptWhenbasic">
                                Basic Info. Updated Successfully.
                            </div>
                            <form name="editprofile" ng-submit="basicinfochanging()" novalidate>
                                <div class="form-group" ng-class="{ 'has-error' : editprofile.username.$invalid && !editprofile.username.$pristine }">
                                    <label for="username">Username</label>
                                    <input id="username" name="username" class="form-control" type="text" value="{{row.username}}" required
                                           ng-model="row.username" ng-minlength="5" ng-maxlength="20" ng-pattern="/^[A-Za-z0-9]+$/">
                                    <p ng-show="editprofile.username.$error.required" class="help-block">Required</p>
                                    <p ng-show="editprofile.username.$error.minlength" class="help-block">Username is too short.</p>
                                    <p ng-show="editprofile.username.$error.maxlength" class="help-block">Username is too long.</p>
                                    <p ng-show="editprofile.username.$error.pattern" class="help-block">Only Alpha & Numbers Allowed</p>
                                </div>


                                <div class="form-group" ng-class="{ 'has-error' : editprofile.firstname.$invalid && !editprofile.firstname.$pristine }">
                                    <label for="firstname">First Name</label>
                                    <input id="firstname" name="firstname" class="form-control" type="text" value="{{row.firstname}}" required
                                           ng-model="row.firstname" ng-pattern="/^[A-Za-z ]+$/" ng-maxlength="25" />
                                    <p ng-show="editprofile.firstname.$error.required" class="help-block">Required</p>
                                    <p ng-show="editprofile.firstname.$error.maxlength" class="help-block">First Name is too long.</p>
                                    <p ng-show="editprofile.firstname.$error.pattern" class="help-block">Only Alpha & Numbers Allowed</p>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : editprofile.lastname.$invalid && !editprofile.lastname.$pristine }">
                                    <label for="lastname">Last Name</label>
                                    <input id="lastname" name="lastname" class="form-control" type="text" value="{{row.lastname}}" required
                                           ng-model="row.lastname" ng-pattern="/^[A-Za-z ]+$/" ng-maxlength="25" />
                                    <p ng-show="editprofile.lastname.$error.required" class="help-block">Required</p>
                                    <p ng-show="editprofile.lastname.$error.maxlength" class="help-block">Last Name is too long.</p>
                                    <p ng-show="editprofile.lastname.$error.pattern" class="help-block">Only Alpha & Numbers Allowed</p>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : editprofile.email.$invalid && !editprofile.email.$pristine }">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" class="form-control" type="email" required ng-model="row.email" ng-pattern="word" ng-maxlength="255" required />
                                    <p ng-show="editprofile.email.$error.required" class="help-block">Required</p>
                                    <p ng-show="editprofile.email.$error.maxlength" class="help-block">Email is too long.</p>
                                    <p ng-show="editprofile.email.$error.pattern" class="help-block">Invalid Email! </p>
                                </div>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>
                        </div>
                        <!--BASic Information end-->
                        <!--Change Password Start-->
                        <div class="portlet-body" style="width: 50%; float: left; padding:15px 15px;">
                            <p>Change Password</p>
                            <div class="alert alert-success message-animation" role="alert" ng-if="showSubmittedPromptSuccess">
                                Your New Password Updated Successfully.
                            </div>
                            <div class="alert alert-error message-animation" role="alert" ng-if="showSubmittedPromptfail">
                                Your Current Password doesn't Matched.
                            </div>
                            <form name="editpasswordprofile" ng-submit="changepasswordsubmit()" novalidate>
                                <div class="form-group" >
                                    <label for="current_password">Verify Current Password</label>
                                    <input id="current_password" name="current_password" ng-model="editpasswordprofile.password" class="form-control" type="password" 
                                           ng-minlength="8" ng-maxlength="20" ng-pattern="/(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])/" required/>
                                    <div class="my-messages" ng-messages="editpasswordprofile.current_password.$error" >
                                        <span ng-show="editpasswordprofile.current_password.$error.required && editpasswordprofile.current_password.$dirty">Required</span>
                                        <span ng-show="!editpasswordprofile.current_password.$error.required && (editpasswordprofile.current_password.$error.minlength || editpasswordprofile.current_password.$error.maxlength) && editpasswordprofile.current_password.$dirty">Passwords must be between 8 and 20 characters.</span>
                                        <span ng-show="!editpasswordprofile.current_password.$error.required && !editpasswordprofile.current_password.$error.minlength && !editpasswordprofile.current_password.$error.maxlength && editpasswordprofile.current_password.$error.pattern && editpasswordprofile.current_password.$dirty">Must contain one lower &amp; uppercase letter, and one non-alpha character (a number or a symbol.)</span>
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="new_password">New Password</label> <br><label> <a data-ng-click="createPassword()">Generate Strong Password</a>  <span>{{password}}</span> </label>
                                    <input id="new_password" name="new_password" ng-model="editpasswordprofile.newpassword" class="form-control" type="password"
                                           ng-minlength="8" ng-maxlength="20" ng-pattern="/(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])/" required="" />
                                    <div class="my-messages" ng-messages="editpasswordprofile.new_password.$error" >
                                        <span ng-show="editpasswordprofile.new_password.$error.required && editpasswordprofile.new_password.$dirty">required</span>
                                        <span ng-show="!editpasswordprofile.new_password.$error.required && (editpasswordprofile.new_password.$error.minlength || editpasswordprofile.new_password.$error.maxlength) && editpasswordprofile.new_password.$dirty">Passwords must be between 8 and 20 characters.</span>
                                        <span ng-show="!editpasswordprofile.new_password.$error.required && !editpasswordprofile.new_password.$error.minlength && !editpasswordprofile.new_password.$error.maxlength && editpasswordprofile.new_password.$error.pattern && editpasswordprofile.new_password.$dirty">Must contain one lower &amp; uppercase letter, and one non-alpha character (a number or a symbol.)</span>
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input id="confirm_password" name="confirm_password" ng-model="editpasswordprofile.confirmpassword" class="form-control" type="password" valid-password-c
                                           ng-minlength="8" ng-maxlength="20" ng-pattern="/(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])/" required="" />
                                    <div class="my-messages" ng-messages="editpasswordprofile.confirm_password.$error" >
                                        <span ng-show="editpasswordprofile.confirm_password.$error.required && editpasswordprofile.confirm_password.$dirty">required</span>
                                        <span ng-show="!editpasswordprofile.confirm_password.$error.required && editpasswordprofile.confirm_password.$error.noMatch && editpasswordprofile.new_password.$dirty">Passwords do not match.</span>
                                        <span ng-show="!editpasswordprofile.confirm_password.$error.required && (editpasswordprofile.confirm_password.$error.minlength || editpasswordprofile.confirm_password.$error.maxlength) && editpasswordprofile.confirm_password.$dirty">Passwords must be between 8 and 20 characters.</span>
                                        <span ng-show="!editpasswordprofile.confirm_password.$error.required && !editpasswordprofile.confirm_password.$error.minlength && !editpasswordprofile.confirm_password.$error.maxlength && editpasswordprofile.confirm_password.$error.pattern && editpasswordprofile.confirm_password.$dirty">Must contain one lower &amp; uppercase letter, and one non-alpha character (a number or a symbol.)</span>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>
                        </div>
                        <!--Change Password end-->


                    </div>
                    <!--Get User group for notification Settings start--> 
                    <div class="portlet-body" >
                        <h4 class="block">Connection and Notifications</h4>
                        <p>
                            If you are admin or owner of an account, enable notifications to receive updates when a change made to the account. 
                        </p>
                        <form name="setnotification" ng-submit="setnotificationsubmit()">
                            <div class="table-scrollable">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <td>Account Name</td>
                                    <td>User Type</td>
                                    <td>Security Notification !info</td>
                                    <td>Login Notification !info</td>
                                    <td></td>
                                    </thead>
                                    <tbody>
                                    <td>{{gridrow.username}} <span class="label label-sm label-warning">CURRENT</span></td>
                                    <td>
                                        <span class="label label-sm label-warning" ng-if="gridrow.role == 0">Super Admin</span>
                                        <span class="label label-sm label-warning" ng-if="gridrow.role == 1">Admin</span>
                                        <span class="label label-sm label-warning" ng-if="gridrow.role == 2">Subscriber</span>
                                        <span class="label label-sm label-warning" ng-if="gridrow.role == 3">User</span>
                                    </td>
                                    <td><input type="checkbox" ng-model="gridrow.security_notification" ng-true-value="1" ng-false-value="0" id="s_email" class="checker" /><label for="s_email">Email</label></td>
                                    <td><input type="checkbox" ng-model="gridrow.login_notification" ng-true-value="1" ng-false-value="0" id="l_email" class="checker" /><label for="l_email">Email</label></td>
                                    <td><a class="label label-sm label-info" ng-click="leaveaccountclick(gridrow.userid)">Leave Account</a></td>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-primary" type="submit">Update</button>
                            <div class="alert alert-success message-animation" role="alert" ng-if="shownotificationmessagesuccess">
                                Notification(s) Updated Successfully.
                            </div>
                        </form>
                    </div>
                    <!--Get User group for notification Settings end--> 
                </div>
            </div>
            <!-- END TODO CONTENT -->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<!-- END PAGE CONTENT-->
