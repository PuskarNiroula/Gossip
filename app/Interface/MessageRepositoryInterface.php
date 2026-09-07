<?php
namespace App\Interface;

interface MessageRepositoryInterface
{
    public function createMessage(array $messageDto);
    public function getMessagesByConversation(int $conversationId, int $perPage);
    public function markAsRead(int $conversationId);

    public function isUnread(int $conversationId,int $myId):bool;

}
