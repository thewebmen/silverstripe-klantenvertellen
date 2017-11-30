<?php

namespace TheWebmen\KlantenVertellen;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SiteConfigExtension extends DataExtension {

    private static $db = array(
        'KlantenvertellenSlug' => 'Varchar'
    );

    private static $has_one = array(
        'KlantenvertellenData' => KlantenvertellenData::class
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Klantenvertellen', TextField::create('KlantenvertellenSlug', 'Klantenvertellen slug'));
        $data = $this->owner->KlantenvertellenData();
        if($data && $data->exists()){
            $fields->addFieldToTab('Root.Klantenvertellen', LiteralField::create('KlantenvertellenSummaryTable', $data->AdminSummaryTable()));
        }
    }

    public function onAfterWrite()
    {
        if($this->owner->isChanged('KlantenvertellenSlug')){
            $task = new KlantenvertellenUpdateTask();
            $task->run(Controller::curr()->getRequest(), $this->owner->ID);
        }
    }

}
