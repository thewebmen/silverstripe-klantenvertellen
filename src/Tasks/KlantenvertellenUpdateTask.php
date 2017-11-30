<?php

namespace TheWebmen\KlantenVertellen;

use SilverStripe\Dev\BuildTask;
use SilverStripe\SiteConfig\SiteConfig;

class KlantenvertellenUpdateTask extends BuildTask
{

    private static $segment = 'klantenvertellen';
    protected $title = 'Klantenvertellen data retrieve';
    protected $description = 'Update the klantenvertellen data';

    public function run($request, $configID = false)
    {
        if(!$configID){
            $configID = $request->getVar('configid');
        }
        $configs = SiteConfig::get()->exclude('KlantenvertellenSlug', null);
        if($configID){
            $configs = $configs->filter('ID', $configID);
        }
        foreach ($configs as $config) {
            $data = $this->loadDataForConfig($config);
            if($data){
                $klantenvertellenData = false;
                if($config->KlantenvertellenDataID){
                    $klantenvertellenData = $config->KlantenvertellenData();
                }
                $isNew = false;
                if(!$klantenvertellenData || !$klantenvertellenData->exists()){
                    $klantenvertellenData = new KlantenvertellenData();
                    $isNew = true;
                }

                $grades = array();
                foreach($data->statistieken->gemiddelden->cijfer as $cijfer){
                    $grades[] = array(
                        'Title' => $cijfer->attributes()['name']->__toString(),
                        'Grade' => $cijfer->__toString()
                    );
                }

                $klantenvertellenData->Avarage = $data->statistieken->gemiddelde->__toString();
                $klantenvertellenData->NumReviews = $data->statistieken->aantalbeoordelingen->__toString();
                $klantenvertellenData->PercentageRecommend = $data->statistieken->percentageaanbeveling->__toString();
                $klantenvertellenData->Grades = json_encode($grades);
                $klantenvertellenData->write();
                if($isNew){
                    $config->KlantenvertellenDataID = $klantenvertellenData->ID;
                    $config->write();
                }
            }
        }
    }

    private function loadDataForConfig($config)
    {
        $url = 'https://www.klantenvertellen.nl/xml/' . $config->KlantenvertellenSlug;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $data = curl_exec($ch);
        curl_close($ch);

        if(!$data){
            return false;
        }

        return simplexml_load_string($data);
    }

}
