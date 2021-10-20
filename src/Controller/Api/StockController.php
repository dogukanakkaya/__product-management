<?php

namespace App\Controller\Api;

use App\Builder\Stock\OptionBuilder;
use App\Entity\Stock\Option;
use App\Entity\Stock\Stock;
use App\Repository\Stock\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/stocks', name: 'api_stocks_', options: ['expose' => true])]
class StockController extends AbstractController
{
    #[Route('', name: 'get', methods: 'GET')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $optionBuilder = new OptionBuilder();

        $combinations = $optionBuilder->combinations([
            1 => [1, 2],
            2 => [3, 4]
        ]);

        dd($combinations);

        /*
        $stock = new Stock();
        $stock
            ->translate('en')
            ->setName('Name');

        $entityManager->persist($stock);
        $stock->mergeNewTranslations();
        $entityManager->flush();
        */
    }

    #[Route('/options', name: 'options', methods: 'GET')]
    public function options(OptionRepository $optionRepository): JsonResponse
    {
        return $this->json([
            'data' => $optionRepository->findAll()
        ], context: [
            'circular_reference_handler' => function (Option $option) {
                return $option->getId();
            }
        ]);
    }
}