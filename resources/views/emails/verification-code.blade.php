<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 480px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #0b132b; padding: 24px; text-align: center; }
        .logo { font-size: 42px; font-weight: 900; }
        .logo .y { color: #00529B; }
        .logo .g { color: #F39C12; }
        .body { padding: 32px 24px; text-align: center; }
        .code { font-size: 48px; font-weight: 900; letter-spacing: 12px; color: #0b132b; background: #f0f4ff; border: 2px dashed #3b82f6; border-radius: 12px; padding: 16px 24px; display: inline-block; margin: 20px 0; }
        .note { font-size: 13px; color: #6b7280; margin-top: 16px; }
        .footer { background: #f9fafb; padding: 16px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo"><span class="y">Y</span><span class="g">G</span></div>
            <p style="color:#93c5fd; font-size:13px; margin:4px 0 0">Training and Consultancy</p>
        </div>
        <div class="body">
            <p style="color:#374151; font-size:16px;">Hello, <strong>{{ $name }}</strong>!</p>
            <p style="color:#6b7280; font-size:14px;">Use this 4-digit code to verify your email address:</p>
            <div class="code">{{ $code }}</div>
            <p class="note">This code expires in <strong>10 minutes</strong>.<br>If you didn't register, ignore this email.</p>
        </div>
        <div class="footer">YG Training and Consultancy &mdash; info@ygtraining.com</div>
    </div>
</body>
</html>
