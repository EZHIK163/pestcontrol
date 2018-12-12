<?php
namespace app\repositories;

use app\dto\Disinfectant;
use app\entities\DisinfectantRecord;
use app\exceptions\DisinfectantNotFound;
use RuntimeException;

/**
 * Class DisinfectantRepository
 * @package app\repositories
 */
class DisinfectantRepository implements DisinfectantRepositoryInterface
{

    /**
     * @param $id
     * @return Disinfectant
     * @throws DisinfectantNotFound
     */
    public function get($id)
    {
        /**
         * @var DisinfectantRecord $disinfectantRecord
         */
        $disinfectantRecord = $this->findOrFail($id);

        $disinfectant = $this->fillDisinfectant($disinfectantRecord);

        return $disinfectant;
    }

    /**
     * @param Disinfectant $disinfectant
     * @return Disinfectant
     * @throws \Throwable
     */
    public function add(Disinfectant $disinfectant)
    {
        $disinfectantRecord = new DisinfectantRecord();

        $disinfectantRecord = $this->fillDisinfectantRecord($disinfectantRecord, $disinfectant);

        if (!$disinfectantRecord->insert()) {
            throw new RuntimeException();
        }

        $disinfectant->setId($disinfectantRecord->id);

        return $disinfectant;
    }

    /**
     * @param Disinfectant $disinfectant
     * @return Disinfectant
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Disinfectant $disinfectant)
    {
        /**
         * @var DisinfectantRecord $disinfectantRecord
         */
        $disinfectantRecord = $this->findOrFail($disinfectant->getId());

        $disinfectantRecord = $this->fillDisinfectantRecord($disinfectantRecord, $disinfectant);

        $disinfectantRecord->update();

        return $disinfectant;
    }

    /**
     * @param Disinfectant $disinfectant
     * @return Disinfectant
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Disinfectant $disinfectant)
    {
        $disinfectantRecord = $this->findOrFail($disinfectant->getId());

        $disinfectantRecord->is_active = false;

        if (!$disinfectantRecord->update()) {
            throw new \RuntimeException();
        }

        $disinfectant->setIsActive(false);

        return $disinfectant;
    }

    /**
     * @return Disinfectant[]
     */
    public function all()
    {
        $disinfectantRecords = DisinfectantRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $disinfectants = [];
        /**
         * @var DisinfectantRecord $disinfectantRecord
         */
        foreach ($disinfectantRecords as $disinfectantRecord) {
            $disinfectants [] = $this->fillDisinfectant($disinfectantRecord);
        }

        return $disinfectants;
    }

    /**
     * @param $id
     * @return DisinfectantRecord
     * @throws DisinfectantNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var DisinfectantRecord $disinfectant
         */
        if (!($disinfectant = DisinfectantRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new DisinfectantNotFound();
        }

        return $disinfectant;
    }

    /**
     * @param DisinfectantRecord $disinfectantRecord
     * @return Disinfectant
     */
    private function fillDisinfectant($disinfectantRecord)
    {
        $disinfectant = (new Disinfectant())
            ->setId($disinfectantRecord->id)
            ->setCode($disinfectantRecord->code)
            ->setDescription($disinfectantRecord->description)
            ->setActiveSubstance($disinfectantRecord->active_substance)
            ->setConcentrationOfSubstance($disinfectantRecord->concentration_of_substance)
            ->setFromOfFacility($disinfectantRecord->form_of_facility)
            ->setManufacturer($disinfectantRecord->manufacturer)
            ->setPlaceOfApplication($disinfectantRecord->place_of_application)
            ->setTermsOfUse($disinfectantRecord->terms_of_use)
            ->setValue($disinfectantRecord->value);

        return $disinfectant;
    }

    /**
     * @param DisinfectantRecord $disinfectantRecord
     * @param Disinfectant $disinfectant
     * @return DisinfectantRecord
     */
    private function fillDisinfectantRecord($disinfectantRecord, $disinfectant)
    {
        $disinfectantRecord->code = $disinfectant->getCode();
        $disinfectantRecord->description = $disinfectant->getDescription();
        $disinfectantRecord->active_substance = $disinfectant->getActiveSubstance();
        $disinfectantRecord->concentration_of_substance = $disinfectant->getConcentrationOfSubstance();
        $disinfectantRecord->form_of_facility = $disinfectant->getFormOfFacility();
        $disinfectantRecord->manufacturer = $disinfectant->getManufacturer();
        $disinfectantRecord->place_of_application = $disinfectant->getPlaceOfApplication();
        $disinfectantRecord->terms_of_use = $disinfectant->getTermsOfUse();
        $disinfectantRecord->value = $disinfectant->getValue();

        return $disinfectantRecord;
    }
}
