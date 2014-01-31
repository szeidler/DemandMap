<?php // Hack ushahidis javascript embedding to get syntax highlighting in editors ?>
<?php if (1 == 0) { ?>
<script type="text/javascript">
<?php } ?>
  $(function () {
    var markers = null;
    var category_id = '';
    function addMarkers(category_id) {
      filter = '';
      markers = L.markerClusterGroup({
        maxClusterRadius: 40,
        iconCreateFunction: function (cluster) {
          var childCount = cluster.getChildCount();
          var c = ' marker-cluster-';
          if (childCount < 20) {
            c += 'small';
          } else if (childCount < 50) {
            c += 'medium';
          } else {
            c += 'large';
          }
          return new L.DivIcon({ html: '<div><span>' + childCount + '</span></div>', className: 'marker-cluster' + c, iconSize: new L.Point(40, 40) });
        }
      });
      if (category_id.length > 0) {
        filter = 'catid&id=' + category_id;
      }
      if (filter.length == 0) {
        filter = 'all';
      }
      $.ajax({
        dataType: 'json',
        url: '/api?task=incidents&by=' + filter,
        success: function (data) {
          $.each(data.payload.incidents, function (i, item) {
            var title = '<h3><a href="reports/view/' + item.incident.incidentid + '">' + item.incident.incidenttitle + '<a></h3>';
            var marker = L.marker(new L.LatLng(item.incident.locationlatitude, item.incident.locationlongitude), { title: title });
            marker.bindPopup(title);
            markers.addLayer(marker);
          });
        }
      });
      map.addLayer(markers);
    };

    function reloadList(category_id, page) {
      if (category_id.length > 0) {
        filter = category_id;
      }
      $('.list-view').load('/reports/fetch_reports?c=' + filter + '&page=' + page);
    }

    var map = new L.Map('map', {
      center: new L.LatLng(7.253496050069552, 31.827392578125),
      zoom: 6,
      scrollWheelZoom: false,
      layers: [googleLayer]
    });

    // add markers to the map
    addMarkers(category_id);

    $('#type_switch a').live('click', function(e) {
      $('#type_switch a').removeClass('active');
      $(this).addClass('active');
      map.removeLayer(markers);
      category_id = $(this).attr('id').substr(4);
      addMarkers(category_id);
      reloadList(category_id, 1);
      if (category_id != '') {
        $('.category_swich_cat').hide();
        $('#category_swich_cat_' + category_id).show();
      } else {
        $('.category_swich_cat').show();
      }
      e.preventDefault();
    });

    $('#category_switch a').live('click', function(e) {
      $('#category_switch a').removeClass('active');
      $(this).addClass('active');
      map.removeLayer(markers);
      category_id = $(this).attr('id').substr(4);
      addMarkers(category_id);
      reloadList(category_id, 1);
      e.preventDefault();
    });

    // Pager Trigger
    $('ul.pager a').live('click', function(e) {
      page_id = $(this).html();
      if (page_id.length < 1) {
        page_id = 1;
      }
      if (category_id.length == 0) {
        category_id = 'all';
      }
      reloadList(category_id, page_id);
      e.preventDefault();
    });

    /*var track = new L.KML("/themes/demandmap/kml/undp_states.kml", {async: true});
     track.on("loaded", function(e) { map.fitBounds(e.target.getBounds()); });

     map.addLayer(track);*/
  });
<?php if (1 == 0) { ?>
</script>
<?php } ?>