<?php

namespace App\Service;

use App\Dto\Request\AssignJobRequest;
use App\Dto\Request\CompleteJobRequest;
use App\Entity\Assessment;
use App\Entity\Inspector;
use App\Enum\AssessmentStatus;
use App\Enum\InspectorLocation;
use App\Enum\JobStatus;
use App\Repository\AssessmentRepository;
use App\Repository\JobRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class AssessmentService
{
    public function __construct(
        private AssessmentRepository $assessmentRepository,
        private JobRepository        $jobRepository,
        private LoggerInterface      $logger,
    )
    {
    }

    public function assignJob(
        Inspector $inspector,
        AssignJobRequest $request,
    ): Assessment {
        $this->logger->info(
            sprintf(
                "Start process to assign a new job to inspector with id %s.",
                $inspector->getId(),
            ),
        );
        $assessment = new Assessment();
        $job = $this->jobRepository->find($request->jobId);

        if (!$job) {
            throw new NotFoundHttpException('Job not found for id '. $request->jobId .'.');
        }

        if ($job->getStatus() === JobStatus::ASSIGNED->value) {
            throw new NotFoundHttpException('Job with id '. $request->jobId .' is assigned already.');
        }

        $currentTime = new \DateTime();;
        $timezone = $this->setTimezone($inspector, $currentTime);
        $assessment
            ->setInspector($inspector)
            ->setJob($job)
            ->setAssignedDate($timezone)
            ->setDeliveryDate(new \DateTime($request->deliveryDate))
            ->setStatus(AssessmentStatus::IN_PROGRESS);

        $this->assessmentRepository->save($assessment, true);

        $job->setStatus(JobStatus::ASSIGNED);
        $this->jobRepository->save($job, true);

        return $assessment;
    }

    public function completeJob(
        Assessment $assessment,
        CompleteJobRequest $request
    ): void {
        $this->logger->info(
            sprintf(
            "Start process to complete a job from inspector with id %s.",
            $assessment->getInspector()->getId(),
            ),
        );

        $assessment
            ->setNote($request->note)
            ->setStatus(AssessmentStatus::COMPLETED);
        $this->assessmentRepository->save($assessment, true);
    }

    private function setTimezone(
        Inspector $inspector,
        \DateTime $assignedDateTime
    ): \DateTime
    {
        $location = $inspector->getLocation();
        $dateTime = match($location) {
            InspectorLocation::TOKYO->value => $assignedDateTime->modify('+9 hours'),
            InspectorLocation::BERLIN->value,
            InspectorLocation::PARIS->value
            => $assignedDateTime->modify('+2 hours'),
            InspectorLocation::SYDNEY->value => $assignedDateTime->modify('+11 hours'),
            InspectorLocation::NEW_YORK->value => $assignedDateTime->modify('-4 hours'),
            InspectorLocation::LONDON->value => $assignedDateTime->modify('+1 hour'),
            default => $assignedDateTime,
        };

        $dateTime->format('Y-m-d H:i:s');

        return $dateTime;
    }
}