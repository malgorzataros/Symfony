<?php

namespace firstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

///**
// * @Route("/firstController")
// */
class firstController extends Controller
{
    /**
     * @Route("/default/{text}", name = "default")
     */
    public function defaultAction($text){
        $resp = new Response("<h1> Default action 1 </h1><br><p>$text</p>");
        return $resp;
    }


    /**
     * @Route("/show/{city}/{street}",
     *     defaults = {"city" = "Warszawa", "street" = "Wilanowska"},
     *     requirements = {"city"="[a-zA-Z]+"})
     */
    public function showStreetAction($city, $street){
        $resp = new Response ("W mieście $city jest ulica $street ");
        return $resp;
    }

    /**
     * @Route ("/showuser/{id}", requirements = {"id" = "[\d]+"})
     */
    public function showUserByIdAction($id){
        $resp = new Response("Wczytuje usera po id: $id");
        return $resp;
    }

    /**
     * @Route ("/showuser/{name}", requirements = {"name" = "[a-zA-Z]+"})
     */
    public function showUserByNameAction($name){
        $resp = new Response("Wczytuje usera po nazwie: $name");
        return $resp;
    }

    /**
     * @Route ("/form")
     * @Method("GET")
     */
    public function formAction(){
        return new Response ("<form method='POST'><input name='name'><input type='submit'></form>");
    }

    /**
     * @Route ("/form")
     * @Method("POST")
     */
    public function procesFromAction(Request $req){
        $name = $req->request->get('name');
        return new Response ("Dziekuje za wyslanie formularza: $name <br>");
    }


    /**
     * @Route ("/request")
     */
    public function reqAction (Request $req){
        //var_dump($req);
        $name = $req->query->get("name", "Default name");
        return new Response("Nazwa przeslana GETem: $name");
    }

    /**
     * @Route ("/setSession/{value}")
     */
    public function setSessionAction (Request $req, $value){
        $session = $req->getSession();
        $session->set("foo", $value);
        return new Response("Nastawiono sesję na watrość: $value");
    }

    /**
     * @Route ("/getSession")
     */
    public function getSessionAction(Request $req){
        $session = $req->getSession();
        $fooValue = $session->get("foo", "Default foo value");
        return new Response ("W sesji pod kluczem foo jest wartosc: $fooValue");
    }

    /**
     * @Route ("/delSession")
     */
    public function delSessionAction (Request $req){
        $session = $req ->getSession();
        $session->remove('foo');
        return new Response("Wyszysciłem sesje");
    }

    /**
     * @Route ("/setCookie/{value}")
     */
    public function setCookieAction($value){
        $newCookie = new Cookie("fooCookie", $value, time() + 3600 * 24);
        $resp = new Response("Nowe ciasteczko zostało dodane");
        $resp->headers->setCookie($newCookie);
        return $resp;

    }
    
    /**
     * @Route ("/showCookie")
     */
    public function showCookieAction (Request $req){
        $cookieValue1 = $req->cookies->get("fooCookie");
        $allCookiesTable = $req->cookies->all();
        $cookieValue2 = $allCookiesTable['fooCookie'];

        return new Response ("Ciasteczko zebrane metodą 1: $cookieValue1 <br>
                               Ciasteczko zebrane metoda 2: $cookieValue2<br>");
    }
    
    /**
     * @Route ("/delCookie")
     */
    public function delCookieAction(Request $req){
        $newCookie = $req->cookies->get("fooCookie");
        $cookie = new Cookie("fooCookie", $newCookie, time() - 1);
        $resp = new Response ("Usunalem cookie");
        $resp->headers->setCookie($cookie);
        return $resp;

    }
    
    /**
     * @Route ("/redirect")
     */
    public function redirectAction(){
        //$resp = $this->redirectToRoute("first_first_form");
        $resp= $this->redirectToRoute("first_first_setcookie", ["value" => "xxx"]);
        return $resp;
    }

    /**
     * @Route ("/link")
     */
    public function linkAction(){
        //drugi prametr to ZAWSZE jes slug - zapisany jako tablica,
        // get nie ma sluga wiec ma trzeba wpisac pusta tablice
        $link1 = $this->generateUrl('first_first_getsession',
                        [],
                        UrlGeneratorInterface::ABSOLUTE_URL);
        $link2 = $this->generateUrl('first_first_setsession', ['value' => "New Value"]);

        return new Response ("<a href='$link1'> Link1 </a><br>
                              <a href='$link2'> Link2 </a>");
    }

    /**
     * @Route ("/firstTwig/{name}/{surname}")
     * @Template ("firstBundle:first:firstTwig.html.twig")
     */
    public function firstTwigAction($name, $surname){
        //$resp = $this->render("firstTwig.html.twig");
        //$resp = $this->render("firstBundle:first:firstTwig.html.twig");
        //return $resp;
        return ["name" => $name, "surname" => $surname, "welcomeText" => "witaj w moim serwisie:"];
    }

    /**
     * @Route ("/censor")
     * @Method ("GET")
     * @Template ("firstBundle:first:censorForm.html.twig")
     */
    public function censorGetAction(){
        return [];
    }

    /**
     * @Route ("/censor")
     * @Method ("post")
     * @Template ("firstBundle:first:censor.html.twig")
     */
    public function censorAction(Request $req){
        $textToCensor = $req->request->get('toCensor');
        $arrayOfBadWords = ["kurcze", "gupek" , "frajer"];
        return ["text" => $textToCensor, "badWords" => $arrayOfBadWords];
    }

    /**
     * @Route ("/cycle")
     * @Template ("firstBundle:first:cycle.html.twig")
     */
    public function cycleAction(){
        return [];
    }

    //ćwiczenie 7
    /**
     * @Route ("/createRandom/{start}/{end}/{n}")
     * @Template("firstBundle::createRandom.html.twig")
     */
    public function createRandomAction($start, $end, $n){
        $array = [];
        for($i=0; $i<$n; $i++){
            $array[$i]=rand($start, $end);
        }
        return ["arrayRand" => $array];
    }

    /**
     * @Route ("/user/show")
     * @Template ("firstBundle:first:userShow.html.twig")
     */
    public function userShowAction(){
        return ["name" => "Malgosia", "surname" => "Ros"];
    }

    /**
     * @Route ("/user/all")
     * @Template ("firstBundle:first:userShowAll.html.twig")
     */
    public function userShowAllAction(){
        $users = [];
        $users[]=["name" => "Janusz", "surname" => "Kowalski"];
        $users[]=["name" => "Michal", "surname" => "Iksinski"];
        $users[]=["name" => "Gosia", "surname" => "Ros"];
        $users[]=["name" => "Piotr", "surname" => "Trynski"];
        $users[]=["name" => "Ania", "surname" => "Ktos"];
        $users[]=["name" => "Marcin", "surname" => "Majewski"];
        $users[]=["name" => "Kasia", "surname" => "Kowalska"];

        return ["users" => $users];

    }


}
