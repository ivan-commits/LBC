<?php

namespace App\Service;

use App\Entity\MotorCar;

class MotorCarService extends HelperService
{
    public function searchMotorCar(string $payload)
    {
        $words = $this->formatSearchPayload($payload);
        $result = !empty($words);
        $find= [];
        $motorCar = null;
        //get words refer to a brand
        if($result){
            $goodWords = [];
            foreach($words as $word){
                $motorCars = $this->doctrine->getRepository(MotorCar::class)->getByName($word);
                if(!empty($motorCars)){
                    $goodWords[]= $word;
                }
            }
            $result = !empty($goodWords);
        }
        //check if good words combination refer to motor_car
        if($result){
            $combination = $this->getCombination($goodWords);
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