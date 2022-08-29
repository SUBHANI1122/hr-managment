<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?php echo e(config('app.name')); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
</head>

<style>
    h4 {
        font-size: 80%;
    }
    h5 {
        font-size: 80%;
    }
    h6 {
        font-size: 80%;
    }

    tbody {
        font-size: 80%;
        margin:0px;
        padding: 5px;
    }

    .table thead tr th, {
        border: 1px solid #000;
        font-size: 80%;
        margin:0px;
        padding: 5px;

    }
    .table tr td {
        border: 1px solid #000;
        font-size: 80%;
        margin:0px;
        padding: 5px;
    }
    #heading{
        font-size: 80%;
        color: #CE7749;
        text-align: center;
    }
    #normal-heading{
        font-size: 70%;
        color: #000
    }
    /* * { font-family: DejaVu Sans, sans-serif; } */
</style>

<body onload="window.print()">

<h5><?php echo e($company['company_name']); ?></h5>
<h6><?php echo e($company['location']['address1']); ?></h6>
<h6><?php echo e($company['location']['city']); ?>,<?php echo e($company['location']['country']['name']); ?>-<?php echo e($company['location']['zip']); ?></h6>
<h6>Phone: <?php echo e($company['contact_no']); ?>| <?php echo e(trans('file.Email')); ?>: <?php echo e($company['email']); ?></h6>
<hr>

<div class="center">
    <h5><?php echo e(trans('file.Payslip')); ?>: <?php echo e($month_year); ?></h5>
</div>
<br>
<div class="table-responsive">
    <table class="table table-bordered">
        <tbody>
        <tr>
            <td><strong class="help-split"><?php echo e(__('Employee ID')); ?>: </strong><?php echo e($user['username'] ?? ''); ?></td>
            <td><strong class="help-split"><?php echo e(__('Employee Name')); ?>: </strong><?php echo e($first_name); ?> <?php echo e($last_name); ?></td>
            <td><strong class="help-split"><?php echo e(__('Payslip NO')); ?>: </strong><?php echo e($id); ?></td>
        </tr>
        <tr>
            <td><strong class="help-split"><?php echo e(trans('file.Phone')); ?>: </strong><?php echo e($contact_no); ?></td>
            <td><strong class="help-split"><?php echo e(__('Joining Date')); ?>: </strong><?php echo e($joining_date); ?></td>
            <td><strong class="help-split"><?php echo e(__('Payslip Type')); ?>: </strong><?php echo e($payment_type); ?></td>

        </tr>
        <tr>
            <td><strong class="help-split"><?php echo e(trans('file.Company')); ?>: </strong><?php echo e($company['company_name']); ?></td>
            <td><strong class="help-split"><?php echo e(trans('file.Department')); ?>: </strong><?php echo e($department['department_name']); ?>

            </td>
            <td><strong class="help-split"><?php echo e(trans('file.Designation')); ?>: </strong><?php echo e($designation['designation_name']); ?>

            </td>
        </tr>
        </tbody>
    </table>
</div>

<hr>


<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-bordered text-center">

            <thead>
            <tr>
                <th id="heading" colspan="2"><?php echo e(trans('file.Earnings')); ?></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th id="normal-heading"><?php echo e(trans('file.Description')); ?></th>
                <th id="normal-heading"><?php echo e(trans('file.Amount')); ?></th>
            </tr>
            </thead>
            <?php
                if ($payment_type == 'Monthly')
                {
                    $total_earnings = $basic_salary;
                }
                else
                {
                    $total_earnings = $hours_amount;
                }
            ?>
            <tr>
                <?php if($payment_type == 'Monthly'): ?>
                    <td class="py-3"><?php echo e(__('Basic Salary')); ?></td>
                    <td><?php echo e($basic_salary); ?></td>
                <?php else: ?>
                    <td class="py-3"><?php echo e(__('Basic Salary')); ?> (<?php echo e(__('Total')); ?>)</td>
                    <td><?php echo e($total_earnings); ?></td>
                <?php endif; ?>
            </tr>
            <?php if($allowances): ?>
                <?php $__currentLoopData = $allowances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-3"><?php echo e($allowance['allowance_title']); ?></td>
                        <td><?php echo e($allowance['allowance_amount']); ?></td>
                    </tr>
                    <?php
                        $total_earnings = $total_earnings + $allowance['allowance_amount'] ;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($commissions): ?>
                <?php $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-3"><?php echo e($commission['commission_title']); ?></td>
                        <td><?php echo e($commission['commission_amount']); ?></td>
                    </tr>
                    <?php
                        $total_earnings = $total_earnings + $commission['commission_amount'] ;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($other_payments): ?>
                <?php $__currentLoopData = $other_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other_payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-3"><?php echo e($other_payment['other_payment_title']); ?></td>
                        <td><?php echo e($other_payment['other_payment_amount']); ?></td>
                    </tr>
                    <?php
                        $total_earnings = $total_earnings + $other_payment['other_payment_amount'] ;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($overtimes): ?>
                <?php $__currentLoopData = $overtimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overtime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-3"><?php echo e($overtime['overtime_title']); ?></td>
                        <td><?php echo e($overtime['overtime_amount']); ?></td>
                    </tr>
                    <?php
                        $total_earnings = $total_earnings + $overtime['overtime_amount'] ;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <tr>
                <td class="py-3">Total</td>
                <?php if(config('variable.currency_format') =='suffix'): ?>
                    <td id="total_earnings"><?php echo e($total_earnings); ?> <span style="font-family: DejaVu Sans; sans-serif;"><?php echo e(config('variable.currency')); ?></span></td>
                <?php else: ?>
                    <td id="total_earnings"><span style="font-family: DejaVu Sans; sans-serif;"><?php echo e(config('variable.currency')); ?></span> <?php echo e($total_earnings); ?> </td>
                <?php endif; ?>
            </tr>


        </table>
    </div>
    <!-- /.col -->
</div>

<hr>
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-bordered text-center">

            <thead>
            <tr>
                <th id="heading" colspan="2"><?php echo e(trans('file.Deductions')); ?></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th id="normal-heading"><?php echo e(trans('file.Description')); ?></th>
                <th id="normal-heading"><?php echo e(trans('file.Amount')); ?></th>
            </tr>
            </thead>

            <?php
                $total_deductions = 0;
            ?>

            <?php if($loans): ?>
                <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-3"><?php echo e($loan['loan_title']); ?></td>
                        <td><?php echo e($loan['monthly_payable']); ?></td>
                    </tr>
                    <?php
                        $total_deductions = $total_deductions + $loan['monthly_payable'] ;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($deductions): ?>
                <?php $__currentLoopData = $deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-3"><?php echo e($deduction['deduction_title']); ?></td>
                        <td><?php echo e($deduction['deduction_amount']); ?></td>
                    </tr>
                    <?php
                        $total_deductions = $total_deductions + $deduction['deduction_amount'] ;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

                <tr>
                    <td class="py-3"><?php echo e(__('Pension Amount')); ?></td>
                    <td><?php echo e($pension_amount); ?></td>
                </tr>

				<?php
                    $total_deductions = $total_deductions + $pension_amount;
                ?>



            <tr>
                <td class="py-3"><?php echo e(trans('file.Total')); ?></td>
                <?php if(config('variable.currency_format') =='suffix'): ?>
                    <td id="total_deductions"><?php echo e($total_deductions); ?> <span style="font-family: DejaVu Sans; sans-serif;"><?php echo e(config('variable.currency')); ?></span></td>
                <?php else: ?>
                    <td id="total_deductions"><span style="font-family: DejaVu Sans; sans-serif;"><?php echo e(config('variable.currency')); ?></span> <?php echo e($total_deductions); ?> </td>
                <?php endif; ?>
            </tr>


        </table>
    </div>
    <!-- /.col -->
</div>
<?php if(config('variable.currency_format') =='suffix'): ?>
    <p class="text-danger"><?php echo e(__('Total Paid')); ?> : <strong><?php echo e($net_salary); ?> <span style="font-family: DejaVu Sans; sans-serif;"><?php echo e(config('variable.currency')); ?></span></strong></p>
<?php else: ?>
    <p class="text-danger"><?php echo e(__('Total Paid')); ?> :<span style="font-family: DejaVu Sans; sans-serif;"><?php echo e(config('variable.currency')); ?></span> <strong><?php echo e($net_salary); ?></strong></p>
<?php endif; ?>


</body>
</html>
<?php /**PATH D:\xampp\htdocs\convextech-hrms\resources\views/salary/payslip/pdf.blade.php ENDPATH**/ ?>