jQuery(document).ready(function($) {

	table()
  sKantor()

    $('#mn-master').addClass('active')
    $('#mn-master .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-master .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-master-parent').addClass('hover show')
    $('#mn-master-parent menu-sub').addClass('hover show')
    $('#dd-divisi').addClass('text-primary font-weight-bolder').removeClass('menu-title')



});	

function table() {

  document.getElementById("table-wrapper").innerHTML = ewpTable({
    targetId: "dttb-master-divisi",
    class: "table table-row-bordered bg-default table-head-custom table-vertical-center",
    column: [
    { name: "No", width: "10" },
    { name: "Nama", width: "20" },
    { name: "Lokasi", width: "35" },
    { name: "Status", width: "15" },
    { name: "Action", width: "15" },
    ],
  });
  
  geekDatatables({
    target: "#dttb-master-divisi",
    url: urlApi + "division",
    sorting: [0, "desc"],
    apiKey: "data",
    column: [
    {
      col: "id", 
      mid: true,
      mod: {
        aTargets: [0],
        bSortable:false,
        mRender: function (data, type, full,draw) {

          var row = draw.row;
          var start = draw.settings._iDisplayStart;
          var length = draw.settings._iDisplayLength;

          var counter = start + 1 + row;

          return counter;
        },
      },
    },
    {
      col: "name", 
      mid: true,
      mod: {
        aTargets: [1],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          return noNull(data)
        },
      },
    },
    {
      col: "offices", 
      mid: true,
      mod: {
        aTargets: [2],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          // console.log(data)

          let lokasi = ' - '
          if (data.length > 0) {
            lokasi = data[0].name
          }
          return lokasi
        },
      },
    },
    {
        col: "id", 
        mid: true,
        mod: {
          aTargets: [3],
          bSortable:false,
          mRender: function (data, type, full,draw) {
              let is_active=full.status=="1"?"checked='checked'":""

              let htmlStatus=`
                <div style="padding: 0 3rem;">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="" id="check-`+data+`" `+is_active+` onclick="changeStatus(`+data+`)"/>
                        <label class="form-check-label" for="chk-switch"></label>
                    </div>
                </div>`
            return htmlStatus
          },
        },
      },
    {
      col: "id",
      mid: true,
      mod: {
        aTargets: [-1],
        bSortable:false,
        mRender: function (data, type, full) {
        	var btn = `
            <button class="btn btn-icon btn-color-success btn-active-light-success" onclick="karyawan(`+data+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Karyawan">
              <i class="fa fa-users"></i>
            </button>

            <button class="btn btn-icon btn-color-warning btn-active-light-warning"  onclick="edit(`+data+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Divisi">
              <i class="bi bi-pencil-fill"></i>
            </button>
            `
            return btn
        },
      },
    },
   ],
 });

}

function karyawan(id_divisi) {
  window.location.href = baseUrl+'divisi/karyawan/'+id_divisi;
}

function addKaryawan() {
  Swal.fire("Berhasil!", "Karyawan berhasil ditambahkan. ", "success");
}

function clearForm(){
    $("#nama-divisi").val("")

    $("#lokasi-kantor").val("")
    $("#lokasi-kantor").change()
    $("#id").val("")
}

function edit(id){
    clearForm()
    ewpLoadingShow();
    if (id != null) {
        $.ajax({
          type: "GET",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Authorization":"Bearer " + localStorage.getItem("token")
          },
          url: urlApi + "division/" + id,
          success: function (response) {
            res = response.data;
            console.log(res)

            $("#nama-divisi").val(noZero(res.name))

            // $("#lokasi-kantor").val(res.lokasi_id)
            // $("#lokasi-kantor").change()

            $("#id").val(id)

            let selected_lokasi =  "<option selected='selected' value='" + res.lokasi_id + "'>" + res.nama_kantor + "</option>";
            $("#lokasi-kantor").append(selected_lokasi).trigger("change");

            sKantor()

            ewpLoadingHide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
        });
    }

    $('#modal-add .modal-title').html("Edit Divisi")
    $('#modal-add').modal('show')
}

function tambah(){
    clearForm()
    $('#modal-add .modal-title').html("Tambah Divisi")
    $('#modal-add').modal('show')
}

function simpan(){
    ewpLoadingShow();
    loadStart();
    var data = {
        name: $("#nama-divisi").val(),
        lokasi_id: $("#lokasi-kantor").val(),
      }
  
      var tipe = $("#id").val() == "" ? "POST" : "PUT";
      var link = $("#id").val() == "" ? urlApi + "division" : urlApi + "division/" + $("#id").val()
  
      $.ajax({
          type: tipe,
          dataType: "json",
          data: data,
          url: link,
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Authorization":"Bearer " + localStorage.getItem("token")
          },
          success: function (response) {
              // console.log(response);
              ewpLoadingHide();
              loadStop()
  
              var resSwal= $("#id").val() == "" ? "disimpan" : "diubah";
              Swal.fire("Success!", "Data berhasil "+resSwal, "success");
              $('#modal-add').modal('hide')
              table()
          },
          error: function (xhr, ajaxOptions, thrownError) {
              ewpLoadingHide();
              loadStop()
              handleErrorDetail(xhr)
          },
      });
}

function changeStatus(id) {
  $.ajax({
      type: "PATCH",
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      "Authorization": "Bearer " + localStorage.getItem("token") },
      data: {
          status: document.getElementById("check-" + id).checked ? true : false,
      },
      url: urlApi+"division/change-status/" + id ,
      success: function (response) {
      toastr.success("Status Berhasil Diubah!");
      table();
      },
      error: function (xhr, ajaxOptions, thrownError) {
          handleErrorDetail(xhr)
      },
  });
}


function sKantor() {

  console.log('sKantor runned')

    $("#lokasi-kantor").select2({
        allowClear: true,
        placeholder: "Pilih Lokasi",
        // dropdownParent: $('#modal-add'),
        ajax: {
            url: urlApi + "select_list/office",
            dataType: "json",
            type: "GET",
            quietMillis: 50,
            headers: {
                "Authorization" : "Bearer "+localStorage.getItem('token'),
            },
            
            data: function (term) {
            return {
                search:term.term,
                status:1,
            };
            },
            processResults: function (data) {
            return {
                results: $.map(data.data.office, function (item) {
                return {
                    text: item.name,
                    id: item.id,
                };
              }),
            };
          },
        },
      });

    // if (id_selected !== false) {
    //   $("#lokasi-kantor").val(id_selected)
    //   $("#lokasi-kantor").change()
    // }
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
