<!-- BEGIN: main -->
<div class="block-google-maps m-bottom">
    <em class="fa fa-map-marker fa-lg">&nbsp;</em>{DATA.company_name}
</div>
<div id="company-map-{DATA.bid}" style="height: 180px; padding-right: 20px" data-clat="{DATA.company_mapcenterlat}" data-clng="{DATA.company_mapcenterlng}" data-lat="{DATA.company_maplat}" data-lng="{DATA.company_maplng}" data-zoom="{DATA.company_mapzoom}"></div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key={DATA.appid}"></script>
<script>
	var ele = 'company-map-{DATA.bid}';
	var map, marker, ca, cf, a, f, z;
	ca = parseFloat($('#' + ele).data('clat'));
	cf = parseFloat($('#' + ele).data('clng'));
	a = parseFloat($('#' + ele).data('lat'));
	f = parseFloat($('#' + ele).data('lng'));
	z = parseInt($('#' + ele).data('zoom'));
	map = new google.maps.Map(document.getElementById(ele), {
	    zoom: z,
	    center: {
	        lat: ca,
	        lng: cf
	    }
	});
	marker = new google.maps.Marker({
	    map: map,
	    position: new google.maps.LatLng(a, f),
	    draggable: false,
	    animation: google.maps.Animation.DROP
	});
</script>
<!-- END: main -->