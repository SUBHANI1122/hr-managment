<?php $__env->startSection('content'); ?>


    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo e(__('Import CSV file only')); ?></h3>
                    <?php echo $__env->make('shared.flash_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                   <div id="form_result"></div>
                </div>
                <div class="card-body">
                    <p class="card-text">The first line in downloaded csv file should remain as it is. Please do not change
                        the order of columns in csv file.</p>
                    <p class="card-text">The correct column order is (Employee Email,Attendance Date, Clock In, Clock Out) and you must follow the csv file,
                        otherwise you will get an error while importing the csv file.</p>
                    <h6><a href="<?php echo e(url('sample_file/sample_attendance.csv')); ?>" class="btn btn-primary"> <i
                                    class="fa fa-download"></i> <?php echo e(__('Download sample File')); ?> </a></h6>
                    <form action="<?php echo e(route('attendances.importPost')); ?>" name="import_attendance" id="import_attendance" autocomplete="off" enctype="multipart/form-data"
                          method="post" accept-charset="utf-8">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <fieldset class="form-group">
                                        <label for="logo"><?php echo e(trans('file.Upload')); ?> <?php echo e(trans('file.File')); ?></label>
                                        <input type="file" class="form-control-file" id="file" name="file"
                                               accept=".xlsx, .xls, .csv">
                                        <small><?php echo e(__('Please select csv or excel')); ?> file (allowed file size 2MB)</small>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1">
                            <div class="form-actions box-footer">
                                <button name="import_form" type="submit" class="btn btn-primary"><i
                                            class="fa fa fa-check-square-o"></i> <?php echo e(trans('file.Save')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\convextech-hrms\resources\views/timesheet/attendance/import.blade.php ENDPATH**/ ?>