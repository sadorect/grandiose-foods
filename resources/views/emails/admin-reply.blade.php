<!DOCTYPE html>
<html>
<head>
    <title>Response from Grandiose Foods</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .header {
            background: white ; /*linear-gradient(135deg, #2e8c12 0%, #769e6c 100%);*/
            color: #2e8c12;
            padding: 10px 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 15px;
        }
        .content {
            background: #ffffff;
            padding: 10px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .message-box {
            background: #f8f9fa;
            padding: 20px;
            margin: 5px 0;
            border-left: 4px solid #4a6741;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #666;
            font-size: 0.9em;
            border-top: 1px solid #eee;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            color: #2e8c12;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2e8c12;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/grandiose_logo.png') }}" alt="{{ config('app.name') }}" class="logo">
        <h1>{{ config('app.name') }}</h1>
    </div>
    
    <div class="content">
        <h2>Hello {{ $name }},</h2>

        <p>Thank you for reaching out to us. Here's our response to your inquiry:</p>

        <div class="message-box">
            {!! nl2br(e($replyContent)) !!}
        </div>

        <div class="message-box">
            <h3>Your Original Message:</h3>
            <p><strong>Subject:</strong> {{ $subject }}</p>
            <p>{!! nl2br(e($originalMessage)) !!}</p>
        </div>

        <a href="{{ url('/') }}" class="button">Visit Our Website</a>

        <div class="footer">
            <p><strong>Best regards,</strong><br>
            The {{ config('app.name') }} Team</p>
            
            <div class="social-links">
                <a href="{{ config('services.social.facebook') }}" target="_top">Facebook</a> |
                <a href="{{ config('services.social.twitter') }}" target="_top">Twitter</a> |
                <a href="{{ config('services.social.instagram') }}" target="_top">Instagram</a>
            </div>
            
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
