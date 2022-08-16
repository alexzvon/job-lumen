<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AddressList as Model;

class AddressRepository extends CoreSdnRepository
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

    if (isset($sdnEntry['uid']) && isset($sdnEntry['addressList'])) {
      if (isset($sdnEntry['addressList']['address']['uid'])) {
        $result[] = [
          'uid' => $sdnEntry['addressList']['address']['uid'] ?? null,
          'uid_sdn_entry' => $sdnEntry['uid'],
          'city' => $sdnEntry['addressList']['address']['city'] ?? null,
          'address1' => $sdnEntry['addressList']['address']['address1'] ?? null,
          'address2' => $sdnEntry['addressList']['address']['address2'] ?? null,
          'address3' => $sdnEntry['addressList']['address']['address3'] ?? null,
          'country' => $sdnEntry['addressList']['address']['country'] ?? null,
          'postal_code' => $sdnEntry['addressList']['address']['postalCode'] ?? null,
        ];
      } else {
        foreach ($sdnEntry['addressList']['address'] as $address) {
          $result[] = [
            'uid' => $address['uid'] ?? null,
            'uid_sdn_entry' => $sdnEntry['uid'],
            'city' => $address['city'] ?? null,
            'address1' => $address['address1'] ?? null,
            'address2' => $address['address2'] ?? null,
            'address3' => $address['address3'] ?? null,
            'country' => $address['country'] ?? null,
            'postal_code' => $address['postalCode'] ?? null,
          ];
        }
      }
    }

    return $result;
  }

  public function empty(array $sdnEntry): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT * FROM address_list WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
  }
}
