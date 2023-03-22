<script src="/theme/public/assets/frontend/new/js/frontend.js?v=<?php echo filemtime('theme/public/assets/frontend/new/js/frontend.js'); ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function(event) {
        $(function() {
            setInterval(function() {
                var degree;
                <?php /*
                var time = new Date(new Date().toLocaleString("en-US", { timeZone: "<?php echo dd_data()->timeZone()['timezone']; ?>" }));
                */ ?>
                var time = new Date(new Date().toLocaleString("en-US", { timeZone: "<?php echo dischdev()->settings('contact', 'timezone'); ?>" }));

                var hours = time.getHours();
                var minutes = time.getMinutes();
                var seconds = time.getSeconds();

                degree = hours * 30 + minutes * .5;

                $('.dd-clock .dd-hour').css('transform', 'rotateZ(' + degree + 'deg)');

                <?php /*
                if(hours >= 6 && hours < 18) {
                    $('.dd-clock').addClass('dd-clock-daylight');
                } else {
                    $('.dd-clock').removeClass('dd-clock-daylight');
                }
                */ ?>

                degree = seconds * 6;

                $('.dd-clock .dd-second').css('transform', 'rotateZ(' + degree + 'deg)');

                degree = minutes * 6;

                $('.dd-clock .dd-minute').css('transform', 'rotateZ(' + degree + 'deg)');
            }, 1000);
        });
    });
</script>
