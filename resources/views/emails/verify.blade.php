<h2>Hello {{ $val['username'] }},</h2>
<p>Thank you for signing up with AgroConnect.</p>
<p>Please verify your account by clicking the link below:</p>

<p>
    <a href="{{ route('account_verify', ['username' => $val['username'], 'register_as' => $val['register_as']]) }}">
        👉 Click here to verify your account
    </a>
</p>

<p>Thank you,<br>AgroConnect Team</p>
