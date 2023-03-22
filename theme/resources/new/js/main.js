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

        function updateAvailability() {
            $.ajax({ url: '/theme/ajax/availability.php', type: 'POST', data: {

                //

            }, success: function(data) {

                data = $.parseJSON(data);

                $('[data-ajax-availability]').html(data['availability']);
                $('[data-ajax-meetings]').html(data['meetings']);

                if(data['status']) {
                    $('.dd-clock').addClass('dd-clock-daylight');
                } else {
                    $('.dd-clock').removeClass('dd-clock-daylight');
                }

                scroll.update();

            }, error: function() {

                //

            }});
        }

        updateAvailability();

        setInterval(function() {
            if(!$(':root').is('.has-scroll-scrolling')) {
                updateAvailability();
            }
        }, 60000);

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($('[data-ajax-events]').length) {
            function updateEvents() {
                $('[data-ajax-events]').each(function() {
                    var $this = $(this);

                    var fields = [];

                    fields['token'] = $this.attr('data-token');

                    $.ajax({ url: '/theme/ajax/events.php', type: 'POST', data: {

                        token: fields['token']

                    }, success: function(data) {

                        data = $.parseJSON(data);

                        $('[data-ajax-events]').html(data['events']);

                        updateTables();

                        scroll.update();

                    }, error: function() {

                        //

                    }});
                });
            }

            updateEvents();

            setInterval(function() {
                if(!$(':root').is('.has-scroll-scrolling')) {
                    updateEvents();
                }
            }, 60000);
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        // $('.rex-yform .form-group').each(function() {
        //     var $this = $(this);

        //     $this.addClass('dd-form-group');

        //     if(!$(':nth-child(3)', $this).length) {
        //         $this.append('<div class="dd-alert">–</div>');
        //     }
        // });

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
        }, 25);

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

    if($('#dd-section-comment-form').length) {
        $('#dd-section-comment-form form').submit(function(event) {
            event.preventDefault();

            var $this = $(this);

            var alerts = $this.prev('.dd-alerts');
            var fields = [];
            var error = false;

            fields['content'] = $this.find('[name="content"]');
            fields['callname'] = '';
            fields['email'] = '';
            fields['honeypot'] = $this.find('[name="honeypot"]');
            fields['notification'] = $this.find('[name="notification"]');
            fields['parent'] = $this.find('[name="parent"]');
            fields['post'] = $this.find('[name="post"]');
            fields['token'] = '';

            if($this.find('[name="callname"]').length) {
                fields['callname'] = $this.find('[name="callname"]');
            }

            if($this.find('[name="email"]').length) {
                fields['email'] = $this.find('[name="email"]');
            }

            if($this.find('[name="token"]').length) {
                fields['token'] = $this.find('[name="token"]');
            }

            $this
                .find('.dd-form-group')
                .removeClass('dd-invalid');

            alerts
                .empty()
                .hide();

            if($this.find('[name="callname"]').length) {
                fields['callname']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
            }

            fields['content']
                .closest('.dd-form-group')
                .find('.dd-alert')
                .text('–');

            if($this.find('[name="email"]').length) {
                fields['email']
                    .closest('.dd-form-group')
                    .find('.dd-alert')
                    .text('–');
            }

            scroll.update();

            scroll.scrollTo('#dd-section-comment-form', {
                duration: 250
            });

            if(!fields['content'].val()) {
                error = true;

                fields['content']
                    .closest('.dd-form-group')
                    .addClass('dd-invalid')
                    .find('.dd-alert')
                    .text('Diese Angabe wird benötigt.')
            }

            if($this.find('[name="email"]').length) {
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
            }

            if($this.find('[name="callname"]').length) {
                if(!fields['callname'].val()) {
                    error = true;

                    fields['callname']
                        .closest('.dd-form-group')
                        .addClass('dd-invalid')
                        .find('.dd-alert')
                        .text('Diese Angabe wird benötigt.')
                }
            }

            if(error) {
                return false;
            }

            fields['content'] = fields['content'].val();
            fields['honeypot'] = fields['honeypot'].val();
            fields['notification'] = fields['notification'].val();
            fields['parent'] = fields['parent'].val();
            fields['post'] = fields['post'].val();

            if($this.find('[name="callname"]').length) {
                fields['callname'] = fields['callname'].val();
            }

            if($this.find('[name="email"]').length) {
                fields['email'] = fields['email'].val();
            }

            if($this.find('[name="token"]').length) {
                fields['token'] = fields['token'].val();
            }

            alerts
                .empty()
                .append('<li class="dd-alert-flash">Deine Angaben werden geprüft ...</li>')
                .show()
                .nextAll()
                .hide();

            scroll.update();

            $.ajax({ url: '/theme/ajax/form-comment.php', type: 'POST', data: {

                callname: fields['callname'],
                content: fields['content'],
                email: fields['email'],
                honeypot: fields['honeypot'],
                notification: fields['notification'],
                parent: fields['parent'],
                post: fields['post'],
                token: fields['token']

            }, success: function(data) {

                data = $.parseJSON(data);

                var comment = data['comment'];

                alerts
                    .empty()
                    .append('<li class="dd-alert-' + data['type'] + '">' + data['alert'] + '</li>');

                if(data['code'] == 2) {

                    //

                } else if(data['code'] == 1) {

                    $this
                        .find('[name="content"]')
                        .val(null);

                    alerts
                        .empty()
                        .nextAll()
                        .show();

                    $.ajax({ url: '/theme/ajax/comments.php', type: 'POST', data: {

                        post: fields['post']

                    }, success: function(data) {

                        $this
                            .find('[name="parent"]')
                            .val(null);

                        $('#dd-section-comments')
                            .replaceWith(data)
                            .removeClass('dd-d-none')
                            .prev()
                            .removeClass('dd-d-none');

                        scroll.update();

                        scroll.scrollTo('#dd-comment-' + comment, {
                            duration: 250
                        });

                        $('[data-parent]').click(function() {
                            var $this = $(this);

                            $('#dd-section-comment-form')
                                .find('[name="parent"]')
                                .val($this.data('parent'));

                            scroll.scrollTo('#dd-section-comment-form', {
                                duration: 250
                            });
                        });

                    }, error: function() {

                        //

                    }});

                }

                scroll.update();

            }, error: function() {

                //

            }});
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $('[data-parent]').click(function() {
            var $this = $(this);

            $('#dd-section-comment-form')
                .find('[name="parent"]')
                .val($this.data('parent'));

            scroll.scrollTo('#dd-section-comment-form', {
                duration: 250
            });
        });
    }

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
            fields['callname'] = $this.find('[name="callname"]');
            fields['content'] = $this.find('[name="content"]');
            fields['email'] = $this.find('[name="email"]');
            fields['honeypot'] = $this.find('[name="honeypot"]');
            fields['referer'] = $this.find('[name="referer"]');

            $this
                .find('.dd-form-group')
                .removeClass('dd-invalid');

            alerts
                .empty()
                .hide();
            
            fields['callname']
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

            scroll.update();

            scroll.scrollTo('#dd-section-contact-form', {
                duration: 250
            });

            if(!fields['callname'].val()) {
                error = true;

                fields['callname']
                    .closest('.dd-form-group')
                    .addClass('dd-invalid')
                    .find('.dd-alert')
                    .text('Diese Angabe wird benötigt.')
            }

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

            if(error) {
                return false;
            }

            alerts
                .empty()
                .append('<li class="dd-alert-flash">Deine Angaben werden geprüft ...</li>')
                .show()
                .nextAll()
                .hide();

            scroll.update();

            $.ajax({ url: '/theme/ajax/form-contact.php', type: 'POST', data: {

                article: fields['article'].val(),
                callname: fields['callname'].val(),
                content: fields['content'].val(),
                email: fields['email'].val(),
                honeypot: fields['honeypot'].val(),
                referer: fields['referer'].val()

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

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    if($('#dd-section-newsletter-form').length) {
        $('#dd-section-newsletter-form form').submit(function(event) {
            event.preventDefault();

            var $this = $(this);

            var alerts = $this.prev('.dd-alerts');
            var fields = [];
            var error = false;

            fields['callname'] = $this.find('[name="callname"]');
            fields['email'] = $this.find('[name="email"]');
            fields['honeypot'] = $this.find('[name="honeypot"]');

            $this
                .find('.dd-form-group')
                .removeClass('dd-invalid');

            alerts
                .empty()
                .hide();

            fields['callname']
                .closest('.dd-form-group')
                .find('.dd-alert')
                .text('–');

            fields['email']
                .closest('.dd-form-group')
                .find('.dd-alert')
                .text('–');

            scroll.update();

            scroll.scrollTo('#dd-section-newsletter-form', {
                duration: 250
            });

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

            if(!fields['callname'].val()) {
                error = true;

                fields['callname']
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
                .append('<li class="dd-alert-flash">Deine Angaben werden geprüft ...</li>')
                .show()
                .nextAll()
                .hide();

            scroll.update();

            $.ajax({ url: '/theme/ajax/form-newsletter.php', type: 'POST', data: {

                callname: fields['callname'].val(),
                email: fields['email'].val(),
                honeypot: fields['honeypot'].val()

            }, success: function(data) {

                data = $.parseJSON(data);

                alerts
                    .empty()
                    .append('<li class="dd-alert-' + data['type'] + '">' + data['alert'] + '</li>');

                if(data['code'] == 2) {

                    //

                } else if(data['code'] == 1) {

                    //
                    
                }

                scroll.update();

            }, error: function() {

                //

            }});
        });
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    if($('#dd-form-channels').length) {
        $('#dd-form-channels .dd-checkbox-wrapper').on('click', function(event) {
            var $this = $(this);

            var fields = [];
            var form = $this.closest('form');

            fields['email'] = form.find('[name="email"]').val();
            fields['sms'] = form.find('[name="sms"]').val();
            fields['token'] = form.find('[name="token"]').val();

            if($this.is('[data-name="email"]')) {
                if(fields['email'] == 1) {
                    fields['email'] = 0;
                } else {
                    fields['email'] = 1;
                }
            }

            if($this.is('[data-name="sms"]')) {
                if(fields['sms'] == 1) {
                    fields['sms'] = 0;
                } else {
                    fields['sms'] = 1;
                }
            }

            $.ajax({ url: '/theme/ajax/form-channels.php', type: 'POST', data: {

                email: fields['email'],
                sms: fields['sms'],
                token: fields['token']

            }, success: function(data) {

                // data = $.parseJSON(data);

                //

            }, error: function() {

                //

            }});
        });
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    if($('#dd-section-token-form').length) {
        $('#dd-section-token-form form').submit(function(event) {
            event.preventDefault();

            var $this = $(this);

            var alerts = $this.prev('.dd-alerts');
            var article = $this.data('article');
            var error = false;
            var fields = [];
            var post = $this.data('post');

            fields['identifier'] = $this.find('[name="identifier"]');
            fields['honeypot'] = $this.find('[name="honeypot"]');

            $this
                .find('.dd-form-group')
                .removeClass('dd-invalid');

            alerts
                .empty()
                .hide();

            fields['identifier']
                .closest('.dd-form-group')
                .find('.dd-alert')
                .text('–');

            scroll.update();

            scroll.scrollTo('#dd-section-token-form', {
                duration: 250
            });

            if(!fields['identifier'].val()) {
                error = true;

                fields['identifier']
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
                .append('<li class="dd-alert-flash">Deine Angaben werden geprüft ...</li>')
                .show()
                .nextAll()
                .remove();

            scroll.update();

            $.ajax({ url: '/theme/ajax/form-token.php', type: 'POST', data: {

                article: article,
                honeypot: fields['honeypot'].val(),
                identifier: fields['identifier'].val(),
                post: post

            }, success: function(data) {

                data = $.parseJSON(data);

                alerts
                    .empty()
                    .append('<li class="dd-alert-' + data['type'] + '">' + data['alert'] + '</li>');

                if(data['code'] == 2) {

                    //

                } else if(data['code'] == 1) {

                    //

                }

                scroll.update();

            }, error: function() {

                //

            }});
        });
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

        if($('body').is('.dd-template-landing-2')) {
            if(!$('[data-address].is-inview').length && $('body').is('.dd-scroll-t-05') && object.direction == 'down') {
                $('body').addClass('dd-nav-is-hidden');
                
                if(object.scroll.y < $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
                    timer[2] = setTimeout(function() {
                        $('body').removeClass('dd-nav-is-hidden');
                    }, 5000);
                }
            } else if(object.scroll.y < $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
                $('body').removeClass('dd-nav-is-hidden');
            }
        } else if($('body').is('.dd-template-landing-1')) {
            if($('body').is('.dd-scroll-t-05') && object.scroll.y < $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
                $('body').addClass('dd-nav-is-hidden');
            } else {
                $('body').removeClass('dd-nav-is-hidden');
            }
        } else {
            if(!$('[data-address].is-inview').length && $('body').is('.dd-scroll-t-05') && object.direction == 'down' && object.scroll.y < $('main').offset().top + $('main').outerHeight() - $(window).height() * 1.5) {
                $('body').addClass('dd-nav-is-hidden');
    
                timer[2] = setTimeout(function() {
                    $('body').removeClass('dd-nav-is-hidden');
                }, 5000);
            } else {
                $('body').removeClass('dd-nav-is-hidden');
            }
        }

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

        if($('[data-clock].is-inview').length) {
            $('.dd-cursor-shape').addClass('dd-hidden');

            $('.dd-clock-cursor').addClass('dd-visible');
        } else {
            $('.dd-clock-cursor').removeClass('dd-visible');

            $('.dd-cursor-shape').removeClass('dd-hidden');
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
    });
});
