<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Meeting;
use App\Repository\MeetingRepository;
use App\Service\PlanApiClient;
use App\Service\PlanHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class OpinionController extends AbstractController
{
    #[Route('/room/{room}')]
    public function forRoom(
        string $room,
        #[MapQueryParameter('now')] ?string $now,
        PlanHelper $planHelper,
        MeetingRepository $meetingRepository,
    ): Response
    {
        $now = new \DateTime($now ?? 'now');

        $meeting = $meetingRepository->findInRoom($room, $now);
        if (!$meeting) {
            $meetingDto = $planHelper->getMeetingInRoom($room, $now);
            if (!$meetingDto) {
                throw $this->createNotFoundException("Meeting in room $room not found at {$now->format('Y-m-d H:i:s')}");
            }
            $meeting = $meetingDto->buildMeeting();
            $meetingRepository->save($meeting, true);
        }

        return $this->redirectToRoute('app_opinion_formeeting', [
            'id' => $meeting->getId(),
        ]);
    }

    #[Route('/meeting/{id}')]
    public function forMeeting(Meeting $meeting): Response
    {
        return new Response($meeting->getName() . ' ' . $meeting->getRoom());
    }
}
