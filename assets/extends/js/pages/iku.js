let yearFilter=""
let divisionFilter=""
let tableSearch=""
let currentTable=""
let arraySimpan=[]

jQuery(document).ready(function() {
    $('#mn-indikator').addClass('active')
    $('#mn-indikator .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-indikator .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-indikator-parent').addClass('hover show')
    $('#mn-indikator-parent menu-sub').addClass('hover show')
    $('#dd-iku').addClass('text-primary font-weight-bolder').removeClass('menu-title')

    $('#tahun').datepicker({
        rtl: KTUtil.isRTL(),
        format: 'yyyy',
        todayHighlight: true,
        orientation: "bottom left",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
    });

    sDivisi()

    $(document).on("click", '#btn-filter', function (e) {
        if($('#tahun').val()!==''){
            $('#div-empty').addClass("d-none")
            yearFilter=$('#tahun').val()
            show('1')
            show('2')
            changeType('1')
            //$('.table-poin').removeClass("d-none")
            $('#btn-simpan').removeClass("d-none")
        }else{
            yearFilter=$('#tahun').val()
            $('#div-empty').removeClass("d-none")
            $('.table-poin').addClass("d-none")
        }
    });

    
    
    //input-poin
   

    $(document).on("blur", '.input-poin', function (e) {
        let ids=$(this).parents('.div-parent')
        let parent=ids.attr("id")
        let thisType=$('#'+parent+" #type").val()
        let idTr=$('#'+parent+' .id_user').val()
        console.log(idTr)
        console.log(thisType)
        console.log(arraySimpan)
        //simpan(idTr,thisType)
        let exist=dataExists(idTr,thisType)
        console.log(exist)
        if(exist==false){
            arraySimpan.push({
                idtr:idTr,type:thisType
            })
        }
    });

    $(document).on("click", '#btn-simpan', function (e) {
       console.log(arraySimpan)
       for(a in arraySimpan){
           simpan(arraySimpan[a].idtr,arraySimpan[a].type)
       }
    });

    $(document).on("keyup", '#input-search', function (e) {
        tableSearch=$(this).val()
        console.log(tableSearch)
        show(currentTable)
    });
});

function dataExists(idtr,type) {
    return arraySimpan.some(function(el) {
      return el.idtr === idtr && el.type === type;
    }); 
}

function loaderInit(param){
    if(param=='start'){
        $('.div-loader').removeClass("d-none")
    }else{
        $('.div-loader').addClass("d-none")
    }
    
}

function show(type){
    loaderInit('start')
    $('.div-search').removeClass("d-none")
    
    $.ajax({
        type: "GET",
        headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: urlApi + 'point/index?type='+type+'&year='+yearFilter+"&divisi="+divisionFilter+"&sort=asc&search="+tableSearch,
        beforeSend: function (xhr) {
        xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
        );

        },
        success: function (response) {
        ewpLoadingHide();
            res = response.data;
            console.log(res);
            
            if(res.length>0){
                let htmlPoint=``
                for(r in res){
                    let colorNote=res[r]?.points?.total_point<res[r]?.points?.target_point?"warning":"primary"
                    htmlPoint+=`
                    <tr class="div-parent">
                        <td rowspan="4">`+res[r].name+`</td>
                        <td class="month">JAN</td>
                        <td class="month">FEB</td>
                        <td class="month">MAR</td>
                        <td class="month">APR</td>
                        <td class="month">MEI</td>
                        <td class="month">JUN</td>
                        <td rowspan="4" class="d-none"></td>
                        <td rowspan="4">`+noNull(res[r]?.points?.total_point)+`</td>
                        <td rowspan="4">`+noNull(res[r]?.points?.target_point)+`</td>
                        <td rowspan="4">`+noNull(res[r]?.points?.presentase)+`%</td>
                        <td rowspan="4" class="text-`+colorNote+` font-weight-bolder">`+noNull(res[r]?.points?.notes)+`</td>
                    </tr>
                    <tr class="div-parent" id="div-`+res[r].id+`-`+type+`-1">
                        <input type="hidden" id="type" value="`+type+`"/>
                        <input type="hidden" class="id_user" value="`+res[r].id+`"/>
                        <td><input type="text" id="in-`+type+`-jan-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.jan)+`"/></td>
                        <td><input type="text" id="in-`+type+`-feb-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.feb)+`"/></td>
                        <td><input type="text" id="in-`+type+`-mar-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.mar)+`"/></td>
                        <td><input type="text" id="in-`+type+`-apr-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.apr)+`"/></td>
                        <td><input type="text" id="in-`+type+`-mei-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.mei)+`"/></td>
                        <td><input type="text" id="in-`+type+`-jun-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.jun)+`"/></td>
                    </tr>
                    <tr class="div-parent">
                        <td class="month">JUL</td>
                        <td class="month">AGT</td>
                        <td class="month">SEP</td>
                        <td class="month">OKT</td>
                        <td class="month">NOV</td>
                        <td class="month">DES</td>
                    </tr>
                    <tr class="div-parent" id="div-`+res[r].id+`-`+type+`-2">
                        <input type="hidden" id="type" value="`+type+`"/>
                        <input type="hidden" class="id_user" value="`+res[r].id+`"/>
                        <td><input type="text" id="in-`+type+`-jul-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.jul)+`"/></td>
                        <td><input type="text" id="in-`+type+`-agt-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.agt)+`"/></td>
                        <td><input type="text" id="in-`+type+`-sep-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.sep)+`"/></td>
                        <td><input type="text" id="in-`+type+`-okt-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.okt)+`"/></td>
                        <td><input type="text" id="in-`+type+`-nov-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.nov)+`"/></td>
                        <td><input type="text" id="in-`+type+`-des-`+res[r].id+`" class="form-control input-poin" placeholder="0" value="`+noZero(res[r]?.points?.des)+`"/></td>
                    </tr>`
                }
                loaderInit('end')
                $("#generate-poin-"+type).html(htmlPoint)
            }
        },
        error: function (res) {
        loaderInit('end')
        ewpLoadingHide();
        handleErrorDetail(res);
        },
    });
}

function simpan(id,type){
    let data= {
        "employee_id" : id,
        "type" : type,
        "year" : $('#tahun').val(),
        "jan" : $('#in-'+type+'-jan-'+id).val()!==''?$('#in-'+type+'-jan-'+id).val():0,
        "feb" : $('#in-'+type+'-feb-'+id).val()!==''?$('#in-'+type+'-feb-'+id).val():0,
        "mar" : $('#in-'+type+'-mar-'+id).val()!==''?$('#in-'+type+'-mar-'+id).val():0,
        "apr" : $('#in-'+type+'-apr-'+id).val()!==''?$('#in-'+type+'-apr-'+id).val():0,
        "mei" : $('#in-'+type+'-mei-'+id).val()!==''?$('#in-'+type+'-mei-'+id).val():0,
        "jun" : $('#in-'+type+'-jun-'+id).val()!==''?$('#in-'+type+'-jun-'+id).val():0,
        "jul" : $('#in-'+type+'-jul-'+id).val()!==''?$('#in-'+type+'-jul-'+id).val():0,
        "agt" : $('#in-'+type+'-agt-'+id).val()!==''?$('#in-'+type+'-agt-'+id).val():0,
        "sep" : $('#in-'+type+'-sep-'+id).val()!==''?$('#in-'+type+'-sep-'+id).val():0,
        "okt" : $('#in-'+type+'-okt-'+id).val()!==''?$('#in-'+type+'-okt-'+id).val():0,
        "nov" : $('#in-'+type+'-nov-'+id).val()!==''?$('#in-'+type+'-nov-'+id).val():0,
        "des" : $('#in-'+type+'-des-'+id).val()!==''?$('#in-'+type+'-des-'+id).val():0,   
    }
    console.log(data)

    $.ajax({
        type: "POST",
        dataType: "json",
        data: data,
        url: urlApi+"point/store",
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + localStorage.getItem("token")
            );
            //ewpLoadingShow();
            //loadStart()
        },
        success: function (response) {
            // console.log(response);
            //ewpLoadingHide();
            //loadStop()

            // var resSwal= $("#id").val() == "" ? "disimpan" : "diubah";
            // Swal.fire("Success!", "Data berhasil "+resSwal, "success");
            // $('#modal').modal('hide')
            show('1')
            show('2')
        },
        error: function (res) {
            // ewpLoadingHide();
            // loadStop()
            console.log(res);
            // $('#modal').modal('hide')

            //Swal.fire("Oopss...", res.responseJSON.status.message, "error");
            
        },
    });
}

function changeType(param){
    $(".pilih-jenis").removeClass("active")
    $("#btn-type-"+param).addClass("active")

    $(".table-poin").addClass("d-none")
    $("#table-"+param).removeClass("d-none")
    currentTable=param
}

function sDivisi() {
$("#divisi").select2({
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
                console.log(item)
            return {
                text: item.division_name,
                id: item.division_id,
            };
            }),
        };
        },
    },
    });
}