<?php

namespace Account\Application\UseCase;

use Account\Application\UseCase\DTO\ForgetAccountOutput;
use Account\Application\Repository\AccountRepository;
use Account\Application\UseCase\DTO\ForgetAccountInput;
use Exception;

class ForgetAccount
{
    public function __construct(
        readonly AccountRepository $accountRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(ForgetAccountInput $input): ForgetAccountOutput
    {
        $account = $this->accountRepository->getById($input->accountId);
        if (!$account) throw new Exception("Account not found");
        $account->forget();
        $this->accountRepository->update($account);
        return new ForgetAccountOutput(
            accountId: $account->accountId,
            status: $account->getStatus()
        );

    }
}