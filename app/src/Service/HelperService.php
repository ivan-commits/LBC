<?php

namespace App\Service;

use App\Entity\ApiResult;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

class HelperService
{
    protected $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function initApiResult($request): ApiResult
    {
        $isApplicationJson = 0 === strpos($request->headers->get('Content-Type'), 'application/json');

        $apiResult = new ApiResult();
        $payload = [];
        if($request->getMethod() === 'POST' || $request->getMethod() === 'PUT'){
            $payload = json_decode($request->getContent(), true);
        }
        $apiResult
            ->setCode($isApplicationJson ? 200 : 400)
            ->setData($payload)
            ->setContext($request->getRequestUri())
            ->setMessage($isApplicationJson ? 'initApiResult successful' : 'error Content-Type must be application/json');

        return $apiResult;
    }

    public function returnApiResult(ApiResult $apiResult): JsonResponse
    {
        $response = ["code" => $apiResult->getCode(),
            "message" => $apiResult->getMessage(),
            "context" => $apiResult->getContext(),
            "data" => $apiResult->getData()];

        return new JsonResponse($response, $apiResult->getCode());
    }

    public function checkCodeApiResult(ApiResult $apiResult) : bool
    {
        return $apiResult->getCode() === 200;
    }

    public function removeBlankItem(array &$items) : array
    {
        foreach ($items??[] as $key => $string){
            if(empty(trim($string))){
                unset($items[$key]);
            }
        }
        return $items;
    }

    public function formatSearchPayload(string $payload) : array
    {
        $payload = preg_replace('/[^a-z0-9]/i', ' ', $payload);
        $payload = explode(' ', $payload,10);
        return $this->removeBlankItem($payload) ;
    }
}