<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif">

    <h2>New Contact Message</h2>

    <p><strong>Name:</strong> <?php echo e($data['name']); ?></p>
    <p><strong>Email:</strong> <?php echo e($data['email']); ?></p>
    <p><strong>Subject:</strong> <?php echo e($data['subject']); ?></p>

    <hr>

    <p><strong>Message:</strong></p>
    <p><?php echo e($data['message']); ?></p>

</body>
</html>
<?php /**PATH /home/saingo/public_html/resources/views/emails/contact.blade.php ENDPATH**/ ?>