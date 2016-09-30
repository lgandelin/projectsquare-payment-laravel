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

    public function getAll()
    {
        $result = [];
        $platformModels = Platform::where('balance', '>', 0)->get();
        foreach ($platformModels as $platformModel) {
            $result[]= $this->convertModelToEntity($platformModel);
        }

        return $result;
    }

    public function persist(PlatformEntity $platform)
    {
        $platformModel = ($platform->getId()) ? Platform::find($platform->getID()) : new Platform();
        $platformModel->name = $platform->getName();
        $platformModel->slug = $platform->getSlug();
        $platformModel->users_count = $platform->getUsersCount();
        $platformModel->platform_monthly_cost = $platform->getPlatformMonthlyCost();
        $platformModel->user_monthly_cost = $platform->getUserMonthlyCost();
        $platformModel->balance = $platform->getAccountBalance();
        $platformModel->save();

        return $platformModel->id;
    }

    private function convertModelToEntity(Platform $platformModel)
    {
        $platform = new PlatformEntity();
        $platform->setId($platformModel->id);
        $platform->setName($platformModel->name);
        $platform->setSlug($platformModel->slug);
        $platform->setUsersCount($platformModel->users_count);
        $platform->setPlatformMonthlyCost($platformModel->platform_monthly_cost);
        $platform->setUserMonthlyCost($platformModel->user_monthly_cost);
        $platform->setAccountBalance($platformModel->balance);
        $platform->setCreationDate($platformModel->created_at);

        return $platform;
    }

    public function deleteByID($platformID)
    {
        if ($platform = Platform::find($platformID))
            $platform->delete();
    }
}
