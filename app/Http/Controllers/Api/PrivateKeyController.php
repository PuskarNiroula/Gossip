<?php

namespace App\Http\Controllers\Api;


use App\Dto\PrivateKeyDto;
use App\Models\UserPrivateKey;
use App\Service\PrivateKeyService;
use Exception;
use Illuminate\Http\Request;

class PrivateKeyController
{
    private PrivateKeyService $privateKeyService;

    public function __construct()
    {
        $this->privateKeyService=new PrivateKeyService();
    }

    public function savePrivateKey(Request $request){
        $request->validate([
            'ciphertext'=>'required|string',
            'iv'=>'required|string',
            'salt'=>'required|string'
        ]);

       $dto = new PrivateKeyDto();
       $dto->userId=auth()->id();
       $dto->cipherText=$request->ciphertext;
       $dto->iv=$request->iv;
       $dto->salt=$request->salt;

       try{
           $this->privateKeyService->savePrivateKey($dto);
           return response()->json([
               'status'=> "Recovery password updated successfully",
           ]);
       }catch (Exception $e){
           return response()->json([
               'status'=> "Failed to update recovery password",
               'message'=> $e->getMessage(),
           ]);
       }

    }
    public function getPrivateKeyMetaData(){
        $user=auth()->user();
        if(!$user){
            return response()->json([
                'message'=>"User not found"
            ],404);
        }
        $pKey = UserPrivateKey::where("user_id",$user->id)->first();
        if(!$pKey){
            return response()->json([
                'message'=>"User has no private key"
            ],404);
        }
        return response()->json([
            'status' => 'success',
            'cipherText' => $pKey->ciphertext,
            'iv' => $pKey->iv,
            'salt' => $pKey->salt,
            'userId'=>$pKey->user_id,
        ]);
    }
}
