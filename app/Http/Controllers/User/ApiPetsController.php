<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Users\RegistryBird;
use App\Models\Users\RegistryCat;
use App\Models\Users\RegistryDog;
use App\Models\Users\RegistryOtherAnimal;
use App\Models\Users\RegistryRabbit;
use Illuminate\Http\Request;

class ApiPetsController extends Controller
{
    public function getallPets()
    {
        $birds = RegistryBird::select('PetNo', 'PetName', 'breed', 'DateAdded')->get()->map(function ($item) {
            $item['category'] = 'bird';
            return $item;
        });

        $cats = RegistryCat::select('PetNo', 'PetName', 'breed', 'DateAdded')->get()->map(function ($item) {
            $item['category'] = 'cat';
            return $item;
        });

        $dogs = RegistryDog::select('PetNo', 'PetName', 'breed', 'DateAdded')->get()->map(function ($item) {
            $item['category'] = 'dog';
            return $item;
        });

        $rabbits = RegistryRabbit::select('PetNo', 'PetName', 'breed', 'DateAdded')->get()->map(function ($item) {
            $item['category'] = 'rabbit';
            return $item;
        });

        $otherPetss = RegistryOtherAnimal::select('PetNo', 'PetName', 'AnimalType', 'DateAdded')->get()->map(function ($item) {
            $item['category'] = 'other_pet';
            return $item;
        });

        $mergedData = collect()
            ->concat($birds)
            ->concat($cats)
            ->concat($dogs)
            ->concat($rabbits)
            ->concat($otherPetss);
        return response()->json($mergedData,200,['Content-Type', 'application/json; charset=utf-8'],JSON_INVALID_UTF8_IGNORE);

    }
}
