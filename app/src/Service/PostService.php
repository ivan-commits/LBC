<?php

namespace App\Service;

use App\Constant;
use App\Entity\ApiResult;
use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;

class PostService extends HelperService
{
    private $categoryService;
    private $motorCarService;

    public function __construct(CategoryService $categoryService, ManagerRegistry $doctrine, MotorCarService $motorCarService)
    {
        parent::__construct($doctrine);
        $this->categoryService = $categoryService;
        $this->motorCarService = $motorCarService;
    }

    public function create(ApiResult $apiResult): ApiResult
    {
        $result = $this->checkCodeApiResult($apiResult);
        //check empty payload
        if ($result) {
            $payload = $apiResult->getData();
            if (empty($payload)) {
                $result = false;
                $apiResult->setMessage('payload is empty');
            }
        }
        //check category
        if ($result) {
            $category = $this->categoryService->getCategoryEntity($payload['category']);
            $result = $this->checkPayloadByCategory($payload, $category);
            if (!$result) {
                $apiResult->setMessage('Error: category not found');
            }
        }
        //check params by category
        if ($result) {
            $post = $this->createPostByCategory($payload, $category);
            if ($post === null) {
                $apiResult->setMessage('Error: payload incorrect for category');
                $result = false;
            }
        }
        //create post
        if ($result) {
            $this->doctrine->getManager()->persist($post);
            $this->doctrine->getManager()->flush();
            $post = ['id'=>$post->getId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'brandCar' => $post->getBrandCar(),
                'carName' => $post->getNameCar()];
            $apiResult->setData($post);
        }

        $apiResult->setContext('PostService: create');
        $apiResult->setCode($result ? 200 : 400);

        return $apiResult;
    }

    public function read(ApiResult $apiResult, int $id): ApiResult
    {
        $result = $this->checkCodeApiResult($apiResult);
        //check post
        if ($result) {
            $post = $this->doctrine->getRepository(Post::class)->find($id);
            if ($post === null) {
                $result = false;
                $apiResult->setMessage('Error: post not found for id '.$id);
            }
        }
        // read post
        if ($result) {
            $post = ['title' => $post->getTitle(),
                'content' => $post->getContent(),
                'brandCar' => $post->getBrandCar(),
                'carName' => $post->getNameCar()];
            $apiResult->setData($post);
            $apiResult->setMessage('success');
        }
        
        $apiResult->setContext('PostService: read');
        $apiResult->setCode($result ? 200 : 400);

        return $apiResult;
    }

    public function update(ApiResult $apiResult, int $id): ApiResult
    {
        $result = $this->checkCodeApiResult($apiResult);
        //check post
        if ($result) {
            $post = $this->doctrine->getRepository(Post::class)->find($id);
            if ($post === null) {
                $result = false;
                $apiResult->setMessage('Error: post not found for id '.$id);
            }
        }
        //check empty payload
        if ($result) {
            $payload = $apiResult->getData();
            if (empty($payload)) {
                $result = false;
                $apiResult->setMessage('payload is empty');
            }
        }
        //check category
        if ($result) {
            $category = $this->categoryService->getCategoryEntity($payload['category']);
            $result = $this->checkPayloadByCategory($payload, $category);
            if (!$result) {
                $apiResult->setMessage('Error: category not found');
            }
        }
        //check params by category
        if ($result) {
            $post = $this->editPostByCategory($payload, $category, $post);
            if ($post === null) {
                $apiResult->setMessage('Error: payload incorrect for category');
                $result = false;
            }
        }
        //create post
        if ($result) {
            $this->doctrine->getManager()->persist($post);
            $this->doctrine->getManager()->flush();

            $post = ['title' => $post->getTitle(),
                'content' => $post->getContent(),
                'brandCar' => $post->getBrandCar(),
                'carName' => $post->getNameCar()];
            $apiResult->setData($post);
        }
        $apiResult->setContext('PostService: update');
        $apiResult->setCode($result ? 200 : 400);
        return $apiResult;
    }

    public function delete(ApiResult $apiResult, $id): ApiResult
    {
        $result = $this->checkCodeApiResult($apiResult);
        //check post
        if ($result) {
            $post = $this->doctrine->getRepository(Post::class)->find($id);
            if ($post === null) {
                $result = false;
                $apiResult->setMessage('Error: post not found for id '.$id);
            }
        }
        //delete post
        if ($result) {
            $apiResult->setData(['title' => $post->getTitle()]);
            $apiResult->setMessage('success');

            $this->doctrine->getManager()->remove($post);
            $this->doctrine->getManager()->flush();
        }

        $apiResult->setContext('PostService: delete');
        $apiResult->setCode($result ? 200 : 400);

        return $apiResult;
    }

    private function checkPayloadByCategory(array $payload, ?Category $category): bool
    {
        $result = $category !== null && !empty($payload['title']) && !empty($payload['content']);
        //check category MotorCar
        if ($result && $category->getName() === Constant::CATEGORY_MOTORCAR) {
            $result = !empty($payload['carName']);
        }

        return $result;
    }

    private function createPostByCategory(array $payload, $category): ?Post
    {
        $result = !empty($payload) && $category !== null;
        $motorCar = null;
        $post = null;

        if ($result && $category->getName() === Constant::CATEGORY_MOTORCAR) {
            $motorCar = $this->motorCarService->searchMotorCar($payload['carName']);
            if ($motorCar === null) {
                $result = false;
            }
        }

        if ($result) {
            $post = new Post();
            $post
                ->setTitle($payload['title'])
                ->setContent($payload['content'])
                ->setBrandCar($motorCar !== null ? $motorCar->getBrand() : null)
                ->setNameCar($motorCar !== null ? $motorCar->getName() : null)
                ->setCategory($category);
        }

        return $post;
    }

    private function editPostByCategory(array $payload, Category $category, Post $post): ?Post
    {
        $result = !empty($payload);
        $motorCar = null;

        if ($result && $category->getName() === Constant::CATEGORY_MOTORCAR) {
            $motorCar = $this->motorCarService->searchMotorCar($payload['carName']);
            if ($motorCar === null) {
                $result = false;
            }
        }

        if ($result) {
            $post
                ->setTitle($payload['title'])
                ->setContent($payload['content'])
                ->setBrandCar($motorCar !== null ? $motorCar->getBrand() : null)
                ->setNameCar($motorCar !== null ? $motorCar->getName() : null)
                ->setCategory($category);

            return $post;
        }

        return null;
    }
}