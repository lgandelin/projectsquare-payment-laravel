<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Repositories;

use Webaccess\ProjectSquarePayment\Entities\Platform as PlatformEntity;
use Webaccess\ProjectSquarePayment\Repositories\PlatformRepository;
use Webaccess\ProjectSquarePaymentLaravel\Models\Platform;

class EloquentPlatformRepository implements PlatformRepository
{
    public function getByID($platformID)
    {
        if ($platformModel = Platform::find($platformID)) {
            return $this->convertModelToEntity($platformModel);
        }

        return false;
    }

    public function getBySlug($platformSlug)
    {
        if ($platformModel = Platform::where('slug', '=', $platformSlug)->first()) {
            return $this->convertModelToEntity($platformModel);
        }

        return false;
    }

    public function persist(PlatformEntity $platform)
    {
        $platformModel = ($platform->getId()) ? Platform::find($platform->getID()) : new Platform();
        $platformModel->name = $platform->getName();
        $platformModel->slug = $platform->getSlug();
        $platformModel->users_count = $platform->getUsersCount();
        $platformModel->save();

        return true;
    }

    private function convertModelToEntity(Platform $platformModel): PlatformEntity
    {
        $platform = new PlatformEntity();
        $platform->setId($platformModel->id);
        $platform->setName($platformModel->name);
        $platform->setSlug($platformModel->slug);
        $platform->setUsersCount($platformModel->users_count);

        return $platform;
    }
}