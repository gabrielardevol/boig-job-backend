<?php

namespace App\Controller;

use App\Repository\OfferRepository;
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

    public function dashboardData(OfferRepository $offerRepository) : Response {

        // BAR CHART PLATFORM x OFFER_STATUS
        // pillar totes les ofertes
        // separar-les per xarxa social
        // seleccionar-ne la xarxa social i l'estat
        // tornar un objecte tipus 'xarxa': { waitingForResponse: 124, inProcess: 12, rejected: 12}

        // KPI CARDS
        // total applications
        // total first-interviews
        // total rejections

        // RANGO SALARIAL x STATUS
        // salts de 100 euros
        // iterar totes les ofertes i retornar {status: string, salarialRange: {minimum: number, mximum: number}}
        // trobar el valor minim de salarialRange.minimum i el valor maxim de salarialRange.maximum
        // generar un array amb tots els valors entre minimum i maximum, amb salts de 500€ entremig
        // iterar cada element del array d'objectes reduits;
        // si sols te minimum, sumar 1 al corresponent de l'array de numeros
        // si te min i max, sumar 1 a cada step fins que arribi a max
        // resultat: {24000: {waitingForResponse: 12, inProcess: 3, rejected: 4}, 25000: {...} ... }

        return "";
    }
}
