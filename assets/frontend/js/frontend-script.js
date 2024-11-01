jQuery(document).ready(function($){
    
    var wpfrsl_reviews_slider = {};
    
    wow = new WOW();
    wow.init();

    wpfbr_slide_event();

    function wpfbr_slide_event(){
        $('.wpfrsl-slider-type, .wpfrsl-carousel-type').each(function () {
            
            wpfrsl_reviews_slider.id = $(this).bxSlider({
				pagerType: 'full',
				infiniteLoop: true,
                responsive: true,
				adaptiveHeight: true,
				stopAutoOnClick: true,
                touchEnabled: false,
            });    
        });
    }

    $('body').on('click', '.wpfrsl-pagination-wrapper .wpfrsl-page-link', function (e) {
        var selector = $(this);
    	$(this).closest('.wpfrsl-pagination-wrapper').find('.wpfrsl-page-link').removeClass('wpfrsl-current-page');
        $(this).addClass('wpfrsl-current-page');

        var post_id = $(this).data('review-id');
        var page_number = $(this).data('page-number');
        var total_page = $(this).data('total-page');
        var pagination_type = $(this).data('pagination-type');
        var template = $(this).data('template');
        var badge_template = $(this).data('badge-template');
        var layout_type = $(this).data('layout-type');

        $.ajax({
            type: 'post',
            url: wpfrsl_frontend_js_obj.ajax_url,
            data: {
                action: 'wpfrsl_review_pagination_ajax_action',
                _wpnonce: wpfrsl_frontend_js_obj.ajax_nonce,
                page_number: page_number,
                post_id: post_id,
                total_page: total_page,
                template: template,
                badge_template: badge_template,
                layout_type: layout_type
            },
            cache:false,
            beforeSend: function (xhr) {
                $('.wpfrsl-pagination-wrapper .wpfrsl-page-number-loader').show();
            },
            success: function (response) {
                $('.wpfrsl-pagination-wrapper .wpfrsl-page-number-loader').hide();
                
				selector.closest('.wpfrsl-wrap').find('.wpfrsl-main-wrap').html(response);

                var pagination_html = build_pagination_html(page_number, total_page, post_id, template, badge_template, layout_type);

               selector.closest('.wpfrsl-wrap').find('.wpfrsl-pagination-wrapper ul').html(pagination_html);
            }
        });
    });

    /**
    * Next Page Pagination
    *
    * @since 1.0.0
    */
    $('body').on('click', '.wpfrsl-next-page,.wpfrsl-previous-page', function () {
        var selector = $(this);
        var template = $(this).data('template');
        var badge_template = $(this).data('badge-template');
        var layout_type = $(this).data('layout-type');
        var post_id = $(this).data('review-id');
        var total_page = $(this).data('total-page');
        var current_page = $(this).closest('.wpfrsl-pagination-wrapper').find('.wpfrsl-current-page').data('page-number');
        var next_page = parseInt(current_page) + 1;
        var previous_page = parseInt(current_page) - 1;
        if (selector.hasClass('wpfrsl-previous-page')) {
            current_page = previous_page;
        } else {
            current_page = next_page;
        }

        $.ajax({
            type: 'post',
            url: wpfrsl_frontend_js_obj.ajax_url,
            data: {
                action: 'wpfrsl_review_pagination_ajax_action',
                _wpnonce: wpfrsl_frontend_js_obj.ajax_nonce,
                template: template,
                badge_template: badge_template,
                page_number: current_page,
                post_id: post_id,
                total_page : total_page,
                layout_type: layout_type
            },
            beforeSend: function (xhr) {
                $('.wpfrsl-pagination-wrapper .wpfrsl-page-number-loader').show();
            },
            success: function (response) {
                $('.wpfrsl-pagination-wrapper .wpfrsl-page-number-loader').hide();
                
				selector.closest('.wpfrsl-wrap').find('.wpfrsl-main-wrap').html(response);
                
                var pagination_html = build_pagination_html(current_page, total_page, post_id, template, badge_template, layout_type);
                selector.closest('.wpfrsl-wrap').find('.wpfrsl-pagination-wrapper ul').html(pagination_html);
            }
        });
    });

    function build_pagination_html(current_page, total_page, post_id, template, badge_template, layout_type) 
    {
        var pagination_html = '';

        if (current_page > 1) 
        {
            pagination_html += '<li class="wpfrsl-previous-page-wrap"><a href="javascript:void(0);" class="wpfrsl-previous-page" data-total-page="' + total_page + '" data-template="' + template + '" data-review-id="' + post_id + '" data-layout-type="' + layout_type + '" data-badge-template="' + badge_template + '">&lt;</a></li>';
        }

        var upper_limit = current_page + 2;
        var lower_limit = current_page - 2;
        
        if (upper_limit > total_page) 
            upper_limit = total_page;
        

        if (lower_limit < 1) 
            lower_limit = 1;
        
        if (upper_limit - lower_limit < 5 && upper_limit - 4 >= 1) 
            lower_limit = upper_limit - 4;
        
        if (upper_limit < 5 && total_page >= 5) 
            upper_limit = 5;
        

        for (var page_count = lower_limit; page_count <= upper_limit; page_count++) 
        {
            var page_class = (current_page == page_count) ? 'wpfrsl-current-page wpfrsl-page-link' : 'wpfrsl-page-link';
            pagination_html += '<li><a href="javascript:void(0);" data-total-page="' + total_page + '" data-page-number="' + page_count + '" class="' + page_class + '" data-template="' + template + '" data-review-id="' + post_id + '" data-layout-type="' + layout_type + '" data-badge-template="' + badge_template + '">' + page_count + '</a></li>';
        }
        
        if (current_page < total_page) 
        {
            pagination_html += '<li class="wpfrsl-next-page-wrap"><a href="javascript:void(0);" data-total-page="' + total_page + '" class="wpfrsl-next-page" data-template="' + template + '" data-review-id="' + post_id + '" data-layout-type="' + layout_type + '" data-badge-template="' + badge_template + '">&gt;</a></li>';
        }
        
        return pagination_html;
    }

    $('body').on('click', '.wpfrsl-load-more-trigger', function () {
        var $this = $(this);
        var template = $(this).data('template');
        var layout_type = $(this).data('layout-type');
        var page_number = $(this).data('page-number');
        var post_id = $(this).data('review-id');
        var total_page = $(this).data('total-page');
        var next_page = parseInt(page_number) + 1;
        if (next_page <= total_page) 
        {
            $.ajax({
                type: 'post',
                url: wpfrsl_frontend_js_obj.ajax_url,
                data: {
                    action: 'wpfrsl_review_pagination_ajax_action',
                    _wpnonce: wpfrsl_frontend_js_obj.ajax_nonce,
                    template: template,
                    page_number: next_page,
                    post_id: post_id,
                    total_page : total_page,
                    layout_type: layout_type
                },
                beforeSend: function (xhr) {
                    $(this).hide();
                    $(this).closest('.wpfrsl-load-more-block').find('.wpfrsl-ajax-loader').show();
                },
                success: function (response) {

                    $this.data('page-number', next_page);
                    $this.closest('.wpfrsl-load-more-block').find('.wpfrsl-ajax-loader').hide();
                    
                    $this.closest('.wpfrsl-wrap').find('.wpfrsl-main-wrap').find('.wpfrsl-show-reviews-wrap').append(response);
					if (next_page == total_page) 
                    {
                        $this.remove();
                    } 
                    else 
                    {
                        $this.show();
                    }
                }
            });
        } else {
            $this.remove();
        }
    });
    
    function wpfrsl_reset_data_index(selector) 
    {
        var count = 0;
        var total_items = selector.closest('.eg-wrap').find('a[data-lightbox-type]').length;
        selector.closest('.eg-wrap').find('a[data-lightbox-type]').each(function () {
            count++;

            $(this).attr('data-index', count);
            $(this).data('index', count);
            $(this).attr('data-total-items', total_items);
            $(this).data('total-items', total_items);
        });
    }

    $('body').on('click','.wpfrsl-read-more', function(){
        $(this).parent('.wpfrsl-small-description').slideUp(400);
        $(this).closest('.wpfrsl-content-reviews-wrapper').find('.wpfrsl-full-description').slideDown(400);
        $(this).closest('.bx-viewport').css('height','100%');
        return false;
    });
    $('body').on('click','.wpfrsl-read-less', function(){
        $(this).parent('.wpfrsl-full-description').slideUp(400);
        $(this).closest('.wpfrsl-content-reviews-wrapper').find('.wpfrsl-small-description').slideDown(400);
        return false;        
    });
    
});