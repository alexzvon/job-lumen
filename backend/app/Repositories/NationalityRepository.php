<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\NationalityList as Model;

class NationalityRepository extends CoreSdnRepository
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

    if (isset($sdnEntry['uid']) && isset($sdnEntry['nationalityList'])) {
      if (isset($sdnEntry['nationalityList']['nationality']['uid'])) {
        $result[] = [
          'uid' => $sdnEntry['nationalityList']['nationality']['uid'] ?? null,
          'uid_sdn_entry' => $sdnEntry['uid'],
          'country' => $sdnEntry['nationalityList']['nationality']['country'] ?? null,
          'main_entry' => $sdnEntry['nationalityList']['nationality']['mainEntry'] ?? null,
        ];
      } else {
        foreach ($sdnEntry['nationalityList']['nationality'] as $nationality) {
          $result[] = [
            'uid' => $nationality['uid'] ?? null,
            'uid_sdn_entry' => $sdnEntry['uid'],
            'country' => $nationality['country'] ?? null,
            'main_entry' => $nationality['mainEntry'] ?? null,
          ];
        }
      }
    }

    return $result;
  }

  public function empty(array $sdnEntry): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT * FROM nationality_list WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
  }
}
