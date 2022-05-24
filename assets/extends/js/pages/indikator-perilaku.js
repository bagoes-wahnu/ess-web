jQuery(document).ready(function($) {
	table()
  $('#mn-master').addClass('active')
  $('#mn-master .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
  $('#mn-master .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
  $('#mn-master-parent').addClass('hover show')
  $('#mn-master-parent menu-sub').addClass('hover show')
  $('#dd-indikator-perilaku').addClass('text-primary font-weight-bolder').removeClass('menu-title')
});	

function table() {

  document.getElementById("table-wrapper").innerHTML = ewpTable({
    targetId: "dttb-master-indikator-perilaku",
    class: "table table-row-bordered bg-default table-head-custom table-vertical-center",
    column: [
    { name: "No", width: "10" },
    { name: "Tata Nilai", width: "20" },
    { name: "Aspek Perilaku", width: "35" },
    { name: "Status", width: "15" },
    { name: "Action", width: "15" },
    ],
  });
  geekDatatables({
    target: "#dttb-master-indikator-perilaku",
    url: urlApi + "behavior-aspect-indicator",
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
        col: "behavior_indicators.name", 
        mid: true,
        mod: {
          aTargets: [1],
          bSortable:false,
          mRender: function (data, type, full,draw) {
            // console.log(data)
            return data
          },
        },
      },
      {
        col: "name", 
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
              <button class="btn btn-icon btn-color-warning btn-active-light-warning"  onclick="edit(`+data+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Indikator Perilaku">
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
  $("#nama-indikator").val("")
  $("#nama-aspek").val("")
  // $("#lokasi-kantor").val("")
  // $("#lokasi-kantor").change()
  $('#modal-add #select-indicator').val(null).trigger("change"),
  $('#modal-add #select-indicator-edit').val(null).trigger("change"),
  $("#modal-add input.menu-1").prop("checked", false);
  $("#modal-add input.menu-2").prop("checked", false);
  $("#id").val("")
}

function changeName(){
  $("#modal-add #nama-indikator").val($("#select-indicator-edit").find(":selected").text());
}

function indicator(){
  $("#change-button").removeClass("d-none");
  $('#change-button').html(
    `
    <button type="button" id="btn-tambah-aspect" onclick="simpan_indicator()" class="btn btn-primary">
        <span class="indicator-label">Simpan</span>
        <span class="indicator-progress">Please wait...
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    </button>
    `
    )
}

function aspek(){
  $("#change-button").removeClass("d-none");
  $('#change-button').html(
    `
    <button type="button" id="btn-tambah-aspect" onclick="simpan_aspect('t')" class="btn btn-primary">
      <span class="indicator-label">Simpan</span>
      <span class="indicator-progress">Please wait...
      <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    </button>
    `
    )
}

function edit(id){
  clearForm()
  ewpLoadingShow();
  $("#modal-add input.menu-2").prop("checked", true);
  $("#modal-add #label-indicator").removeClass("active");
  $("#modal-add #label-aspect").addClass("active");
  $("#kt_widget_tab_1").removeClass("active show");
  $("#kt_widget_tab_2").addClass("active show");
  $(".menu-form-pilih").removeClass("active show");
  $("#modal-add #indicator-edit").removeClass("d-none");
  $("#modal-add #indicator-add").addClass("d-none");
  aspek()
  $('#add-menu').html(
    `
    <label id="label-indicator" class="mt-2 btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 ms-0 me-2" data-bs-toggle="tab" href="#kt_widget_tab_1" data-kt-button="true">
      <span class="form-check form-check-custom form-check-sm align-items-middle mt-1">
          <input class="form-check-input menu-1" type="radio" name="type" value="1"/>
      </span>
      <span class="ms-5 mt-2">
          <span class="fs-4 fw-bolder text-gray-800 mb-2 d-block">Tata Nilai</span>
      </span>
    </label>
    `
    )
  if (id != null) {
      $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          "Authorization":"Bearer " + localStorage.getItem("token")
        },
        url: urlApi + "behavior-aspect-indicator/aspects/" + id,
        success: function (response) {
          res = response.data;
          console.log(res)

          $("#id").val(res.aspects.id)
          $("#modal-add #nama-aspek").val(res.aspects.name)
          $("#modal-add #nama-indikator").val(res.aspects.behavior_indicators.name);

          let selected_indicator =  "<option selected='selected' value='" + res.aspects.behavior_indicators.id + "'>" + res.aspects.behavior_indicators.name + "</option>";
          $("#select-indicator-edit").append(selected_indicator).trigger("change");

          changeName()

          sIndikator()

          ewpLoadingHide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
      });
  }

  $('#modal-add .modal-title').html("Edit Indikator Perilaku Penilaian")
  $('#modal-add').modal('show')
}

function tambah(){
  clearForm()
  $(".menu-2").removeClass("active show");
  $("#modal-add #label-aspect").removeClass("active");
  $("#modal-add #label-indicator").removeClass("active");
  $("#kt_widget_tab_1").removeClass("active show");
  $("#kt_widget_tab_2").removeClass("active show");
  $(".menu-form-pilih").addClass("active show");
  $("#modal-add #indicator-edit").addClass("d-none");
  $("#modal-add #indicator-add").removeClass("d-none");
  $("#change-button").addClass("d-none");
  $('#add-menu').html(
    `
    <label id="label-indicator" class="mt-2 btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 ms-0 me-2" data-bs-toggle="tab" href="#kt_widget_tab_1" data-kt-button="true">
      <span class="form-check form-check-custom form-check-sm align-items-middle mt-1">
          <input class="form-check-input menu-1" type="radio" name="type" value="1" onclick="indicator()"/>
      </span>
      <span class="ms-5 mt-2">
          <span class="fs-4 fw-bolder text-gray-800 mb-2 d-block">Tata Nilai</span>
      </span>
    </label>
    `
  )
  sIndikator()
  $('#modal-add .modal-title').html("Tambah Indikator Perilaku Penilaian")
  $('#modal-add').modal('show')
}

function simpan_aspect(param){
  ewpLoadingShow();
  loadStart();
  if ($("#id").val() == ""){
    var data = {
      name: $("#nama-aspek").val(),
      behavior_indicator_id: $("#select-indicator").val(),
      behavior_indicator_name: $("#nama-indikator").val(),
      status: param,
    }
  }else{
    var data = {
      name: $("#nama-aspek").val(),
      behavior_indicator_id: $("#select-indicator-edit").val(),
      behavior_indicator_name: $("#nama-indikator").val(),
      status: param,
    }
  }

    var tipe = $("#id").val() == "" ? "POST" : "PUT";
    var link = $("#id").val() == "" ? urlApi + "behavior-aspect-indicator/aspects" : urlApi + "behavior-aspect-indicator/aspects/" + $("#id").val()

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
            $("#modal-add #label-aspect").removeClass("active");
            $("#modal-add #label-indicator").removeClass("active");
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

function simpan_indicator(){
  ewpLoadingShow();
  loadStart();
  var data = {
      name: $("#nama-indikator").val(),
    }

    var tipe = $("#id").val() == "" ? "POST" : "PUT";
    var link = $("#id").val() == "" ? urlApi + "behavior-aspect-indicator/indicators" : urlApi + "behavior-aspect-indicator/indicators/" + $("#id").val()

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
      url: urlApi+"behavior-aspect-indicator/" + id ,
      success: function (response) {
      toastr.success("Status Berhasil Diubah!");
      table();
      },
      error: function (xhr, ajaxOptions, thrownError) {
          handleErrorDetail(xhr)
      },
  });
}

function sIndikator() {

  console.log('sIndikator runned')

    $("#select-indicator").select2({
        allowClear: true,
        placeholder: "Pilih Indikator",
        // dropdownParent: $('#modal-add'),
        ajax: {
            url: urlApi + "behavior-aspect-indicator/indicators",
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
                results: $.map(data.data, function (item) {
                return {
                    text: item.name,
                    id: item.id,
                };
              }),
            };
          },
        },
      });

    $("#select-indicator-edit").select2({
      allowClear: true,
      placeholder: "Pilih Indikator",
      // dropdownParent: $('#modal-add'),
      ajax: {
          url: urlApi + "behavior-aspect-indicator/indicators",
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
              results: $.map(data.data, function (item) {
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