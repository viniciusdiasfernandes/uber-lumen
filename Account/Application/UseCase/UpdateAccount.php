<?php

namespace Account\Application\UseCase;

use Account\Application\Repository\AccountRepository;
use Account\Application\UseCase\DTO\UpdateAccountInput;
use Account\Application\UseCase\DTO\UpdateAccountOutput;
use Account\Domain\Account;
use Account\Domain\PasswordFactory;
use Exception;

class UpdateAccount
{
    public function __construct(
        readonly AccountRepository $accountRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(UpdateAccountInput $input): UpdateAccountOutput
    {
        $account = $this->accountRepository->getById($input->accountId);
        if (!$account) throw new Exception("Account not found");
        if ($input->email !== $account->email->getValue()) {
            $checkIfEmailIsInUse = $this->accountRepository->getByEmail($input->email);
            if ($checkIfEmailIsInUse) throw new Exception("Cannot use this email");
        }
        $account = Account::restore(
            accountId: $input->accountId,
            name: $input->name,
            email: $input->email,
            cpf: $input->cpf,
            password: PasswordFactory::create("hash",$input->password)->getValue(),
            status: $account->getStatus(),
            isPassenger: $account->isPassenger,
            isDriver: $account->isDriver,
            verificationCode: $account->verificationCode,
            carPlate: $input->carPlate
        );
        $this->accountRepository->update($account);
        return new UpdateAccountOutput(
            accountId: $account->accountId,
            name: $account->name,
            email: $account->email->getValue(),
            cpf: $account->cpf->getValue(),
            password: $account->password->getValue(),
            isPassenger: $account->isPassenger,
            isDriver: $account->isDriver,
            carPlate: $account->carPlate
        );

    }
}