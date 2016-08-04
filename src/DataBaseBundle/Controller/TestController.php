<?php

namespace DataBaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DataBaseBundle\Entity\Customer;
use DataBaseBundle\Entity\ShopOrder;
use DataBaseBundle\Entity\Product;
use DataBaseBundle\Entity\Invoice;
use Symfony\Component\HttpFoundation\Response;


class TestController extends Controller
{
    /**
     * @Route ("/createData")
     */
    public function createDataAction(){
        $newCustomer1 = new Customer();
        $newCustomer1->setName("Gosia Ros");
        $newCustomer1->setAddress("Adres Gosi w Warszawie");
        $newCustomer1->setEmail("gosia@gmail.com");

        $newCustomer2 = new Customer();
        $newCustomer2->setName("Jan Kowalski");
        $newCustomer2->setAddress("Adres Jana w Krakowie");
        $newCustomer2->setEmail("jan@test.com");

        $em = $this->getDoctrine()->getManager();
        $em->persist($newCustomer1);
        $em->persist($newCustomer2);

        $em->flush();

        return new Response("Udało się");
    }

    /**
     * @Route ("/showCustomer/{id}")
     * @Template
     */
    public function showCustomerAction($id){
        $customerRepo = $this->getDoctrine()->getRepository("DataBaseBundle:Customer");
        $customer = $customerRepo->find($id);
        return ["customer"=>$customer];
    }

    /**
     * @Route ("/addOrder/{id}")
     */
    public function addOrderAction($id){
        $customerRepo = $this->getDoctrine()->getRepository("DataBaseBundle:Customer");
        $customer = $customerRepo->find($id);

        $newOrder = new ShopOrder();
        $newOrder->setOrderNumber(12);
        $newOrder->setOrderDate(new \DateTime("now"));

        $newOrder->setCustomer($customer);
        $customer->addShopOrder($newOrder);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newOrder);
        $em->flush();

        return $this->redirectToRoute("database_test_showcustomer", ["id"=>$id]);
    }

    /**
     * @Route ("/showOrder/{id}")
     * @Template
     */
    public function showOrderAction($id){
        $orderRepo = $this->getDoctrine()->getRepository("DataBaseBundle:ShopOrder");
        $orderId = $orderRepo->find($id);
        return ["showOrder"=>$orderId];
    }

    /**
     * @Route ("/createProductOrder")
     */
    public function createProductOrderAction(){
        $newProduct = new Product();
        $newProduct->setName("XYZ");
        $newProduct->setDescription("Produkt XYZ");
        $newProduct->setPrice(12);
        $newProduct->setQuantity(5);

        $newOrder = new ShopOrder();
        $newOrder->setOrderNumber(12);
        $newOrder->setOrderDate(new \DateTime("now"));

        $newOrder->addProduct($newProduct);
        $newProduct->addShopOrder($newOrder);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newOrder);
        $em->persist($newProduct);

        $em->flush();

        return new Response("Udało się");
    }

    /**
     * @Route ("/createInvoice/{n}")
     */
    public function createInvoiceAction($n){
        $em = $this->getDoctrine()->getManager();
        for($i=0; $i<$n; $i++){
            $newInvoice = new Invoice();
            $newInvoice->setInvoiceNumber(rand(0,1000));
            $newInvoice->setIsPayed(rand(0,1));

            $em->persist($newInvoice);
        }
        $em->flush();

        return $this->redirectToRoute("database_test_listinvoices");
    }

    /**
     * @Route ("/listInvoices")
     * @Template()
     */
    public function listInvoicesAction(){
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Invoice");
        $allInvoices = $repo->findAll();

        return ["invoices" => $allInvoices];
    }

    /**
     * @Route ("/listInvoices/{start}/{stop}")
     * @Template("DataBaseBundle:Test:listInvoices.html.twig")
     */
    public function listInvoicesStartStopAction($start, $stop){
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Invoice");
        $allInvoices = $repo->findAllInvoicesWithNumberBetween($start, $stop);

        return ["invoices" => $allInvoices];
    }

        /**
         * @Route ("/invoices/{page}")
         * @Template ("DataBaseBundle:Test:listInvoices.html.twig")
         */
        public function paginateInvoicesAction($page){
            $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Invoice");
            $invoicesPerPage = $repo->findAllInvoicesPagination($page);

            $arrayToReturn = ["invoices"=> $invoicesPerPage];
            if($page > 0 ){
                $arrayToReturn["prevpage"] = $page - 1;
            }

            if(count($invoicesPerPage) === 10){
                $arrayToReturn['nextpage'] = $page + 1;
            }

            return $arrayToReturn;
        }

}
