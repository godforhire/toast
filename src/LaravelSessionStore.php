<?php

namespace godforhire\Toast;

use Illuminate\Session\Store;

class LaravelSessionStore implements SessionStore
{
    /**
     * @var Store
     */
    private $session;

    /**
     * Create a new session store instance.
     *
     * @param Store $session
     */
    function __construct(Store $session)
    {
        $this->session = $session;
    }

    /*
    * Get an item from the session.
    *
    * @param  string $key
    * @param  mixed  $default
    * @return mixed
    */
    public function get($key, $default = null)
    {
        return $this->session->get($key, $default);
    }

    /**
     * Toast a message to the session.
     *
     * @param string $name
     * @param array  $data
     */
    public function toast($name, $data)
    {
        $this->session->flash($name, $data);
    }
}