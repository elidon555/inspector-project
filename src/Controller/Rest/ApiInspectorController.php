<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Dto\Request\AssignJobRequest;
use App\Dto\Request\CompleteJobRequest;
use App\Dto\Response\AssessmentResponse;
use App\Dto\Response\InspectorResponse;
use App\Entity\Inspector;
use App\Entity\Job;
use App\Repository\AssessmentRepository;
use App\Repository\InspectorRepository;
use App\Service\AssessmentService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[OA\Tag(name: 'Inspectors')]
class ApiInspectorController extends AbstractController
{
    public function __construct(
        private readonly InspectorRepository $inspectorRepository,
        private readonly AssessmentRepository $assessmentRepository,
        private readonly AssessmentService $assessmentService,
    ) {
    }

    #[Route('/api/inspectors', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns all inspectors',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: InspectorResponse::class, groups: ['full']))
        )
    )]
    public function index()
    {
        $inspectors = $this->inspectorRepository->findAll();

        return $this->json($inspectors);
    }

    #[Route(
        path: 'api/inspectors/{id}/job',
        name: 'api_post_inspectors_job',
        requirements: ['id' => '\d+'],
        methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new Model(type: AssignJobRequest::class)
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Success.',
        content: new Model(type: AssessmentResponse::class, groups: [
            'assessments',
            'assessment.inspector',
            'inspectors',
            'assessment.job',
            'jobs',
        ])
    )]
    #[OA\Response(
        ref: '#/components/responses/UnprocessableEntity',
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
    )]
    public function assignJob(
        Inspector $inspector,
        #[MapRequestPayload] AssignJobRequest $request
    ): JsonResponse
    {
        $assignment = $this->assessmentService->assignJob($inspector, $request);
        return $this->json($assignment);
    }

    #[Route(
        path: '/api/inspectors/{id}/job/{jobId}',
        name: 'api_put_inspectors_job',
        requirements: ['id' => '\d+'],
        methods: ['PUT']
    )]
    #[OA\RequestBody(
        required: true,
        content: new Model(type: CompleteJobRequest::class)
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Success.'
    )]
    #[OA\Response(
        ref: '#/components/responses/UnprocessableEntity',
        response: Response::HTTP_UNPROCESSABLE_ENTITY
    )]
    public function completeJob(
        Inspector $inspector,
        Job $job,
        #[MapRequestPayload] CompleteJobRequest $request
    ): Response
    {
        $assessment = $this->assessmentRepository->findOneBy(
            ['inspector' => $inspector->getId(), 'job' => $job->getId()],
        );
        if (!$assessment){
            throw new NotFoundHttpException('No inspector is assigned to job with id ' . $job->getId());
        }
        $this->assessmentService->completeJob($assessment, $request);
        return $this->json(['message'=>'Job completed!']);
    }
}