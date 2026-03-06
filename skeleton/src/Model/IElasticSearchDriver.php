<?php declare(strict_types=1);

namespace App\Model;

interface IElasticSearchDriver
{
/**
* @param string $id
* @return array
*/
public function findById($id);
}
