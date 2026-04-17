<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif">

    <h2>New Contact Message</h2>

    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>

    <hr>

    <p><strong>Message:</strong></p>
    <p>{{ $data['message'] }}</p>

</body>
</html>
