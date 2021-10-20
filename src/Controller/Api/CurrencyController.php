<?php

namespace App\Controller\Api;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Schema\DataFilter\CurrencySchema;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/currencies', name: 'api_currencies_', options: ['expose' => true])]
class CurrencyController extends AbstractController
{
    #[Route('', name: 'get', methods: 'GET')]
    public function index(Request $request, CurrencyRepository $currencyRepository): Response
    {
        $searchQuerySchema = (new CurrencySchema())
                            ->setSearch($request->get('q'))
                            ->setPerPage($request->get('perPage', 10))
                            ->setOrderByField($request->get('orderByField'))
                            ->setOrderByDirection($request->get('orderByDirection'));

        $currencyCount = $currencyRepository->findCountBySchema($searchQuerySchema);

        // Set page after count is found to check if page is greater than the last page
        $searchQuerySchema->setPage($request->get('page', 1), ceil($currencyCount / $searchQuerySchema->getPerPage()));

        return $this->json([
            'data' => $currencyRepository->findBySchema($searchQuerySchema),
            'count' => $currencyCount
        ]);
    }

    #[Route('/{id}', name: 'find', methods: 'GET')]
    public function find(Currency $currency): Response
    {
        return $this->json($currency);
    }

    /*
    #[Route('', name: 'create', methods: 'POST')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $currency = new Currency();
        $currency
            ->setName($request->get('name'));

        $entityManager->persist($currency);
        $entityManager->flush();

        return $this->json(array_merge(['status' => 1], $currency->jsonSerialize()));
    }


    #[Route('/{id}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update(Currency $currency, Request $request, EntityManagerInterface $entityManager): Response
    {
        $updateAbleFields = $currency->getUpdatableFields();

        foreach ($updateAbleFields as $field => $callable) {
            if ($request->get($field)) {
                call_user_func($callable, $request->get($field));
            }
        }

        $entityManager->flush();

        return $this->json(array_merge(['status' => 1], $currency->jsonSerialize()));
    }
    */

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(Currency $currency, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($currency);
            $entityManager->flush();

            return $this->json(['status' => 1]);
        } catch (\Exception) {
            return $this->json(['status' => 0, 'message' => 'There has been a problem while deleting currency from database.']);
        }
    }
}