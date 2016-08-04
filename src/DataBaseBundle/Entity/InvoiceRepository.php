<?php

namespace DataBaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InvoiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InvoiceRepository extends EntityRepository
{
    public function findAllInvoicesWithNumberBetween($start, $stop){
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT i FROM DataBaseBundle:Invoice i WHERE i.invoiceNumber > :start 
                                    AND i.invoiceNumber < :end");
        $query->setParameter("start", $start);
        $query->setParameter("end", $stop);

        $invoices = $query->getResult();

        return $invoices;
    }

    public function findAllInvoicesPagination($page){
        $resultPerPage = 10;
        $em = $this->getEntityManager();

        //$query = $em->createQuery("SELECT i FROM DataBaseBundle:Invoice i BETWEEN :start AND :end");
        $query = $em->createQuery("SELECT i FROM DataBaseBundle:Invoice i")
                    ->setFirstResult($page * $resultPerPage)
                    ->setMaxResults($resultPerPage);
        //$query->setParameter("start", $page * $resultPerPage);
        //$query->setParameter("end", ($page +1) * $resultPerPage);

        $invoices = $query->getResult();
        return $invoices;
    }
}
