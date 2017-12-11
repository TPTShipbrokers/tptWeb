<?php

use yii\helpers\Url;

$role_colors = $this->context->module->params["role_colors"];
$status_colors = $this->context->module->params["status_colors"];

$get = Yii::$app->request->get();
$filter = isset($get['filter']) ? $get['filter'] : '';

?>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Operations
    <small>operations & statistics</small>
</h3>
<!-- END PAGE TITLE-->


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="caption-subject font-red-sunglo bold uppercase block pull-left"
                      style="padding: 5px 15px 5px 0; font-size: 16px"><b>Operations</b></span>

                <div class="pull-left hide-print">
                    <a href="<?= Url::toRoute('operations/create') ?>" class=" btn red btn-sm"><i
                                class="fa fa-plus"></i> Start New Operation</a>
                </div>

                <div class="pull-right hide-print">
                    <div class="btn-group">
                        <a href="" class="btn red btn-circle btn-sm dropdown-toggle" data-toggle="dropdown"
                           data-hover="dropdown" data-close-others="true" aria-expanded="false"
                           style="padding: 7px 25px; margin-top: 2px;">
                            Filter
                            <span class="fa fa-angle-down"> </span>
                        </a>
                        <br><br>
                        <ul class="dropdown-menu pull-right">
                            <li class="<?= !$filter ? 'active' : '' ?>">
                                <a href="<?= Url::toRoute('operations/') ?>">
                                    All
                                </a>
                            </li>
                            <li class="<?= $filter == 'past' ? 'active' : '' ?>">
                                <a href="<?= Url::toRoute('operations/index/past') ?>">
                                    Past
                                </a>
                            </li>

                            <li class="<?= $filter == 'ongoing' ? 'active' : '' ?>">
                                <a href="<?= Url::toRoute('operations/index/ongoing') ?>">
                                    Ongoing
                                </a>
                            </li>

                        </ul>
                    </div>
                    <a href="#" class="export btn btn-success btn-sm"><i class="fa fa-bars"></i> Export Table Data into
                        CSV</a>
                    <div class="btn-group info">
                        <button class="btn btn-success btn-sm" onclick="windowPrint()"><i class="fa fa-print"></i> Print
                        </button>

                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">


                <br>

                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover table-advance" id="dataTableUsers">
                        <thead>
                        <tr>
                            <th>Reference ID</th>
                            <th>Operation</th>
                            <th>Client</th>
                            <th><i class="fa fa-map-marker"></i>&nbsp;Location</th>
                            <th><i class="fa fa-clock"></i>Start Time</th>
                            <th><i class="fa fa-clock"></i>End Time</th>
                            <th><i class="fa fa-flag"></i>Status</th>
                            <th><i class="fa fa-o-pdf"></i>Report</th>
                            <th><i class="fa fa-chart"></i>Invoice</th>
                            <th class="hide-print"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data["operations"] as $operation): ?>
                            <tr class="odd" id="row<?= $operation['operation_id'] ?>">
                                <td><?= $operation['reference_id'] ?></td>
                                <td>
                                    <div class="well">
                                        <b>
                                            <?= $operation['discharging_ship']['name'] . ' - ' . $operation['receiving_ship']['name'] ?>
                                        </b>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= Url::toRoute('users/view/' . $operation['user']['user_id']) ?>"
                                       target="_blank">
                                        <?= $operation['user']['first_name'] . ' ' . $operation['user']['last_name'] ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?= Url::toRoute('locations/view/' . $operation['location']['location_id']) ?>"
                                       target="_blank">
                                        <?= $operation['location']['title'] ?>
                                    </a>
                                </td>
                                <td><span class="date"><?= date('d M, Y', strtotime($operation['start_time'])) ?></span>
                                </td>
                                <td>

                                    <?= $operation['end_time'] ? '<span class="date">' . date('d M, Y', strtotime($operation['end_time'])) . '</span>' : '<span class="label label-danger">ongoing</span> ' ?></td>
                                <td>
                                    <?php if ($operation['status']): ?>
                                        <span class="label <?= $operation['end_time'] ? 'label-success' : 'label-default' ?>"><?= $operation['status']['description'] ?></span>
                                        <br>
                                        <br>
                                        <span class="date"> <?= date('d M, Y', strtotime($operation['status']['time'])) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($operation['report_id']): ?>
                                    <a class="btn btn-sm red-sunglo btn-outline"
                                       href="<?= Yii::$app->request->baseUrl . '/' . $operation['report']['file'] ?>"
                                       target="_blank">View Report Document</a>
                                    <br>
                                    <br>
                                    <a href="<?= Url::toRoute('post-operation-reports/view/' . $operation['report_id']) ?>"
                                       target="_blank">View Report Details</a></td>
                                <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (isset($operation['invoice']) && $operation['invoice']): ?>

                                        <a class="btn btn-sm grey-salsa btn-outline"
                                           href="<?= Yii::$app->request->baseUrl . '/' . $operation['invoice']['file'] ?>"
                                           target="_blank"> View Document </a>
                                        <br>
                                        <br>
                                        <a href="<?= Url::toRoute('invoices/view/' . $operation['invoice_id']) ?>"
                                           target="_blank">
                                            View Invoice Details
                                        </a>

                                    <?php else: ?>

                                        <span class="label label-danger">not ready</span>
                                        <br>
                                        <br>

                                        <a class="btn btn-sm grey-salsa btn-outline"
                                           href="<?= Url::toRoute('invoices/create/' . $operation['operation_id']) ?>"
                                           target="_blank"> Create Invoice </a>


                                    <?php endif; ?>
                                </td>


                                <td class="hide-print">
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only green"
                                           href="<?= Url::toRoute('operations/view/' . $operation['operation_id']) ?>">
                                            <i class="icon-eye" data-toggle="tooltip" data-placement="top"
                                               title="View"></i>
                                        </a>
                                        <a class="btn btn-circle btn-icon-only default"
                                           href="<?= Url::toRoute('operations/update/' . $operation['operation_id']) ?>">
                                            <i class="icon-wrench" data-toggle="tooltip" data-placement="top"
                                               title="Edit"></i>
                                        </a>

                                        <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                           href="javascript:;"
                                           data-original-title="Are you sure you want to delete and stop operation permanently?"
                                           data-id="<?= $operation['operation_id'] ?>" data-message="Operation deleted."
                                           data-errormessage="An error ocurred while tryng to delete operation and its details."
                                           data-url="<?= Url::toRoute("operations/delete") ?>" data-placement="bottom">
                                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                               title="Delete operation"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<script>


    $(document).ready(function () {


        //   initMap();


        toastr.options.closeDuration = 50;


        $('.confirmation-delete').confirmation(
            {
                container: 'body',
                btnOkClass: 'btn btn-sm btn-success',
                btnOkLabel: 'Delete ',
                btnCancelClass: 'btn btn-sm btn-danger',

                onConfirm: function () {
                    var id = $(this)[0].id;
                    var url = $(this)[0].url;
                    var message = $(this)[0].message;
                    var error_message = $(this)[0].errormessage;

                    $.post(url, {"operation_id": id},
                        function (data) {


                            if (data.result == 'success') {
                                $('#row' + id).fadeOut();
                                $('#row' + id).remove();
                                toastr.success(message);

                            } else {
                                toastr.error(data.message + '<br>' + data.data.error_description);
                            }

                        }, 'json'
                    );
                }
            });

        var table = $('#dataTableUsers').DataTable({
            responsive: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

        });


    });

    function ex() {
        var csv = $('#dataTableUsers').table2CSV({delivery: 'value'});
        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        return csvData;
    }


    $(".export").on('click', function (event) {
        // CSV
        $(this)
            .attr({
                'download': 'Operations.csv',
                'href': ex(),
                'target': '_blank'
            });
    });

    function initMap() {

        if (typeof(AmCharts) === 'undefined' || $('#dashboard_amchart_operations').size() === 0) {
            return;
        }

        // svg path for target icon
        var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
        // svg path for plane icon
        var planeSVG = "M199.944,36.46c0-20.136,16.323-36.46,36.46-36.46c16.756,0,30.724,11.368,34.99,26.766c0.497-0.026,0.965-0.148,1.469-0.148c15.137,0,27.407,12.271,27.407,27.408c0,3.692-0.753,7.204-2.076,10.418l0.011-0.001c9.384,0,16.991,7.606,16.991,16.99c0,9.383-7.606,16.991-16.991,16.991c-9.383,0-16.99-7.606-16.99-16.991c0-0.507,0.105-0.985,0.149-1.481c-2.691,0.883-5.514,1.481-8.5,1.481c-9.152,0-17.205-4.531-22.183-11.425c-4.386,1.869-9.208,2.912-14.277,2.912C216.268,72.92,199.944,56.596,199.944,36.46z M216.492,217.077h-49.937c-8.761,0-15.863,7.102-15.863,15.863v106.207l155.305-74.393l155.311,74.393V232.94c0-8.761-7.102-15.863-15.862-15.863h-49.938M395.508,201.214v-9.721c0-8.761-7.102-15.863-15.862-15.863h-38.529l-6.889-63.13h-56.455l-6.888,63.13h-38.529c-8.761,0-15.863,7.102-15.863,15.863v9.721H395.508z M306,282.345L75.247,392.877l68.331,199.338c31.721-14.751,72.487-28.507,114.275-28.507c67.151,0,121.121,31.984,192.013,48.292h11.775l75.112-219.123L306,282.345z";

        var map = AmCharts.makeChart("dashboard_amchart_operations", {
            type: "map",
            "theme": "light",
            pathToImages: "../assets/global/plugins/amcharts/ammap/images/",

            dataProvider: {
                map: "worldLow",
                linkToObject: "ongoing",
                images: [{
                    id: "ongoing",
                    color: "#009dc7",
                    svgPath: targetSVG,
                    title: "Ongoing Operations",
                    latitude: 51.5002,
                    longitude: -0.1262,
                    scale: 1.5,
                    zoomLevel: 2.74,
                    zoomLongitude: -20.1341,
                    zoomLatitude: 49.1712,

                    lines: [{
                        latitudes: [51.5002, 50.4422],
                        longitudes: [-0.1262, 30.5367]
                    }, {
                        latitudes: [51.5002, 46.9480],
                        longitudes: [-0.1262, 7.4481]
                    }, {
                        latitudes: [51.5002, 59.3328],
                        longitudes: [-0.1262, 18.0645]
                    }, {
                        latitudes: [51.5002, 40.4167],
                        longitudes: [-0.1262, -3.7033]
                    }, {
                        latitudes: [51.5002, 46.0514],
                        longitudes: [-0.1262, 14.5060]
                    }, {
                        latitudes: [51.5002, 48.2116],
                        longitudes: [-0.1262, 17.1547]
                    }, {
                        latitudes: [51.5002, 44.8048],
                        longitudes: [-0.1262, 20.4781]
                    }, {
                        latitudes: [51.5002, 55.7558],
                        longitudes: [-0.1262, 37.6176]
                    }, {
                        latitudes: [51.5002, 38.7072],
                        longitudes: [-0.1262, -9.1355]
                    }, {
                        latitudes: [51.5002, 54.6896],
                        longitudes: [-0.1262, 25.2799]
                    }, {
                        latitudes: [51.5002, 64.1353],
                        longitudes: [-0.1262, -21.8952]
                    }, {
                        latitudes: [51.5002, 40.4300],
                        longitudes: [-0.1262, -74.0000]
                    }],

                    images: [{
                        label: "Ongoing Operations",
                        svgPath: planeSVG,
                        left: 100,
                        top: 45,
                        width: 100,
                        labelShiftY: 5,
                        color: "#d93d5e",
                        labelColor: "#d93d5e",
                        labelRollOverColor: "#d93d5e",
                        labelFontSize: 20
                    }, {
                        label: "show past operations",
                        left: 106,
                        top: 70,
                        labelColor: "#009dc7",
                        labelRollOverColor: "#d93d5e",
                        labelFontSize: 11,
                        linkToObject: "past"
                    }]
                },

                    {
                        id: "past",
                        color: "#009dc7",
                        svgPath: targetSVG,
                        title: "Past Operations",
                        latitude: 51.5002,
                        longitude: -0.1262,
                        scale: 1.5,
                        zoomLevel: 4.92,
                        zoomLongitude: 15.4492,
                        zoomLatitude: 50.2631,

                        lines: [{
                            latitudes: [51.5002, 50.8371],
                            longitudes: [-0.1262, 4.3676],

                            color: "#009dc7"
                        }, {
                            latitudes: [51.5002, 59.9138],
                            longitudes: [-0.1262, 10.7387]
                        }, {
                            latitudes: [51.5002, 40.4167],
                            longitudes: [-0.1262, -3.7033]
                        }, {
                            latitudes: [51.5002, 50.0878],
                            longitudes: [-0.1262, 14.4205]
                        }, {
                            latitudes: [51.5002, 48.2116],
                            longitudes: [-0.1262, 17.1547]
                        }, {
                            latitudes: [51.5002, 44.8048],
                            longitudes: [-0.1262, 20.4781]
                        }, {
                            latitudes: [51.5002, 55.7558],
                            longitudes: [-0.1262, 37.6176]
                        }, {
                            latitudes: [551.5002, 37.9792],
                            longitudes: [-0.1262, 23.7166]
                        }, {
                            latitudes: [51.5002, 54.6896],
                            longitudes: [-0.1262, 25.2799]
                        }, {
                            latitudes: [51.5002, 51.5002],
                            longitudes: [-0.1262, -0.1262]
                        }, {
                            latitudes: [51.5002, 53.3441],
                            longitudes: [-0.1262, -6.2675]
                        }],

                        images: [{
                            label: "Past Operations",
                            svgPath: planeSVG,
                            left: 100,
                            top: 45,
                            labelShiftY: 5,
                            color: "#009dc7",
                            labelColor: "#009dc7",
                            labelRollOverColor: "#009dc7",
                            labelFontSize: 20
                        }, {
                            label: "show ongoing operations",
                            left: 106,
                            top: 70,
                            labelColor: "#009dc7",
                            labelRollOverColor: "#d93d5e",
                            labelFontSize: 11,
                            linkToObject: "ongoing"
                        }]
                    },
                    {
                        svgPath: targetSVG,
                        title: "Brussels",
                        latitude: 50.8371,
                        longitude: 4.3676
                    }, {
                        svgPath: targetSVG,
                        title: "Prague",
                        latitude: 50.0878,
                        longitude: 14.4205
                    }, {
                        svgPath: targetSVG,
                        title: "Athens",
                        latitude: 37.9792,
                        longitude: 23.7166
                    }, {
                        svgPath: targetSVG,
                        title: "Reykjavik",
                        latitude: 64.1353,
                        longitude: -21.8952
                    }, {
                        svgPath: targetSVG,
                        title: "Dublin",
                        latitude: 53.3441,
                        longitude: -6.2675
                    }, {
                        svgPath: targetSVG,
                        title: "Oslo",
                        latitude: 59.9138,
                        longitude: 10.7387
                    }, {
                        svgPath: targetSVG,
                        title: "Lisbon",
                        latitude: 38.7072,
                        longitude: -9.1355
                    }, {
                        svgPath: targetSVG,
                        title: "Moscow",
                        latitude: 55.7558,
                        longitude: 37.6176
                    }, {
                        svgPath: targetSVG,
                        title: "Belgrade",
                        latitude: 44.8048,
                        longitude: 20.4781,
                    }, {
                        svgPath: targetSVG,
                        title: "Bratislava",
                        latitude: 48.2116,
                        longitude: 17.1547
                    }, {
                        svgPath: targetSVG,
                        title: "Ljubljana",
                        latitude: 46.0514,
                        longitude: 14.5060
                    }, {
                        svgPath: targetSVG,
                        title: "Madrid",
                        latitude: 40.4167,
                        longitude: -3.7033
                    }, {
                        svgPath: targetSVG,
                        title: "Stockholm",
                        latitude: 59.3328,
                        longitude: 18.0645
                    }, {
                        svgPath: targetSVG,
                        title: "Bern",
                        latitude: 46.9480,
                        longitude: 7.4481
                    }, {
                        svgPath: targetSVG,
                        title: "Kiev",
                        latitude: 50.4422,
                        longitude: 30.5367
                    }, {
                        svgPath: targetSVG,
                        title: "Paris",
                        latitude: 48.8567,
                        longitude: 2.3510
                    }, {
                        svgPath: targetSVG,
                        title: "New York",
                        latitude: 40.43,
                        longitude: -74
                    }
                ]
            },

            zoomControl: {
                buttonFillColor: "#dddddd"
            },

            areasSettings: {
                unlistedAreasColor: "#15A892"
            },

            imagesSettings: {
                color: "#d93d5e",
                rollOverColor: "#d93d5e",
                selectedColor: "#009dc7"
            },

            linesSettings: {
                color: "#d93d5e",
                alpha: 0.4
            },


            backgroundZoomsToTop: true,
            linesAboveImages: true,

            "export": {
                "enabled": true,
                "libs": {
                    "path": "http://www.amcharts.com/lib/3/plugins/export/libs/"
                }
            }
        });


    }
</script>