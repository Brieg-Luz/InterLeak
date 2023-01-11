<?php

namespace interleak\routeur;

use routeur\routerException\routeurException;

class route
{
    public array $path;
    public array $matches;

    public function __construct(
        public string $name,
        $chemins,
        public string $method,
        public $function
    ) {
        foreach ($chemins as $cle => $chemin) {
            $chemins[$cle] = trim($chemin, '/');
        }
        $this->path = $chemins;
    }

    public function verify(string $url)
    {
        $url = trim($url, '/');
        if (($_SERVER['REQUEST_METHOD'] == "POST" && preg_match("#(^POST$){1}|(^POST\|GET$){1}|(^GET\|POST$){1}#", $this->method)) || ($_SERVER['REQUEST_METHOD'] == "GET" && preg_match("#(^GET$){1}|(^POST\|GET$){1}|(^GET\|POST$){1}#", $this->method))) {
            foreach ($this->path as $chemin) {
                $path = preg_replace("#:([\w]+)#", '([^/]+)', $chemin);
                $regexPath = "#^$path$#i";
                if (preg_match($regexPath, $url, $matches)) {
                    array_shift($matches);
                    $this->matches = $matches;
                    return true;
                }
            }
            return false;
        } else {
            return false;
        }
    }

    public function execute()
    {
        return call_user_func_array($this->function, $this->matches);
    }
}
