<!DOCTYPE html>
<html>
<head>
<style>
    body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 20px; color: #1e293b; }
    .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .header { background: #10b981; padding: 30px 20px; text-align: center; color: white; }
    .content { padding: 30px; }
    .btn { display: inline-block; padding: 14px 28px; background-color: #10b981; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 20px 0; font-size: 16px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.4); }
    .footer { background-color: #f1f5f9; padding: 20px; text-align: center; font-size: 12px; color: #64748b; }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Account Approved! 🎉</h2>
        </div>
        <div class="content">
            <p>Congratulations <strong>{{ $user->full_name }}</strong>,</p>
            <p>Your account registration has been formally approved by our administration. You can now access the system.</p>
            
            <p>We've generated a secure, one-time login link to get you started immediately:</p>
            
            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="btn">Access Your Dashboard</a>
            </div>
            
            <p style="color: #64748b; font-size: 14px; text-align: center;">This specific link expires in 15 minutes.</p>
            
            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
            
            <p style="font-size: 14px;"><strong>How to log in later:</strong></p>
            <p style="font-size: 14px;">Since we use a secure, passwordless system, you will never need to remember a password. Whenever you want to log in, just visit our login page and enter your email address to receive a fresh magic link.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
