<?php

namespace App\Controller;

use App\Service\HelperService;
use App\Service\PostService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostCreateController extends AbstractController
{
    /**
     * @Route("/post", name="post_create", methods={"POST"})
     */
    public function create(Request $request, HelperService $helperService, PostService $postService): JsonResponse
    {
        $apiResult = $postService->create($helperService->initApiResult($request));

        return $helperService->returnApiResult($apiResult);
    }
}
