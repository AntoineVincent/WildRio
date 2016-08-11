<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Epreuve;
use AppBundle\Form\EpreuveType;
use AppBundle\Entity\Athlete;
use AppBundle\Form\AthleteType;
use AppBundle\Entity\Vote;

class DefaultController extends Controller
{

    public function epreuveAction(Request $request, $idepreuve)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $epreuve = $em->getRepository('AppBundle:Epreuve')->findOneById($idepreuve);
        $athletes = $em->getRepository('AppBundle:Athlete')->findByIdepreuve($idepreuve);

        $voteEpreuves = $em->getRepository('AppBundle:Vote')->findByIdepreuve($idepreuve);

        return $this->render('default/epreuve.html.twig', array(
            'epreuve' => $epreuve,
            'athletes' => $athletes,
            'voteEpreuves' => $voteEpreuves,
            'user' => $user,
        ));
    }

    public function newEpreuveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $epreuve = new Epreuve();
        $form = $this->createForm('AppBundle\Form\EpreuveType', $epreuve);
        $form->handleRequest($request);

        

        if ($form->isValid()) {

            $image = $epreuve->getImage();

            $photoName = md5(uniqid()).'.'.$image->guessExtension();
            $photoDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/epreuve';
            $image->move($photoDir, $photoName);

            $epreuve->setImage($photoName);

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Epreuve Créée !')
            ;

            $em->persist($epreuve);
            $em->flush();
        }

        return $this->render('default/newEpreuve.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function newAthleteAction(Request $request, $idepreuve)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $athlete = new Athlete();
        $form = $this->createForm('AppBundle\Form\AthleteType', $athlete);
        $form->handleRequest($request);

        $epreuve = $em->getRepository('AppBundle:Epreuve')->findOneById($idepreuve);

        

        if ($form->isValid()) {

            $athlete->setIdepreuve($idepreuve);
            $athlete->setVote(0);
            $athlete->setPercent(0);

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Athlete Ajouté !')
            ;

            $em->persist($athlete);
            $em->flush();
        }

        return $this->render('default/newAthlete.html.twig', array(
            'form' => $form->createView(),
            'epreuve' => $epreuve,
        ));
    }

    public function voteAction(Request $request, $idathlete)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $vote = new Vote();

        $athlete = $em->getRepository('AppBundle:Athlete')->findOneById($idathlete);
        $epreuve = $em->getRepository('AppBundle:Epreuve')->findOneById($athlete->getIdepreuve());

        $vote->setIduser($user->getId());
        $vote->setIdepreuve($epreuve->getId());

        $athlete->setVote($athlete->getVote() + 1);

        $em->persist($vote);
        $em->flush();
        $em->persist($athlete);
        $em->flush();

        $allVotes = count($em->getRepository('AppBundle:Vote')->findAll());

        $allAthlete = $em->getRepository('AppBundle:Athlete')->findAll();

        foreach ($allAthlete as $athl ) {
            $percent = ($athl->getVote() / $allVotes) * 100;
            $athl->setPercent($percent);

            $em->persist($athl);
            $em->flush();
        }

        return $this->render('default/vote.html.twig', array(
            'epreuve' => $epreuve,
            'athlete' => $athlete,
        ));
    }
}
