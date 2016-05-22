<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 23.05.16
 * Time: 1:51
 */
?>
<div data-scrollbar="true" data-height="270px" class="bg-silver" style="
                            -webkit-filter: blur(7px);
                            -moz-filter: blur(15px);
                            -o-filter: blur(15px);
                            -ms-filter: blur(15px);
                            filter: blur(15px);">
    <ul class="todolist">
        <li class="active">
            <a href="javascript:;" class="todolist-container active" data-click="todolist">
                <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                <div class="todolist-title">Что-то уже сделано</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="todolist-container" data-click="todolist">
                <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                <div class="todolist-title">А что-то еще нет</div>
            </a>
        </li>
    </ul>
</div>