<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AkaList as Model;

class AkaRepository extends CoreSdnRepository
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

    if (isset($sdnEntry['uid']) && isset($sdnEntry['akaList'])) {
      if (isset($sdnEntry['akaList']['aka']['uid'])) {
        $result[] = [
          'uid' => $sdnEntry['akaList']['aka']['uid'] ?? null,
          'uid_sdn_entry' => $sdnEntry['uid'],
          'type' => $sdnEntry['akaList']['aka']['type'] ?? null,
          'category' => $sdnEntry['akaList']['aka']['category'] ?? null,
          'last_name' => $sdnEntry['akaList']['aka']['lastName'] ?? null,
        ];
      } else {
        foreach ($sdnEntry['akaList']['aka'] as $aka) {
          $result[] = [
            'uid' => $aka['uid'] ?? null,
            'uid_sdn_entry' => $sdnEntry['uid'],
            'type' => $aka['type'] ?? null,
            'category' => $aka['category'] ?? null,
            'last_name' => $aka['lastName'] ?? null,
          ];
        }
      }
    }

    return $result;
  }

  public function empty(array $sdnEntry): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT * FROM aka_list WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
  }
}
