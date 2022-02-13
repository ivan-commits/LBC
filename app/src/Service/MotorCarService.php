<?php

namespace App\Service;

use App\Entity\MotorCar;

class MotorCarService extends HelperService
{
    public function searchMotorCar(string $payload) :?MotorCar
    {
        $words = $this->formatSearchPayload($payload);
        $result = !empty($words);
        $motorCar = null;
        //get words refer to a brand
        if($result){
            $wordsReferToBrand = [];
            foreach($words as $word){
                $motorCars = $this->doctrine->getRepository(MotorCar::class)->getByName($word);
                if(!empty($motorCars)){
                    $wordsReferToBrand[]= $word;
                }
            }
            $result = !empty($wordsReferToBrand);
        }
        //check if wordsReferToBrand combination refer unique motorcar
        if($result){
            $combination = $this->getCombination($wordsReferToBrand);
            $find= [];
            foreach($combination ?? [] as $words){
                $motorCars = $this->doctrine->getRepository(MotorCar::class)->findOneBy(['name'=>$words]);
                if($motorCars!==null){
                    $find[] = $motorCars;
                }
            }
            //check find unique motor_car
            $result = count($find) === 1;
        }

        if($result){
            $motorCar = $find[0];
        }

        return $motorCar;
    }
}