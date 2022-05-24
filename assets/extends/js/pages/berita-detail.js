
$(document).ready(function () {
    show($('#id').val())
    console.log($('#id').val())
    $('#mn-berita').addClass('active')
    $('a#mn-berita .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('a#mn-berita .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
});

function show(id){
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
            
            $("#judul").html(noNull(res.title))
            $("#desc").html(noNull(res.content))
            $("#creator").html(noNull(res?.created_by.name)+" - "+noNull(fDate(res.created_at,'date13')))

            let htmlImage=``
            const d = new Date()
            const unique = d.getTime()
            console.log(res.news_file?.link!==undefined)
            if(res.news_file?.link!==undefined){
                htmlImage=`<div style="background-image:url(`+res.news_file?.link+`&`+unique+`)" class="image-detail" ></div>`
                console.log(res.news_file?.link+`?`+unique)
            }else{
                htmlImage=`<div class="mb-4 image-detail" style='
                display: flex;
                justify-content: center;
                align-items: center;
                border: 1px dashed #bbb;'><p class="text-center"><i class="far fa-image"></i><br/>Belum ada gambar</p></div>`
            }
            $('#image-detail').html(htmlImage)

            let ribbon_color=res.status=='1'?"bg-warning":"bg-primary"
            let ribbon_text=res.status=='1'?"Draft":"Published"
            $('#status-ribbon').addClass(ribbon_color).removeClass("d-none")
            $('#status-ribbon').html(ribbon_text)
            console.log( $('#btn-ubah'))
            if(res.status=='1'){
                $('#btn-ubah').removeClass("d-none")
            }else{
                $('#btn-ubah').addClass("d-none")
            }

            ewpLoadingHide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
        });
    }
}

function ubah(){
    //window.open(baseUrl+"berita/"+$('#id').val()+"")
    window.location.href=baseUrl+"berita/"+$('#id').val()+""
}

