<?php

namespace frontend\widgets;

use frontend\models\Post;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\VarDumper;


class Archives extends Widget
{
    public $title;


    protected $archives = [];
    protected $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    ];

    public function init()
    {
        parent::init();

        if($this->title == null) {
            $this->title = "Archives";
        }

        $posts = Post::find()->all();
        foreach($posts as $post /* @var Post $post */) {
            $item = [];

            $createdAt = $post->created_at;
            $month = date("n", $createdAt);
            $year = date("Y", $createdAt);

            $item['createdAt'] = $createdAt;
            $item['month'] = $this->months[$month];
            $item['monthId'] = $month;
            $item['year'] = $year;
            $item['fullDate'] = $this->months[$month] . ' ' . $year;

            $this->archives[$month.'.'.$year] = $item;
        }

        //VarDumper::dump($this->archives, 10, true);
    }

    public function run()
    {
        $html = '';
        $html .= '<h4>'. $this->title .'</h4>';
        $html .= '<ol class="list-unstyled">';

        if(count($this->archives)) {
            foreach($this->archives as $key => $archive) {
                $html .= '<li>'. Html::a($archive['fullDate'], ["/post/archive", "month" => $archive['monthId'], "year" => $archive['year']]) .'</li>';
            }
        }

        $html .= '</ol>';


        return $html;
    }

}