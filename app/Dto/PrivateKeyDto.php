<?php

namespace App\Dto;

class PrivateKeyDto
{
    public int $userId;
    public string $cipherText;
    public string $iv;
    public string $salt;

}
