let is_tambah=false;
let markersAdd=[]
let all_overlays=[]
var drawingManager
var listener
var map
var mapModal
let is_radius='';
let modalPoly=[]
let modalMarker=[]

$(document).ready(function () {
    //renderMap();
    renderMapModal()
    
    $('a#mn-lokasi-kantor').addClass('active')
    $('a#mn-lokasi-kantor .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('a#mn-lokasi-kantor .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
});

function create(){
    is_tambah=true
    $('#modal-jenis-marker').modal('show')
    clearForm()
    //$('#btn-pointer-1').click()
    
    if(mapModal!==undefined){
        updateMap()
    }else{
        renderMapModal()
    }
    sDivisi()
       
}

function clearForm(){
    $('#pac-input-modal').val("")
    $('#txt-radius').val("")
    //$('#txt-name').addClass("d-none")
    $('.div-divisi').addClass("d-none")
    $('#div-nama').addClass('d-none')
    $('.div-radius').addClass("d-none")
    $('#btn-pointer-1').removeClass('active')
    $('#btn-pointer-2').removeClass('active')
    $('#id-map').val("")
    $('#divisi').val(null).trigger('change')
    $('#pointer-alert').removeClass("d-none")
    $('#div-map').addClass("d-none")
    createBatal()

    if(modalPoly.length>0){
        for(p in modalPoly){
            modalPoly[p].setMap(null)
        }
        //modalPoly=[]
    }
    if(modalMarker.length>0){
        for(m in modalMarker){
            modalMarker[m].setMap(null)
        }
        //modalMarker=[]
    }
}

function createSimpan(){
    is_tambah=false
    let param=is_radius
    if(param=='1'){
        //$('#text-radius').removeClass('d-none')
        listener = google.maps.event.addListener(mapModal, "click", function (event) {
            let icon = {
                url: baseUrl+"assets/extends/img/office.svg", // url
                scaledSize: new google.maps.Size(50, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(25, 25) // anchor
            };
            if (markersAdd.length>0) {
                markersAdd=[]
                marker.setPosition(event.latLng);
            } else {
                marker = new google.maps.Marker({
                position: event.latLng,
                map: mapModal,
                icon:icon
                });
            }
            markersAdd.push(marker);
            
            $('#modal-nama-marker #koordinat').val(JSON.stringify(event.latLng));
            console.log("coord")
            console.log(JSON.stringify(event.latLng))

            $("#lat-inp").val(event.latLng.lat());
            $("#lng-inp").val(event.latLng.lng());
    });
        
    }else{
        //$('#text-polygon').removeClass('d-none')
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: false,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            },
            polygonOptions: {
                editable: true  
            }
        });
        drawingManager.setMap(mapModal);

        google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
            const newShape = event.overlay;
            newShape.type = event.type;
            
        });
    
        google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
            overlayClickListener(event.overlay);
            const polygon = event.overlay.getPath().getArray();
            $('#modal-nama-marker #koordinat').val(JSON.stringify(event.overlay.getPath().getArray()));
            all_overlays.push(event);
        });
    }
    
    //$('#btn-simpan').removeClass('d-none')
    //$('#btn-batal').removeClass('d-none')
    //$('#btn-create').addClass('d-none')
    //$('#modal-jenis-marker').modal('hide')
    // $('#btn-pointer-1').removeClass('active')
    // $('#btn-pointer-2').removeClass('active')
    
    //$('#modal-nama-marker').modal('show')
    
}

function simpanNama(){
    //$('#modal-nama-marker').modal('hide')
    google.maps.event.removeListener(listener,"click")
    //google.maps.event.removeListener(drawingManager)
    //ajaxSimpan()
    
    
    for(d in markersAdd){
        markersAdd[d].setMap(null);
    }
    // $('#text-polygon').addClass('d-none')
    // $('#text-radius').addClass('d-none')

    
    let LocationArr=[]

    if(is_radius==true){
        let koordinat=JSON.parse($('#modal-nama-marker #koordinat').val())
        LocationArr=[{
            "longitude": koordinat.lng,
            "latitude": koordinat.lat,
            "radius": $('#txt-radius').val(),
            "order_number": null
        }]
    }else{
        let koordinat=JSON.parse($('#modal-nama-marker #koordinat').val())
        for(i in koordinat){
            LocationArr.push({
                "longitude": koordinat[i].lng,
                "latitude": koordinat[i].lat,
                "radius": null,
                "order_number": parseInt(i)+1
            })
        }
        
    }
    
    let data={
        name:$('#pac-input-modal').val(),
        location_type:is_radius==true?1:2,
        office_locations:LocationArr,
        divisi_id:$('#divisi').val()
    }
    console.log(data)
    
    loadStart()
    let tipe=$('#id-map').val()==''? "POST": "PUT"
    let link=$('#id-map').val()==''?urlApi+"office":urlApi+"office/"+$('#id-map').val()
    $.ajax({
          type:tipe,
          dataType: "json",
          data: data,
          url: link,
          beforeSend: function (xhr) {
          xhr.setRequestHeader(
              "Authorization",
              "Bearer " + localStorage.getItem("token")
          );
          },
          success: function (response) {
          loadStop()
          $('#modal-jenis-marker').modal('hide')
            swal.fire({
                title: "Berhasil!",
                text: "Lokasi berhasil disimpan",
                icon: "success",
                confirmButtonText: "Selesai",
            }).then((value) => {
                location.reload()
            });
          },
          error: function (xhr, ajaxOptions, thrownError) {
            loadStop()
            handleErrorDetail(xhr)
        },
    });
    
    //createBatal()
}

function createBatal(){
    is_tambah=false
  
    // polygonMarker.setMap(null);
    // polygonMarker=[]
    //polygonDots=$('#koordinat').val()
    
    if(is_radius=='1'){
        google.maps.event.removeListener(listener,"click")
    
        for(m in markersAdd){
            markersAdd[m].setMap(null);
        }
        markersAdd=[]
    }else if(is_radius=='2'){
        drawingManager.setMap(null);
        drawingManager.setDrawingMode(null);
    
        for(a in all_overlays){
            all_overlays[a].overlay.setMap(null);
        }
        all_overlays=[]
    }
    
    
    // $('#btn-simpan').addClass('d-none')
    // $('#btn-batal').addClass('d-none')
    // $('#btn-create').removeClass('d-none')
    // $('#text-polygon').addClass('d-none')
    // $('#text-radius').addClass('d-none')
}

function pointerPeta(param){
    console.log(param)
    if(param!==null){
        is_radius=param
        if(is_radius=='1'&&drawingManager!==undefined){
            console.log("delete drawing")
            drawingManager.setMap(null);
            drawingManager.setDrawingMode(null);
        
            for(a in all_overlays){
                all_overlays[a].overlay.setMap(null);
            }
            all_overlays=[]
        }else if(is_radius=='2'){
            console.log("delete marker")
            google.maps.event.removeListener(listener,"click")
        
            for(m in markersAdd){
                markersAdd[m].setMap(null);
            }
            markersAdd=[]
        }
        createSimpan() 
        $('#Maplokasi').css("cursor","pointer")
        if(is_radius==true){
            $('.div-radius').removeClass("d-none")
            //$('#txt-name').removeClass("d-none")
            $('.div-divisi').addClass("col-md-6 ps-0").removeClass("col-md-12 d-none p-0")
        }else{
            $('.div-radius').addClass("d-none")
            $('.div-divisi').addClass("col-md-12 p-0").removeClass("col-md-6 d-none ps-0")
            //$('#txt-name').removeClass("d-none")
        }

        $('#pointer-alert').addClass("d-none")
        $('#div-nama').removeClass('d-none')
        
        if(param=='1'){
            $('#modal-jenis-marker #btn-pointer-1').addClass('active')
            $('#modal-jenis-marker #btn-pointer-2').removeClass('active')
           
        }else{
            $('#modal-jenis-marker #btn-pointer-2').addClass('active')
            $('#modal-jenis-marker #btn-pointer-1').removeClass('active')
            
        }
        $('#div-map').removeClass("d-none")
    }
}

function overlayClickListener(overlay) {
    google.maps.event.addListener(overlay, "mouseup", function (event) {
        const polygon = overlay.getPath().getArray();
        // for (var i = 0; i < event.overlay.getPath().getLength(); i++) {
        //     document.getElementById('koordinat').value += polygon.getPath().getAt(i).toUrlValue(6) + "<br>";
        // }
        $('#modal-nama-marker #koordinat').val(JSON.stringify(overlay.getPath().getArray()));

       
    });
}

let polygonMarkers=[]
function renderMap(vlat=0,vlong=0) {
    var sby = {  
        lat: parseFloat(vlat)==0?-7.270840:parseFloat(vlat),
        lng: parseFloat(vlong)==0?112.765994:parseFloat(vlong) };
    const markers = [];
    
    var mapOptions = {
      center: sby,
      zoom: 12
    };

    this.setMapOnAll = function (map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      };
    
    map = new google.maps.Map(document.getElementById("Maplokasi"), mapOptions);

    // Create the search box and link it to the UI element.
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
      searchBox.setBounds(map.getBounds());
    });
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }
        // Clear out the old markers.
        // markers.forEach((marker) => {
        //   marker.setMap(null);
        // });
        // markers = [];
        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {
          if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
          }
          const icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25),
          };
          /*// Create a marker for each place.
          markers.push(
            new google.maps.Marker({
              map,
              icon,
              title: place.name,
              position: place.geometry.location,
            })
          );*/

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });
        map.fitBounds(bounds);
    });

    let icon = {
        url: baseUrl+"assets/extends/img/office.svg", // url
        scaledSize: new google.maps.Size(50, 50), // scaled size
        origin: new google.maps.Point(0,0), // origin
        anchor: new google.maps.Point(25, 25) // anchor
    };
    marker = new google.maps.Marker({
        position: new google.maps.LatLng($("#lat-inp").val(), $("#lng-inp").val()),
        map: map,
        icon:icon
      });
      marker.setMap(map);
    
      //$('#btn-create').removeClass('d-none')  
    
    $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: urlApi + "office/web?only_active=",
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
        },
        success: function (response) {
        let office=response.data.office
          for(var i=0;i<office.length;i++){
              let ofcLoc=office[i].office_locations
              if(office[i].location_type=="1"){
                for(var o=0;o<ofcLoc.length;o++){
                    let icon = {
                        url: baseUrl+"assets/extends/img/office.svg", // url
                        scaledSize: new google.maps.Size(50, 50), // scaled size
                        origin: new google.maps.Point(0,0), // origin
                        anchor: new google.maps.Point(25, 25) // anchor
                    };
                    markers[i] = new google.maps.Marker({
                        position: new google.maps.LatLng(ofcLoc[o].latitude, ofcLoc[o].longitude),
                        map: map,
                        id_lokasi:office[i].id,
                        icon:icon
                    })
                    
                    let infowindow = new google.maps.InfoWindow({
                        content: `<strong>`+office[i].name+`</strong><br/> Radius:`+office[i]?.office_locations[0]?.radius+` Meter`,
                        maxWidth: 250,
                        minWidth: 120
                    });
                    let resMarker=office[i]
                    marker = markers[i];
                    (function(marker, i) {
                        // add click event
                        
                        google.maps.event.addListener(markers[i], 'click', function() {
                            showDetail(markers[i].id_lokasi,markers[i]);
                            //changeColorMarker(resMarker,markers[i],'on')
                        });
                        google.maps.event.addListener(marker, 'mouseover', function() {
                            infowindow.open(map,markers[i]);
                            //changeColorMarker(resMarker,markers[i],'off')
                        });
                        // assuming you also want to hide the infowindow when user mouses-out
                        marker.addListener('mouseout', function() {
                            infowindow.close();
                        });
                    })(marker, i);
                }
              }else{
                const polygonCoord=[]
                //let id_for_marker=''
                for(var o=0;o<ofcLoc.length;o++){
                    //id_for_marker=''
                    polygonCoord.push({
                        lat: parseFloat(ofcLoc[o].latitude), lng: parseFloat( ofcLoc[o].longitude)
                    })
                }
               
                  // Construct the polygon.
                  polygonMarkers[o] = new google.maps.Polygon({
                    paths: polygonCoord,
                    strokeColor: "#00A1D3",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#00A1D3",
                    fillOpacity: 0.35,
                    id_lokasi:office[i].id,
                  });
                  
                  polygonMarkers[o].setMap(map);

                  let infowindowpolygon = new google.maps.InfoWindow({
                    content: `<strong>`+office[i].name+`</strong>`,
                    position:polygonCoord[0],
                    maxWidth: 250,
                    minWidth:120
                    });
                  let resPolygon=office[i]

                  polygonMarker = polygonMarkers[o];
                  (function(polygonMarker, o) {
                    // add click event
                    google.maps.event.addListener(polygonMarkers[o], 'click', function() {
                          showDetail(polygonMarkers[o].id_lokasi,polygonMarkers[o]);
                      });
                    google.maps.event.addListener(polygonMarkers[o], 'mouseover', function(event) {
                        infowindowpolygon.open(map,polygonMarkers[o]);
                        //changeColorPolygon(resPolygon,polygonMarkers[o],'on')
                    });
                    // assuming you also want to hide the infowindowpolygon when user mouses-out
                    polygonMarker.addListener('mouseout', function() {
                        infowindowpolygon.close();
                        //changeColorPolygon(resPolygon,polygonMarkers[o],'off')
                    });
                  })(polygonMarker, o);
              }
                
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          handleErrorDetail(xhr);
        },
    });
}

function renderMapModal(vlat=0,vlong=0) {
    var sby = {  
        lat: parseFloat(vlat)==0?-7.270840:parseFloat(vlat),
        lng: parseFloat(vlong)==0?112.765994:parseFloat(vlong) };
    const markers = [];
    
    var mapOptions = {
      center: sby,
      zoom: 12
    };

    this.setMapOnAll = function (mapModal) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(mapModal);
        }
      };
    
    mapModal = new google.maps.Map(document.getElementById("map-modal"), mapOptions);

    // Create the search box and link it to the UI element.
    const inputModal = document.getElementById("pac-input-modal");
    const searchBox = new google.maps.places.SearchBox(inputModal);
    mapModal.controls[google.maps.ControlPosition.TOP_LEFT].push(inputModal);
    // Bias the SearchBox results towards current map's viewport.
   
    mapModal.addListener("bounds_changed", () => {
      searchBox.setBounds(mapModal.getBounds());
    });
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }
        // Clear out the old markers.
        // markers.forEach((marker) => {
        //   marker.setMap(null);
        // });
        // markers = [];
        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {
          if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
          }
          const icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25),
          };
          /*// Create a marker for each place.
          markers.push(
            new google.maps.Marker({
              map,
              icon,
              title: place.name,
              position: place.geometry.location,
            })
          );*/

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });
        mapModal.fitBounds(bounds);
    });
    let icon = {
        url: baseUrl+"assets/extends/img/office.svg", // url
        scaledSize: new google.maps.Size(50, 50), // scaled size
        origin: new google.maps.Point(0,0), // origin
        anchor: new google.maps.Point(25, 25) // anchor
    };
    marker = new google.maps.Marker({
        position: new google.maps.LatLng($("#lat-inp").val(), $("#lng-inp").val()),
        map: mapModal,
        icon:icon
      });
      marker.setMap(mapModal);
    
      //$('#btn-create').removeClass('d-none')  
    
    // $.ajax({
    //     type: "GET",
    //     headers: {
    //       "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //     },
    //     url: urlApi + "office?only_active=",
    //     beforeSend: function (xhr) {
    //       xhr.setRequestHeader(
    //         "Authorization",
    //         "Bearer " + localStorage.getItem("token")
    //       );
    //     },
    //     success: function (response) {
    //     let office=response.data.office
    //       for(var i=0;i<office.length;i++){
    //           let ofcLoc=office[i].office_locations
    //           if(office[i].location_type=="1"){
    //             for(var o=0;o<ofcLoc.length;o++){
    //                 let icon = {
    //                     url: baseUrl+"assets/extends/img/office.svg", // url
    //                     scaledSize: new google.maps.Size(50, 50), // scaled size
    //                     origin: new google.maps.Point(0,0), // origin
    //                     anchor: new google.maps.Point(25, 25) // anchor
    //                 };
    //                 markers[i] = new google.maps.Marker({
    //                     position: new google.maps.LatLng(ofcLoc[o].latitude, ofcLoc[o].longitude),
    //                     map: map,
    //                     id_lokasi:office[i].id,
    //                     icon:icon
    //                 })
    //                 marker = markers[i];
    //                 (function(marker, i) {
    //                     // add click event
    //                     google.maps.event.addListener(markers[i], 'click', function() {
    //                         showDetail(markers[i].id_lokasi,markers[i]);
    //                     });
    //                 })(marker, i);
    //             }
    //           }else{
    //             const polygonCoord=[]
    //             //let id_for_marker=''
    //             for(var o=0;o<ofcLoc.length;o++){
    //                 //id_for_marker=''
    //                 polygonCoord.push({
    //                     lat: parseFloat(ofcLoc[o].latitude), lng: parseFloat( ofcLoc[o].longitude)
    //                 })
    //             }
               
    //               // Construct the polygon.
    //               polygonMarkers[o] = new google.maps.Polygon({
    //                 paths: polygonCoord,
    //                 strokeColor: "#00A1D3",
    //                 strokeOpacity: 0.8,
    //                 strokeWeight: 2,
    //                 fillColor: "#00A1D3",
    //                 fillOpacity: 0.35,
    //                 id_lokasi:office[i].id,
    //               });
                  
    //               polygonMarkers[o].setMap(map);

    //               polygonMarker = polygonMarkers[o];
    //               (function(polygonMarker, o) {
    //                   // add click event
    //                   google.maps.event.addListener(polygonMarkers[o], 'click', function() {
    //                       showDetail(polygonMarkers[o].id_lokasi,polygonMarkers[o]);
    //                   });
    //               })(polygonMarker, o);
    //           }
                
    //         }
    //     },
    //     error: function (xhr, ajaxOptions, thrownError) {
    //       handleErrorDetail(xhr);
    //     },
    // });
}

var markersArray=[]
function updateMap(vlat=0,vlong=0){
    var sby = {  
        lat: parseFloat(vlat)==0?-7.270840:parseFloat(vlat),
        lng: parseFloat(vlong)==0?112.765994:parseFloat(vlong)
    };
    google.maps.Map.prototype.clearOverlays = function() {
        for (var i = 0; i < markersArray.length; i++ ) {
          markersArray[i].setMap(null);
        }
        markersArray.length = 0;
    }
    mapModal.clearOverlays();
    $('#pac-input-modal').val("")

    mapModal.setCenter(sby);
    mapModal.setZoom(12);

    marker = new google.maps.Marker({
        position: new google.maps.LatLng($("#lat-inp").val(), $("#lng-inp").val()),
        map: mapModal,
      });
      marker.setMap(mapModal);
      markersArray.push(marker);
}

let currentEdited=''
let currentEditedType=''
let currentEditedData=''


function showDetail(id,thismarker){
    clearForm()
    $('#id-map').val(id)
    if(mapModal!==undefined){
        updateMap()
    }else{
        renderMapModal()
    }
    sDivisi()
    
    currentEditedType=""
    if (id != null) {
        $.ajax({
          type: "GET",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Authorization":"Bearer " + localStorage.getItem("token")
          },
          url: urlApi + "office/" + id,
          success: function (response) {
            res = response.data.office;
            $('#modal-jenis-marker').modal('show')
            pointerPeta(res.location_type)
            //createSimpan()

            const newPolygonCoord=[]
            let ofcLoc=res.office_locations

            if(res.location_type=='1'){
                currentEditedType='1'
                changeColorMarkerModal(res,thismarker)

                for(n in ofcLoc){
                    $('#modal-nama-marker #koordinat').val(JSON.stringify({
                        lat: parseFloat(ofcLoc[n].latitude), lng: parseFloat( ofcLoc[n].longitude)
                    }))
                }
            }else{
                currentEditedType='2'
                changeColorPolygonModal(res,thismarker)
                
                for(n in ofcLoc){
                    newPolygonCoord.push({
                        lat: parseFloat(ofcLoc[n].latitude), lng: parseFloat( ofcLoc[n].longitude)
                    })
                }
                $('#modal-nama-marker #koordinat').val(JSON.stringify(newPolygonCoord));
            }
            $('#btn-lokasi').removeClass('d-none')

            //pointerPeta(res.location_type)

            $('#pac-input-modal').val(res.name)
            let txtRadius=res.location_type=='1'?res.office_locations[0].radius:''
            $('#txt-radius').val(txtRadius)

            let dv = "";
            if(res.divisi!==null){
                dv +=
                    "<option selected='selected' value='" +
                    res.divisi.id +
                    "'>" +
                    res.divisi.name +
                    "</option>";

                $("#divisi").append(dv).trigger("change");
            }
            sDivisi()

            $('#btn-hapus').removeClass('d-none')

            // $("#name").val(noZero(res.name))
            // $("#address").val(noZero(res.address))
            // $("#id").val(id)
            // $('#modal-add .modal-title').html("Edit Instansi")
            // $('#modal-add').modal('show')

            ewpLoadingHide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
        });
    }
}

function changeColorPolygon(res,thismarker,status){
    currentEdited=''
    currentEditedData=``
    const newPolygonCoord=[]
    let ofcLoc=res.office_locations
    currentEdited=thismarker
    currentEditedData=res
    for(n in ofcLoc){
        newPolygonCoord.push({
            lat: parseFloat(ofcLoc[n].latitude), lng: parseFloat( ofcLoc[n].longitude)
        })
    }
    let colorShow=status=='on'?"#FCAD00":"#00A1D3"
    thismarker.setMap(null);
    let newpolygonMarkers =  new google.maps.Polygon({
        paths: newPolygonCoord,
        strokeColor: colorShow,
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: colorShow,
        fillOpacity: 0.35,
        id_lokasi:res.id,
    });
        
    newpolygonMarkers.setMap(map);
    polygonMarkers.push(newpolygonMarkers)
}

function changeColorMarker(res,thismarker,status){
    currentEdited=''
    currentEditedData=``
    const newPolygonCoord=[]
    let ofcLoc=res.office_locations
    currentEdited=thismarker
    currentEditedData=res
    thismarker.setMap(null);
    for(n in ofcLoc){
        let newMarker=''
        let iconShow=status=='on'?"office-marked":"office"
        let icon = {
            url: baseUrl+"assets/extends/img/"+iconShow+".svg", // url
            scaledSize: new google.maps.Size(50, 50), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(25, 25) // anchor
        };
        newMarker = new google.maps.Marker({
            position: new google.maps.LatLng(ofcLoc[n].latitude, ofcLoc[n].longitude),
            map: map,
            id_lokasi:res.id,
            icon:icon
        })
        marker = newMarker;
       
    }
}

// function changeColorPolygonModal(res,thismarker,status){
//     currentEdited=''
//     currentEditedData=``
//     const newPolygonCoord=[]
//     let ofcLoc=res.office_locations
//     currentEdited=thismarker
//     currentEditedData=res
//     for(n in ofcLoc){
//         newPolygonCoord.push({
//             lat: parseFloat(ofcLoc[n].latitude), lng: parseFloat( ofcLoc[n].longitude)
//         })
//     }
//     let colorShow=status=='on'?"#FCAD00":"#00A1D3"
//     thismarker.setMap(null);
//     let newpolygonMarkers =  new google.maps.Polygon({
//         paths: newPolygonCoord,
//         strokeColor: colorShow,
//         strokeOpacity: 0.8,
//         strokeWeight: 2,
//         fillColor: colorShow,
//         fillOpacity: 0.35,
//         id_lokasi:res.id,
//     });
        
//     newpolygonMarkers.setMap(mapModal);
//     polygonMarkers.push(newpolygonMarkers)
// }

// function changeColorMarkerModal(res,thismarker,status){
//     currentEdited=''
//     currentEditedData=``
//     const newPolygonCoord=[]
//     let ofcLoc=res.office_locations
//     currentEdited=thismarker
//     currentEditedData=res
//     thismarker.setMap(null);
//     for(n in ofcLoc){
//         let newMarker=''
//         let iconShow=status=='on'?"office-marked":"office"
//         let icon = {
//             url: baseUrl+"assets/extends/img/"+iconShow+".svg", // url
//             scaledSize: new google.maps.Size(50, 50), // scaled size
//             origin: new google.maps.Point(0,0), // origin
//             anchor: new google.maps.Point(25, 25) // anchor
//         };
//         newMarker = new google.maps.Marker({
//             position: new google.maps.LatLng(ofcLoc[n].latitude, ofcLoc[n].longitude),
//             map: map,
//             id_lokasi:res.id,
//             icon:icon
//         })
//         marker = newMarker;
//        newMarker.setMap(mapModal);
//     }
// }




function changeColorPolygonModal(res,thismarker,status){
    // currentEdited=''
    // currentEditedData=``
    const newPolygonCoord=[]
    let ofcLoc=res.office_locations
    // currentEdited=thismarker
    // currentEditedData=res
    for(n in ofcLoc){
        newPolygonCoord.push({
            lat: parseFloat(ofcLoc[n].latitude), lng: parseFloat( ofcLoc[n].longitude)
        })
    }
    // let colorShow=status=='on'?"#FCAD00":"#00A1D3"
    // thismarker.setMap(null);
    let newpolygonMarkers =  new google.maps.Polygon({
        paths: newPolygonCoord,
        strokeColor: "#FCAD00",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FCAD00",
        fillOpacity: 0.35,
        id_lokasi:res.id,
    });
        
    newpolygonMarkers.setMap(mapModal);
    modalPoly.push(newpolygonMarkers)
}

function changeColorMarkerModal(res,thismarker,status){
    // currentEdited=''
    // currentEditedData=``
    // const newPolygonCoord=[]
    let ofcLoc=res.office_locations
    // currentEdited=thismarker
    // currentEditedData=res
    // thismarker.setMap(null);
    for(n in ofcLoc){
        let newMarker=''
        let icon = {
            url: baseUrl+"assets/extends/img/office-marked.svg", // url
            scaledSize: new google.maps.Size(50, 50), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(25, 25) // anchor
        };
        newMarker = new google.maps.Marker({
            position: new google.maps.LatLng(ofcLoc[n].latitude, ofcLoc[n].longitude),
            map: map,
            id_lokasi:res.id,
            icon:icon
        })
        //marker = newMarker;
        newMarker.setMap(mapModal);
        modalMarker.push(newMarker)
    }
}

function batalEdit(){
    let res=currentEditedData
    if(currentEditedType=='1'){
        const newPolygonCoord=[]
        let ofcLoc=res.office_locations
        currentEdited.setMap(null);
        for(n in ofcLoc){
            let newMarker=''
            let icon = {
                url: baseUrl+"assets/extends/img/office.svg", // url
                scaledSize: new google.maps.Size(50, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(25, 25) // anchor
            };
            newMarker = new google.maps.Marker({
                position: new google.maps.LatLng(ofcLoc[n].latitude, ofcLoc[n].longitude),
                map: map,
                id_lokasi:res.id,
                icon:icon
            })
            marker = newMarker;
            (function(marker) {
                // add click event
                google.maps.event.addListener(marker, 'click', function() {
                    showDetail(marker.id_lokasi,marker);
                });
            })(marker);
           
        }
    }else{
        const newPolygonCoord=[]
        let ofcLoc=res.office_locations
        for(n in ofcLoc){
            newPolygonCoord.push({
                lat: parseFloat(ofcLoc[n].latitude), lng: parseFloat( ofcLoc[n].longitude)
            })
        }
        currentEdited.setMap(null);
        let newpolygonMarkers =  new google.maps.Polygon({
            paths: newPolygonCoord,
            strokeColor: "#00A1D3",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#00A1D3",
            fillOpacity: 0.35,
            id_lokasi:res.id,
        });
            
        newpolygonMarkers.setMap(map);
        //polygonMarkers.push(newpolygonMarkers)
        (function(newpolygonMarkers) {
            // add click event
            google.maps.event.addListener(newpolygonMarkers, 'click', function() {
                showDetail(newpolygonMarkers.id_lokasi,newpolygonMarkers);
            });
        })(newpolygonMarkers);
    }
}

function hapusLokasi(){
    let id= $('#id-map').val()
    ewpLoadingShow()
    $.ajax({
        type: "DELETE",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        "Authorization": "Bearer " + localStorage.getItem("token") },
        url: urlApi+"office/" + id ,
        success: function (response) {
        ewpLoadingHide()
        $('#modal-jenis-marker').modal('hide')
        toastr.success("Status Berhasil Diubah!");
        location.reload()
        },
        error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide()
            handleErrorDetail(xhr)
        },
    });
}

function sDivisi() {
    $("#divisi").select2({
        allowClear: true,
        placeholder: "Pilih Divisi",
        ajax: {
            url: urlApi + "select_list/divisi",
            dataType: "json",
            type: "GET",
            quietMillis: 50,
            headers: {
                "Authorization" : "Bearer "+localStorage.getItem('token'),
            },
            
            data: function (term) {
            return {
                search:term.term,
            };
            },
            processResults: function (data) {
            return {
                results: $.map(data.data.division, function (item) {
                return {
                    text: item.name,
                    id: item.id,
                };
                }),
            };
            },
        },
        });
    }

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };