<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/30/18
 * Time: 3:16 PM
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

    /**
     * @Route("/homepage")
     */
    public function indexAction()
    {
        return $this->render('homepage.html.twig', [
        ]);
    }


}