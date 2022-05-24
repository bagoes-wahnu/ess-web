jQuery(document).ready(function($) {
	//table()
    $('#mn-master').addClass('active')
    $('#mn-master .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-master .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-master-parent').addClass('hover show')
    $('#mn-master-parent menu-sub').addClass('hover show')
    $('#dd-tahun').addClass('text-primary font-weight-bolder').removeClass('menu-title')

    $("#tahun").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
    });
});	

function table() {
  document.getElementById("table-wrapper").innerHTML = ewpTable({
    targetId: "dttb-master-instansi",
    class: "table table-row-bordered bg-default table-head-custom table-vertical-center",
    column: [
    { name: "No", width: "10" },
    { name: "Nama", width: "20" },
    { name: "Alamat", width: "35" },
    { name: "Status", width: "15" },
    { name: "Action", width: "15" },
    ],
  });
  
  geekDatatables({
    target: "#dttb-master-instansi",
    url: urlApi + "instansi",
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
      col: "address", 
      mid: true,
      mod: {
        aTargets: [2],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          return noNull(data)
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
              console.log(is_active)
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
            <button class="btn btn-icon btn-color-warning btn-active-light-warning" onclick="edit(`+data+`)" 
            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
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

function clearForm(){
    $("#tahun").val("")
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
          url: urlApi + "instansi/" + id,
          success: function (response) {
            res = response.data.instansi;
            
            $("#name").val(noZero(res.name))
            $("#address").val(noZero(res.address))
            $("#id").val(id)
            $('#modal-add .modal-title').html("Edit Tahun")
            $('#modal-add').modal('show')

            ewpLoadingHide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
        });
    }
}

function tambah(){
    clearForm()
    $('#modal-add .modal-title').html("Tambah Tahun")
    $('#modal-add').modal('show')
}

function simpan(){
    ewpLoadingShow();
    loadStart();
    var data = {
        name: $("#name").val(),
        address: $("#address").val(),
      }
      console.log(data);
  
      var tipe = $("#id").val() == "" ? "POST" : "PUT";
      var link = $("#id").val() == "" ? urlApi + "instansi" : urlApi + "instansi/" + $("#id").val()
  
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
        url: urlApi+"instansi/" + id ,
        success: function (response) {
        toastr.success("Status Berhasil Diubah!");
        table();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            handleErrorDetail(xhr)
        },
    });
}

function divisi(){
    window.location.href=baseUrl+"tahun/divisi/id"
}

function targetNilai(){
    window.location.href=baseUrl+"tahun/target-nilai/id1/id2"
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