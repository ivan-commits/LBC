<?php

namespace App\Controller;

use App\Service\HelperService;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostUpdateController extends AbstractController
{
    /**
     * @Route("/post/{id}", name="post_update", methods={"PUT"})
     */
    public function create(Request $request, HelperService $helperService, PostService $postService, int $id): JsonResponse
    {
        $apiResult = $postService->update($helperService->initApiResult($request), $id);

        return $helperService->returnApiResult($apiResult);
    }
}