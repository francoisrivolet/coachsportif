<?php

namespace CoachSportifBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('envoyer', SubmitType::class)
            ->getForm();

        $content = $this->get('templating')->render('CoachSportifBundle::layout.html.twig',
            array(
                'form'=>$form->createView()
            ));

        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isValid())
        {
            $infoFormulaire = $form->getData();
            $nom = $infoFormulaire['nom'];
            $email = $infoFormulaire['email'];
            $message = $infoFormulaire['message'];
            $date = date('d-m-Y');

            $mail = \Swift_Message::newInstance()
                ->setSubject('[davidhuet-coachsportif.fr] - '.$nom.' '.$date)
                ->setFrom('francois.rivolet@imie-rennes.fr')
                ->setTo('francois.rivolet@imie-rennes.fr')
                ->setBody(
                    $this->renderView(
                        'CoachSportifBundle::email.html.twig',
                        array('nom' => $nom,
                            'email' => $email,
                            'message' => $message,
                            'date' => $date
                        )
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($mail);

            $request->getSession()->getFlashBag()->add('success', 'REUSSI');
            return new Response($content);
        }

        return new Response($content);

    }
}
