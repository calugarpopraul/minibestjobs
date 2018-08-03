<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/1/18
 * Time: 1:39 PM
 */

namespace App\Controller;


use App\Entity\Job;
use App\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class JobController extends Controller
{
    /**
     * @Route("/job")
     */

    public function addAction(Request $request)
    {

        $form = $this->createForm(JobType::class, null);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $job=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($job); //persist pune in entity manager sa salveze
            $em->flush();//salvare
        }
        $this->createForm(JobType::Class,null);
        return $this->render('addjob.html.twig', array(
            'form' => $form->createView(),
        ));

        //return $this->render('jobpage.html.twig',['title'=>'job']);
    }



}