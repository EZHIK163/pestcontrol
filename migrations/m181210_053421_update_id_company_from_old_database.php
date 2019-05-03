<?php

use yii\db\Migration;

/**
 * Class m181210_053421_update_id_company_from_old_database
 */
class m181210_053421_update_id_company_from_old_database extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('events_id_customer', 'events');
        $this->dropForeignKey('customer_contact_id_file_customer', 'customer_contact');
        $this->dropForeignKey('customer_disinfectant_id_customer', 'customer_disinfectant');

        $this->updateIds('testbase', 1, 0);
        $this->updateIds('baltika', 2, 1);
        $this->updateIds('heineken', 3, 2);
        $this->updateIds('auchan_izh', 4, 3);
        $this->updateIds('ikea_uf', 5, 4);
        $this->updateIds('sj_nn', 6, 5);
        $this->updateIds('cc_nsk', 7, 6);
        $this->updateIds('x5_iz_uf', 8, 7);
        $this->updateIds('x5_kazan', 9, 8);
        $this->updateIds('sed_nestle', 10, 9);
        $this->updateIds('heineken_sp', 11, 10);
        $this->updateIds('alpla_sam', 12, 11);
        $this->updateIds('baltika_tul', 13, 12);
        $this->updateIds('pestrzavod', 14, 13);
        $this->updateIds('PepsiCo_Sam', 15, 14);
        $this->updateIds('Alpla_spb', 16, 15);
        $this->updateIds('Baltika_Spb', 17, 16);

        $this->addForeignKey(
            'customer_disinfectant_id_customer',
            'customer_disinfectant',
            'id_customer',
            'customers',
            'id'
        );
        $this->addForeignKey(
            'customer_contact_id_file_customer',
            'customer_contact',
            'id_customer',
            'customers',
            'id'
        );
        $this->addForeignKey(
            'events_id_customer',
            'events',
            'id_customer',
            'customers',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('events_id_customer', 'events');
        $this->dropForeignKey('customer_contact_id_file_customer', 'customer_contact');
        $this->dropForeignKey('customer_disinfectant_id_customer', 'customer_disinfectant');

        $this->updateIds('Baltika_Spb', 16, 17);
        $this->updateIds('Alpla_spb', 15, 16);
        $this->updateIds('PepsiCo_Sam', 14, 15);
        $this->updateIds('pestrzavod', 13, 14);
        $this->updateIds('baltika_tul', 12, 13);
        $this->updateIds('alpla_sam', 11, 12);
        $this->updateIds('heineken_sp', 10, 11);
        $this->updateIds('sed_nestle', 9, 10);
        $this->updateIds('x5_kazan', 8, 9);
        $this->updateIds('x5_iz_uf', 7, 8);
        $this->updateIds('cc_nsk', 6, 7);
        $this->updateIds('sj_nn', 5, 6);
        $this->updateIds('ikea_uf', 4, 5);
        $this->updateIds('auchan_izh', 3, 4);
        $this->updateIds('heineken', 2, 3);
        $this->updateIds('baltika', 1, 2);
        $this->updateIds('testbase', 0, 1);

        $this->addForeignKey(
            'customer_disinfectant_id_customer',
            'customer_disinfectant',
            'id_customer',
            'customers',
            'id'
        );
        $this->addForeignKey(
            'customer_contact_id_file_customer',
            'customer_contact',
            'id_customer',
            'customers',
            'id'
        );
        $this->addForeignKey(
            'events_id_customer',
            'events',
            'id_customer',
            'customers',
            'id'
        );

        return true;
    }

    private function updateIds($code, $idOld, $idNew)
    {
        $this->db->createCommand(
            'UPDATE public.customer_contact SET id_customer = :id_new WHERE id_customer = :id_old',
            ['id_new'    => $idNew, 'id_old'  => $idOld]
        )->execute();
        $this->db->createCommand(
            'UPDATE public.customer_disinfectant SET id_customer = :id_new WHERE id_customer = :id_old',
            ['id_new'    => $idNew, 'id_old'  => $idOld]
        )->execute();
        $this->db->createCommand(
            'UPDATE public.events SET id_customer = :id_new WHERE id_customer = :id_old',
            ['id_new'    => $idNew, 'id_old'  => $idOld]
        )->execute();
        $this->db->createCommand(
            'UPDATE public.file_customer SET id_customer = :id_new WHERE id_customer = :id_old',
            ['id_new'    => $idNew, 'id_old'  => $idOld]
        )->execute();
        $this->db->createCommand('UPDATE public.customers SET id = :id WHERE code = :code', ['code'    => $code, 'id'  => $idNew])->execute();
    }
}
