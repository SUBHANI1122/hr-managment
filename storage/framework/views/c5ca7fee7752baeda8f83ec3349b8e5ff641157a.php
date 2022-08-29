<?php $__env->startSection('content'); ?>


    <section>

        <div class="container">

            <?php echo e(__('There are some errors on')); ?>


        </div>

        <div class="container">

        <?php if(isset($failures)): ?>
            <div class="alert alert-danger" role="alert">
                <strong><?php echo e(trans('file.Errors')); ?>:</strong>

                <ul>
                    <?php $__currentLoopData = $failures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $failure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>Row No -<?php echo e($failure->row()); ?></li>
                        <?php $__currentLoopData = $failure->errors(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
    <?php endif; ?>

        </div>

    </section>

    <?php $__env->stopSection(); ?>





<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\convextech-hrms\resources\views/timesheet/attendance/importError.blade.php ENDPATH**/ ?>