<?php

namespace App\Service;

use App\Entity\ApiResult;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        if ($request->getMethod() === 'POST' || $request->getMethod() === 'PUT') {
            $payload = json_decode($request->getContent(), true);
        }
        $apiResult
            ->setCode($isApplicationJson ? 200 : 400)
            ->setData($payload)
            ->setContext($request->getRequestUri())
            ->setMessage($isApplicationJson ? 'success' : 'error Content-Type must be application/json');

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

    public function checkCodeApiResult(ApiResult $apiResult): bool
    {
        return $apiResult->getCode() === 200;
    }

    public function removeBlankItemFromArray(array $items): array
    {
        foreach ($items ?? [] as $key => $string) {
            if (empty(trim($string))) {
                unset($items[$key]);
            }
        }
        return $items;
    }

    public function formatSearchPayload(string $payload): array
    {
        $result = !empty($payload);
        $wordsArray = [];
        //escape special characters
        if ($result) {
            $cleanPayload = preg_replace('/[^a-z0-9]/i', ' ', $this->normalizeChars($payload));
            if (strlen($cleanPayload) < 2) {
                $result = false;
            }
        }
        //get distinct number from cleanPayload and merge it like words
        if ($result) {
            $nbNumbers = preg_match_all('!\d+!', $payload, $numbers);
            $cleanPayload = preg_replace('!\d+!', '', $cleanPayload);
            $words = explode(' ', $cleanPayload, 10);
            if ($nbNumbers > 0) {
                $words = array_merge($numbers[0] ?? [], $words);
            }
            $wordsArray = $this->removeBlankItemFromArray($words);
        }
        return $wordsArray;
    }

    public function getCombination($items): array
    {
        $allCombination = [];
        foreach ($items as $key => $word1) {
            foreach ($items as $i => $word2) {
                if ($i !== $key) {
                    $combinationWithoutBlank = $word1 . $word2;
                    $combination2WithBlank = $word1 . ' ' . $word2;
                    if (!in_array($combinationWithoutBlank, $allCombination, true) && !in_array($combination2WithBlank, $allCombination, true)) {
                        $allCombination[] = $combinationWithoutBlank;
                        $allCombination[] = $combination2WithBlank;
                    }

                }
            }
        }
        return $allCombination;
    }

    public function normalizeChars($s): string
    {
        $replace = array(
            '??'=>'-', '??'=>'-', '??'=>'-', '??'=>'-',
            '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'Ae',
            '??'=>'B',
            '??'=>'C', '??'=>'C', '??'=>'C',
            '??'=>'E', '??'=>'E', '??'=>'E', '??'=>'E', '??'=>'E',
            '??'=>'G',
            '??'=>'I', '??'=>'I', '??'=>'I', '??'=>'I', '??'=>'I',
            '??'=>'L',
            '??'=>'N', '??'=>'N',
            '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'Oe',
            '??'=>'S', '??'=>'S', '??'=>'S', '??'=>'S',
            '??'=>'T',
            '??'=>'U', '??'=>'U', '??'=>'U', '??'=>'Ue',
            '??'=>'Y',
            '??'=>'Z', '??'=>'Z', '??'=>'Z',
            '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'ae', '??'=>'ae', '??'=>'ae', '??'=>'ae',
            '??'=>'b', '??'=>'b', '??'=>'b', '??'=>'b',
            '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'ch', '??'=>'ch',
            '??'=>'d', '??'=>'d', '??'=>'d', '??'=>'d', '??'=>'d', '??'=>'d', '??'=>'D', '??'=>'d',
            '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e',
            '??'=>'f', '??'=>'f', '??'=>'f',
            '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g',
            '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h',
            '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'ij', '??'=>'ij',
            '??'=>'j', '??'=>'j', '??'=>'j', '??'=>'j', '??'=>'ja', '??'=>'ja', '??'=>'je', '??'=>'je', '??'=>'jo', '??'=>'jo', '??'=>'ju', '??'=>'ju',
            '??'=>'k', '??'=>'k', '??'=>'k', '??'=>'k', '??'=>'k', '??'=>'k', '??'=>'k',
            '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l',
            '??'=>'m', '??'=>'m', '??'=>'m', '??'=>'m',
            '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n',
            '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'oe', '??'=>'oe', '??'=>'oe',
            '??'=>'p', '??'=>'p', '??'=>'p', '??'=>'p',
            '??'=>'q',
            '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r',
            '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'sch', '??'=>'sch', '??'=>'sh', '??'=>'sh', '??'=>'ss',
            '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '???'=>'tm',
            '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'ue',
            '??'=>'v', '??'=>'v', '??'=>'v',
            '??'=>'w', '??'=>'w', '??'=>'w',
            '??'=>'y', '??'=>'y', '??'=>'y', '??'=>'y', '??'=>'y', '??'=>'y',
            '??'=>'y', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'zh', '??'=>'zh',
            '{'=>'', '}'=>'','('=>'',')'=>'','~'=>'','&'=>'','"'=>'',"'"=>'','['=>'',']'=>'','`'=>'','+'=>'','='=>'','^'=>'','??'=>'','??'=>'','??'=>'','$'=>'',
            '??'=>'','*'=>'','%'=>'',';'=>'',','=>'','<'=>'','>'=>'','??'=>'','???'=>' ','???'=>' '
        );
        return strtr($s, $replace);
    }

}