jQuery(document).ready(function($) {

	$('div.wpfrsl-nav-tab-wrapper a').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('.wpfrsl-content').hide();
		$('div.wpfrsl-nav-tab-wrapper a').removeClass('wpfrsl-nav-tab-active');
		$(this).addClass('wpfrsl-nav-tab-active');
		$("#"+tab_id).show();
	});

	/* 
    * Case 1: Tab Settings
    */
    $('ul.wpfrsl-nav-tabs li a').click(function(){
	    
	    var tab_id = $(this).attr('data-tab');
	    $('ul.wpfrsl-nav-tabs li').removeClass('current');
	    $('.wpfrsl-tab-content').hide().removeClass('current');
	    $(this).parent().addClass('current');
	    $("#"+tab_id).fadeIn('300').addClass('current');
	    if(tab_id == "aboutus" || tab_id == "howtouse" || tab_id == "shortcode_usage"){
	      $('.wpfrsl-form-actions-wrap').hide();
	    }
	    else{
	       $('.wpfrsl-form-actions-wrap').show();
	    }
	 });

    $("#wpfrsl_meta_enable_ranimation").change(function() {
        if($(this).prop('checked') == true) 
        {
               $('.wpfrsl-review-animation').slideDown('slow');
        } else {
               $('.wpfrsl-review-animation').slideUp('slow');
        }
    });

    if($('#wpfrsl_meta_enable_ranimation').attr('checked')) {
       $('.wpfrsl-review-animation').show();
     } else {
       $('.wpfrsl-review-animation').hide();
    }

    /**
     * Layout type show & hide configuration
     *
     */
    var layouttype = $('body').find('.wpfrsl-layout-type').val();
    if(layouttype == 'list_type')
    {
      $('body').find('#wpfrsl-list-template-select').trigger('change');
      $('body').find('#list_type_template_select').show();
    }
    else if(layouttype == 'slide_type')
    {
      $('body').find('#wpfrsl-slide-template-select').trigger('change');
      $('body').find('#slider_type_template_select').show();
    }
    else if(layouttype == 'grid_type')
    {
      $('body').find('#wpfrsl-grid-template-select').trigger('change');
      $('body').find('#grid_type_template_select').show();
    }
    else if(layouttype == 'carousel')
    {
      $('body').find('#wpfrsl-carousel-template-select').trigger('change');
      $('body').find('#carousel_type_template_select').show();
    }
    
    $(".wpfrsl-layout-type").on('change', function() {
      
        var layout_type = $(this).val();
        $('body').find('.template_select').hide();
        if(layout_type == 'list_type')
        {
          $('body').find('#wpfrsl-list-template-select').trigger('change');
          $('body').find('#list_type_template_select').show();
        }
        else if(layout_type == 'slide_type')
        {
          $('body').find('#wpfrsl-slide-template-select').trigger('change');
          $('body').find('#slider_type_template_select').show();
        }
        else if(layout_type == 'grid_type')
        {
          $('body').find('#wpfrsl-grid-template-select').trigger('change');
          $('body').find('#grid_type_template_select').show();
        }
        else if(layout_type == 'carousel')
        {
          $('body').find('#wpfrsl-carousel-template-select').trigger('change');
          $('body').find('#carousel_type_template_select').show();
        }

       if ($(this).val() === "list_type" || $(this).val() === 'grid_type')
        {
           $('.wpfrsl-slider-setting-wrapper').slideUp('slow');
           $('.wpfrsl-carousel-settings-wrap').slideUp('slow');
           $('.wpfrsl-pagination-settings-wrap').slideDown('slow');
        }
        else if($(this).val() === "slide_type" || $(this).val() === 'carousel' )
        {
           $('.wpfrsl-slider-setting-wrapper').slideDown('slow');
           $('.wpfrsl-pagination-settings-wrap').slideUp('slow');
           if($(this).val() === 'carousel')
           {
              $('.wpfrsl-carousel-settings-wrap').slideDown('slow');
           }
        }
        else
        {
          $('.wpfrsl-pagination-settings-wrap').hide(); 
          $('.wpfrsl-slider-setting-wrapper').hide();
          $('.wpfrsl-carousel-settings-wrap').hide();
        }
    });

    var selected_layout_type = $(".wpfrsl-layout-type option:selected").val();
    if (selected_layout_type === "list_type" || selected_layout_type === "grid_type" )
    {
    	$('.wpfrsl-slider-setting-wrapper').hide();
      $('.wpfrsl-pagination-settings-wrap').show();
      $('.wpfrsl-carousel-settings-wrap').hide();
    }
    else if(selected_layout_type === "slide_type" || selected_layout_type === "carousel")
    {
        $('.wpfrsl-slider-setting-wrapper').show();
        $('.wpfrsl-pagination-settings-wrap').hide();   
        if(selected_layout_type === "carousel")
        {
          $('.wpfrsl-carousel-settings-wrap').show();
        }
    }
    else
    {
        $('.wpfrsl-slider-setting-wrapper').hide();
        $('.wpfrsl-pagination-settings-wrap').hide();
        $('.wpfrsl-carousel-settings-wrap').hide();
    }
    
    // Show/Toggle Slider settings 
    $('body').on('click', '.wpfrsl-slider-toogle-outer-wrap', function() {
        $(this).closest('.wpfrsl-layout-setting-wrap').find('.wpfrsl-slider-setting-inner-wrap').slideToggle();
        $(this).find('.dashicons').toggleClass('dashicons-arrow-down dashicons-arrow-up');
    });

    // Show / Toggle Carousel Setting
    $('body').on('click', '.wpfrsl-carousel-toggle-wrap', function() {
        $(this).closest('.wpfrsl-carousel-settings-wrap').find('.wpfrsl-carousel-setting-inner-wrap').slideToggle();
        $(this).find('.dashicons').toggleClass('dashicons-arrow-down dashicons-arrow-up');
    });

    $('.wpfrsl_slider_pager_type').change(function(){
	    $('.pager_type_preview').slideToggle(); 
	});

	$(".slider_controls_show").change(function() {
      if ($(this).val() === "true")
      {
        $('.controls_type_preview').slideDown('slow');
      }
      else
      {
        $('.controls_type_preview').slideUp('slow');
      }
    });

    $("#wpfrsl_meta_enable_banimation").change(function() {
        if($(this).prop('checked') == true) 
        {
          $('.wpfrsl-badge-animation').slideDown('slow');
        } else {
          $('.wpfrsl-badge-animation').slideUp('slow');
        }
    });

    if($('#wpfrsl_meta_enable_banimation').attr('checked')) {
       $('.wpfrsl-badge-animation').show();
     } else {
       $('.wpfrsl-badge-animation').hide();
    }
    
    
    
    $('#wpfrsl-app-id, #wpfrsl-app-secret').on('keyup', function(){
      
      var fb_app_id = $('body').find('#wpfrsl-app-id').val();
      var fb_app_secret = $('#wpfrsl-app-secret').val();

      if(fb_app_id != '' && fb_app_secret != '' )
      {
        $(this).closest('.wpfrsl-main-wrap').find('.wpfrsl_api_fb_login_wrap').show();
      }
      else if(fb_app_id == '' || fb_app_secret == '')
      {
        $(this).closest('.wpfrsl-main-wrap').find('.wpfrsl_api_fb_login_wrap').hide(); 
      }
    });


    //Display the Review Retrieved after login btn is clicked 
    $('body').on('change', '#wpfrsl_fbpage_select',function() {
      var id_pagename = $(this).val();
      var split = id_pagename.split("_");
      var fb_page_id = split[0];
      var fb_page_name = split[1];
      $('body').find('#wpfrsl-retrieved-reviews').remove();

      $.ajax({
            type: 'post',
            url: wpfrsl_backend_js_obj.ajax_url,
            data: {
                action: 'wpfrsl_ajax_download_review',
                _wpnonce: wpfrsl_backend_js_obj.ajax_nonce,
                fb_page_id: fb_page_id,
                fb_page_name: fb_page_name
            },
            beforeSend: function (xhr) {
              $('body').find('#wpfrsl-ajax-download-loader').show();
            },
            success: function (response) {
              $('body').find('#wpfrsl-ajax-download-loader').hide();
              if ((response != 'empty') && (response.length > 0)) {
                var hidden_field = "<label>Reviews Retrieved</label><textarea class='wpfrsl-hidden-display' name='wpfrsl_api_settings[downloaded_reviews]'>"+response+"</textarea>";
                $('body').find('#wpfrsl-download-review-response').html(hidden_field);
              }
              else{
                $('body').find('#wpfrsl-download-review-response').html('Something went wrong while trying to retrieve reviews. Please try again.');
              }
            }
      }); 
    });

    //Display Review Retrieved after post is saved
    $('body').on('change', '#wpfrsl_select_fbpage',function() {
      var id_pagename = $(this).val();
      var split = id_pagename.split("_");
      var fb_page_id = split[0];
      var fb_page_name = split[1];
      $('body').find('#wpfrsl-retrieved-reviews').empty();

      $.ajax({
            type: 'post',
            url: wpfrsl_backend_js_obj.ajax_url,
            data: {
                action: 'wpfrsl_ajax_download_review',
                _wpnonce: wpfrsl_backend_js_obj.ajax_nonce,
                fb_page_id: fb_page_id,
                fb_page_name: fb_page_name
            },
            beforeSend: function (xhr) {
              $('body').find('#wpfrsl-ajax-review-loader').show();
            },
            success: function (response) {
              $('body').find('#wpfrsl-ajax-review-loader').hide();
              if ((response != 'empty') && (response.length > 0)) 
              {
                var hidden_field = "<label>Reviews Retrieved</label><textarea class='wpfrsl-hidden-display' name='wpfrsl_api_settings[downloaded_reviews]'>"+response+"</textarea>";
                $('body').find('#wpfrsl-retrieved-reviews').html(hidden_field);
              }
              else
              {
                $('body').find('#wpfrsl-retrieved-reviews').html('Something went wrong while trying to retrieve reviews. Please try again.');
              }
            }
      }); 
    });

  $('body').on('change','#wpfrsl-list-template-select' , function(){
    var selected_tmp_img = $(this).find('option:selected').data('img');
    $(this).closest('.wpfrsl-template-section').find('.wpfrsl-template-image img').attr('src', selected_tmp_img);
  });

  $('body').on('change','#wpfrsl-slide-template-select' , function(){
    var selected_tmp_img = $(this).find('option:selected').data('img');
    $(this).closest('.wpfrsl-template-section').find('.wpfrsl-template-image img').attr('src', selected_tmp_img);
  });

  $('body').on('change','#wpfrsl-grid-template-select' , function(){
    var selected_tmp_img = $(this).find('option:selected').data('img');
    $(this).closest('.wpfrsl-template-section').find('.wpfrsl-template-image img').attr('src', selected_tmp_img);
  });

  $('body').on('change','#wpfrsl-carousel-template-select' , function(){
    var selected_tmp_img = $(this).find('option:selected').data('img');
    $(this).closest('.wpfrsl-template-section').find('.wpfrsl-template-image img').attr('src', selected_tmp_img);
  });

  $('body').on('change','#wpfrsl-badge-template-select' , function(){
    var selected_tmp_img = $(this).find('option:selected').data('img');
    $(this).closest('.wpfrsl-badge-temp').find('.wpfrsl-badge-template-image img').attr('src', selected_tmp_img);
  });

  /*
    * Get facebook pages using graph api
    */
     $('body').on('click','#wpfrsl_fb_get_pages', function (e) {
      "use strict";
        e.preventDefault();
        var fgraph_appid = $('.wpfrs-page-name').val();
        var fgraph_appsecret = $('.wpfrs-page-id').val();
        var fgraph_usertoken = $('.wpfrs-page-token').val();
        if(fgraph_appid === '' || fgraph_appsecret === '' || fgraph_usertoken === ''){
         alert('Please fill App ID, App Secret and User Token fields!');
        } else {
           $.ajax({
            type: 'post',
            url: wpfrsl_backend_js_obj.ajax_url,
            data: {
                fgraph_appid: fgraph_appid,
                fgraph_appsecret: fgraph_appsecret,
                fgraph_usertoken: fgraph_usertoken,
                action: 'asap_get_fbgraph_pages_action',
                _wpnonce: wpfrsl_backend_js_obj.ajax_nonce
            },
            beforeSend: function (xhr) {
                // $('.asap-ajax-loader').css('visibility','visible');
                // $('.asap-ajax-loader').css('opacity',1);
            },
            success: function (resp) {
              console.log(resp);
                // $('.asap-ajax-loader').css('visibility','hidden');
                // $('.asap-ajax-loader').css('opacity',0);
                if(resp.success == false){
                    $('#asap-error-msg').html('An error occured. Please try again after you have filled the APP ID, APP Secret and User Access Token correctly').css({color:'red'});
                } else {
          var result = $.parseJSON(resp.data);
          if(result.error){
             $('#asap-error-msg').html('An error occured. Please fill in the correct APP ID and APP Secret or renew your User Access Token and try again.').css({color:'red'});
          } else {
            $('#asap-error-msg').html('The pages managed by you were fetched successfully.').css({color:'green'}).delay(1000).fadeOut();
            var dropdown = $('#wpfrsl-graph-pages-select');
            var allJson = $('#wpfrsl-graph-pages-all-json');
            dropdown.empty();
            allJson.empty();
            $.each(result.data, function(index, curItem) {
              dropdown.append($("<option data-page-token=''></option>").attr('value', curItem.id).data('page-token', curItem.access_token).text(curItem.name));
            });
            allJson.append(resp.data);
          }
                }
            }
        });
        }
      });
	
});	

function fbrev_init(data) {

  var el = document.querySelector('#' + data.widgetId);
  if (!el) return;

  var fbConnectBtn = el.querySelector('#fb_connect');
  WPacFastjs.on(fbConnectBtn, 'click', function() {
    fbrev_connect(el, data);
    return false;
  });
}

function fbrev_popup(url, width, height, cb) {
    var top = top || (screen.height/2)-(height/2),
        left = left || (screen.width/2)-(width/2),
        win = window.open(url, '', 'location=1,status=1,resizable=yes,width='+width+',height='+height+',top='+top+',left='+left);
    function check() {
        if (!win || win.closed != false) {
            cb();
        } else {
            setTimeout(check, 100);
        }
    }
    setTimeout(check, 100);
}

function fbrev_connect(el, data) {

  fbrev_popup('https://app.widgetpack.com/auth/fbrev?scope=manage_pages,pages_show_list', 670, 520, function() {
      WPacXDM.get('https://embed.widgetpack.com', 'https://app.widgetpack.com/widget/facebook/accesstoken', {}, function(res) {
          WPacFastjs.jsonp('https://graph.facebook.com/me/accounts', {access_token: res.accessToken, limit: 250}, function(res) {

              var pagesEl = el.querySelector('.wpfrs-pages'),
                  idEl = el.querySelector('.wpfrs-page-id'),
                  nameEl = el.querySelector('.wpfrs-page-name'),
                  tokenEl = el.querySelector('.wpfrs-page-token'),
                  businessPhoto = el.querySelector('.wpfrs-business-photo'),
                  businessPhotoImg = el.querySelector('.wpfrs-business-photo-img');

              WPacFastjs.each(res.data, function(page) {

                  var pageEL = WPacFastjs.create('div', 'wpfrs-page');
                  pageEL.innerHTML = '<img src="https://graph.facebook.com/' + page.id +  '/picture" class="wpfrs-page-photo">' +
                                     '<div class="wpfrs-page-name">' + page.name + '</div>';
                  pagesEl.appendChild(pageEL);

                  WPacFastjs.on(pageEL, 'click', function() {
                      idEl.value = page.id;
                      nameEl.value = page.name;
                      tokenEl.value = page.access_token;
                      jQuery(tokenEl).change();

                      if (businessPhoto) 
                      {
                          businessPhoto.value = '';
                          businessPhotoImg.src = 'https://graph.facebook.com/' + page.id +  '/picture';
                          WPacFastjs.show2(businessPhotoImg);
                      }

                      WPacFastjs.remcl(pagesEl.querySelector('.active'), 'active');
                      WPacFastjs.addcl(pageEL, 'active');

                      data.cb && data.cb();
                      return false;
                  });
              });
          });
      });
  });
  return false;
}