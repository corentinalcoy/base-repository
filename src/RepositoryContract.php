<?php

namespace Alcoy\Repository;

interface RepositoryContract
{

    public function getAll($columns = null, $orderBy = 'created_at', $sort = 'desc');

    public function getPaginated($number = 15, $orderBy = 'created_at', $sort = 'desc');

    public function getById($id);

    public function getItemByColumn($term, $column = 'slug');

    public function getCollectionByColumn($term, $column = 'slug', $orderBy = 'created_at', $sort = 'desc');

    public function create(array $data);

    public function updateOrCreate(array $identifiers, array $data);

    public function delete($id);

}