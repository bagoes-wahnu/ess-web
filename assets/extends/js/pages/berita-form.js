
var desc
let statusUpload=false

$(document).ready(function () {
    //table()
    $('#mn-berita').addClass('active')
    $('a#mn-berita .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('a#mn-berita .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')

    $('#tanggal').datepicker({
        rtl: KTUtil.isRTL(),
        format: "dd-mm-yyyy",
        autoclose:true,
        todayHighlight: true,
    });

    ClassicEditor
    .create(document.querySelector('#kt_docs_ckeditor_classic'))
    .then(editor => {
        console.log(editor);
        desc=editor
    })
    .catch(error => {
        console.error(error);
    });

    if($("#id").val() !== "form"){
        edit($("#id").val())
    }else{
        $('#btn-perview').attr("disabled",true)
    }
});


function upload(id,jenis) {
    var file = $("#file-avatar")[0].files[0];
    var dataFile = new FormData();
    dataFile.append("file", file);
    $.ajax({
      type: "POST",
      data: dataFile,
      url: urlApi + "news/upload_file/"+id,
      processData: false,
      contentType: false,
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        "Authorization":"Bearer " + localStorage.getItem("token")
        },
      success: function (response) {
        ewpLoadingHide();
        loadStop()
        statusUpload=true
        $("#file-avatar").val("");
        if(jenis!=="perview"){
                let resSwal= $("#id").val() == "form" ? "disimpan" : "diubah";
                Swal.fire("Success!", "Data berhasil "+resSwal, "success").then((result) => {
                if (result.value) {
                    window.location.href=baseUrl+"berita"
                    table();
                }
            });;
        }else{
            event.preventDefault()
            //window.location.href=baseUrl+"berita/"+id
            //window.open(baseUrl+"berita/"+id+"/perview")
            window.location.href=baseUrl+"berita/"+id+"/perview"
        }
      },
      error: function (response) {
        ewpLoadingHide();
        loadStop()
        handleError(response);
      },
    });
}

function simpan(param,jenis=''){
    ewpLoadingShow();
    loadStart();
    
    console.log()

    var data = {
        title: $("#judul").val(),
        content: desc.getData(),
        date: fDate($("#tanggal").val(),'date1'),
        status: param,
      }
      console.log(data);
  
      var tipe = $("#id").val() == "form" ? "POST" : "PUT";
      var link = $("#id").val() == "form" ? urlApi + "news" : urlApi + "news/" + $("#id").val()
      console.log()
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
              //ewpLoadingHide();
              //loadStop()
              
                
                    if($("#file-avatar")[0].files.length>0){
                        upload(response.data.news.id,jenis)
                    }else{
                        ewpLoadingHide();
                        loadStop()
                        if(jenis!=="perview"){
                            let resSwal= $("#id").val() == "form" ? "disimpan" : "diubah";
                                Swal.fire("Success!", "Data berhasil "+resSwal, "success").then((result) => {
                                if (result.value) {
                                    window.location.href=baseUrl+"berita"
                                    table();
                                }
                            });;
                        }else{
                            event.preventDefault()
                            // window.location.href=baseUrl+"berita/"+response.data.news.id
                            // window.open(baseUrl+"berita/"+response.data.news.id+"/perview")
                            window.location.href=baseUrl+"berita/"+response.data.news.id+"/perview"
                        }
                    }
          },
          error: function (xhr, ajaxOptions, thrownError) {
              ewpLoadingHide();
              loadStop()
              handleErrorDetail(xhr)
          },
    });
}

function edit(id){
    ewpLoadingShow();
    if (id != null) {
        $.ajax({
          type: "GET",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Authorization":"Bearer " + localStorage.getItem("token")
          },
          url: urlApi + "news/" + id,
          success: function (response) {
            res = response.data;
            
            $("#judul").val(noZero(res.title))
            desc.setData(noZero(res.content))
            $("#tanggal").val(fDate(res.created_at,'date14'))

            //$('#image-detail').attr("src",res?.news_file?.link)
            $('.image-input-wrapper').css("background-image","url('"+res?.news_file?.link+"')")

            ewpLoadingHide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
        });
    }
}


let tinyVal=''
function replaceImageSrc(){
    
    return new Promise(resolve => {
        //setTimeout(() => {
            tinyMCE.triggerSave();
            let tinyVals=$("#mytextarea").val()
            let loopImage=``
            if(imageArr.length>0){
                for(i in imageArr){
                    if(i==0){
                        loopImage=tinyVals.replace(imageArr[i].location, imageArr[i].watch)
                    }else{
                        loopImage=loopImage.replace(imageArr[i].location, imageArr[i].watch)
                    }
                }
            }else{
                loopImage=tinyVals
            }
            
            tinyVal=loopImage
            resolve("resolve")
        //}, 2000);
      });
}

function perview () {
   event.preventDefault()
   simpan('1','perview')
}