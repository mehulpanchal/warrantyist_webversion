<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="sub_row">
    <a class="pull-left back_left back_none">
        <img src="<?php echo base_url('assets/admin/layout/img/Back-icon.png'); ?>" />
    </a>
    <a class="pull-right close_right" ng-click="$modalCancel()">
        <img src="<?php echo base_url('assets/admin/layout/img/Close-Button-icon.png'); ?>" />
    </a>
</div>
<div class="portlet light" style="min-height: 150px;" >
    <div class="portlet-body form" >
        <form class="form-horizontal" name="inviteUserForm" novalidate ng-submit="update_role_submit()">
            <div id="messages" class="alert alert-success" ng-show="message">{{message}}</div>
            <div class="form-body">
                <!-- SHOW ERROR/SUCCESS MESSAGES -->
                <div class="warrenty-form-left">
                    <label> <input type="radio" name="role" value="1" ng-model="inviteUserFormData.role">  Administrator </label><br>
                    <label> <input type="radio" name="role" value="2" ng-model="inviteUserFormData.role">  Subscriber </label><br>
                    <label> <input type="radio" name="role" value="3" ng-model="inviteUserFormData.role">  User </label><br>
                    <div class="form-group" >
                        <button type="submit" class="btn btn-success btn-lg btn-block"  >
                            <span class="glyphicon glyphicon-flash"></span> Update Role
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

