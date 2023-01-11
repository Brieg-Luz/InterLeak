<?php
namespace interleak\routeur;

use interleak\routeur\route;
use interleak\routeur\routerException;

class routeur
{
    private $routes = [];
    private $url;

    /**
     * __construct
     *
     * @param  mixed $url correspond à l'url avec laquelle on a appelé la page
     * @return void
     */

    public function __construct(string $url)
    {
        $url = preg_replace('#([?\#]{1}[\w=&]+)#', '', $url);
        $this->url = $url;
    }

    /**
     * listen
     *
     * @param  mixed $path the path of the route
     * @param  mixed $method the accepted method of the request, it can be "POST", "GET" or "POST|GET" (and vice-versa) 
     * @param  mixed $function the function called if the road match
     * @return void
     */

    public function listen(string $name, array|string $path, string $method, callable $function)
    {
        if (preg_match("#(^POST$){1}|(^GET$){1}|(^POST\|GET$){1}|(^GET\|POST$){1}$#", $method)) {
            if (gettype($path) == "string") {
                $path = [$path];
            }
            $route = new route($name, $path, $method, $function);
            $this->routes[] = $route;
        } else {
            throw new routerException('Request method unknown : ' . $method);
        }
    }

    public function match() {
        foreach ($this->routes as $route) {
            if ($route->verify($this->url)) {
                $this->page = $route->name;
                return $route->execute();
            }
        }
        throw new routerException('No path match');
    }

    public function hypertexte($name) {
        foreach ($this->routes as $route) {
            if ($route->name == $name) {
                if (gettype($route->path) === "string") {
                    return $route->path;
                } else if (gettype($route->path) === "array") {
                    return $route->path[0];
                } else {
                    throw new routerException('Le chemin d\'une route ne peut qu\'être une chaîne ou un tableau.');
                }
            }
        }
    }
}
