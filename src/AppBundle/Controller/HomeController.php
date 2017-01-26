<?php 

namespace AppBundle\Controller;

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

        $content = $this->get('templating')->render('layout.html.twig',
            array(
                'form'=>$form->createView()
            ));

        return new Response($content);

	}
} 