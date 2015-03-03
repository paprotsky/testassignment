var foursquareApp = angular.module('foursquareApp', ['ngSanitize', 'ngCsv']);  

foursquareApp.controller('VenuesListCtrl', function ($scope, $http) {
   $scope.map;
   var gmarkers = [];
   var latitude = 35.68585623406027;
   var longtitude = 139.7633972147014;
   var query;
   $scope.venuesQuantity = 0;

   $scope.loadData = function() {     
      var mapOptions = {
         zoom: 11,
         center: new google.maps.LatLng(35.68585623406027, 139.7633972147014)
      }

      $scope.map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
      google.maps.event.addListener($scope.map, "click", function(event) {
         latitude = event.latLng.lat();
         longtitude = event.latLng.lng();
      });        
   };
   $scope.loadData();

   $scope.searchData = function(){ 
      query = $scope.query; 
      for(i=0; i<gmarkers.length; i++){
          gmarkers[i].setMap(null);
      }
      $http.post('foursquareData.php', {lat:latitude, lng:longtitude, query: query}).success(function(data) {
         $scope.venuesQuantity = 0;
         var csvData = [];
         for (var i = 0; i < data.response.venues.length; ++i) {
            csvData.push({
               "Name": data.response.venues[i].name,
               "City": data.response.venues[i].location.city,
               "Address": data.response.venues[i].location.address,
               "Latitude": data.response.venues[i].location.lat,
               "Longitude": data.response.venues[i].location.lng
            });
            $scope.venuesQuantity++;
         }
         $scope.csvData = csvData;

         $scope.foundVenues = data;

         var lat = data.response.venues[0].location.lat;
         var lng = data.response.venues[0].location.lng;
         var myLatlng = new google.maps.LatLng(lat,lng);
         var mapOptions = {
            zoom: 9,
            center: myLatlng
         }
         for(var i = 0; i < data.response.venues.length; i++){
            var lat = data.response.venues[i].location.lat;
            var lng = data.response.venues[i].location.lng;

            var marker = new google.maps.Marker({
               position: new google.maps.LatLng(lat,lng),
               map: $scope.map,
               title: data.response.venues[i].name
            });
            gmarkers.push(marker);
         }
         $scope.showPreviousQueries();
      });
   };

   $scope.showPreviousQueries = function(){ 
      $http.get('previousQueriesData.php').success(function(data) {
         $scope.previousQueries = data;
      });
   };
   $scope.showPreviousQueries();

   $scope.deleteQuery = function(queryId){
      var queryId = queryId;
      $http.post('deletePreviousQuery.php', {queryId: queryId}).success(function(data) {
         $scope.showPreviousQueries();
      });
   };

   $scope.getCsvData = function() { 
      return $scope.csvData; 
   }

   $scope.hitEnter = function(keyEvent) {
      if (keyEvent.which === 13){
         $scope.searchData();
      }
   }
});

foursquareApp.filter('distance', function () {
   return function (input) {
      if (input >= 1000) {
         return (input/1000).toFixed(0) + ' km';
      } else {
         return input + ' m';
      }
   }
});
