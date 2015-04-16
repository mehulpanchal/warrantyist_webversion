<!-- BEGIN HEADER -->
<div class="page-header">
    <?php include_once 'header.php'; ?>
</div>    
<!-- END HEADER -->

<div class="clearfix">
</div>

<!-- BEGIN CONTAINER -->
<div class="page-container">

    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">		
        <?php include_once 'page-head.html'; ?>
    </div>
    <!-- END PAGE HEAD -->

    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="container">
            <!-- BEGIN ACTUAL CONTENT -->
            <div ui-view class="fade-in-up">
            </div>
            <!-- END ACTUAL CONTENT -->
        </div>
    </div>
    <!-- END PAGE CONTENT -->

</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<div><?php include_once 'footer.html'; ?></div>
<!-- END FOOTER -->