<?php

namespace App\Controller;

use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OfferController extends AbstractController
{

    #[Route('/api/offersByCompanyLevenshtein/{companyName}', name: 'offersByCompany')]
    public function offersByCompanyLevenshtein(string $companyName, OfferRepository $offerRepository): Response
    {

        $offers = $offerRepository->findAllIdAndCompany(); // mètode personalitzat al repositori

        usort($offers, function ($a, $b) use ($companyName) {
            $scoreA = str_contains(strtolower($a['company']), strtolower($companyName)) ? 0 : levenshtein(strtolower($companyName), strtolower($a['company']));
            $scoreB = str_contains(strtolower($b['company']), strtolower($companyName)) ? 0 : levenshtein(strtolower($companyName), strtolower($b['company']));
            return $scoreA <=> $scoreB;
        });

        return $this->json([
            'message' => 'Hello from API!',
            'company' => $companyName,
            'offers' =>  $offers,
        ]);
    }

//    #[Route('/api/offersByAttribute/{attribute}', name: 'allOffersByAttribute')]
//    public function allByAttribute(string $attribute, OfferRepository $offerRepository): Response {
//        $offers = $offerRepository->findAllByAttribute($attribute);
//        return $this->json([
//            $offers
//        ]);
//    }
}
