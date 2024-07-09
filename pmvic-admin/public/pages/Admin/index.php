<?php
//header('Location: today-pmvic-record.php');

  error_reporting(E_ALL);
  ini_set('display_errors', 1);
	include('../../backend/layout/inc/header.php');
    if ($_SESSION['userdata']['access'] != 'Administrator') {
        echo "<script> window.location.href = '../../';</script>";
        die();
    }
?>

	<title>HOME</title>
    <body>

    <?php
    include('../../../private/initialize.php');
        $result = new Upload();
        $dupResult = new Duplicates();
        $cenResult = new Center();
        $todayUploads = $result->TodayRecordsTotal();
        $allUpload = $result->RecordsTotal();
        $todayDuplicate = $dupResult->todayDuplicateRecord();
        $allPMVIC = $cenResult->get_total_all_center_records();
    ?>

<?php include('../../backend/layout/inc/right-sidebar.php');?>	

<?php include('../../backend/layout/inc/left-side-bar.php');?>


<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h3 mb-0">PMVIC Overview</h2>
        </div>

        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $allPMVIC ?></div>
                            <div class="font-14 text-secondary weight-500">
                                PMVIC CENTER
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#00eccf">
                                <i class="icon-copy dw dw-building"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $todayUploads ?></div>
                            <div class="font-14 text-secondary weight-500">
                                TOTAL UPLOAD TODAY
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#ff5b5b">
                                <span class="icon-copy dw dw-calendar1"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $allUpload ?></div>
                            <div class="font-14 text-secondary weight-500">
                                ALL UPLOADS
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon">
                                <i
                                    class="icon-copy fa fa-upload text-warning"
                                    aria-hidden="true"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $todayDuplicate ?></div>
                            <div class="font-14 text-secondary weight-500">TODAY DUPLICATES</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#09cc06">
                                <i class="icon-copy fa fa-copy" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
<?php include('../../backend/layout/inc/footer.php');?>




