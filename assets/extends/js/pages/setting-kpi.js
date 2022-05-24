jQuery(document).ready(function($) {
	show()
  $('#mn-setting').addClass('active')
  $('#mn-setting .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
  $('#mn-setting .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
  $('#mn-setting-parent').addClass('hover show')
  $('#mn-setting-parent menu-sub').addClass('hover show')
  $('#dd-setting-kpi').addClass('text-primary font-weight-bolder').removeClass('menu-title')
  $('#tahun').datepicker({
    rtl: KTUtil.isRTL(),
    format: 'yyyy',
    todayHighlight: true,
    orientation: "bottom left",
    viewMode: "years",
    minViewMode: "years",
    autoclose: true,
  });
  $('#tahun-edit').datepicker({
    rtl: KTUtil.isRTL(),
    format: 'yyyy',
    todayHighlight: true,
    orientation: "bottom left",
    viewMode: "years",
    minViewMode: "years",
    autoclose: true,
  });
});	

function show(){
  $("#edit-view").addClass("d-none");
  $("#grid-view").removeClass("d-none");
  $("#btn-kembali").addClass("d-none");
  $("#btn-simpan").addClass("d-none");
  $.ajax({
      type: "GET",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        "Authorization":"Bearer " + localStorage.getItem("token")
      },
      url: urlApi + "kpi/setting-time",
      success: function (response) {
        res = response.data.kpi_setting_time;
        console.log(res);
        if(res.length>0){
          $('#div-empty').addClass('d-none')
          $('#btn-add').removeClass('d-none')
            let htmlParameter=``
            for(r in res){
              let htmlParamChild=``
              id_temporary=uuidv4()
              let cp=res[r].kpi_setting_time
              let is_active=res[r].status=="1"?"checked='checked'":""
              console.log(is_active)
              htmlParameter+=`
              <div class="col-md-3" style="padding:14px;">
                <div class=" text-center setting-item" style="">
                  <a onclick="edit('`+res[r].id+`','`+res[r].year+`')" type="button"><h1 class="text-dark font-weight-boldest mb-5" id="title-1">`+res[r].year+`</h1></a>
                  <div class="d-flex ms-15">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                      <input class="form-check-input" type="checkbox" value="" id="check-`+res[r].id+`" `+is_active+` onclick="changeStatus(`+res[r].id+`)"/>
                      <label class="form-check-label" for="chk-switch"></label>
                    </div>
                    <a href="javascript:;" onclick="edit_tahun('`+res[r].id+`','`+res[r].year+`')" class="btn" style="padding: 4px !important">
                      <span class="">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="#FCAD00"/>
                        <g clip-path="url(#clip0)">
                        <path d="M12.6783 8.82144L15.1787 11.3218L9.74917 16.7513L7.51987 16.9974C7.22143 17.0304 6.96929 16.7781 7.00249 16.4796L7.25054 14.2488L12.6783 8.82144ZM16.7251 8.44917L15.5511 7.27515C15.1849 6.90894 14.591 6.90894 14.2248 7.27515L13.1203 8.37964L15.6207 10.88L16.7251 9.77554C17.0914 9.40913 17.0914 8.81538 16.7251 8.44917Z" fill="white"/>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
              `
            }
            $('#grid-view').html(
              `
              <div class="row">
                <div class="col-md-3" style="padding:14px;">
                  <a type="button" class="text-primary bg-light-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
                    <div class="btn btn-outline btn-outline-dashed btn-outline-default active text-center setting-item text-primary bg-light-primary" style="">
                      <span class="svg-icon svg-icon-primary svg-icon-4x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M11 13H7C6.4 13 6 12.6 6 12C6 11.4 6.4 11 7 11H11V13ZM17 11H13V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="black"/>
                        <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM17 11H13V7C13 6.4 12.6 6 12 6C11.4 6 11 6.4 11 7V11H7C6.4 11 6 11.4 6 12C6 12.6 6.4 13 7 13H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="black"/>
                        </svg>
                      </span>
                      <h3 class="font-weight-boldest mt-5 mb-0" id="title-1">Tambah Data</h3>
                      <span style="font-size:10px">Klik untuk menambah tahun baru</span>
                    </div>
                  </a>
                </div>
              `
              +htmlParameter+
              `</div>`
            )
        }else{
            $('#grid-view').html(
                `
                <div class="row">
                  <div class="col-md-3" style="padding:14px;">
                    <a type="button" class="text-primary bg-light-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
                      <div class="btn btn-outline btn-outline-dashed btn-outline-default active text-center setting-item text-primary bg-light-primary" style="">
                        <span class="svg-icon svg-icon-primary svg-icon-4x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path opacity="0.3" d="M11 13H7C6.4 13 6 12.6 6 12C6 11.4 6.4 11 7 11H11V13ZM17 11H13V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="black"/>
                          <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM17 11H13V7C13 6.4 12.6 6 12 6C11.4 6 11 6.4 11 7V11H7C6.4 11 6 11.4 6 12C6 12.6 6.4 13 7 13H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="black"/>
                          </svg>
                        </span>
                        <h3 class="font-weight-boldest mt-5 mb-0" id="title-1">Tambah Data</h3>
                        <span style="font-size:10px">Klik untuk menambah tahun baru</span>
                      </div>
                    </a>
                  </div>
                </div>`
              )
        }

        ewpLoadingHide();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        ewpLoadingHide();
        handleErrorDetail(xhr);
      },
  });
}

function clearForm(){
  $("#nama-indikator").val("")
  $("#nama-aspek").val("")
  $("#checkbox-tahun").prop("checked", false);
  $("#id").val("")
  $("#id-tahun").val("")
  $("#btn-kembali").addClass("d-none");
}

function edit(id, year){
    window.location.href=baseUrl+"setting-kpi/"+id+"?year="+year
//   clearForm()
//   ewpLoadingShow();
//   $("#btn-kembali").removeClass("d-none");
//   $("#edit-view").removeClass("d-none");
//   $("#grid-view").addClass("d-none");
//   $("#year").removeClass("d-none");
//   if (id != null) {
//       $.ajax({
//         type: "GET",
//         headers: {
//           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//           "Authorization":"Bearer " + localStorage.getItem("token")
//         },
//         url: urlApi + "kpi/setting/" + id,
//         success: function (response) {
//           res = response.data.behavior_setting_indicators;
//           for(r in res){
//             console.log(res[0].behavior_setting_aspects)
//             console.log(res[r])
//             console.log(res[r].indicator_id)
//             let selected_indicator =  "<option selected='selected' value='" + res[r].indicator_id + "'>" + res[r].indicator_name + "</option>";
//             $("#select-indicator-edit").append(selected_indicator).trigger("change");
//             for(e in r){
//               console.log(res[r].behavior_setting_aspects[e].id)
//               console.log(res[r].behavior_setting_aspects[e])
//               $('#row-indicator').html(
//                 `
//                 <button class="btn btn-icon btn-danger btn-active-light-danger" onclick="removeEditor('`+res[r].behavior_setting_aspects[e].id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Indicator">
//                   <i class="bi bi-dash-lg"></i>
//                 </button>
//                 `
//               )
//               let selected_indicator =  "<option selected='selected' value='" + res[r].behavior_setting_aspects[e].aspect_id + "'>" + res[r].behavior_setting_aspects[e].aspect_name + "</option>";
//               $("#select-aspect").append(selected_indicator).trigger("change");
//               $("#weight").val(res[r].behavior_setting_aspects[e].weight)
//               $("#target").val(res[r].behavior_setting_aspects[e].target)
//             }
//           }
//           $("#id").val(id)
//           $("#id-tahun").val(id)
//           $("#year-text").text(year)
//           $('#btn-simpan-setting').html(
//             `
//             <button type="button" class="btn btn-primary" onclick="serializeNewData('`+id+`')">Tambah Tata Nilai</button>
//             `
//           )
//           sIndikator()
//           sAspect()
//           ewpLoadingHide();
//         },
//         error: function (xhr, ajaxOptions, thrownError) {
//           ewpLoadingHide();
//           handleErrorDetail(xhr);
//         },
//       });
//   }
//   $('#kolom-skor').html(
//     `
//     <tr class="data-new" id="data-`+id+`">
//       <td>
//         <select class="form-select" id="select-aspect" data-control="select2" data-placeholder="Pilih Tata Nilai">
//         </select>
//       </td>
//       <td>
//         <input id="weight" type="text" class="form-control score_min" placeholder="Cth: 100"/>
//       </td>
//       <td>
//         <input id="target" type="text" class="form-control score_max" placeholder="Cth: 100"/>
//       </td>
//       <td class="text-center">
//         <input type="hidden" name="id_child[]" value="`+id+`"/>
//         <button class="btn btn-icon btn-success btn-active-light-primary" onclick="openEditor('new_create', '`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
//           <i class="bi bi-plus-lg"></i>
//         </button>
//       </td>
//     </tr>
//     `
//   )
}

function edit_tahun(id, year){
  clearForm()
  ewpLoadingShow();
  $('#modal-edit').modal('show')
  console.log($('#checkbox-tahun').is('checked'))
  $('#footer-edit').html(
    `
    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
    <button type="button" id="btn-simpan" class="btn btn-primary" onclick="simpan_tahun('`+id+`')">
      <span class="indicator-label">Simpan</span>
      <span class="indicator-progress">Proses menyimpan...
      <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    </button>
    `
  )
  $("#checkbox-tahun").change(function() {
    if(this.checked) {
      $('#footer-edit').html(
        `
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="btn-simpan" class="btn btn-primary" onclick="delete_tahun('`+id+`')">
          <span class="indicator-label">Simpan</span>
          <span class="indicator-progress">Proses menyimpan...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
        `
      )
    }else{
      $('#footer-edit').html(
        `
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="btn-simpan" class="btn btn-primary" onclick="simpan_tahun('`+id+`')">
          <span class="indicator-label">Simpan</span>
          <span class="indicator-progress">Proses menyimpan...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
        `
      )
    }
  });
  if (id != null) {
      $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          "Authorization":"Bearer " + localStorage.getItem("token")
        },
        url: urlApi + "kpi/setting-time",
        success: function (response) {
          res = response.data.kpi_setting_time;

          console.log(res)
          
          $("#id").val(id)

          $("#tahun-edit").val(year)

          ewpLoadingHide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
      });
  }
}

function delete_tahun(id){
  if ($('#checkbox-tahun').is(':checked')) {
    $.ajax({
      type: "DELETE",
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      "Authorization": "Bearer " + localStorage.getItem("token") },
      url: urlApi+"kpi/setting-time/" + id ,
      success: function (response) {
      toastr.success("Data berhasil di hapus!");
      show();
      },
      error: function (xhr, ajaxOptions, thrownError) {
          handleErrorDetail(xhr)
      },
    });
    $("#checkbox-tahun").prop("checked", false);
    $('#modal-edit').modal('hide')
  }
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

  sIndikator()
  $('#modal-add .modal-title').html("Tambah Indikator Perilaku Penilaian")
  $('#modal-add').modal('show')
}

function simpan_tahun(param=""){
  ewpLoadingShow();
  loadStart();
  let data =""
  if (param == "") {
    data = {
      year: $("#tahun").val(),
    }
  } else {
    data = {
      year: $("#tahun-edit").val(),
    }
  }

  var tipe = $("#id").val() == "" ? "POST" : "PUT";
    var link = $("#id").val() == "" ? urlApi + "kpi/setting-time" : urlApi + "kpi/setting-time/" + $("#id").val()

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

            var resSwal= $("#id-edit").val() == "" ? "disimpan" : "diubah";
            Swal.fire("Success!", "Data berhasil "+resSwal, "success");
            // $("#modal-add #label-aspect").removeClass("active");
            // $("#modal-add #label-indicator").removeClass("active");
            $('#modal-add').modal('hide')
            $('#modal-edit').modal('hide')
            show()
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
      url: urlApi+"kpi/setting-time/change-status/" + id ,
      success: function (response) {
      toastr.success("Status Berhasil Diubah!");
      // table();
      show();
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

function sAspect() {
  console.log('sAspect runned')
  $("#select-aspect").select2({
    allowClear: true,
    placeholder: "Pilih Indikator",
    // dropdownParent: $('#modal-add'),
    ajax: {
        url: urlApi + "behavior-aspect-indicator",
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