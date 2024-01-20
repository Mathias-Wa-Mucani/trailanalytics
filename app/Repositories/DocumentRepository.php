<?php

namespace App\Repositories;

use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Collection;

class DocumentRepository extends Repository implements DocumentRepositoryInterface
{

    /**
     * @param Document $model
     */
    public function __construct(Document $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    public function getByDocmentTag($tag)
    {
        return $this->model->whereDocumentTag($tag)->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }
}
