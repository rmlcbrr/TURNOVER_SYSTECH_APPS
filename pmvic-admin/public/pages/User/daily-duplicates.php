<?php include('../../backend/layout/inc/header.php'); 
    if ($_SESSION['userdata']['access'] != 'User') 
    {
        echo "<script> window.location.href = '../../';</script>";
        die();
    }
?>



<body>

    <?php include('../../backend/layout/inc/right-sidebar.php'); ?>

    <?php include('../../backend/layout/inc/left-side-bar.php'); ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div>

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
                                    <h4 class="text-center" data-color="#3033af">DAILY PMVIC DUPLICATES</h4>
                                </div>
                                <div class="col order-first">

                                </div>
                            </div>
                        </div>
                        <div class="pb-20" style="padding: 10px;">
                            <table class="data-table table hover multiple-select-row nowrap dataTable no-footer dtr-inline collapsed" id="upload_data">
                                <thead>
                                    <tr>
                                        <th>PMVIC</th>
                                        <th>MVISR</th>
                                        <th>MV FILE</th>
                                        <th>PLATE</th>+
                                        <th>CHASSIS</th>
                                        <th>ENGINE</th>
                                        <th>SUCCESS LOG</th>
                                        <th>EMISSION RESULT</th>
                                        <th>DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Simple Datatable End -->
                </div>
            </div>


            <!-- DELETE MODAL -->

            <div class="modal fade " id="duplicate-deleted" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="myLargeModalLabel">
                                DELETE PMVIC RECORDS
                            </h6>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formDeleted">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id-deleted" id="id-deleted">
                                    <div class="col-md-12 text-center">
                                        <div id="mv-file"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="Submit" class="btn btn-danger" id="MoveToDeleted">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <?php include('../../backend/layout/inc/footer.php'); ?>

            <script>
                $(document).ready(function() {
                    let duplicateData = $('#upload_data').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "scrollCollapse": true,
                        "autoWidth": false,
                        "responsive": true,
                        "order": [],
                        "ajax": {
                            url: "../../../private/controller/user-controller/duplicates/daily-duplicate.php",
                            type: "POST"
                        },
                        "columnDefs": [{
                            "targets": "datatable-nosort",
                            "orderable": false,
                        }, ],
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



                    $(document).on('click', '.fetch-deleted', function() {
                        event.preventDefault();

                        let reupload_id = $(this).data('id');

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/upload/fetch-upload.php",
                            data: {
                                'reupload_id': reupload_id
                            },
                            success: function(response) {
                                const data = JSON.parse(response);

                                $('#id-deleted').val(data.id);
                                $('#mv-file').html("MV FILE No: <b>" + data.TRANSACTION_NO + "</b> Move to Deleted History!");

                                $('#duplicate-deleted').modal('show');

                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    $(document).on('click', '#MoveToDeleted', function() {
                        event.preventDefault();

                        let form = $('#formDeleted')[0];
                        let data = new FormData(form);


                        $.ajax({
                            type: "POST",
                            url: "../../../private/controller/deleted/deleted-update.php",
                            data: data,
                            processData: false,
                            contentType: false,
                            cache: false,
                            async: false,
                            beforeSend: function() {
                                $('#MoveToDeleted').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                $('#MoveToDeleted').attr("disabled", true);
                                $('#MoveToDeleted').css({
                                    "border-radius": "50%"
                                });
                            },

                            success: function(data) {

                                // console.log(data);

                                if (data == 'true') {
                                    poUpRightCorner('success', 'Delete Successfully.');
                                    duplicateData.ajax.reload();
                                } else {
                                    poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                }

                            },
                            complete: function() {

                                $('#duplicate-deleted').modal('hide');
                                $('#MoveToDeleted').html('Submit');
                                $('#MoveToDeleted').attr("disabled", false);
                                $('#MoveToDeleted').css({
                                    "border-radius": "4px"
                                });


                            },
                            error: function(data) {

                                poUpRightCorner('error', data.statusText);
                            }
                        });

                        function poUpRightCorner(status, message) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: status,
                                title: message
                            })
                        }
                    });
                });
            </script>