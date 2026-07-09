<!DOCTYPE html>
<html>
<head>
<style>
    body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 20px; color: #1e293b; }
    .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-top: 6px solid #ef4444; }
    .content { padding: 40px 30px; }
    .reason-box { background-color: #fee2e2; border-radius: 6px; padding: 20px; margin: 20px 0; color: #991b1b; }
    .reason-title { font-size: 12px; text-transform: uppercase; font-weight: bold; margin-bottom: 10px; letter-spacing: 1px; color: #b91c1c; }
    .footer { background-color: #f1f5f9; padding: 20px; text-align: center; font-size: 12px; color: #64748b; }
</style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h2 style="color: #ef4444; margin-top: 0;">Registration Update</h2>
            <p>Hello <strong>{{ $user->full_name }}</strong>,</p>
            <p>We have reviewed your registration for the {{ config('app.name') }}. We regret to inform you that your account registration was not approved.</p>
            
            <div class="reason-box">
                <div class="reason-title">Reason for Rejection:</div>
                <div style="font-size: 16px;">
                    @php
                        $reasonEnum = App\Enums\RejectionReason::tryFrom($reason);
                        echo $reasonEnum ? $reasonEnum->label() : htmlspecialchars($reason);
                    @endphp
                </div>
            </div>
            
            <p style="color: #64748b; font-size: 14px;">If you believe this decision was made in error or if you need to provide additional information, please contact our support team.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
