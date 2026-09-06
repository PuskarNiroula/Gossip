<?php

namespace App\Service;

use App\Exception\UserNotFoundException;
use App\Interface\UserRepoInterface;
use App\Jobs\SendUserVerificationEmail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;


class UserService{

    protected UserRepoInterface $userRepo;
    public function __construct()
    {
        $this->userRepo=app(UserRepoInterface::class);
    }

    public function createUser(array $data){
     if($this->userRepo->emailExists($data['email'])){
         throw new Exception('Email already exists');
     }
    DB::beginTransaction();
     try {
         $user = $this->userRepo->createUsers($data);
         if ($user == null)
             throw new Exception('Error creating user');
         SendUserVerificationEmail::dispatch($user);
         DB::commit();
         return $user;

     }catch (Exception $e){
         DB::rollBack();
         throw $e;
     }
    }

    public function updateProfile(array $data): User
    {
        $user = auth()->user();
        if (!$user) throw new UserNotFoundException('You are not logged in');
        if (!empty($data['avatar'])) {
            $file = $data['avatar'];
            $extension = $file->getClientOriginalExtension();

            if (!in_array(strtolower($extension), ['jpeg','jpg','png','gif','svg','webp'])) {
                throw new Exception('Invalid file type');
            }

            $filename = uniqid() . '_' . time() . '.' . $extension;

            $file->move(public_path('images/avatars'), $filename);

            if ($user->avatar && file_exists(public_path('images/avatars/' . $user->avatar))) {
                @unlink(public_path('images/avatars/' . $user->avatar));
            }

            $data['avatar'] = $filename;
        }

        return $this->userRepo->updateUser($user, $data);
    }

    /**
     * @throws UserNotFoundException
     */
    public function searchUser(string $name):array{
        $result = $this->userRepo->searchUser($name);

        if (!$result) {
            throw new UserNotFoundException('User not found');
        }

        return $result;
    }


}
