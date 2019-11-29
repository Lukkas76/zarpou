function initMap(latitude,longitude) {
   var pyrmont = {lat: latitude, lng: longitude};
   
   var map = new google.maps.Map(document.getElementById('maps'), {
      center: pyrmont,
      zoom: 18,
      scrollwheel:  false,
      draggable: true
   });

   var iconBase = '/assets/img/site/';

   var marker = new google.maps.Marker({
      position: pyrmont,
      map: map,
      icon: iconBase + 'icon-maps.png'
   });
}

