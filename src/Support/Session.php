<?php

namespace Mvc\Support;

class Session
{

    public function __construct()
    {
        $flashMessages = $_SESSION['flash'] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }

        $_SESSION['flash'] = $flashMessages;
    }

    /**
     * @param string $key
     * @param mixed $value
     * 
     * @return void
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param mixed $key
     * 
     * @return mixed
     */
    public function get($key): mixed
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * @param mixed $key
     * 
     * @return bool
     */
    public function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param mixed $key
     * 
     * @return void
     */
    public function remove($key): void
    {
        if ($this->has($key))
            unset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @param mixed $data
     * 
     * @return void
     */
    public function setFlash(string $key, mixed $data): void
    {
        $_SESSION['flash'][$key] = [
            'remove'    => false,
            'content'   => $data,
        ];
    }

    /**
     * @param string $key
     * 
     * @return mixed
     */
    public function getFlash(string $key): mixed
    {
        return $_SESSION['flash'][$key]['content'] ?? false;
    }

    /**
     * @param string $key
     * 
     * @return bool
     */
    public function hasFlash(string $key): bool
    {
        return isset($_SESSION['flash'][$key]);
    }

    public function __destruct()
    {
        $this->removeFlash();
    }

    /**
     * @return void
     */
    public function removeFlash(): void
    {
        $flashMessages = $_SESSION['flash'] ?? [];

        foreach ($flashMessages as $key => $flashMessage)
            if ($flashMessage['remove'])
                unset($flashMessages[$key]);

        $_SESSION['flash'] = $flashMessages;
    }
}
