<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/1/18
 * Time: 1:39 PM
 */

namespace App\Controller;


use App\Entity\Job;
use App\Form\JobForm;
use App\Form\JobSearchType;
use App\Form\JobType;
use App\Model\JobSearch;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        if ($form->isSubmitted() && $form->isValid()) {
            $job = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($job); //persist pune in entity manager sa salveze
            $em->flush();//salvare
        }
        $this->createForm(JobType::Class, null);
        return $this->render('addjob.html.twig', array(
            'form' => $form->createView(),
        ));


    }

    /**
     * @Route("/edit/{id}", name="app_edit_job")
     */

    public function editAction(Request $request, Job $job)
    {

        $form = $this->createForm(JobForm::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $job = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('app_job_list');
        }
    }


    /**
     * @Route("/list", name="app_job_list")
     * @Route("/list/{keyword}", name="app_job_keyword")
     *
     *
     * @param Request $request
     * @return Response
     */

    public function listAction(Request $request, $keyword = null)
    {
        $jobSearch = new JobSearch();
        if ($keyword) {
            $jobSearch->setKeyword($keyword);
        }

        /** @var FormInterface $from */
        $form = $this->createForm(JobSearchType::class, $jobSearch);
        $form ->handleRequest($request);

        /** @var JobRepository $reposityory */
        $reposityory = $this->getDoctrine()->getManager()->getRepository(Job::class);

        $jobs = $reposityory->getByKeyword($jobSearch->getKeyword());

        return $this->render(
            'list.html.twig',
            [
                'form' => $form->createView(),
                'jobs' => $jobs,
                'keyword' => $jobSearch->getKeyword(),
            ]
        );

    }


}