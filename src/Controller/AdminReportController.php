<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReportType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationRepository;
use App\Entity\Reservation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use DateTime;

class AdminReportController extends AbstractController
{
    /** @var ReservationRepository*/
    public $reservationRepository;

    /**
     * @required
     */
    public function setUserRepository(ReservationRepository $repository)
    {
        $this->reservationRepository = $repository;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/reportttttt", name="admin_reportttttt")
     */
    public function getReport(Request $request)
    {
        $formReport = $this->createForm(ReportType::class);
        $formReport->handleRequest($request);


        if ($formReport->isSubmitted() && $formReport->isValid()) {
            $formData = $formReport->getData();

            $dateFrom = $formData->getDateFrom();
            $dateTo = $formData->getDateTo();

            //$report = $this->reservationRepository->getReportByPeriod($dateFrom, $dateTo);

        } else {
            $dateFrom = new \DateTime('- 1 month');
            $dateFrom = $dateFrom->format('Y-m-d');
            //dd($dateFrom);
            $dateTo = new \DateTime("now");
            $dateTo = $dateTo->format('Y-m-d');

            $report = $this->reservationRepository->getReportByPeriod($dateFrom, $dateTo);
        }

        return $this->render('page/admin_report.html.twig', [
            'admin' => 'active',
            'reports' => $report,
            'report_form' => $formReport->createView(),
            'date_from' => $dateFrom,
            'date_to' => $dateTo
        ]);
    }
}
