<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\IdList as Model;

class IdRepository extends CoreSdnRepository
{
  public function __construct()
  {
    parent::__construct();
  }

  protected function getModelClass(): string
  {
    return Model::class;
  }

  protected function parse(array $sdnEntry): array
  {
    $result = [];

    if (isset($sdnEntry['uid']) && isset($sdnEntry['idList'])) {
      if (isset($sdnEntry['idList']['id']['uid'])) {
        $result[] = [
          'uid' => $sdnEntry['idList']['id']['uid'] ?? null,
          'uid_sdn_entry' => $sdnEntry['uid'],
          'id_type' => $sdnEntry['idList']['id']['idType'] ?? null,
          'id_number' => $sdnEntry['idList']['id']['idNumber'] ?? null,
          'id_country' => $sdnEntry['idList']['id']['idCountry'] ?? null,
        ];
      } else {
        foreach ($sdnEntry['idList']['id'] as $id) {
          $result[] = [
            'uid' => $id['uid'] ?? null,
            'uid_sdn_entry' => $sdnEntry['uid'],
            'id_type' => $id['idType'] ?? null,
            'id_number' => $id['idNumber'] ?? null,
            'id_country' => $id['idCountry'] ?? null,
          ];
        }
      }
    }

    return $result;
  }

  public function empty(array $sdnEntry): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT * FROM id_list WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
  }
}
