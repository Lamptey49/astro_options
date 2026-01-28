<h2>Withdrawal Status Update</h2>

<p>Hello {{ $withdrawal->user->name ?? 'User' }},</p>

<p>Your withdrawal request of <strong>${{ $withdrawal->amount }}</strong> has been
<strong>{{ strtoupper($withdrawal->status) }}</strong>.</p>

@if($withdrawal->status === 'approved')
<p>The funds will be processed shortly.</p>
@else
<p>The amount has been refunded to your balance.</p>
@endif

<p>Thank you for trading with us.</p>
