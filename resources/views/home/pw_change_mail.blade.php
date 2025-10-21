<h3>Password Reset Request</h3>

<p>Click the link below to reset your password:</p>

<a href="{{ route('pw_change', ['role' => $role, 'email' => $email]) }}">
    Reset Password
</a>

<p>If you didn’t request this, just ignore this email.</p>

<hr>
<p>Thank you,<br>AgroConnect Team</p>
