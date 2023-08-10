<?php
declare(strict_types=1);

namespace App\controller;

class TestController
{
    /**
     * Summary of index
     * this function is temporary, just to test
     *
     * @param mixed $id
     * 
     * @return void
     */
    public function index(?int $id) :void
    {
        echo "test";
        if ($id) {
            echo "l'id du paramètre est : " . $id;
        }
    }
}
