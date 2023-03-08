<?php
/** nicetheme: +1s **/
if (!defined('ABSPATH')) {
    exit;
}

    global $wpdb;

    $down_box_hide = get_field( 'down_box_hide' )?: array();

/*$content .= in_array('true', $down_box_hide) ? 'd-xl-inline-block ' : 'd-xl-none ';

return $content;*/

    if (!in_array('true', $down_box_hide)) {

        $erphp_post_types = get_option('erphp_post_types');

        if (is_singular() && in_array(get_post_type(), $erphp_post_types)) {

            $content2 = $content;

            $erphp_see2_style = get_option('erphp_see2_style');
            $erphp_life_name = get_option('erphp_life_name') ? get_option('erphp_life_name') : '终身VIP';
            $erphp_year_name = get_option('erphp_year_name') ? get_option('erphp_year_name') : '包年VIP';
            $erphp_quarter_name = get_option('erphp_quarter_name') ? get_option('erphp_quarter_name') : '包季VIP';
            $erphp_month_name = get_option('erphp_month_name') ? get_option('erphp_month_name') : '包月VIP';
            $erphp_day_name = get_option('erphp_day_name') ? get_option('erphp_day_name') : '体验VIP';
            $erphp_vip_name = get_option('erphp_vip_name') ? get_option('erphp_vip_name') : 'VIP';

            $erphp_down = get_field('erphp_down');

            /*$start_down = get_post_meta(get_the_ID(), 'start_down', true);*/
            $start_down = ($erphp_down == 1) ? true : false;
            $start_down2 = ($erphp_down == 5) ? true : false;
            $start_see = ($erphp_down == 2) ? true : false;
            $start_see2 = ($erphp_down == 3) ? true : false;

            $days = get_field('down_days');
            $price = get_field('down_price');
            $price_type = get_field('down_price_type');



            $url = get_field('down_url');
            $urls = get_field( 'down_urls' );
            /*            $urls = get_post_meta(get_the_ID(), 'down_urls', true);*/
            $url_free = get_field( 'down_url_free' );
            $memberDown = get_field( 'member_down' );

            $hidden = get_field( 'hidden_content' );

            $userType = getUsreMemberType();
            $down_info = null;
            $downMsgFree = '';
            $down_checkpan = '';
            $yituan = '';
            $down_tuan = 0;
            $erphp_popdown = '';
            $iframe = '';
            $down_repeat = 0;
            $down_info_repeat = null;

            if (function_exists('erphpdown_tuan_install')) {
                $down_tuan = get_post_meta(get_the_ID(), 'down_tuan', true);
            }

            $down_repeat = get_post_meta(get_the_ID(), 'down_repeat', true);

            $erphp_url_front_vip = get_bloginfo('wpurl') . '/wp-admin/admin.php?page=erphpdown/admin/erphp-update-vip.php';
            if (get_option('erphp_url_front_vip')) {
                $erphp_url_front_vip = get_option('erphp_url_front_vip');
            }
            $erphp_url_front_login = wp_login_url();
            if (get_option('erphp_url_front_login')) {
                $erphp_url_front_login = get_option('erphp_url_front_login');
            }

            if (get_option('erphp_popdown')) {
                $erphp_popdown = ' erphpdown-down-layui';
                $iframe = '&iframe=1';
            }

            if (is_user_logged_in()) {
                $erphp_url_front_vip2 = $erphp_url_front_vip;
            } else {
                $erphp_url_front_vip2 = $erphp_url_front_login;
            }

            $erphp_blank_domains = get_option('erphp_blank_domains') ? get_option('erphp_blank_domains') : 'pan.baidu.com';
            $erphp_colon_domains = get_option('erphp_colon_domains') ? get_option('erphp_colon_domains') : 'pan.baidu.com';

            if ($down_tuan && is_user_logged_in()) {
                global $current_user;
                $yituan = $wpdb->get_var("select ice_status from $wpdb->tuanorder where ice_user_id=" . $current_user->ID . " and ice_post=" . get_the_ID() . " and ice_status>0");
            }

            if ($url_free) {
                $downMsgFree .= '<div class="h4 mb-3">免费资源</div><div class="erphpdown-free">';
                $downList = explode("\r\n", $url_free);
                foreach ($downList as $k => $v) {
                    $filepath = $downList[$k];
                    if ($filepath) {

                        if ($erphp_colon_domains) {
                            $erphp_colon_domains_arr = explode(',', $erphp_colon_domains);
                            foreach ($erphp_colon_domains_arr as $erphp_colon_domain) {
                                if (strpos($filepath, $erphp_colon_domain)) {
                                    $filepath = str_replace('：', ': ', $filepath);
                                    break;
                                }
                            }
                        }

                        $erphp_blank_domain_is = 0;
                        if ($erphp_blank_domains) {
                            $erphp_blank_domains_arr = explode(',', $erphp_blank_domains);
                            foreach ($erphp_blank_domains_arr as $erphp_blank_domain) {
                                if (strpos($filepath, $erphp_blank_domain)) {
                                    $erphp_blank_domain_is = 1;
                                    break;
                                }
                            }
                        }
                        $downMsgFree .= '<div id="download-block_63eb4f17be4f6" class="nice-block-download border border-light rounded-md p-4 my-3 my-md-4">
						<div class="block-download-inner d-flex flex-fill">
						  <div class="block-download-icon flex-shrink-0 me-3 me-lg-4 mr-3 mr-lg-4">
							<div class="btn btn-primary btn-icon btn-lg btn-rounded-md">
							  <span>
								<i class="svg-blocks svg-baidu-line"></i>
							  </span>
							</div>
						  </div>
						  <div class="block-download-body flex-fill">
							<div class="block-download-content d-md-flex align-items-md-center flex-md-fill">';
                        $MsgFreeTitle = '';
                        if (strpos($filepath, ',')) {
                            $filearr = explode(',', $filepath);
                            $arrlength = count($filearr);
                            if ($arrlength == 1) {
                                $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>文件" . ($k + 1) . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . $filepath . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                                $MsgFreeTitle = '';
                            } elseif ($arrlength == 2) {
                                $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>" . $filearr[0] . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . $filearr[1] . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                                $MsgFreeTitle = '';
                            } elseif ($arrlength == 3) {
                                $filearr2 = str_replace('：', ': ', $filearr[2]);
                                $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>" . $filearr[0] . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . $filearr[1] . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                                $MsgFreeTitle = '<span class="text-muted">' . $filearr2 . '</span><a class="erphpdown-copy" data-clipboard-text="' . str_replace('提取码: ', '', $filearr2) . '" href="javascript:;">复制</a>';
                            }
                        } elseif (strpos($filepath, '  ') && $erphp_blank_domain_is) {
                            $filearr = explode('  ', $filepath);
                            $arrlength = count($filearr);
                            if ($arrlength == 1) {
                                $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>文件" . ($k + 1) . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . $filepath . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                                $MsgFreeTitle = '';
                            } elseif ($arrlength >= 2) {
                                $filearr2 = explode(':', $filearr[0]);
                                $filearr3 = explode(':', $filearr[1]);
                                $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>" . $filearr2[0] . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . trim($filearr2[1] . ':' . $filearr2[2]) . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                                $MsgFreeTitle = '<span class="text-muted">提取码: </span><span class="font-theme">' . trim($filearr3[1]) . '</span><a class="erphpdown-copy" data-clipboard-text="' . trim($filearr3[1]) . '" href="javascript:;">复制</a>';
                            }
                        } elseif (strpos($filepath, ' ') && $erphp_blank_domain_is) {
                            $filearr = explode(' ', $filepath);
                            $arrlength = count($filearr);
                            if ($arrlength == 1) {
                                $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>文件" . ($k + 1) . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . $filepath . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                                $MsgFreeTitle = '';
                            } elseif ($arrlength == 2) {
                                $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>" . $filearr[0] . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . $filearr[1] . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                                $MsgFreeTitle = '';
                            } elseif ($arrlength >= 3) {
                                $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>" . str_replace(':', '', $filearr[0]) . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . $filearr[1] . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                                $MsgFreeTitle = '<span class="text-muted">' . $filearr[2] . '</span><span class="font-theme">' . $filearr[3] . '</span><a class="erphpdown-copy" data-clipboard-text="' . $filearr[3] . '" href="javascript:;">复制</a>';

                            }
                        } else {
                            $downMsgFree .= "<div class='flex-fill h5 mr-0 mr-md-4 me-0 me-md-4 mb-0'>文件" . ($k + 1) . "</div><div class='flex-shrink-0 mt-3 mt-md-0'><a href='" . $filepath . "' rel='nofollow' target='_blank' class='btn btn-dark btn-sm btn-w-md btn-rounded'>下载</a></div>";
                        }
                        $downMsgFree .= '</div><div class="block-download-desc text-secondary text-sm mt-3"> 描述 </div>
						<div class="block-download-data text-sm border-top border-light pt-3 mt-3">
						  <span class="item-download-data d-inline-block me-2 me-md-4 mr-2 mr-md-4">
							<span class="text-muted">类型：</span>
							<span class="">文件类型</span>
						  </span>
						  <span class="item-download-data d-inline-block me-2 me-md-4 mr-2 mr-md-4">
							<span class="text-muted">大小：</span>
							<span class="font-theme">15MB</span>
						  </span>
						  <span class="item-download-data d-inline-block">
							' . $MsgFreeTitle . '
						  </span>
						</div>
					  </div>
					</div>
				  </div>';
                    }
                }

                $downMsgFree .= '</div>

					';
                if (get_option('ice_tips_free')) $downMsgFree .= '<div class="timer" data-countdown="">
				<div class="timer-in">
				  <div class="timer-title">' . get_option('ice_tips_free') . '</div>
				  <div class="timer-time" data-countdown-time="3600">
					<div class="timer-item"><span data-countdown-hours="">0</span>h</div>
					<div class="timer-item"><span data-countdown-minutes="">59</span>米</div>
					<div class="timer-item"><span data-countdown-seconds="">48</span>s</div>
				  </div>
				</div>
			  </div>';
                if ($start_down2 || $start_down) {
                    /*$downMsgFree .= '<div class="h4 mb-3">付费资源</div>';*/
                    /*$downMsgFree .= '<div class="h4 mb-3">请选择版本：</div>';*/
                }
            }

            if ($start_down2) {
                $downMsg = '';
                if ($url) {
                    if (function_exists('epd_check_pan_callback')) {
                        if (strpos($url, 'pan.baidu.com') !== false || (strpos($url, 'lanzou') !== false && strpos($url, '.com') !== false) || strpos($url, 'cloud.189.cn') !== false) {
                            $down_checkpan = '<a class="erphpdown-buy erphpdown-checkpan2" href="javascript:;" data-id="' . get_the_ID() . '" data-post="' . get_the_ID() . '">点击检测网盘有效后购买</a>';
                        }
                    }

                    $content .= '<fieldset class="erphpdown erphpdown-default" id="erphpdown"><legend>资源下载</legend>' . $downMsgFree;

                    $user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
                    $wppay = new EPD(get_the_ID(), $user_id);

                    if ($wppay->isWppayPaid() || $wppay->isWppayPaidNew() || !$price || ($memberDown == 3 && $userType) || ($memberDown == 16 && $userType >= 8) || ($memberDown == 6 && $userType >= 9) || ($memberDown == 7 && $userType >= 10)) {
                        $downList = explode("\r\n", trim($url));
                        foreach ($downList as $k => $v) {
                            $filepath = trim($downList[$k]);
                            if ($filepath) {

                                if ($erphp_colon_domains) {
                                    $erphp_colon_domains_arr = explode(',', $erphp_colon_domains);
                                    foreach ($erphp_colon_domains_arr as $erphp_colon_domain) {
                                        if (strpos($filepath, $erphp_colon_domain)) {
                                            $filepath = str_replace('：', ': ', $filepath);
                                            break;
                                        }
                                    }
                                }

                                $erphp_blank_domain_is = 0;
                                if ($erphp_blank_domains) {
                                    $erphp_blank_domains_arr = explode(',', $erphp_blank_domains);
                                    foreach ($erphp_blank_domains_arr as $erphp_blank_domain) {
                                        if (strpos($filepath, $erphp_blank_domain)) {
                                            $erphp_blank_domain_is = 1;
                                            break;
                                        }
                                    }
                                }

                                if (strpos($filepath, ',')) {
                                    $filearr = explode(',', $filepath);
                                    $arrlength = count($filearr);
                                    if ($arrlength == 1) {
                                        $downMsg .= "<div class='erphpdown-item'>文件" . ($k + 1) . "地址<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a></div>";
                                    } elseif ($arrlength == 2) {
                                        $downMsg .= "<div class='erphpdown-item'>" . $filearr[0] . "<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a></div>";
                                    } elseif ($arrlength == 3) {
                                        $filearr2 = str_replace('：', ': ', $filearr[2]);
                                        $downMsg .= "<div class='erphpdown-item'>" . $filearr[0] . "<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a>（" . $filearr2 . "）<a class='erphpdown-copy' data-clipboard-text='" . str_replace('提取码: ', '', $filearr2) . "' href='javascript:;'>复制</a></div>";
                                    }
                                } elseif (strpos($filepath, '  ') && $erphp_blank_domain_is) {
                                    $filearr = explode('  ', $filepath);
                                    $arrlength = count($filearr);
                                    if ($arrlength == 1) {
                                        $downMsg .= "<div class='erphpdown-item'>文件" . ($k + 1) . "地址<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a></div>";
                                    } elseif ($arrlength >= 2) {
                                        $filearr2 = explode(':', $filearr[0]);
                                        $filearr3 = explode(':', $filearr[1]);
                                        $downMsg .= "<div class='erphpdown-item'>" . $filearr2[0] . "<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a>（提取码: " . trim($filearr3[1]) . "）<a class='erphpdown-copy' data-clipboard-text='" . trim($filearr3[1]) . "' href='javascript:;'>复制</a></div>";
                                    }
                                } elseif (strpos($filepath, ' ') && $erphp_blank_domain_is) {
                                    $filearr = explode(' ', $filepath);
                                    $arrlength = count($filearr);
                                    if ($arrlength == 1) {
                                        $downMsg .= "<div class='erphpdown-item'>文件" . ($k + 1) . "地址<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a></div>";
                                    } elseif ($arrlength == 2) {
                                        $downMsg .= "<div class='erphpdown-item'>" . $filearr[0] . "<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a></div>";
                                    } elseif ($arrlength >= 3) {
                                        $downMsg .= "<div class='erphpdown-item'>" . str_replace(':', '', $filearr[0]) . "<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a>（" . $filearr[2] . ' ' . $filearr[3] . "）<a class='erphpdown-copy' data-clipboard-text='" . $filearr[3] . "' href='javascript:;'>复制</a></div>";
                                    }
                                } else {
                                    $downMsg .= "<div class='erphpdown-item'>文件" . ($k + 1) . "地址<a href='" . ERPHPDOWN_URL . "/download.php?postid=" . get_the_ID() . "&key=" . ($k + 1) . "&nologin=1' target='_blank' class='erphpdown-down'>点击下载</a></div>";
                                }
                            }
                        }
                        $content .= $downMsg;
                        if ($hidden) {
                            $content .= '<div class="erphpdown-item">提取码：' . $hidden . ' <a class="erphpdown-copy" data-clipboard-text="' . $hidden . '" href="javascript:;">复制</a></div>';
                        }
                    } else {
                        if ($url) {
                            $tname = '资源下载';
                        } else {
                            $tname = '内容查看';
                        }
                        if ($memberDown == 3 || $memberDown == 16 || $memberDown == 6 || $memberDown == 7) {
                            $wppay_vip_name = $erphp_vip_name;
                            if ($memberDown == 16) {
                                $wppay_vip_name = $erphp_quarter_name;
                            } elseif ($memberDown == 6) {
                                $wppay_vip_name = $erphp_year_name;
                            } elseif ($memberDown == 7) {
                                $wppay_vip_name = $erphp_life_name;
                            }

                            if ($down_checkpan) $content .= $tname . '价格<span class="erphpdown-price">' . $price . '</span>元' . $down_checkpan . '&nbsp;&nbsp;<b>或</b>&nbsp;&nbsp;升级' . $wppay_vip_name . '后免费<a href="' . $erphp_url_front_vip2 . '" target="_blank" class="erphpdown-vip' . (is_user_logged_in() ? '' : ' erphp-login-must') . '">升级' . $wppay_vip_name . '</a>';
                            else $content .= $tname . '价格<span class="erphpdown-price">' . $price . '</span>元<a href="javascript:;" class="erphp-wppay-loader erphpdown-buy" data-post="' . get_the_ID() . '">立即购买</a>&nbsp;&nbsp;<b>或</b>&nbsp;&nbsp;升级' . $wppay_vip_name . '后免费<a href="' . $erphp_url_front_vip2 . '" target="_blank" class="erphpdown-vip' . (is_user_logged_in() ? '' : ' erphp-login-must') . '">升级' . $wppay_vip_name . '</a>';
                        } else {
                            if ($down_checkpan) $content .= $tname . '价格<span class="erphpdown-price">' . $price . '</span>元' . $down_checkpan;
                            else $content .= $tname . '价格<span class="erphpdown-price">' . $price . '</span>元<a href="javascript:;" class="erphp-wppay-loader erphpdown-buy" data-post="' . get_the_ID() . '">立即购买</a>';
                        }
                    }

                    if (get_option('ice_tips')) $content .= '<div class="erphpdown-tips">' . get_option('ice_tips') . '</div>';
                    $content .= '</fieldset>';
                }

            } elseif ($start_down) {

                $tuanHtml = '';
                $content .= '<div class="h3 mx-1 mt-5 mb-2 mb-md-3">软件下载</div><div class="card card-md">
				<div class="card-body"><!--<div class="h4 mb-3">请选择版本：</div>--><div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-4 g-md-4">';
                if ($down_tuan == '2' && function_exists('erphpdown_tuan_install')) {
                    $tuanHtml = erphpdown_tuan_html();
                    $content .= $tuanHtml;
                } else {
                    if ($price_type) {

                        if ($urls) {

                            $cnt = count($urls);
                            if ($cnt) {
                                for ($i = 0; $i < $cnt; $i++) {
                                    $index = $urls[$i]['index'];
                                    $index_name = $urls[$i]['name'];
                                    $price = $urls[$i]['price'];
                                    $index_url = $urls[$i]['url'];
                                    $index_vip = $urls[$i]['vip'];

                                    $indexMemberDown = $memberDown;
                                    if ($index_vip) {
                                        $indexMemberDown = $index_vip;
                                    }

                                    $product_tag = '';
                                    $product_name = '';
                                    $product_ver = '';
                                    $product_desc = '';
                                    $alt_name = '';

                                    $fields = explode('-', $index_name);

                                    if (count($fields) == 4) {
                                        $product_info = [
                                            'tag' => $fields[0],
                                            'name' => $fields[1],
                                            'version' => $fields[2],
                                            'desc' => $fields[3]
                                        ];


                                        if (!empty($product_info['tag'])) {
                                            $product_tag = '<span class="product-image-label">' . $product_info['tag'] . '</span>';
                                        }
                                        if (!empty($product_info['version'])) {
                                            $product_ver = $product_info['version'];
                                        }
                                        if (!empty($product_info['name'])) {
                                            $product_name = '<div class="product-item-name h4 mb-2">' . $product_info['name'] . '<span class="font-number ms-2">' . $product_ver . '</span></div>';
                                            $alt_name = $product_info['name'];
                                        }
                                        if (!empty($product_info['desc'])) {
                                            $product_desc = '<div class="product-item-description text-secondary">' . $product_info['desc'] . '</div>';
                                        }

                                    } else {
                                        $product_name = '<div class="product-item-name h4 mb-2">' . $index_name . '</div>';
                                        $alt_name = $index_name;
                                    }

                                    $content .= '<div class="col d-flex">
    <div class="product-item flex-fill" data-checkout-type-trigger="subscription">
        <div class="product-image">
            <img src="https://cdn2.macpaw.com/images/ec1c2519a9f7f02df7b657eb7aed9397.png" alt="' . $alt_name . '">
            ' . $product_tag . '
        </div>
        ' . $product_name . '
        ' . $product_desc . '
';


                                    $down_checkpan = '';
                                    if (function_exists('epd_check_pan_callback')) {
                                        if (strpos($index_url, 'pan.baidu.com') !== false || (strpos($index_url, 'lanzou') !== false && strpos($index_url, '.com') !== false) || strpos($index_url, 'cloud.189.cn') !== false) {
                                            $down_checkpan = '<a class="erphpdown-buy erphpdown-checkpan" href="javascript:;" data-id="' . get_the_ID() . '" data-index="' . $index . '" data-buy="' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '&index=' . $index . '">点击检测网盘有效后购买</a>';
                                        }
                                    }

                                    if (is_user_logged_in()) {
                                        if ($price) {
                                            if ($indexMemberDown != 4 && $indexMemberDown != 15 && $indexMemberDown != 8 && $indexMemberDown != 9)
                                                $content .= '<div class="product-item-price-wrapper d-none"><div class="product-item-price" data-price=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div><div class="product-item-price-full" data-price-full=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div></div>';
                                        } else {
                                            if ($indexMemberDown != 4 && $indexMemberDown != 15 && $indexMemberDown != 8 && $indexMemberDown != 9)
                                                $content .= '此资源为免费资源';
                                        }

                                        if ($price || $indexMemberDown == 4 || $indexMemberDown == 15 || $indexMemberDown == 8 || $indexMemberDown == 9) {
                                            $user_info = wp_get_current_user();
                                            $down_info = $wpdb->get_row("select * from " . $wpdb->icealipay . " where ice_post='" . get_the_ID() . "' and ice_index='" . $index . "' and ice_success=1 and ice_user_id=" . $user_info->ID . " order by ice_time desc");
                                            if ($days > 0 && $down_info) {
                                                $lastDownDate = date('Y-m-d H:i:s', strtotime('+' . $days . ' day', strtotime($down_info->ice_time)));
                                                $nowDate = date('Y-m-d H:i:s');
                                                if (strtotime($nowDate) > strtotime($lastDownDate)) {
                                                    $down_info = null;
                                                }
                                            }

                                            if ($down_repeat) {
                                                $down_info_repeat = $down_info;
                                                $down_info = null;
                                            }

                                            $buyText = '立即购买';
                                            if ($down_repeat && $down_info_repeat && !$down_info) {
                                                $buyText = '再次购买';
                                            }

                                            if (($userType && ($indexMemberDown == 3 || $indexMemberDown == 4)) || $down_info || (($indexMemberDown == 15 || $indexMemberDown == 16) && $userType >= 8) || (($indexMemberDown == 6 || $indexMemberDown == 8) && $userType >= 9) || (($indexMemberDown == 7 || $indexMemberDown == 9 || $indexMemberDown == 13 || $indexMemberDown == 14) && $userType == 10) || (!$price && $indexMemberDown != 4 && $indexMemberDown != 15 && $indexMemberDown != 8 && $indexMemberDown != 9)) {

                                                if ($indexMemberDown == 3) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . '免费）</div>';
                                                } elseif ($indexMemberDown == 2) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . ' 5折）</div>';
                                                } elseif ($indexMemberDown == 13) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费）</div>';
                                                } elseif ($indexMemberDown == 5) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . ' 899折）</div>';
                                                } elseif ($indexMemberDown == 14) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . ' 866折、' . $erphp_life_name . '免费）</div>';
                                                } elseif ($indexMemberDown == 16) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_quarter_name . '免费）</div>';
                                                } elseif ($indexMemberDown == 6) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_year_name . '免费）</div>';
                                                } elseif ($indexMemberDown == 7) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_life_name . '免费）</div>';
                                                } elseif ($indexMemberDown == 4) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_vip_name . '下载）</div>';
                                                } elseif ($indexMemberDown == 15) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_quarter_name . '下载）</div>';
                                                } elseif ($indexMemberDown == 8) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_year_name . '下载）</div>';
                                                } elseif ($indexMemberDown == 9) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_life_name . '下载）</div>';
                                                } elseif ($indexMemberDown == 10) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买）</div>';
                                                } elseif ($indexMemberDown == 11) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折）</div>';
                                                } elseif ($indexMemberDown == 12) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 899折）</div>';
                                                }

                                                $content .= "<input type='hidden' name='erphpdown-down' data-class=" . $erphp_popdown . " data-title='立即下载' data-url='" . constant("erphpdown") . 'download.php?postid=' . get_the_ID() . "&index=" . $index . $iframe . "' data-target='_blank'>";
                                            } else {


                                                $vipText = '<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                if ($userType) {
                                                    $vipText = '';
                                                    if (($indexMemberDown == 13 || $indexMemberDown == 14) && $userType < 10) {
                                                        $vipText = '<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_life_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                    }
                                                }

                                                if ($indexMemberDown == 3) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . '免费）</div>' . $vipText;
                                                } elseif ($indexMemberDown == 2) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . ' 5折）</div>' . $vipText;
                                                } elseif ($indexMemberDown == 13) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费）</div>' . $vipText;
                                                } elseif ($indexMemberDown == 5) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . ' 866折）</div>' . $vipText;
                                                } elseif ($indexMemberDown == 14) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_vip_name . ' 866折、' . $erphp_life_name . '免费）</div>' . $vipText;
                                                } elseif ($indexMemberDown == 16) {
                                                    if ($userType < 8) {
                                                        $vipText = '<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_quarter_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                    }
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_quarter_name . '免费）</div>' . $vipText;
                                                } elseif ($indexMemberDown == 6) {
                                                    if ($userType < 9) {
                                                        $vipText = '<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_year_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                    }
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_year_name . '免费）</div>' . $vipText;
                                                } elseif ($indexMemberDown == 7) {
                                                    if ($userType < 10) {
                                                        $vipText = '<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_life_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                    }
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（' . $erphp_life_name . '免费）</div>' . $vipText;
                                                } elseif ($indexMemberDown == 4) {
                                                    if ($userType) {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源为' . $erphp_vip_name . '专享资源）</div>';
                                                    }
                                                } elseif ($indexMemberDown == 15) {
                                                    if ($userType >= 9) {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源为' . $erphp_quarter_name . '专享资源）</div>';
                                                    }
                                                } elseif ($indexMemberDown == 8) {
                                                    if ($userType >= 9) {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源为' . $erphp_year_name . '专享资源）</div>';
                                                    }
                                                } elseif ($indexMemberDown == 9) {
                                                    if ($userType >= 10) {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源为' . $erphp_life_name . '专享资源）</div>';
                                                    }
                                                }


                                                if ($indexMemberDown == 4) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_vip_name . '下载）</div><input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                } elseif ($indexMemberDown == 15) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_quarter_name . '下载）</div><input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_quarter_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                } elseif ($indexMemberDown == 8) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_year_name . '下载）</div><input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_year_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                } elseif ($indexMemberDown == 9) {
                                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_life_name . '下载）</div><input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_life_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                } elseif ($indexMemberDown == 10) {
                                                    if ($userType) {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买）</div>';
                                                        if ($down_checkpan) $content .= $down_checkpan;
                                                        else $content .= '<input type="hidden" name="erphpdown-buy" data-class="erphpdown-iframe" data-title="' . $buyText . '" data-url="' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '&index=' . $index . '" data-target="_blank">';

                                                        if ($days) {
                                                            $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（购买后' . $days . '天内可下载）</div>';
                                                        }
                                                    } else {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买）</div><input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';

                                                    }
                                                } elseif ($indexMemberDown == 11) {
                                                    if ($userType) {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折）</div>';
                                                        if ($down_checkpan) $content .= $down_checkpan;
                                                        else $content .= '<input type="hidden" name="erphpdown-buy" data-class="erphpdown-iframe" data-title="' . $buyText . '" data-url="' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '&index=' . $index . '" data-target="_blank">';

                                                        if ($days) {
                                                            $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（购买后' . $days . '天内可下载）</div>';
                                                        }
                                                    } else {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折）</div><input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                    }
                                                } elseif ($indexMemberDown == 12) {
                                                    if ($userType) {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 899折）</div>';
                                                        if ($down_checkpan) $content .= $down_checkpan;
                                                        else $content .= '<input type="hidden" name="erphpdown-buy" data-class="erphpdown-iframe" data-title="' . $buyText . '" data-url="' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '&index=' . $index . '" data-target="_blank">';

                                                        if ($days) {
                                                            $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（购买后' . $days . '天内可下载）</div>';
                                                        }
                                                    } else {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 899折）</div><input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                                    }
                                                } else {
                                                    if ($down_checkpan) $content .= $down_checkpan;
                                                    else $content .= '<input type="hidden" name="erphpdown-buy" data-class="erphpdown-iframe" data-title="' . $buyText . '" data-url="' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '&index=' . $index . '" data-target="_blank">';

                                                    if ($days) {
                                                        $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（购买后' . $days . '天内可下载）</div>';
                                                    }
                                                }

                                            }

                                        } else {
                                            $content .= "<input type='hidden' name='erphpdown-down' data-class=" . $erphp_popdown . " data-title='立即下载' data-url='" . constant("erphpdown") . 'download.php?postid=' . get_the_ID() . "&index=" . $index . $iframe . "' data-target='_blank'>";
                                        }

                                    } else {
                                        if ($indexMemberDown == 4 || $indexMemberDown == 15 || $indexMemberDown == 8 || $indexMemberDown == 9) {
                                            $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限' . $erphp_vip_name . '下载）</div><input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                                        } else {
                                            if ($price) {
                                                $content .= '<div class="product-item-price-wrapper d-none"><div class="product-item-price" data-price=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div><div class="product-item-price-full" data-price-full=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div></div><input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                                            } else {
                                                $content .= '此资源为免费资源<input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                                            }
                                        }
                                    }
                                    if (get_option('erphp_repeatdown_btn') && $down_repeat && $down_info_repeat && !$down_info) {

                                        $content .= '<input type="hidden" name="erphpdown-down" data-class=' . $erphp_popdown . ' data-title="立即下载" data-url="' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '&index=' . $index . $iframe . '" data-target="_blank">';
                                    }
                                    $content .= '
									<div class="product-item-check mt-auto"><input type="radio" class="form-check-input" name="checkout-onetime"></div></div></div>';
                                }
                            }
                        }
                    } else {
                        if (function_exists('erphpdown_tuan_install')) {
                            $tuanHtml = erphpdown_tuan_html();
                        }

                        if (function_exists('epd_check_pan_callback')) {
                            if (strpos($url, 'pan.baidu.com') !== false || (strpos($url, 'lanzou') !== false && strpos($url, '.com') !== false) || strpos($url, 'cloud.189.cn') !== false) {
                                $down_checkpan = '<a class="erphpdown-buy erphpdown-checkpan" href="javascript:;" data-id="' . get_the_ID() . '" data-index="0" data-buy="' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '">点击检测网盘有效后购买</a>';
                            }
                        }
                        if (is_user_logged_in()) {
                            if ($price) {
                                if ($memberDown != 4 && $memberDown != 15 && $memberDown != 8 && $memberDown != 9)
                                    $content .= '<div class="product-item-price-wrapper"><div class="product-item-price" data-price=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</span></div><div class="product-item-price-full" data-price-full=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div></div>';
                            } else {
                                if ($memberDown != 4 && $memberDown != 15 && $memberDown != 8 && $memberDown != 9)
                                    $content .= '<div class="product-item-discount text-xs text-muted mt-1 mt-md-2" data-product-discount>（此资源仅限注册用户下载）</div>';
                            }

                            if ($price || $memberDown == 4 || $memberDown == 15 || $memberDown == 8 || $memberDown == 9) {
                                $user_info = wp_get_current_user();
                                $down_info = $wpdb->get_row("select * from " . $wpdb->icealipay . " where ice_post='" . get_the_ID() . "' and ice_success=1 and (ice_index is null or ice_index = '') and ice_user_id=" . $user_info->ID . " order by ice_time desc");
                                if ($days > 0 && $down_info) {
                                    $lastDownDate = date('Y-m-d H:i:s', strtotime('+' . $days . ' day', strtotime($down_info->ice_time)));
                                    $nowDate = date('Y-m-d H:i:s');
                                    if (strtotime($nowDate) > strtotime($lastDownDate)) {
                                        $down_info = null;
                                    }
                                }

                                if ($down_repeat) {
                                    $down_info_repeat = $down_info;
                                    $down_info = null;
                                }

                                $buyText = '立即购买';
                                if ($down_repeat && $down_info_repeat && !$down_info) {
                                    $buyText = '再次购买';
                                }

                                $user_id = $user_info->ID;
                                $wppay = new EPD(get_the_ID(), $user_id);

                                if (($userType && ($memberDown == 3 || $memberDown == 4)) || (($wppay->isWppayPaid() || $wppay->isWppayPaidNew()) && !$down_repeat) || $down_info || (($memberDown == 15 || $memberDown == 16) && $userType >= 8) || (($memberDown == 6 || $memberDown == 8) && $userType >= 9) || (($memberDown == 7 || $memberDown == 9 || $memberDown == 13 || $memberDown == 14) && $userType == 10) || (!$price && $memberDown != 4 && $memberDown != 15 && $memberDown != 8 && $memberDown != 9)) {

                                    if ($memberDown == 3) {
                                        $content .= '（' . $erphp_vip_name . '免费）';
                                    } elseif ($memberDown == 2) {
                                        $content .= '（' . $erphp_vip_name . ' 5折）';
                                    } elseif ($memberDown == 13) {
                                        $content .= '（' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费）';
                                    } elseif ($memberDown == 5) {
                                        $content .= '（' . $erphp_vip_name . ' 899折）';
                                    } elseif ($memberDown == 14) {
                                        $content .= '（' . $erphp_vip_name . ' 866折、' . $erphp_life_name . '免费）';
                                    } elseif ($memberDown == 16) {
                                        $content .= '（' . $erphp_quarter_name . '免费）';
                                    } elseif ($memberDown == 6) {
                                        $content .= '（' . $erphp_year_name . '免费）';
                                    } elseif ($memberDown == 7) {
                                        $content .= '（' . $erphp_life_name . '免费）';
                                    } elseif ($memberDown == 4) {
                                        $content .= '（此资源仅限' . $erphp_vip_name . '下载）';
                                    } elseif ($memberDown == 15) {
                                        $content .= '（此资源仅限' . $erphp_quarter_name . '下载）';
                                    } elseif ($memberDown == 8) {
                                        $content .= '（此资源仅限' . $erphp_year_name . '下载）';
                                    } elseif ($memberDown == 9) {
                                        $content .= '（此资源仅限' . $erphp_life_name . '下载）';
                                    } elseif ($memberDown == 10) {
                                        $content .= '（仅限' . $erphp_vip_name . '购买）';
                                    } elseif ($memberDown == 11) {
                                        $content .= '（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折）';
                                    } elseif ($memberDown == 12) {
                                        $content .= '（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 899折）';
                                    }

                                    $content .= "<a href=" . constant("erphpdown") . 'download.php?postid=' . get_the_ID() . $iframe . " class='erphpdown-down" . $erphp_popdown . "' target='_blank'>立即下载</a>";

                                } else {

                                    $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_vip_name . '</a>';
                                    if ($userType) {
                                        $vipText = '';
                                        if (($memberDown == 13 || $memberDown == 14) && $userType < 10) {
                                            $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                                        }
                                    }
                                    if ($memberDown == 3) {
                                        $content .= '（' . $erphp_vip_name . '免费）' . $vipText;
                                    } elseif ($memberDown == 2) {
                                        $content .= '（' . $erphp_vip_name . ' 5折）' . $vipText;
                                    } elseif ($memberDown == 13) {
                                        $content .= '（' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费）' . $vipText;
                                    } elseif ($memberDown == 5) {
                                        $content .= '（' . $erphp_vip_name . ' 899折）' . $vipText;
                                    } elseif ($memberDown == 14) {
                                        $content .= '（' . $erphp_vip_name . ' 866折、' . $erphp_life_name . '免费）' . $vipText;
                                    } elseif ($memberDown == 16) {
                                        if ($userType < 8) {
                                            $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_quarter_name . '</a>';
                                        }
                                        $content .= '（' . $erphp_quarter_name . '免费）' . $vipText;
                                    } elseif ($memberDown == 6) {
                                        if ($userType < 9) {
                                            $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_year_name . '</a>';
                                        }
                                        $content .= '（' . $erphp_year_name . '免费）' . $vipText;
                                    } elseif ($memberDown == 7) {
                                        if ($userType < 10) {
                                            $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                                        }
                                        $content .= '（' . $erphp_life_name . '免费）' . $vipText;
                                    } elseif ($memberDown == 4) {
                                        if ($userType) {
                                            $content .= '此资源为' . $erphp_vip_name . '专享资源';
                                        }
                                    } elseif ($memberDown == 15) {
                                        if ($userType >= 9) {
                                            $content .= '此资源为' . $erphp_quarter_name . '专享资源';
                                        }
                                    } elseif ($memberDown == 8) {
                                        if ($userType >= 9) {
                                            $content .= '此资源为' . $erphp_year_name . '专享资源';
                                        }
                                    } elseif ($memberDown == 9) {
                                        if ($userType >= 10) {
                                            $content .= '此资源为' . $erphp_life_name . '专享资源';
                                        }
                                    }


                                    if ($memberDown == 4) {
                                        $content .= '此资源仅限' . $erphp_vip_name . '下载<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                    } elseif ($memberDown == 15) {
                                        $content .= '此资源仅限' . $erphp_quarter_name . '下载<a href="' . $erphp_url_front_vip . '" class="erphpdown-vip">升级' . $erphp_quarter_name . '</a>';
                                    } elseif ($memberDown == 8) {
                                        $content .= '此资源仅限' . $erphp_year_name . '下载<a href="' . $erphp_url_front_vip . '" class="erphpdown-vip">升级' . $erphp_year_name . '</a>';
                                    } elseif ($memberDown == 9) {
                                        $content .= '此资源仅限' . $erphp_life_name . '下载<a href="' . $erphp_url_front_vip . '" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                                    } elseif ($memberDown == 10) {
                                        if ($userType) {
                                            $content .= '（仅限' . $erphp_vip_name . '购买）';
                                            if ($down_checkpan) $content .= $down_checkpan;
                                            else $content .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">' . $buyText . '</a>';

                                            if ($days) {
                                                $content .= '（购买后' . $days . '天内可下载）';
                                            }
                                        } else {
                                            $content .= '（仅限' . $erphp_vip_name . '购买）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                        }
                                    } elseif ($memberDown == 11) {
                                        if ($userType) {
                                            $content .= '（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折）';
                                            if ($down_checkpan) $content .= $down_checkpan;
                                            else $content .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">' . $buyText . '</a>';

                                            if ($days) {
                                                $content .= '（购买后' . $days . '天内可下载）';
                                            }
                                        } else {
                                            $content .= '（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                        }
                                    } elseif ($memberDown == 12) {
                                        if ($userType) {
                                            $content .= '（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 899折）';
                                            if ($down_checkpan) $content .= $down_checkpan;
                                            else $content .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">' . $buyText . '</a>';

                                            if ($days) {
                                                $content .= '（购买后' . $days . '天内可下载）';
                                            }
                                        } else {
                                            $content .= '（仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 899折）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                                        }
                                    } else {

                                        if ($down_checkpan) $content .= $down_checkpan;
                                        else $content .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">' . $buyText . '</a>';

                                        if ($days) {
                                            $content .= '（购买后' . $days . '天内可下载）';
                                        }
                                    }
                                }

                            } else {
                                $content .= "<a href=" . constant("erphpdown") . 'download.php?postid=' . get_the_ID() . $iframe . " class='erphpdown-down" . $erphp_popdown . "' target='_blank'>立即下载</a>";
                            }

                        } else {
                            if ($memberDown == 4) {
                                $content .= '此资源仅限' . $erphp_vip_name . '下载，请先<input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                            } elseif ($memberDown == 15) {
                                $content .= '此资源仅限' . $erphp_quarter_name . '下载，请先<input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                            } elseif ($memberDown == 8) {
                                $content .= '此资源仅限' . $erphp_year_name . '下载，请先<input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                            } elseif ($memberDown == 9) {
                                $content .= '此资源仅限' . $erphp_life_name . '下载，请先<input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                            } elseif ($memberDown == 10) {
                                $content .= '此资源仅限' . $erphp_vip_name . '购买，请先<input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                            } elseif ($memberDown == 11) {
                                $content .= '此资源仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折，请先<input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                            } elseif ($memberDown == 12) {
                                $content .= '此资源仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 866折，请先<input type="hidden" name="erphp-login-must" data-title="登录" data-url="' . $erphp_url_front_login . '" data-target="_blank">';
                            } else {
                                $vip_content = '';
                                if ($memberDown == 3) {
                                    $vip_content .= '，' . $erphp_vip_name . '免费';
                                } elseif ($memberDown == 2) {
                                    $vip_content .= '，' . $erphp_vip_name . ' 5折';
                                } elseif ($memberDown == 13) {
                                    $vip_content .= '，' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费';
                                } elseif ($memberDown == 5) {
                                    $vip_content .= '，' . $erphp_vip_name . ' 866折';
                                } elseif ($memberDown == 14) {
                                    $vip_content .= '，' . $erphp_vip_name . ' 866折、' . $erphp_life_name . '免费';
                                } elseif ($memberDown == 16) {
                                    $vip_content .= '，' . $erphp_quarter_name . '免费';
                                } elseif ($memberDown == 6) {
                                    $vip_content .= '，' . $erphp_year_name . '免费';
                                } elseif ($memberDown == 7) {
                                    $vip_content .= '，' . $erphp_life_name . '免费';
                                }

                                if (get_option('erphp_wppay_down')) {
                                    $user_id = 0;
                                    $wppay = new EPD(get_the_ID(), $user_id);
                                    if ($wppay->isWppayPaid() || $wppay->isWppayPaidNew()) {
                                        if ($price) {
                                            $content .= '此资源下载价格为<div class="product-item-price-wrapper"><div class="product-item-price" data-price=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div><div class="product-item-price-full" data-price-full=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div></div>';
                                        }
                                        $content .= "<a href=" . constant("erphpdown") . 'download.php?postid=' . get_the_ID() . $iframe . " class='erphpdown-down" . $erphp_popdown . "' target='_blank'>立即下载</a>";
                                    } else {
                                        if ($price) {
                                            $content .= '此资源下载价格为<div class="product-item-price-wrapper"><div class="product-item-price" data-price=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div><div class="product-item-price-full" data-price-full=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div></div>';

                                            if ($down_checkpan) $content .= $down_checkpan;
                                            else $content .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';

                                            $content .= $vip_content ? ($vip_content . '<a href="' . $erphp_url_front_login . '" target="_blank" class="erphpdown-vip erphp-login-must">立即升级</a>') : '';
                                        } else {
                                            if (!get_option('erphp_free_login')) {
                                                $content .= "此资源为免费资源<a href=" . constant("erphpdown") . 'download.php?postid=' . get_the_ID() . $iframe . " class='erphpdown-down" . $erphp_popdown . "' target='_blank'>立即下载</a>";
                                            } else {
                                                $content .= '此资源仅限注册用户下载，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                                            }
                                        }
                                    }
                                } else {
                                    if ($price) {
                                        $content .= '此资源下载价格为<div class="product-item-price-wrapper"><div class="product-item-price" data-price=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div><div class="product-item-price-full" data-price-full=""><span class="niceeeeee">' . get_option('ice_name_alipay') . '</span>' . $price . '</div></div>' . $vip_content . '，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                                    } else {
                                        $content .= '此资源仅限注册用户下载，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                                    }

                                }
                            }
                        }

                        if (get_option('erphp_repeatdown_btn') && $down_repeat && $down_info_repeat && !$down_info) {
                            $content .= '<a href=' . constant("erphpdown") . 'download.php?postid=' . get_the_ID() . $iframe . ' class="erphpdown-down' . $erphp_popdown . '" target="_blank">立即下载</a>';
                        }

                    }
                    $content .= '</div>';
                    if (get_option('ice_tips')) $content .= '<div class="timer" data-countdown="">
					<div class="timer-in">
					  <div class="timer-title">' . get_option('ice_tips') . '</div>
					  <div class="timer-time" data-countdown-time="3600">
						<div class="timer-item"><span data-countdown-hours="">0</span>h</div>
						<div class="timer-item"><span data-countdown-minutes="">59</span>米</div>
						<div class="timer-item"><span data-countdown-seconds="">48</span>s</div>
					  </div>
					</div>
				  </div>';

                    $content .= $tuanHtml;
                }
                $content .= '<div class="checkout-in" data-checkout-block="subscription" data-checkout="cleanmypc">
				<div class="row">
				  <div class="col-12 col-md-12 col-lg-6 col-xxl-7">
					<div class="checkout-info text-sm text-secondary">
					  <div class="checkout-info-item">
						<div class="checkout-info-item-in">
						<i class="text-xl iconfont icon-read"></i>
						  <div class="checkout-info-text">详尽的使用教程</div>
						</div>
					  </div>
					  <div class="checkout-info-item">
						<div class="checkout-info-item-in">
						<i class="text-xl iconfont icon-cloud-sync"></i>
						  <div class="checkout-info-text">免费更新、维护</div>
						</div>
					  </div>
					</div>
					<div class="checkout-info text-sm text-secondary">
					  <div class="checkout-info-item">
						<div class="checkout-info-item-in">
						<i class="text-xl iconfont icon-customerservice"></i>
						  <div class="checkout-info-text"> 24X7 技术和销售支持 </div>
						</div>
					  </div>
					  <div class="checkout-info-item">
						<div class="checkout-info-item-in">
						<i class="text-xl iconfont icon-retweet"></i>
						  <div class="checkout-info-text">安全支付加密</div>
						</div>
					  </div>
					</div>
				  </div>
				  <div class="col-12 col-md-12 col-lg-6 col-xxl-5">
					<div class="checkout-purchase">
					  <div class="checkout-purchase-name text-sm text-secondary mb-2">当先选择： <span data-name></span>
					  </div>
					  <div class="checkout-purchase-cta">
					  <div class="button-container">
					  </div>
					  </div>
					  <div class="checkout-pay">
						<div class="checkout-pay-icons">
						  <img src="https://cdn2.macpaw.com/images/store/pay-visa.svg?id=0e1ea75c79ae0d2cd30f0b17d7f1e8f8" width="28" alt="">
						  <img src="https://cdn2.macpaw.com/images/store/pay-ms.svg?id=63a6c0d9dd6f1366489d4ab046ed4cfd" width="28" alt="">
						  <img src="https://cdn2.macpaw.com/images/store/pay-amex.svg?id=42c420d0330782cd12a836449559433e" width="28" alt="">
						</div>
						<div class="checkout-pay-price text-sm text-muted">
						<span data-price-full></span><span data-checkout-discount></span>
						</div>

					  </div>
					</div>
				  </div>
				</div>
			  </div></div>
				</div>';

            } elseif ($start_see) {

                if (is_user_logged_in()) {
                    $user_info = wp_get_current_user();
                    $down_info = $wpdb->get_row("select * from " . $wpdb->icealipay . " where ice_post='" . get_the_ID() . "' and ice_success=1 and (ice_index is null or ice_index = '') and ice_user_id=" . $user_info->ID . " order by ice_time desc");
                    if ($days > 0 && $down_info) {
                        $lastDownDate = date('Y-m-d H:i:s', strtotime('+' . $days . ' day', strtotime($down_info->ice_time)));
                        $nowDate = date('Y-m-d H:i:s');
                        if (strtotime($nowDate) > strtotime($lastDownDate)) {
                            $down_info = null;
                        }
                    }

                    $user_id = $user_info->ID;
                    $wppay = new EPD(get_the_ID(), $user_id);

                    if (($userType && ($memberDown == 3 || $memberDown == 4)) || $wppay->isWppayPaid() || $wppay->isWppayPaidNew() || $down_info || (($memberDown == 15 || $memberDown == 16) && $userType >= 8) || (($memberDown == 6 || $memberDown == 8) && $userType >= 9) || (($memberDown == 7 || $memberDown == 9 || $memberDown == 13 || $memberDown == 14) && $userType == 10) || (!$price && $memberDown != 4 && $memberDown != 15 && $memberDown != 8 && $memberDown != 9)) {
                        return $content;
                    } else {

                        $content2 = '<fieldset class="erphpdown erphpdown-default erphpdown-see" id="erphpdown"><legend>内容查看</legend>';
                        if ($price) {
                            if ($memberDown != 4 && $memberDown != 15 && $memberDown != 8 && $memberDown != 9) {
                                $content2 .= '此内容查看价格为<span class="erphpdown-price">' . $price . '</span>' . get_option('ice_name_alipay');
                            }
                        }

                        $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_vip_name . '</a>';
                        if ($userType) {
                            $vipText = '';
                            if (($memberDown == 13 || $memberDown == 14) && $userType < 10) {
                                $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                            }
                        }
                        if ($memberDown == 3) {
                            $content2 .= '（' . $erphp_vip_name . '免费）' . $vipText;
                        } elseif ($memberDown == 2) {
                            $content2 .= '（' . $erphp_vip_name . ' 5折）' . $vipText;
                        } elseif ($memberDown == 13) {
                            $content2 .= '（' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费）' . $vipText;
                        } elseif ($memberDown == 5) {
                            $content2 .= '（' . $erphp_vip_name . ' 8折）' . $vipText;
                        } elseif ($memberDown == 14) {
                            $content2 .= '（' . $erphp_vip_name . ' 8折、' . $erphp_life_name . '免费）' . $vipText;
                        } elseif ($memberDown == 16) {
                            if ($userType < 8) {
                                $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_quarter_name . '</a>';
                            }
                            $content2 .= '（' . $erphp_quarter_name . '免费）' . $vipText;
                        } elseif ($memberDown == 6) {
                            if ($userType < 9) {
                                $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_year_name . '</a>';
                            }
                            $content2 .= '（' . $erphp_year_name . '免费）' . $vipText;
                        } elseif ($memberDown == 7) {
                            if ($userType < 10) {
                                $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                            }
                            $content2 .= '（' . $erphp_life_name . '免费）' . $vipText;
                        }

                        if ($memberDown == 4) {
                            $content2 .= '此内容仅限' . $erphp_vip_name . '查看<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_vip_name . '</a>';
                        } elseif ($memberDown == 15) {
                            $content2 .= '此内容仅限' . $erphp_quarter_name . '查看<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_quarter_name . '</a>';
                        } elseif ($memberDown == 8) {
                            $content2 .= '此内容仅限' . $erphp_year_name . '查看<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_year_name . '</a>';
                        } elseif ($memberDown == 9) {
                            $content2 .= '此内容仅限' . $erphp_life_name . '查看<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                        } elseif ($memberDown == 10) {
                            if ($userType) {
                                $content2 .= '（仅限' . $erphp_vip_name . '购买）<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';

                                if ($days) {
                                    $content2 .= '（购买后' . $days . '天内可查看）';
                                }
                            } else {
                                $content2 .= '（仅限' . $erphp_vip_name . '购买）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                            }
                        } elseif ($memberDown == 11) {
                            if ($userType) {
                                $content2 .= '（仅限' . $erphp_vip_name . '购买，' . $erphp_year_name . ' 5折）<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';

                                if ($days) {
                                    $content2 .= '（购买后' . $days . '天内可查看）';
                                }
                            } else {
                                $content2 .= '（仅限' . $erphp_vip_name . '购买，' . $erphp_year_name . ' 5折）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                            }
                        } elseif ($memberDown == 12) {
                            if ($userType) {
                                $content2 .= '（仅限' . $erphp_vip_name . '购买，' . $erphp_year_name . ' 8折）<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';

                                if ($days) {
                                    $content2 .= '（购买后' . $days . '天内可查看）';
                                }
                            } else {
                                $content2 .= '（仅限' . $erphp_vip_name . '购买，' . $erphp_year_name . ' 8折）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                            }
                        } else {
                            $content2 .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '>立即购买</a>';

                            if ($days) {
                                $content2 .= '（购买后' . $days . '天内可查看）';
                            }
                        }
                    }

                } else {
                    $content2 = '<fieldset class="erphpdown erphpdown-default erphpdown-see" id="erphpdown"><legend>内容查看</legend>';

                    if ($memberDown == 4) {
                        $content2 .= '此内容仅限' . $erphp_vip_name . '查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 15) {
                        $content2 .= '此内容仅限' . $erphp_quarter_name . '查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 8) {
                        $content2 .= '此内容仅限' . $erphp_year_name . '查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 9) {
                        $content2 .= '此内容仅限' . $erphp_life_name . '查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 10) {
                        $content2 .= '此内容仅限' . $erphp_vip_name . '购买，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 11) {
                        $content2 .= '此内容仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 12) {
                        $content2 .= '此内容仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 8折，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } else {
                        $vip_content = '';
                        if ($memberDown == 3) {
                            $vip_content .= '，' . $erphp_vip_name . '免费';
                        } elseif ($memberDown == 2) {
                            $vip_content .= '，' . $erphp_vip_name . ' 5折';
                        } elseif ($memberDown == 13) {
                            $vip_content .= '，' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费';
                        } elseif ($memberDown == 5) {
                            $vip_content .= '，' . $erphp_vip_name . ' 8折';
                        } elseif ($memberDown == 14) {
                            $vip_content .= '，' . $erphp_vip_name . ' 8折、' . $erphp_life_name . '免费';
                        } elseif ($memberDown == 16) {
                            $vip_content .= '，' . $erphp_quarter_name . '免费';
                        } elseif ($memberDown == 6) {
                            $vip_content .= '，' . $erphp_year_name . '免费';
                        } elseif ($memberDown == 7) {
                            $vip_content .= '，' . $erphp_life_name . '免费';
                        }

                        if (get_option('erphp_wppay_down')) {
                            $user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
                            $wppay = new EPD(get_the_ID(), $user_id);
                            if ($wppay->isWppayPaid() || $wppay->isWppayPaidNew()) {
                                return $content;
                            } else {
                                if ($price) {
                                    $content2 .= '此内容查看价格为<span class="erphpdown-price">' . $price . '</span>' . get_option('ice_name_alipay');
                                    $content2 .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';

                                    $content2 .= $vip_content ? ($vip_content . '<a href="' . $erphp_url_front_login . '" target="_blank" class="erphpdown-vip erphp-login-must">立即升级</a>') : '';
                                } else {
                                    if (!get_option('erphp_free_login')) {
                                        return $content;
                                    } else {
                                        $content2 .= '此内容仅限注册用户查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                                    }
                                }
                            }
                        } else {
                            if ($price) {
                                $content2 .= '此内容查看价格为<span class="erphpdown-price">' . $price . '</span>' . get_option('ice_name_alipay') . $vip_content . '，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                            } else {
                                $content2 .= '此内容仅限注册用户查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                            }

                        }
                    }

                }
                if (get_option('ice_tips')) $content2 .= '<div class="erphpdown-tips">' . get_option('ice_tips') . '</div>';
                $content2 .= '</fieldset>';
                return $content2;

            } elseif ($start_see2 && $erphp_see2_style) {

                if (is_user_logged_in()) {
                    $user_info = wp_get_current_user();
                    $down_info = $wpdb->get_row("select * from " . $wpdb->icealipay . " where ice_post='" . get_the_ID() . "' and ice_success=1 and (ice_index is null or ice_index = '') and ice_user_id=" . $user_info->ID . " order by ice_time desc");
                    if ($days > 0 && $down_info) {
                        $lastDownDate = date('Y-m-d H:i:s', strtotime('+' . $days . ' day', strtotime($down_info->ice_time)));
                        $nowDate = date('Y-m-d H:i:s');
                        if (strtotime($nowDate) > strtotime($lastDownDate)) {
                            $down_info = null;
                        }
                    }
                    if (($userType && ($memberDown == 3 || $memberDown == 4)) || $down_info || (($memberDown == 15 || $memberDown == 16) && $userType >= 8) || (($memberDown == 6 || $memberDown == 8) && $userType >= 9) || (($memberDown == 7 || $memberDown == 9 || $memberDown == 13 || $memberDown == 14) && $userType == 10) || (!$price && $memberDown != 4 && $memberDown != 15 && $memberDown != 8 && $memberDown != 9)) {

                    } else {

                        $content .= '<fieldset class="erphpdown erphpdown-default erphpdown-see" id="erphpdown"><legend>内容查看</legend>';
                        if ($price) {
                            if ($memberDown != 4 && $memberDown != 15 && $memberDown != 8 && $memberDown != 9)
                                $content .= '本文隐藏内容查看价格为<span class="erphpdown-price">' . $price . '</span>' . get_option('ice_name_alipay');
                        }


                        $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_vip_name . '</a>';
                        if ($userType) {
                            $vipText = '';
                            if (($memberDown == 13 || $memberDown == 14) && $userType < 10) {
                                $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                            }
                        }
                        if ($memberDown == 3) {
                            $content .= '（' . $erphp_vip_name . '免费）' . $vipText;
                        } elseif ($memberDown == 2) {
                            $content .= '（' . $erphp_vip_name . ' 5折）' . $vipText;
                        } elseif ($memberDown == 13) {
                            $content .= '（' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费）' . $vipText;
                        } elseif ($memberDown == 5) {
                            $content .= '（' . $erphp_vip_name . ' 8折）' . $vipText;
                        } elseif ($memberDown == 14) {
                            $content .= '（' . $erphp_vip_name . ' 8折、' . $erphp_life_name . '免费）' . $vipText;
                        } elseif ($memberDown == 16) {
                            if ($userType < 9) {
                                $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_quarter_name . '</a>';
                            }
                            $content .= '（' . $erphp_quarter_name . '免费）' . $vipText;
                        } elseif ($memberDown == 6) {
                            if ($userType < 9) {
                                $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_year_name . '</a>';
                            }
                            $content .= '（' . $erphp_year_name . '免费）' . $vipText;
                        } elseif ($memberDown == 7) {
                            if ($userType < 10) {
                                $vipText = '<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                            }
                            $content .= '（' . $erphp_life_name . '免费）' . $vipText;
                        }

                        if ($memberDown == 4) {
                            $content .= '本文隐藏内容仅限' . $erphp_vip_name . '查看<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_vip_name . '</a>';
                        } elseif ($memberDown == 15) {
                            $content .= '本文隐藏内容仅限' . $erphp_quarter_name . '查看<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_quarter_name . '</a>';
                        } elseif ($memberDown == 8) {
                            $content .= '本文隐藏内容仅限' . $erphp_year_name . '查看<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_year_name . '</a>';
                        } elseif ($memberDown == 9) {
                            $content .= '本文隐藏内容仅限' . $erphp_life_name . '查看<a href="' . $erphp_url_front_vip . '" target="_blank" class="erphpdown-vip">升级' . $erphp_life_name . '</a>';
                        } elseif ($memberDown == 10) {
                            if ($userType) {
                                $content .= '（仅限' . $erphp_vip_name . '购买）<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';

                                if ($days) {
                                    $content .= '（购买后' . $days . '天内可查看）';
                                }
                            } else {
                                $content .= '（仅限' . $erphp_vip_name . '购买）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                            }
                        } elseif ($memberDown == 11) {
                            if ($userType) {
                                $content .= '（仅限' . $erphp_vip_name . '购买，' . $erphp_year_name . ' 5折）<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';
                                if ($days) {
                                    $content .= '（购买后' . $days . '天内可查看）';
                                }
                            } else {
                                $content .= '（仅限' . $erphp_vip_name . '购买，' . $erphp_year_name . ' 5折）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                            }
                        } elseif ($memberDown == 12) {
                            if ($userType) {
                                $content .= '（仅限' . $erphp_vip_name . '购买，' . $erphp_year_name . ' 8折）<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';

                                if ($days) {
                                    $content .= '（购买后' . $days . '天内可查看）';
                                }
                            } else {
                                $content .= '（仅限' . $erphp_vip_name . '购买，' . $erphp_year_name . ' 8折）<input type="hidden" name="erphpdown-vip" data-title="升级' . $erphp_vip_name . '" data-url="' . $erphp_url_front_vip . '" data-target="_blank">';
                            }
                        } else {

                            $content .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . '>立即购买</a>';
                            if ($days) {
                                $content .= '（购买后' . $days . '天内可查看）';
                            }
                        }

                        if (get_option('ice_tips')) $content .= '<div class="erphpdown-tips">' . get_option('ice_tips') . '</div>';
                        $content .= '</fieldset>';
                    }

                } else {
                    $content .= '<fieldset class="erphpdown erphpdown-default erphpdown-see" id="erphpdown"><legend>内容查看</legend>';

                    if ($memberDown == 4) {
                        $content .= '本文隐藏内容仅限' . $erphp_vip_name . '查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 15) {
                        $content .= '本文隐藏内容仅限' . $erphp_quarter_name . '查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 8) {
                        $content .= '本文隐藏内容仅限' . $erphp_year_name . '查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 9) {
                        $content .= '本文隐藏内容仅限' . $erphp_life_name . '查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 10) {
                        $content .= '本文隐藏内容仅限' . $erphp_vip_name . '购买，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 11) {
                        $content .= '本文隐藏内容仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 5折，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } elseif ($memberDown == 12) {
                        $content .= '本文隐藏内容仅限' . $erphp_vip_name . '购买、' . $erphp_year_name . ' 8折，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                    } else {
                        $vip_content = '';
                        if ($memberDown == 3) {
                            $vip_content .= '，' . $erphp_vip_name . '免费';
                        } elseif ($memberDown == 2) {
                            $vip_content .= '，' . $erphp_vip_name . ' 5折';
                        } elseif ($memberDown == 13) {
                            $vip_content .= '，' . $erphp_vip_name . ' 5折、' . $erphp_life_name . '免费';
                        } elseif ($memberDown == 5) {
                            $vip_content .= '，' . $erphp_vip_name . ' 8折';
                        } elseif ($memberDown == 14) {
                            $vip_content .= '，' . $erphp_vip_name . ' 8折、' . $erphp_life_name . '免费';
                        } elseif ($memberDown == 16) {
                            $vip_content .= '，' . $erphp_quarter_name . '免费';
                        } elseif ($memberDown == 6) {
                            $vip_content .= '，' . $erphp_year_name . '免费';
                        } elseif ($memberDown == 7) {
                            $vip_content .= '，' . $erphp_life_name . '免费';
                        }

                        if (get_option('erphp_wppay_down')) {
                            $user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
                            $wppay = new EPD(get_the_ID(), $user_id);
                            if ($wppay->isWppayPaid() || $wppay->isWppayPaidNew()) {
                                return '';
                            } else {
                                if ($price) {
                                    $content .= '本文隐藏内容查看价格为<span class="erphpdown-price">' . $price . '</span>' . get_option('ice_name_alipay');
                                    $content .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';

                                    $content .= $vip_content ? ($vip_content . '<a href="' . $erphp_url_front_login . '" target="_blank" class="erphpdown-vip erphp-login-must">立即升级</a>') : '';
                                } else {
                                    if (!get_option('erphp_free_login')) {
                                        return '';
                                    } else {
                                        $content .= '此内容仅限注册用户查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                                    }
                                }
                            }
                        } else {
                            if ($price) {
                                $content .= '本文隐藏内容查看价格为<span class="erphpdown-price">' . $price . '</span>' . get_option('ice_name_alipay') . $vip_content . '，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                            } else {
                                $content .= '本文隐藏内容仅限注册用户查看，请先<a href="' . $erphp_url_front_login . '" target="_blank" class="erphp-login-must">登录</a>';
                            }

                        }
                    }
                    if (get_option('ice_tips')) $content .= '<div class="erphpdown-tips">' . get_option('ice_tips') . '</div>';
                    $content .= '</fieldset>';
                }

                return $content;

            } elseif ($erphp_down == 6) {
                $content .= '<fieldset class="erphpdown erphpdown-default" id="erphpdown"><legend>自动发卡</legend>';
                $content .= '此卡密价格为<span class="erphpdown-price">' . $price . '</span>' . get_option("ice_name_alipay");
                $content .= '<a class="erphpdown-iframe erphpdown-buy" href=' . constant("erphpdown") . 'buy.php?postid=' . get_the_ID() . ' target="_blank">立即购买</a>';
                if (function_exists('getErphpActLeft')) $content .= '（库存：' . getErphpActLeft(get_the_ID()) . '）';
                $content .= '</fieldset>';
            } else {
                if ($downMsgFree) $content .= '<fieldset class="erphpdown erphpdown-default" id="erphpdown"><legend>资源下载</legend>' . $downMsgFree . '</fieldset>';
            }

        } else {
            $start_see = get_post_meta(get_the_ID(), 'start_see', true);
            if ($start_see) {
                return '';
            }
        }
    }


