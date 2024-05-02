<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('CRM')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('Modules/Lead/Resources/assets/css/main.css')); ?>" />

<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('Modules/Lead/Resources/assets/js/main.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script>
        <?php if($calenderTasks): ?>
            (function () {
                var etitle;
                var etype;
                var etypeclass;
                var calendar = new FullCalendar.Calendar(document.getElementById('event_calendar'), {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridDay,timeGridWeek,dayGridMonth'
                    },
                    buttonText: {
                    timeGridDay: "<?php echo e(__('Day')); ?>",
                    timeGridWeek: "<?php echo e(__('Week')); ?>",
                    dayGridMonth: "<?php echo e(__('Month')); ?>"
                    },
                    themeSystem: 'bootstrap',
                    initialDate: '<?php echo e($transdate); ?>',
                    slotDuration: '00:10:00',
                    navLinks: true,
                    droppable: true,
                    selectable: true,
                    selectMirror: true,
                    editable: true,
                    dayMaxEvents: true,
                    handleWindowResize: true,
                    events: <?php echo json_encode($calenderTasks); ?>,
                });
                calendar.render();
            })();
        <?php endif; ?>

        $(document).on('click', '.fc-daygrid-event', function (e) {
            if (!$(this).hasClass('deal')) {
                e.preventDefault();
                var event = $(this);
                var title = $(this).find('.fc-event-title-container .fc-event-title').html();
                var size = 'md';
                var url = $(this).attr('href');
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);

                $.ajax({
                    url: url,
                    success: function (data) {
                        $('#commonModal .body').html(data);
                        $("#commonModal").modal('show');
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        toastrs('Error', data.error, 'error')
                    }
                });
            }
        });
    </script>

    <script>
        <?php if(\Auth::user()->type == 'client'): ?>
        (function() {
            <?php if(!empty($dealdata['date'])): ?>
            var options = {
                chart: {
                    height: 104,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },

                series: [{
                    name: "<?php echo e(__('Won Deal by day')); ?>",
                    data:<?php echo json_encode($dealdata['deal']); ?>

                }, ],

                xaxis: {
                    categories:<?php echo json_encode($dealdata['date']); ?>,

                },
                colors: ['#6fd943','#2633cb'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                yaxis: {
                    tickAmount: 3,
                }

            };

            <?php endif; ?>
            var chart = new ApexCharts(document.querySelector("#deal_data"), options);
            chart.render();
        })();
        <?php endif; ?>
    </script>

    <script>
        (function() {
            <?php if(!empty($chartcall['date'])): ?>
            var options = {
                chart: {
                    height: 104,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },

                series: [{
                    name: "<?php echo e(__('Deal calls by day')); ?>",
                    data:<?php echo json_encode($chartcall['dealcall']); ?>

                }, ],

                xaxis: {
                    categories:<?php echo json_encode($chartcall['date']); ?>,

                },
                colors: ['#6fd943','#2633cb'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                yaxis: {
                    tickAmount: 3,
                }

            };

            <?php endif; ?>
            var chart = new ApexCharts(document.querySelector("#callchart"), options);
            chart.render();
        })();
    </script>


    <script>
        var WorkedHoursChart = (function () {
            var $chart = $('#deal_stage');

            function init($this) {
                var options = {
                    chart: {
                        height: 270,
                        type: 'bar',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false
                        },
                        shadow: {
                            enabled: false,
                        },

                    },
                    plotOptions: {
                bar: {
                    columnWidth: '30%',
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
                    stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
                    series: [{
                        name: 'Platform',
                        data: <?php echo json_encode($dealStageData); ?>,
                    }],
                    xaxis: {
                        labels: {
                            // format: 'MMM',
                            style: {
                                colors: '#293240',
                                fontSize: '12px',
                                fontFamily: "sans-serif",
                                cssClass: 'apexcharts-xaxis-label',
                            },
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: true,
                            borderType: 'solid',
                            color: '#f2f2f2',
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        },
                        title: {
                            text: 'Platform'
                        },
                        categories: <?php echo json_encode($dealStageName); ?>,
                    },
                    yaxis: {
                        labels: {
                            style: {
                                color: '#f2f2f2',
                                fontSize: '12px',
                                fontFamily: "Open Sans",
                            },
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: true,
                            borderType: 'solid',
                            color: '#f2f2f2',
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        }
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1

                    },
                    markers: {
                        size: 4,
                        opacity: 0.7,
                        strokeColor: "#000",
                        strokeWidth: 3,
                        hover: {
                            size: 7,
                        }
                    },
                    grid: {
                        borderColor: '#f2f2f2',
                        strokeDashArray: 5,
                    },
                    dataLabels: {
                        enabled: false
                    }
                }
                // Get data from data attributes
                var dataset = $this.data().dataset,
                    labels = $this.data().labels,
                    color = $this.data().color,
                    height = $this.data().height,
                    type = $this.data().type;

                // Init chart
                var chart = new ApexCharts($this[0], options);
                // Draw chart
                setTimeout(function () {
                    chart.render();
                }, 300);
            }

            // Events
            if ($chart.length) {
                $chart.each(function () {
                    init($(this));
                });
            }
        })();
    </script>

    <script>
        var today = new Date()
        var curHr = today.getHours()
        var target = document.getElementById("greetings");

        if (curHr < 12) {
            target.innerHTML = "<?php echo e(__('Good Morning,')); ?>";
        } else if (curHr < 17) {
            target.innerHTML = "<?php echo e(__('Good Afternoon,')); ?>";
        } else {
            target.innerHTML = "<?php echo e(__('Good Evening,')); ?>";
        }
    </script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('Modules/Lead/Resources/assets/css/custom.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>


    <div class="row">

            <?php
            $class = '';
            if(count($arrCount) < 3)
            {
                $class = 'col-lg-4 col-md-4';
            }
            else
            {
                $class = 'col-lg-3 col-md-3';
            }
            ?>

            <div class="col-xxl-7">
                <div class="row">
                        <div class="<?php echo e($class); ?> col-6">
                        <div class="card dash1-card">
                            <div class="card-body mb-2">
                                <div class="theme-avtar bg-danger">
                                    <i class="ti ti-home"></i>
                                </div>
                                <p class="text-muted text-m mt-4 mb-4" id="greetings"></p>
                                <h5 class="mb-0"><?php echo e($workspace->name); ?></h5>
                            </div>
                        </div>
                        </div>

                    <?php if(isset($arrCount['client'])): ?>
                        <div class="<?php echo e($class); ?> col-6">
                        <div class="card dash1-card">
                            <div class="card-body mb-2">
                                <div class="theme-avtar bg-success">
                                    <i class="ti ti-user"></i>
                                </div>
                                <p class="text-muted text-m mt-4 mb-4"><?php echo e(__('Total Client')); ?></p>
                                <h3 class="mb-0"><?php echo e($arrCount['client']); ?></h3>
                            </div>
                        </div>
                        </div>
                    <?php endif; ?>


                    <?php if(isset($arrCount['user'])): ?>
                        <div class="<?php echo e($class); ?> col-6">
                            <div class="card dash1-card">
                                <div class="card-body mb-2">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-users"></i>
                                    </div>
                                    <p class="text-muted text-m mt-4 mb-4"><?php echo e(__('Total User')); ?></p>
                                    <h3 class="mb-0"><?php echo e($arrCount['user']); ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($arrCount['deal'])): ?>
                        <div class="<?php echo e($class); ?> col-6">
                            <div class="card dash1-card">
                                <div class="card-body mb-2">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-rocket"></i>
                                    </div>
                                    <p class="text-muted text-m mt-4 mb-4"><?php echo e(__('Total Deal')); ?></p>
                                    <h3 class="mb-0"><?php echo e($arrCount['deal']); ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($arrCount['task'])): ?>
                        <div class="<?php echo e($class); ?> col-6">
                            <div class="card dash1-card">
                                <div class="card-body mb-2">
                                    <div class="theme-avtar bg-danger">
                                        <i class="ti ti-subtask"></i>
                                    </div>
                                    <p class="text-muted text-m mt-4 mb-4"><?php echo e(__('Total Task')); ?></p>
                                    <h3 class="mb-0"><?php echo e($arrCount['task']); ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>


                <div class="card top-card ">
                    <div class="card-header">
                        <h5><?php echo e(__('Recently created deals')); ?></h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Deal Name')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                        <th><?php echo e(__('Created At')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($deal->name); ?></td>
                                            <td><?php echo e($deal->stage->name); ?></td>
                                            <td><?php echo e($deal->created_at); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <?php if($calenderTasks): ?>
                <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Calendar')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="w-100" id='event_calendar'></div>
                        </div>
                    </div>

                <?php endif; ?>
            </div>

            <div class="col-xxl-5">

                <?php if(!empty($dealdata)): ?>
                    <?php if(\Auth::user()->type == 'client'): ?>
                        <div class="card">
                            <div class="card-header ">
                                <?php if(\Auth::user()->type != 'super admin'): ?>
                                <h5><?php echo e(__('Won Deals by day')); ?></h5>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-2">
                                <div id="deal_data" data-color="primary"  data-height="230">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(!empty($chartcall)): ?>
                        <div class="card">
                            <div class="card-header ">
                                <?php if(\Auth::user()->type != 'super admin'): ?>
                                <h5><?php echo e(__('Deal calls by day')); ?></h5>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-2">
                                <div id="callchart" data-color="primary"  data-height="230"></div>
                            </div>
                        </div>
                <?php endif; ?>
                <?php if(!empty($dealStageData)): ?>
                    <?php if(\Auth::user()->type == 'company'): ?>
                    <div class="card">
                        <div class="card-header ">
                            <h5><?php echo e(__('Deals by stage')); ?></h5>
                        </div>
                        <div class="card-body p-2">
                            <div id="deal_stage" data-color="primary"  data-height="230"></div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('Recently modified deals')); ?></h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Deal Name')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                        <th><?php echo e(__('Updated At')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($deal->name); ?></td>
                                            <td><?php echo e($deal->stage->name); ?></td>
                                            <td><?php echo e($deal->updated_at); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/Modules/Lead/Resources/views/index.blade.php ENDPATH**/ ?>