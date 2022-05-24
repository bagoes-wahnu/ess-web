let is_tambah=false;
let markersAdd=[]
let all_overlays=[]
var drawingManager
var listener
var map
let is_radius=true;

$(document).ready(function () {
    //renderMap();
    $('#mn-lokasi-kantor').addClass('active')
});

function create(){
    is_tambah=true
    $('#modal-jenis-marker').modal('show')
    clearForm()
    //$('#btn-pointer-1').click()
    $('#div-nama').addClass('d-none')
    

}

function clearForm(){
    $('#txt-name').val("")
    $('#txt-radius').val("")
    $('#txt-name').addClass("d-none")
    $('.div-radius').addClass("d-none")
    $('#btn-pointer-1').removeClass('active')
    $('#btn-pointer-2').removeClass('active')
    $('#id-map').val("")
}

function createSimpan(){
    is_tambah=false
    let param=is_radius
    if(param=='1'){
        $('#text-radius').removeClass('d-none')
        listener = google.maps.event.addListener(map, "click", function (event) {
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
                map: map,
                icon:icon
                });
            }
            markersAdd.push(marker);
            
            $('#koordinat').val(JSON.stringify(event.latLng));

            $("#lat-inp").val(event.latLng.lat());
            $("#lng-inp").val(event.latLng.lng());
    });
        
    }else{
        $('#text-polygon').removeClass('d-none')
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            },
            polygonOptions: {
                editable: true  
            }
        });
        drawingManager.setMap(map);

        google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
            const newShape = event.overlay;
            newShape.type = event.type;
            
        });
    
        google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
            overlayClickListener(event.overlay);
            const polygon = event.overlay.getPath().getArray();
            $('#koordinat').val(JSON.stringify(event.overlay.getPath().getArray()));
            all_overlays.push(event);
        });
    }
    
    $('#btn-simpan').removeClass('d-none')
    $('#btn-batal').removeClass('d-none')
    $('#btn-create').addClass('d-none')
    $('#modal-jenis-marker').modal('hide')
    $('#btn-pointer-1').removeClass('active')
    $('#btn-pointer-2').removeClass('active')
    
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
    $('#text-polygon').addClass('d-none')
    $('#text-radius').addClass('d-none')

    
    let LocationArr=[]

    if(is_radius==true){
        let koordinat=JSON.parse($('#koordinat').val())
        LocationArr=[{
            "longitude": koordinat.lng,
            "latitude": koordinat.lat,
            "radius": $('#txt-radius').val(),
            "order_number": null
        }]
    }else{
        let koordinat=JSON.parse($('#koordinat').val())
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
        name:$('#txt-name').val(),
        location_type:is_radius==true?1:2,
        office_locations:LocationArr
    }
    
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
    }else{
        drawingManager.setMap(null);
        drawingManager.setDrawingMode(null);
    
        for(a in all_overlays){
            all_overlays[a].overlay.setMap(null);
        }
        all_overlays=[]
    }
    
    
    $('#btn-simpan').addClass('d-none')
    $('#btn-batal').addClass('d-none')
    $('#btn-create').removeClass('d-none')
    $('#text-polygon').addClass('d-none')
    $('#text-radius').addClass('d-none')
}

function pointerPeta(param){
    if(param!==null){
        is_radius=param
        $('#Maplokasi').css("cursor","pointer")
        if(is_radius==true){
            $('.div-radius').removeClass("d-none")
            $('#txt-name').removeClass("d-none")
        }else{
            $('.div-radius').addClass("d-none")
            $('#txt-name').removeClass("d-none")
        }
       
        $('#div-nama').removeClass('d-none')
        if(param=='1'){
            $('#btn-pointer-1').addClass('active')
            $('#btn-pointer-2').removeClass('active')
           
        }else{
            $('#btn-pointer-2').addClass('active')
            $('#btn-pointer-1').removeClass('active')
            
        }
    }
}

function overlayClickListener(overlay) {
    google.maps.event.addListener(overlay, "mouseup", function (event) {
        const polygon = overlay.getPath().getArray();
        // for (var i = 0; i < event.overlay.getPath().getLength(); i++) {
        //     document.getElementById('koordinat').value += polygon.getPath().getAt(i).toUrlValue(6) + "<br>";
        // }
        $('#koordinat').val(JSON.stringify(overlay.getPath().getArray()));

       
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
    
      $('#btn-create').removeClass('d-none')  
    
    $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: urlApi + "office?only_active=",
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
                    marker = markers[i];
                    (function(marker, i) {
                        // add click event
                        google.maps.event.addListener(markers[i], 'click', function() {
                            showDetail(markers[i].id_lokasi,markers[i]);
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

                  polygonMarker = polygonMarkers[o];
                  (function(polygonMarker, o) {
                      // add click event
                      google.maps.event.addListener(polygonMarkers[o], 'click', function() {
                          showDetail(polygonMarkers[o].id_lokasi,polygonMarkers[o]);
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

let currentEdited=''
let currentEditedType=''
let currentEditedData=''

function showDetail(id,thismarker){
    $('#id-map').val(id)
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
            if(res.location_type=='1'){
                currentEditedType='1'
                changeColorMarker(res,thismarker)
            }else{
                currentEditedType='2'
                changeColorPolygon(res,thismarker)
            }
            $('#btn-lokasi').removeClass('d-none')

            pointerPeta(res.location_type)
            $('#txt-name').val(res.name)
            let txtRadius=res.location_type=='1'?res.office_locations[0].radius:''
            $('#txt-radius').val(txtRadius)
            
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



function changeColorPolygon(res,thismarker){
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
    thismarker.setMap(null);
    let newpolygonMarkers =  new google.maps.Polygon({
        paths: newPolygonCoord,
        strokeColor: "#FCAD00",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FCAD00",
        fillOpacity: 0.35,
        id_lokasi:res.id,
    });
        
    newpolygonMarkers.setMap(map);
    polygonMarkers.push(newpolygonMarkers)
}

function changeColorMarker(res,thismarker){
    currentEdited=''
    currentEditedData=``
    const newPolygonCoord=[]
    let ofcLoc=res.office_locations
    currentEdited=thismarker
    currentEditedData=res
    thismarker.setMap(null);
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
        marker = newMarker;
       
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