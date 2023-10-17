<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Dto\Response\InspectorResponse;
use App\Dto\Response\JobResponse;
use App\Repository\JobRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Jobs')]
class ApiJobController extends AbstractController
{
    public function __construct(
        private readonly JobRepository $jobRepository,
    ) {
    }

    #[Route(
        path: 'api/jobs',
        name: 'api_jobs_get',
        methods: ['GET']
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Success.',
        content: new Model(type: JobResponse::class, groups: ['jobs'])
    )]
    public function index(): JsonResponse
    {
        $jobs = $this->jobRepository->findAll();

        return $this->json($jobs);
    }
}