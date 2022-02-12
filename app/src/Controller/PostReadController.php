<?php

namespace App\Controller;

use App\Service\HelperService;
use App\Service\PostService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostReadController extends AbstractController
{
    /**
     * @Route("/post/{id}", name="post_read", methods={"GET"})
     */
    public function read(Request $request, HelperService $helperService, PostService $postService, int $id): JsonResponse
    {
        $apiResult = $postService->read($helperService->initApiResult($request), $id);

        return $helperService->returnApiResult($apiResult);
    }
}
