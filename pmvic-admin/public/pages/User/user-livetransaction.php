<?php
include('../../backend/layout/inc/header.php');
if ($_SESSION['userdata']['access'] != 'User') {
    echo "<script> window.location.href = '../../';</script>";
    die();
}

include('../../../private/initialize.php');
$transact   = new Transaction();
?>

<body>
    <?php include('../../backend/layout/inc/right-sidebar.php'); ?>

    <?php include('../../backend/layout/inc/left-side-bar.php'); ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div>
            <div class="min-height-200px">
                <div>
                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <div class="row">
                                <div class="col order-last"></div>
                                <div class="col">
                                    <h4 class="text-center" data-color="#3033af">LIVE TRANSACTION</h4>
                                </div>
                                <div class="col order-first">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button id="printButton" style="float: right;" class="btn btn-success mr-3"><i class="icon-copy fa fa-print" aria-hidden="true"></i> PRINT</button>
                                <div class="d-none" id="conatinerFrame"></div>
                            </div>
                        </div>


                        <div class="invoice-wrap" id="content">
                            <div class="invoice-box">
                                <div class="invoice-header">
                                    <div class="logo text-center">
                                        <div class="row mt-4">
                                            <div class="col-md-12 text-center">
                                                <img width="310px" src="../../backend/img/logo.jpg" alt="logo">
                                                <h5><strong>SYSTECH IT SOLUTION AND SERVICES CORP.</strong></h5>
                                                <h6>72 RICHMAK BLG MINDANAO AVENUE, PROJECT 6 QUEZON CITY</h6>
                                                <p>Tel No.:02-828-593-60</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row pb-10">
                                    <div class="col-md-6">
                                        <h5 class="mb-5"><span id="pmvicName"></span></h5>
                                        <p class="font-14 mb-5">
                                            <span id="pmvicAddres"></span>
                                        </p>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">

                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12 text-center">
                                        <h5>Live Transaction Today</h5>
                                    </div>
                                </div>

                                <div class="invoice-desc pb-10">
                                    <div class="invoice-desc-head clearfix">
                                        <div class="invoice-sub">VEHICLE TYPE</div>
                                        <div class="invoice-rate">AMOUNT PER UPLOAD</div>
                                        <div class="invoice-rate">NUMBER OF UPLOADS</div>
                                        <div class="invoice-subtotal">TOTAL</div>
                                    </div>
                                    <div class="invoice-desc-body">
                                        <ul id="itemList">
                                            <li class="clearfix">
                                                <div class='invoice-sub' id="vehicleType">

                                                </div>
                                                <div class='invoice-rate' id="priceUploads">

                                                </div>
                                                <div class='invoice-hours' id="numUploads">

                                                </div>
                                                <div class='invoice-subtotal' id="totalAmount">

                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="invoice-desc-footer">
                                        <div class="invoice-desc-head clearfix">
                                            <div class="invoice-sub"></div>
                                            <div class="invoice-rate"></div>
                                            <div class="invoice-subtotal">Total Uploads</div>
                                        </div>
                                        <div class="invoice-desc-body">
                                            <ul>
                                                <li class="clearfix">
                                                    <div class="invoice-sub">
                                                        <p class="font-14 mb-5">
                                                            <strong class="weight-600"></strong>
                                                        </p>
                                                        <p class="font-14 mb-5">
                                                            <strong class="weight-600"></strong>
                                                        </p>
                                                    </div>
                                                    <div class="invoice-rate font-20 weight-600"></div>
                                                    <div class="invoice-subtotal">
                                                        <span class="weight-600 font-24 text-black"><span id="totalDue">0</span></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../../backend/layout/inc/footer.php'); ?>

            <script>
                function Transact() {

                    this.fetchTransact = async () => {

                        let response = await fetch(`../../../private/controller/user-controller/transactions/process-transact.php`, {
                            method: "GET"
                        });

                        let {
                            message,
                            status
                        } = await response.json();

                        if (status == 200) {
                            message.map(e => {

                                let vehicle = JSON.parse(JSON.parse(e[2])['vehicleTpye']),
                                    price = JSON.parse(JSON.parse(e[2])['amounPerUpload'])

                                this.vehicleType(vehicle);
                                this.price(price);
                                this.stageType(e);
                                this.totalAmount(e);

                                console.log('auto refresh ruinning....');
                            })
                        } else {
                            console.log(message);
                        }
                    }
                    this.vehicleType = async (item) => {
                        let result = '';

                        item.map(e => {
                            result += `<p>${e}</p>`;
                        })
                        $('#vehicleType').html(result)
                    }

                    this.price = async (item) => {
                        let result = '';

                        item.map(e => {
                            result += `<p>${e}</p>`;
                        })
                        $('#priceUploads').html(result)
                    }

                    this.stageType = async (item) => {

                        let fromData = new FormData();
                        fromData.append('uploadCounts', JSON.stringify(item));

                        let response = await fetch("../../../private/controller/user-controller/transactions/response-data.php", {
                            method: "POST",
                            credentials: "same-origin",
                            body: fromData,
                        });

                        let {
                            message,
                            status
                        } = await response.json();

                        if (status == 200) {
                            let result = '';

                            for (let i = 0; i < message.length; i++) {
                                result += `<p>${ message[i]}</p>`;

                            }
                            $('#numUploads').html(result)
                        } else {
                            console.log(message);
                        }
                    }

                    this.totalAmount = async (item) => {

                        let fromData = new FormData();
                        fromData.append('totalAmount', JSON.stringify(item));

                        let response = await fetch("../../../private/controller/user-controller/transactions/response-data.php", {
                            method: "POST",
                            credentials: "same-origin",
                            body: fromData,
                        });

                        let {
                            message,
                            status
                        } = await response.json();

                        if (status == 200) {
                            let result = '',
                                totalAmount = 0;

                            for (let i = 0; i < message.length; i++) {
                                result += `<p>${ message[i]}</p>`;

                                totalAmount += parseInt(message[i]);
                            }
                            $('#totalDue').html(totalAmount)
                            $('#totalAmount').html(result)
                        } else {
                            console.log(message);
                        }
                    }

                    this.goPrint = () => {
                        printButton.onclick = () => {
                            var contentToPrint = $("#content").html();
                            var iframe = $("<iframe>");

                            $("#conatinerFrame").append(iframe);

                            var iframeDoc =
                                iframe[0].contentDocument || iframe[0].contentWindow.document;

                            iframeDoc.write(`
                            <html>
                            <head>
                                <link rel="stylesheet" type="text/css" href="../../backend/vendors/styles/core.css" />
                                <link
                                    rel="stylesheet"
                                    type="text/css"
                                    href="../../backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css"
                                />
                                <link
                                    rel="stylesheet"
                                    type="text/css"
                                    href="../../backend/src/plugins/datatables/css/responsive.bootstrap4.min.css"
                                />
                                <link rel="stylesheet" type="text/css" href="../../backend/vendors/styles/style.css" />
                            </head>
                            <body>
                        `);

                            iframeDoc.write(contentToPrint);
                            iframeDoc.write(`</body></html>`);
                            iframeDoc.close();

                            iframe[0].contentWindow.print();
                        }
                    }

                    this.loadData = () => {
                        let spinner = `<div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                        </div>`;

                        $('#priceUploads').html(spinner)
                        $('#vehicleType').html(spinner)
                        $('#numUploads').html(spinner)
                        $('#totalAmount').html(spinner)

                        
                        setTimeout(() => {
                            $('.spinner-border').hide();
                            $('#priceUploads').html('-')
                            $('#vehicleType').html('-')
                            $('#numUploads').html('-')
                            $('#totalAmount').html('-')
                        }, 1000);
                    }
                }

                $(document).ready(function() {

                    let obj = new Transact();
                    obj.loadData();
                    obj.goPrint();
                    setInterval(() => {
                        obj.fetchTransact();
                    }, 1000);

                });
            </script>