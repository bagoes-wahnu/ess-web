jQuery(document).ready(function($) {
	show()
  $('#mn-setting').addClass('active')
  $('#mn-setting .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
  $('#mn-setting .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
  $('#mn-setting-parent').addClass('hover show')
  $('#mn-setting-parent menu-sub').addClass('hover show')
  $('#dd-setting-indikator-perilaku').addClass('text-primary font-weight-bolder').removeClass('menu-title')

  // $(document).on("change", '.select-aspect', function (e) {
  //   let ids=$(this).prop('id')
  //   let value=$(this).val()
  //   let id_selected=ids.replace("parameter-","")
  //   console.log(ids)
  //   console.log(value)
  //   console.log(parameterArr)
  //   for(pa in parameterArr){
  //       if(parameterArr[pa].id==value){
  //           let evidenceText=""
  //           let ev=parameterArr[pa].evidence
  //           if(ev.length>1){
  //               for(e in ev){
  //                   evidenceText+=ev[e]?.name+", "
  //               }
  //           }else if(ev.length==1){
  //               evidenceText=ev[0]?.name
  //           }else{
  //               evidenceText="-"
  //           }
  //           let sumberText=""
  //           switch(parameterArr[pa].sumber) {
  //               case "1":
  //               sumberText="KPI Korporat"
  //               break;
  //               case "2":
  //               sumberText="Spesifik"
  //               break;
  //               case "3":
  //               sumberText="RKAP"
  //               break;
  //               default:
  //               sumberText=""
  //           }
  //           $('#perspective-'+id_selected).html(parameterArr[pa]?.perspective?.name)
  //           $('#formula-'+id_selected).html(parameterArr[pa]?.formula)
  //           $('#st-'+id_selected).html(parameterArr[pa]?.strategic_target?.name)
  //           $('#sumber-'+id_selected).html(sumberText)
  //           $('#satuan-'+id_selected).html(parameterArr[pa]?.satuan)
  //           $('#status-'+id_selected).html(parameterArr[pa]?.status)
  //           $('#ytd-'+id_selected).html(parameterArr[pa]?.type_ytd?.value)
  //           $('#evidence-'+id_selected).html(evidenceText)
  //       }
  //   }
  // });

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
  closeEditor()
  $("#btn-tambah-nilai").addClass("d-none");
  $("#year").addClass("d-none");
  $("#edit-view").addClass("d-none");
  $("#grid-view").removeClass("d-none");
  $("#btn-kembali").addClass("d-none");
  $.ajax({
      type: "GET",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        "Authorization":"Bearer " + localStorage.getItem("token")
      },
      url: urlApi + "behavior/setting-time",
      success: function (response) {
        res = response.data.behavior_setting_time;
        // console.log(res);
        if(res.length>0){
          $('#div-empty').addClass('d-none')
          $('#btn-add').removeClass('d-none')
            let htmlParameter=``
            for(r in res){
              let htmlParamChild=``
              id_temporary=uuidv4()
              let cp=res[r].behavior_setting_time
              let is_active=res[r].status=="1"?"checked='checked'":""
              // console.log(r)
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
              </div>`
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
            $('#div-empty').removeClass('d-none')
            $('#btn-add').addClass('d-none')
        }
        ewpLoadingHide();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        ewpLoadingHide();
        handleErrorDetail(xhr);
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
      url: urlApi+"behavior/setting-time/change-status/" + id ,
      success: function (response) {
      toastr.success("Status Berhasil Diubah!");
      show();
      },
      error: function (xhr, ajaxOptions, thrownError) {
          handleErrorDetail(xhr)
      },
  });
}

function clearForm(){
  $("#nama-indikator").val("")
  $("#nama-aspek").val("")
  $("#checkbox-tahun").prop("checked", false)
  $("#id").val("")
  $("#id-tahun").val("")
  $("#btn-kembali").addClass("d-none")
  $('#label-tahun').removeClass('border-danger')
  $('#text-tahun').removeClass('text-danger')
}

function edit(id, year){
  clearForm()
  // ewpLoadingShow();
  $("#btn-tambah-nilai").removeClass("d-none");
  $("#btn-kembali").removeClass("d-none");
  $("#edit-view").removeClass("d-none");
  $("#grid-view").addClass("d-none");
  $("#year").removeClass("d-none");
  if (id != null) {
      $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          "Authorization":"Bearer " + localStorage.getItem("token")
        },
        url: urlApi + "behavior/setting/" + id,
        success: function (response) {
          res = response.data.behavior_setting_indicators;
          // console.log(res)
          if(res.length>0){
            let html=``
            for(r in res){
              let bsa = res[r].behavior_setting_aspects
              // let selected_indicator =  "<option selected='selected' value='" + res[r].indicator_id + "'>" + res[r].indicator_name + "</option>";
              // $("#select-indicator-edit").append(selected_indicator).trigger("change");
              let htmlbsa=``
              for(e in bsa){
                // console.log(bsa[e])
                $('#indicator-add').html(
                  `<select class="form-select select-indicator-edit" id="select-indicator-edit-`+res[r].indicator_id+`" data-control="select2" data-placeholder="Pilih Tata Nilai">
                  <option selected='selected' value='` + res[r].indicator_id + `'>` + res[r].indicator_name + `</option>
                  </select>`
                )
                $('#row-indicator').html(
                  `<button class="btn btn-icon btn-danger btn-active-light-danger" onclick="removeEditor('`+bsa[e].id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Indicator">
                    <i class="bi bi-dash-lg"></i>
                  </button>`
                )
                // let selected_aspect =  "<option selected='selected' value='" + bsa[e].aspect_id + "'>" + bsa[e].aspect_name + "</option>";
                // $("#select-aspect-'`+bsa[e].id+`'").append(selected_aspect).trigger("change");

                htmlbsa+=`
                <td>
                <select class="form-select select-aspect" id="select-aspect-`+bsa[e].aspect_id+`" data-control="select2" data-placeholder="Pilih Aspek">
                  <option value="`+bsa[e].aspect_id+`" selected>`+bsa[e].aspect_name+`</option>
                </select>
                </td>
                <td>
                  <input id="weight" type="text" class="form-control score_min" placeholder="Cth: 100" value="`+bsa[e].weight+`"/>
                </td>
                <td>
                  <input id="target" type="text" class="form-control score_max" placeholder="Cth: 100" value="`+bsa[e].target+`"/>
                </td>
                <td class="text-center">
                  <input type="hidden" name="id_type[]" value="`+bsa[e].id+`"/>
                  <input type="hidden" name="id_child[]" value="`+bsa[e].aspect_id+`"/>
                  <button class="btn btn-icon btn-success btn-active-light-primary" onclick="openEditor('create', '`+bsa[e].aspect_id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                    <i class="bi bi-plus-lg"></i>
                  </button>
                </td>`
              }
              html+=`
              <di id="id-setting-`+res[r].id+`">
                <div class="d-flex flex-column fv-row mb-2">
                  <label class="fs-5 fw-bold mb-2">Tata Nilai</label>
                  <div class="d-flex">
                    <div class="col-11 me-10" id="indicator-add">
                      <select class="form-select select-indicator-edit" id="select-indicator-edit-`+res[r].indicator_id+`" data-control="select2" data-placeholder="Pilih Tata Nilai">
                      </select>
                    </div>
                    <div class="col-1" id="row-indicator">
                      <button class="btn btn-icon btn-danger btn-active-light-danger" onclick="deleteSetting('`+res[r].id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Indicator">
                        <i class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <table class="table gs-0 gy-1" id="table-setting-skor">
                  <thead>
                    <tr class="fs-5 fw-bold">
                      <th scope="col" style="width:30%">Aspek Perilaku</th>
                      <th scope="col" style="width:30%">Bobot (%)</th>
                      <th scope="col" style="width:30%">Target</th>
                      <th scope="col" style="width:10%"></th>
                    </tr>
                  </thead>
                  <tbody id="kolom-skor">
                  <tr class="data-index" id="data-`+bsa[e].aspect_id+`">
                    `+htmlbsa+`
                  </tr>
                  </tbody>
                </table>`
            }
            $('#edit-view').html(html)
          }else{
            openEditor('new_create', '', id, year)
          }
          $("#id").val(id)
          $("#id-tahun").val(id)
          $("#year-text").text(year)
          console.log(id)
          console.log(year)
          $('#btn-simpan-setting').html(
            `<button type="button" class="btn btn-success" onclick="serializeNewData('`+id+`', '`+year+`')">Simpan Semua</button>`
          )
          $('#btn-tambah-nilai').html(
            `<button type="button" class="btn btn-primary" onclick="tambahNilai()">Tambah Tata Nilai</button>`
          )
          sIndikator()
          sAspect()
          ewpLoadingHide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
      });
    
  }
}

function edit_tahun(id, year){
  clearForm()
  ewpLoadingShow();
  $('#modal-edit').modal('show')
  console.log($('#checkbox-tahun').is('checked'))
  $('#footer-edit').html(
    `<button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
    <button type="button" id="btn-simpan" class="btn btn-primary" onclick="simpan_tahun('`+id+`')">
      <span class="indicator-label">Simpan</span>
      <span class="indicator-progress">Proses menyimpan...
      <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    </button>`
  )
  $("#checkbox-tahun").change(function() {
    if(this.checked) {
      $('#label-tahun').addClass('border-danger')
      $('#label-tahun').removeClass('border-secondary')
      $('#text-tahun').addClass('text-danger')
      $('#footer-edit').html(
        `<button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="btn-simpan" class="btn btn-primary" onclick="delete_tahun('`+id+`')">
          <span class="indicator-label">Simpan</span>
          <span class="indicator-progress">Proses menyimpan...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>`
      )
    }else{
      $('#label-tahun').removeClass('border-danger')
      $('#label-tahun').addClass('border-secondary')
      $('#text-tahun').removeClass('text-danger')
      $('#footer-edit').html(
        `<button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="btn-simpan" class="btn btn-primary" onclick="simpan_tahun('`+id+`')">
          <span class="indicator-label">Simpan</span>
          <span class="indicator-progress">Proses menyimpan...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>`
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
        url: urlApi + "behavior/setting-time",
        success: function (response) {
          res = response.data.behavior_setting_time;
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

function tambahNilai(){
  let uuid=uuidv4()
  let uuidPrs=uuidv4()
  $('#edit-view').append(
      `<div id="id-setting-`+uuid+`">
        <div class="d-flex flex-column fv-row mb-2">
          <label class="fs-5 fw-bold mb-2">Tata Nilai</label>
          <div class="d-flex">
            <div class="col-11 me-10" id="indicator-add">
              <select class="form-select select-indicator-edit" id="select-indicator-edit-'`+uuid+`'" data-control="select2" data-placeholder="Pilih Tata Nilai">
              </select>
            </div>
            <div class="col-1" id="row-indicator">
              <button class="btn btn-icon btn-danger btn-active-light-danger" onclick="deleteSetting('`+uuid+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Indicator">
                <i class="bi bi-dash-lg"></i>
              </button>
            </div>
          </div>
        </div>
        <table class="table gs-0 gy-1" id="table-setting-skor">
          <thead>
            <tr class="fs-5 fw-bold">
              <th scope="col" style="width:30%">Aspek Perilaku</th>
              <th scope="col" style="width:30%">Bobot (%)</th>
              <th scope="col" style="width:30%">Target</th>
              <th scope="col" style="width:10%"></th>
            </tr>
          </thead>
          <tbody id="kolom-skor">
            <tr class="data-new" id="data-'`+uuid+`'">
              <td>
                <select class="form-select select-aspect" id="select-aspect-'`+uuid+`'" data-control="select2" data-placeholder="Pilih Tata Nilai">
                </select>
              </td>
              <td>
                <input id="weight" type="text" class="form-control score_min" placeholder="Cth: 100"/>
              </td>
              <td>
                <input id="target" type="text" class="form-control score_max" placeholder="Cth: 100"/>
              </td>
              <td class="text-center">
                <input type="hidden" name="id_type[]" value="`+uuid+`"/>
                <input type="hidden" name="id_child[]" value="`+uuid+`"/>
                <button class="btn btn-icon btn-success btn-active-light-primary" onclick="openEditor('create', '`+uuid+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                  <i class="bi bi-plus-lg"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>`
  )
  sIndikator()
  sAspect()
}

function openEditor(param, id, year){
  if(param=='new_create'){
    id_temporary=uuidv4()
    $('#kolom-skor').append(
        `<tr class="data-new" id="data-`+id_temporary+`">
          <td>
            <select class="form-select select-aspect" id="select-aspect-`+id_temporary+`" data-control="select2" data-placeholder="Pilih Aspek">
            </select>
          </td>
          <td>
            <input id="weight" type="text" class="form-control score_min" placeholder="Cth: 100"/>
          </td>
          <td>
            <input id="target" type="text" class="form-control score_max" placeholder="Cth: 100"/>
          </td>
          <td class="text-center">
            <input type="hidden" name="id_type[]" value="`+id_temporary+`"/>
            <input type="hidden" name="id_child[]" value="`+id_temporary+`"/>
            <button class="btn btn-icon btn-success btn-success-light-danger" onclick="openEditor('create')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
              <i class="bi bi-plus-lg"></i>
            </button>
          </td>
        </tr>`
    )
    sAspect()
  }else if(param=='create'){
    id_temporary=uuidv4()
    $('#kolom-skor').append(
      `<tr class="data-add" id="data-`+id_temporary+`">
          <td>
            <select class="form-select select-aspect" id="select-aspect-`+id_temporary+`" data-control="select2" data-placeholder="Pilih Aspek">
            </select>
          </td>
          <td>
            <input id="weight" type="text" class="form-control score_min" placeholder="Cth: 100"/>
          </td>
          <td>
            <input id="target" type="text" class="form-control score_max" placeholder="Cth: 100"/>
          </td>
          <td class="text-center">
              <input type="hidden" name="id_type[]" value="`+id_temporary+`"/>
              <input type="hidden" name="id_child[]" value="`+id_temporary+`"/>
              <button class="btn btn-icon btn-danger btn-active-light-danger" onclick="removeEditor('`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor">
                  <i class="bi bi-dash-lg"></i>
              </button>
          </td>
      </tr>`
    )
    sAspect()
  }
  $('#btn-simpan-setting').html(
    `<button type="button" class="btn btn-primary" onclick="serializeNewData('`+id_temporary+`', '`+id+`', '`+year+`')">Tambah Tata Nilai</button>`
  )
}

function delete_tahun(id){
  if ($('#checkbox-tahun').is(':checked')) {
    $.ajax({
      type: "DELETE",
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      "Authorization": "Bearer " + localStorage.getItem("token") },
      url: urlApi+"behavior/setting-time/" + id ,
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

function deleteSetting(id){
  $('#id-setting-'+id).remove()
}

function removeEditor(id){
  if(id.length>30){
      $('#data-'+id).remove()
  }else{
    $.ajax({
        type: "DELETE",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        "Authorization": "Bearer " + localStorage.getItem("token") },
        url: urlApi+"behavior/setting/" + id ,
        success: function (response) {
        toastr.success("Data berhasil di hapus!");
        show();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            handleErrorDetail(xhr)
        },
    });
  }
}

function closeEditor(){
  $('.data-index').remove()
  $('.data-new').remove()
  $('.data-add').remove()
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

let objectParamChildCreate={}
function  serializeNewData(id, year){
  let ptid=$("[name='id_type[]']").serializeArray()
  let pcid=$("[name='id_child[]']").serializeArray()
  let ised=$("[name='is_edit[]']").serializeArray()
  // console.log(ised[t].value)
  let setting=[]
  if (pcid.length>0) {
      for(t in pcid){
      // if(ised[t].value=='new'){
        // for(c in ptid){
          console.log(ptid[t].value)
          let pt = ptid[t].value
          setting.push({
                // "behavior_setting_time_id" : param,
                "id" : pt.length>11?null:pt,
                // "behavior_aspect_id" : $("#data-"+pcid[t].value+" #select-aspect").val(),
                "behavior_aspect_id" : $("#data-"+pcid[t].value+" #select-aspect-"+pcid[t].value).val(),
                "weight" : $("#data-"+pcid[t].value+" #weight").val(),
                "target" : $("#data-"+pcid[t].value+" #target").val(),
            })
        // }
      // }
    }
  }
  console.log(id)
  console.log(year)
  // if(setting.length>0){
      // objectParamChildCreate={setting:dataParamChildCreate}
      // setting={setting}
      simpan_setting(setting, id, year)
  // }
}

function simpan_tahun(param){
  ewpLoadingShow();
  loadStart();
  if (param == "") {
    var data = {
      year: $("#tahun").val(),
    }
  } else {
    var data = {
      year: $("#tahun-edit").val(),
    }
  }

    var tipe = $("#id").val() == "" ? "POST" : "PUT";
    var link = $("#id").val() == "" ? urlApi + "behavior/setting-time" : urlApi + "behavior/setting-time/" + $("#id").val()

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

function simpan_setting(setting, id, year){
  ewpLoadingShow();
  loadStart();
  console.log(setting)
  var data = {
      behavior_setting_time_id: $("#id-tahun").val(),
      // behavior_setting_time_id: id,
      // objectParamChildCreate
      setting
    }
  data=data
  console.log(data)
    var tipe = "POST";
    var link = urlApi + "behavior/setting"

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
            ewpLoadingHide();
            loadStop()

            var resSwal= "disimpan";
            Swal.fire("Success!", "Data berhasil "+resSwal, "success");
            $('#modal-add').modal('hide')
            // show()
            edit(id, year)
        },
        error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            loadStop()
            handleErrorDetail(xhr)
        },
    });
}

function sIndikator() {
  $(".select-indicator-edit").select2({
      allowClear: true,
      placeholder: "Pilih Indikator",
      // dropdownParent: $('#modal-add'),
      ajax: {
          url: urlApi + "select_list/behavior_indicator",
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
  $(".select-aspect").select2({
    allowClear: true,
    placeholder: "Pilih Aspek",
    // dropdownParent: $('#modal-add'),
    ajax: {
        url: urlApi + "select_list/behavior_aspect",
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