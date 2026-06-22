<p>Hi {{ $user->name }},</p>

@if($type === 'daily')
<p>You need to update your daily task today.</p>
@else
<p>You need to update your weekly task today.</p>
@endif

<p>Thank you.</p>
