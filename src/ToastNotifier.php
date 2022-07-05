<?php

namespace godforhire\Toast;

use Illuminate\Support\Traits\Macroable;

class ToastNotifier
{
    use Macroable;

    /**
     * The session store.
     *
     * @var SessionStore
     */
    protected $session;

    /**
     * The messages collection.
     *
     * @var \Illuminate\Support\Collection
     */
    public $messages;

    /**
     * Create a new ToastNotifier instance.
     *
     * @param SessionStore $session
     */
    function __construct(SessionStore $session)
    {
        $this->session = $session;
        $this->messages = $session->get('toast_notification', collect());
    }

    /**
     * Toast an information message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function info($message = null)
    {
        return $this->message($message, 'info');
    }

    /**
     * Toast a success message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function success($message = null)
    {
        return $this->message($message, 'success');
    }

    /**
     * Toast a warning message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function warning($message = null)
    {
        return $this->message($message, 'warning');
    }

    /**
     * Toast an error/danger message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function danger($message = null)
    {
        return $this->message($message, 'danger');
    }

    /**
     * Toast a general message.
     *
     * @param  string|null $message
     * @param  string|null $level
     * @return $this
     */
    public function message($message = null, $level = null)
    {
        // If no message was provided, we should update
        // the most recently added message.
        if (!$message)
        {
            return $this->updateLastMessage(compact('level'));
        }

        if (!$message instanceof Message)
        {
            $message = new Message(compact('message', 'level'));
        }

        $this->messages->push($message);

        return $this->toast();
    }

    /**
     * Modify the most recently added message.
     *
     * @param  array $overrides
     * @return $this
     */
    protected function updateLastMessage($overrides = [])
    {
        $this->messages->last()->update($overrides);

        return $this;
    }

    /**
     * Toast an overlay modal.
     *
     * @param  string|null $message
     * @param  string      $title
     * @return $this
     */
    public function overlay($message = null, $title = 'Notice')
    {
        if (!$message)
        {
            return $this->updateLastMessage(['title' => $title, 'overlay' => true]);
        }

        return $this->message(
            new OverlayMessage(compact('title', 'message'))
        );
    }

    /**
     * Add an "important" toast to the session.
     *
     * @return $this
     */
    public function important()
    {
        return $this->updateLastMessage(['important' => true]);
    }

    /**
     * Add a different delay to the session. Uses data-bs-delay
     *
     * @param int $delay
     * @return $this
     */
    public function delay(int $delay)
    {
        return $this->updateLastMessage(['delay' => $delay]);
    }

    /**
     * Clear all registered messages.
     *
     * @return $this
     */
    public function clear()
    {
        $this->messages = collect();

        return $this;
    }

    /**
     * Toast all messages to the session.
     */
    protected function toast()
    {
        $this->session->toast('toast_notification', $this->messages);

        return $this;
    }
}