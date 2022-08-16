<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SdnEntry as Model;

class SdnEntryRepository extends CoreRepository
{

  public function __construct()
  {
    parent::__construct();
  }

  protected function getModelClass(): string
  {
    return Model::class;
  }

  /**
   * Создать изменить
   * @param array $sdnEntry
   * */
  public function CreateUpdate(array $sdnEntry)
  {
    $uid['uid'] = $sdnEntry['uid'];
    $data = $this->parse($sdnEntry);

    if (count($data)) {
      $this->startConditions()->updateOrCreate($uid, $data);
    }
  }

  /**
   * Парсер
   * @param array $sdnEntry
   * @return array
   */
  private function parse(array $sdnEntry): array
  {
    $result = [];

    if (isset($sdnEntry['uid'])) {
      $result['uid'] = $sdnEntry['uid'];
    }

    if (isset($sdnEntry['firstName'])) {
      $result['first_name'] = $sdnEntry['firstName'];
    }

    if (isset($sdnEntry['lastName'])) {
      $result['last_name'] = $sdnEntry['lastName'];
    }

    if (isset($sdnEntry['sdnType'])) {
      $result['sdn_type'] = $sdnEntry['sdnType'];
    }

    if (isset($sdnEntry['uid'])) {
      $result['uid'] = $sdnEntry['uid'];
    }

    if (isset($sdnEntry['title'])) {
      $result['title'] = $sdnEntry['title'];
    }

    if (isset($sdnEntry['remarks'])) {
      $result['remarks'] = $sdnEntry['remarks'];
    }

    return $result;
  }

  /**
   * @return bool
   */
  public function Empty(): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT uid FROM sdn_entry)');
  }

  /**
   * @param string $name
   * @return array
   */
  public function Strong(string $name): array
  {
    $arrName = explode(' ', $name);

    return $this->startConditions()
      ->select(['uid', 'first_name', 'last_name'])
      ->where(function ($query) use ($arrName) {
        foreach ($arrName as $name) {
          $query->orWhere('last_name', 'ilike', $name);
          $query->orWhere('first_name', 'ilike', $name);
        }
      })
      ->get()
      ->toArray();
  }

  /**
   * @param string $name
   * @return array
   */
  public function Weak(string $name): array
  {
    $result = [];
    $arrName = explode(' ', $name);

    if (isset($arrName[0])) {
      $build = $this->startConditions()
        ->select(['uid', 'first_name', 'last_name'])
        ->where('first_name', 'ilike', $arrName[0]);
      if (isset($arrName[1])) {
        $build = $build->where('last_name', 'ilike', $arrName[1]);
      }

      $result = $build->get()->toArray();
    }

    return $result;
  }
}
