<?php


class Router
{

    protected $rutes = [];
    public static $uri_values = [];

    public static function carregar($fitxer)
    {
        $rutes = new static;

        require $fitxer;

        return $rutes;
    }

    public function definir($rutes)
    {

        $this->rutes = $rutes;
    }


    public function direct($uri)
    {


        $uri_array = explode('/', $uri);

        foreach ($this->rutes as $route_uri => $route_file)
        {
            $route_uri_array = explode('/', $route_uri);

            if (count($uri_array) != count($route_uri_array))
                continue;

            for ($index = 0; $index < count($uri_array); $index++)
            {
                if ($uri_array[$index] == $route_uri_array[$index])
                    continue;

                if ($route_uri_array[$index] == '*')
                {
                    array_push(static::$uri_values, $uri_array[$index]);
                    continue;
                }

                continue 2;
            }

            return $route_file;
        }

        throw new Exception('No hi ha ruta Definida per aquesta URI.'. $uri_array);
    }




}