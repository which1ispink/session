<?php
namespace Which1ispink\Session;

/**
 * Session wrapper class
 *
 * @author Ahmed Hassan <a.hassan.dev@gmail.com>
 */
class Session
{
    /**
     * @var string
     */
    const FLASH_MESSAGES = 'flash';

    /**
     * @var string
     */
    const FLASH_MESSAGE_VALUE = 'value';

    /**
     * @var string
     */
    const FLASH_REQUESTS_SINCE = 'requests_since';

    /**
     * Initializes the session class
     *
     * @return void
     */
    public static function init()
    {
        session_start();
        self::processFlashData();
    }

    /**
     * Sets a session variable
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Finds a session variable by key if it's set, returns false otherwise
     *
     * @param mixed $key
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    /**
     * Returns all session data
     *
     * @param bool $includeFlashMessages (optional)
     * @return array
     */
    public static function all($includeFlashMessages = false)
    {
        $sessionData = $_SESSION;
        if (! $includeFlashMessages) {
            unset($sessionData[self::FLASH_MESSAGES]);
        }
        return $sessionData;
    }

    /**
     * Checks whether a session variable is set or not
     *
     * @param mixed $key
     * @return bool
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Removes a session variable by key if it's set, returns false otherwise
     *
     * @param mixed $key
     * @return void
     */
    public static function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
        return false;
    }

    /**
     * Clears the whole session data
     *
     * @return void
     */
    public static function clear()
    {
        session_unset();
        self::addFlashSessionKey();
    }

    /**
     * Sets a flash message
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public static function addFlashMessage($key, $value)
    {
        $_SESSION[self::FLASH_MESSAGES][$key] = [
            self::FLASH_MESSAGE_VALUE => $value,
            self::FLASH_REQUESTS_SINCE => 0,
        ];
    }

    /**
     * Finds a flash message by key if it's set, returns false otherwise
     *
     * @param mixed $key
     * @return mixed
     */
    public static function getFlashMessage($key)
    {
        if (isset($_SESSION[self::FLASH_MESSAGES][$key])) {
            return $_SESSION[self::FLASH_MESSAGES][$key][self::FLASH_MESSAGE_VALUE];
        }
        return false;
    }

    /**
     * Returns all session flash messages
     *
     * @return array
     */
    public static function getAllFlashMessages()
    {
        return $_SESSION[self::FLASH_MESSAGES];
    }

    /**
     * Helper method that adds the flash empty entry to the session
     *
     * @return void
     */
    private static function addFlashSessionKey()
    {
        $_SESSION[self::FLASH_MESSAGES] = [];
    }

    /**
     * Takes care of removing old flash data at the start of the request
     *
     * @return void
     */
    private static function processFlashData()
    {
        if (isset($_SESSION[self::FLASH_MESSAGES])) {
            foreach ($_SESSION[self::FLASH_MESSAGES] as $key => $message) {
                $_SESSION[self::FLASH_MESSAGES][$key][self::FLASH_REQUESTS_SINCE]++;
                if ($_SESSION[self::FLASH_MESSAGES][$key][self::FLASH_REQUESTS_SINCE] > 1) {
                    unset($_SESSION[self::FLASH_MESSAGES][$key]);
                }
            }
        } else {
            // make sure the flash messages session entry always exists for consistency
            self::addFlashSessionKey();
        }
    }
}
