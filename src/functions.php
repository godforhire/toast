<?php

if (!function_exists('toast'))
{

    /**
     * Arrange for a toast message.
     *
     * @param  string|null $message
     * @param  string      $level
     * @return \godforhire\Toast\ToastNotifier
     */
    function toast($message = null, $level = 'info')
    {
        $notifier = app('toast');

        if (!is_null($message))
        {
            return $notifier->message($message, $level);
        }

        return $notifier;
    }

}