<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 21.09.15
 * Time: 18:36
 */
?>
<div id="sidebar" class="sidebar">
<!-- begin sidebar scrollbar -->
<div data-scrollbar="true" data-height="100%">
<!-- begin sidebar user -->
<ul class="nav">
    <li class="nav-profile">
<?php if(!Yii::$app->user->isGuest):?>

        <div class="image">
            <a href="javascript:;"><img src="/img/user-13.jpg" alt=""/></a>
        </div>
        <div class="info">
            <?php echo Yii::$app->user->identity->full_name ?>
            <small>Front end developer</small>
        </div>

<?php else:?>
    <a href="site/login">
        <span class="hidden-xs">Login</span>
    </a>
<?php endif;?>
    </li>
</ul>
<!-- end sidebar user -->
<!-- begin sidebar nav -->
<ul class="nav">
<li class="nav-header">Navigation</li>
<li class="has-sub active">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-laptop"></i>
        <span>Dashboard</span>
    </a>
    <ul class="sub-menu">
        <li class="active"><a href="#ajax/index.html" data-toggle="ajax">Dashboard v1</a></li>
        <li><a href="#ajax/index_v2.html" data-toggle="ajax">Dashboard v2</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <span class="badge pull-right">10</span>
        <i class="fa fa-inbox"></i>
        <span>Email</span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/email_inbox.html" data-toggle="ajax">Inbox v1</a></li>
        <li><a href="#ajax/email_inbox_v2.html" data-toggle="ajax">Inbox v2</a></li>
        <li><a href="#ajax/email_compose.html" data-toggle="ajax">Compose</a></li>
        <li><a href="#ajax/email_detail.html" data-toggle="ajax">Detail</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-suitcase"></i>
        <span>UI Elements <span class="label label-theme m-l-5">NEW</span></span>
    </a>
    <ul class="sub-menu">
        <li><a href="#site/index" data-toggle="ajax">General</a></li>
        <li><a href="#ajax/ui_typography.html" data-toggle="ajax">Typography</a></li>
        <li><a href="#ajax/ui_tabs_accordions.html" data-toggle="ajax">Tabs & Accordions</a></li>
        <li><a href="#ajax/ui_unlimited_tabs.html" data-toggle="ajax">Unlimited Nav Tabs</a></li>
        <li><a href="#ajax/ui_modal_notification.html" data-toggle="ajax">Modal & Notification</a></li>
        <li><a href="#ajax/ui_widget_boxes.html" data-toggle="ajax">Widget Boxes <i
                    class="fa fa-paper-plane text-theme m-l-5"></i></a></li>
        <li><a href="#ajax/ui_media_object.html" data-toggle="ajax">Media Object</a></li>
        <li><a href="#ajax/ui_buttons.html" data-toggle="ajax">Buttons</a></li>
        <li><a href="#ajax/ui_icons.html" data-toggle="ajax">Icons</a></li>
        <li><a href="#ajax/ui_simple_line_icons.html" data-toggle="ajax">Simple Line Icons</a></li>
        <li><a href="#ajax/ui_tree.html" data-toggle="ajax">Tree View</a></li>
        <li><a href="ui_language_bar_icon.html">Language Bar & Icon</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-file-o"></i>
        <span>Form Stuff <span class="label label-theme m-l-5">NEW</span></span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/form_elements.html" data-toggle="ajax">Form Elements</a></li>
        <li><a href="#ajax/form_plugins.html" data-toggle="ajax">Form Plugins <i
                    class="fa fa-paper-plane text-theme"></i></a></li>
        <li><a href="#ajax/form_slider_switcher.html" data-toggle="ajax">Form Slider + Switcher</a></li>
        <li><a href="#ajax/form_validation.html" data-toggle="ajax">Form Validation</a></li>
        <li><a href="#ajax/form_wizards.html" data-toggle="ajax">Wizards</a></li>
        <li><a href="#ajax/form_wizards_validation.html" data-toggle="ajax">Wizards + Validation</a></li>
        <li><a href="#ajax/form_wysiwyg.html" data-toggle="ajax">WYSIWYG</a></li>
        <li><a href="#ajax/form_editable.html" data-toggle="ajax">X-Editable</a></li>
        <li><a href="#ajax/form_multiple_upload.html" data-toggle="ajax">Multiple File Upload</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-th"></i>
        <span>Tables</span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/table_basic.html" data-toggle="ajax">Basic Tables</a></li>
        <li class="has-sub">
            <a href="javascript:;"><b class="caret pull-right"></b> Managed Tables</a>
            <ul class="sub-menu">
                <li><a href="#ajax/table_manage.html" data-toggle="ajax">Default</a></li>
                <li><a href="#ajax/table_manage_autofill.html" data-toggle="ajax">Autofill</a></li>
                <li><a href="#ajax/table_manage_colreorder.html" data-toggle="ajax">ColReorder</a></li>
                <li><a href="#ajax/table_manage_colvis.html" data-toggle="ajax">ColVis</a></li>
                <li><a href="#ajax/table_manage_fixed_columns.html" data-toggle="ajax">Fixed Column</a></li>
                <li><a href="#ajax/table_manage_fixed_header.html" data-toggle="ajax">Fixed Header</a></li>
                <li><a href="#ajax/table_manage_keytable.html" data-toggle="ajax">KeyTable</a></li>
                <li><a href="#ajax/table_manage_responsive.html" data-toggle="ajax">Responsive</a></li>
                <li><a href="#ajax/table_manage_scroller.html" data-toggle="ajax">Scroller</a></li>
                <li><a href="#ajax/table_manage_tabletools.html" data-toggle="ajax">TableTools</a></li>
                <li><a href="#ajax/table_manage_combine.html" data-toggle="ajax">Extension Combination</a></li>
            </ul>
        </li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-star"></i>
        <span>Front End <span class="label label-theme m-l-5">NEW</span></span>
    </a>
    <ul class="sub-menu">
        <li><a href="../../frontend/one-page-parallax/template_content_html/index.html" target="_blank">One Page
                Parallax</a></li>
        <li><a href="../../frontend/blog/template_content_html/index.html" target="_blank">Blog <i
                    class="fa fa-paper-plane text-theme m-l-5"></i></a></li>
        <li><a href="../../frontend/forum/template_content_html/index.html" target="_blank">Forum <i
                    class="fa fa-paper-plane text-theme m-l-5"></i></a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-envelope"></i>
        <span>Email Template</span>
    </a>
    <ul class="sub-menu">
        <li><a href="email_system.html">System Template</a></li>
        <li><a href="email_newsletter.html">Newsletter Template</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-area-chart"></i>
        <span>Chart</span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/chart-flot.html" data-toggle="ajax">Flot Chart</a></li>
        <li><a href="#ajax/chart-morris.html" data-toggle="ajax">Morris Chart</a></li>
        <li><a href="#ajax/chart-js.html" data-toggle="ajax">Chart JS</a></li>
    </ul>
</li>
<li><a href="#ajax/calendar.html" data-toggle="ajax"><i class="fa fa-calendar"></i> <span>Calendar</span></a></li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-map-marker"></i>
        <span>Map</span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/map_vector.html" data-toggle="ajax">Vector Map</a></li>
        <li><a href="#ajax/map_google.html" data-toggle="ajax">Google Map</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-camera"></i>
        <span>Gallery</span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/gallery.html" data-toggle="ajax">Gallery v1</a></li>
        <li><a href="#ajax/gallery_v2.html" data-toggle="ajax">Gallery v2</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-cogs"></i>
        <span>Page Options</span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/page_blank.html" data-toggle="ajax">Blank Page</a></li>
        <li><a href="#ajax/page_with_footer.html" data-toggle="ajax">Page with Footer</a></li>
        <li><a href="page_without_sidebar.html">Page without Sidebar</a></li>
        <li><a href="page_with_right_sidebar.html">Page with Right Sidebar</a></li>
        <li><a href="page_with_minified_sidebar.html">Page with Minified Sidebar</a></li>
        <li><a href="page_with_two_sidebar.html">Page with Two Sidebar</a></li>
        <li><a href="page_with_line_icons.html">Page with Line Icons</a></li>
        <li><a href="page_with_ionicons.html">Page with Ionicons</a></li>
        <li><a href="page_full_height.html">Full Height Content</a></li>
        <li><a href="page_with_wide_sidebar.html">Page with Wide Sidebar</a></li>
        <li><a href="page_with_light_sidebar.html">Page with Light Sidebar</a></li>
        <li><a href="page_with_mega_menu.html">Page with Mega Menu</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-gift"></i>
        <span>Extra</span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/extra_timeline.html" data-toggle="ajax">Timeline</a></li>
        <li><a href="extra_coming_soon.html">Coming Soon Page</a></li>
        <li><a href="#ajax/extra_search_results.html" data-toggle="ajax">Search Results</a></li>
        <li><a href="#ajax/extra_invoice.html" data-toggle="ajax">Invoice</a></li>
        <li><a href="extra_404_error.html">404 Error Page</a></li>
        <li><a href="#ajax/extra_profile.html" data-toggle="ajax">Profile Page</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-key"></i>
        <span>Login</span>
    </a>
    <ul class="sub-menu">
        <li><a href="login.html">Login</a></li>
        <li><a href="login_v2.html">Login v2</a></li>
        <li><a href="login_v3.html">Login v3</a></li>
        <li><a href="register_v3.html">Register v3</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-cubes"></i>
        <span>Version</span>
    </a>
    <ul class="sub-menu">
        <li><a href="../template_content_html/index.html">HTML</a></li>
        <li><a href="javascript:;">AJAX</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-medkit"></i>
        <span>Helper</span>
    </a>
    <ul class="sub-menu">
        <li><a href="#ajax/helper_css.html" data-toggle="ajax">Predefined CSS Classes</a></li>
    </ul>
</li>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret pull-right"></b>
        <i class="fa fa-align-left"></i>
        <span>Menu Level</span>
    </a>
    <ul class="sub-menu">
        <li class="has-sub">
            <a href="javascript:;">
                <b class="caret pull-right"></b>
                Menu 1.1
            </a>
            <ul class="sub-menu">
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        Menu 2.1
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;">Menu 3.1</a></li>
                        <li><a href="javascript:;">Menu 3.2</a></li>
                    </ul>
                </li>
                <li><a href="javascript:;">Menu 2.2</a></li>
                <li><a href="javascript:;">Menu 2.3</a></li>
            </ul>
        </li>
        <li><a href="javascript:;">Menu 1.2</a></li>
        <li><a href="javascript:;">Menu 1.3</a></li>
    </ul>
</li>
<!-- begin sidebar minify button -->
<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
            class="fa fa-angle-double-left"></i></a></li>
<!-- end sidebar minify button -->
</ul>
<!-- end sidebar nav -->
</div>
<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
