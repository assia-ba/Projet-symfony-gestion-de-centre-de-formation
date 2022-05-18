<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Component\Routing\Annotation\Route;
class IndexController extends AbstractController
{

public function home()
{
return $this->render('index.html.twig');
}
public function accueil()
{
return $this->render('accueil.html.twig');
}
public function about()
{
return $this->render('about.html.twig');
}
public function admin()
{
return $this->render('admin.html.twig');
}
public function etudiant()
{
return $this->render('etudiant.html.twig');
}
public function calendar()
{
return $this->render('formations/calendar.html.twig');
}
public function calendar2()
{
return $this->render('formations/calendar2.html.twig');
}
}
