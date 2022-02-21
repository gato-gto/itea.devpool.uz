<?php

namespace Dacota\Controller;

use Exception;

require_once 'config/dacota.php';

class Controller
{
    private $path;

    static function link($url, $view): array
    {
        preg_match_all('/^(\w+):(\w+)$/', $view, $class, PREG_SET_ORDER);
        if ($class) {
            list(, $className, $fnName) = $class[0];
            if ($className and $fnName) {
                $view = "new $className" . '()->' . $fnName;
            }
        }

        return [
            'url' => Controller::urlToReg($url),
            'view' => $view
        ];
    }

    static function urlToReg($url): string
    {
        $filter = function ($item) {
            $arg = '';
            preg_match_all('/{(?<arg>\w+):(\w+)}$/', $item, $matches, PREG_SET_ORDER);
            foreach ($matches as $key => $match) {
                $arg = $matches[0]['arg'] ?? "arg" . $key;
            }
            if (preg_match('/{(\w+):(?<type>str)}$/', $item)) {
                return "(?<$arg>\w+)";
            }
            if (preg_match('/{(\w+):(int)}$/', $item)) {
                return "(?<$arg>\d+)";
            }
            return $item;
        };
        $url = explode("/", $url);
        $reg = array_map($filter, $url);
        $str = implode("\/", $reg);
        return "/^$str(\/|)$/";
    }


    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->init();
    }

    private function sessionInit()
    {
        if (defined('HT_SECRET') and isset($_COOKIE['hashToken'])) {
            $ht = $_COOKIE['hashToken'];
            $local_ht = md5(HT_SECRET . $_COOKIE['HTTPSESSION']);
            if ($local_ht != $ht) {
                session_id(session_create_id());
                setcookie("hashToken", md5(HT_SECRET . session_id()));
            }
        }
        session_start();
    }

    /**
     * @throws Exception
     */
    protected function init()
    {
        $this->sessionInit();
        if (defined('APPS')) {
            return $this->findApp();
        }
        throw new Exception('No valid app');
    }


    protected function findApp()
    {
        foreach (APPS as $app) {
            $appPath = $this->findUrl($app);
            if ($appPath) {
                return $appPath;
            }
        }
        echo 'Not Found';
        return http_response_code(404);
    }

    protected function findUrl($app)
    {
        include_once $app . '/links.php';
        if (isset($links)) {
            foreach ($links as $link) {
                if ($this->isUrl($link['url'])) {
                    $args = $this->getArgs($link['url']);
                    return $this->directView($app, $link['view'], $args);
                }
            }
        }
        return null;
    }

    protected function getArgs($regexp_url): array
    {
        preg_match_all($regexp_url, $this->path, $urlArgs, PREG_SET_ORDER);
        if ($urlArgs) {
            return array_filter(
                $urlArgs[0],
                function ($key) {
                    return !is_int($key);
                },
                ARRAY_FILTER_USE_KEY
            );
        }
        return [];
    }

    protected function isUrl($regexp_url)
    {
        return preg_match($regexp_url, $this->path);
    }

    protected function directView($app, $view, $args)
    {
        include_once $app . '/views.php';
        return $view(...array_values($args));
    }
}
