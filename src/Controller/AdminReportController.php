<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReportType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationRepository;
use App\Entity\Reservation;
use App\Entity\StorageType;
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
     * @Route("/admin/my_report", name="admin_my_report")
     */
    public function getReport(Request $request)
    {
        $formReport = $this->createForm(ReportType::class);
        $formReport->handleRequest($request);


        if ($formReport->isSubmitted() && $formReport->isValid()) {
            $formData = $formReport->getData();

            $dateFrom = $formData['dateFrom'];
            $dateFrom = $dateFrom->format('Y-m-d');

            $dateTo = $formData['dateTo'];
            $dateTo = $dateTo->format('Y-m-d');
        } else {
            $dateFrom = new \DateTime('- 1 month');
            $dateFrom = $dateFrom->format('Y-m-d');

            $dateTo = new \DateTime("now");
            $dateTo = $dateTo->format('Y-m-d');
        }

        $report = $this->reservationRepository->getReportByPeriod($dateFrom, $dateTo);

        foreach ($report as &$item) {
            $gp_ids = explode(',', $item['gp_ids']);
            $count_gp = array_count_values($gp_ids);
            $maxs = array_keys($count_gp, max($count_gp));
            $most_popular_gp = $maxs[0];
            $item['most_popular_goods_property'] = $most_popular_gp;

            $is_reserved_now = explode(',', $item['is_reserved_now_vals']);
            if (in_array("1", $is_reserved_now, true)) {
                $item['is_reserved_now'] = 'yes';
            } else {
                $item['is_reserved_now'] = 'no';
            }

            $tot_days_res = explode(',', $item['tot_days_res_vals']);
            $item['tot_days_res'] = array_sum($tot_days_res);

            $item['tot_days_emp'] = $item['period']*$item['storage_count'] - $item['tot_days_res'];
        }
        unset($item);

        return $this->render('page/admin_report.html.twig', [
            'admin' => 'active',
            'reports' => $report,
            'report_form' => $formReport->createView(),
            'date_from' => $dateFrom,
            'date_to' => $dateTo
        ]);
    }
}
