<?php

namespace Newsapp\Helpers;

/**
 * Class used to get and edit the request
 */
class RequestHelper
{
    /**
     * Adds the given values to the current query string and returns it
     *
     * @param array $query
     * @param array $params key-value peers to add to the query string
     * @return string
     */
    public static function addToQueryString(array $query, array $params) : string
    {
        foreach ($params as $k => $v) {
            $query[$k] = $v;
        }
        $url = '';

        foreach ($query as $k => $v) {
            $url .= "{$k}={$v}&";
        }
        return WEB_URL . '?' . trim($url, '&');
    }

    /**
     * Remove the given keys from the query string and returns it
     *
     * @param array $query
     * @param array $keys keys to remove from the query string
     * @return string
     */
    public static function removeFromQueryString(array $query, array $keys) : string
    {
        foreach ($keys as $k) {
            if (array_key_exists($k, $query)) {
                unset($query[$k]);
            }
        }

        $url = '';
        foreach ($query as $k => $v) {
            $url .= "{$k}={$v}&";
        }
        return WEB_URL . '?' . trim($url, '&');
    }
}
