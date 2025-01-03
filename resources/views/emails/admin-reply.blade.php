<!DOCTYPE html>
<html>
<head>
    <title>Response to Your Message</title>
</head>
<body>
    <p>Dear {{ $name }},</p>

    <p>Thank you for contacting us. Here's our response to your inquiry:</p>

    <div style="padding: 20px; background: #f5f5f5; margin: 20px 0;">
        {!! nl2br(e($replyContent)) !!}
    </div>

    <p><strong>Your original message:</strong></p>
    <div style="padding: 20px; background: #f5f5f5; margin: 20px 0;">
        <p><strong>Subject: </strong> {{ $subject }}</p>
        <p>{!! nl2br(e($replyContent)) !!}</p>
    </div>

    <p>Best regards,<br>
    {{ config('app.name') }} Support Team</p>
</div>
</body>
</html>
