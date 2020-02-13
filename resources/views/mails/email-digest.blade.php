@component('mail::message')
{{-- Greeting --}}

@if (! empty($greeting))
# {{ $greeting }}
@endif

{{ __("Here's what you missed:") }}
<br>
{{ __('Notifications') }}
@component('mail::table')
@foreach ($user->unreadNotifications as $notify)
@php
$mode = $notify->data['model_object'];
$noti = $notify->data['url']. '?notification_id='. $notify->id;
@endphp

| {{ $mode['name'] }} |
| - |
| [{{ $mode['description'] }}]({{ url($noti) }}) |
@endforeach
@endcomponent

@component('mail::button', ['url' => $url , 'color' => 'primary'])
{{ __('See all notifications') }}
@endcomponent

@lang('Regards'),<br>
{{ config('app.name') }}

@endcomponent