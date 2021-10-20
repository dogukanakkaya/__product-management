<?php

namespace App\Controller\Admin;

use App\Repository\FileRepository;
use App\Service\File\ImageManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/{svelte}', name: 'admin', requirements: ['svelte' => '^(?!api).+'], defaults: ['svelte' => null], methods: 'GET')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/api/me', priority: 1)]
    public function me(Request $request, JWTEncoderInterface $encoder): JsonResponse
    {
        return $this->json($encoder->decode($request->cookies->get('BEARER')));
    }
}
