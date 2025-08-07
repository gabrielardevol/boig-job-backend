<?php

namespace App\Controller;

use App\Repository\InterviewRepository;
use App\Repository\OfferRepository;
use App\Repository\OfferResponseRepository;
use App\Repository\StatusChangeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{

    #[Route('/api/dashboard/offersByDay/', name: 'dashboardOfferCount')]
    public function offersByDay(OfferRepository $offerRepository): Response {
        $data = $offerRepository->countOffersGroupedByDay();

        return $this->json([
            $data,
        ]);
    }
    #[Route('/api/dashboard/skills/', name: 'dahsboardSkills')]
    public function skills(OfferRepository $offerRepository): Response
    {

        $offers = $offerRepository->findAll(); // mètode personalitzat al repositori
        $allSkills = [];
        foreach($offers as $offer) {
            $allSkills = array_merge($allSkills, $offer->getSkills());
        }
        $skillsCount = [];
        foreach ($allSkills as $skill) {
            $skill = strtolower($skill);
            if (key_exists($skill , $skillsCount)){$skillsCount[$skill] = $skillsCount[$skill] + 1;}
            else {$skillsCount[$skill] = 1;}
        }
        arsort($skillsCount);


        // generar un objecte skillsCount
        // iterar l'array resultant de manera que per cada element:
        // si no existeix un key en skillsCount amb el nom de l'element, crear i assignar el valor 1
        // si sí existeix, sumar-li 1

        return $this->json([
            $skillsCount,
        ]);
    }

    #[Route('/api/dashboard', name: 'dashboard', methods: ['GET'])]
    public function dashboardData(OfferRepository $offerRepository, OfferResponseRepository $offerResponseRepository, StatusChangeRepository $statusChangeRepository, InterviewRepository $interviewRepository) : Response {

        $offers = $offerRepository->findAll();

        $interviews = $interviewRepository->findAll();

        $platformAndStatus = $this->countByPlatformAndStatus($offers);

        $kpiData = $this->getKpiData($offers, $interviews);

        $skillFrequency = $this->getSkillFrequency($offers);

        $offersByDay = $offerRepository->countOffersGroupedByDay();

        $responsesByDay = $offerResponseRepository->countGroupedByDay();

        $salaryRange = $this->getSalaryRange($offers);

        return $this->json([
            'kpiData' => $kpiData,
            'platformAndStatus' => $platformAndStatus,
            'skillFrequency' => $skillFrequency,
            'offersByDay' => $offersByDay,
            'responsesByDay' => $responsesByDay,

//            'dolor' => $salaryRange
        ]);

    }

    public function countByPlatformAndStatus($offers) {
        $grouped = [];

        foreach ($offers as $offer) {
            $platform = $offer->getPlatform();

            if (!isset($grouped[strtolower($platform)])) {
                $grouped[strtolower($platform)] = [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                ];
            }

            foreach ($offer->getStatusHistory() as $status) {
                $statusValue = $status->getStatus();

                if (isset($grouped[strtolower($platform)][$statusValue])) {
                    $grouped[strtolower($platform)][$statusValue]++;
                }
            }
        }

        return $grouped;
    }

    private function getKpiData(array $offers, array $interviews)
    {

        $totalApplications = count($offers);
        $totalInterviews = 0;
        $totalFirstInterviews = 0;
        $totalSecondInterviews = 0;
        $totalRejections = 0;

        foreach ($offers as $offer) {
            $interviews = $offer->getInterviews();
            $interviewCount = count($interviews);

            $totalInterviews += $interviewCount;

            if ($interviewCount >= 1) {
                $totalFirstInterviews++;
            }

            if ($interviewCount >= 2) {
                $totalSecondInterviews++;
            }

            if ($offer->getState() === 2) {
                $totalRejections++;
            }

        }
        return [
            'totalApplications' => $totalApplications,
            'totalInterviews' => $totalInterviews,
            'totalFirstInterviews' => $totalFirstInterviews,
            'totalSecondInterviews' => $totalSecondInterviews,
            'totalRejections' => $totalRejections,
        ];
    }

    private function getSalaryRange(array $offers): array
    {
        $ranges = [];

        $globalMin = PHP_INT_MAX;
        $globalMax = PHP_INT_MIN;

        $processedOffers = [];

        foreach ($offers as $offer) {
            $status = $offer->getState(); // string o int, segons el teu cas
            $salaryMin = $offer->getSalaryMinimum(); // ex: getSalarialRange()->getMinimum()
            $salaryMax = $offer->getSalaryMaximum(); // pot ser null

            if ($salaryMin !== null) {
                $globalMin = min($globalMin, $salaryMin);
            }

            if ($salaryMax !== null) {
                $globalMax = max($globalMax, $salaryMax);
            } else {
                $globalMax = max($globalMax, $salaryMin);
            }

            $processedOffers[] = [
                'status' => $status,
                'min' => $salaryMin,
                'max' => $salaryMax,
            ];
        }

        if ($globalMin === PHP_INT_MAX || $globalMax === PHP_INT_MIN) {
            return []; // no hi ha dades vàlides
        }

        $steps = [];
        for ($i = floor($globalMin / 500) * 500; $i <= $globalMax; $i += 500) {
            $steps[$i] = [];
        }

        foreach ($processedOffers as $offer) {
            $min = $offer['min'];
            $max = $offer['max'] ?? $min; // si no hi ha màxim, només compta el mínim
            $status = $offer['status'];

            for ($i = floor($min / 500) * 500; $i <= $max; $i += 500) {
                if (!isset($steps[$i][$status])) {
                    $steps[$i][$status] = 0;
                }
                $steps[$i][$status]++;
            }
        }

        return $steps;
    }

    public function getSkillFrequency($offers)
    {

        $allSkills = [];
        foreach($offers as $offer) {
            $allSkills = array_merge($allSkills, $offer->getSkills());
        }
        $skillsCount = [];
        foreach ($allSkills as $skill) {
            $skill = strtolower($skill);
            if (key_exists($skill , $skillsCount)){$skillsCount[$skill] = $skillsCount[$skill] + 1;}
            else {$skillsCount[$skill] = 1;}
        }
        arsort($skillsCount);

        return $skillsCount;
    }


}

