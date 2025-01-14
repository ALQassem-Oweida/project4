<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<!--<div class="woof-admin-preloader"></div>-->
<div class="woof-admin-preloader">
    <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
    </div>
</div>

<div class="subsubsub_section <?php echo ($this->is_free_ver) ? "woof_free" : ""; ?>">

    <div class="woof_fix12"></div>

    <section class="woof-section">

        <?php if (isset($_GET['settings_saved'])): ?>
            <div class="woof-notice"><?php esc_html_e("Your settings have been saved.", 'woocommerce-products-filter') ?></div>
        <?php endif; ?>


        <h3 class="woof_plugin_name"><?php printf(__('WOOF - WooCommerce Products Filter v.%s', 'woocommerce-products-filter'), WOOF_VERSION) ?></h3>
        <i><?php printf(esc_html__('Actualized for WooCommerce v.%s.x', 'woocommerce-products-filter'), WOOCOMMERCE_VERSION) ?></i><br />
        <br />

        <input type="hidden" name="woof_settings" value="" />
        <input type="hidden" name="woof_settings[items_order]" value="<?php echo(isset($woof_settings['items_order']) ? $woof_settings['items_order'] : '') ?>" />

        <?php if (version_compare(WOOCOMMERCE_VERSION, WOOF_MIN_WOOCOMMERCE_VERSION, '<')): ?>

            <div id="message" class="error fade"><p><strong><?php esc_html_e("ATTENTION! Your version of the woocommerce plugin is too obsolete. There is no warranty for working with WOOF!!", 'woocommerce-products-filter') ?></strong></p></div>

        <?php endif; ?>

        <svg class="hidden">
        <defs>
        <path id="tabshape" d="M80,60C34,53.5,64.417,0,0,0v60H80z"/>
        </defs>
        </svg>

        <div id="tabs" class="woof-tabs woof-tabs-style-shape">

            <nav>
                <ul>
                    <li class="tab-current">
                        <a href="#tabs-1">
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <span><?php esc_html_e("Structure", 'woocommerce-products-filter') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tabs-2">
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <span><?php esc_html_e("Options", 'woocommerce-products-filter') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tabs-3">
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <span><?php esc_html_e("Design", 'woocommerce-products-filter') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tabs-4">
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <span><?php esc_html_e("Advanced", 'woocommerce-products-filter') ?></span>
                        </a>
                    </li>


                    <?php
                    if (!empty(WOOF_EXT::$includes['applications'])) {
                        foreach (WOOF_EXT::$includes['applications'] as $obj) {
                            $dir1 = $this->get_custom_ext_path() . $obj->folder_name;
                            $dir2 = WOOF_EXT_PATH . $obj->folder_name;
                            $checked1 = WOOF_EXT::is_ext_activated($dir1);
                            $checked2 = WOOF_EXT::is_ext_activated($dir2);
                            if ($checked1 OR $checked2) {
                                do_action('woof_print_applications_tabs_' . $obj->folder_name);
                            }
                        }
                    }
                    ?>

                    <li>
                        <a href="#tabs-6">
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <span><?php esc_html_e("Extensions", 'woocommerce-products-filter') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tabs-7">
                            <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                            <span><?php esc_html_e("Info", 'woocommerce-products-filter') ?></span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="content-wrap">

                <section id="tabs-1" class="content-current">

                    <ul id="woof_options">

                        <?php
                        $items_order = array();
                        $taxonomies = $this->get_taxonomies();
                        $taxonomies_keys = array_keys($taxonomies);
                        if (isset($woof_settings['items_order']) AND!empty($woof_settings['items_order'])) {
                            $items_order = explode(',', $woof_settings['items_order']);
                        } else {
                            $items_order = array_merge($this->items_keys, $taxonomies_keys);
                        }

//*** lets check if we have new taxonomies added in woocommerce or new item
                        foreach (array_merge($this->items_keys, $taxonomies_keys) as $key) {
                            if (!in_array($key, $items_order)) {
                                $items_order[] = $key;
                            }
                        }

//lets print our items and taxonomies
                        foreach ($items_order as $key) {
                            if (in_array($key, $this->items_keys)) {
                                woof_print_item_by_key($key, $woof_settings);
                            } else {
                                if (isset($taxonomies[$key])) {
                                    woof_print_tax($key, $taxonomies[$key], $woof_settings);
                                }
                            }
                        }
                        ?>
                    </ul>

                    <input type="button" class="woof_reset_order" value="<?php esc_html_e('Reset items order', 'woocommerce-products-filter') ?>" />

                    <div class="clear"></div>

                </section>

                <section id="tabs-2">

                    <?php woocommerce_admin_fields($this->get_options()); ?>

                </section>

                <section id="tabs-3">

                    <?php
                    $skins = array(
                        'none' => array('none'),
                        'flat' => array(
                            'flat_aero',
                            'flat_blue',
                            'flat_flat',
                            'flat_green',
                            'flat_grey',
                            'flat_orange',
                            'flat_pink',
                            'flat_purple',
                            'flat_red',
                            'flat_yellow'
                        ),
                        'minimal' => array(
                            'minimal_aero',
                            'minimal_blue',
                            'minimal_green',
                            'minimal_grey',
                            'minimal_minimal',
                            'minimal_orange',
                            'minimal_pink',
                            'minimal_purple',
                            'minimal_red',
                            'minimal_yellow'
                        ),
                        'square' => array(
                            'square_aero',
                            'square_blue',
                            'square_green',
                            'square_grey',
                            'square_orange',
                            'square_pink',
                            'square_purple',
                            'square_red',
                            'square_yellow',
                            'square_square'
                        )
                    );
                    $skin = 'none';
                    if (isset($woof_settings['icheck_skin'])) {
                        $skin = $woof_settings['icheck_skin'];
                    }
                    ?>

                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Radio and checkboxes skin', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control">

                                <select name="woof_settings[icheck_skin]" class="chosen_select">
                                    <?php foreach ($skins as $key => $schemes) : ?>
                                        <optgroup label="<?php echo $key ?>">
                                            <?php foreach ($schemes as $scheme) : ?>
                                                <option value="<?php echo $scheme; ?>" <?php if ($skin == $scheme): ?>selected="selected"<?php endif; ?>><?php echo $scheme; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <div class="woof-description"></div>
                        </div>

                    </div><!--/ .woof-control-section-->

                    <?php
                    $skins = array(
                        'default' => esc_html__('Default', 'woocommerce-products-filter'),
                        'plainoverlay' => esc_html__('Plainoverlay - CSS', 'woocommerce-products-filter'),
                        'loading-balls' => esc_html__('Loading balls - SVG', 'woocommerce-products-filter'),
                        'loading-bars' => esc_html__('Loading bars - SVG', 'woocommerce-products-filter'),
                        'loading-bubbles' => esc_html__('Loading bubbles - SVG', 'woocommerce-products-filter'),
                        'loading-cubes' => esc_html__('Loading cubes - SVG', 'woocommerce-products-filter'),
                        'loading-cylon' => esc_html__('Loading cyclone - SVG', 'woocommerce-products-filter'),
                        'loading-spin' => esc_html__('Loading spin - SVG', 'woocommerce-products-filter'),
                        'loading-spinning-bubbles' => esc_html__('Loading spinning bubbles - SVG', 'woocommerce-products-filter'),
                        'loading-spokes' => esc_html__('Loading spokes - SVG', 'woocommerce-products-filter'),
                    );
                    if (!isset($woof_settings['overlay_skin'])) {
                        $woof_settings['overlay_skin'] = 'default';
                    }
                    $skin = $woof_settings['overlay_skin'];
                    ?>


                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Overlay skins', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control">

                                <select name="woof_settings[overlay_skin]" class="chosen_select">
                                    <?php foreach ($skins as $scheme => $title) : ?>
                                        <option value="<?php echo $scheme; ?>" <?php if ($skin == $scheme): ?>selected="selected"<?php endif; ?>><?php echo $title; ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <div class="woof-description">

                            </div>
                        </div>

                    </div><!--/ .woof-control-section-->

                    <?php
                    if (!isset($woof_settings['overlay_skin_bg_img'])) {
                        $woof_settings['overlay_skin_bg_img'] = '';
                    }
                    $overlay_skin_bg_img = $woof_settings['overlay_skin_bg_img'];
                    ?>


                    <div class="woof-control-section" <?php if ($skin == 'default'): ?>style="display: none;"<?php endif; ?>>

                        <h4><?php esc_html_e('Overlay image background', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">

                                <input type="text" name="woof_settings[overlay_skin_bg_img]" value="<?php echo $overlay_skin_bg_img ?>" />

                                <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a><br />

                                <div <?php if ($skin != 'plainoverlay'): ?>style="display: none;"<?php endif; ?>>
                                    <br />
                                    <?php
                                    if (!isset($woof_settings['plainoverlay_color'])) {
                                        $woof_settings['plainoverlay_color'] = '';
                                    }
                                    $plainoverlay_color = $woof_settings['plainoverlay_color'];
                                    ?>

                                    <h4<?php esc_html_e('Plainoverlay color', 'woocommerce-products-filter') ?></h4>
                                        <input type="text" name="woof_settings[plainoverlay_color]" value="<?php echo $plainoverlay_color ?>" id="woof_color_picker_plainoverlay_color" class="woof-color-picker" />

                                </div>

                            </div>
                            <div class="woof-description">
                                <p class="description">
                                    <?php esc_html_e('Example', 'woocommerce-products-filter') ?>: <?php echo WOOF_LINK ?>img/overlay_bg.png
                                </p>
                            </div>
                        </div>

                    </div><!--/ .woof-control-section-->


                    <div class="woof-control-section" <?php if ($skin != 'default'): ?>style="display: none;"<?php endif; ?>>

                        <h4><?php esc_html_e('Loading word', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">

                            <div class="woof-control woof-upload-style-wrap">

                                <?php
                                if (!isset($woof_settings['default_overlay_skin_word'])) {
                                    $woof_settings['default_overlay_skin_word'] = '';
                                }
                                $default_overlay_skin_word = $woof_settings['default_overlay_skin_word'];
                                ?>



                                <input type="text" name="woof_settings[default_overlay_skin_word]" value="<?php echo $default_overlay_skin_word ?>" />


                            </div>
                            <div class="woof-description">
                                <p class="description">
                                    <?php esc_html_e('Word while searching is going on front when "Overlay skins" is default.', 'woocommerce-products-filter') ?>
                                </p>
                            </div>
                        </div>
                    </div><!--/ .woof-control-section-->



                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Use chosen', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">

                            <div class="woof-control woof-upload-style-wrap">

                                <?php
                                $chosen_selects = array(
                                    0 => esc_html__('No', 'woocommerce-products-filter'),
                                    1 => esc_html__('Yes', 'woocommerce-products-filter')
                                );

                                if (!isset($woof_settings['use_chosen'])) {
                                    $woof_settings['use_chosen'] = 1;
                                }
                                $chosen_select = $woof_settings['use_chosen'];
                                ?>

                                <div class="select-wrap">
                                    <select name="woof_settings[use_chosen]" class="chosen_select">
                                        <?php foreach ($chosen_selects as $key => $value) : ?>
                                            <option value="<?php echo $key; ?>" <?php if ($chosen_select == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                            </div>
                            <div class="woof-description">
                                <p class="description">
                                    <?php esc_html_e('Use chosen javascript library on the front of your site for drop-downs.', 'woocommerce-products-filter') ?>
                                </p>
                            </div>
                        </div>
                    </div><!--/ .woof-control-section-->


                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Use beauty scroll', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">

                            <div class="woof-control woof-upload-style-wrap">

                                <?php
                                $use_beauty_scroll = array(
                                    0 => esc_html__('No', 'woocommerce-products-filter'),
                                    1 => esc_html__('Yes', 'woocommerce-products-filter')
                                );

                                if (!isset($woof_settings['use_beauty_scroll'])) {
                                    $woof_settings['use_beauty_scroll'] = 0;
                                }
                                $use_scroll = $woof_settings['use_beauty_scroll'];
                                ?>

                                <div class="select-wrap">
                                    <select name="woof_settings[use_beauty_scroll]" class="chosen_select">
                                        <?php foreach ($use_beauty_scroll as $key => $value) : ?>
                                            <option value="<?php echo $key; ?>" <?php if ($use_scroll == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                            </div>
                            <div class="woof-description">
                                <p class="description">
                                    <?php esc_html_e('Use beauty scroll when you apply max height for taxonomy block on the front', 'woocommerce-products-filter') ?>
                                </p>
                            </div>
                        </div>
                    </div><!--/ .woof-control-section-->


                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Range-slider skin', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">

                            <div class="woof-control woof-upload-style-wrap">

                                <?php
                                $skins = array(
                                    'skinNice' => 'skinNice',
                                    'skinFlat' => 'skinFlat',
                                    'skinHTML5' => 'skinHTML5',
                                    'skinModern' => 'skinModern',
                                    'skinSimple' => 'skinSimple'
                                );

                                if (!isset($woof_settings['ion_slider_skin'])) {
                                    $woof_settings['ion_slider_skin'] = 'skinNice';
                                }
                                $skin = $woof_settings['ion_slider_skin'];
                                ?>

                                <div class="select-wrap">
                                    <select name="woof_settings[ion_slider_skin]" class="chosen_select">
                                        <?php foreach ($skins as $key => $value) : ?>
                                            <option value="<?php echo $key; ?>" <?php if ($skin == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                            </div>
                            <div class="woof-description">
                                <p class="description">
                                    <?php esc_html_e('Ion-Range slider js lib skin for range-sliders of the plugin', 'woocommerce-products-filter') ?>
                                </p>
                            </div>
                        </div>
                    </div><!--/ .woof-control-section-->

                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Use tooltip', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">

                            <div class="woof-control woof-upload-style-wrap">

                                <?php
                                $tooltip_selects = array(
                                    0 => esc_html__('No', 'woocommerce-products-filter'),
                                    1 => esc_html__('Yes', 'woocommerce-products-filter')
                                );

                                if (!isset($woof_settings['use_tooltip'])) {
                                    $woof_settings['use_tooltip'] = 1;
                                }
                                $tooltip_select = $woof_settings['use_tooltip'];
                                ?>

                                <div class="select-wrap">
                                    <select name="woof_settings[use_tooltip]" class="chosen_select">
                                        <?php foreach ($tooltip_selects as $key => $value) : ?>
                                            <option value="<?php echo $key; ?>" <?php if ($tooltip_select == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                            </div>
                            <div class="woof-description">
                                <p class="description">
                                    <?php esc_html_e('Use tooltip library on the front of your site. Possible to disable it here if any scripts conflicts on the site front.', 'woocommerce-products-filter') ?>
                                </p>
                            </div>
                        </div>
                    </div><!--/ .woof-control-section-->

                    <?php if (get_option('woof_set_automatically')): ?>
                        <div class="woof-control-section">

                            <h4><?php esc_html_e('Hide auto filter by default', 'woocommerce-products-filter') ?></h4>

                            <div class="woof-control-container">
                                <div class="woof-control">

                                    <?php
                                    $woof_auto_hide_button = array(
                                        0 => esc_html__('No', 'woocommerce-products-filter'),
                                        1 => esc_html__('Yes', 'woocommerce-products-filter')
                                    );
                                    if (!isset($woof_settings['woof_auto_hide_button'])) {
                                        $woof_settings['woof_auto_hide_button'] = 0;
                                    }
                                    $woof_auto_hide_button_val = $woof_settings['woof_auto_hide_button'];
                                    ?>

                                    <select name="woof_settings[woof_auto_hide_button]" class="chosen_select">
                                        <?php foreach ($woof_auto_hide_button as $v => $n) : ?>
                                            <option value="<?php echo $v; ?>" <?php if ($woof_auto_hide_button_val == $v): ?>selected="selected"<?php endif; ?>><?php echo $n; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                                <div class="woof-description">
                                    <p class="description"><?php esc_html_e('If in options tab option "Set filter automatically" is "Yes" you can hide filter and show hide/show button instead of it.', 'woocommerce-products-filter') ?></p>
                                </div>
                            </div>

                        </div><!--/ .woof-control-section-->

                        <div class="woof-control-section">

                            <h4><?php esc_html_e('Skins for the auto filter', 'woocommerce-products-filter') ?></h4>

                            <div class="woof-control-container">
                                <div class="woof-control">

                                    <?php
                                    $woof_auto_filter_skins = array(
                                        '' => esc_html__('Default', 'woocommerce-products-filter'),
                                        'flat_grey woof_auto_3_columns' => esc_html__('Flat grey (3columns)', 'woocommerce-products-filter'),
                                        'flat_dark woof_auto_3_columns' => esc_html__('Flat dark (3columns)', 'woocommerce-products-filter'),
                                        'flat_grey woof_auto_2_columns' => esc_html__('Flat grey (2columns)', 'woocommerce-products-filter'),
                                        'flat_dark woof_auto_2_columns' => esc_html__('Flat dark (2columns)', 'woocommerce-products-filter'),
                                        'flat_grey woof_auto_1_columns' => esc_html__('Flat grey (1column)', 'woocommerce-products-filter'),
                                        'flat_dark woof_auto_1_columns' => esc_html__('Flat dark (1column)', 'woocommerce-products-filter'),
                                        'flat_grey woof_auto_4_columns' => esc_html__('Flat grey (4columns) without sidebar*', 'woocommerce-products-filter'),
                                        'flat_dark woof_auto_4_columns' => esc_html__('Flat dark (4columns) without sidebar*', 'woocommerce-products-filter'),
                                    );
                                    if (!isset($woof_settings['woof_auto_filter_skins'])) {
                                        $woof_settings['woof_auto_filter_skins'] = "";
                                    }
                                    $woof_auto_filter_skins_val = $woof_settings['woof_auto_filter_skins'];
                                    ?>

                                    <select name="woof_settings[woof_auto_filter_skins]" class="chosen_select">
                                        <?php foreach ($woof_auto_filter_skins as $v => $n) : ?>
                                            <option value="<?php echo $v; ?>" <?php if ($woof_auto_filter_skins_val == $v): ?>selected="selected"<?php endif; ?>><?php echo $n; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                                <div class="woof-description">
                                    <p class="description"><?php esc_html_e('Skins for the auto-filter which appears on the shop page if in tab Options enabled Set filter automatically', 'woocommerce-products-filter') ?></p>
                                </div>
                            </div>

                        </div><!--/ .woof-control-section-->
                    <?php endif; ?>

                    <?php
                    if (!isset($woof_settings['woof_tooltip_img'])) {
                        $woof_settings['woof_tooltip_img'] = '';
                    }
                    ?>
                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Tooltip icon', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">
                                <input type="text" name="woof_settings[woof_tooltip_img]" value="<?php echo $woof_settings['woof_tooltip_img'] ?>" />
                                <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a>
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Image which displayed for tooltip', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>

                    </div><!--/ .woof-control-section-->

                    <?php
                    if (!isset($woof_settings['woof_auto_hide_button_img'])) {
                        $woof_settings['woof_auto_hide_button_img'] = '';
                    }

                    if (!isset($woof_settings['woof_auto_hide_button_txt'])) {
                        $woof_settings['woof_auto_hide_button_txt'] = '';
                    }
                    ?>

                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Auto filter close/open image', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">
                                <input type="text" name="woof_settings[woof_auto_hide_button_img]" value="<?php echo $woof_settings['woof_auto_hide_button_img'] ?>" />
                                <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a>
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Image which displayed instead filter while it is closed if selected. Write "none" here if you want to use text only!', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>

                    </div><!--/ .woof-control-section-->


                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Auto filter close/open text', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control">
                                <input type="text" name="woof_settings[woof_auto_hide_button_txt]" value="<?php echo $woof_settings['woof_auto_hide_button_txt'] ?>" />
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Text which displayed instead filter while it is closed if selected.', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>

                    </div><!--/ .woof-control-section-->

                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Image for subcategories open', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">
                                <input type="text" name="woof_settings[woof_auto_subcats_plus_img]" value="<?php echo(isset($woof_settings['woof_auto_subcats_plus_img']) ? $woof_settings['woof_auto_subcats_plus_img'] : '') ?>" />
                                <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a>
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Image when you select in tab Options "Hide childs in checkboxes and radio". By default it is green cross.', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>

                        <h4><?php esc_html_e('Image for subcategories close', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">
                                <input type="text" name="woof_settings[woof_auto_subcats_minus_img]" value="<?php echo(isset($woof_settings['woof_auto_subcats_minus_img']) ? $woof_settings['woof_auto_subcats_minus_img'] : '') ?>" />
                                <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a>
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Image when you select in tab Options "Hide childs in checkboxes and radio". By default it is green minus.', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>

                    </div><!--/ .woof-control-section-->
                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Image for open mobile filter', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">
                                <input type="text" name="woof_settings[image_mobile_behavior_open]" value="<?php echo(isset($woof_settings['image_mobile_behavior_open']) ? $woof_settings['image_mobile_behavior_open'] : '') ?>" />
                                <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a>
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Filter image when to activate mobile phone mode. If you want to remove the image just insert -1', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>
                        <h4><?php esc_html_e('Text for open mobile filter', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">
                                <?php
                                if (!isset($woof_settings['text_mobile_behavior_open'])) {
                                    $woof_settings['text_mobile_behavior_open'] = esc_html__('Open filter', 'woocommerce-products-filter');
                                }
                                ?>
                                <input type="text" name="woof_settings[text_mobile_behavior_open]" value="<?php echo $woof_settings['text_mobile_behavior_open'] ?>" />
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Filter text when to activate mobile phone mode. If you want to remove the text just insert -1', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>


                        <h4><?php esc_html_e('Image for close mobile filter', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">
                                <input type="text" name="woof_settings[image_mobile_behavior_close]" value="<?php echo(isset($woof_settings['image_mobile_behavior_close']) ? $woof_settings['image_mobile_behavior_close'] : '') ?>" />
                                <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a>
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Filter image when to activate mobile phone mode. If you want to remove the image just insert -1', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>
                        <h4><?php esc_html_e('Text for close mobile filter', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control woof-upload-style-wrap">
                                <?php
                                if (!isset($woof_settings['text_mobile_behavior_close'])) {
                                    $woof_settings['text_mobile_behavior_close'] = esc_html__('Close filter', 'woocommerce-products-filter');
                                }
                                ?>
                                <input type="text" name="woof_settings[text_mobile_behavior_close]" value="<?php echo $woof_settings['text_mobile_behavior_close'] ?>" />
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('Filter text when to activate mobile phone mode. If you want to remove the text just insert  -1', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>						

                    </div><!--/ .woof-control-section-->					


                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Toggle block type', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">

                            <div class="woof-control woof-upload-style-wrap">

                                <?php
                                $toggle_types = array(
                                    'text' => esc_html__('Text', 'woocommerce-products-filter'),
                                    'image' => esc_html__('Images', 'woocommerce-products-filter')
                                );

                                if (!isset($woof_settings['toggle_type'])) {
                                    $woof_settings['toggle_type'] = 'text';
                                }
                                $toggle_type = $woof_settings['toggle_type'];
                                ?>

                                <div class="select-wrap">
                                    <select name="woof_settings[toggle_type]" class="chosen_select" id="toggle_type">
                                        <?php foreach ($toggle_types as $key => $value) : ?>
                                            <option value="<?php echo $key; ?>" <?php if ($toggle_type == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                            </div>
                            <div class="woof-description">
                                <p class="description">
                                    <?php esc_html_e('Type of the toogle on the front for block of html-items as: radio, checkbox .... Works only if the block title is not hidden!', 'woocommerce-products-filter') ?>
                                </p>
                            </div>
                        </div>

                        <div class="toggle_type_text" <?php if ($toggle_type == 'image'): ?>style="display: none;"<?php endif; ?>>

                            <h4><?php esc_html_e('Text for block toggle opened', 'woocommerce-products-filter') ?></h4>

                            <div class="woof-control-container">
                                <div class="woof-control woof-upload-style-wrap">
                                    <?php
                                    if (!isset($woof_settings['toggle_opened_text'])) {
                                        $woof_settings['toggle_opened_text'] = '';
                                    }
                                    ?>
                                    <input type="text" name="woof_settings[toggle_opened_text]" value="<?php echo $woof_settings['toggle_opened_text'] ?>" />
                                </div>
                                <div class="woof-description">
                                    <p class="description"><?php esc_html_e('Toggle text for opened html-items block. Example: close. By default applied sign minus "-"', 'woocommerce-products-filter') ?></p>
                                </div>
                            </div>

                            <h4><?php esc_html_e('Text for block toggle closed', 'woocommerce-products-filter') ?></h4>

                            <div class="woof-control-container">
                                <div class="woof-control woof-upload-style-wrap">
                                    <?php
                                    if (!isset($woof_settings['toggle_closed_text'])) {
                                        $woof_settings['toggle_closed_text'] = '';
                                    }
                                    ?>
                                    <input type="text" name="woof_settings[toggle_closed_text]" value="<?php echo $woof_settings['toggle_closed_text'] ?>" />
                                </div>
                                <div class="woof-description">
                                    <p class="description"><?php esc_html_e('Toggle text for closed html-items block. Example: open. By default applied sign plus "+"', 'woocommerce-products-filter') ?></p>
                                </div>
                            </div>

                        </div>


                        <div class="toggle_type_image" <?php if ($toggle_type == 'text'): ?>style="display: none;"<?php endif; ?>>
                            <h4><?php esc_html_e('Image for block toggle [<i>opened</i>]', 'woocommerce-products-filter') ?></h4>

                            <div class="woof-control-container">
                                <div class="woof-control woof-upload-style-wrap">
                                    <?php
                                    if (!isset($woof_settings['toggle_opened_image'])) {
                                        $woof_settings['toggle_opened_image'] = '';
                                    }
                                    ?>
                                    <input type="text" name="woof_settings[toggle_opened_image]" value="<?php echo(isset($woof_settings['toggle_opened_image']) ? $woof_settings['toggle_opened_image'] : '') ?>" />
                                    <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a>
                                </div>
                                <div class="woof-description">
                                    <p class="description"><?php esc_html_e('Any image for opened html-items block 20x20', 'woocommerce-products-filter') ?></p>
                                </div>
                            </div>


                            <h4><?php esc_html_e('Image for block toggle closed', 'woocommerce-products-filter') ?></h4>

                            <div class="woof-control-container">
                                <div class="woof-control woof-upload-style-wrap">
                                    <?php
                                    if (!isset($woof_settings['toggle_closed_image'])) {
                                        $woof_settings['toggle_closed_image'] = '';
                                    }
                                    ?>
                                    <input type="text" name="woof_settings[toggle_closed_image]" value="<?php echo(isset($woof_settings['toggle_closed_image']) ? $woof_settings['toggle_closed_image'] : '') ?>" />
                                    <a href="#" class="woof-button woof_select_image"><?php esc_html_e('Select Image', 'woocommerce-products-filter') ?></a>
                                </div>
                                <div class="woof-description">
                                    <p class="description"><?php esc_html_e('Any image for closed html-items block 20x20', 'woocommerce-products-filter') ?></p>
                                </div>
                            </div>
                        </div>


                    </div><!--/ .woof-control-section-->

                    <?php
                    if (!isset($woof_settings['custom_front_css'])) {
                        $woof_settings['custom_front_css'] = '';
                    }
                    ?>

                    <div class="woof-control-section">

                        <h4><?php esc_html_e('Custom front css styles file link', 'woocommerce-products-filter') ?></h4>

                        <div class="woof-control-container">
                            <div class="woof-control">
                                <input type="text" name="woof_settings[custom_front_css]" value="<?php echo $woof_settings['custom_front_css'] ?>" />
                            </div>
                            <div class="woof-description">
                                <p class="description"><?php esc_html_e('For developers who want to rewrite front css of the plugin front side. You are need to know CSS for this!', 'woocommerce-products-filter') ?></p>
                            </div>
                        </div>

                    </div><!--/ .woof-control-section-->

                    <?php do_action('woof_print_design_additional_options'); ?>

                </section>

                <section id="tabs-4">

                    <div class="woof-tabs woof-tabs-style-line">

                        <nav>
                            <ul>
                                <li>
                                    <a href="#tabs-41">
                                        <span><?php esc_html_e("Code", 'woocommerce-products-filter') ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tabs-42">
                                        <span><?php esc_html_e("Options", 'woocommerce-products-filter') ?></span>
                                    </a>
                                </li>
                                <?php do_action('woof_print_applications_tabs_anvanced'); ?>
                            </ul>
                        </nav>

                        <div class="content-wrap">

                            <section id="tabs-41">

                                <table class="form-table">

                                    <tr>
                                        <th scope="row"><label for="custom_css_code"><?php esc_html_e('Custom CSS code', 'woocommerce-products-filter') ?></label></th>

                                        <td>
                                            <textarea class="wide woof_custom_css" id="custom_css_code" name="woof_settings[custom_css_code]"><?php echo(isset($this->settings['custom_css_code']) ? stripcslashes($this->settings['custom_css_code']) : '') ?></textarea>
                                            <p class="description"><?php esc_html_e("If you are need to customize something and you don't want to lose your changes after update", 'woocommerce-products-filter') ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label for="js_after_ajax_done"><?php esc_html_e('JavaScript code after AJAX is done', 'woocommerce-products-filter') ?></label></th>
                                        <td>
                                            <textarea class="wide woof_custom_css" id="js_after_ajax_done" name="woof_settings[js_after_ajax_done]"><?php echo(isset($this->settings['js_after_ajax_done']) ? stripcslashes($this->settings['js_after_ajax_done']) : '') ?></textarea>
                                            <p class="description"><?php esc_html_e('Use it when you are need additional action after AJAX redraw your products in shop page or in page with shortcode! For use when you need additional functionality after AJAX redraw of your products on the shop page or on pages with shortcodes.', 'woocommerce-products-filter') ?></p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row"><label for="init_only_on"><?php esc_html_e('Init plugin on the next site pages only ', 'woocommerce-products-filter') ?></label></th>
                                        <td>
                                            <div class="woof-control-section">
                                                <div class="woof-control-container">
                                                    <div class="woof-control">

                                                        <?php
                                                        $init_only_on_r = array(
                                                            0 => esc_html__("Yes", 'woocommerce-products-filter'),
                                                            1 => esc_html__("No", 'woocommerce-products-filter')
                                                        );
                                                        ?>

                                                        <?php
                                                        if (!isset($woof_settings['init_only_on_reverse']) OR empty($woof_settings['init_only_on_reverse'])) {
                                                            $woof_settings['init_only_on_reverse'] = 0;
                                                        }
                                                        ?>
                                                        <div class="select-wrap">
                                                            <select name="woof_settings[init_only_on_reverse]">
                                                                <?php foreach ($init_only_on_r as $key => $value) : ?>
                                                                    <option value="<?php echo $key; ?>" <?php if ($woof_settings['init_only_on_reverse'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="woof-description woof_fix13">
                                                        <p class="description"><?php esc_html_e("Reverse: deactivate plugin on the next site pages only", 'woocommerce-products-filter') ?></p>
                                                    </div>
                                                </div>

                                            </div><!--/ .woof-control-section-->



                                            <?php
                                            if (!isset($this->settings['init_only_on'])) {
                                                $this->settings['init_only_on'] = '';
                                            }
                                            ?>
                                            <textarea class="wide woof_custom_css" id="init_only_on" name="woof_settings[init_only_on]"><?php echo stripcslashes(trim($this->settings['init_only_on'])) ?></textarea>
                                            <p class="description"><?php esc_html_e('This option enables or disables initialization of the plugin on all pages of the site except links and link-masks in the textarea. One row - one link (or link-mask)! Example of link: http://site.com/ajaxed-search-7. Example of link-mask: product-category . Leave it empty to allow the plugin initialization on all pages of the site!', 'woocommerce-products-filter') ?></p>
                                            <p class="description"><?php esc_html_e('Use sign # before link to apply strict compliance. Example: #https://your_site.com/product-category/man/', 'woocommerce-products-filter') ?></p>
                                        </td>
                                    </tr>


                                    <?php if (class_exists('SitePress') OR class_exists('Polylang')): ?>
                                        <tr>
                                            <th scope="row"><label for="wpml_tax_labels">
                                                    <?php esc_html_e('WPML taxonomies labels translations', 'woocommerce-products-filter') ?> <img class="help_tip" data-tip="Syntax:
                                                         es:Locations^Ubicaciones
                                                         es:Size^Tamaño
                                                         de:Locations^Lage
                                                         de:Size^Größe" src="<?php echo WP_PLUGIN_URL ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                                                </label></th>
                                            <td>

                                                <?php
                                                $wpml_tax_labels = "";
                                                if (isset($woof_settings['wpml_tax_labels']) AND is_array($woof_settings['wpml_tax_labels'])) {
                                                    foreach ($woof_settings['wpml_tax_labels'] as $lang => $words) {
                                                        if (!empty($words) AND is_array($words)) {
                                                            foreach ($words as $key_word => $translation) {
                                                                $wpml_tax_labels .= $lang . ':' . $key_word . '^' . $translation . PHP_EOL;
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>

                                                <textarea class="wide woof_custom_css" id="wpml_tax_labels" name="woof_settings[wpml_tax_labels]"><?php echo $wpml_tax_labels ?></textarea>
                                                <p class="description"><?php esc_html_e('Use it if you can not translate your custom taxonomies labels and attributes labels by another plugins.', 'woocommerce-products-filter') ?></p>

                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                </table>

                            </section>

                            <section id="tabs-42">

                                <div class="woof-control-section">

                                    <h5><?php esc_html_e('Search slug', 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">

                                            <?php
                                            if (!isset($woof_settings['swoof_search_slug'])) {
                                                $woof_settings['swoof_search_slug'] = '';
                                            }
                                            ?>

                                            <input placeholder="swoof" type="text" name="woof_settings[swoof_search_slug]" value="<?php echo $woof_settings['swoof_search_slug'] ?>" id="swoof_search_slug" />

                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e('If you do not like search key "swoof" in the search link you can replace it by your own word. But be care to avoid conflicts with any themes and plugins, + never define it as symbol "s".<br /> Not understood? Simply do not touch it!', 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                                <div class="woof-control-section">

                                    <h5><?php esc_html_e('Products per page', 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">
                                            <?php
                                            if (!isset($woof_settings['per_page'])) {
                                                $woof_settings['per_page'] = -1;
                                            }
                                            ?>

                                            <input type="text" name="woof_settings[per_page]" value="<?php echo $woof_settings['per_page'] ?>" id="per_page" />
                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e('Products per page when searching is going only. Set here -1 to prevent pagination managing from here!', 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                                <div class="woof-control-section">

                                    <h5><?php esc_html_e("Optimize loading of WOOF JavaScript files", 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">

                                            <?php
                                            $optimize_js_files = array(
                                                0 => esc_html__("No", 'woocommerce-products-filter'),
                                                1 => esc_html__("Yes", 'woocommerce-products-filter')
                                            );
                                            ?>

                                            <?php
                                            if (!isset($woof_settings['optimize_js_files']) OR empty($woof_settings['optimize_js_files'])) {
                                                $woof_settings['optimize_js_files'] = 0;
                                            }
                                            ?>

                                            <select name="woof_settings[optimize_js_files]">
                                                <?php foreach ($optimize_js_files as $key => $value) : ?>
                                                    <option value="<?php echo $key; ?>" <?php if ($woof_settings['optimize_js_files'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e("This option place WOOF JavaScript files on the site footer. Use it for page loading optimization. Be care with this option, and always after enabling of it test your site frontend!", 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                                <div class="woof-control-section">

                                    <h5><?php esc_html_e('Override no products found content', 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">

                                            <?php
                                            if (!isset($woof_settings['override_no_products'])) {
                                                $woof_settings['override_no_products'] = '';
                                            }
                                            ?>

                                            <textarea name="woof_settings[override_no_products]" id="override_no_products" ><?php echo $woof_settings['override_no_products'] ?></textarea>

                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e('Place in which you can paste text or/and any shortcodes which will be displayed when customer will not find any products by his search criterias. Example:', 'woocommerce-products-filter') ?> <i class="woof_orangered">&lt;center&gt;&lt;h2>Where are the products?&lt;/h2&gt;&lt;/center&gt;&lt;h4&gt;Perhaps you will like next products&lt;/h4&gt;[recent_products limit="3" columns="4" ]</i> (<?php esc_html_e('do not use shortcodes here in turbo mode', 'woocommerce-products-filter') ?>)</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="woof-control-section woof_premium_only">
                                    <?php
                                    $show_images_by_attr = array(
                                        0 => esc_html__("No", 'woocommerce-products-filter'),
                                        1 => esc_html__("Yes", 'woocommerce-products-filter')
                                    );
                                    if (!isset($woof_settings['show_images_by_attr_show']) OR empty($woof_settings['show_images_by_attr_show'])) {
                                        $woof_settings['show_images_by_attr_show'] = 0;
                                    }
                                    ?>

                                    <h5><?php esc_html_e("Show image of variation", 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">

                                            <select name="woof_settings[show_images_by_attr_show]">
                                                <?php foreach ($show_images_by_attr as $key => $value) : ?>
                                                    <option value="<?php echo $key; ?>" <?php if ($woof_settings['show_images_by_attr_show'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                            <?php
                                            $attributes = wc_get_attribute_taxonomies();
                                            ?>

                                            <?php
                                            if (!isset($woof_settings['show_images_by_attr']) OR empty($woof_settings['show_images_by_attr'])) {
                                                $woof_settings['show_images_by_attr'] = array();
                                            }
                                            ?>
                                            <div class="select-wrap chosen_select" <?php echo (!$woof_settings['show_images_by_attr_show']) ? "style='display:none;'" : ""; ?> >
                                                <select  class="chosen_select" multiple name="woof_settings[show_images_by_attr][]">
                                                    <?php foreach ($attributes as $attr) : ?>
                                                        <option value="pa_<?php echo $attr->attribute_name ?>" <?php if (in_array('pa_' . $attr->attribute_name, $woof_settings['show_images_by_attr'])): ?>selected="selected"<?php endif; ?>><?php echo $attr->attribute_label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                        </div>


                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e("For variable products you can show an image depending on the current filter selection. For example you have variation with red color, and that varation has its own preview image - if on the site front user will select red color this imag will be shown. You can select attributes by which images will be selected", 'woocommerce-products-filter') ?></p>
                                        </div>

                                    </div>

                                </div><!--/ .woof-control-section-->

                                <div class="woof-control-section woof_premium_only">

                                    <h5><?php esc_html_e("Hide terms count text", 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">

                                            <?php
                                            $hide_terms_count_txt = array(
                                                0 => esc_html__("No", 'woocommerce-products-filter'),
                                                1 => esc_html__("Yes", 'woocommerce-products-filter')
                                            );
                                            ?>

                                            <?php
                                            if (!isset($woof_settings['hide_terms_count_txt']) OR empty($woof_settings['hide_terms_count_txt'])) {
                                                $woof_settings['hide_terms_count_txt'] = 0;
                                            }
                                            ?>

                                            <select name="woof_settings[hide_terms_count_txt]">
                                                <?php foreach ($hide_terms_count_txt as $key => $value) : ?>
                                                    <option value="<?php echo $key; ?>" <?php if ($woof_settings['hide_terms_count_txt'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e("If you want show relevant tags on the categories pages you should activate show count, dynamic recount and <b>hide empty terms</b> in the tab Options. But if you do not want show count (number) text near each term - set Yes here.", 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                                <div class="woof-control-section">

                                    <h5><?php esc_html_e("Listen catalog visibility", 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">

                                            <?php
                                            $listen_catalog_visibility = array(
                                                0 => esc_html__("No", 'woocommerce-products-filter'),
                                                1 => esc_html__("Yes", 'woocommerce-products-filter')
                                            );
                                            ?>

                                            <?php
                                            if (!isset($woof_settings['listen_catalog_visibility']) OR empty($woof_settings['listen_catalog_visibility'])) {
                                                $woof_settings['listen_catalog_visibility'] = 0;
                                            }
                                            ?>

                                            <select name="woof_settings[listen_catalog_visibility]">
                                                <?php foreach ($listen_catalog_visibility as $key => $value) : ?>
                                                    <option value="<?php echo $key; ?>" <?php if ($woof_settings['listen_catalog_visibility'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                        </div>
                                        <div class="woof-description">
                                            <p class="description">
                                                <?php esc_html_e("Listen catalog visibility - options in each product backend page in 'Publish' sidebar widget.", 'woocommerce-products-filter') ?><br />
                                                <a href="<?php echo WOOF_LINK ?>img/plugin_options/listen_catalog_visibility.png" target="_blank"><img src="<?php echo WOOF_LINK ?>img/plugin_options/listen_catalog_visibility.png" width="150" alt="" /></a>
                                            </p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->


                                <div class="woof-control-section">

                                    <h5><?php esc_html_e("Disable swoof influence", 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">

                                            <?php
                                            $disable_swoof_influence = array(
                                                0 => esc_html__("No", 'woocommerce-products-filter'),
                                                1 => esc_html__("Yes", 'woocommerce-products-filter')
                                            );
                                            ?>

                                            <?php
                                            if (!isset($woof_settings['disable_swoof_influence']) OR empty($woof_settings['disable_swoof_influence'])) {
                                                $woof_settings['disable_swoof_influence'] = 0;
                                            }
                                            ?>

                                            <select name="woof_settings[disable_swoof_influence]">
                                                <?php foreach ($disable_swoof_influence as $key => $value) : ?>
                                                    <option value="<?php echo $key; ?>" <?php if ($woof_settings['disable_swoof_influence'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e("Sometimes code '<code>wp_query->is_post_type_archive = true</code>' does not necessary. Try to disable this and try woof-search on your site. If all is ok - leave its disabled. Disabled code by this option you can find in index.php by mark disable_swoof_influence.", 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                                <?php if (!isset($woof_settings['woof_turbo_mode']['enable']) OR $woof_settings['woof_turbo_mode']['enable'] != 1 OR!class_exists("WOOF_EXT_TURBO_MODE")) { ?>
                                    <div class="woof-control-section">

                                        <h5><?php esc_html_e("Cache dynamic recount number for each item in filter", 'woocommerce-products-filter') ?></h5>

                                        <div class="woof-control-container">
                                            <div class="woof-control">

                                                <?php
                                                $cache_count_data = array(
                                                    0 => esc_html__("No", 'woocommerce-products-filter'),
                                                    1 => esc_html__("Yes", 'woocommerce-products-filter')
                                                );
                                                ?>

                                                <?php
                                                if (!isset($woof_settings['cache_count_data']) OR empty($woof_settings['cache_count_data'])) {
                                                    $woof_settings['cache_count_data'] = 0;
                                                }
                                                ?>

                                                <select name="woof_settings[cache_count_data]">
                                                    <?php foreach ($cache_count_data as $key => $value) : ?>
                                                        <option value="<?php echo $key; ?>" <?php if ($woof_settings['cache_count_data'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                    <?php endforeach; ?>
                                                </select>


                                                <?php if ($woof_settings['cache_count_data']): ?>
                                                    <br />
                                                    <br /><a href="#" class="button js_cache_count_data_clear"><?php esc_html_e("clear cache", 'woocommerce-products-filter') ?></a>&nbsp;<span class="woof_green"></span><br />
                                                    <br />
                                                    <?php
                                                    $clean_period = 'days7';
                                                    if (isset($this->settings['cache_count_data_auto_clean'])) {
                                                        $clean_period = $this->settings['cache_count_data_auto_clean'];
                                                    }
                                                    $periods = array(
                                                        0 => esc_html__("do not clean cache automatically", 'woocommerce-products-filter'),
                                                        'hourly' => esc_html__("clean cache automatically hourly", 'woocommerce-products-filter'),
                                                        'twicedaily' => esc_html__("clean cache automatically twicedaily", 'woocommerce-products-filter'),
                                                        'daily' => esc_html__("clean cache automatically daily", 'woocommerce-products-filter'),
                                                        'days2' => esc_html__("clean cache automatically each 2 days", 'woocommerce-products-filter'),
                                                        'days3' => esc_html__("clean cache automatically each 3 days", 'woocommerce-products-filter'),
                                                        'days4' => esc_html__("clean cache automatically each 4 days", 'woocommerce-products-filter'),
                                                        'days5' => esc_html__("clean cache automatically each 5 days", 'woocommerce-products-filter'),
                                                        'days6' => esc_html__("clean cache automatically each 6 days", 'woocommerce-products-filter'),
                                                        'days7' => esc_html__("clean cache automatically each 7 days", 'woocommerce-products-filter')
                                                    );
                                                    ?>

                                                    <select name="woof_settings[cache_count_data_auto_clean]">
                                                        <?php foreach ($periods as $key => $txt): ?>
                                                            <option <?php selected($clean_period, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>


                                                <?php endif; ?>

                                            </div>
                                            <div class="woof-description">

                                                <?php
                                                global $wpdb;

                                                $charset_collate = '';
                                                if (method_exists($wpdb, 'has_cap') AND $wpdb->has_cap('collation')) {
                                                    if (!empty($wpdb->charset)) {
                                                        $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
                                                    }
                                                    if (!empty($wpdb->collate)) {
                                                        $charset_collate .= " COLLATE $wpdb->collate";
                                                    }
                                                }
                                                //***
                                                $sql = "CREATE TABLE IF NOT EXISTS `" . WOOF::$query_cache_table . "` (
                                                    `mkey` varchar(64) NOT NULL,
                                                    `mvalue` text NOT NULL,
                                                    KEY `mkey` (`mkey`)
                                                  ) {$charset_collate}";

                                                if ($wpdb->query($sql) === false) {
                                                    ?>
                                                    <p class="description"><?php esc_html_e("WOOF cannot create the database table! Make sure that your mysql user has the CREATE privilege! Do it manually using your host panel&phpmyadmin!", 'woocommerce-products-filter') ?></p>
                                                    <code><?php echo $sql; ?></code>
                                                    <input type="hidden" name="woof_settings[cache_count_data]" value="0" />
                                                    <?php
                                                    echo $wpdb->last_error;
                                                }
                                                ?>

                                                <p class="description"><?php esc_html_e("Useful thing when you already set your site IN THE PRODUCTION MODE and use dynamic recount -> it make recount very fast! Of course if you added new products which have to be in search results you have to clean this cache OR you can set time period for auto cleaning!", 'woocommerce-products-filter') ?></p>
                                            </div>
                                        </div>

                                    </div><!--/ .woof-control-section-->



                                    <div class="woof-control-section">

                                        <h5><?php esc_html_e("Cache terms", 'woocommerce-products-filter') ?></h5>

                                        <div class="woof-control-container">
                                            <div class="woof-control">

                                                <?php
                                                $cache_terms = array(
                                                    0 => esc_html__("No", 'woocommerce-products-filter'),
                                                    1 => esc_html__("Yes", 'woocommerce-products-filter')
                                                );
                                                ?>

                                                <?php
                                                if (!isset($woof_settings['cache_terms']) OR empty($woof_settings['cache_terms'])) {
                                                    $woof_settings['cache_terms'] = 0;
                                                }
                                                ?>

                                                <select name="woof_settings[cache_terms]">
                                                    <?php foreach ($cache_terms as $key => $value) : ?>
                                                        <option value="<?php echo $key; ?>" <?php if ($woof_settings['cache_terms'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                    <?php endforeach; ?>
                                                </select>


                                                <?php if ($woof_settings['cache_terms']): ?>
                                                    <br />
                                                    <br /><a href="#" class="button js_cache_terms_clear"><?php esc_html_e("clear terms cache", 'woocommerce-products-filter') ?></a>&nbsp;<span class="woof_green"></span><br />
                                                    <br />
                                                    <?php
                                                    $clean_period = 'days7';
                                                    if (isset($this->settings['cache_terms_auto_clean'])) {
                                                        $clean_period = $this->settings['cache_terms_auto_clean'];
                                                    }
                                                    $periods = array(
                                                        0 => esc_html__("do not clean cache automatically", 'woocommerce-products-filter'),
                                                        'hourly' => esc_html__("clean cache automatically hourly", 'woocommerce-products-filter'),
                                                        'twicedaily' => esc_html__("clean cache automatically twicedaily", 'woocommerce-products-filter'),
                                                        'daily' => esc_html__("clean cache automatically daily", 'woocommerce-products-filter'),
                                                        'days2' => esc_html__("clean cache automatically each 2 days", 'woocommerce-products-filter'),
                                                        'days3' => esc_html__("clean cache automatically each 3 days", 'woocommerce-products-filter'),
                                                        'days4' => esc_html__("clean cache automatically each 4 days", 'woocommerce-products-filter'),
                                                        'days5' => esc_html__("clean cache automatically each 5 days", 'woocommerce-products-filter'),
                                                        'days6' => esc_html__("clean cache automatically each 6 days", 'woocommerce-products-filter'),
                                                        'days7' => esc_html__("clean cache automatically each 7 days", 'woocommerce-products-filter')
                                                    );
                                                    ?>
                                                    <div class="select-wrap">
                                                        <select name="woof_settings[cache_terms_auto_clean]">
                                                            <?php foreach ($periods as $key => $txt): ?>
                                                                <option <?php selected($clean_period, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                <?php endif; ?>

                                            </div>
                                            <div class="woof-description">
                                                <p class="description"><?php esc_html_e("Useful thing when you already set your site IN THE PRODUCTION MODE - its getting terms for filter faster without big MySQL queries! If you actively adds new terms every day or week you can set cron period for cleaning. Another way set: '<b>not clean cache automatically</b>'!", 'woocommerce-products-filter') ?></p>
                                            </div>
                                        </div>

                                    </div><!--/ .woof-control-section-->

                                    <div class="woof-control-section">

                                        <h5><?php esc_html_e("Optimize price filter", 'woocommerce-products-filter') ?></h5>

                                        <div class="woof-control-container">
                                            <div class="woof-control">

                                                <?php
                                                $price_transient = array(
                                                    0 => esc_html__("No", 'woocommerce-products-filter'),
                                                    1 => esc_html__("Yes", 'woocommerce-products-filter')
                                                );
                                                ?>

                                                <?php
                                                if (!isset($woof_settings['price_transient']) OR empty($woof_settings['price_transient'])) {
                                                    $woof_settings['price_transient'] = 0;
                                                }
                                                ?>

                                                <select name="woof_settings[price_transient]">
                                                    <?php foreach ($price_transient as $key => $value) : ?>
                                                        <option value="<?php echo $key; ?>" <?php if ($woof_settings['price_transient'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                    <?php endforeach; ?>
                                                </select>


                                                <?php if ($woof_settings['price_transient']): ?>
                                                    <br />
                                                    <br /><a href="#" class="button js_price_transient_clear"><?php esc_html_e("clear", 'woocommerce-products-filter') ?></a>&nbsp;<span class="woof_green"></span><br />
                                                    <br />
                                                <?php endif; ?>

                                            </div>
                                            <div class="woof-description">
                                                <p class="description"><?php esc_html_e("Helps to more quickly find the minimum and maximum values for the filter by price on the site front and minimize server loading.", 'woocommerce-products-filter') ?></p>
                                            </div>
                                        </div>

                                    </div><!--/ .woof-control-section-->   

                                <?php } ?>
                                <div class="woof-control-section">

                                    <h5><?php esc_html_e("Show blocks helper button", 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">

                                            <?php
                                            $show_woof_edit_view = array(
                                                0 => esc_html__("No", 'woocommerce-products-filter'),
                                                1 => esc_html__("Yes", 'woocommerce-products-filter')
                                            );
                                            ?>

                                            <?php
                                            if (!isset($woof_settings['show_woof_edit_view'])) {
                                                $woof_settings['show_woof_edit_view'] = 0;
                                            }
                                            ?>

                                            <select id="show_woof_edit_view" name="woof_settings[show_woof_edit_view]">
                                                <?php foreach ($show_woof_edit_view as $key => $value) : ?>
                                                    <option value="<?php echo $key; ?>" <?php if ($woof_settings['show_woof_edit_view'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e("Show helper button for shortcode [woof] on the front when 'Set filter automatically' is Yes", 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                                <div class="woof-control-section">

                                    <h5><?php esc_html_e('Custom extensions folder', 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">
                                            <?php
                                            if (!isset($woof_settings['custom_extensions_path'])) {
                                                $woof_settings['custom_extensions_path'] = '';
                                            }
                                            ?>

                                            <input type="text" name="woof_settings[custom_extensions_path]" value="<?php echo $woof_settings['custom_extensions_path'] ?>" id="custom_extensions_path" placeholder="Example: my_woof_extensions" />
                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php printf(__('Custom extensions folder path relative to: %s', 'woocommerce-products-filter'), WP_CONTENT_DIR . DIRECTORY_SEPARATOR) ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                                <div class="woof-control-section">

                                    <h5><?php esc_html_e('Result count css selector', 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">
                                            <?php
                                            if (!isset($woof_settings['result_count_redraw'])) {
                                                $woof_settings['result_count_redraw'] = "";
                                            }
                                            ?>

                                            <input type="text" name="woof_settings[result_count_redraw]" value="<?php echo $woof_settings['result_count_redraw'] ?>"  />
                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e('Css class of result-count container. Is needed for ajax compatibility with wp themes. If you do not understand, leave it blank.', 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                                <div class="woof-control-section">

                                    <h5><?php esc_html_e('Order dropdown css selector', 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">
                                            <?php
                                            if (!isset($woof_settings['order_dropdown_redraw'])) {
                                                $woof_settings['order_dropdown_redraw'] = "";
                                            }
                                            ?>

                                            <input type="text" name="woof_settings[order_dropdown_redraw]" value="<?php echo $woof_settings['order_dropdown_redraw'] ?>"  />
                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e('Css class of ordering dropdown container. Is needed for ajax compatibility with wp themes. If you do not understand, leave it blank.', 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->
                                <div class="woof-control-section">

                                    <h5><?php esc_html_e('Per page css selector', 'woocommerce-products-filter') ?></h5>

                                    <div class="woof-control-container">
                                        <div class="woof-control">
                                            <?php
                                            if (!isset($woof_settings['per_page_redraw'])) {
                                                $woof_settings['per_page_redraw'] = "";
                                            }
                                            ?>

                                            <input type="text" name="woof_settings[per_page_redraw]" value="<?php echo $woof_settings['per_page_redraw'] ?>"  />
                                        </div>
                                        <div class="woof-description">
                                            <p class="description"><?php esc_html_e('Css class of per page dropdown container. Is needed for ajax compatibility with wp themes. If you do not understand, leave it blank.', 'woocommerce-products-filter') ?></p>
                                        </div>
                                    </div>

                                </div><!--/ .woof-control-section-->

                            </section>

                            <?php do_action('woof_print_applications_tabs_content_advanced'); ?>

                        </div>

                    </div>

                </section>



                <?php
                if (!empty(WOOF_EXT::$includes['applications'])) {
                    foreach (WOOF_EXT::$includes['applications'] as $obj) {
                        $dir1 = $this->get_custom_ext_path() . $obj->folder_name;
                        $dir2 = WOOF_EXT_PATH . $obj->folder_name;
                        $checked1 = WOOF_EXT::is_ext_activated($dir1);
                        $checked2 = WOOF_EXT::is_ext_activated($dir2);
                        if ($checked1 OR $checked2) {
                            do_action('woof_print_applications_tabs_content_' . $obj->folder_name);
                        }
                    }
                }
                ?>



                <section id="tabs-6">

                    <div class="woof-tabs woof-tabs-style-line">

                        <nav>
                            <ul>
                                <li>
                                    <a href="#tabs-61">
                                        <span><?php esc_html_e("Extensions", 'woocommerce-products-filter') ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tabs-62">
                                        <span><?php esc_html_e("Ext-Applications options", 'woocommerce-products-filter') ?></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <div class="content-wrap">


                            <section id="tabs-61">

                                <div class="select-wrap">
                                    <select id="woof_manipulate_with_ext">
                                        <option value="0"><?php esc_html_e('All', 'woocommerce-products-filter') ?></option>
                                        <option value="1"><?php esc_html_e('Enabled', 'woocommerce-products-filter') ?></option>
                                        <option value="2"><?php esc_html_e('Disabled', 'woocommerce-products-filter') ?></option>
                                    </select>
                                </div>

                                <input type="hidden" name="woof_settings[activated_extensions]" value="" />


                                <?php if (true): ?>


                                    <!-- ----------------------------------------- -->
                                    <?php if (isset($this->settings['custom_extensions_path']) AND!empty($this->settings['custom_extensions_path'])): ?>

                                        <br />
                                        <hr />
                                        <h3><?php esc_html_e('Custom extensions installation', 'woocommerce-products-filter') ?></h3>

                                        <?php
                                        $is_custom_extensions = false;
                                        if (is_dir($this->get_custom_ext_path())) {
                                            //$dir_writable = substr(sprintf('%o', fileperms($this->get_custom_ext_path())), -4) == "0774" ? true : false;
                                            $dir_writable = is_writable($this->get_custom_ext_path());
                                            if ($dir_writable) {
                                                $is_custom_extensions = true;
                                            }
                                        } else {
                                            if (!empty($this->settings['custom_extensions_path'])) {
                                                //ext dir auto creation
                                                $dir = $this->get_custom_ext_path();
                                                try {
                                                    mkdir($dir, 0777);
                                                    $dir_writable = is_writable($this->get_custom_ext_path());
                                                    if ($dir_writable) {
                                                        $is_custom_extensions = true;
                                                    }
                                                } catch (Exception $e) {
                                                    //***
                                                }
                                            }
                                        }
                                        //***
                                        if ($is_custom_extensions):
                                            ?>
                                            <input type="button" id="upload-btn" class="button" value="<?php esc_html_e('Choose an extension zip', 'woocommerce-products-filter') ?>">
                                            <span class="woof_fix14"><i><?php esc_html_e('(zip)', 'woocommerce-products-filter') ?></i></span>

                                            <div id="errormsg" class="clearfix redtext"></div>

                                            <div id="pic-progress-wrap" class="progress-wrap"></div>

                                            <div id="picbox" class="clear"></div>

                                        <?php else: ?>
                                            <span class="woof_orangered"><?php printf(__('Note for admin: Folder %s for extensions is not writable OR doesn exists! Ignore this message if you not planning using WOOF custom extensions!', 'woocommerce-products-filter'), $this->get_custom_ext_path()) ?></span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if (!empty($this->settings['custom_extensions_path'])): ?>
                                            <span class="woof_orangered"><?php esc_html_e('<b>Note for admin</b>: Create folder for custom extensions in wp-content folder: tab Advanced -> Options -> Custom extensions folder', 'woocommerce-products-filter') ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <!-- ----------------------------------------- -->




                                    <?php
                                    if (!isset($woof_settings['activated_extensions']) OR!is_array($woof_settings['activated_extensions'])) {
                                        $woof_settings['activated_extensions'] = array();
                                    }
                                    ?>
                                    <?php if (!empty($extensions) AND is_array($extensions)): ?>

                                        <input type="hidden" id="rm-ext-nonce" value="<?php echo wp_create_nonce('rm-ext-nonce') ?>">
                                        <ul class="woof_extensions woof_custom_extensions">

                                            <?php foreach ($extensions['custom'] as $dir): ?>
                                                <?php
                                                $checked = WOOF_EXT::is_ext_activated($dir);
                                                $idx = WOOF_EXT::get_ext_idx_new($dir);
                                                ?>
                                                <li class="woof_ext_li <?php echo($checked ? 'is_enabled' : 'is_disabled'); ?>">
                                                    <?php
                                                    $info = array();
                                                    if (file_exists($dir . DIRECTORY_SEPARATOR . 'info.dat')) {
                                                        $info = WOOF_HELPER::parse_ext_data($dir . DIRECTORY_SEPARATOR . 'info.dat');
                                                    }
                                                    ?>
                                                    <table class="woof_width_100p">
                                                        <tr>
                                                            <td class="woof_valign_top">
                                                                <img width="85" src="<?php echo WOOF_LINK ?>img/woof_ext_cover.png" alt="ext cover" /><br />
                                                                <br />
                                                                <span class="woof_ext_ver"><?php
                                                                    if (isset($info['version'])) {
                                                                        printf(__('<i>ver.:</i> %s', 'woocommerce-products-filter'), $info['version']);
                                                                    }
                                                                    ?></span>
                                                            </td>
                                                            <td><div class="woof_width_5px"></div></td>
                                                            <td class="woof_fix14">
                                                                <a href="#" class="woof_ext_remove" data-title="" data-idx="<?php echo $idx ?>" title="<?php esc_html_e('remove extension', 'woocommerce-products-filter') ?>"><img src="<?php echo $this->settings['delete_image'] ?>" alt="<?php esc_html_e('remove extension', 'woocommerce-products-filter') ?>" /></a>
                                                                <?php
                                                                if (!empty($info)) {
                                                                    if (!empty($info) AND is_array($info)) {
                                                                        ?>
                                                                        <label for="<?php echo $idx ?>">
                                                                            <input type="checkbox" id="<?php echo $idx ?>" <?php if (isset($info['status']) AND $info['status'] == 'premium' AND $this->is_free_ver): ?>disabled="disabled"<?php endif; ?> <?php if ($checked): ?>checked=""<?php endif; ?> value="<?php echo $idx ?>" name="woof_settings[activated_extensions][]" />
                                                                            <?php
                                                                            if (isset($info['link'])) {
                                                                                ?>
                                                                                <a href="<?php echo $info['link'] ?>" class="woof_ext_title" target="_blank"><?php echo $info['title'] ?></a>
                                                                                <?php
                                                                            } else {
                                                                                echo $info['title'];
                                                                            }
                                                                            ?>
                                                                        </label><br />
                                                                        <?php
                                                                        if (isset($info['description'])) {
                                                                            echo '<br />';
                                                                            echo '<p class="description">' . $info['description'] . '</p>';
                                                                        }
                                                                    } else {
                                                                        echo $dir;
                                                                        echo '<br />';
                                                                        esc_html_e('You should write extension info in info.dat file!', 'woocommerce-products-filter');
                                                                    }
                                                                } else {
                                                                    printf(__('Looks like its not the WOOF extension here %s!', 'woocommerce-products-filter'), $dir);
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="clear clearfix"></div>
                                    <br />
                                    <hr />

                                    <?php if (!empty($extensions['default'])): ?>

                                        <h3><?php esc_html_e('Default extensions', 'woocommerce-products-filter') ?></h3>

                                        <ul class="woof_extensions">
                                            <?php foreach ($extensions['default'] as $dir): ?>
                                                <?php
                                                $checked = WOOF_EXT::is_ext_activated($dir);
                                                $idx = WOOF_EXT::get_ext_idx_new($dir);
                                                ?>
                                                <li class="woof_ext_li <?php echo($checked ? 'is_enabled' : 'is_disabled'); ?>">
                                                    <?php
                                                    $info = array();
                                                    if (file_exists($dir . DIRECTORY_SEPARATOR . 'info.dat')) {
                                                        $info = WOOF_HELPER::parse_ext_data($dir . DIRECTORY_SEPARATOR . 'info.dat');
                                                    }
                                                    ?>
                                                    <table class="woof_width_100p">
                                                        <tr>
                                                            <td class="woof_valign_top">
                                                                <img width="85" src="<?php echo WOOF_LINK ?>img/woof_ext_cover.png" alt="ext cover" /><br />
                                                                <br />
                                                                <span class="woof_ext_ver"><?php
                                                                    if (isset($info['version'])) {
                                                                        printf(__('<i>ver.:</i> %s', 'woocommerce-products-filter'), $info['version']);
                                                                    }
                                                                    ?></span>
                                                            </td>
                                                            <td><div class="woof_width_5px"></div></td>
                                                            <td class="woof_width_100p">
                                                                <?php
                                                                if (!empty($info)) {
                                                                    $info = WOOF_HELPER::parse_ext_data($dir . DIRECTORY_SEPARATOR . 'info.dat');
                                                                    if (!empty($info) AND is_array($info)) {
                                                                        ?>
                                                                        <label for="<?php echo $idx ?>">
                                                                            <input type="checkbox" id="<?php echo $idx ?>" <?php if (isset($info['status']) AND $info['status'] == 'premium'): ?>disabled="disabled"<?php endif; ?> <?php if ($checked): ?>checked=""<?php endif; ?> value="<?php echo $idx ?>" name="woof_settings[activated_extensions][]" />
                                                                            <?php
                                                                            if (isset($info['link'])) {
                                                                                ?>
                                                                                <a href="<?php echo $info['link'] ?>" class="woof_ext_title" target="_blank"><?php echo $info['title'] ?></a>
                                                                                <?php
                                                                            } else {
                                                                                echo $info['title'];
                                                                            }
                                                                            ?>
                                                                        </label><br />
                                                                        <?php
                                                                        echo '<br />';
                                                                        echo '<p class="description">' . $info['description'] . '</p>';
                                                                    } else {
                                                                        echo $dir;
                                                                        echo '<br />';
                                                                        esc_html_e('You should write extension info in info.dat file!', 'woocommerce-products-filter');
                                                                    }
                                                                } else {
                                                                    echo $dir;
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                <?php endif; ?>
                                <div class="clear"></div>


                            </section>


                            <section id="tabs-62">

                                <div class="woof-tabs woof-tabs-style-line">

                                    <nav class="woof_ext_nav">
                                        <ul>
                                            <?php
                                            $is_custom_extensions = false;
                                            if (is_dir($this->get_custom_ext_path())) {
                                                $dir_writable = is_writable($this->get_custom_ext_path());
                                                if ($dir_writable) {
                                                    $is_custom_extensions = true;
                                                }
                                            }

                                            if ($is_custom_extensions) {
                                                if (!empty(WOOF_EXT::$includes['applications'])) {
                                                    foreach (WOOF_EXT::$includes['applications'] as $obj) {

                                                        $dir = $this->get_custom_ext_path() . $obj->folder_name;
                                                        $checked = WOOF_EXT::is_ext_activated($dir);
                                                        if (!$checked) {
                                                            continue;
                                                        }
                                                        ?>
                                                        <li>

                                                            <?php
                                                            if (file_exists($dir . DIRECTORY_SEPARATOR . 'info.dat')) {
                                                                $info = WOOF_HELPER::parse_ext_data($dir . DIRECTORY_SEPARATOR . 'info.dat');
                                                                if (!empty($info) AND is_array($info)) {
                                                                    $name = $info['title'];
                                                                } else {
                                                                    $name = $obj->folder_name;
                                                                }
                                                            } else {
                                                                $name = $obj->folder_name;
                                                            }
                                                            ?>
                                                            <a href="#tabs-<?php echo sanitize_title($obj->folder_name) ?>" title="<?php printf(__("%s", 'woocommerce-products-filter'), $name) ?>">
                                                                <span class="woof_fix15"><?php printf(__("%s", 'woocommerce-products-filter'), $name) ?></span>
                                                            </a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>


                                        </ul>
                                    </nav>


                                    <div class="content-wrap woof_ext_opt">

                                        <?php
                                        if ($is_custom_extensions) {
                                            if (!empty(WOOF_EXT::$includes['applications'])) {
                                                foreach (WOOF_EXT::$includes['applications'] as $obj) {

                                                    $dir = $this->get_custom_ext_path() . $obj->folder_name;
                                                    $checked = WOOF_EXT::is_ext_activated($dir);
                                                    if (!$checked) {
                                                        continue;
                                                    }
                                                    do_action('woof_print_applications_options_' . $obj->folder_name);
                                                }
                                            }
                                        }
                                        ?>

                                    </div>


                                    <div class="clear"></div>

                                </div>




                            </section>

                        </div>

                    </div>

                </section>



                <section id="tabs-7">

                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><label><?php esc_html_e("Links", 'woocommerce-products-filter') ?></label></th>
                                <td>

                                    <ul>

                                        <li>
                                            <a class="button" href="https://products-filter.com/documentation/" target="_blank"><?php esc_html_e("WOOF documentation", 'woocommerce-products-filter') ?></a>
                                            <a class="button" href="https://products-filter.com/category/faq/" target="_blank"><?php esc_html_e("FAQ", 'woocommerce-products-filter') ?></a>
                                            <a class="button" href="https://products-filter.com/video-tutorials/" target="_blank"><?php esc_html_e("Video tutorials", 'woocommerce-products-filter') ?></a>
                                            <a class="button" href="https://pluginus.net/support/" target="_blank"><?php esc_html_e("Support", 'woocommerce-products-filter') ?></a>
                                            <a class="button" href="https://products-filter.com/translations/" target="_blank"><?php esc_html_e("Translations", 'woocommerce-products-filter') ?></a>
                                        </li>

                                    </ul>

                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php esc_html_e("Demo sites", 'woocommerce-products-filter') ?></label></th>
                                <td>

                                    <ul>

                                        <li>
                                            <a href="https://demo.products-filter.com/" class="button" target="_blank">Demo 1</a>&nbsp;
                                            <a href="https://demo10k.products-filter.com/" class="button" target="_blank">Demo 2</a>&nbsp;
                                            <a href="https://turbo.products-filter.com/" class="button" target="_blank">Demo 3</a>&nbsp;
                                        </li>
                                        <li>
                                            <a href="https://products-filter.com/styles-codes-applied-on-demo-site/" class="button" target="_blank"><?php esc_html_e("Styles and codes which are applied on the demo site", 'woocommerce-products-filter') ?></a>
                                        </li>

                                    </ul>

                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row"><label><?php esc_html_e("Quick video tutorial", 'woocommerce-products-filter') ?></label></th>
                                <td>

                                    <ul>

                                        <li>
                                            <iframe width="560" height="315" src="https://www.youtube.com/embed/jZPtdWgAxKk" frameborder="0" allowfullscreen></iframe>
                                        </li>

                                    </ul>

                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row"><label><?php esc_html_e("More video", 'woocommerce-products-filter') ?></label></th>
                                <td>

                                    <ul>

                                        <li>
                                            <a href="https://products-filter.com/video-tutorials/" class="button" target="_blank"><?php esc_html_e("Video tutorials", 'woocommerce-products-filter') ?></a>
                                        </li>

                                    </ul>

                                </td>
                            </tr>



                            <tr valign="top">
                                <th scope="row"><label><?php esc_html_e("GDPR", 'woocommerce-products-filter') ?></label></th>
                                <td>

                                    <ul>

                                        <li>
                                            <a href="https://products-filter.com/gdpr/" class="button" target="_blank"><?php esc_html_e("GDPR info", 'woocommerce-products-filter') ?></a>
                                        </li>

                                    </ul>

                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php esc_html_e("Recommended plugins for your site flexibility and features", 'woocommerce-products-filter') ?></label></th>
                                <td>

                                    <ul class="list_plugins">


                                        <li>
                                            <a href="https://currency-switcher.com/" width="300" alt="" target="_blank"><img width="300" src="<?php echo WOOF_LINK ?>img/plugin_options/banners/woocs.png" /></a>
                                            <p class="description"><?php esc_html_e("WooCommerce Currency Switcher – is the plugin that allows you to switch to different currencies and get their rates converted in the real time!", 'woocommerce-products-filter') ?></p>
                                        </li>

                                        <li>
                                            <a href="https://bulk-editor.com/downloads/" width="300" alt="" target="_blank"><img width="300" src="<?php echo WOOF_LINK ?>img/plugin_options/banners/bear.png" /></a>
                                            <p class="description"><?php esc_html_e("WordPress plugin for managing and bulk edit WooCommerce Products data in robust and flexible way! Be professionals with managing data of your woocommerce e-shop!", 'woocommerce-products-filter') ?></p>
                                        </li>

                                        <li>
                                            <a href="https://products-tables.com/" width="300" alt="" target="_blank"><img width="300" src="<?php echo WOOF_LINK ?>img/plugin_options/banners/woot.png" /></a>
                                            <p class="description"><?php esc_html_e("WooCommerce Active Products Table - WOOT - (new name is PROTAS) WooCommerce plugin for displaying shop products in table format. Woo Products Tables makes focus for your buyers on the things they want to get, nothing superfluous, just what the client wants, and full attention to what is offered!", 'woocommerce-products-filter') ?></p>
                                        </li>

                                        <li>
                                            <a href="https://wordpress.org/plugins/inpost-gallery/" target="_blank">InPost Gallery - flexible photo gallery</a>
                                            <p class="description"><?php esc_html_e("Insert Gallery in post, page and custom post types just in two clicks. You can create great galleries for your products.", 'woocommerce-products-filter') ?></p>
                                        </li>


                                        <li>
                                            <a href="https://wordpress.org/plugins/autoptimize/" target="_blank">Autoptimize</a>
                                            <p class="description"><?php esc_html_e("It concatenates all scripts and styles, minifies and compresses them, adds expires headers, caches them, and moves styles to the page head, and scripts to the footer", 'woocommerce-products-filter') ?></p>
                                        </li>


                                        <li>
                                            <a href="https://wordpress.org/plugins/pretty-link/" target="_blank">Pretty Link Lite</a>
                                            <p class="description"><?php esc_html_e("Shrink, beautify, track, manage and share any URL on or off of your WordPress website. Create links that look how you want using your own domain name!", 'woocommerce-products-filter') ?></p>
                                        </li>

                                        <li>
                                            <a href="https://wordpress.org/plugins/custom-post-type-ui/" target="_blank">Custom Post Type UI</a>
                                            <p class="description"><?php esc_html_e("This plugin provides an easy to use interface to create and administer custom post types and taxonomies in WordPress.", 'woocommerce-products-filter') ?></p>
                                        </li>

                                        <li>
                                            <a href="https://wordpress.org/plugins/widget-logic/other_notes/" target="_blank">Widget Logic</a>
                                            <p class="description"><?php esc_html_e("Widget Logic lets you control on which pages widgets appear using", 'woocommerce-products-filter') ?></p>
                                        </li>

                                        <li>
                                            <a href="https://wordpress.org/plugins/wp-super-cache/" target="_blank">WP Super Cache</a>
                                            <p class="description"><?php esc_html_e("Cache pages, allow to make a lot of search queries on your site without high load on your server!", 'woocommerce-products-filter') ?></p>
                                        </li>


                                        <li>
                                            <a href="https://wordpress.org/plugins/wp-migrate-db/" target="_blank">WP Migrate DB</a>
                                            <p class="description"><?php esc_html_e("Exports your database, does a find and replace on URLs and file paths, then allows you to save it to your computer.", 'woocommerce-products-filter') ?></p>
                                        </li>

                                        <li>
                                            <a href="https://wordpress.org/plugins/duplicator/" target="_blank">Duplicator</a>
                                            <p class="description"><?php esc_html_e("Duplicate, clone, backup, move and transfer an entire site from one location to another.", 'woocommerce-products-filter') ?></p>
                                        </li>

                                    </ul>

                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php esc_html_e("Adv", 'woocommerce-products-filter') ?></label></th>
                                <td>

                                    <ul>

                                        <li>
                                            <a href="https://wp.bulk-editor.com/" target="_blank" title="WPBE - WordPress Posts Bulk Editor Professional"><img src="<?php echo WOOF_LINK ?>img/plugin_options/banners/wpbe.png" alt="WPBE - WordPress Posts Bulk Editor Professional" width="300" /></a>
                                        </li>

                                    </ul>

                                </td>
                            </tr>

                        </tbody>
                    </table>

                </section>

            </div>

            <div class="woof_fix19">
                <a href="https://pluginus.net/" target="_blank" class="woof_powered_by">Powered by PluginUs.NET</a>
            </div>

        </div>


    </section><!--/ .woof-section-->

    <div id="woof-modal-content" style="display: none;">

        <div class="woof_option_container woof_option_all">

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Show title label', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('Show/Hide taxonomy block title on the front', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">

                    <div class="select-wrap">
                        <select class="woof_popup_option" data-option="show_title_label">
                            <option value="0"><?php esc_html_e('No', 'woocommerce-products-filter') ?></option>
                            <option value="1"><?php esc_html_e('Yes', 'woocommerce-products-filter') ?></option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Show toggle button', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('Show toggle button near the title on the front above the block of html-items', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">

                    <div class="select-wrap">
                        <select class="woof_popup_option" data-option="show_toggle_button">
                            <option value="0"><?php esc_html_e('No', 'woocommerce-products-filter') ?></option>
                            <option value="1"><?php esc_html_e('Yes, show as closed', 'woocommerce-products-filter') ?></option>
                            <option value="2"><?php esc_html_e('Yes, show as opened', 'woocommerce-products-filter') ?></option>
                        </select>
                    </div>

                </div>

            </div>
            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Tooltip', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('Show tooltip', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">

                    <div class="select-wrap">
                        <textarea class="woof_popup_option" data-option="tooltip_text" ></textarea>
                    </div>

                </div>

            </div>

        </div>


        <div class="woof_option_container woof_option_all">

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Not toggled terms count', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('Enter count of terms which should be visible to make all other collapsible. "Show more" button will be appeared. This feature is works with: radio, checkboxes, labels, colors.', 'woocommerce-products-filter') ?></span>
                    <span><?php printf(__('Advanced info is <a href="%s" target="_blank">here</a>', 'woocommerce-products-filter'), 'https://products-filter.com/hook/woof_get_more_less_button_xxxx/') ?></span>
                </div>

                <div class="woof-form-element">
                    <input type="text" class="woof_popup_option regular-text code" data-option="not_toggled_terms_count" placeholder="<?php esc_html_e('leave it empty to show all terms', 'woocommerce-products-filter') ?>" value="0" />
                </div>

            </div>

        </div>

        <div class="woof_option_container woof_option_all">

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Taxonomy custom label', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('For example you want to show title of Product Categories as "My Products". Just for your convenience.', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">
                    <input type="text" class="woof_popup_option regular-text code" data-option="custom_tax_label" placeholder="<?php esc_html_e('leave it empty to use native taxonomy name', 'woocommerce-products-filter') ?>" value="0" />
                </div>

            </div>

        </div>

        <div class="woof_option_container woof_option_radio woof_option_checkbox woof_option_label">

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Max height of the block', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('Container max-height (px). 0 means no max-height.', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">
                    <input type="text" class="woof_popup_option regular-text code" data-option="tax_block_height" placeholder="<?php esc_html_e('Max height of  the block', 'woocommerce-products-filter') ?>" value="0" />
                </div>

            </div>

        </div>

        <div class="woof_option_container woof_option_radio woof_option_checkbox">

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Display items in a row', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('Works for radio and checkboxes only. Allows show radio/checkboxes in 1 row!', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">

                    <div class="select-wrap">
                        <select class="woof_popup_option" data-option="dispay_in_row">
                            <option value="0"><?php esc_html_e('No', 'woocommerce-products-filter') ?></option>
                            <option value="1"><?php esc_html_e('Yes', 'woocommerce-products-filter') ?></option>
                        </select>
                    </div>

                </div>

            </div>

        </div>

        <div class="woof_option_container  woof_option_all">

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Sort terms', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('How to sort terms inside of filter block', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">

                    <div class="select-wrap">
                        <select class="woof_popup_option" data-option="orderby">
                            <option value="-1"><?php esc_html_e('Default', 'woocommerce-products-filter') ?></option>
                            <option value="id"><?php esc_html_e('Id', 'woocommerce-products-filter') ?></option>
                            <option value="name"><?php esc_html_e('Title', 'woocommerce-products-filter') ?></option>
                            <option value="numeric"><?php esc_html_e('Numeric.', 'woocommerce-products-filter') ?></option>

                        </select>
                    </div>

                </div>

            </div>

        </div>
        <div class="woof_option_container  woof_option_all">

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Sort terms', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('Direction of terms sorted inside of filter block', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">

                    <div class="select-wrap">
                        <select class="woof_popup_option" data-option="order">
                            <option value="ASC"><?php esc_html_e('ASC', 'woocommerce-products-filter') ?></option>
                            <option value="DESC"><?php esc_html_e('DESC', 'woocommerce-products-filter') ?></option>
                        </select>
                    </div>

                </div>

            </div>

        </div>
        <?php //  woof_option_checkbox woof_option_mselect woof_option_image woof_option_color woof_option_label woof_option_select_radio_check  ?>
        <div class="woof_option_container woof_option_all ">

            <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php esc_html_e('Logic of filtering', 'woocommerce-products-filter') ?></strong>
                    <span><?php esc_html_e('AND or OR: if to select AND and on the site front select 2 terms - will be found products which contains both terms on the same time.', 'woocommerce-products-filter') ?></span>
                    <span><?php esc_html_e('If to select NOT IN will be found items which not has selected terms!! Means vice versa to the the concept of including: excluding', 'woocommerce-products-filter') ?></span>
                </div>
                <div class="woof-form-element">

                    <div class="select-wrap">
                        <select class="woof_popup_option" data-option="comparison_logic">
                            <option value="OR"><?php esc_html_e('OR', 'woocommerce-products-filter') ?></option>
                            <option class="woof_option_checkbox woof_option_mselect woof_option_image woof_option_color woof_option_label woof_option_select_radio_check" value="AND" style="display: none;"><?php esc_html_e('AND', 'woocommerce-products-filter') ?></option>
                            <option value="NOT IN"><?php esc_html_e('NOT IN', 'woocommerce-products-filter') ?></option>
                        </select>
                    </div>

                </div>

            </div>

        </div>
        <!------------- options for extensions ------------------------>

        <?php
        if (!empty(WOOF_EXT::$includes['taxonomy_type_objects'])) {
            foreach (WOOF_EXT::$includes['taxonomy_type_objects'] as $obj) {
                if (!empty($obj->taxonomy_type_additional_options)) {
                    foreach ($obj->taxonomy_type_additional_options as $key => $option) {
                        switch ($option['type']) {
                            case 'select':
                                ?>
                                <div class="woof_option_container woof_option_<?php echo $obj->html_type ?>">

                                    <div class="woof-form-element-container">

                                        <div class="woof-name-description">
                                            <strong><?php echo $option['title'] ?></strong>
                                            <span><?php echo $option['tip'] ?></span>
                                        </div>

                                        <div class="woof-form-element">

                                            <div class="select-wrap">
                                                <select class="woof_popup_option" data-option="<?php echo $key ?>">
                                                    <?php foreach ($option['options'] as $val => $title): ?>
                                                        <option value="<?php echo $val ?>"><?php echo $title ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <?php
                                break;

                            case 'text':
                                ?>
                                <div class="woof_option_container woof_option_<?php echo $obj->html_type ?>">

                                    <div class="woof-form-element-container">

                                        <div class="woof-name-description">
                                            <strong><?php echo $option['title'] ?></strong>
                                            <span><?php echo $option['tip'] ?></span>
                                        </div>

                                        <div class="woof-form-element">
                                            <input type="text" class="woof_popup_option regular-text code" data-option="<?php echo $key ?>" placeholder="<?php echo(isset($option['placeholder']) ? $option['placeholder'] : '') ?>" value="" />
                                        </div>

                                    </div>

                                </div>
                                <?php
                                break;

                            case 'image':
                                ?>
                                <div class="woof_option_container woof_option_<?php echo $obj->html_type ?>">

                                    <div class="woof-form-element-container">

                                        <div class="woof-name-description">
                                            <strong><?php echo $option['title'] ?></strong>
                                            <span><?php echo $option['tip'] ?></span>
                                        </div>

                                        <div class="woof-form-element">
                                            <input type="text" class="woof_popup_option regular-text code" data-option="<?php echo $key ?>" placeholder="<?php echo $option['placeholder'] ?>" value="" />
                                            <a href="#" class="button woof_select_image"><?php esc_html_e('select image', 'woocommerce-products-filter') ?></a>
                                        </div>

                                    </div>

                                </div>
                                <?php
                                break;

                            default:
                                break;
                        }
                    }
                }
            }
        }
        ?>

    </div>

    <div id="woof_ext_tpl" style="display: none;">
        <li class="woof_ext_li is_disabled">

            <table class="woof_width_100p">
                <tbody>
                    <tr>
                        <td class="woof_valign_top">
                            <img alt="ext cover" src="<?php echo WOOF_LINK ?>img/woof_ext_cover.png" width="85">
                        </td>
                        <td><div class="woof_width_5px"></div></td>
                        <td class="woof_fix16">
                            <a href="#" class="woof_ext_remove" data-title="__TITLE__" data-idx="__IDX__" title="<?php esc_html_e('remove extension', 'woocommerce-products-filter') ?>"><img src="<?php echo $this->settings['delete_image'] ?>" alt="<?php esc_html_e('remove extension', 'woocommerce-products-filter') ?>" /></a>
                            <label for="__IDX__">
                                <input type="checkbox" name="__NAME__" value="__IDX__" id="__IDX__">
                                __TITLE__
                            </label><br>
                            <i>ver.:</i> __VERSION__<br><p class="description">__DESCRIPTION__</p>
                        </td>
                    </tr>
                </tbody>
            </table>

        </li>
    </div>

    <div id="woof-modal-content-by_price" style="display: none;">

        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php esc_html_e('Show button', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('Show button for woocommerce filter by price inside woof search form when it is dispayed as woo range-slider', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">

                <?php
                $show_button = array(
                    0 => esc_html__('No', 'woocommerce-products-filter'),
                    1 => esc_html__('Yes', 'woocommerce-products-filter')
                );
                ?>

                <div class="select-wrap">
                    <select class="woof_popup_option" data-option="show_button">
                        <?php foreach ($show_button as $key => $value) : ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

        </div>

        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php esc_html_e('Title text', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('Text before the price filter range slider. Leave it empty if you not need it!', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <input type="text" class="woof_popup_option" data-option="title_text" placeholder="" value="" />
            </div>

        </div>
        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php esc_html_e('Show toggle button', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('Show toggle button near the title on the front above the block of html-items', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <div class="select-wrap">
                    <select class="woof_popup_option" data-option="show_toggle_button">
                        <option value="0"><?php esc_html_e('No', 'woocommerce-products-filter') ?></option>
                        <option value="1"><?php esc_html_e('Yes, show as closed', 'woocommerce-products-filter') ?></option>
                        <option value="2"><?php esc_html_e('Yes, show as opened', 'woocommerce-products-filter') ?></option>
                    </select>
                </div>

            </div>

        </div>
        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php esc_html_e('Tooltip', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('Show tooltip', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">

                <div class="select-wrap">
                    <textarea class="woof_popup_option" data-option="tooltip_text" ></textarea>
                </div>

            </div>

        </div>

        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <h3><?php esc_html_e('Drop-down OR radio', 'woocommerce-products-filter') ?></h3>
                <strong><?php esc_html_e('Drop-down OR radio price filter ranges', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('Ranges for price filter.', 'woocommerce-products-filter') ?></span>
                <span><?php echo esc_html__('Example: 0-50,51-100,101-i. Where "i" is infinity.', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <input type="text" class="woof_popup_option" data-option="ranges" placeholder="" value="" />
            </div>

        </div>

        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php esc_html_e('Drop-down price filter text', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('Drop-down price filter first option text', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <input type="text" class="woof_popup_option" data-option="first_option_text" placeholder="" value="" />
            </div>

        </div>

        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <h3><?php esc_html_e('Ion Range slider', 'woocommerce-products-filter') ?></h3>
                <strong><?php esc_html_e('Step', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('predifined step', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <input type="text" class="woof_popup_option" data-option="ion_slider_step" placeholder="" value="" />
            </div>

        </div>
        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php esc_html_e('Show price text inputs', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('This works with ionSlider only', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <div class="select-wrap">
                    <select class="woof_popup_option" data-option="show_text_input">
                        <option value="0"><?php esc_html_e('No', 'woocommerce-products-filter') ?></option>
                        <option value="1"><?php esc_html_e('Yes', 'woocommerce-products-filter') ?></option>
                    </select>
                </div>

            </div>

        </div>		
        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <h3><?php esc_html_e('Taxes', 'woocommerce-products-filter') ?></h3>
                <strong><?php esc_html_e('Tax', 'woocommerce-products-filter') ?></strong>
                <span><?php esc_html_e('It will be counted in the filter( Only for ion-slider )', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <input type="text" class="woof_popup_option" data-option="price_tax" placeholder="" value="" />
            </div>

        </div>


    </div>



    <div id="woof_buffer" style="display: none;"></div>

    <div id="woof_html_buffer" class="woof_info_popup" style="display: none;"></div>




</div>


<?php if ($this->is_free_ver): ?>
    <hr />


    <table class="woof_width_100p">
        <tr>
            <td class="woof_width_25p">
                <h3 class="woof_tomato"><?php esc_html_e("WOOF FULL VERSION", 'woocommerce-products-filter') ?>:</h3>
                <a href="https://pluginus.net/affiliate/woocommerce-products-filter" target="_blank"><img width="250" src="<?php echo WOOF_LINK ?>img/plugin_options/banners/woof.png" alt="<?php esc_html_e("full version of the plugin", 'woocommerce-products-filter'); ?>" /></a>
            </td>

            <td class="woof_width_25p">
                <h3><?php esc_html_e("WooCommerce Bulk Editor", 'woocommerce-products-filter') ?>:</h3>
                <a href="https://pluginus.net/affiliate/woocommerce-bulk-editor" target="_blank"><img width="250" src="<?php echo WOOF_LINK ?>img/plugin_options/banners/bear.png" alt="<?php esc_html_e("WOOBE", 'woocommerce-products-filter'); ?>" /></a>
            </td>

            <td class="woof_width_25p">
                <h3><?php esc_html_e("WooCommerce Currency Swither", 'woocommerce-products-filter') ?>:</h3>
                <a href="https://pluginus.net/affiliate/woocommerce-currency-switcher" target="_blank"><img width="250" src="<?php echo WOOF_LINK ?>img/plugin_options/banners/woocs.png" alt="<?php esc_html_e("WOOCS", 'woocommerce-products-filter'); ?>" /></a>
            </td>

            <td class="woof_width_25p">
                <h3><?php esc_html_e("WooCommerce Products Tables", 'woocommerce-products-filter') ?>:</h3>
                <a href="https://codecanyon.pluginus.net/item/woot-woocommerce-products-tables/27928580" target="_blank"><img width="250" src="<?php echo WOOF_LINK ?>img/plugin_options/banners/woot.png" alt="<?php esc_html_e("WOOT", 'woocommerce-products-filter'); ?>" /></a>
            </td>
        </tr>

    </table>

<?php endif; ?>

<?php

function woof_print_tax($key, $tax, $woof_settings) {
    global $WOOF;
    ?>
    <li data-key="<?php echo $key ?>" class="woof_options_li">

        <a href="#" class="help_tip woof_drag_and_drope" data-tip="<?php esc_html_e("drag and drope", 'woocommerce-products-filter'); ?>"><img src="<?php echo WOOF_LINK ?>img/move.png" alt="<?php esc_html_e("move", 'woocommerce-products-filter'); ?>" /></a>

        <div class="select-wrap">
            <select name="woof_settings[tax_type][<?php echo $key ?>]" class="woof_select_tax_type">
                <?php foreach ($WOOF->html_types as $type => $type_text) : ?>
                    <option value="<?php echo $type ?>" <?php if (isset($woof_settings['tax_type'][$key])) echo selected($woof_settings['tax_type'][$key], $type) ?>><?php echo $type_text ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <img class="help_tip" data-tip="<?php esc_html_e('View of the taxonomies terms on the front', 'woocommerce-products-filter') ?>" src="<?php echo WP_PLUGIN_URL ?>/woocommerce/assets/images/help.png" height="16" width="16" />

        <?php
        $excluded_terms = '';
        if (isset($woof_settings['excluded_terms'][$key])) {
            $excluded_terms = $woof_settings['excluded_terms'][$key];
        }

        $excluded_terms_reverse = 0;
        if (isset($woof_settings['excluded_terms_reverse'][$key])) {
            $excluded_terms_reverse = $woof_settings['excluded_terms_reverse'][$key];
        }
        ?>

        <input type="text" class="woof_width_350px" name="woof_settings[excluded_terms][<?php echo $key ?>]" placeholder="<?php esc_html_e('excluded terms ids', 'woocommerce-products-filter') ?>" value="<?php echo $excluded_terms ?>" />

        <input <?php echo(((isset($WOOF->settings['excluded_terms_reverse']) ? is_array($WOOF->settings['excluded_terms_reverse']) : FALSE) ? in_array($key, (array) array_keys($WOOF->settings['excluded_terms_reverse'])) : false) ? 'checked="checked"' : '') ?> type="checkbox" name="woof_settings[excluded_terms_reverse][<?php echo $key ?>]" value="1" />
        <label class="woof_fix17"><?php esc_html_e('Reverse', 'woocommerce-products-filter') ?></label>


        <img class="help_tip" data-tip="<?php esc_html_e('If you want to exclude some current taxonomies terms from the search form! Use Reverse if you want include only instead of exclude! Example: 11,23,77', 'woocommerce-products-filter') ?>" src="<?php echo WP_PLUGIN_URL ?>/woocommerce/assets/images/help.png" height="16" width="16" />
        <input type="button" value="<?php esc_html_e('additional options', 'woocommerce-products-filter') ?>" data-taxonomy="<?php echo $key ?>" data-taxonomy-name="<?php echo $tax->labels->name ?>" class="woof-button js_woof_add_options" />

        <div style="display: none;">
            <?php
            $max_height = 0;
            if (isset($woof_settings['tax_block_height'][$key])) {
                $max_height = $woof_settings['tax_block_height'][$key];
            }
            ?>
            <input type="text" name="woof_settings[tax_block_height][<?php echo $key ?>]" placeholder="" value="<?php echo $max_height ?>" />
            <?php
            $show_title_label = 0;
            if (isset($woof_settings['show_title_label'][$key])) {
                $show_title_label = $woof_settings['show_title_label'][$key];
            }
            ?>
            <input type="text" name="woof_settings[show_title_label][<?php echo $key ?>]" placeholder="" value="<?php echo $show_title_label ?>" />


            <?php
            $show_toggle_button = 0;
            if (isset($woof_settings['show_toggle_button'][$key])) {
                $show_toggle_button = $woof_settings['show_toggle_button'][$key];
            }
            ?>
            <input type="text" name="woof_settings[show_toggle_button][<?php echo $key ?>]" placeholder="" value="<?php echo $show_toggle_button ?>" />


            <?php
            $tooltip_text = "";
            if (isset($woof_settings['tooltip_text'][$key])) {
                $tooltip_text = stripcslashes($woof_settings['tooltip_text'][$key]);
            }
            ?>
            <input type="text" name="woof_settings[tooltip_text][<?php echo $key ?>]" placeholder="" value="<?php echo $tooltip_text ?>" />

            <?php
            $dispay_in_row = 0;
            if (isset($woof_settings['dispay_in_row'][$key])) {
                $dispay_in_row = $woof_settings['dispay_in_row'][$key];
            }
            ?>
            <input type="text" name="woof_settings[dispay_in_row][<?php echo $key ?>]" placeholder="" value="<?php echo $dispay_in_row ?>" />


            <?php
            $orderby = '-1';
            if (isset($woof_settings['orderby'][$key])) {
                $orderby = $woof_settings['orderby'][$key];
            }
            ?>
            <input type="text" name="woof_settings[orderby][<?php echo $key ?>]" placeholder="" value="<?php echo $orderby ?>" />

            <?php
            $order = 'ASC';
            if (isset($woof_settings['order'][$key])) {
                $order = $woof_settings['order'][$key];
            }
            ?>
            <input type="text" name="woof_settings[order][<?php echo $key ?>]" placeholder="" value="<?php echo $order ?>" />
            <?php
            $comparison_logic = 'OR';
            $logic_restriction = array('checkbox', 'mselect', 'label', 'color', 'image', 'slider', 'select_hierarchy');
            if (isset($woof_settings['comparison_logic'][$key])) {
                $comparison_logic = $woof_settings['comparison_logic'][$key];
            }
            if (isset($woof_settings['tax_type'][$key]) AND!in_array($woof_settings['tax_type'][$key], $logic_restriction) AND $comparison_logic == 'AND') {
                $comparison_logic = 'OR';
            }

            if ($comparison_logic == 'NOT IN' AND $woof_settings['tax_type'][$key] == 'select_hierarchy') {
                $comparison_logic = 'OR';
            }
            ?>
            <input type="text" name="woof_settings[comparison_logic][<?php echo $key ?>]" placeholder="" value="<?php echo $comparison_logic ?>" />

            <?php
            $custom_tax_label = '';
            if (isset($woof_settings['custom_tax_label'][$key])) {
                $custom_tax_label = stripcslashes($woof_settings['custom_tax_label'][$key]);
            }
            ?>
            <input type="text" name="woof_settings[custom_tax_label][<?php echo $key ?>]" placeholder="" value="<?php echo $custom_tax_label ?>" />


            <?php
            $not_toggled_terms_count = '';
            if (isset($woof_settings['not_toggled_terms_count'][$key])) {
                $not_toggled_terms_count = $woof_settings['not_toggled_terms_count'][$key];
            }
            ?>
            <input type="text" name="woof_settings[not_toggled_terms_count][<?php echo $key ?>]" placeholder="" value="<?php echo $not_toggled_terms_count ?>" />


            <!------------- options for extensions ------------------------>
            <?php
            if (!empty(WOOF_EXT::$includes['taxonomy_type_objects'])) {
                foreach (WOOF_EXT::$includes['taxonomy_type_objects'] as $obj) {
                    if (!empty($obj->taxonomy_type_additional_options)) {
                        foreach ($obj->taxonomy_type_additional_options as $option_key => $option) {
                            $option_val = 0;
                            if (isset($woof_settings[$option_key][$key])) {
                                $option_val = $woof_settings[$option_key][$key];
                            }
                            ?>
                            <input type="text" name="woof_settings[<?php echo $option_key ?>][<?php echo $key ?>]" value="<?php echo $option_val ?>" />
                            <?php
                        }
                    }
                }
            }
            ?>




        </div>



        <input <?php echo(((isset($WOOF->settings['tax']) ? is_array($WOOF->settings['tax']) : FALSE) ? in_array($key, (array) array_keys($WOOF->settings['tax'])) : false) ? 'checked="checked"' : '') ?> type="checkbox" name="woof_settings[tax][<?php echo $key ?>]" id="tax_<?php echo md5($key) ?>" value="1" />
        <label for="tax_<?php echo md5($key) ?>"><b><?php echo $tax->labels->name ?></b></label>
        <?php
        if (isset($woof_settings['tax_type'][$key])) {
            do_action('woof_print_tax_additional_options_' . $woof_settings['tax_type'][$key], $key);
        }
        ?>
    </li>
    <?php
}

//***

function woof_print_item_by_key($key, $woof_settings) {

    switch ($key) {
        case 'by_price':

            if (!isset($woof_settings[$key])) {
                $woof_settings[$key] = [];
            }

            if (!is_array($woof_settings)) {
                break;
            }
            ?>
            <li data-key="<?php echo $key ?>" class="woof_options_li">

                <?php
                $show = 0;
                if (isset($woof_settings[$key]['show'])) {
                    $show = $woof_settings[$key]['show'];
                }
                ?>

                <a href="#" class="help_tip woof_drag_and_drope" data-tip="<?php esc_html_e("drag and drope", 'woocommerce-products-filter'); ?>"><img src="<?php echo WOOF_LINK ?>img/move.png" alt="<?php esc_html_e("move", 'woocommerce-products-filter'); ?>" /></a>

                <strong class="woof_fix1"><?php esc_html_e("Search by Price", 'woocommerce-products-filter'); ?>:</strong>

                <img class="help_tip" data-tip="<?php esc_html_e('Show woocommerce filter by price inside woof search form', 'woocommerce-products-filter') ?>" src="<?php echo WP_PLUGIN_URL ?>/woocommerce/assets/images/help.png" height="16" width="16" />

                <div class="select-wrap">
                    <select name="woof_settings[<?php echo $key ?>][show]" class="woof_setting_select">
                        <option value="0" <?php echo selected($show, 0) ?>><?php esc_html_e('No', 'woocommerce-products-filter') ?></option>
                        <option value="1" <?php echo selected($show, 1) ?>><?php esc_html_e('As woo range-slider', 'woocommerce-products-filter') ?></option>
                        <option value="2" <?php echo selected($show, 2) ?>><?php esc_html_e('As drop-down', 'woocommerce-products-filter') ?></option>
                        <option value="5" <?php echo selected($show, 5) ?>><?php esc_html_e('As radio button', 'woocommerce-products-filter') ?></option>
                        <option value="4" <?php echo selected($show, 4) ?>><?php esc_html_e('As textinputs', 'woocommerce-products-filter') ?></option>
                        <option value="3" <?php echo selected($show, 3) ?>><?php esc_html_e('As ion range-slider', 'woocommerce-products-filter') ?></option>

                    </select>
                </div>

                <input type="button" value="<?php esc_html_e('additional options', 'woocommerce-products-filter') ?>" data-key="<?php echo $key ?>" data-name="<?php esc_html_e("Search by Price", 'woocommerce-products-filter'); ?>" class="woof-button js_woof_options js_woof_options_<?php echo $key ?>" />

                <?php
                if (!isset($woof_settings[$key]['show_button'])) {
                    $woof_settings[$key]['show_button'] = 0;
                }

                if (!isset($woof_settings[$key]['title_text'])) {
                    $woof_settings[$key]['title_text'] = '';
                }

                if (!isset($woof_settings[$key]['show_toggle_button'])) {
                    $woof_settings[$key]['show_toggle_button'] = 0;
                }
                if (!isset($woof_settings[$key]['ranges'])) {
                    $woof_settings[$key]['ranges'] = '';
                }

                if (!isset($woof_settings[$key]['first_option_text'])) {
                    $woof_settings[$key]['first_option_text'] = '';
                }

                if (!isset($woof_settings[$key]['ion_slider_step'])) {
                    $woof_settings[$key]['ion_slider_step'] = 0;
                }
                if (!isset($woof_settings[$key]['price_tax'])) {
                    $woof_settings[$key]['price_tax'] = 0;
                }
                if (!isset($woof_settings[$key]['show_text_input'])) {
                    $woof_settings[$key]['show_text_input'] = 0;
                }

                if (!isset($woof_settings[$key]['tooltip_text'])) {
                    $woof_settings[$key]['tooltip_text'] = "";
                }
                ?>
                <input type="hidden" name="woof_settings[<?php echo $key ?>][tooltip_text]" placeholder="" value="<?php echo stripcslashes($woof_settings[$key]['tooltip_text']) ?>" />
                <input type="hidden" name="woof_settings[<?php echo $key ?>][show_button]" value="<?php echo $woof_settings[$key]['show_button'] ?>" />
                <input type="hidden" name="woof_settings[<?php echo $key ?>][title_text]" value="<?php echo $woof_settings[$key]['title_text'] ?>" />
                <input type="hidden" name="woof_settings[<?php echo $key ?>][show_toggle_button]" value="<?php echo $woof_settings[$key]['show_toggle_button'] ?>" />
                <input type="hidden" name="woof_settings[<?php echo $key ?>][ranges]" value="<?php echo $woof_settings[$key]['ranges'] ?>" />
                <input type="hidden" name="woof_settings[<?php echo $key ?>][first_option_text]" value="<?php echo $woof_settings[$key]['first_option_text'] ?>" />
                <input type="hidden" name="woof_settings[<?php echo $key ?>][ion_slider_step]" value="<?php echo $woof_settings[$key]['ion_slider_step'] ?>" />
                <input type="hidden" name="woof_settings[<?php echo $key ?>][price_tax]" value="<?php echo $woof_settings[$key]['price_tax'] ?>" />
                <input type="hidden" name="woof_settings[<?php echo $key ?>][show_text_input]" value="<?php echo $woof_settings[$key]['show_text_input'] ?>" />
            </li>
            <?php
            break;

        default:
            //options for extensions

            do_action('woof_print_html_type_options_' . $key);
            break;
    }
}
