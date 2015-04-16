<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="sub_row">
    <a class="pull-left back_left back_none">
        <img src="<?php echo base_url('assets/admin/layout/img/Back-icon.png'); ?>" />
    </a>
    <a class="pull-right close_right" ng-click="$modalCancel()">
        <img src="<?php echo base_url('assets/admin/layout/img/Close-Button-icon.png'); ?>" />
    </a>
</div>
<div class="portlet light" style="min-height: 350px;" >
    <div class="portlet-body form" >
        <form class="form-horizontal" name="inviteUserForm" ng-submit="inviteusersubmit(inviteUserForm.$valid)" novalidate >
            <div id="messages" class="alert alert-success" ng-show="message">{{message}}</div>
            <div class="form-body">
                <!-- SHOW ERROR/SUCCESS MESSAGES -->
                <div class="warrenty-form-left">
                    <div class="form-group" ng-class="{ 'has-error' : inviteUserForm.name.$invalid && !inviteUserForm.name.$pristine }">
                        <div class="col-md-9">
                            <label for="email">Name</label>
                            <input type="text" class="form-control input-inline input-medium" name="name" ng-model="inviteUserFormData.name"  ng-pattern="/^[A-Za-z ]+$/" required="">
                            <div class="custom-error" ng-show="inviteUserForm.name.$dirty && inviteUserForm.name.$invalid">
                                <span ng-show="inviteUserForm.name.$error.required">Name is required.</span>
                                <span ng-show="inviteUserForm.name.$error.pattern">No Special Character Allowed.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : inviteUserForm.Myemail.$invalid && !inviteUserForm.Myemail.$pristine }">
                        <div class="col-md-9">
                            <label for="email">Email</label>
                            <input name="Myemail" ng-model="inviteUserFormData.Myemail" class="form-control input-inline input-medium" type="text" ng-pattern="/^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/" required="" />
                            <div class="custom-error" ng-show="inviteUserForm.Myemail.$dirty && inviteUserForm.Myemail.$invalid">
                                <span ng-show="inviteUserForm.Myemail.$error.required" class="help-block">Email is Required.</span>
                                <span ng-show="inviteUserForm.Myemail.$error.maxlength" class="help-block">Email is too long.</span>
                                <span ng-show="inviteUserForm.Myemail.$error.pattern" class="help-block">Invalid Email! </span>
                            </div>
                        </div>
                    </div>
                    <h3>Access Level</h3>
                    <label> <input type="radio" name="role" value="1" ng-model="inviteUserFormData.role">  Administrator </label><br>
                    <label> <input type="radio" name="role" value="2" ng-model="inviteUserFormData.role">  Subscriber </label><br>
                    <label> <input type="radio" name="role" value="3" ng-model="inviteUserFormData.role">  User </label>
                    <div class="form-group" >
                        <button type="submit" class="btn btn-success btn-lg btn-block"  >
                            <span class="glyphicon glyphicon-flash"></span> Invite User
                        </button>
                        <div class="loadingtillresponse" ng-if="loadingtillresponse" ></div>
                    </div>
                    <!--                    {{inviteUserFormData}}-->
                </div>
        </form>    
        <?php
        ?>
    </div>
</div>

<!-- END SAMPLE FORM PORTLET-->

