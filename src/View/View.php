<?php

namespace Mvc\View;

class View
{
    public static function make($view, $params = [])
    {
        $baseContent = self::getBaseContent();

        $viewContent = self::getViewContent($view, params: $params);

        echo str_replace('{{content}}', $viewContent, $baseContent);
    }

    protected static function getBaseContent()
    {
        $view = view_path() . 'layout/main.php';
        return self::renderView($view);
    }

    protected static function getViewContent($view, $isError = false, $params = [])
    {
        $path = $isError ? view_path() . 'errors/' : view_path();

        if (str_contains($view, '.')) {
            $views = explode('.', $view);
            foreach ($views as $view) {
                if (is_dir($path . $view)) {
                    $path .= $view . '/';
                }
            }
            $view = $path . end($views) . '.php';
        } else {
            $view = $path . $view . '.php';
        }
        foreach ($params as $param => $value) {
            $$param = $value;
        }
        if (file_exists($view)) {
            if ($isError) {
                include $view;
            } else {
                return self::renderView($view);
            }
        }
    }

    protected static function renderView($view)
    {
        ob_start();
        include $view;
        return ob_get_clean();
    }

    public static function makeError($error)
    {
        self::getViewContent($error, true);
    }
}
