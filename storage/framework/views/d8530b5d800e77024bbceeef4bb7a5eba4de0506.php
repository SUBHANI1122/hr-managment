<h3>Dear <?php echo e($birthday->first_name); ?>,</h3><br>
<p>Wishing you a magical birthday filled with wonderful surprises.</p>
<div class="row">
    <div class="col-md-6">
        <img src="<?php echo e($message->embed(public_path() . '/images/happy_birthday.jpg')); ?>" alt="Birthday Image"/>
    </div>
</div>
<?php /**PATH D:\xampp\htdocs\convextech-hrms\resources\views/email_templates/birthday_email.blade.php ENDPATH**/ ?>