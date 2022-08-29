<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header with-border">
                    <h3 class="card-title text-center"> <?php echo e(__('Date Wise Attendance')); ?> </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" id="filter_form" class="form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="row">


                                    <?php if((Auth::user()->can('view-attendance'))): ?>
                                    

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo e(trans('file.Company')); ?> *</label>
                                                <select name="company_id" id="company_id"  class="form-control selectpicker dynamic" required
                                                        data-live-search="true" data-live-search-style="contains"  data-first_name="first_name" data-last_name="last_name" data-dependent="department_name"
                                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>...'>
                                                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label><?php echo e(trans('file.Department')); ?></label>
                                            <select name="department_id" id="department_id"
                                                    class="selectpicker form-control department_wise_employees"
                                                    data-live-search="true" data-live-search-style="contains"
                                                    data-first_name="first_name" data-last_name="last_name"
                                                    title="<?php echo e(__('Selecting',['key'=>trans('file.Department')])); ?>...">
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label><?php echo e(trans('file.Employee')); ?> </label>
                                            <select name="employee_id" id="employee_id"  class="selectpicker form-control"
                                                    data-live-search="true" data-live-search-style="contains"
                                                    title='<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>...'>
                                            </select>
                                        </div>

                                    <?php else: ?>
                                        <input type="hidden" name="employee_id" id="employee_id" value="<?php echo e(Auth::user()->id); ?>"> 
                                    <?php endif; ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date"><?php echo e(__('Start Date')); ?></label>
                                            <input class="form-control month_year date"
                                                   placeholder="Select Date" readonly=""
                                                   id="start_date" name="start_date" type="text" required
                                                   value="">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date"><?php echo e(__('End Date')); ?></label>
                                            <input class="form-control month_year date"
                                                   placeholder="Select Date" readonly=""
                                                   id="end_date" name="end_date" type="text" required
                                                   value="">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-actions">
                                                <button type="submit" class="filtering btn btn-primary"><i class="fa fa-search"></i> <?php echo e(trans('file.Search')); ?>

                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="date_wise_attendance-table" class="table ">
                <thead>
                    <tr>
                        <th></th>
                        <th><?php echo e(trans('file.Employee')); ?></th>
                        <th><?php echo e(trans('file.Company')); ?></th>
                        <th><?php echo e(trans('file.Date')); ?></th>
                        <th><?php echo e(trans('file.status')); ?></th>
                        <th><?php echo e(__('Clock In')); ?></th>
                        <th><?php echo e(__('Clock Out')); ?></th>
                        <th><?php echo e(trans('file.Late')); ?></th>
                        <th><?php echo e(__('Early Leaving')); ?></th>
                        <th><?php echo e(trans('file.Overtime')); ?></th>
                        <th><?php echo e(__('Total Work')); ?></th>
                        <th><?php echo e(__('Total Rest')); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th><?php echo e(trans('file.Total')); ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </section>
    
    

    <script type="text/javascript">
        (function($) {
            "use strict";
            $(document).ready(function () {

                let date = $('.date');
                date.datepicker({
                    format: '<?php echo e(env('Date_Format_JS')); ?>',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date()
                });

            });

            fill_datatable();

            function fill_datatable(filter_start_date = '', filter_end_date = '', company_id = '', department_id = '', employee_id = '') {

                let table_table = $('#date_wise_attendance-table').DataTable({
                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?php echo e(route('date_wise_attendances.index')); ?>",
                        data: {
                            filter_start_date: filter_start_date,
                            filter_end_date: filter_end_date,
                            company_id: company_id,
                            department_id: department_id,
                            employee_id: employee_id,
                            "_token": "<?php echo e(csrf_token()); ?>"
                        }
                    },

                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'employee_name',
                            name: 'employee_name'
                        },
                        {
                            data: 'company',
                            name: 'company'
                        },
                        {
                            data: 'attendance_date',
                            name: 'attendance_date',
                        },
                        {
                            data: 'attendance_status',
                            name: 'attendance_status'
                        },
                        {
                            data: 'clock_in',
                            name: 'clock_in',
                        },
                        {
                            data: 'clock_out',
                            name: 'clock_out',
                        },
                        {
                            data: 'time_late',
                            name: 'time_late',
                        },
                        {
                            data: 'early_leaving',
                            name: 'early_leaving',
                        },
                        {
                            data: 'overtime',
                            name: 'overtime',
                        },
                        {
                            data: 'total_work',
                            name: 'total_work'
                        },
                        {
                            data: 'total_rest',
                            name: 'total_rest'
                        },
                    ],


                    "order": [],
                    'language': {
                        'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
                        "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
                        "search": '<?php echo e(trans("file.Search")); ?>',
                        'paginate': {
                            'previous': '<?php echo e(trans("file.Previous")); ?>',
                            'next': '<?php echo e(trans("file.Next")); ?>'
                        }
                    },

                    'columnDefs': [
                        {

                            "orderable": true,
                            'targets': [0, 10],
                        },
                        {
                            'render': function (data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                                }

                                return data;
                            },
                            'checkboxes': {
                                'selectRow': true,
                                'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                            },
                            'targets': [0]
                        }
                    ],


                    'select': {style: 'multi', selector: 'td:first-child'},
                    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    dom: '<"row"lfB>rtip',
                    buttons: [
                        {
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer:true
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer:true
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer:true
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                    drawCallback: function () {
                        var api = this.api();
                        for (let i = 7; i <12; i++) {
                            datatable_sum(api, i);
                        }

                    }
                });
                new $.fn.dataTable.FixedHeader(table_table);
            }

            function datatable_sum(dt_selector, columnNo) {
                var rows = dt_selector.rows().indexes();
                var rowsdataCol = dt_selector.cells( rows, columnNo, { page: 'current' } ).data();

                var totalMinutes = 0;
                for(let i=0; i<rowsdataCol.length; i++) {
                    if (rowsdataCol[i] != "---") {
                        var timeArray = rowsdataCol[i].split(":");
                        totalMinutes += parseInt(timeArray[0]*60) + parseInt(timeArray[1]);
                    }
                }
                var hours   = Math.trunc(totalMinutes/60);
                var minutes = totalMinutes % 60;

                var result  = digitCheck(hours) + ':' + digitCheck(minutes);
                $(dt_selector.column(columnNo).footer()).html(result);
            }

            function digitCheck(data){
                if (data<10) {
                    var result ='0'+  data;
                }else{
                    var result = data;
                }
                return result;
            }

            $('#filter_form').on('submit',function (e) {
                e.preventDefault();
                var filter_start_date = $('#start_date').val();
                var filter_end_date = $('#end_date').val();
                let company_id = $('#company_id').val();
                let department_id = $('#department_id').val();
                let employee_id = $('#employee_id').val();
                if (filter_start_date !== '' && filter_end_date !== '' && company_id !== '') {
                    $('#date_wise_attendance-table').DataTable().destroy();
                    fill_datatable(filter_start_date, filter_end_date, company_id, department_id, employee_id);
                } else {
                    alert('<?php echo e(__('Select Both filter option')); ?>');
                }
            });





            $('.dynamic').change(function() {
                if ($(this).val() !== '') {
                    let value = $(this).val();
                    let first_name = $(this).data('first_name');
                    let last_name = $(this).data('last_name');
                    let _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"<?php echo e(route('dynamic_employee')); ?>",
                        method:"POST",
                        data:{ value:value, _token:_token, first_name:first_name,last_name:last_name},
                        success:function(result)
                        {
                            $('select').selectpicker("destroy");
                            $('#employee_id').html(result);
                            $('select').selectpicker();

                        }
                    });
                }
            });

            $('.dynamic').change(function () {
                if ($(this).val() !== '') {
                    let value = $(this).val();
                    let dependent = $(this).data('dependent');
                    let _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "<?php echo e(route('dynamic_department')); ?>",
                        method: "POST",
                        data: {value: value, _token: _token, dependent: dependent},
                        success: function (result) {

                            $('select').selectpicker("destroy");
                            $('#department_id').html(result);
                            $('select').selectpicker();

                        }
                    });
                }
            });

            $('.department_wise_employees').change(function () {
                if ($(this).val() !== '') {
                    let value = $(this).val();
                    let first_name = $(this).data('first_name');
                    let last_name = $(this).data('last_name');
                    let _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "<?php echo e(route('dynamic_employee_department')); ?>",
                        method: "POST",
                        data: {value: value, _token: _token, first_name:first_name,last_name:last_name},
                        success: function (result) {

                            $('select').selectpicker("destroy");
                            $('#employee_id').html(result);
                            $('select').selectpicker();

                        }
                    });
                }
            });

        })(jQuery);
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\convextech-hrms\resources\views/timesheet/dateWiseAttendance/index.blade.php ENDPATH**/ ?>