<?php

namespace App\Traits;

trait ComputeAddressTrait
{
    public function computeAddress()
    {
        $senderAddress = $this->sender_street . ', ' . $this->sender_apartment_no . ', ' . $this->sender_apartment . ', ' . $this->sender_lga . ', ' . $this->sender_state;
        $receiverAddress = $this->receiver_street . ', ' . $this->receiver_apartment_no . ', ' . $this->receiver_apartment . ', ' . $this->receiver_lga . ', ' . $this->receiver_state;

        return [
            'sender_address' => $senderAddress,
            'receiver_address' => $receiverAddress
        ];
    }
}
