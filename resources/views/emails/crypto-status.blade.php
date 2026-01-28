<!DOCTYPE html>
<html>
<body style="font-family: Arial">

<h2>Crypto Deposit Update</h2>

<p>Hello {{ $transaction->user->name }},</p>

<p>
Your crypto deposit of
<strong>${{ number_format($transaction->amount, 2) }}</strong>
using <strong>{{ strtoupper($transaction->crypto_type) }}</strong>
has been <strong>{{ strtoupper($transaction->status) }}</strong>.
</p>

@if($transaction->status === 'approved')
<p>Your account balance has been updated.</p>
@endif

<p>Thank you for using our platform.</p>

<hr>
<p style="font-size:12px;color:#777">
This is an automated notification.
</p>

</body>
</html>
