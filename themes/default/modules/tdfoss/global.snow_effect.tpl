<!-- BEGIN: main -->
<script>
    (function($) {
        $.fn.snow = function(options) {
            var $flake = $('<div id="flake" style="z-index: 99999999999" />').css({
                'position' : 'absolute',
                'top' : '-50px'
            }).html('&#10052;'), documentHeight = $(document).height(), documentWidth = $(document).width(), defaults = {
                minSize : 10,
                maxSize : 20,
                newOn : 500,
                flakeColor : "#FFFFFF"
            }, options = $.extend({}, defaults, options);
            var interval = setInterval(function() {
                var startPositionLeft = Math.random() * documentWidth - 100, startOpacity = 0.5 + Math.random(), sizeFlake = options.minSize + Math.random() * options.maxSize, endPositionTop = documentHeight - 40, endPositionLeft = startPositionLeft - 100 + Math.random() * 200, durationFall = documentHeight * 10 + Math.random() * 5000;
                $flake.clone().appendTo('body').css({
                    left : startPositionLeft,
                    opacity : startOpacity,
                    'font-size' : sizeFlake,
                    color : options.flakeColor
                }).animate({
                    top : endPositionTop,
                    left : endPositionLeft,
                    opacity : 0.2
                }, durationFall, 'linear', function() {
                    $(this).remove()
                });
            }, options.newOn);
        };
    })(jQuery);
    jQuery(document).ready(function() {
        $.fn.snow({
            minSize : '{DATA.minsize}',
            maxSize : '{DATA.maxsize}',
            newOn : '{DATA.newon}',
            flakeColor : '{DATA.flakecolor}'
        });
    });
</script>
<!-- END: main -->

<!-- BEGIN: config -->
<tr>
    <td>{LANG.minsize}</td>
    <td><input type="text" name="config_minsize" class="form-control" value="{DATA.minsize}"></td>
</tr>
<tr>
    <td>{LANG.maxsize}</td>
    <td><input type="text" name="config_maxsize" class="form-control" value="{DATA.maxsize}"></td>
</tr>
<tr>
    <td>{LANG.newon}</td>
    <td><input type="text" name="config_newon" class="form-control" value="{DATA.newon}"> <span class="heml-block">{LANG.newon_note}</span></td>
</tr>
<tr>
    <td>{LANG.flakecolor}</td>
    <td><input type="text" name="config_flakecolor" class="form-control" value="{DATA.flakecolor}"></td>
</tr>
<!-- END: config -->