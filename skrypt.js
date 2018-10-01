<script>
      var map;
      var marker;
      var infowindow;
      var messagewindow;

      var customLabel = {
        bdb: {
          label: '1'
        },
        db: {
          label: '2'
        },
        sr: {
          label: '3'
        },
        sl: {
          label: '4'
        },
        bdz: {
          label: '5'
        }
      };

         function initMap() {
        var california = new google.maps.LatLng(53.422227347149054, 14.525041580200194);
       

        var opcjeMapy = {
          zoom: 14,
          center: california,
          disableDefaultUI: false,
        };

        map = new google.maps.Map(document.getElementById("map"), opcjeMapy);   
        znajdzMnie();
                }
      function znajdzMnie()
      {
      
          navigator.geolocation.getCurrentPosition(function(pozycja)
          {
            setTimeout(
              function()
              {
                var punkt = new google.maps.LatLng(pozycja.coords.latitude,pozycja.coords.longitude);
                map.setCenter(punkt);
              
              }, 
              250);
          }, 
        );

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





        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('http://localhost/mapa/pobrane.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));
              
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
                var image = {
                  url: 'http://localhost/mapa/' + type + '.png',
                  
                  
                   };
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon:image,
                
              });

              var circle = new google.maps.Circle({
  map: map,
  
      // 10 miles in metres
 
});
circle.bindTo('center', marker, 'position');
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
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
     location.reload();
      }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiQtbQxqp0yw-p0L2K9213BBTe2uAWVeQ&callback=initMap">
    </script>