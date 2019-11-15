{*
    Template variables:
    - $viewData.error (string) Error message
    - $viewData.images (array) List of images
    - $viewData.captions (array) List of captions
    - $viewData.nivoOptions (string) Nivo Slider options
    - $viewData.cssClassName (string) CSS class name for module
    - $viewData.styles (string) Additional styles
    - $viewData.sliderWrapperCssClassName (string) CSS class name for slider wrapper
    - $viewData.uid (string) Module uid
    - $viewData.modulePath (string) Module html path
*}

<!-- mp_nivo_slider -->

{if $viewData.error}

    <p>{$viewData.error}</p>

{else}

    <script src="{$viewData.modulePath}/lib/nivo-slider/jquery.nivo.slider.pack.js" type="text/javascript"></script>

    <div class="modMpNivoSlider{$viewData.cssClassName}" style="{$viewData.styles}">
        <div class="slider-wrapper theme-contenido{$viewData.sliderWrapperCssClassName}">
            <div class="ribbon"></div>
            <div class="nivoSlider mpNivoSlider_{$viewData.uid}">

                {foreach from=$viewData.images item=image}

                    <img src="{$image.src}" alt="{$image.alt}" title="{$image.title}"{$image.attributes} />

                {/foreach}

            </div>

            {foreach from=$viewData.captions item=caption}

                <div id="{$caption.id}" class="nivo-html-caption">
                    {$caption.text}
                </div>

            {/foreach}

        </div>

        <script type="text/javascript">
            (function($) {
                $(document).ready(function() {
                    $('.mpNivoSlider_{$viewData.uid}').nivoSlider({$viewData.nivoOptions});
                });
            })(jQuery);
        </script>
    </div>

{/if}

<!-- /mp_nivo_slider -->
