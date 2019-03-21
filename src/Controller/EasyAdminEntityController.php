<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationRepository;

class EasyAdminEntityController extends AbstractController
{
    /** @var array The full configuration of the entire backend */
    protected $config;
    /** @var array The full configuration of the current entity */
    protected $entity;
    /** @var Request The instance of the current Symfony request */
    protected $request;
    /** @var EntityManager The Doctrine entity manager for the current entity */
    protected $em;

    /** @Route("/admin/report", name="admin_report") */
//    public function indexAction(Request $request)
//    {
//
//        // you can override this method to perform additional checks and to
//        // perform more complex logic before redirecting to the other methods
//    }

    // Creates the Doctrine query builder used to get all the items. Override it
    // to filter the elements displayed in the listing
//    public function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
//    {
//
//    }

    // Performs the actual database query to get all the items (using the query
    // builder created with the previous method). You can override this method
    // to filter the results before sending them to the template
//    public function findAll($entityClass, $page = 1, $maxPerPage = 15, $sortField = null, $sortDirection = null, $dqlFilter = null)
//    {
//
//    }

}
