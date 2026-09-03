<?php

namespace App\Service;

use App\Dto\PrivateKeyDto;
use App\Models\UserPrivateKey;

class PrivateKeyService
{

    public function savePrivateKey(PrivateKeyDto $dto):void{

        $pKey= UserPrivateKey::where("user_id",$dto->userId)->first();
        if($pKey!=null) {
            $pKey->update([
                'ciphertext' => $dto->cipherText,
                'iv' => $dto->iv,
                'salt' => $dto->salt,
            ]);
            return;
        }
        UserPrivateKey::create([
            'user_id'=>$dto->userId,
            'ciphertext'=>$dto->cipherText,
            'iv'=>$dto->iv,
            'salt'=>$dto->salt,
        ]);

    }

}
