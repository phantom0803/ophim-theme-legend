<?php

namespace Ophim\ThemeLegend;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemeLegendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/legend')
        ], 'legend-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'legend' => [
                'name' => 'Legend',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-legend',
                'publishes' => ['legend-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommended movies limit',
                        'type' => 'number',
                        'value' => 10,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 28,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 9,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Danh sách phim',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url',
                        'value' => "Phim chiếu rạp||is_shown_in_theater|1|8|/danh-sach/phim-chieu-rap\r\nPhim bộ mới cập nhật||type|series|12|/danh-sach/phim-bo\r\nPhim lẻ mới cập nhật||type|single|12|/danh-sach/phim-bo",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Danh sách hot',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => "Top phim lẻ||type|single|view_total|desc|9\r\nTop phim bộ||type|series|view_total|desc|9",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_update_left',
                        'label' => 'Movie Update - Col Left',
                        'type' => 'code',
                        'hint' => 'Label|image_url|show_more_url',
                        'value' => "Tuyển tập Marvel|https://1.bp.blogspot.com/-Me8nPHuQ1Ls/Xe2kMRMudZI/AAAAAAAAAtQ/yitov6AR38k4fk0oTxYxmxx8ukQ09mvKgCLcBGAsYHQ/s1600/Tuyen-Tap-Marvel.jpg|/tu-khoa/marvel\r\nTuyển tập DC|https://1.bp.blogspot.com/-6nuUg26KJOE/Xe2kMGJyJLI/AAAAAAAAAtM/kRmnjQqvwno2p-3AjP6bH-6dI-tS4waMACLcBGAsYHQ/s1600/Tuyen-Tap-DC.jpg|/tu-khoa/dc\r\nTuyển tập HBO|https://vtv1.mediacdn.vn/thumb_w/640/2020/6/10/lotr937-1591776067772382097733.png|/tu-khoa/hbo\r\nTuyển tập Netflix|https://1.bp.blogspot.com/-b2X634WI1Gc/YUTCsiCbh1I/AAAAAAAAJLs/BW-phIupygo-PvNzJXJ9VEFJXWwwoX-5wCLcBGAsYHQ/s16000/phim-netflix.jpg|/tu-khoa/netflix",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_update_right',
                        'label' => 'Movie Update - Col Right',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => "Phim lẻ mới||type|single|created_at|desc|11\r\nPhim bộ đang chiếu||type,status|series,ongoing|updated_at|desc|11\r\nPhim bộ hoàn thành||type,status|series,completed|updated_at|desc|11",
                        'attributes' => [
                            'rows' => 3
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <div class="bar">
                            <div class="bar-wrap">
                                <div class="links">
                                    <img src="https://ophim.cc/logo-ophim-5.png" alt="OPHIMCMS" />
                                    <br>
                                    <div class="copyright">Copyright 2022 © <a href="/" title="OPHIMCMS">OPHIMCMS</a>
                                        <br />
                                        <p>
                                            Xem phim mới miễn phí nhanh chất lượng cao. Phimmoi online Việt Sub, Thuyết minh, lồng tiếng chất lượng HD. Xem phim nhanh online chất lượng cao
                                        </p>
                                    </div>
                                </div>
                                <div class="textlink">
                                    <div class="hotlink">
                                        <h3 class="phimaz-foot">Phim Mới</h3>
                                        <a href="#" title="Phim Lẻ">Phim lẻ mới</a>
                                        <a href="#" title="Phim Bộ">Phim bộ mới</a>
                                        <a href="#" title="Phim chiếu rạp">Phim chiếu rạp</a>
                                        <a href="#" title="Phim sắp chiếu">Phim sắp chiếu</a>
                                        <a href="#" title="Phim thuyết minh">Phim thuyết minh</a>
                                    </div>
                                    <div class="hotlink">
                                        <h3 class="phimaz-foot">Phim Lẻ</h3>
                                        <a href="#" title="Phim Hành Động">Phim hành động</a>
                                        <a href="#" title="Phim kiếm hiệp">Phim kiếm hiệp</a>
                                        <a href="#" title="Phim kinh dị">Phim kinh dị</a>
                                        <a href="#" title="Phim viễn tưởng">Phim viễn tưởng</a>
                                        <a href="#" title="Phim hoạt hình">Phim hoạt hình</a>
                                    </div>
                                    <div class="hotlink">
                                        <h3 class="phimaz-foot">Phim Bộ</h3>
                                        <a href="#"
                                            title="Phim bộ Hàn Quốc">Phim bộ Hàn Quốc</a>
                                        <a href="#"
                                            title="Phim bộ Trung Quốc">Phim bộ Trung Quốc</a>
                                        <a href="#" title="Phim bộ Mỹ">Phim bộ Mỹ</a>
                                        <a href="#" title="Phim bộ Việt Nam">Phim bộ Việt Nam</a>
                                        <a href="#" title="Phim bộ Hồng Kông">Phim bộ Hồng Kông</a>
                                    </div>

                                </div>
                                <div class="social"><a href="#" class="call"><span data-icon="7" class="icon"></span>
                                        <span class="info"><span class="follow">Email liên hệ:</span>
                                            <span class="num"><span class="__cf_email__">email</span></span></span></a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
