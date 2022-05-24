jQuery(document).ready(function($) {
	//table()
    index()
    $('#mn-master').addClass('active')
    $('#mn-master .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-master .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-master-parent').addClass('hover show')
    $('#mn-master-parent menu-sub').addClass('hover show')
    $('#dd-parameter-nilai').addClass('text-primary font-weight-bolder').removeClass('menu-title')

    $("#tahun").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
    });
});	

function index(){
    $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          "Authorization":"Bearer " + localStorage.getItem("token")
        },
        url: urlApi + "parameter-value",
        success: function (response) {
          res = response.data.parameter;
          if(res.length>0){
            $('#div-empty').addClass('d-none')
            $('#btn-add').removeClass('d-none')
              let htmlParameter=``
              for(r in res){
                let htmlParamChild=``
                let cp=res[r].parameter
                if(cp.length>0){
                    for(c in cp){
                        htmlParamChild+=`
                        <tr id="data-`+cp[c].id+`">
                            <td><div class="ps-6">
                                <span class="data-label">`+cp[c].name+`</span>
                                <input type="text" class="form-control data-input d-none txt-name" placeholder="Cth: Pengendalian biaya cost center (by konsultan, by rapat, consumable, dll)"
                                value="`+cp[c].name+`"/>
                            </div></td>
                            <td class="text-center"><span class="data-label">`+cp[c].unit+`</span><input type="text" class="form-control data-input d-none txt-unit" placeholder="Cth: Min %" value="`+cp[c].unit+`"/></td>
                            <td class="text-center">
                                <button class="btn btn-icon data-label" onclick="openEditor('edit','`+res[r].id+`','`+cp[c].id+`')">
                                    <span class="svg-icon svg-icon-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                                <input type="hidden" id="isEdit-`+res[r].id+`-`+cp[c].id+`" name="is_edit[]" value=""/>
                                <input type="hidden" name="id_type[]" value="`+res[r].id+`"/>
                                <input type="hidden" name="id_child[]" value="`+cp[c].id+`"/>
                                <button class="btn btn-icon btn-sm btn-danger btn-active-light-danger data-input d-none" onclick="removeEditor('`+cp[c].id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Parameter">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                            </td>
                        </tr>`
                    }
                }

                htmlParameter+=`
                <tbody id="jenis-`+res[r].id+`">
                    <tr>
                        <td colspan="2"><h5>`+res[r].name+`</h5></td>
                        <td class="text-center">
                            <button class="btn btn-icon btn-sm btn-success btn-active-light-primary" onclick="openEditor('create','`+res[r].id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tambah Parameter">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </td>
                    </tr>
                    `+htmlParamChild+`
                </tbody>
                `
              }
              $('#table-jenis-parameter').html(
                   `<thead>
                        <tr class="font-weight-bolder text-center">
                            <th scope="col" style="width:70%">Jenis Parameter</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>`+htmlParameter
              )
          }else{
              $('#div-empty').removeClass('d-none')
              $('#btn-add').addClass('d-none')
          }
          
        //   $("#id").val(id)
        //   $('#modal-add .modal-title').html("Edit Tahun")
        //   $('#modal-add').modal('show')

          ewpLoadingHide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
    });
}

function clearForm(){
    $("#select_parameter_type").val(null).trigger('change')
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
            
            $("#id").val(id)
            $('#modal-add .modal-title').html("Edit Tahun")
            $('#modal-add').modal('show')
            sType()

            ewpLoadingHide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
        });
    }
}

function openEditor(param,id_jenis,id_parameter){
    $('#btn-add').addClass('d-none')
    $('#btn-simpan').removeClass('d-none')
    $('#btn-kembali').removeClass('d-none')
    if(param=='create'){
        id_temporary=uuidv4()
        $('#jenis-'+id_jenis).append(
            `<tr class="data-new" id="data-`+id_temporary+`">
                <td><div class="ps-6"><input type="text" class="form-control txt-name" placeholder="Cth: Pengendalian biaya cost center (by konsultan, by rapat, consumable, dll)"/></div></td>
                <td class="text-center"><input type="text" class="form-control txt-unit" placeholder="Cth: Min %"/></td>
                <td class="text-center">
                    <input type="hidden" name="id_type[]" value="`+id_jenis+`"/>
                    <input type="hidden" name="id_child[]" value="`+id_temporary+`"/>
                    <input type="hidden" name="is_edit[]" value="new"/>
                    <button class="btn btn-icon btn-sm btn-danger btn-active-light-danger" onclick="removeEditor('`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
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

function removeEditor(id){
    if(id.length>30){
        $('#data-'+id).remove()
    }else{
        swal.fire({
            title: "Hapus Parameter Nilai",
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
                    url: urlApi+"parameter-value/" + id ,
                    success: function (response) {
                    toastr.success("Data berhasil di hapus!");
                    index();
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
    $('#btn-add').removeClass('d-none')
    $('#btn-simpan').addClass('d-none')
    $('#btn-kembali').addClass('d-none')
    $('.data-new').remove()
    $('.data-label').removeClass('d-none')
    $('.data-input').addClass('d-none')
}

function tambah(){
    clearForm()
    $('#modal-add .modal-title').html("Tambah Parameter Nilai")
    $('#modal-add').modal('show')
    sType()
}

function simpan(){
    ewpLoadingShow();
    loadStart();
      $.ajax({
          type: "PATCH",
          dataType: "json",
          url: urlApi+"parameter-value/change-status/"+$('#select_parameter_type').val(),
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Authorization":"Bearer " + localStorage.getItem("token")
          },
          success: function (response) {
              ewpLoadingHide();
              loadStop()
  
              Swal.fire("Success!", "Data berhasil disimpan", "success");
              $('#modal-add').modal('hide')
              index()
          },
          error: function (xhr, ajaxOptions, thrownError) {
              ewpLoadingHide();
              loadStop()
              handleErrorDetail(xhr)
          },
      });
}

let objectParamChildCreate={}
let objectParamChildEdit={}
function  serializeData(){
    let ptid=$("[name='id_type[]']").serializeArray()
    let pcid=$("[name='id_child[]']").serializeArray()
    let ised=$("[name='is_edit[]']").serializeArray()

    let dataParamChildCreate=[]
    let dataParamChildEdit=[]
    for(t in ptid){
        if(ised[t].value=='true'){
            dataParamChildEdit.push({
                "parameter_type_id" : ptid[t].value!==''?ptid[t].value:"",
                "id" : pcid[t].value!==''?pcid[t].value:"",
                "name" : $("#jenis-"+ptid[t].value+" #data-"+pcid[t].value+" .txt-name").val(),
                "unit" : $("#jenis-"+ptid[t].value+" #data-"+pcid[t].value+" .txt-unit").val(),
            })
        }else if(ised[t].value=='new'){
            dataParamChildCreate.push({
                "parameter_type_id" : ptid[t].value!==''?ptid[t].value:"",
                "id" : pcid[t].value!==''?pcid[t].value:"",
                "name" : $("#jenis-"+ptid[t].value+" #data-"+pcid[t].value+" .txt-name").val(),
                "unit" : $("#jenis-"+ptid[t].value+" #data-"+pcid[t].value+" .txt-unit").val(),
            })
        }
    }
    
    if(dataParamChildCreate.length>0){
        objectParamChildCreate={parameter:dataParamChildCreate}
        simpanParameter('create')
    }

    if(dataParamChildEdit.length>0){
        objectParamChildEdit={parameter:dataParamChildEdit}
        simpanParameter('edit')
    }
}

function simpanParameter(param){
    //ewpLoadingShow();
    var data
    if(param=="create"){
        data=objectParamChildCreate
    }else{
        data=objectParamChildEdit
    }

      var tipe = param=="create" ? "POST" : "PUT";
      var link = param=="create" ? urlApi + "parameter-value" : urlApi + "parameter-value/edit"
  
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
              objectParamChildCreate={parameter:[]}
              objectParamChildEdit={parameter:[]}
              if(objectParamChildCreate.parameter.length==0&&objectParamChildEdit.parameter.length==0){
                ewpLoadingHide();
                Swal.fire("Success!", "Data berhasil disimpan", "success");
                $('#modal-add').modal('hide')
                index()
                closeEditor()
              }
             
          },
          error: function (xhr, ajaxOptions, thrownError) {
              ewpLoadingHide();
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

function sType(parameter_type, ph) {
      $("#select_parameter_type").select2({
        allowClear: true,
        placeholder: "Pilih Jenis Parameter",
        ajax: {
          url: urlApi + "select_list/parameter_type",
          dataType: "json",
          type: "GET",
          quietMillis: 50,
          headers: {
              "Authorization" : "Bearer "+localStorage.getItem('token'),
          },
         
          data: function (term) {
            return {
              search:term.term,
              is_active:false,
            };
          },
          processResults: function (data) {
            return {
              results: $.map(data.data['parameter_type'], function (item) {
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