let homeMap, searchManager, searchManagerProduction;
function GetMap() {
    map_settings = {
        zoom: 16,
        disableScrollWheelZoom: true,
        mapTypeId: Microsoft.Maps.MapTypeId.load
    };

    homeMap = new Microsoft.Maps.Map('#office-map', map_settings);
    productionMap = new Microsoft.Maps.Map('#production-map', map_settings);
    Search();

    homeMapInfobox = new Microsoft.Maps.Infobox(homeMap.getCenter(), { visible: false });
    productionMapInfobox = new Microsoft.Maps.Infobox(productionMap.getCenter(), { visible: false });

    homeMapInfobox.setMap(homeMap);
    productionMapInfobox.setMap(productionMap);
}

function Search() {
    if (!searchManager) {
        Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
            searchManager = new Microsoft.Maps.Search.SearchManager(homeMap);
            searchManagerProduction = new Microsoft.Maps.Search.SearchManager(productionMap);
            Search();
        });
    } else {
        homeMap.entities.clear();
        productionMap.entities.clear();
        geocodeQuery(regionContacts.address);
        geocodeQueryProduction(regionContacts.production_address);
    }
}


function geocodeQuery(query) {
    let searchRequest = {
        where: query,
        callback: function (r) {
            if (r && r.results && r.results.length > 0) {
                let pin, pins = [], locs = [];
                for (let i = 0; i < r.results.length; i++) {
                    //Create a pushpin for each result.
                    pin = new Microsoft.Maps.Pushpin(r.results[i].location, {
                        title: 'Офис Рустехпром Полимер',
                        text: 'A'
                    });
                    pin.metadata = {
                        title: 'Контакты',
                        description: '<div class="map-pin"><i class="fas fa-phone-alt"></i> '+regionContacts.phone+'<br/><i class="fas fa-envelope"></i> '+regionContacts.email + '</div>'
                    };
                    pins.push(pin);
                    locs.push(r.results[i].location);
                    Microsoft.Maps.Events.addHandler(pin, 'click', pushpinClicked);
                }
                homeMap.entities.push(pins);
                //Determine a bounding box to best view the results.
                let bounds;
                if (r.results.length == 1) {
                    bounds = r.results[0].bestView;
                } else {
                    //Use the locations from the results to calculate a bounding box.
                    bounds = Microsoft.Maps.LocationRect.fromLocations(locs);
                }
                homeMap.setView({ bounds: bounds });
            }
        },
        errorCallback: function (e) {
            console.log("No results found.");
        }
    };

    function pushpinClicked(e){
        homeMapInfobox.setOptions({
            location: e.target.getLocation(),
            title: e.target.metadata.title,
            description: e.target.metadata.description,
            visible: true
        });
    }

    searchManager.geocode(searchRequest);
}





function geocodeQueryProduction(query) {
    let searchRequest = {
        where: query,
        callback: function (r) {
            if (r && r.results && r.results.length > 0) {
                let pin, pins = [], locs = [];
                for (let i = 0; i < r.results.length; i++) {
                    //Create a pushpin for each result.
                    pin = new Microsoft.Maps.Pushpin(r.results[i].location, {
                        title: 'Производство Рустехпром Полимер',
                        text: 'A'
                    });
                    pin.metadata = {
                        title: 'Контакты',
                        description: '<div class="map-pin"><i class="fas fa-phone-alt"></i> '+regionContacts.phone+'<br/><i class="fas fa-envelope"></i> '+regionContacts.email + '</div>'
                    };
                    pins.push(pin);
                    locs.push(r.results[i].location);
                    //Microsoft.Maps.Events.addHandler(pin, 'click', pushpinClicked);
                }
                productionMap.entities.push(pins);
                //Determine a bounding box to best view the results.
                let bounds;
                if (r.results.length == 1) {
                    bounds = r.results[0].bestView;
                } else {
                    //Use the locations from the results to calculate a bounding box.
                    bounds = Microsoft.Maps.LocationRect.fromLocations(locs);
                }
                productionMap.setView({ bounds: bounds });
            }
        },
        errorCallback: function (e) {
            console.log("No results found.");
        }
    };

    function pushpinClicked(e){
        productionMapInfobox.setOptions({
            location: e.target.getLocation(),
            title: e.target.metadata.title,
            description: e.target.metadata.description,
            visible: true
        });
    }

    searchManagerProduction.geocode(searchRequest);
}





window.addEventListener('load', function(){
    homeMap.setView({
        zoom: 16
    });
    productionMap.setView({
        zoom: 16
    });
});
