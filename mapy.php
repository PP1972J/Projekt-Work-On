

<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>From Info Windows to a Database: Saving User-Added Form Data</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
       
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>

     


    <div id="map" height="460px" width="100%"></div>
    
    <div id="form">
      <table>
      <tr><td>Użytkownik:</td> <td><input type='text' id='name'/> </td> </tr>
      
      <tr><td>Jakość powietrza:</td> <td><select id='type'> +
                 <option value='bdb' SELECTED>bardzo dobra</option>
                 <option value='db'>dobra</option>
                 <option value='sr'>średnia</option>
                 <option value='sl'>słaba</option>
                 <option value='bdz'>bardzo zła</option>
                 </select> </td></tr>
                 <tr><td></td><td><input type='button' value='Zapisz' onclick='saveData()'/></td></tr>
      </table>
    </div>
    <div id="message">Location saved</div>
    
    <script>
      var map;
      var marker;
      var infowindow;
      var messagewindow;

      function initMap() {
        var california = {lat: 53.111, lng: 18.010};
        map = new google.maps.Map(document.getElementById('map'), {
          center: california,
          zoom: 9
        });

        infowindow = new google.maps.InfoWindow({
          content: document.getElementById('form')
        });

        messagewindow = new google.maps.InfoWindow({
          content: document.getElementById('message')
        });

        google.maps.event.addListener(map, 'click', function(event) {
          marker = new google.maps.Marker({
            position: event.latLng,
            map: map
          });


          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
          });
        });
      }

      function saveData() {
        var name = escape(document.getElementById('name').value);
        
        var type = document.getElementById('type').value;
        var latlng = marker.getPosition();
        var url = 'http://localhost/mapa/phpsqlinfo_addrow.php?name=' + name  +
                  '&type=' + type + '&lat=' + latlng.lat() + '&lng=' + latlng.lng();
console.log(url);
        downloadUrl(url, function(data, responseCode) {

          if (responseCode == 200 && data.length <= 1) {
            infowindow.close();
            messagewindow.open(map, marker);
          }
        });
        var x = document.getElementById("form");
        if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
      }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request.responseText, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing () {
      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiQtbQxqp0yw-p0L2K9213BBTe2uAWVeQ&callback=initMap">
    </script>





  </body>
</html>