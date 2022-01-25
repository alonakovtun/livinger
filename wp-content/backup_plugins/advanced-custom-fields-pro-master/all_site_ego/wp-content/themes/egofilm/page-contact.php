<?
/* Template Name: Contact */

get_header(); ?>


<main class="contact_content">
	<?
	$acf_content_top = get_field('contact_top');
	?>
	<h1 class="content_ttl a--hd-1 a--ex-ttl"><?= $acf_content_top['title']; ?></h1>
	<p class="content_tgl a--txt-md a--ex-tgl"><?= $acf_content_top['tagline']; ?></p>

	<div class="content_txt a--ex-cnt">
		<? the_field('contact_content'); ?>
	</div>

	<div id="map"></div>

</main>


<script>
	/* ==============================
	 * Map.
	 * ============================== */

	var map;
	function initMap() {
		if( !document.querySelector('#map') ){
			return;
		}

		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 52.2245922, lng: 21.0630642},
			// 53.141870, 18.025322
			zoom: 14,
			styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}],
			streetViewControl: false,
		})

		var marker = new google.maps.Marker({
			position: {lat: 52.2245922, lng: 21.0630642},
			map: map,
			icon: document.location.origin + '/wp-content/themes/egofilm/custom/img/map-marker.svg',
			// title: 'Hello World!'
		});
	};
</script>

<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCHPIvZaPdXd7lLcJMkcj6RLGArYzXt70&callback=initMap">
</script>


<? get_footer();