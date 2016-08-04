<?php

namespace DataBaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use DataBaseBundle\Entity\Product;


class ProductController extends Controller
{

    /**
     * @Route ("/create")
     * @Template()
     * @Method ("GET")
     */
    public function createAction(){
        return [];
    }

    /**
     * @Route("/create")
     * @Method("POST")
     */
    public function createPostAction(Request $req)
    {
        $newProduct = new Product();

        $newName = $req->request->get("productName");
        $newDesc = $req->request->get("productDesc");
        $newPrice = $req->request->get("productPrice");
        $newQuantity = $req->request->get("productQuantity");

        $newProduct->setName($newName);
        $newProduct->setPrice($newPrice);
        $newProduct->setQuantity($newQuantity);
        $newProduct->setDescription($newDesc);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newProduct);
        $em->flush();

        return $this->redirectToRoute("database_product_show", ["id"=>$newProduct->getId()]);
    }

    /**
     * @Route("/show/{id}")
     */
    public function showAction($id)
    {
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Product");
        $product = $repo->find($id);

//        if ($product === null){
//            return $this->redirectToRoute("database_product_list");
//        }
        return $this->render("DataBaseBundle:Product:show.html.twig", ["product"=> $product]);
    }

    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Product");
        $allProducts = $repo->findAll();
        return array("allProducts" => $allProducts);
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Product");

        $productToDel = $repo->find($id);

        $em->remove($productToDel);
        $em->flush();

        $resp = $this->redirectToRoute("database_product_list");
        return $resp;
    }

    /**
     * @Route("/edit/{id}")
     * @Method ("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Product");
        $product = $repo->find($id);
        return array("product"=>$product);
    }

    /**
     * @Route("/edit/{id}")
     * @Method ("POST")
     */
    public function editPostAction(Request $req, $id)
    {
        $repo = $this->getDoctrine()->getRepository("DataBaseBundle:Product");
        $product = $repo->find($id);
        $em = $this->getDoctrine()->getManager();

        $newName = $req->request->get("productName");
        $newDesc = $req->request->get("productDesc");
        $newPrice = $req->request->get("productPrice");
        $newQuantity = $req->request->get("productQuantity");

        $product->setName($newName);
        $product->setPrice($newPrice);
        $product->setQuantity($newQuantity);
        $product->setDescription($newDesc);

        $em->flush();

        $resp = $this->redirectToRoute("database_product_show", ["id" =>$product->getId()]);

        return $resp;
    }

    /**
     * @Route ("/create/{n}")
     */
    public function createNAction($n){
        $em = $this->getDoctrine()->getManager();

        for($i = 0; $i < $n ; $i ++){
            $newProduct = new Product();
            $newProduct->setDescription("Nowy produkt o numerze $i");
            $newProduct->setName("Product $i");
            $newProduct->setPrice(rand(1, 100));
            $newProduct->setQuantity(rand(3,60));

            $em->persist($newProduct);
        }
        $em->flush();

        return $this->redirectToRoute("database_product_list");
    }

    /**
     * @Route ("/byPrice/{startPrice}/{stopPrice}")
     * @Template("DataBaseBundle:Product:list.html.twig")
     */
    public function byPriceAction($startPrice, $stopPrice){
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT p FROM DataBaseBundle:Product p WHERE p.price> :start AND p.price < :end");
        $query->setParameter("start", $startPrice);
        $query->setParameter("end", $stopPrice);
        $products = $query->getResult();

        return ["allProducts"=>$products];
    }

    /**
     * @Route ("/byQuantity/{startQuantity}/{stopQuantity}")
     * @Template ("DataBaseBundle:Product:list.html.twig")
     */
    public function byQuantityAction($startQuantity, $stopQuantity){
        $em = $this->getDoctrine()->getManager();

        $query= $em->createQuery("SELECT q FROM DataBaseBundle:Product q WHERE q.quantity > :start AND q.quantity < :stop");
        $query->setParameter("start", $startQuantity);
        $query->setParameter("stop", $stopQuantity);

        $products = $query->getResult();

        return ["allProducts" => $products];
    }
}
