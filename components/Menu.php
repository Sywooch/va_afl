<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 22.09.15
 * Time: 19:48
 */
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class Menu extends Widget
{
    public $items = [];

    public function run()
    {
        $menuitems = [];
        foreach ($this->items as $item) {
            if (isset($item['items']) && is_array($item['items'])) {
                $newitems = [];
                $active = false;
                foreach ($item['items'] as $subitem) {
                    $linkOptions = isset($suitem['linkOptions']) ? $suitem['linkOptions'] : [];
                    $subactive = \Yii::$app->request->url === $subitem['url'] ? 'active' : '';
                    if (!$active && strlen($subactive) > 0) {
                        $active = true;
                    }
                    $newitems[] = [
                        'item' => Html::a(
                                "<span>" . $subitem['name'] . "</span>",
                                $subitem['url'],
                                $linkOptions
                            ),
                        'class' => $subactive
                    ];
                }
                $itemclass = ($item['icon']) ? 'fa ' . $item['icon'] : '';
                $linkOptions = isset($item['linkOptions']) ? $item['linkOptions'] : [];
                $sm = Html::a(
                    '<b class="caret pull-right"></b>' . Html::tag(
                        'i',
                        '',
                        ['class' => $itemclass]
                    ) . "<span>" . $item['name'] . "</span>",
                    'javascript:;',
                    $linkOptions
                );
                $menuitems[] = [
                    'items' => $sm . Html::ul(
                            $newitems,
                            [
                                'class' => 'sub-menu',
                                'item' => function ($sitem, $index) {
                                        return "<li class='" . $sitem['class'] . "'>" . $sitem['item'] . "</li>";
                                    }
                            ]
                        ),
                    'class' => 'has-sub' . (($active) ? ' active' : '')
                ];
            } else {
                $itemclass = ($item['icon']) ? 'fa ' . $item['icon'] : '';
                $active = \Yii::$app->request->url === $item['url'] ? 'active' : '';
                $linkOptions = isset($item['linkOptions']) ? $item['linkOptions'] : [];

                $menuitems[] = [
                    'items' => Html::a(
                            Html::tag('i', '', ['class' => $itemclass]) . "<span>" . $item['name'] . "</span>",
                            $item['url'],
                            $linkOptions
                        ),
                    'class' => $active
                ];
            }
        }
        $menuitems[] = [
            'items' => Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-angle-double-left']),
                    'javasrcipt:;',
                    ['class' => 'sidebar-minify-btn', 'data-click' => 'sidebar-minify']
                ),
            'class' => ''
        ];
        echo Html::ul(
            $menuitems,
            [
                'class' => 'nav',
                'item' => function ($item, $index) {
                        return "<li class='" . $item['class'] . "'>" . $item['items'] . "</li>";
                    }
            ]
        );
    }
}