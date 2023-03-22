import jQuery from 'jquery';
window.jQuery = jQuery;
window.$ = jQuery;

require('jquery.easing');

import LazyLoad from 'vanilla-lazyload';

var lazyLoadInstance = new LazyLoad({
    //
})
.loadAll();

import videojs from 'video.js';

import Dropzone from 'dropzone';
window.Dropzone = Dropzone;

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

document.addEventListener('DOMContentLoaded', function(event) {
    $(function() {
        $(window).scroll(function() {
            var scrollPercent = 100 * ($(window).scrollTop() - $('main').offset().top) / ($('main').height() - $(window).height());

            $('.dd-reading-progress-bar').css('width', scrollPercent + '%');
        })
        .scroll();

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $(document).on({
            mousemove: function(event) {
                $(':root').css({
                    '--dd-mouse-x': event.clientX + 'px',
                    '--dd-mouse-y': event.clientY + 'px',
                });
            }
        });

        var selectors = [
            'a',
            'button',
            '.dd-btn',
            '.dd-cursor-shape-animation',
            '.dropzone',
            '.dz-preview',
        ];

        $(document).on({
            mouseover: function(event) {
                $('#dd-cursor-shape').addClass('dd-cursor-shape-hover');

                if(
                    $(event.target).is(':disabled') ||
                    $(event.target).parents(':disabled').length ||
                    $(event.target).is('.disabled') ||
                    $(event.target).parents('.disabled').length
                ) {
                    $('#dd-cursor-shape').addClass('dd-cursor-shape-disabled');
                }
            },

            mouseout: function() {
                $('#dd-cursor-shape').removeClass('dd-cursor-shape-disabled dd-cursor-shape-hover');
            },

            mousedown: function(event) {
                if(
                    !$(event.target).is(':disabled') &&
                    !$(event.target).parents(':disabled').length &&
                    !$(event.target).is('.disabled') &&
                    !$(event.target).parents('.disabled').length
                ) {
                    $('#dd-cursor-shape').addClass('dd-cursor-shape-active');
                }
            },

            mouseup: function() {
                $('#dd-cursor-shape').removeClass('dd-cursor-shape-active');
            },
        }, selectors.join(', '));
    });
});
