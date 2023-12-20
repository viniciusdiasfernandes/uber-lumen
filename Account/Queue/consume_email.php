<?php

namespace Account\Queue;

require_once "vendor/autoload.php";

use Account\Infra\Controller\QueueController;
use Account\Infra\Gateway\MailerGatewayAmazon;
use Account\Infra\Queue\RabbitMQAdapter;

$rabbitMQAdapter = new RabbitMQAdapter();
$mailerGateway = new MailerGatewayAmazon();
$queueController = new QueueController($rabbitMQAdapter, $mailerGateway);
$queueController->consumeAccountCreatedSendEmail();
