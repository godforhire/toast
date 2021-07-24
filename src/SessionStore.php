<?php

namespace godforhire\Toast;

interface SessionStore
{
    /**
     * Toast a message to the session.
     *
     * @param string $name
     * @param array  $data
     */
    public function toast($name, $data);
}