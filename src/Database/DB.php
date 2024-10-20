<?php

namespace Mvc\Database;

use Mvc\Database\Concerns\ConnectsTo;
use Mvc\Database\Managers\Contracts\DatabaseManager;

class DB
{
    protected DatabaseManager $manager;

    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }

    public function init()
    {
        ConnectsTo::connect($this->manager);
    }

    protected function raw(string $query, $values = [])
    {
        return $this->manager->query($query, $values);
    }

    protected function read($columns = '*', $filters = null)
    {
        return $this->manager->read($columns, $filters);
    }

    protected function create(array $data)
    {
        return $this->manager->create($data);
    }

    protected function update($id, $data)
    {
        return $this->manager->update($id, $data);
    }

    protected function delete($id)
    {
        return $this->manager->delete($id);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name))
            return call_user_func_array([$this, $name], $arguments);
    }
}
