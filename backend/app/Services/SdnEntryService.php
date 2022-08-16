<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\LocksRW;

use App\Repositories\SdnEntryRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\AkaRepository;
use App\Repositories\AddressRepository;
use App\Repositories\IdRepository;
use App\Repositories\DateOfBirthRepository;
use App\Repositories\PlaceOfBirthRepository;
use App\Repositories\VasselInfoRepository;
use App\Repositories\NationalityRepository;
use App\Repositories\CitizenshipRepository;
use App\Repositories\LocksRWRepository;

class SdnEntryService
{
  const TAG_ENTRY = 'sdnEntry';

  private $sdnEntryRepository;
  private $programRepository;
  private $akaRepository;
  private $addressRepository;
  private $idRepository;
  private $dateOfBirthRepository;
  private $placeOfBirthRepository;
  private $vasselInfoRepository;
  private $nationalityRepository;
  private $citizenshipRepository;
  private $locksRWRepository;

  public function __construct()
  {
    $this->sdnEntryRepository = app(SdnEntryRepository::class);
    $this->programRepository = app(ProgramRepository::class);
    $this->akaRepository = app(AkaRepository::class);
    $this->addressRepository = app(AddressRepository::class);
    $this->idRepository = app(IdRepository::class);
    $this->dateOfBirthRepository = app(DateOfBirthRepository::class);
    $this->placeOfBirthRepository = app(PlaceOfBirthRepository::class);
    $this->vasselInfoRepository = app(VasselInfoRepository::class);
    $this->nationalityRepository = app(NationalityRepository::class);
    $this->citizenshipRepository = app(CitizenshipRepository::class);
    $this->locksRWRepository = app(LocksRWRepository::class);
  }

  /**
   * @param string $url
   * @return bool
   */
  public function Update(string $url): bool
  {
    ini_set('max_execution_time', 6000);

    $result = true;

    if (!strlen($url)) {
      return !$result;
    }

    if ($this->locksRWRepository->Check(LocksRW::SDN_UPDATE_LOCK)) {
      return false;
    }

    if (!$this->locksRWRepository->Lock(LocksRW::SDN_UPDATE_LOCK)) {
      return false;
    }

    try {
      $xml = new \XMLReader;
      $xml->open($url);

      while ($xml->read()) {
        $arrOutput = [];

        if ($xml->nodeType === \XMLReader::ELEMENT && self::TAG_ENTRY == $xml->name) {
          $echo_outner_xml = $xml->readOuterXml();
          $objXmlDocument = simplexml_load_string($echo_outner_xml);
          $objJsonDocument = json_encode($objXmlDocument);
          $arrOutput = json_decode($objJsonDocument, TRUE);

          $xml->next();

          app('db')->beginTransaction();

          //sdnEntry
          $this->sdnEntryRepository->CreateUpdate($arrOutput);

          //programList
          if (isset($arrOutput['programList'])) {
            if (!$this->programRepository->Empty($arrOutput)) {
              $this->programRepository->Delete($arrOutput);
            }

            $this->programRepository->Create($arrOutput);
          }

          //akaList
          if (isset($arrOutput['akaList'])) {
            if (!$this->akaRepository->Empty($arrOutput)) {
              $this->akaRepository->Delete($arrOutput);
            }

            $this->akaRepository->Create($arrOutput);
          }

          //addressList
          if (isset($arrOutput['addressList'])) {
            if (!$this->addressRepository->Empty($arrOutput)) {
              $this->addressRepository->Delete($arrOutput);
            }

            $this->addressRepository->Create($arrOutput);
          }

          //idList
          if (isset($arrOutput['idList'])) {
            if (!$this->idRepository->Empty($arrOutput)) {
              $this->idRepository->Delete($arrOutput);
            }

            $this->idRepository->Create($arrOutput);
          }

          //dateOfBirthList
          if (isset($arrOutput['dateOfBirthList'])) {
            if (!$this->dateOfBirthRepository->Empty($arrOutput)) {
              $this->dateOfBirthRepository->Delete($arrOutput);
            }

            $this->dateOfBirthRepository->Create($arrOutput);
          }

          //placeOfBirthList
          if (isset($arrOutput['placeOfBirthList'])) {
            if (!$this->placeOfBirthRepository->Empty($arrOutput)) {
              $this->placeOfBirthRepository->Delete($arrOutput);
            }

            $this->placeOfBirthRepository->Create($arrOutput);
          }

          //vesselInfo
          if (isset($arrOutput['vesselInfo'])) {
            if (!$this->vasselInfoRepository->Empty($arrOutput)) {
              $this->vasselInfoRepository->Delete($arrOutput);
            }

            $this->vasselInfoRepository->Create($arrOutput);
          }

          //nationalityList
          if (isset($arrOutput['nationalityList'])) {
            if (!$this->nationalityRepository->Empty($arrOutput)) {
              $this->nationalityRepository->Delete($arrOutput);
            }

            $this->nationalityRepository->Create($arrOutput);
          }

          //citizenshipList
          if (isset($arrOutput['citizenshipList'])) {
            if (!$this->citizenshipRepository->Empty($arrOutput)) {
              $this->citizenshipRepository->Delete($arrOutput);
            }

            $this->citizenshipRepository->Create($arrOutput);
          }

          app('db')->commit();
        }
      }

      $xml->close();
    } catch (\Exception $exception) {
      app('db')->rollBack();
      app('log')->debug($exception);
      app('log')->debug($arrOutput);
      $result = false;
    }

    $this->locksRWRepository->UnLock(LocksRW::SDN_UPDATE_LOCK);

    return $result;
  }

  /**
   * @return array
   */
  public function State(): array
  {
    if ($this->sdnEntryRepository->Empty()) {
      return ['result' => false, 'info' => 'empty'];
    }

    if ($this->locksRWRepository->Check(LocksRW::SDN_UPDATE_LOCK)) {
      return ['result' => false, 'info' => 'updating'];
    }

    return ['result' => true, 'info' => 'ok'];
  }

  /**
   * @param string $name
   * @param string $type
   * @return array
   */
  public function GetNames(string $name, string $type): array
  {
    $result = [];

    switch ($type) {
      case 'strong':
        $result = $this->sdnEntryRepository->Strong($name);
        break;
      default:
        $result = $this->sdnEntryRepository->Weak($name);
        break;
    }

    return $result;
  }
}
