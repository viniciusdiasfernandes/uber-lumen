<?php

namespace Account\Application\UseCase;

use Account\Application\Repository\AccountRepository;
use Account\Application\UseCase\DTO\LoginInput;
use Account\Application\UseCase\DTO\LoginOutput;
use Exception;

class Login
{
    public function __construct(readonly AccountRepository $accountRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(LoginInput $input): LoginOutput
    {
        $account = $this->accountRepository->getByEmail($input->email);
        if(!$account) throw new Exception("Invalid email");
        $isValidPassword = $account->password->validate($input->password);
        if(!$isValidPassword) throw new Exception("Invalid password");
        return new LoginOutput($account->accountId, $account->email->getValue());
    }
}