<?php

namespace App\Services;

class UserDataService
{
    public function processUserData($data)
    {
        //business logic

        // Randomly choose a user from the data
        $randomIndex = rand(0, count($data) - 1);
        $user = $data[$randomIndex];

        //apply transformations
        $user = $this->applyTransformations($user);

        //calculate average age and email domain count
        $averageAge = $this->calculateAverageAge($data);
        $emailDomainCount = $this->countEmailDomainExtension($data);

        // get total record of users
        $totalRecord = $this->getTotalRecord($data);

        return [
            'user' => $user,
            'randomIndex' => $randomIndex,
            'averageAge' => $averageAge,
            'emailDomainCount' => $emailDomainCount,
            'totalRecord' => $totalRecord
        ];

    }

    private function applyTransformations($user)
    {
        //apply transformations to user data
        $user['firstName'] = ucwords($user['firstName']);
        $user['lastName'] = ucwords($user['lastName']);
        $user['email'] = strtolower($user['email']);
        $user['age'] = intval($user['age']);

        return $user;
    }

    private function calculateAverageAge($data)
    {
        $totalAge = 0;
        
        foreach($data as $record){
            $totalAge += $record['age'];
        }

        return $totalAge / count($data);
    }

    private function countEmailDomainExtension($data)
    {
        $emailDomainCount = [];
        
        foreach($data as $record){
            $domain = substr(strrchr($record['email'], "@"), 1);
            $parts = explode(".", $domain);
            $extenstion = $domain;

            if(count($parts) >= 2)
            {
                $extenstion = '.' . $parts[1];

                if(count($parts) >= 3 ){
                    $extenstion .= '.' . $parts[2];
                }
            } else {
                $extenstion = '.'.$parts[0];
            }

            if(!isset($emailDomainCount[$extenstion]))
            {
                $emailDomainCount[$extenstion] = 0;
            }

            $emailDomainCount[$extenstion]++;
        }

        return $emailDomainCount;
    }

    private function getTotalRecord($data)
    {
        return count($data);
    }
}