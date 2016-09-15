<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Repositories;

use Webaccess\ProjectSquarePayment\Entities\Administrator as AdministratorEntity;
use Webaccess\ProjectSquarePayment\Repositories\AdministratorRepository;
use Webaccess\ProjectSquarePaymentLaravel\Models\Administrator;

class EloquentAdministratorRepository implements AdministratorRepository
{
    public function getByID($administratorID)
    {
        if ($administratorModel = Administrator::find($administratorID)) {
            return $this->convertModelToEntity($administratorModel);
        }

        return false;
    }

    public function persist(AdministratorEntity $administrator)
    {
        $administratorModel = ($administrator->getId()) ? Administrator::find($administrator->getID()) : new Administrator();
        $administratorModel->email = $administrator->getEmail();
        $administratorModel->password = $administrator->getPassword();
        $administratorModel->last_name = $administrator->getLastName();
        $administratorModel->first_name = $administrator->getFirstName();
        $administratorModel->billing_address = $administrator->getBillingAddress();
        $administratorModel->zipcode = $administrator->getZipCode();
        $administratorModel->city = $administrator->getCity();
        $administratorModel->platform_id = $administrator->getPlatformID();
        $administratorModel->save();

        return $administratorModel->id;
    }

    private function convertModelToEntity(Administrator $administratorModel): AdministratorEntity
    {
        $administrator = new AdministratorEntity();
        $administrator->setId($administratorModel->id);
        $administrator->setEmail($administratorModel->email);
        $administrator->setPassword($administratorModel->password);
        $administrator->setLastName($administratorModel->last_name);
        $administrator->setFirstName($administratorModel->first_name);
        $administrator->setBillingAddress($administratorModel->billing_address);
        $administrator->setZipCode($administratorModel->zipcode);
        $administrator->setCity($administratorModel->city);
        $administrator->setPlatformID($administratorModel->administrator_id);

        return $administrator;
    }
}
