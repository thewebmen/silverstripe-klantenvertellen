<?php

namespace TheWebmen\KlantenVertellen;

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;

class KlantenvertellenData extends DataObject {

    private static $db = array(
        'Avarage' => 'Varchar',
        'NumReviews' => 'Int',
        'PercentageRecommend' => 'Int',
        'Grades' => 'Text'
    );

    private static $belongs_to = array(
        'SiteConfig' => 'SiteConfig'
    );

    public function AdminSummaryTable(){
        return $this->renderWith('TheWebmen\\KlantenVertellen\\AdminSummaryTable');
    }

    public function GradesList(){
        return $this->Grades ? new ArrayList(json_decode($this->Grades, true)) : false;
    }

}
