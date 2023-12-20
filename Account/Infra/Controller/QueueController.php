<?php

namespace Account\Infra\Controller;

use Account\Application\Gateway\MailerGateway;
use Account\Infra\Queue\Queue;


class QueueController
{
    public function __construct(readonly Queue $queue, readonly MailerGateway $mailerGateway)
    {
    }

    public function consumeAccountCreatedSendEmail(): void
    {
        $this->queue->consume("accountCreatedSendEmail", function ($message) {
            echo "[x] Message received from accountCreatedSendEmail " . PHP_EOL;
            $emailData = json_decode($message->body);
            $response = $this->mailerGateway->send(
                email: $emailData->email,
                subject: $emailData->subject,
                message: $emailData->message
            );
            var_dump($response);
            $message->ack();
        });
    }
}