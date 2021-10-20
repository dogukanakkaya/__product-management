<?php

namespace App\Controller\Api;

use App\Entity\File;
use App\Repository\FileRepository;
use App\Schema\DataFilter\FileSchema;
use App\Service\File\FileManager;
use App\Service\File\ImageManager;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/files', name: 'api_files_', options: ['expose' => true])]
class FileController extends AbstractController
{
    #[Route('', name: 'get', methods: 'GET')]
    public function index(Request $request, FileRepository $fileRepository)
    {
        $searchQuerySchema = (new FileSchema())
            //->setSearch($request->get('q'))
            ->setStart($request->get('start', 0));

        return $this->json([
            'data' => $fileRepository->findBySchema($searchQuerySchema),
            'count' => $fileRepository->findCountBySchema($searchQuerySchema)
        ]);
    }

    #[Route('/upload', name: 'upload', methods: 'POST')]
    public function upload(Request $request, FileManager $fileManager): Response
    {
        if (!$request->files->has('files')) {
            return $this->json(['status' => 0, 'message' => 'No files to upload.']);
        }

        foreach ($request->files->get('files') as $file) {
            try {
                $fileManager->upload($file);
            } catch (DBALException) {
                return $this->json(['status' => 0, 'message' => 'There has been a problem while saving file to database.']);
            } catch (FileException | \Exception $e) {
                return $this->json(['status' => 0, 'message' => $e->getMessage()]);
            }
        }

        return $this->json(['status' => 1, 'message' => 'All files uploaded successfully']);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(File $file, EntityManagerInterface $entityManager, FileManager $fileManager): Response
    {
        try {
            $entityManager->remove($file);
            $entityManager->flush();

            $fileManager->remove($file);

            return $this->json(['status' => 1]);
        } catch (IOException $e) {
            return $this->json(['status' => 0, 'message' => sprintf('Record deleted from database but file could not be deleted: %s', $e->getMessage())]);
        } catch (\Exception) {
            return $this->json(['status' => 0, 'message' => 'There has been a problem while deleting file from database.']);
        }
    }

    #[Route('/{id}', name: 'update', methods: 'PATCH')]
    public function update(File $file, Request $request, EntityManagerInterface $entityManager): Response
    {
        $updateAbleFields = $file->getUpdatableFields();

        foreach ($updateAbleFields as $field => $callable) {
            if ($request->get($field)) {
                call_user_func($callable, $request->get($field));
            }
        }

        $entityManager->flush();

        return $this->json(array_merge(['status' => 1], $file->jsonSerialize()));
    }

    #[Route('/abc')]
    public function test(FileRepository $fileRepository, ImageManager $imageManager)
    {
        foreach ($fileRepository->findAll() as $file) {
            $imageManager->resize($file, 500);
        }
    }
}
