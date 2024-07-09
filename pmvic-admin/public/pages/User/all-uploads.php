<?php include('../../backend/layout/inc/header.php');
if ($_SESSION['userdata']['access'] != 'User') {
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
                                    <h4 class="text-center" data-color="#3033af">ALL PMVIC DATA UPLOAD'S</h4>
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
                                        <th>PLATE</th>
                                        <th>CHASSIS</th>
                                        <th>ENGINE</th>
                                        <th>STAGE</th>
                                        <th>INSPEC. NAME</th>
                                        <th>SUCCESS LOG</th>
                                        <th>EMISSION RESULT</th>
                                        <th>DATE</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Simple Datatable End -->
                </div>
            </div>

            <?php include('../../backend/layout/inc/footer.php'); ?>

            <script>
                $(document).ready(function() {

                    $(".form-control-sm").on("input", function() {
                        customTooltip();
                        alert();
                    });
                   

                    // $(".sorting").on("click", function() {
                    //     customTooltip();
                    //     alert();
                    // });

                    const customTooltip = () => {
                        setTimeout(() => {
                            let trList = document.querySelectorAll('tr');

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
                    }
                    customTooltip();

                    let userData = $('#upload_data').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "scrollCollapse": true,
                        "autoWidth": false,
                        "responsive": true,
                        "order": [],
                        "ajax": {
                            url: "../../../private/controller/user-controller/upload/process-upload.php",
                            type: "POST"
                        },
                        "columnDefs": [{
                                "targets": "datatable-nosort",
                                "orderable": false,
                            },
                            {
                                className: "hovertooltips",
                                "targets": [8]
                            }
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

                    $('#upload_data').on('draw.dt', function () {
                        customTooltip();
                    });

                    $('#upload_data_filter input').on('keyup', function () {
                        customTooltip();
                    });



                    $(document).on('click', '.re-upload', function() {
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

                                $('#id-upload').val(data.id);

                                $('#pmvic-upload').val(data.PMVIC_CENTER);

                                $('#ref_no').val(data.INSPECTION_REF_NO);

                                $('#mvfile-upload').val(data.MV_FILE);

                                $('#plate-upload').val(data.PLATE_NUM);

                                $('#Engine').val(data.ENGINE_NUM);

                                $('#Chassis').val(data.CHASIS_NUM);

                                $('#inspector_name').val(data.INSPECTOR_USERNAME);

                                $('#id').val(data.id);

                                $('#pmvic_name').val(data.PMVIC_CENTER);

                                $('#inspection_id').val(data.INSPECTION_ID);

                                $('#re-upload').modal('show');
                            },
                            error: function(response) {
                                poUpRightCorner('error', 'Error Seleting Data');
                            }
                        });
                    });


                    $(document).on('click', '#reupload-submit', function() {
                        event.preventDefault();

                        //let update_id = $('#pmvicID').val();

                        let form = $('#formReupload')[0];
                        let data = new FormData(form);

                        checkUserInputs(data);

                        if (data.get('plate-upload') != '' && data.get('mvfile-upload') != '') {

                            $.ajax({
                                type: "POST",
                                url: "../../../private/controller/upload/update-upload.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                cache: false,
                                async: false,
                                beforeSend: function() {
                                    $('#UpdatePmvic').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                                    $('#UpdatePmvic').attr("disabled", true);
                                    $('#UpdatePmvic').css({
                                        "border-radius": "50%"
                                    });
                                },

                                success: function(data) {

                                    console.log(data);
                                    return;

                                    if (data == 'true') {
                                        poUpRightCorner('success', 'Update Successfully.');
                                        pmvicData.ajax.reload();
                                    } else {
                                        poUpRightCorner('error', 'Someting Went Wrong!!!.');
                                    }

                                },
                                complete: function() {

                                    $('#edit-pmvic').modal('hide');
                                    $('#formPmvicUpdate').trigger("reset");
                                    $('#UpdatePmvic').html('Submit');
                                    $('#UpdatePmvic').attr("disabled", false);
                                    $('#UpdatePmvic').css({
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
                            'plate-upload',
                            'Plate No.',
                            '.error-plate'
                        )

                        showMSG(
                            data,
                            'mvfile-upload',
                            'MV File No.',
                            '.error-mvfile'
                        )
                    }
                });
            </script>