<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\QuotasPolicy;
use Hyperf\Database\Model\Collection;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\Server\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class QuotaController extends AbstractController
{
    public function index(): Collection
    {
        return QuotasPolicy::get();
    }

    public function show(int $id): QuotasPolicy
    {
        $quota = QuotasPolicy::find($id);
        if ($quota === null) {
            throw new NotFoundHttpException('QuotaPolicy not found');
        }

        return $quota;
    }

    public function store(): QuotasPolicy
    {
        return QuotasPolicy::create($this->request->all());
    }

    public function update(int $id): ResponseInterface
    {
        try {
            if (QuotasPolicy::find($id)->update($this->request->all())) {
                return $this->response->withStatus(200);
            }
        } catch (\Exception $e) {
            $this->container->get(LoggerInterface::class)
                ->error($e->getMessage());
            throw new ServerException();
        }

        return $this->response->withStatus(404);
    }

    public function delete(int $id): ResponseInterface
    {
        try {
            if (QuotasPolicy::destroy($id)) {
                return $this->response->withStatus(204);
            }
        } catch (\Exception $e) {
            $this->container->get(LoggerInterface::class)
                ->error($e->getMessage());
            throw new ServerException();
        }

        return $this->response->withStatus(404);
    }
}
