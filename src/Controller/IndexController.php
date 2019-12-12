<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController {


	public function index() {

		 if (!$this->getUser()) {
		    return $this->redirectToRoute('app_login');
		 }

		return $this->render('index/index.html.twig');
	}
}