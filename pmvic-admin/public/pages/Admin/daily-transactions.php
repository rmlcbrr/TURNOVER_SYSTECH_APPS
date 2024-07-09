<?php include('../../backend/layout/inc/header.php');
if ($_SESSION['userdata']['access'] != 'Administrator') {
    echo "<script> window.location.href = '../../';</script>";
    die();
}
?>

<title>LIVE TRANSACTIONS</title>

<body>
    <?php include('../../backend/layout/inc/right-sidebar.php'); ?>
    <?php include('../../backend/layout/inc/left-side-bar.php'); ?>
    <style>
        .odd,
        .even {
            padding: 50%;
        }
    </style>
    <?php include('../../../private/initialize.php');

    $get_pmvic_name = new Center();
    $pmvic_name = $get_pmvic_name->get_Center_Name();
    ?>

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

                                </div>
                                <div class="col">
                                    <h4 class="text-center" data-color="#3033af">PMVIC LIVE TRANSACTIONS</h4>
                                </div>
                                <div class="col order-first">
                                    <button type="button" class="btn" data-toggle="modal" data-target="#add-transact" data-bgcolor="#007bb5" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(0, 123, 181);">
                                        <i class="bi bi-plus-circle"></i> ADD LIVE TRANSACTIONS
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pb-20">
                            <table class="data-table table stripe hover nowrap" id="transact_data">
                                <thead>
                                    <tr>
                                        <th class="table-plus datatable-nosort">ID</th>
                                        <th>PMVIC Name</th>
                                        <th>Vehicle Type</th>
                                        <th>Amount Per Upload</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Simple Datatable End -->
                </div>
            </div>

            <!-- ADD -->
            <div class="modal fade bs-example-modal-lg" id="add-transact" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">
                                ADD LIVE TRANSACTIONS
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formTransactionAdd" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="col-md-12 p-0">
                                    <div class="col-md-12 form_field_outer p-0">
                                        <div class="row form_field_outer_row">
                                            <div class="form-group col-md-3">
                                                <small>Select PMVIC Center</small>
                                                <select name="pmvic_id" class="form-control" id="pmvicSelect" required>
                                                    <option value="" class="form-control">Select Center</option>
                                                    <?php foreach ($pmvic_name as $row) : ?>
                                                        <option value="<?= $row['pmvic_name'] ?>" class="form-control"><?= $row['pmvic_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please enter PMVIC Center.
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <small>Vehicle Type</small>
                                                <input type="text" class="form-control disabled-input" name="vehicleTpye[]" placeholder="Enter Vehicle Tpye" required disabled>
                                                <div class="invalid-feedback">
                                                    Please enter Vehicle Type.
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <small>Stage Type</small>
                                                <input type="text" class="form-control disabled-input" name="stageType[]" placeholder="Enter Stage Type" required disabled>
                                                <div class="invalid-feedback">
                                                    Please enter Stage Type.
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <small>Amount Per Upload</small>
                                                <input type="number" class="form-control disabled-input" name="amounPerUpload[]" placeholder="Enter Amount Per Upload" required disabled>
                                                <div class="invalid-feedback">
                                                    Please enter Amount Per Upload.
                                                </div>
                                            </div>
                                            <div class="form-group col-md-1 add_del_btn_outer d-flex justify-content-center align-items-center">

                                                <button type="button" class="btn_round btn btn-sm add_new_frm_field_btn mt-2 disabled-input" title="Copy or clone this row" disabled>
                                                    <i class="fa fa-plus"></i>
                                                </button>

                                                <button type="button" class="btn_round btn btn-sm remove_node_btn_frm_field mt-2" disabled>
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ADD MODAL -->

            <!-- UPDATE MODAL -->
            <div class="modal fade bs-example-modal-lg" id="edit-transact" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">
                                UPDATE LIVE TRANSACTIONS
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="formTransactionUpdate" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="col-md-12 p-0">
                                    <div class="col-md-12 form_field_outer_edit p-0 form_field_outer">

                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- UPDATE MODAL -->

            <!-- DELETE MODAL -->

            <div class="modal fade " id="delete-user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="myLargeModalLabel">
                                DELETE LIVE TRANSACTIONS RECORD
                            </h6>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" class="form-control" name="userIDDeleted" id="userIDDeleted">
                                <div class="col-md-12 text-center">
                                    <div id="DataDeleted"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="Submit" class="btn btn-danger" id="DeleteUser">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../../backend/layout/inc/footer.php'); ?>
            <script>
                $(document).ready(function() {

                    let userData = $('#transact_data').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "scrollCollapse": true,
                        "autoWidth": false,
                        "responsive": true,
                        "order": [],
                        "ajax": {
                            url: "../../../private/controller/transactions/process-transact.php",
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

                    //save data
                    $('#formTransactionAdd').submit(function(e) {
                        event.preventDefault();

                        //cehck inputs
                        let isValid = true;
                        $(this).find('[required]').each(function() {
                            if (!$(this).val()) {
                                isValid = false;
                                $(this).addClass('is-invalid');
                            } else {
                                $(this).removeClass('is-invalid');
                            }
                        });

                        if (isValid) {
                            let formData = $(this).serialize();

                            $.ajax({
                                type: 'POST',
                                url: '../../../private/controller/transactions/save.php',
                                data: formData,
                                beforeSend: function() {
                                    $('#InsertUser').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                    $('#InsertUser').attr("disabled", true);
                                    $('#InsertUser').css({
                                        "border-radius": "50%"
                                    });
                                },
                                success: function(response) {

                                    console.log(response)

                                    if (response == '1') {

                                        poUpRightCorner('success', 'Success save data.');

                                        $('#add-transact').modal('hide');

                                        userData.ajax.reload();
                                        $('#formTransactionAdd')[0].reset();

                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1000);

                                    } else if (response == 'duplicate') {

                                        poUpRightCorner('warning', 'Duplicate save data.');
                                        userData.ajax.reload();
                                        return;

                                    } else {
                                        console.log(response)
                                        poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                    }
                                },
                                error: function(error) {
                                    poUpRightCorner('error', error.statusText);
                                }
                            });
                        }
                    });

                    $(document).on('click', '.fetch-transact', function() {
                        event.preventDefault();

                        let edit_id = $(this).data('id');

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/transactions/fetch-transact.php",
                            data: {
                                'edit_id': edit_id
                            },
                            beforeSend: function() {
                                //clearSelected();
                            },
                            success: function(response) {
                                const data = JSON.parse(response);
                                let i = 0;

                                document.querySelector('.form_field_outer_edit').innerHTML = '';

                                JSON.parse(JSON.parse(data[2])['vehicleTpye']).forEach(el => {

                                    let stageType = JSON.parse(JSON.parse(data[2])['stageType']),
                                        amounPerUpload = JSON.parse(JSON.parse(data[2])['amounPerUpload']);

                                    $(".form_field_outer_edit").append(`
                                        <div class="row form_field_outer_row">
                                            <div class="form-group col-md-4">
                                                <small>Vehicle Type</small>
                                                <input type="text" class="form-control" value="${el}" name="vehicleTpye[]" placeholder="Enter Vehicle Tpye" required>
                                                <div class="invalid-feedback">
                                                    Please enter Vehicle Type.
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <small>Stage Type</small>
                                                <input type="text" class="form-control" value="${stageType[i]}" name="stageType[]" placeholder="Enter Stage Type" required>
                                                <div class="invalid-feedback">
                                                    Please enter Stage Type.
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <small>Amount Per Upload</small>
                                                <input type="number" class="form-control" value="${amounPerUpload[i]}" name="amounPerUpload[]" placeholder="Enter Amount Per Upload" required>
                                                <div class="invalid-feedback">
                                                    Please enter Amount Per Upload.
                                                </div>
                                            </div>
                                            <div class="form-group col-md-1 add_del_btn_outer d-flex justify-content-center align-items-center">

                                                <button type="button" class="btn_round btn btn-sm add_new_frm_field_btn mt-2 disabled-input" title="Copy or clone this row">
                                                    <i class="fa fa-plus"></i>
                                                </button>

                                                <button type="button" class="btn_round btn btn-sm remove_node_btn_frm_field mt-2">
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <input type="hidden" value="${data[0]}" name="id">
                                    `);
                                    i++;
                                });

                                $('#edit-transact').modal('show');
                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    $('#formTransactionUpdate').submit(function(e) {
                        event.preventDefault();

                        //cehck inputs
                        let isValid = true;
                        $(this).find('[required]').each(function() {
                            if (!$(this).val()) {
                                isValid = false;
                                $(this).addClass('is-invalid');
                            } else {
                                $(this).removeClass('is-invalid');
                            }
                        });

                        if (isValid) {
                            let formData = $(this).serialize();

                            $.ajax({
                                type: "POST",
                                url: "../../../private/controller/transactions/update-transact.php",
                                data: formData,
                                beforeSend: function() {
                                    $('#UpdateUser').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                    $('#UpdateUser').attr("disabled", true);
                                    $('#UpdateUser').css({
                                        "border-radius": "50%"
                                    });
                                },

                                success: function(response) {

                                    if (response == '1') {
                                        poUpRightCorner('success', 'Update Successfully.');
                                        userData.ajax.reload();

                                        $('#edit-transact').modal('hide');
                                        userData.ajax.reload();
                                        $('#formTransactionUpdate')[0].reset();

                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1000);

                                    } else {
                                        poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                    }

                                },
                                complete: function() {

                                    $('#edit-user').modal('hide');
                                    $('#formUserEdit').trigger("reset");
                                    $('#UpdateUser').html('Submit');
                                    $('#UpdateUser').attr("disabled", false);
                                    $('#UpdateUser').css({
                                        "border-radius": "4px"
                                    });
                                },
                                error: function(data) {

                                    poUpRightCorner('error', data.statusText);

                                }
                            });

                        }
                    });


                    $(document).on('click', '.select-delete-transact', function() {
                        event.preventDefault();

                        let delete_id = $(this).data('id');

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/transactions/fetch-transact.php",
                            data: {
                                'edit_id': delete_id
                            },
                            success: function(response) {

                                const data = JSON.parse(response);

                                $('#userIDDeleted').val(data.transact_id);
                                $('#DataDeleted').html('<span class="text-center"><h5>Do You Want delete "' + data.pmvic_name + '"</h5></span>');

                                $('#delete-user').modal('show');

                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });

                    $(document).on('click', '#DeleteUser', function() {
                        event.preventDefault();

                        let delete_id = $('#userIDDeleted').val();

                        $.ajax({
                            method: "POST",
                            url: "../../../private/controller/transactions/delete-transact.php",
                            data: {
                                'delete_id': delete_id
                            },
                            beforeSend: function() {
                                $('#DeleteUser').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                $('#DeleteUser').attr("disabled", true);
                                $('#DeleteUser').css({
                                    "border-radius": "50%"
                                });
                            },
                            success: function(data) {
                                if (data == 'true') {
                                    userData.ajax.reload();
                                    poUpRightCorner('success', 'Delete Successfully');
                                } else {
                                    poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                }

                            },
                            complete: function() {

                                $('#delete-user').modal('hide');
                                $('#DeleteUser').html('Submit');
                                $('#DeleteUser').attr("disabled", false);
                                $('#DeleteUser').css({
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

                function checkUserInputs(data) {
                    if ($.trim(data.get('pmvic')).length == 0) {
                        $('.error-pmvic').html("<small class='ml-3'><span style='color:red;'> Please Please Select Center.</span></small>");
                        setInterval(function() {
                            $(".error-pmvic").html("");
                        }, 5000);

                    }
                    if ($.trim(data.get('username')).length == 0) {
                        $('.error-username').html("<small class='ml-3'><span style='color:red;'> Please type Username.</span></small>");
                        setInterval(function() {
                            $(".error-username").html("");
                        }, 5000);
                    }
                    if ($.trim(data.get('password')).length == 0) {
                        $('.error-password').html("<small class='ml-3'><span style='color:red;'> Please type Password.</span></small>");
                        setInterval(function() {
                            $(".error-password").html("");
                        }, 5000);
                    }
                    if ($.trim(data.get('status')).length == 0) {
                        $('.error-status').html("<small class='ml-3'><span style='color:red;'> Please type Status.</span></small>");
                        setInterval(function() {
                            $(".error-status").html("");
                        }, 5000);
                    }


                    if ($.trim(data.get('role')).length == 0) {
                        $('.error-role').html("<small class='ml-3'><span style='color:red;'> Please Select Role.</span></small>");
                        setInterval(function() {
                            $(".error-role").html("");
                        }, 5000);
                    }
                }

                function clearSelected() {

                    $('#edit-pmvic option:selected').append('<option value="" selected ></option>');
                    $('#edit-status option:selected').html("");
                    $('#edit-role option:selected').html("");
                }

                // form validation
                (function() {
                    'use strict';
                    window.addEventListener('load', function() {
                        let forms = document.getElementsByClassName('needs-validation');
                        let validation = Array.prototype.filter.call(forms, function(form) {
                            form.addEventListener('submit', function(event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();

                // dynamic forms
                $(document).ready(function() {
                    $(document).ready(function() {
                        pmvicSelect.onchange = () => {
                            $('.disabled-input').removeAttr('disabled');
                        }

                        $("body").on("click", ".add_new_frm_field_btn", function() {
                            console.log("clicked");
                            var index =
                                $(".form_field_outer").find(".form_field_outer_row").length + 1;
                            $(".form_field_outer").append(`
                                <div class="row form_field_outer_row">
                                    <div class="form-group col-md-4">
                                        <small>Vehicle Type</small>
                                        <input type="text" class="form-control" name="vehicleTpye[]" placeholder="Enter Vehicle Tpye" required>
                                        <div class="invalid-feedback">
                                            Please enter Vehicle Type.
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <small>Stage Type</small>
                                        <input type="text" class="form-control" name="stageType[]" placeholder="Enter Stage Type" required>
                                        <div class="invalid-feedback">
                                            Please enter Stage Type.
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <small>Amount Per Upload</small>
                                        <input type="number" class="form-control" name="amounPerUpload[]" placeholder="Enter Amount Per Upload" required>
                                        <div class="invalid-feedback">
                                            Please enter Amount Per Upload.
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1 add_del_btn_outer d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn_round btn btn-sm add_new_frm_field_btn mt-2" title="Copy or clone this row">
                                            <i class="fa fa-plus"></i>
                                        </button>

                                        <button type="button" class="btn_round btn btn-sm remove_node_btn_frm_field mt-2" disabled>
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </div>
                                </div>
                            `);

                            $(".form_field_outer")
                                .find(".remove_node_btn_frm_field:not(:first)")
                                .prop("disabled", false);
                            $(".form_field_outer")
                                .find(".remove_node_btn_frm_field")
                                .first()
                                .prop("disabled", true);
                        });
                    });

                    ///======Clone method
                    $(document).ready(function() {
                        $("body").on("click", ".add_node_btn_frm_field", function(e) {
                            var index =
                                $(e.target)
                                .closest(".form_field_outer")
                                .find(".form_field_outer_row").length + 1;
                            var cloned_el = $(e.target)
                                .closest(".form_field_outer_row")
                                .clone(true);

                            $(e.target)
                                .closest(".form_field_outer")
                                .last()
                                .append(cloned_el)
                                .find(".remove_node_btn_frm_field:not(:first)")
                                .prop("disabled", false);

                            $(e.target)
                                .closest(".form_field_outer")
                                .find(".remove_node_btn_frm_field")
                                .first()
                                .prop("disabled", true);

                            //change id
                            $(e.target)
                                .closest(".form_field_outer")
                                .find(".form_field_outer_row")
                                .last()
                                .find("input[type='text']")
                                .attr("id", "mobileb_no_" + index);

                            $(e.target)
                                .closest(".form_field_outer")
                                .find(".form_field_outer_row")
                                .last()
                                .find("select")
                                .attr("id", "no_type_" + index);

                            console.log(cloned_el);
                            //count++;
                        });
                    });

                    $(document).ready(function() {
                        //===== delete the form fieed row
                        $("body").on("click", ".remove_node_btn_frm_field", function() {
                            $(this).closest(".form_field_outer_row").remove();
                            console.log("success");
                        });
                    });
                });
            </script>