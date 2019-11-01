@component('mail::message')
#Hello {{$user->first_name}},

<p>Here is your digest of unread notification(s).</p>
@foreach ($notifications as $notification)

<p>
    <strong>{{ $notification->action }}</strong>
</p>

<p>
    <a href="{{ $notification->url }}">
        <strong>{{ $notification->model_object['name'] }}</strong>
    </a>
</p>

<p>{{ $notification->model_object['description'] }}</p>

<small>
    Created <strong>
        {{ \Carbon\Carbon::parse($notification->model_object['created_at'])->diffForHumans() }}
    </strong>
</small>

<hr/>
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent