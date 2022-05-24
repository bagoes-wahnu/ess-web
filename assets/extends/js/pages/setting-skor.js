jQuery(document).ready(function($) {
    $('#mn-setting').addClass('active')
    $('#mn-setting .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-setting .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-setting-parent').addClass('hover show')
    $('#mn-setting-parent menu-sub').addClass('hover show')
    $('#dd-setting-skor').addClass('text-primary font-weight-bolder').removeClass('menu-title')
});

function clearForm(){
    $("#select_parameter_type").val(null).trigger('change')
    // show().val(null).trigger('change')
}

function show_hasil(){
    clearForm()
    $('#modal-edit .modal-title').html("Setting Skor")
    $('#modal-edit').modal('show')
    $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          "Authorization":"Bearer " + localStorage.getItem("token")
        },
        url: urlApi + "setting-score/hasil",
        success: function (response) {
          res = response.data.details;
          console.log(res);
          if(res.length>0){
            $('#div-empty').addClass('d-none')
            $('#btn-add').removeClass('d-none')
              let htmlParameter=``
              for(r in res){
                id_temporary=uuidv4()
                console.log(r)
                if (r == 0) {
                    htmlParameter+=`
                    <tbody id="kolom-skor">
                        <tr class="data-edit" id="data-`+res[r].id+`">
                            <td>
                                <div class="d-flex">
                                    <input type="text" class="form-control achievment_min" placeholder="Cth: 10" value="`+res[r].achievment_min+`"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control achievment_max" placeholder="Cth: 20" value="`+res[r].achievment_max+`"/>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <input type="text" class="form-control score_min" placeholder="Cth: 1" value="`+res[r].score_min+`"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control score_max" placeholder="Cth: 2" value="`+res[r].score_max+`"/>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control description" placeholder="Cth: Melebihi Target" value="`+res[r].description+`"/>
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="id_type[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="id_child[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="is_edit[]" value="edit"/>
                                <button class="btn btn-icon btn-sm btn-success btn-active-light-primary" onclick="openEditor('create', '`+res[r].id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>`
                } else {
                    htmlParameter+=`
                    <tbody id="kolom-skor">
                        <tr class="data-edit" id="data-`+res[r].id+`">
                            <td>
                                <div class="d-flex">
                                    <input type="text" class="form-control achievment_min" placeholder="Cth: 10" value="`+res[r].achievment_min+`"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control achievment_max" placeholder="Cth: 20" value="`+res[r].achievment_max+`"/>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <input type="text" class="form-control score_min" placeholder="Cth: 1" value="`+res[r].score_min+`"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control score_max" placeholder="Cth: 2" value="`+res[r].score_max+`"/>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control description" placeholder="Cth: Melebihi Target" value="`+res[r].description+`"/>
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="id_type[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="id_child[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="is_edit[]" value="edit"/>
                                <button class="btn btn-icon btn-sm btn-danger btn-active-light-primary" onclick="removeEditor('`+res[r].id+`', '1')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>`   
                }
              }
              $('#table-setting-skor').html(
                `<thead>
                    <tr class="font-weight-bolder text-center">
                        <th scope="col" style="width:30%">Range Pencapaian</th>
                        <th scope="col" style="width:30%">Range Skor</th>
                        <th scope="col" style="width:30%">Keterangan</th>
                        <th scope="col" style="width:10%"></th>
                    </tr>
                </thead>
                `
                +htmlParameter
              )
              $('#footer-edit').html(
                `
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-simpan" class="btn btn-primary" onclick="serializeData('1')">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Proses menyimpan...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
                `
              )
          }else{
            id_temporary=uuidv4()
            console.log(id_temporary)
            $('#table-setting-skor').html(
            `<thead>
                    <tr class="font-weight-bolder text-center">
                        <th scope="col" style="width:30%">Range Pencapaian</th>
                        <th scope="col" style="width:30%">Range Skor</th>
                        <th scope="col" style="width:30%">Keterangan</th>
                        <th scope="col" style="width:10%"></th>
                    </tr>
                </thead>
                <tbody id="kolom-skor">
                <tr class="data-new" id="data-`+id_temporary+`">
                    <td>
                        <div class="d-flex">
                            <input type="text" class="form-control achievment_min" placeholder="Cth: 10"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control achievment_max" placeholder="Cth: 20"/>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <input type="text" class="form-control score_min" placeholder="Cth: 1"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control score_max" placeholder="Cth: 2"/>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control description" placeholder="Cth: Melebihi Target"/>
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="id_child[]" value="`+id_temporary+`"/>
                        <input type="hidden" name="is_edit[]" value="new"/>
                        <button class="btn btn-icon btn-sm btn-success btn-active-light-primary" onclick="openEditor('new_create', '`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
            `
            )
            $('#footer-edit').html(
            `<button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="button" id="btn-simpan" class="btn btn-primary" onclick="serializeNewData('1')">
                <span class="indicator-label">Simpan</span>
                <span class="indicator-progress">Proses menyimpan...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>`
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

function show_perilaku(){
    clearForm()
    $('#modal-edit .modal-title').html("Tambah Indikator KPI")
    $('#modal-edit').modal('show')
    $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          "Authorization":"Bearer " + localStorage.getItem("token")
        },
        url: urlApi + "setting-score/perilaku",
        success: function (response) {
          res = response.data.details;
          console.log(res.length);
          if(res.length>0){
            $('#div-empty').addClass('d-none')
            $('#btn-add').removeClass('d-none')
              let htmlParameter=``
              for(r in res){
                id_temporary=uuidv4()
                console.log(r)
                if (r == 0) {
                    htmlParameter+=`
                    <tbody id="kolom-skor">
                        <tr class="data-edit" id="data-`+res[r].id+`">
                            <td>
                                <div class="d-flex">
                                    <input type="text" class="form-control achievment_min" placeholder="Cth: 10" value="`+res[r].achievment_min+`"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control achievment_max" placeholder="Cth: 20" value="`+res[r].achievment_max+`"/>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <input type="text" class="form-control score_min" placeholder="Cth: 1" value="`+res[r].score_min+`"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control score_max" placeholder="Cth: 2" value="`+res[r].score_max+`"/>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control description" placeholder="Cth: Melebihi Target" value="`+res[r].description+`"/>
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="id_type[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="id_child[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="is_edit[]" value="edit"/>
                                <button class="btn btn-icon btn-sm btn-success btn-active-light-primary" onclick="openEditor('create', '`+res[r].id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>`
                } else {
                    htmlParameter+=`
                    <tbody id="kolom-skor">
                        <tr class="data-edit" id="data-`+res[r].id+`">
                            <td>
                                <div class="d-flex">
                                    <input type="text" class="form-control achievment_min" placeholder="Cth: 10" value="`+res[r].achievment_min+`"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control achievment_max" placeholder="Cth: 20" value="`+res[r].achievment_max+`"/>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <input type="text" class="form-control score_min" placeholder="Cth: 1" value="`+res[r].score_min+`"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control score_max" placeholder="Cth: 2" value="`+res[r].score_max+`"/>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control description" placeholder="Cth: Melebihi Target" value="`+res[r].description+`"/>
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="id_type[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="id_child[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="is_edit[]" value="edit"/>
                                <button class="btn btn-icon btn-sm btn-danger btn-active-light-primary" onclick="removeEditor('`+res[r].id+`', '2')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>`   
                }
              }
              $('#table-setting-skor').html(
                `<thead>
                    <tr class="font-weight-bolder text-center">
                        <th scope="col" style="width:30%">Range Pencapaian</th>
                        <th scope="col" style="width:30%">Range Skor</th>
                        <th scope="col" style="width:30%">Keterangan</th>
                        <th scope="col" style="width:10%"></th>
                    </tr>
                </thead>
                `
                +htmlParameter
              )
              $('#footer-edit').html(
                `
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-simpan" class="btn btn-primary" onclick="serializeData('2')">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Proses menyimpan...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
                `
              )
          }else{
            id_temporary=uuidv4()
            console.log(id_temporary)
            $('#table-setting-skor').html(
            `<thead>
                    <tr class="font-weight-bolder text-center">
                        <th scope="col" style="width:30%">Range Pencapaian</th>
                        <th scope="col" style="width:30%">Range Skor</th>
                        <th scope="col" style="width:30%">Keterangan</th>
                        <th scope="col" style="width:10%"></th>
                    </tr>
                </thead>
                <tbody id="kolom-skor">
                <tr class="data-new" id="data-`+id_temporary+`">
                    <td>
                        <div class="d-flex">
                            <input type="text" class="form-control achievment_min" placeholder="Cth: 10"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control achievment_max" placeholder="Cth: 20"/>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <input type="text" class="form-control score_min" placeholder="Cth: 1"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control score_max" placeholder="Cth: 2"/>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control description" placeholder="Cth: Melebihi Target"/>
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="id_child[]" value="`+id_temporary+`"/>
                        <input type="hidden" name="is_edit[]" value="new"/>
                        <button class="btn btn-icon btn-sm btn-success btn-active-light-primary" onclick="openEditor('new_create', '`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
            `
            )
            $('#footer-edit').html(
            `<button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="button" id="btn-simpan" class="btn btn-primary" onclick="serializeNewData('2')">
                <span class="indicator-label">Simpan</span>
                <span class="indicator-progress">Proses menyimpan...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>`
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

function openEditor(param, id_skor){
    if(param=='new_create'){
        id_temporary=uuidv4()
        $('#kolom-skor').append(
            `<tr class="data-add" id="data-`+id_temporary+`">
                <td>
                    <div class="d-flex">
                        <input type="text" class="form-control achievment_min" placeholder="Cth: 10"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control achievment_max" placeholder="Cth: 20"/>
                    </div>
                </td>
                <td>
                    <div class="d-flex">
                        <input type="text" class="form-control score_min" placeholder="Cth: 1"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control score_max" placeholder="Cth: 2"/>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control description" placeholder="Cth: Melebihi Target"/>
                </td>
                <td class="text-center">
                    <input type="hidden" name="id_type[]" value="`+id_skor+`"/>
                    <input type="hidden" name="id_child[]" value="`+id_temporary+`"/>
                    <input type="hidden" name="is_edit[]" value="new"/>
                    <button class="btn btn-icon btn-sm btn-danger btn-active-light-danger" onclick="removeEditor('`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </td>
            </tr>
            `
        )
    }else if(param=='create'){
        id_temporary=uuidv4()
        $('#kolom-skor').append(
            `<tr class="data-add" id="data-`+id_temporary+`">
                <td>
                    <div class="d-flex">
                        <input type="text" class="form-control achievment_min" placeholder="Cth: 10"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control achievment_max" placeholder="Cth: 20"/>
                    </div>
                </td>
                <td>
                    <div class="d-flex">
                        <input type="text" class="form-control score_min" placeholder="Cth: 1"/> &nbsp;<span class="fw-bolder mt-4">-</span>&nbsp; <input type="text" class="form-control score_max" placeholder="Cth: 2"/>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control description" placeholder="Cth: Melebihi Target"/>
                </td>
                <td class="text-center">
                    <input type="hidden" name="id_type[]" value="`+id_skor+`"/>
                    <input type="hidden" name="id_child[]" value="`+id_temporary+`"/>
                    <input type="hidden" name="is_edit[]" value="new"/>
                    <button class="btn btn-icon btn-sm btn-danger btn-active-light-danger" onclick="removeEditor('`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </td>
            </tr>
            `
        )
    }else{
        $('#jenis-'+id_jenis+" #data-"+id_parameter+" .data-label").addClass('d-none')
        $('#jenis-'+id_jenis+" #data-"+id_parameter+" .data-input").removeClass('d-none')
        $('#isEdit-'+id_jenis+"-"+id_parameter).val('true')
    }
}

function removeEditor(id, tipe){
    if(id.length>30){
        $('#data-'+id).remove()
    }else{
        swal.fire({
            title: "Hapus Detail Skor",
            text: "Data yang telah dihapus tidak bisa dikembalikan lagi.",
            icon: "warning",
            buttons: true,
            confirmButtonText: 'Batal',
            showCancelButton: true,
            cancelButtonText: 'Ya, Hapus',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-light',
                cancelButton: 'btn btn-danger',
            }
        })
        .then((willDo) => {
            if (willDo?.value!==undefined) {
            //   window.location.href=baseUrl+"aktivitas-jembatan-timbang/cetak-qr/"+id_simpan
            } else {
                
                $.ajax({
                    type: "DELETE",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Authorization": "Bearer " + localStorage.getItem("token") },
                    url: urlApi+"setting-score/" + id ,
                    success: function (response) {
                    toastr.success("Data berhasil di hapus!");
                    if(tipe == 1){
                        show_hasil();
                    }else if(tipe == 2){
                        show_perilaku();
                    }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        handleErrorDetail(xhr)
                    },
                });
            }
        });
    }
}

function closeEditor(){
    $('.data-add').remove()
}

let objectParamChildCreate={}
let objectParamChildEdit={}
function  serializeData(param){
    let ptid=$("[name='id_type[]']").serializeArray()
    let pcid=$("[name='id_child[]']").serializeArray()
    let ised=$("[name='is_edit[]']").serializeArray()
    // console.log(ised[t].value)
    let dataParamChildCreate=[]
    let dataParamChildEdit=[]
    for(t in ptid){
        if(ised[t].value=='edit'){
            dataParamChildEdit.push({
                "score_setting_id" : param,
                "id" : pcid[t].value!==''?pcid[t].value:"",
                "achievment_min" : $("#data-"+pcid[t].value+" .achievment_min").val(),
                "achievment_max" : $("#data-"+pcid[t].value+" .achievment_max").val(),
                "score_min" : $("#data-"+pcid[t].value+" .score_min").val(),
                "score_max" : $("#data-"+pcid[t].value+" .score_max").val(),
                "description" : $("#data-"+pcid[t].value+" .description").val(),
            })
        }else if(ised[t].value=='new'){
            dataParamChildCreate.push({
                "score_setting_id" : param,
                "achievment_min" : $("#data-"+pcid[t].value+" .achievment_min").val(),
                "achievment_max" : $("#data-"+pcid[t].value+" .achievment_max").val(),
                "score_min" : $("#data-"+pcid[t].value+" .score_min").val(),
                "score_max" : $("#data-"+pcid[t].value+" .score_max").val(),
                "description" : $("#data-"+pcid[t].value+" .description").val(),
            })
        }
    }
    
    if(dataParamChildCreate.length>0){
        objectParamChildCreate={details:dataParamChildCreate}
        simpanSkor('create', param)
    }

    if(dataParamChildEdit.length>0){
        objectParamChildEdit={details:dataParamChildEdit}
        simpanSkor('edit', param)
    }
}

function  serializeNewData(param){
    let pcid=$("[name='id_child[]']").serializeArray()
    let ised=$("[name='is_edit[]']").serializeArray()
    let dataParamChildCreate=[]
    for(t in pcid){
        if(ised[t].value=='new'){
            dataParamChildCreate.push({
                "score_setting_id" : param,
                "id" : pcid[t].value!==''?pcid[t].value:"",
                "achievment_min" : $("#data-"+pcid[t].value+" .achievment_min").val(),
                "achievment_max" : $("#data-"+pcid[t].value+" .achievment_max").val(),
                "score_min" : $("#data-"+pcid[t].value+" .score_min").val(),
                "score_max" : $("#data-"+pcid[t].value+" .score_max").val(),
                "description" : $("#data-"+pcid[t].value+" .description").val(),
            })
        }
    }
    
    if(dataParamChildCreate.length>0){
        objectParamChildCreate={details:dataParamChildCreate}
        simpanSkor('create', param)
    }
}

function simpanSkor(param, show){
    //ewpLoadingShow();
    var data
    if(param=="create"){
        data=objectParamChildCreate
    }else{
        data=objectParamChildEdit
    }

      var tipe = param=="create" ? "POST" : "PUT";
      var link = param=="create" ? urlApi + "setting-score" : urlApi + "setting-score/edit"
  
      $.ajax({
          type: tipe,
          dataType: "json",
          data:data,
          url: link,
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Authorization":"Bearer " + localStorage.getItem("token")
          },
          success: function (response) {
              objectParamChildCreate={details:[]}
              objectParamChildEdit={details:[]}
              if(objectParamChildCreate.details.length==0&&objectParamChildEdit.details.length==0){
                ewpLoadingHide();
                Swal.fire("Success!", "Data berhasil disimpan", "success");
                // $('#modal-edit').modal('hide')
                if (show == 1){
                    show_hasil()
                }else if(show == 2){
                    show_perilaku()
                }
                closeEditor()
              }
             
          },
          error: function (xhr, ajaxOptions, thrownError) {
              ewpLoadingHide();
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