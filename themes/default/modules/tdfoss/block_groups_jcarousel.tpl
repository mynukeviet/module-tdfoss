<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/tdfoss/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/tdfoss/owlcarousel/assets/owl.theme.default.min.css">

<div class="owl-carousel owl-theme">
    <!-- BEGIN: loop -->
    <div class="item text-center">
        <div class="thumbnail">
            <a href="{ROW.link}" title="{ROW.title}"><img width="400" height="270" src="{ROW.homeimgfile}" alt="{ROW.title}" /> </a>
        </div>
        <h4 class="media-heading">
            <a href="{ROW.link}" title="{ROW.title}">{ROW.title_clean}</a>
        </h4>
    </div>
    <!-- END: loop -->
</div>
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/tdfoss/owlcarousel/owl.carousel.min.js"></script>
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop : true,
            autoplay: true,
            navigation:true,
            margin : 10,
            navText : [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
            responsive : {
                0 : {
                    items : 1
                },
                600 : {
                    items : 3
                },
                1000 : {
                    items : 4
                }
            }
        })
    });
</script>
<!-- END: main -->