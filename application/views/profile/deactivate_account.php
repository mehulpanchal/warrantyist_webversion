<!-- BEGIN PAGE CONTENT-->
<div class="row"  >
    <div class="col-md-12">
        <!-- BEGIN TODO SIDEBAR -->
        <div class="todo-ui margin-top-10">

            <!-- BEGIN TODO CONTENT -->
            <div class="todo-content" >
                <div class="portlet light" style="min-height: 500px;">
                    <!-- PROJECT HEAD -->
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-helper"></span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase">Deactivate Account</span>
                        </div>
                    </div>
                    <!-- end PROJECT HEAD -->
                    <!--Account Detail Start-->
                    <div class="portlet-body" style="padding:15px 15px;" >
                        <h4>Pause or delete Account</h4>

                        <div class="alert alert-success message-animation" role="alert" ng-if="successactionfinished">
                            Your Action has been completed.
                        </div>
                        <div class="col-md-10">
                            <form name="pauseyouraccount" ng-submit="sendpauseoptions()" novalidate >
                                    <label>
                                        <input type="radio" name="deactivate" value="pause" ng-model="formData.deactivate">  Temporarily pause billing on this account
                                    </label>
                                    <br>sending will be disable when your account is pause. Everything else will be still available. 
                                    <br><a>Why can i only pause  twice a year?</a>
                                    <br>
                                    <br>
                                    <label>
                                        <input type="radio" name="deactivate" value="delete" ng-model="formData.deactivate"> Permanently delete this account </label>
                                    <br>
                                    this account will no longer be available and all the data in the account will be permanently deleted.
                                    <br><a>How can i export and backup my account data?</a>
                                    <br><br>
                                <button class="btn blue btn-block" type="submit" >Temporarily Pause Account</button>
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
