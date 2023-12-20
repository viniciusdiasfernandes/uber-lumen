<?php

namespace Account\Application\UseCase;

use Account\Application\Repository\AccountRepository;
use Account\Application\UseCase\DTO\ActivateAccountInput;
use Account\Application\UseCase\DTO\ActivateAccountOutput;
use Exception;

class ActivateAccount
{
    public function __construct(readonly AccountRepository $accountRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(ActivateAccountInput $input): ActivateAccountOutput
    {
        $account = $this->accountRepository->getByVerificationCode($input->verificationCode);
        if(!$account) throw new Exception("Invalid verification code");
        $account->active();
        $this->accountRepository->update($account);
        return new ActivateAccountOutput($account->email->getValue());
    }
}
