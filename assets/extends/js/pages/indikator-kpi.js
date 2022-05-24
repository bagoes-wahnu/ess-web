jQuery(document).ready(function($) {
	table()
  $('#mn-master').addClass('active')
  $('#mn-master .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
  $('#mn-master .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
  $('#mn-master-parent').addClass('hover show')
  $('#mn-master-parent menu-sub').addClass('hover show')
  $('#dd-indikator-kpi').addClass('text-primary font-weight-bolder').removeClass('menu-title')
});	

function table() {

  document.getElementById("table-wrapper").innerHTML = ewpTable({
    targetId: "dttb-master-indikator-kpi",
    class: "table table-row-bordered bg-default table-head-custom table-vertical-center",
    column: [
    { name: "No", width: "10" },
    { name: "Jenis Parameter", width: "20" },
    { name: "Prespektif", width: "35" },
    { name: "Status", width: "15" },
    { name: "Action", width: "15" },
    ],
  });
  geekDatatables({
    target: "#dttb-master-indikator-kpi",
    url: urlApi + "kpi-indicator",
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
        col: "kpi_parameters.name", 
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
  $("#nama-parameter").val("")
  $("#nama-prespektif").val("")
  $("#unit-prespektif").val("")
  // $("#lokasi-kantor").val("")
  // $("#lokasi-kantor").change()
  $('#modal-add #select-parameter').val(null).trigger("change"),
  $('#modal-add #select-parameter-edit').val(null).trigger("change"),
  $("#modal-add input.menu-1").prop("checked", false);
  $("#modal-add input.menu-2").prop("checked", false);
  $("#id").val("")
}

function changeName(){
  $("#modal-add #nama-parameter").val($("#select-parameter-edit").find(":selected").text());
}

function parameter(){
  $("#change-button").removeClass("d-none");
  $('#change-button').html(
    `
    <button type="button" id="btn-tambah-aspect" onclick="simpan_parameter()" class="btn btn-primary">
        <span class="indicator-label">Simpan</span>
        <span class="indicator-progress">Please wait...
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    </button>
    `
    )
}

function perspective(){
  $("#change-button").removeClass("d-none");
  $('#change-button').html(
    `
    <button type="button" id="btn-tambah-aspect" onclick="simpan_perspective_parameter('t')" class="btn btn-primary">
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
  $("#modal-add #label-parameter").removeClass("active");
  $("#modal-add #label-prespektif").addClass("active");
  $("#kt_widget_tab_1").removeClass("active show");
  $("#kt_widget_tab_2").addClass("active show");
  $(".menu-form-pilih").removeClass("active show");
  $("#modal-add #parameter-edit").removeClass("d-none");
  $("#modal-add #parameter-add").addClass("d-none");
  perspective()
  $('#add-menu').html(
    `
    <label id="label-parameter" class="mt-2 btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 ms-0 me-2" data-bs-toggle="tab" href="#kt_widget_tab_1" data-kt-button="true">
      <span class="form-check form-check-custom form-check-sm align-items-middle mt-1">
          <input class="form-check-input menu-1" type="radio" name="type" value="1" />
      </span>
      <span class="ms-5 mt-2">
          <span class="fs-4 fw-bolder text-gray-800 mb-2 d-block">Jenis Parameter</span>
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
        url: urlApi + "kpi-indicator/perspective/" + id,
        success: function (response) {
          res = response.data;
          console.log(res)

          $("#id").val(res.perspective.id)
          $("#modal-add #nama-prespektif").val(res.perspective.name)
          $("#modal-add #unit-prespektif").val(res.perspective.unit_perspective)
          $("#modal-add #nama-parameter").val(res.perspective.kpi_parameters.name)

          let selected_parameter =  "<option selected='selected' value='" + res.perspective.kpi_parameters.id + "'>" + res.perspective.kpi_parameters.name + "</option>";
          $("#select-parameter-edit").append(selected_parameter).trigger("change")

          changeName()

          sParameter()

          ewpLoadingHide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
      });
  }

  $('#modal-add .modal-title').html("Edit Indikator KPI")
  $('#modal-add').modal('show')
}

function tambah(){
  clearForm()
  $(".menu-2").removeClass("active show");
  $("#modal-add #label-prespektif").removeClass("active");
  $("#modal-add #label-parameter").removeClass("active");
  $("#kt_widget_tab_1").removeClass("active show");
  $("#kt_widget_tab_2").removeClass("active show");
  $(".menu-form-pilih").addClass("active show");
  $("#modal-add #parameter-edit").addClass("d-none");
  $("#modal-add #parameter-add").removeClass("d-none");
  $("#change-button").addClass("d-none");
  $('#add-menu').html(
    `
    <label id="label-parameter" class="mt-2 btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 ms-0 me-2" data-bs-toggle="tab" href="#kt_widget_tab_1" data-kt-button="true">
      <span class="form-check form-check-custom form-check-sm align-items-middle mt-1">
          <input class="form-check-input menu-1" type="radio" name="type" value="1" onclick="parameter()"/>
      </span>
      <span class="ms-5 mt-2">
          <span class="fs-4 fw-bolder text-gray-800 mb-2 d-block">Jenis Parameter</span>
      </span>
    </label>
    `
  )
  sParameter()
  $('#modal-add .modal-title').html("Tambah Indikator KPI")
  $('#modal-add').modal('show')
}

function simpan_perspective_parameter(param){
  ewpLoadingShow();
  loadStart();
  if ($("#id").val() == "") {
    var data = {
      name: $("#nama-prespektif").val(),
      unit_perspective: $("#unit-prespektif").val(),
      kpi_parameter_id: $("#select-parameter").val(),
      kpi_parameter_name: $("#nama-parameter").val(),
      status: param,
    } 
  }else{
    var data = {
      name: $("#nama-prespektif").val(),
      unit_perspective: $("#unit-prespektif").val(),
      kpi_parameter_id: $("#select-parameter-edit").val(),
      kpi_parameter_name: $("#nama-parameter").val(),
      status: param,
    } 
  }

    var tipe = $("#id").val() == "" ? "POST" : "PUT";
    var link = $("#id").val() == "" ? urlApi + "kpi-indicator/perspective-parameter" : urlApi + "kpi-indicator/perspective-parameter/" + $("#id").val()

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
            $("#modal-add #label-prespektif").removeClass("active");
            $("#modal-add #label-parameter").removeClass("active");
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

function simpan_parameter(){
  ewpLoadingShow();
  loadStart();
  var data = {
      name: $("#nama-parameter").val(),
    }

    var tipe = $("#id").val() == "" ? "POST" : "PUT";
    var link = $("#id").val() == "" ? urlApi + "kpi-indicator/parameters" : urlApi + "kpi-indicator/parameters/" + $("#id").val()

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
      url: urlApi+"kpi-indicator/" + id ,
      success: function (response) {
      toastr.success("Status Berhasil Diubah!");
      table();
      },
      error: function (xhr, ajaxOptions, thrownError) {
          handleErrorDetail(xhr)
      },
  });
}

function sParameter() {

  console.log('sParameter runned')

    $("#select-parameter").select2({
        allowClear: true,
        placeholder: "Pilih Parameter",
        // dropdownParent: $('#modal-add'),
        ajax: {
            url: urlApi + "kpi-indicator/parameter",
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

    $("#select-parameter-edit").select2({
      allowClear: true,
      placeholder: "Pilih Indikator",
      // dropdownParent: $('#modal-add'),
      ajax: {
          url: urlApi + "kpi-indicator/parameter",
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