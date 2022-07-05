<?php
/* Position toasts top right screen. Remove the last one first.
 */
$notifications = session('toast_notification', collect());
$toasts = $notifications->where('overlay', false)->toArray();
$counter = 100;
?>

@foreach ($notifications->where('overlay', true)->toArray() as $message)
    @include('toast::modal', [
        'modalClass' => 'flash-modal',
        'title'      => $message['title'],
        'body'       => $message['message'],
    ])
@endforeach

@if ($toasts)
    <div aria-live="polite" aria-atomic="true" class="position-ab">
        <div class="toast-container position-fixed top-0 end-0 mt-3 me-3">
            @foreach ($toasts as $message)
                @php
                    $text_color = ($message['level'] == 'warning') ? 'dark' : 'white';
                @endphp
                <div id="toast" class="toast hide bg-{{ $message['level'] }} text-{{ $text_color }} align-items-center p-1" role="alert" aria-live="assertive" aria-atomic="true"@if ($message['important']) data-bs-autohide="false" @else data-bs-delay="{{ $message['delay'] + ($counter -= 250) }}"@endif>
                    <div class="d-flex">
                        <div class="toast-body">
                            {!! $message['message'] !!}
                        </div>
                        <button type="button" class="btn-close btn-close-{{ $text_color }} me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{ session()->forget('toast_notification') }}