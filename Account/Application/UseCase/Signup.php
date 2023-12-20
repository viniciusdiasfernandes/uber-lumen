<?php

namespace Account\Application\UseCase;

use Account\Application\Repository\AccountRepository;
use Account\Application\UseCase\DTO\SignupInput;
use Account\Application\UseCase\DTO\SignupOutput;
use Account\Domain\Account;
use Account\Infra\Queue\Queue;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class Signup
{
    public function __construct(
        readonly AccountRepository $accountRepository,
        readonly Queue             $queue
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(SignupInput $input): SignupOutput
    {
        $accountAlreadyExists = $this->accountRepository->getByEmail($input->email);
        if ($accountAlreadyExists) throw new Exception("Email already in use", Response::HTTP_UNPROCESSABLE_ENTITY);
        $account = Account::create(
            name: $input->name,
            email: $input->email,
            cpf: $input->cpf,
            password: $input->password,
            isPassenger: $input->isPassenger,
            isDriver: $input->isDriver,
            carPlate: $input->carPlate
        );
        $this->accountRepository->save($account);
        $this->queue->publish("accountCreatedSendEmail", [
            "email" => $account->email->getValue(),
            "subject" => "Account created - Verification code received",
            "message" => "Verification code: {$account->verificationCode}"
        ]);
        return new SignupOutput(
            accountId: $account->accountId,
            verificationCode: $account->verificationCode
        );

    }
}
