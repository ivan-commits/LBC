<?php

namespace App\Controller;

use App\Service\HelperService;
use App\Service\PostService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostDeleteController extends AbstractController
{
    /**
     * @Route("/post/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, HelperService $helperService, PostService $postService, int $id): JsonResponse
    {
        $apiResult = $postService->delete($helperService->initApiResult($request), $id);

        return $helperService->returnApiResult($apiResult);
    }
}