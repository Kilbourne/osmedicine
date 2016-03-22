/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

    // Use this variable to set up the common and page specific functions. If you
    // rename this variable, you will also need to rename the namespace below.
    var Sage = {
        // All pages
        'common': {
            init: function() {
              deBouncer($,'smartresize', 'resize', 50);

            },
            finalize: function() {
              setTimeout(function(){$('.hvr-sweep-to-right').addClass('animate');},200);
            }
        },
        // Home page
        'home': {
            init: function() {
              var equal=function(){return equalizeHeight(['.other-post-list li .article-image-wrapper','.other-post-list li .article-content-wrapper .entry-title']);}
                  enquire.register("screen and (min-width:45em)", {
                    match : function() {
                      equal();
                      $(window).smartresize(function(){equal();});
                    },
                    unmatch : function() {
                      $(window).off("smartresize", equal);
                      $('.other-post-list li .article-image-wrapper,.other-post-list li .article-content-wrapper .entry-title').css('height','');
                    },
                  });

            }
        },
        'page_template_profile_page': {
          init: function() {
            $('.code_check_button').click(validateCode);
              function validateCode(e) {
                var target = $(e.target),
                    //fieldGroup = target.closest('.acf-fields'),
                    //subsiteField = $('#subsite'),
                    //subsiteOptions = subsiteField.find('option'),
                    //subsite = subsiteField.val(),
                    //subsiteName = subsiteField.children('option:selected').data('slug'),
                    //subsiteName2 = subsiteField.children('option:selected').text(),
                    codeField = $('#code'),
                    groupField=$('.insert-code-wrapper'),
                    code = codeField.val();
                    target.addClass('visible');
                    //acf.fields.repeater.o.max = subsiteOptions.length;

                    function removeOption(record) {
                      //if ($(this).text() === subsiteName2) { $(this).remove(); }
                    }
                    $.post(
                      OSM.ajaxurl, {
                          action: 'validate_code',
                          //subsite_id: subsite,
                          //subsite: subsiteName,
                          code: code,
                          _nonce: OSM.nonce,
                      },
                      function(response) {
                        groupField.children('.response').remove();
                        target.removeClass('visible');
                        ///subsiteField.add(target)
                        target.attr('disabled', 'disabled');
                        var data= !!response.data.data?response.data.data:response.data;
                        groupField.append('<div class="response">' + data + '</div>');
                        if (response.success) {
                            codeField.val('');
                            var subsiteName2 = response.data.name,
                                newAbilitation=$('<li class="last" ><span>'+subsiteName2+'</span> - <span> <a href="'+response.data.url+'"">Vai al sito</a> </span><li>');
                            if(!$('.registered-areas').length){
                                var registeredArea=$('<div class="registered-areas upme-profile-tab-panel"><h4 class="upme-separator">Sottoaree abilitate</h4><ul class="registered-areas-list"></ul></div>');
                                registeredArea.hide();
                                registeredList=registeredArea.children('.registered-areas-list');
                                newAbilitation.appendTo(registeredList);
                                registeredArea.appendTo('.subsite-invites-section').show('slow');
                            }else{
                                newAbilitation.removeClass('last').appendTo('.registered-areas-list')
                            }
                            //subsiteField.children('option').each(removeOption);
                            //if(!subsiteField.children('option').length){
                              //  groupField.delay(1200).hide(1200).remove();
                            //}else{
                                groupField.children('.response').delay(1200).hide(1200).remove();
                                //subsiteField.add(target)
                                target.removeAttr('disabled');
                            //}
                        }
                      }
                  );
                }
            }
        },
        'single_post': {
            init: function() {
              var equal=function(){return equalizeHeight(['.related-post-img-wrap']);}
              enquire.register("screen and (min-width:45em)", {
                match : function() {
                  equal();
                  $(window).smartresize(function(){equal();});},
                unmatch : function() {
                  $(window).off("smartresize", equal);
                  $('.related-post-img-wrap').css('height',' ');
                },
              });
            }
      }
};

    // The routing fires all common scripts, followed by the page specific scripts.
    // Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function(func, funcname, args) {
            var fire;
            var namespace = Sage;
            funcname = (funcname === undefined) ? 'init' : funcname;
            fire = func !== '';
            fire = fire && namespace[func];
            fire = fire && typeof namespace[func][funcname] === 'function';

            if (fire) {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function() {
            // Fire common init JS
            UTIL.fire('common');

            // Fire page-specific init JS, and then finalize JS
            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
                UTIL.fire(classnm);
                UTIL.fire(classnm, 'finalize');
            });

            // Fire common finalize JS
            UTIL.fire('common', 'finalize');
        }
    };

    // Load Events
    $(document).ready(UTIL.loadEvents);

 function deBouncer($,cf,of, interval){
    // deBouncer by hnldesign.nl
    // based on code by Paul Irish and the original debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
        var timeout;
        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            }
            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);
            timeout = setTimeout(delayed, threshold || interval);
        };
    };
    jQuery.fn[cf] = function(fn){  return fn ? this.bind(of, debounce(fn)) : this.trigger(cf); };
};
    function equalizeHeight(selector){
      var n,l;
      for(n=0,l=selector.length;n<l;n++){
        var widthArr = [];
        $(selector[n]).each(function(i) {
            $(this).css("height",'');
            var height = $(this).height() + 1;
            widthArr.push(height);

        });
        var final = Math.max.apply(null, widthArr);
        $(selector[n]).css("height",final);

    }}

})(jQuery); // Fully reference jQuery after this point.
