<?php

namespace DataBaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use DataBaseBundle\Entity\Customer;
use DataBaseBundle\Entity\ShopOrder;
use DataBaseBundle\Entity\Product;


class FormController extends Controller
{
    /**
 * @Route("/simpleForm")
 * @Template()
 * @Method("GET")
 */
    public function simpleFormAction()
    {
        $form = $this->generateSimpleForm();
        return array("form"=>$form->createView());
    }

    private function generateSimpleForm(){
        return $this->createFormBuilder()
            ->add("name", "text", ["label" => "Imie i nazwisko:", "required" =>true])
            ->add("email", "email", ["label" => "Podaj email:"])
            ->add("bday", "birthday", ["label" => "Podaj date urodzenia:"])
            ->add("pass1", "password", ["label" => "Podaj haslo:"])
            ->add("pass2", "password", ["label" => "Powtorz haslo:"])
            ->add("gender", "choice", ["choices" => ["M" => "Male", "F" => "Female"]])
            ->add("agree", "checkbox")
            ->add("send", "submit")
            ->getForm();
    }

    /**
     * @Route("/simpleForm")
     * @Template("DataBaseBundle:Form:showForm.html.twig")
     * @Method("POST")
     */
    public function showSimpleFormAction(Request $req){
        $form = $this->generateSimpleForm();
        $form->handleRequest($req);
        $data = $form->getData();

        return ["dataToShow" => $data];
    }

    /**
     * @Route("/customerForm")
     * @Template()
     * @Method ("GET")
     */
    public function customerFormAction()
    {
        $newCustomer = new Customer;
        $form = $this->createCustomerForm($newCustomer);

        return array("form" => $form->createView());
    }

    private function createCustomerForm(Customer $customer){
        return $this->createFormBuilder($customer)
                    ->add("name", "text")
                    ->add("address", "text")
                    ->add("email", "email")
                    ->add("send", "submit")
                    ->getForm();
    }

    /**
     * @Route("/customerForm")
     * @Template("DataBaseBundle:Form:showForm.html.twig")
     * @Method ("POST")
     */
    public function postCustomerFormAction(Request $req)
    {
        $newCustomer = new Customer;
        $form = $this->createCustomerForm($newCustomer);
        $form->handleRequest($req);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newCustomer);

        $em->flush();

        return array("dataToShow" => $newCustomer);
    }

    /**
     * @Route ("editCustomer/{n}")
     * @Method ("GET")
     * @Template ("DataBaseBundle:Form:customerForm.html.twig")
     */
    public function editCustomerAction($n){
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Customer");
        $customer = $repo->find($n);
        $form = $this->createCustomerForm($customer);

        return ["form" => $form->createView()];
    }

    /**
     * @Route ("editCustomer/{n}")
     * @Method ("POST")
     * @Template ("DataBaseBundle:Form:showForm.html.twig")
     */
    public function postEditCustomerAction(Request $req, $n){
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Customer");
        $customer = $repo->find($n);

        $form = $this->createCustomerForm($customer);
        $form->handleRequest($req);

        $this->getDoctrine()->getManager()->flush();

        return ["dataToShow" => $customer];
    }

    /**
     * @Route("/orderForm")
     * @Template()
     * @Method ("GET")
     */
    public function orderFormAction()
    {
        $newOrder = new ShopOrder();
        $form = $this->createFormOrder($newOrder);
        return array("form" => $form->createView());
    }

    private function createFormOrder(ShopOrder $order){
        return $this->createFormBuilder($order)
                    ->add("orderNumber", "number")
                    ->add("orderDate", "date")
                    ->add("customer", "entity", [
                        "class" => "DataBaseBundle:Customer",
                        "choice_label" => "name"
                    ])
                    ->add("products", "entity", [
                        "class" => "DataBaseBundle:Product",
                        "choice_label" => "name", "multiple" => true, "expanded" => true
                    ])
                    ->add("send", "submit")
                    ->getForm();
    }

    /**
     * @Route("/orderForm")
     * @Template("DataBaseBundle:Form:showForm.html.twig")
     * @Method ("POST")
     */
    public function postOrderFormAction(Request $req)
    {
        $newOrder = new ShopOrder();
        $form = $this->createFormOrder($newOrder);
        $form->handleRequest($req);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($newOrder);
        $em->flush();

        return array("dataToShow" => $newOrder);
    }

}
