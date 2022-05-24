// function openSuggestion(){
    
// }

// function openJobdesk(){
//     $('#modal-jobdesk').modal('show');
// }

jQuery(document).ready(function() {
    $('.summernote').summernote({
        height: 400,
        tabsize: 2
    });
    $('#mn-master').addClass('active')
    $('#mn-master .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-master .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-master-parent').addClass('hover show')
    $('#mn-master-parent menu-sub').addClass('hover show')
    $('#dd-jabatan').addClass('text-primary font-weight-bolder').removeClass('menu-title')

    show()
}); 

function show(){
    $.ajax({
        type: "GET",
        headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: urlApi + 'position',
        beforeSend: function (xhr) {
        xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
        );

        },
        success: function (response) {
        ewpLoadingHide();
            res = response.data.position;
            console.log(res);
            
            if(res.length>0){
                let htmlPosition=``
                for(r in res){
                    //LEVEL 1
                    let htmlChild=``
                    if(res[r].full_childs.length>0){
                        let fc1=res[r].full_childs
                        for(c1 in fc1){
                            //LEVEL 2
                            htmlChild2=``
                            if(fc1[c1].full_childs.length>0){
                                
                                let fc2=fc1[c1].full_childs
                                for(c2 in fc2){
                                    //LEVEL 3
                                    htmlChild3=``
                                    if(fc2[c2].full_childs.length>0){
                                        
                                        let fc3=fc2[c2].full_childs
                                        for(c3 in fc3){
                                            //LEVEL 4
                                            htmlChild4=``
                                            if(fc3[c3].full_childs.length>0){
                                                
                                                let fc4=fc3[c3].full_childs
                                                for(c4 in fc4){
                                                    //LEVEL 5
                                                    htmlChild5=``
                                                    if(fc4[c4].full_childs.length>0){
                                                        let fc5=fc4[c4].full_childs
                                                        for(c5 in fc5){
                                                            htmlChild5+=`
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="acc-`+fc5[c5].level_id+`-`+fc5[c5].id+`">
                                                                    <button class="accordion-button fs-5 p-4 fw-bold row m-0" type="button" data-bs-toggle="collapse" data-bs-target="#acc-body-`+fc5[c5].level_id+`-`+fc5[c5].id+`" aria-expanded="true" aria-controls="acc-body-`+fc5[c5].level_id+`-`+fc5[c5].id+`">
                                                                        <div class="col-md-8">`+fc5[c5].name+`</div>
                                                                        <div class="col-md-3 text-right">
                                                                            <div class="w-autos">
                                                                                <span class="badge badge-circle badge-danger" style="right: -45px;position: relative;top: -15px;">`+noNull(fc5[c5].suggest_count)+`</span>
                                                                                <i class="bi bi-chat-right-dots" style="margin-right:2.5vw;font-size:2rem;cursor:pointer;" onclick="openSuggestion(`+fc5[c5].id+`)"  data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan"></i>
                                                                                <i class="bi bi-briefcase" style="font-size:2rem" onclick="openJobdesk(`+fc5[c5].id+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="acc-body-`+fc5[c5].level_id+`-`+fc5[c5].id+`" class="accordion-collapse collapse show" aria-labelledby="acc-child-`+fc4[c4].level_id+`-`+fc4[c4].id+`" data-bs-parent="#acc-child-`+fc4[c4].level_id+`-`+fc4[c4].id+`">
                                                                    <div class="accordion-body">
                                                                        ...
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            `
                                                        }
                                                    }

                                                    htmlChild4+=`
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="acc-`+fc4[c4].level_id+`-`+fc4[c4].id+`">
                                                            <button class="accordion-button fs-5 p-4 fw-bold row m-0" type="button" data-bs-toggle="collapse" data-bs-target="#acc-body-`+fc4[c4].level_id+`-`+fc4[c4].id+`" aria-expanded="true" aria-controls="acc-body-`+fc4[c4].level_id+`-`+fc4[c4].id+`">
                                                                <div class="col-md-8">`+fc4[c4].name+`</div>
                                                                <div class="col-md-3 text-right">
                                                                    <div class="w-autos">
                                                                        <span class="badge badge-circle badge-danger" style="right: -45px;position: relative;top: -15px;">`+noNull(fc4[c4].suggest_count)+`</span>
                                                                        <i class="bi bi-chat-right-dots" style="margin-right:2.5vw;font-size:2rem;cursor:pointer;" onclick="openSuggestion(`+fc4[c4].id+`)"  data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan"></i>
                                                                        <i class="bi bi-briefcase" style="font-size:2rem" onclick="openJobdesk(`+fc4[c4].id+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </h2>
                                                        <div id="acc-body-`+fc4[c4].level_id+`-`+fc4[c4].id+`" class="accordion-collapse collapse show" aria-labelledby="acc-child-`+fc3[c3].level_id+`-`+fc3[c3].id+`" data-bs-parent="#acc-child-`+fc3[c3].level_id+`-`+fc3[c3].id+`">
                                                            <div class="accordion-body text-right" style="padding:0;display: flex;flex-direction: row-reverse;">
                                                                <div class="accordion col-md-11" id="acc-child-`+fc4[c4].level_id+`-`+fc4[c4].id+`">
                                                                    `+htmlChild5+`
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    `
                                                }
                                            }

                                            htmlChild3+=`
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="acc-`+fc3[c3].level_id+`-`+fc3[c3].id+`">
                                                    <button class="accordion-button fs-5 p-4 fw-bold row m-0" type="button" data-bs-toggle="collapse" data-bs-target="#acc-body-`+fc3[c3].level_id+`-`+fc3[c3].id+`" aria-expanded="true" aria-controls="acc-body-`+fc3[c3].level_id+`-`+fc3[c3].id+`">
                                                        <div class="col-md-8">`+fc3[c3].name+`</div>
                                                        <div class="col-md-3 text-right">
                                                            <div class="w-autos">
                                                                <span class="badge badge-circle badge-danger" style="right: -45px;position: relative;top: -15px;">`+noNull(fc3[c3].suggest_count)+`</span>
                                                                <i class="bi bi-chat-right-dots" style="margin-right:2.5vw;font-size:2rem;cursor:pointer;" onclick="openSuggestion(`+fc3[c3].id+`)"  data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan"></i>
                                                                <i class="bi bi-briefcase" style="font-size:2rem" onclick="openJobdesk(`+fc3[c3].id+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="acc-body-`+fc3[c3].level_id+`-`+fc3[c3].id+`" class="accordion-collapse collapse show" aria-labelledby="acc-child-`+fc2[c2].level_id+`-`+fc2[c2].id+`" data-bs-parent="#acc-child-`+fc2[c2].level_id+`-`+fc2[c2].id+`">
                                                    <div class="accordion-body text-right" style="padding:0;display: flex;flex-direction: row-reverse;">
                                                        <div class="accordion col-md-11" id="acc-child-`+fc3[c3].level_id+`-`+fc3[c3].id+`">
                                                            `+htmlChild4+`
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            `
                                        }
                                    }
                                    htmlChild2+=`
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="acc-`+fc2[c2].level_id+`-`+fc2[c2].id+`">
                                            <button class="accordion-button fs-5 p-4 fw-bold row m-0" type="button" data-bs-toggle="collapse" data-bs-target="#acc-body-`+fc2[c2].level_id+`-`+fc2[c2].id+`" aria-expanded="true" aria-controls="acc-body-`+fc2[c2].level_id+`-`+fc2[c2].id+`">
                                                <div class="col-md-8">`+fc2[c2].name+`</div>
                                                <div class="col-md-3 text-right">
                                                    <div class="w-autos">
                                                        <span class="badge badge-circle badge-danger" style="right: -45px;position: relative;top: -15px;">`+noNull(fc2[c2].suggest_count)+`</span>
                                                        <i class="bi bi-chat-right-dots" style="margin-right:2.5vw;font-size:2rem;cursor:pointer;" onclick="openSuggestion(`+fc2[c2].id+`)"  data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan"></i>
                                                        <i class="bi bi-briefcase" style="font-size:2rem" onclick="openJobdesk(`+fc2[c2].id+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="acc-body-`+fc2[c2].level_id+`-`+fc2[c2].id+`" class="accordion-collapse collapse show" aria-labelledby="acc-child-`+fc1[c1].level_id+`-`+fc1[c1].id+`" data-bs-parent="#acc-child-`+fc1[c1].level_id+`-`+fc1[c1].id+`">
                                            <div class="accordion-body text-right" style="padding:0;display: flex;flex-direction: row-reverse;">
                                                <div class="accordion col-md-11" id="acc-child-`+fc2[c2].level_id+`-`+fc2[c2].id+`">
                                                    `+htmlChild3+`
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `
                                }
                            }
                            htmlChild+=`
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-`+fc1[c1].level_id+`-`+fc1[c1].id+`">
                                        <button class="accordion-button fs-5 p-4 fw-bold row m-0" type="button" data-bs-toggle="collapse" data-bs-target="#acc-body-`+fc1[c1].level_id+`-`+fc1[c1].id+`" aria-expanded="true" aria-controls="acc-body-`+fc1[c1].level_id+`-`+fc1[c1].id+`">
                                            <div class="col-md-8">`+fc1[c1].name+`</div>
                                            <div class="col-md-3 text-right">
                                                <div class="w-autos">
                                                    <span class="badge badge-circle badge-danger" style="right: -45px;position: relative;top: -15px;">`+noNull(fc1[c1].suggest_count)+`</span>
                                                    <i class="bi bi-chat-right-dots" style="margin-right:2.5vw;font-size:2rem;cursor:pointer;" onclick="openSuggestion(`+fc1[c1].id+`)"  data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan"></i>
                                                    <i class="bi bi-briefcase" style="font-size:2rem" onclick="openJobdesk(`+fc1[c1].id+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i>
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="acc-body-`+fc1[c1].level_id+`-`+fc1[c1].id+`" class="accordion-collapse collapse show" aria-labelledby="acc-child-`+fc1[c1].level_id+`-`+fc1[c1].id+`" data-bs-parent="#acc-child-`+res[r].level_id+`-`+res[r].id+`">
                                        <div class="accordion-body text-right" style="padding:0;display: flex;flex-direction: row-reverse;">
                                            <div class="accordion col-md-11" id="acc-child-`+fc1[c1].level_id+`-`+fc1[c1].id+`">
                                                `+htmlChild2+`
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `
                        }
                    }
                    
                    htmlPosition+=`
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="acc-`+res[r].level_id+`-`+res[r].id+`">
                            <button class="accordion-button fs-5 p-4 fw-bold row m-0" type="button" data-bs-toggle="collapse" data-bs-target="#acc-body-`+res[r].level_id+`-`+res[r].id+`" aria-expanded="true" aria-controls="acc-body-`+res[r].level_id+`-`+res[r].id+`">
                                <div class="col-md-8">Director</div>
                                <div class="col-md-3 text-right">
                                    <div class="w-autos">
                                        <span class="badge badge-circle badge-danger" style="right: -45px;position: relative;top: -15px;">`+noNull(res[r].suggest_count)+`</span>
                                        <i class="bi bi-chat-right-dots" style="margin-right:2.5vw;font-size:2rem;cursor:pointer;" onclick="openSuggestion(`+res[r].id+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan"></i>
                                        <i class="bi bi-briefcase" style="font-size:2rem" onclick="openJobdesk(`+res[r].id+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="acc-body-`+res[r].level_id+`-`+res[r].id+`" class="accordion-collapse collapse show" aria-labelledby="acc-`+res[r].level_id+`-`+res[r].id+`" data-bs-parent="#kt_accordion_1">
                            <div class="accordion-body text-right" style="padding:0;display: flex;flex-direction: row-reverse;">
                                <div class="accordion col-md-11" id="acc-child-`+res[r].level_id+`-`+res[r].id+`">
                                `+htmlChild+`
                                </div>
                            </div>
                        </div>
                    </div>`
                }
                $("#kt_accordion_1").html(htmlPosition)
            }

            
            
        },
        error: function (res) {
        ewpLoadingHide();
        handleErrorDetail(res);
        },
    });
}

function openSuggestion(id){
    console.log("open suggest")
    if (id != null) {
        $.ajax({
          type: "GET",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          url: urlApi + 'position/suggest/'+id,
          beforeSend: function (xhr) {
            xhr.setRequestHeader(
              "Authorization",
              "Bearer " + localStorage.getItem("token")
            );
  
          },
          success: function (response) {
            ewpLoadingHide();
            res = response.data.position_suggest;
  
            console.log(res);
            let htmlSuggestion=``
            if(res.length>0){
                for(r in res){
                    let text=res[r].suggest
                    let cutText=""
                    let otherText=""
                    let seeMore=``
                    if(text.length>100){
                        cutText=`<span class="short-`+res[r].id+`">`+String(text).substr(0, 100)+`</span>`
                        otherText=`<span class="long-`+res[r].id+` d-none">`+String(text).substr(100, text.length)+`</span>`
                        seeMore=`<a href="javascript:;" class="text-primary see-more-`+res[r].id+`" onclick="showMore(`+res[r].id+`)"> ... Lihat Selengkapnya</a>`
                    }else{
                        cutText=`<span class="short-`+res[r].id+`">`+String(text)+`</span>`
                        otherText=""
                    }

                    let linkImage=res[r]?.user?.user_file?.link!==undefined?res[r]?.user?.user_file?.link:imgBlank
                   
                    htmlSuggestion+=`
                    <div class="col-md-12 row mx-0 mb-8">
                        <div class="col-md-2">
                            <img src="`+linkImage+`" class="img-profile"/>
                        </div>
                        <div class="col-md-10 row m-0 p-0 comment-perview">
                            <p class="col-md-6 font-weight-bolder">`+noNull(res[r]?.user?.name)+`</p>
                            <p class="col-md-6 text-muted text-right">`+fDate(res[r].created_at,'date12')+`</p>
                            <p class="col-md-12 text-muted">`+noNull(res[r]?.position?.name)+`</p>
                            <p class="col-md-12" style="text-align:justify">
                                `+cutText+``+otherText+`
                                `+seeMore+`
                            </p>
                        </div>
                    </div>
                    `
                }
            }else{
                htmlSuggestion=`<div class="text-center">Belum ada masukan staff terkait jobdesk.</div>`
            }
            $('#modal-comment .modal-body').html(htmlSuggestion)
            $('#modal-comment').modal('show');
                
          },
          error: function (res) {
            ewpLoadingHide();
            handleErrorDetail(res);
          },
        });
      }
}

function showMore(id){
    $('.long-'+id).removeClass("d-none")
    $('.see-more-'+id).addClass("d-none")
}

function openJobdesk(id){
    console.log("openJobdesk")
    if (id != null) {
        $.ajax({
          type: "GET",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          url: urlApi + 'position/detail_jobdesk/'+id,
          beforeSend: function (xhr) {
            xhr.setRequestHeader(
              "Authorization",
              "Bearer " + localStorage.getItem("token")
            );
  
          },
          success: function (response) {
            ewpLoadingHide();
            res = response.data;
            if(res!==null){
                $('#modal-jobdesk #id').val(res.position_id);
                $('#modal-jobdesk #tujuan-jabatan').val(res.purpose);
                $('#modal-jobdesk #tanggung-jawab').summernote('code', res.responsibility);
                $('#modal-jobdesk').modal('show');
            }else{
                // Swal.fire("Opps...","Tidak ada data","error")
                $('#modal-jobdesk #id').val(id);
                $('#modal-jobdesk').modal('show');
            }
          },
          error: function (res) {
            ewpLoadingHide();
            handleErrorDetail(res);
          },
        });
      }
}

function simpan() {
    let responsibility = $('#modal-jobdesk #tanggung-jawab').summernote('code');
    var data = {
        "position_id" : $("#modal-jobdesk #id").val(),
        "purpose" : $('#modal-jobdesk #tujuan-jabatan').val(),
        "responsibility": responsibility
    }
    console.log(data);

    var tipe = "POST";
    var link = urlApi + "position/save_jobdesk"

    $.ajax({
        type: tipe,
        dataType: "json",
        data: data,
        url: link,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + localStorage.getItem("token")
            );
            ewpLoadingShow();
            loadStart()
        },
        success: function (response) {
            // console.log(response);
            ewpLoadingHide();
            loadStop()

            Swal.fire("Success!", "Data berhasil Disimpan", "success");
            $('#modal-jobdesk').modal('hide')
            show()
        },
        error: function (res) {
            ewpLoadingHide();
            loadStop()
            console.log(res);
            // $('#modal').modal('hide')

            Swal.fire("Oopss...", res.responseJSON.status.message, "error");
            
        },
    });
}