<?php

namespace Account\Application\UseCase;

use Account\Application\Repository\AccountRepository;
use Account\Application\UseCase\DTO\GetAccountInput;
use Account\Application\UseCase\DTO\GetAccountOutput;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class GetAccount
{
    public function __construct(readonly AccountRepository $accountRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(GetAccountInput $input): GetAccountOutput
    {
        $account = $this->accountRepository->getById($input->accountId);
        if (!$account) throw new Exception("Trying to get account but it do not exists", Response::HTTP_UNPROCESSABLE_ENTITY);
        return new GetAccountOutput(
            $account->accountId,
            $account->name,
            $account->email->getValue(),
            $account->cpf->getValue(),
            $account->password->getValue(),
            $account->isPassenger,
            $account->isDriver,
            $account->carPlate,
        );
    }
}
