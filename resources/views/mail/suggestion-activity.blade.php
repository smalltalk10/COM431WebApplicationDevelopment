@component('mail::message')
#Alert! A new suggestion has been made.

Please login and access the Comment Bank Admin portal to view new comment suggestion. 

@component('mail::button', ['url' => 'http://localhost/ajax-review-comments'])
Check Suggestion Activity
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
