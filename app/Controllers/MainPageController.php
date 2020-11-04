<?php

namespace App\Controllers;


use App\Models\Currency;
use Doctrine\DBAL\DriverManager;
use Sabre\Xml\Service;

class MainPageController
{

    public function index()
    {
        $rateQuery = query()
            ->select('*')
            ->from('currency_rates')
            ->orderBy('updated_at', 'desc')
            ->execute()
            ->fetchAllAssociative();


        $rates = [];

        foreach ($rateQuery as $rate) {
            $rates[] = new Currency(
                (int)$rate['id'],
                (string)$rate['name'],
                (float)$rate['rate'],
                $rate['updated_at'],

            );
        }
        return require_once __DIR__ . '/../Views/MainPageView.php';
    }

    public function store()
    {
        $xml = file_get_contents("https://www.bank.lv/vk/ecb_rss.xml");

        $service = new Service();
        $result = $service->parse($xml);

        $rate = $result[0]['value'][9]['value'][3]['value'];

        $array = explode(" ", $rate);
        $rates = [];

        for ($i = 0; $i < count($array); $i++) {
            if ($i % 2 == 0) {
                $rates[$array[$i]] = $array[$i + 1];
            }
        }

        array_pop($rates);

        foreach ($rates as $name => $rate) {


            $existRate = query()
                ->select('*')
                ->from('currency_rates')
                ->where('name = :name')
                ->setParameter('name', $name)
                ->execute()
                ->fetchAssociative();


            if (!empty($existRate)) {
                query()
                    ->update('currency_rates')
                    ->set('name', ':name')
                    ->set('rate', ':rate')
                    ->setParameters([
                        'name' => $name,
                        'rate' => $rate
                    ])
                    ->where('name = :name')
                    ->setParameter('name', $name)
                    ->execute();
            } else {
                query()
                    ->insert('currency_rates')
                    ->values([
                        'name' => ':name',
                        'rate' => ':rate'
                    ])
                    ->setParameter('name', $name)
                    ->setParameter('rate', $rate)
                    ->execute();
            }
        }

        header('Location: /');
    }
}