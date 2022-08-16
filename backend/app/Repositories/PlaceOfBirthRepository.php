<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PlaceOfBirthList as Model;

class PlaceOfBirthRepository extends CoreSdnRepository
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

    if (isset($sdnEntry['uid']) && isset($sdnEntry['placeOfBirthList'])) {
      if (isset($sdnEntry['placeOfBirthList']['placeOfBirthItem']['uid'])) {
        $result[] = [
          'uid' => $sdnEntry['placeOfBirthList']['placeOfBirthItem']['uid'] ?? null,
          'uid_sdn_entry' => $sdnEntry['uid'],
          'date_of_birth' => $sdnEntry['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'] ?? null,
          'main_entry' => $sdnEntry['placeOfBirthList']['placeOfBirthItem']['mainEntry'] ?? null,
        ];
      } else {
        foreach ($sdnEntry['placeOfBirthList']['placeOfBirthItem'] as $dateOfBirthItem) {
          $result[] = [
            'uid' => $dateOfBirthItem['uid'] ?? null,
            'uid_sdn_entry' => $sdnEntry['uid'],
            'date_of_birth' => $dateOfBirthItem['placeOfBirth'] ?? null,
            'main_entry' => $dateOfBirthItem['mainEntry'] ?? null,
          ];
        }
      }
    }

    return $result;
  }

  public function empty(array $sdnEntry): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT * FROM place_of_birth_list WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
  }
}
