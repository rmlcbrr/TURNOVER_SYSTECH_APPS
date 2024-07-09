<?php include('../../backend/layout/inc/header.php');
    if ($_SESSION['userdata']['access'] != 'User') {
        echo "<script> window.location.href = '../../';</script>";
        die();
    }
?>


<title>UPLOADS</title>

<body>

    <?php include('../../backend/layout/inc/right-sidebar.php'); ?>

    <?php include('../../backend/layout/inc/left-side-bar.php'); ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">

            <div class="min-height-200px">
                <div>
                    <!-- Simple Datatable start -->
                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <div class="row">
                                <div class="col order-last">
                                    <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-pmvic"> <i class="bi bi-plus-circle"></i> ADD PMVIC</button> -->

                                </div>
                                <div class="col">
                                    <h4 class="text-center" data-color="#3033af">UPLOAD PMVIC DATA</h4>
                                </div>
                                <div class="col order-first">

                                </div>
                            </div>
                        </div>
                        <div class="pb-20" style="padding: 10px;">
                            <table class="data-table table hover multiple-select-row nowrap dataTable no-footer dtr-inline collapsed" id="user_upload_data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>MVISR</th>
                                        <th>MV FILE</th>
                                        <th>PLATE</th>
                                        <th>CHASSIS</th>
                                        <th>ENGINE</th>
                                        <th>SUCCESS LOG</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Simple Datatable End -->
                </div>
            </div>

            <!-- ADD -->
            <div class="modal fade bs-example-modal-lg" id="re-upload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">
                                RE-UPLOAD DATA
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formReupload" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">ID</label>
                                            <input type="text" class="form-control" name="id-upload" id="id-upload" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">PMVIC</label>
                                            <input type="text" class="form-control" name="pmvic-upload" id="pmvic-upload" disabled>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">INSPECTION REF NO :</label>
                                            <input type="text" class="form-control" name="ref-upload" id="ref-upload" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">PLATE NUM:</label>
                                            <input type="text" class="form-control" name="plate-upload" id="plate-upload">

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">MV FILE NUM:</label>
                                            <input type="text" class="form-control" name="mvfile-upload" id="mvfile-upload">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="Submit" class="btn btn-primary" id="reupload-submit">
                                Update and Re-Upload
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ADD MODAL -->


            <?php include('../../backend/layout/inc/footer.php'); ?>

            <script>
                $(document).ready(function() {
                    setInterval(() => {
                        setTimeout(() => {
                            let trList = document.querySelectorAll('.hovertooltips');

                            for (let i = 1; i < trList.length; i++) {
                                trList[i].addEventListener('mouseover', e => {
                                    if (i) {
                                        document.querySelector(`.container-tooltip_${i}`).classList.remove('hide-item');
                                    }
                                });
                            }

                            for (let i = 1; i < trList.length; i++) {
                                trList[i].addEventListener('mouseout', e => {
                                    document.querySelector(`.container-tooltip_${i}`).classList.add('hide-item');
                                });
                            }
                        }, 1000);
                    }, 1000);

                    let uploadData = $('#user_upload_data').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "scrollCollapse": true,
                        "autoWidth": false,
                        "responsive": true,
                        "order": [],
                        "ajax": {
                            url: "../../../private/controller/user-controller/upload/process-upload-today.php",
                            type: "POST"
                        },
                        "columnDefs": [{
                            "targets": "datatable-nosort",
                            "orderable": false,
                        },
                            { className: "hovertooltips", "targets": [ 0 ] } 
                        ],
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        language: {
                            info: "_START_-_END_ of _TOTAL_ entries",
                            searchPlaceholder: "Search Here",
                            paginate: {
                                next: '<i class="ion-chevron-right"></i>',
                                previous: '<i class="ion-chevron-left"></i>'
                            }
                        },

                    });
                });
            </script>