<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Quota;
use Hyperf\Database\Model\Collection;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\HttpServer\Contract\RequestInterface;

class QuotaController extends AbstractController
{
    public function index(): Collection
    {
        return Quota::get();
    }

    public function show(int $id): Quota
    {
        $quota = Quota::find($id);
        if ($quota === null) {
            throw new NotFoundHttpException('Quota not found');
        }

        return $quota;
    }

    public function store(): Quota
    {
        return Quota::create($this->request->all());
    }

    public function update(int $id): bool
    {
        return Quota::find($id)->update($this->request->all());
    }

    public function delete(): int
    {
        $id = $this->request->input('id');
        return Quota::destroy($id);
    }
}
