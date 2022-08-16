<?php

declare(strict_types=1);

namespace App\Repositories;

abstract class CoreSdnRepository extends CoreRepository
{
  /**
   * Парсер
   * @param array $sdnEntry
   * @return array
   */
  abstract protected function parse(array $sdnEntry): array;

  /**
   * Пусто
   * @param array $sdnEntry
   * @return bool
   */
  abstract public function Empty(array $sdnEntry): bool;

  /**
   * Создать
   * @param array $sdnEntry
   * */
  public function Create(array $sdnEntry)
  {
    $arrModel = $this->parse($sdnEntry);

    if (count($arrModel)) {
      foreach ($arrModel as $model) {
        $this->startConditions()->create($model);
      }
    }
  }

  /**
   * Удалить
   * @param array $sdnEntry
   * */
  public function Delete(array $sdnEntry)
  {
    $this->startConditions()->where('uid_sdn_entry', $sdnEntry['uid'])->delete();
  }
}
