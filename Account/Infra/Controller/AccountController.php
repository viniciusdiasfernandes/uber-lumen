<?php

namespace Account\Infra\Controller;

use Account\Application\Repository\AccountRepository;
use Account\Application\UseCase\DTO\GetAccountInput;
use Account\Application\UseCase\DTO\SignupInput;
use Account\Application\UseCase\GetAccount;
use Account\Application\UseCase\Signup;
use Account\Infra\Controller\Validator\SignupRequestValidator;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Queue\RabbitMQAdapter;
use Account\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    private AccountRepository $accountRepository;

    public function __construct()
    {
        $this->accountRepository = new AccountRepositoryDatabase(new MySqlPromiseAdapter());
    }

    public function signup(Request $request): JsonResponse
    {
        try {
            SignupRequestValidator::execute($request);
            $queue = new RabbitMQAdapter();
            $signup = new Signup($this->accountRepository, $queue);
            $input = new SignupInput(
                name: $request->input("name"),
                email: $request->input("email"),
                cpf: $request->input("cpf"),
                password: $request->input("password"),
                isPassenger: $request->input("isPassenger"),
                isDriver: $request->input("isDriver"),
                carPlate: $request->input("carPlate")
            );
            $output = $signup->execute($input);
            return new JsonResponse($output, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return new JsonResponse($e->errors(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function getById(string $accountId): JsonResponse
    {
        try {
            $getAccount = new GetAccount($this->accountRepository);
            $input = new GetAccountInput($accountId);
            $output = $getAccount->execute($input);
            return new JsonResponse([
                    "success" => true,
                    "data" => $output
                ],
            Response::HTTP_OK
            );
        } catch (Exception $exception) {
            return new JsonResponse([
                    "success" => false,
                    "message" => $exception->getMessage()
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function update(string $accountId, Request $request): JsonResponse
    {
        try {
            $getAccount = new GetAccount($this->accountRepository);
            $input = new GetAccountInput($accountId);
            $output = $getAccount->execute($input);
            return new JsonResponse([
                "success" => true,
                "data" => $output
            ],
                Response::HTTP_OK
            );
        } catch (Exception $exception) {
            return new JsonResponse([
                "success" => false,
                "message" => $exception->getMessage()
            ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
