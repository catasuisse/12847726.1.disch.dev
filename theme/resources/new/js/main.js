import jQuery from 'jquery';
window.jQuery = jQuery;
window.$ = jQuery;

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

import LocomotiveScroll from 'locomotive-scroll';

const scroll = new LocomotiveScroll({
    el: document.querySelector('[data-scroll-container]'),
    firefoxMultiplier: 125,
    getDirection: true,
    multiplier: 2.5,
    repeat: true,
    smooth: true,
});

window.scroll = scroll;

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

import LazyLoad from 'vanilla-lazyload';

var lazyLoadInstance = new LazyLoad({
    //
})
.loadAll();

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

import videojs from 'video.js';

videojs.addLanguage('de', {
    'Play Video': 'Abspielen',
});

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

import autosize from 'autosize';

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

import Dropzone from 'dropzone';

window.Dropzone = Dropzone;

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

import { Fancybox } from "@fancyapps/ui";

Fancybox.bind('[data-fancybox]', {
    
});

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

var timer = [];

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

document.addEventListener('DOMContentLoaded', function(event) {
    document.body.addEventListener('touchstart', function() {
        //
    }, {
        passive: true
    });

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    if('ontouchstart' in document.documentElement) {
        $('body').addClass('dd-device-touch');
    } else {
        $('body').addClass('dd-device-click');
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    $(function() {
        if(!sessionStorage['cookies_is_hidden']) {
            $('.dd-cookies').removeClass('dd-hidden');
        }

        $('.dd-cookies [data-confirm]').click(function() {
            var $this = $(this);

            sessionStorage['cookies_is_hidden'] = true;

            $this
                .closest('.dd-cookies')
                .addClass('dd-hidden');
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        function updateTables() {
            $('table').each(function() {
                var labels = [];
                var table = $(this);
    
                $('th', table).each(function(index) {
                    labels[index] = $(this).html();
                });
    
                $('tr', table).each(function() {
                    $('td', $(this)).each(function(index) {
                        $(this).attr('data-label', labels[index]);
                    });
    
                    if($(this).is(':last-child') && $(this).is('.dd-content')) {
                        table.addClass('dd-mb-0');
                    }
                });
            });
        }

        updateTables();

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $('#dd-nav-toggler').click(function() {
            if($(window).width() < 992) {
                $('#dd-logo-nav-wrapper').toggleClass('dd-nav-visible');
                $('#dd-nav-primary-wrapper').toggleClass('dd-visible');
                $('#dd-nav-toggler').toggleClass('dd-active');
            }
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $('.dd-checkbox-wrapper.dd-active').each(function() {
            $(this)
                .closest('form')
                .addClass('dd-checkbox-is-active');
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $('textarea').each(function() {
            autosize(this);
        }).on('autosize:resized', function() {
            scroll.update();
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $('[data-href]').click(function(event) {
            if(!$(event.target).is('a')) {
                event.preventDefault();

                var $this = $(this);

                window.open($this.attr('data-href'), $this.attr('data-target'));
            }
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $('[data-target]').click(function(event) {
            if(!$(event.target).is('[data-href]')) {
                scroll.scrollTo($(this).attr('data-target'), {
                    duration: 250,
                });
            };
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        function setConsistentHeights() {
            if(!$('.dd-h-consistent').length) {
                return false;
            }

            $('.dd-h-consistent > *').css('height', '');

            $('.dd-h-consistent').each(function() {
                var maxHeight = 0;
                var parent = $(this);

                $('> *', parent).css('height', '');

                $('> *', parent).each(function() {
                    var childHeight = $(this).outerHeight();

                    if(childHeight > maxHeight) {
                        maxHeight = childHeight;
                    }
                });

                $('> *', parent).css('height', maxHeight);
            });

            scroll.update();
        }

        setConsistentHeights();

        $(window).on('resize', function() {
            setConsistentHeights();
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        var clientX = $(window).width() * .5;
        var clientY = $(window).height() * .5;
        var pageX = $(window).width() * .5;
        var pageY = $(window).height() * .5;

        $(document).on({
            mousemove: function(event) {
                clearTimeout(timer[0]);

                $('body').addClass('dd-cursor-moving');

                timer[0] = setTimeout(function() {
                    $('body').removeClass('dd-cursor-moving');
                }, 4000);

                var $tooltip = $('#dd-tooltip');

                clientX = event.clientX;
                clientY = event.clientY;
                pageX = event.pageX;
                pageY = event.pageY;

                $tooltip.removeClass('dd-right-aligned');

                if($tooltip.offset().left + $tooltip.width() > $(window).width()) {
                    $tooltip.addClass('dd-right-aligned');
                }
            }
        });

        var clientShapeX = $(window).width() * .5;
        var clientShapeY = $(window).height() * .5;
        var pageShapeX = $(window).width() * .5;
        var pageShapeY = $(window).height() * .5;

        setInterval(function() {
            clientShapeX += (clientX - clientShapeX) * .125;
            clientShapeY += (clientY - clientShapeY) * .125;
            pageShapeX += (pageX - pageShapeX) * .125;
            pageShapeY += (pageY - pageShapeY) * .125;

            $(':root').css({
                '--dd-client-x': clientShapeX + 'px',
                '--dd-client-y': clientShapeY + 'px',
                '--dd-page-x': pageShapeX + 'px',
                '--dd-page-y': pageShapeY + 'px',
            });
        }, 12.5);

        var selectors = [
            'a',
            'button',
            'input',
            'textarea',
            '[data-href]',
            '.dd-checkbox-wrapper',
            '.dz-preview',
            '.video-js',
        ];

        $(document).on({
            mouseover: function(event) {
                $('#dd-clock-cursor, #dd-cursor-shape').addClass('dd-hover');

                if(
                    $(event.target).is(':disabled') ||
                    $(event.target).parents(':disabled').length ||
                    $(event.target).is('.dd-disabled') ||
                    $(event.target).parents('.dd-disabled').length
                ) {
                    $('#dd-clock-cursor, #dd-cursor-shape').addClass('dd-disabled');
                }
            },

            mouseout: function() {
                $('#dd-clock-cursor, #dd-cursor-shape').removeClass('dd-disabled dd-hover');
            },

            mousedown: function(event) {
                if(
                    !$(event.target).is(':disabled') &&
                    !$(event.target).parents(':disabled').length &&
                    !$(event.target).is('.dd-disabled') &&
                    !$(event.target).parents('.dd-disabled').length
                ) {
                    $('#dd-clock-cursor, #dd-cursor-shape').addClass('dd-active');
                }
            },

            mouseup: function() {
                $('#dd-clock-cursor, #dd-cursor-shape').removeClass('dd-active');
            },
        }, selectors.join(', '));

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        function showTooltip(target) {
            clearTimeout(timer[1]);

            var $tooltip = $('#dd-tooltip');

            if(target.is('svg')) {
                target.attr('data-title', target.find('title').text());

                target.find('title').text(null);
            } else {
                target.attr('data-title', target.attr('title'));

                target.attr('title', null);
            }

            if(
                !target.is('[data-tooltip]') ||
                target.parents('a[data-tooltip]').length ||
                (
                    !target.find('title').length &&
                    target.is('svg')
                    
                )
            ) {
                return false;
            }

            $tooltip.removeClass('dd-target-is-anchor');
            $tooltip.text(null);

            $tooltip.text(target.attr('data-title'));

            if(target.is('a')) {
                $tooltip.addClass('dd-target-is-anchor');
            }

            $tooltip.addClass('dd-visible');
        }

        function hideTooltip(target) {
            clearTimeout(timer[1]);

            var $tooltip = $('#dd-tooltip');

            $tooltip.removeClass('dd-visible');

            if(target.is('svg')) {
                target.find('title').text(target.attr('data-title'));

                target.attr('data-title', null);
            } else {
                target.attr('title', target.attr('data-title'));

                target.attr('data-title', null);
            }

            timer[1] = setTimeout(function() {
                $tooltip.removeClass('dd-target-is-anchor');
                $tooltip.text(null);
            }, 250);
        }

        $('[title], svg').hover(function() {
            if($(window).width() >= 1200) {
                showTooltip($(this));
            } else {
                hideTooltip($(this));
            }
        }, function() {
            hideTooltip($(this));
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $(document).on({
            keyup: function(event) {
                if(event.which == 13) {
                    if(!$('textarea:focus').length) {
                        var form = $(':focus').closest('form');

                        if(form.find('[data-action="submit"]').length) {
                            form.submit();
                        }
                    }
                }
            },
        });

        $('.dd-form-group').on('mouseover', function() {
            $(this)
                .addClass('dd-hover');
        });

        $('.dd-form-group').on('mouseout', function() {
            $(this)
                .removeClass('dd-hover');
        });

        $('.dd-form-group').on('click', function() {
            $(this)
                .find('input, textarea')
                .focus();
        });

        $('input, textarea').on('focus', function() {
            $(this)
                .closest('.dd-form-group')
                .addClass('dd-focus');
        });

        $('input, textarea').on('blur', function() {
            $(this)
                .closest('.dd-form-group')
                .removeClass('dd-focus');
        });

        $('.dd-checkbox-wrapper').on('click', function() {
            var $this = $(this);

            var form = $this.closest('form');

            var input = form.find('[name="' + $this.attr('data-name') + '"]');

            if(input.val() == 1) {
                input.val(0);
            } else {
                input.val(1);
            }

            $this
                .toggleClass('dd-active');

            if($('.dd-checkbox-wrapper.dd-active', form).length) {
                form.addClass('dd-checkbox-is-active');
            } else {
                form.removeClass('dd-checkbox-is-active');
            }
        });

        $('[data-action="submit"]').click(function() {
            $(this)
                .closest('form')
                .submit();
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($('.dd-exhibits').length) {
            $('.dd-exhibits').each(function() {
                if($('.dd-exhibits .dd-exhibit-loader-wrapper').length) {
                    var $this = $(this);

                    if($('.dd-exhibit:hidden', $this).length) {
                        $('.dd-exhibit-loader-wrapper .dd-exhibit-loader', $this).removeClass('dd-d-none');
                    } else {
                        // $('.dd-exhibit-loader-wrapper .dd-call-to-action', $this).removeClass('dd-d-none');
                    }

                    if(!$('.dd-exhibit-loader-wrapper > *:visible', $this).length) {
                        $('.dd-exhibit-loader-wrapper', $this).remove();
                    }

                    scroll.update();
                }
            });

            $('.dd-exhibit-loader').click(function(event) {
                event.preventDefault();

                var $this = $(this);

                var exhibits = $this.closest('.dd-exhibits');

                var loadedItems = 3;

                if(exhibits.is('[data-visible-items]')) {
                    loadedItems = exhibits.attr('data-visible-items');
                }

                $('.dd-exhibit:hidden', exhibits)
                    .slice(0, loadedItems)
                    .removeClass('dd-d-none');

                if(!$('.dd-exhibit:hidden', exhibits).length) {
                    $('.dd-exhibit-loader-wrapper .dd-exhibit-loader', exhibits).addClass('dd-d-none');

                    // $('.dd-exhibit-loader-wrapper .dd-call-to-action', exhibits).removeClass('dd-d-none');
                } else {
                    // $('.dd-exhibit-loader-wrapper .dd-call-to-action', exhibits).addClass('dd-d-none');

                    $('.dd-exhibit-loader-wrapper .dd-exhibit-loader', exhibits).removeClass('dd-d-none');
                }

                if(!$('.dd-exhibit-loader-wrapper > *:visible', exhibits).length) {
                    $('.dd-exhibit-loader-wrapper', exhibits).remove();
                }

                scroll.update();
            });
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        var medias = Array.prototype.slice.apply(document.querySelectorAll('audio, video'));

        medias.forEach(function(media) {
            media.addEventListener('play', function(event) {
                medias.forEach(function(media) {
                    if(media != event.target) {
                        media.pause();
                    }
                });
            });
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */
    
        if($('#dd-section-contact-form').length) {
            $('#dd-section-contact-form form').submit(function(event) {
                event.preventDefault();
    
                var $this = $(this);
    
                var alerts = $this.prev('.dd-alerts');
                var fields = [];
                var error = false;
    
                fields['article'] = $this.find('[name="article"]');
                fields['city'] = $this.find('[name="city"]');
                fields['content'] = $this.find('[name="content"]');
                fields['email'] = $this.find('[name="email"]');
                fields['firstname'] = $this.find('[name="firstname"]');
                fields['honeypot'] = $this.find('[name="honeypot"]');
                fields['lastname'] = $this.find('[name="lastname"]');
                fields['postal_code'] = $this.find('[name="postal_code"]');
                fields['referer'] = $this.find('[name="referer"]');
                fields['street'] = $this.find('[name="street"]');
                fields['telephone'] = $this.find('[name="telephone"]');
    
                $this
                    .find('.dd-form-group')
                    .removeClass('dd-invalid');
    
                alerts
                    .empty()
                    .hide();
                
                fields['city']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
    
                fields['content']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
                
                fields['email']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
                
                fields['firstname']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
                
                fields['lastname']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
                
                fields['postal_code']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
                
                fields['street']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
                
                fields['telephone']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
    
                scroll.update();
    
                scroll.scrollTo('#dd-section-contact-form', {
                    duration: 250,
                    offset: -250,
                });
    
                if(!fields['content'].val()) {
                    error = true;
    
                    fields['content']
                        .closest('.dd-form-group')
                        .addClass('dd-invalid')
                        .find('.dd-alert')
                        .text('Diese Angabe wird benötigt.')
                }
    
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    
                if(!regex.test(fields['email'].val())) {
                    error = true;
    
                    fields['email']
                        .closest('.dd-form-group')
                        .addClass('dd-invalid')
                        .find('.dd-alert')
                        .text('Diese Angabe ist fehlerhaft.')
                }
    
                if(!fields['email'].val()) {
                    error = true;
    
                    fields['email']
                        .closest('.dd-form-group')
                        .addClass('dd-invalid')
                        .find('.dd-alert')
                        .text('Diese Angabe wird benötigt.')
                }
    
                if(!fields['firstname'].val()) {
                    error = true;
    
                    fields['firstname']
                        .closest('.dd-form-group')
                        .addClass('dd-invalid')
                        .find('.dd-alert')
                        .text('Diese Angabe wird benötigt.')
                }
    
                if(!fields['lastname'].val()) {
                    error = true;
    
                    fields['lastname']
                        .closest('.dd-form-group')
                        .addClass('dd-invalid')
                        .find('.dd-alert')
                        .text('Diese Angabe wird benötigt.')
                }
    
                if(!fields['telephone'].val()) {
                    error = true;
    
                    fields['telephone']
                        .closest('.dd-form-group')
                        .addClass('dd-invalid')
                        .find('.dd-alert')
                        .text('Diese Angabe wird benötigt.')
                }
    
                if(error) {
                    return false;
                }
    
                alerts
                    .empty()
                    .append('<li class="dd-alert-flash">Ihre Angaben werden geprüft ...</li>')
                    .show()
                    .nextAll()
                    .hide();
    
                scroll.update();
    
                $.ajax({ url: '/theme/ajax/form-contact.php', type: 'POST', data: {
    
                    article: fields['article'].val(),
                    city: fields['city'].val(),
                    content: fields['content'].val(),
                    email: fields['email'].val(),
                    firstname: fields['firstname'].val(),
                    honeypot: fields['honeypot'].val(),
                    lastname: fields['lastname'].val(),
                    postal_code: fields['postal_code'].val(),
                    referer: fields['referer'].val(),
                    street: fields['street'].val(),
                    telephone: fields['telephone'].val()
    
                }, success: function(data) {
    
                    data = $.parseJSON(data);
    
                    alerts
                        .empty()
                        .append('<li class="dd-alert-' + data['type'] + '">' + data['alert'] + '</li>')
                        .nextAll()
                        .show();
    
                    if(data['code'] == 2) {
    
                        //
    
                    } else if(data['code'] == 1) {
    
                        fields['content'].val('');
    
                        alerts
                            .nextAll()
                            .show();
    
                    }
    
                    scroll.update();
    
                }, error: function() {
    
                    //
    
                }});
            });
        }
    });

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    if($('.dd-section-partners').length) {
        var sources = [];

        function loadPartners() {
            $('.dd-partner-source img').each(function() {
                sources.push([
                    $(this).attr('src'),
                    $(this).attr('alt'),
                    $(this).attr('title')
                ]);
            });
        }

        function shufflePartners() {
            var partners = sources.slice();
            var shuffledPartners = [];

            for(var index = 0; index < 6; index++) {
                var randomNumber = Math.floor(Math.random() * partners.length) + 1;

                var partner = partners[randomNumber - 1];

                shuffledPartners.push(partner);

                var position = partners.indexOf(partner);

                partners.splice(position, 1);
            }

            return shuffledPartners;
        }

        function updatePartners() {
            var partners = shufflePartners();
            var tiles = $('.dd-partner');

            if($('.dd-partner img[src="' + partners[0][0] + '"]:visible').length > 0) {
                updatePartners();
            } else {
                var tile = tiles.eq(Math.floor(Math.random() * tiles.length));

                tile
                    .find('img:hidden')
                    .each(function(index) {
                        $(this)
                            .attr('src', partners[index][0])
                            .attr('alt', partners[index][1])
                            .attr('title', partners[index][2]);
                    });

                tile
                    .find('img')
                    .fadeToggle(1000);
            }
        }

        loadPartners();

        setInterval(function() {
            updatePartners();
        }, 5000);
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    scroll.on('scroll', function(object) {
        clearTimeout(timer[2]);

        var scrollPercent = 100 * (object.scroll.y - $('main').offset().top) / ($('main').outerHeight() - $(window).height());

        $('.dd-reading-progress').css('width', scrollPercent + '%');

        if(object.scroll.y >= $(window).height() * .5) {
            $('body').removeClass('-dd-scroll-t-05');

            $('body').addClass('dd-scroll-t-05');
        } else {
            $('body').removeClass('dd-scroll-t-05');

            $('body').addClass('-dd-scroll-t-05');
        }

        // if($('body').is('.dd-template-landing-2')) {
        //     if(!$('[data-address].is-inview').length && $('body').is('.dd-scroll-t-05') && object.direction == 'down') {
        //         $('body').addClass('dd-nav-is-hidden');
                
        //         if(object.scroll.y < $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
        //             timer[2] = setTimeout(function() {
        //                 $('body').removeClass('dd-nav-is-hidden');
        //             }, 5000);
        //         }
        //     } else if(object.scroll.y < $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
        //         $('body').removeClass('dd-nav-is-hidden');
        //     }
        // } else if($('body').is('.dd-template-landing-1')) {
        //     if($('body').is('.dd-scroll-t-05') && object.scroll.y < $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
        //         $('body').addClass('dd-nav-is-hidden');
        //     } else {
        //         $('body').removeClass('dd-nav-is-hidden');
        //     }
        // } else {
        //     if(!$('[data-address].is-inview').length && $('body').is('.dd-scroll-t-05') && object.direction == 'down' && object.scroll.y < $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
        //         $('body').addClass('dd-nav-is-hidden');
    
        //         timer[2] = setTimeout(function() {
        //             $('body').removeClass('dd-nav-is-hidden');
        //         }, 5000);
        //     } else {
        //         $('body').removeClass('dd-nav-is-hidden');
        //     }
        // }

        if($('body').is('.dd-template-landing-2')) {
            if(object.scroll.y >= $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
                $('body').addClass('dd-nav-is-hidden');
                
                $('.dd-logo-footer-wrapper').addClass('dd-visible');
            } else {
                $('.dd-logo-footer-wrapper').removeClass('dd-visible');
            }
        } else {
            if(object.scroll.y >= $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
                $('body').removeClass('dd-nav-is-hidden');
    
                $('.dd-address').addClass('dd-address-expanded');
    
                $('.dd-logo-footer-wrapper').addClass('dd-visible');
            } else {
                $('.dd-logo-footer-wrapper').removeClass('dd-visible');
    
                $('.dd-address').removeClass('dd-address-expanded');
            }
        }
    });

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    $(window).on('load', function() {
        setTimeout(function() {
            $('body')
                .removeClass('dd-loading-state-1')
                .addClass('dd-loaded-state-1');

            var hash = $(location).attr('hash');

            if(hash) {
                scroll.scrollTo(hash, {
                    duration: 250,
                });

                history.replaceState(null, null, ' ');
            }

            setTimeout(function() {
                $('#dd-intro').remove();

                $('body')
                    .removeClass('dd-loading-state-2')
                    .addClass('dd-loaded-state-2');
                
                scroll.update();
            }, 500);

            scroll.update();
        }, 1000);

        scroll.update();
    });

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    $(window).on('resize', function() {
        clearTimeout(timer[3]);

        $('body').addClass('dd-resizing');

        timer[3] = setTimeout(function() {
            $('body').removeClass('dd-resizing');
        }, 250);

        if($(window).width() >= 992) {
            $('#dd-logo-nav-wrapper').removeClass('dd-nav-visible');
            $('#dd-nav-primary-wrapper').removeClass('dd-visible');
            $('#dd-nav-toggler').removeClass('dd-active');
        }
    });
});
