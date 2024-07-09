<?php include('../../backend/layout/inc/header.php');
if ($_SESSION['userdata']['access'] != 'Administrator') {
    echo "<script> window.location.href = '../../';</script>";
    die();
}
?>

<?php include('../../backend/layout/inc/header.php'); ?>

<title>PMVIC Center</title>

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
                                    <h4 class="text-center" data-color="#3033af">LOCATION LIST</h4>
                                </div>
                                <div class="col order-first">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#add-pmvic" data-bgcolor="#007bb5" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(0, 123, 181);">
                                        <i class="bi bi-plus-circle"></i> ADD LOCATION
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pb-20">
                            <table class="data-table table stripe hover nowrap" id="pmvic_data">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Date Update</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Simple Datatable End -->
                </div>
            </div>

            <!-- MODALS -->

            <!-- ADD -->
            <div class="modal fade bs-example-modal-lg" id="add-pmvic" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">
                                ADD LOCATION
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formPmvic">
                                <div class="form-group">
                                    <label for="">PMVIC Name</label>
                                    <input type="text" class="form-control" name="pmvicName" placeholder="Enter Name">
                                    <span class="error-name"></span>
                                </div>

                                <div class="form-group">
                                    <label for="">PMVIC Location</label>
                                    <input type="text" class="form-control" name="pmvicLocation" placeholder="Enter Name">
                                    <span class="error-location"></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="Submit" class="btn btn-primary" id="InsertPmvicLocation">
                                SAVE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ADD MODAL -->

            <!-- UPDATE MODAL -->

            <div class="modal fade bs-example-modal-lg" id="edit-location" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">
                                UPDATE LOCATION
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formLocationUpdate" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" id="loc_id" name="loc_id">
                                    <label for="">PMVIC Name</label>
                                    <input type="text" class="form-control" id="pmvicName" name="pmvicName" placeholder="Enter Name">
                                    <span class="error-name"></span>
                                </div>

                                <div class="form-group">
                                    <label for="">PMVIC Location</label>
                                    <input type="text" class="form-control" id="pmvicLocation" name="pmvicLocation" placeholder="Enter Name">
                                    <span class="error-location"></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="Submit" class="btn btn-primary" id="UpdateLocation">
                                SAVE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DELETE MODAL -->

            <div class="modal fade " id="delete-pmvic" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="myLargeModalLabel">
                                DELETE LOCATION RECORDS
                            </h6>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" class="form-control" name="location_delete" id="location_delete">
                                <div class="col-md-12 text-center">
                                    <div id="DataDeleted"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="Submit" class="btn btn-danger" id="DeleteLocation">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VIEW MODAL -->

            <div class="modal fade" id="view-pmvic" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <h4 class="mb-15">
                                <i class="fa fa-info-circle"> </i> PMVIC VIEW RECORD
                            </h4>
                            <div id="logo">

                            </div>
                            <div id="name">

                            </div>
                            <div id="address">

                            </div>
                            <div id="owner">

                            </div>
                            <div id="status">

                            </div>
                            <div id="start-date">

                            </div>
                            </br>
                            <button type="button" class="btn btn-dark" data-dismiss="modal">
                                BACK
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <?php include('../../backend/layout/inc/footer.php'); ?>

            <script>
                $(document).ready(function() {

                    let locationData = $('#pmvic_data').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "scrollCollapse": true,
                        "autoWidth": false,
                        "responsive": true,
                        "order": [],
                        "ajax": {
                            url: "../../../private/controller/location/process-location.php",
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

                    $(document).on('click', '#InsertPmvicLocation', function() {
                        event.preventDefault();
                        let form = $('#formPmvic')[0];
                        let data = new FormData(form);

                        checkUserInputs(data);

                        if (data.get('pmvicName') != '' && data.get('pmvicLocation') != '') {
                            $.ajax({
                                type: "POST",
                                url: "../../../private/controller/location/insert-location.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                cache: false,
                                async: false,
                                beforeSend: function() {
                                    $('#InsertPmvicLocation').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                    $('#InsertPmvicLocation').attr("disabled", true);
                                    $('#InsertPmvicLocation').css({
                                        "border-radius": "50%"
                                    });
                                },
                                success: function(data) {

                                    if (data == 'true') {
                                        poUpRightCorner('success', 'Added Successfully.');
                                        locationData.ajax.reload();
                                    } else {
                                        poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                    }

                                },
                                complete: function() {

                                    $('#add-pmvic').modal('hide');
                                    $('#formPmvic').trigger("reset");
                                    $('#InsertPmvic').html('Submit');
                                    $('#InsertPmvic').attr("disabled", false);
                                    $('#InsertPmvic').css({
                                        "border-radius": "4px"
                                    });


                                },
                                error: function(data) {

                                    poUpRightCorner('error', data.statusText);
                                }
                            });

                        } else {
                            return false;
                        }
                    });


                    $(document).on('click', '.fetch-pmvic', function() {
                        event.preventDefault();

                        let edit_id = $(this).data('id');;

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/location/fetch-location.php",
                            data: {
                                'edit_id': edit_id
                            },
                            success: function(response) {
                                const data = JSON.parse(response);

                                $('#loc_id').val(data.loc_id);
                                $('#pmvicName').val(data.pmvic_name);
                                $('#pmvicLocation').val(data.location);

                                $('#edit-location').modal('show');

                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    $(document).on('click', '#UpdateLocation', function() {
                        event.preventDefault();

                        let update_id = $('#loca_id').val();

                        let form = $('#formLocationUpdate')[0];
                        let data = new FormData(form);

                        checkUserInputs(data);

                        if (data.get('pmvicName') != '' && data.get('pmvicLocation') != '') {

                            $.ajax({
                                type: "POST",
                                url: "../../../private/controller/location/insert-location.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                cache: false,
                                async: false,
                                beforeSend: function() {
                                    $('#UpdateLocation').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                    $('#UpdateLocation').attr("disabled", true);
                                    $('#UpdateLocation').css({
                                        "border-radius": "50%"
                                    });
                                },

                                success: function(data) {
                                    if (data == 'true') {
                                        poUpRightCorner('success', 'Update Successfully.');
                                        locationData.ajax.reload();
                                    } else {
                                        poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                    }
                                },
                                complete: function() {

                                    $('#edit-location').modal('hide');
                                    $('#formLocationUpdate').trigger("reset");
                                    $('#UpdateLocation').html('Submit');
                                    $('#UpdateLocation').attr("disabled", false);
                                    $('#UpdateLocation').css({
                                        "border-radius": "4px"
                                    });


                                },
                                error: function(data) {

                                    poUpRightCorner('error', data.statusText);
                                }
                            });

                        } else {
                            return false;
                        }
                    });

                    $(document).on('click', '.select-delete-pmvic', function() {
                        event.preventDefault();

                        let delete_id = $(this).data('id');

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/location/fetch-location.php",
                            data: {
                                'edit_id': delete_id
                            },
                            success: function(response) {

                                const data = JSON.parse(response);

                                $('#location_delete').val(data.loc_id);


                                $('#DataDeleted').html('<span class="text-center"><h5>Do You Want delete "' + data.pmvic_name + '"</h5></span>');

                                $('#delete-pmvic').modal('show');

                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    $(document).on('click', '#DeleteLocation', function() {
                        event.preventDefault();

                        let delete_id = $('#location_delete').val();

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/location/delete-location.php",
                            data: {
                                'delete_id': delete_id
                            },
                            beforeSend: function() {
                                $('#DeletePmvic').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                $('#DeletePmvic').attr("disabled", true);
                                $('#DeletePmvic').css({
                                    "border-radius": "50%"
                                });
                            },
                            success: function(data) {
                                if (data == 'true') {
                                    locationData.ajax.reload();
                                    poUpRightCorner('success', 'Delete Successfully');
                                } else {
                                    poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                }

                            },
                            complete: function() {

                                $('#delete-pmvic').modal('hide');
                                $('#DeletePmvic').html('Submit');
                                $('#DeletePmvic').attr("disabled", false);
                                $('#DeletePmvic').css({
                                    "border-radius": "4px"
                                });

                            },
                            error: function(data) {
                                poUpRightCorner('error', data.statusText);
                            }
                        });
                    });


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

                const showMSG = (data, domId, msg, domIdError) => {
                    if ($.trim(data.get(`${domId}`)).length == 0) {
                        $(`${domIdError}`).html(`<small class='ml-3'><span style='color:red;'> Please type ${msg}.</span></small>`);
                        setInterval(function() {
                            $(`${domIdError}`).html("");
                        }, 5000);
                    }
                }

                function checkUserInputs(data) {
                    showMSG(
                        data,
                        'pmvicName',
                        'PMVIC NAME',
                        '.error-name'
                    );

                    showMSG(
                        data,
                        'pmvicLocation',
                        'PMVIC LOCATION',
                        '.error-location'
                    );
                }
            </script>