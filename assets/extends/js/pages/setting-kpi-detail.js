let id_year=""
let year=""
let filterDivisi=""
let settingArr=[]

jQuery(document).ready(function() {
    sDivisi()
    id_year=$('#id_time').val()
    var url_string = window.location.href
    var url = new URL(url_string);
    year= url.searchParams.get("year");
    $('#year').html(year)
})

function show(){
    if (id_year != null) {
        $.ajax({
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Authorization":"Bearer " + localStorage.getItem("token")
        },
        url: urlApi + "kpi/setting/" + id_year+"?division_id="+filterDivisi,
        success: function (response) {
            res = response.data.kpi_setting_parameters;
            $('.menu-form').removeClass('d-none')
            $('.menu-form-pilih').addClass('d-none')
            if(res.length>0){
                let html=""
                for(r in res){
                    let htmlPrs=``
                    let prs=res[r].kpi_setting_perspectives
                    for(p in prs){
                        htmlPrs+=`
                        <tr class="prs-new" id="prs-`+prs[p].id+`">
                            <input type="hidden" name="id_prespective" value="`+prs[p].id+`@`+res[r].parameter_id+`"/>
                            <td>
                                <select class="form-select select-perspective" data-control="select2" id="select-perspective-`+prs[p].id+`" name="select-perspective" data-placeholder="Pilih Perspective">
                                    <option value="`+prs[p].perspective_id+`" selected>`+prs[p].perspective_name+`</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control bobot-`+prs[p].id+`" placeholder="Cth: 100" name="bobot" value="`+prs[p].weight+`"/>
                            </td>
                            <td>
                                <input type="text" class="form-control target-skk-`+prs[p].id+`" placeholder="Cth: 100" name="target_skk" value="`+prs[p].skk_target+`"/>
                            </td>
                            <td>
                                <input type="text" class="form-control target-iku-`+prs[p].id+`" placeholder="Cth: 100" name="target_iku" value="`+prs[p].iku_target+`"/>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-icon btn-success btn-active-light-primary" onclick="addPrespective('`+res[r].parameter_id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </td>
                        </tr>
                        `
                    }

                    html+=`
                    <div class="mt-8 tab-pane fade show active" id="div-setting-`+res[r].parameter_id+`">
                        <div class="d-flex flex-column fv-row mb-2">
                            <label class="fs-5 fw-bold mb-2">Jenis Parameter</label>
                            <div class="d-flex">
                                <input type="hidden" class="id-setting" name="id-setting" value="`+res[r].parameter_id+`" />
                                <div class="col-11 me-10" id="parent-`+res[r].parameter_id+`">
                                    <select class="form-select select-parameter" id="select-parameter-`+res[r].parameter_id+`" name="select-parameter" data-control="select2" data-placeholder="Pilih Jenis Parameter">
                                        <option value="`+res[r].parameter_id+`" selected>`+res[r].parameter_name+`</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-icon btn-danger btn-active-light-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor" onclick="deleteSetting('`+res[r].parameter_id+`')">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <table class="table gs-0 gy-1" id="table-setting-perspective-`+res[r].parameter_id+`">
                            <thead>
                                <tr class="fs-5 fw-bold">
                                    <th scope="col" style="width:35%">Prespektif</th>
                                    <th scope="col" style="width:15%">Bobot (%)</th>
                                    <th scope="col" style="width:15%">Target SKK</th>
                                    <th scope="col" style="width:15%">Target IKU</th>
                                    <th scope="col" style="width:20%"></th>
                                </tr>
                            </thead>
                            <tbody id="body-perspective-`+res[r].parameter_id+`">
                                `+htmlPrs+`
                            </tbody>
                        </table>
                    </div>
                    `
                }
                $('#list-data').html(html)
                sParameter()
                sPerspective()
            }else{
                tambahParameter()
            }
           
            // $("#id").val(id)
            // $("#id-tahun").val(id)
            // $("#year-text").text(year)
            // $('#btn-simpan-setting').html(
            // `
            // <button type="button" class="btn btn-primary" onclick="serializeNewData('`+id+`')">Tambah Tata Nilai</button>
            // `
            // )
            // sIndikator()
            // sAspect()
            ewpLoadingHide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
        },
        });
    }
}

function filter(){
    filterDivisi=$('#select-divisi').val()
    show()
    $('#btn-simpan,#btn-tambah').removeClass('d-none')
}

function tambahParameter(){
    let uuid=uuidv4()
    let uuidPrs=uuidv4()
    $('#list-data').append(
        `<div class="mt-8 tab-pane fade show active" id="div-setting-`+uuid+`">
            <div class="d-flex flex-column fv-row mb-2">
                <label class="fs-5 fw-bold mb-2">Jenis Parameter</label>
                <div class="d-flex">
                    <input type="hidden" class="id-setting" name="id-setting" value="`+uuid+`" />
                    <div class="col-11 me-10" id="parent-`+uuid+`">
                        <select class="form-select select-parameter" id="select-parameter-`+uuid+`" name="select-parameter" data-control="select2" data-placeholder="Pilih Jenis Parameter">
                        </select>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-icon btn-danger btn-active-light-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor" onclick="deleteSetting('`+uuid+`')">
                            <i class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
            <table class="table gs-0 gy-1" id="table-setting-perspective-`+uuid+`">
                <thead>
                    <tr class="fs-5 fw-bold">
                        <th scope="col" style="width:35%">Prespektif</th>
                        <th scope="col" style="width:15%">Bobot (%)</th>
                        <th scope="col" style="width:15%">Target SKK</th>
                        <th scope="col" style="width:15%">Target IKU</th>
                        <th scope="col" style="width:20%"></th>
                    </tr>
                </thead>
                <tbody id="body-perspective-`+uuid+`">
                    <tr class="prs-new" id="prs-`+uuidPrs+`">
                        <input type="hidden" name="id_prespective" value="`+uuidPrs+`@`+uuid+`"/>
                        <td>
                            <select class="form-select select-perspective" data-control="select2" id="select-perspective-`+uuidPrs+`" name="select-perspective" data-placeholder="Pilih Perspective">
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control bobot-`+uuidPrs+`" placeholder="Cth: 100" name="bobot"/>
                        </td>
                        <td>
                            <input type="text" class="form-control target-skk-`+uuidPrs+`" placeholder="Cth: 100" name="target_skk"/>
                        </td>
                        <td>
                            <input type="text" class="form-control target-iku-`+uuidPrs+`" placeholder="Cth: 100" name="target_iku"/>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-icon btn-success btn-active-light-primary" onclick="addPrespective('`+uuid+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>`
    )
    sParameter()
    sPerspective()
}

function deleteSetting(id){
    $('#div-setting-'+id).remove()
}

function addPrespective(id){
    let uuid=uuidv4()
    let html=`
    <tr class="prs-new" id="prs-`+uuid+`">
        <input type="hidden" name="id_prespective" value="`+uuid+`@`+id+`"/>
        <td>
            <select class="form-select select-perspective" id="select-perspective-`+uuid+`" data-control="select2" name="select-perspective" data-placeholder="Pilih Perspective">
            </select>
        </td>
        <td>
            <input type="text" class="form-control bobot-`+uuid+`" placeholder="Cth: 100" name="bobot"/>
        </td>
        <td>
            <input type="text" class="form-control target-skk-`+uuid+`" placeholder="Cth: 100" name="target_skk"/>
        </td>
        <td>
            <input type="text" class="form-control target-iku-`+uuid+`" placeholder="Cth: 100" name="target_iku"/>
        </td>
        <td class="text-center">
            <button class="btn btn-icon btn-success btn-active-light-primary" onclick="addPrespective('`+id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                <i class="bi bi-plus-lg"></i>
            </button>
        </td>
    </tr>
    `
    $('#body-perspective-'+id).append(html)
    sPerspective()
}

function serializeSetting(){
    // [
    //     {   
    //         "id":null,
    //         "kpi_perspective_id":1,
    //         "weight":8,
    //         "skk_target":324,
    //         "iku_target":334
    //     },
    // ]
    settingArr=[]
    let id_prs=$('[name="id_prespective"]').serializeArray()
    if(id_prs.length>0){
        for(i in id_prs){
            let id_spl=id_prs[i].value.split('@')
            let idprs=id_spl[0]
            let idParam=id_spl[1]
            settingArr.push({
                "id":idprs.length>11?null:idprs,
                "kpi_perspective_id":$('#select-perspective-'+idprs).val(),
                "weight":$(".bobot-"+idprs).val(),
                "skk_target":$(".target-skk-"+idprs).val(),
                "iku_target":$(".target-iku-"+idprs).val()
            })
        }
    }
}

function simpan(){
    serializeSetting()
    let data={
        "kpi_setting_time_id" : id_year,
        "division_id" : $('#select-divisi').val(),
        "setting" :settingArr
    }

    $.ajax({
        type: "POST",
        dataType: "json",
        data: data,
        url: urlApi+'kpi/setting',
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          "Authorization":"Bearer " + localStorage.getItem("token")
        },
        success: function (response) {
            ewpLoadingHide();
            loadStop()
            Swal.fire("Berhasil!", "Setting KPI berhasil disimpan", "success");
            show()
        },
        error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            loadStop()
            handleErrorDetail(xhr)
        },
    });
}

function sDivisi() {
    $("#select-divisi").select2({
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

function sParameter() {
    $(".select-parameter").select2({
        allowClear: true,
        placeholder: "Pilih Parameter",
        ajax: {
            url: urlApi + "select_list/kpi_parameter",
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
                results: $.map(data.data.kpi_parameter, function (item) {
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

function sPerspective() {
    $(".select-perspective").select2({
        allowClear: true,
        placeholder: "Pilih Perspective",
        ajax: {
            url: urlApi + "select_list/kpi_perspective",
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
                results: $.map(data.data.kpi_perspective, function (item) {
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