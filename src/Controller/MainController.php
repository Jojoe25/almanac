<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @route("/", name="main_home")
     */
    public function home()
    {
        echo "coucou";
        die();
    }

    /**
     * @route("/test", name="main_test")
     */
    public function test()
    {
        echo "testounet";
        die();
    }

}