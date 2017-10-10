<?php
/**
 * StupidlySimple Framework - A PHP Framework For Lazy Developers.
 *
 * Copyright (c) 2017 Fariz Luqman
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author      Fariz Luqman <fariz.fnb@gmail.com>
 * @copyright   2017 Fariz Luqman
 * @license     MIT
 *
 * @link        https://stupidlysimple.github.io/
 */

namespace Simplyfier\Http;

/**
 * Class Request.
 *
 * @since 0.5.0
 */
class Request
{
    private static $_instance = null;
    private $data = [];

    /**
     * Request constructor.
     *
     * @since 0.5.0
     */
    private function __construct()
    {
        // merge data with get, post and files
        $this->data = array_merge($_GET, $_POST, $_FILES);

        // start session to get flash variables
        if (!isset($_SESSION)) {
            session_start();
        }
        // merge data with flash variables
        if (isset($_SESSION['ss_flash_variables'])) {
            $this->data = array_merge($_SESSION['ss_flash_variables']);
            unset($_SESSION['ss_flash_variables']);
        }
    }

    /**
     * @param null $key
     *
     * @return array|mixed|null
     *
     * @since 0.5.0
     */
    public static function get($key = null)
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance->returnRequest($key);
    }

    /**
     * @param null $key
     *
     * @return array|mixed|null
     *
     * @since 0.5.0
     */
    public function returnRequest($key = null)
    {
        if ($key !== null) {
            if (!isset($this->data[$key])) {
                return;
            }

            return $this->data[$key];
        } else {
            return $this->data;
        }
    }
}
