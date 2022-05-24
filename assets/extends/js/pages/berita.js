

let txtSearch=""
let txtStatus=""

$(document).ready(function () {
    //table()
    grid()
    $('#mn-berita').addClass('active')
    $('a#mn-berita .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('a#mn-berita .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    
    $("body").on('change', '#select-status', function (e) {
        txtStatus=$(this).val()=="0"?"":$(this).val()
        //grid()
    });

    $("body").on('keyup', '#txt-search', function (e) {
        txtSearch=$(this).val()
        //grid()
    });
});

function terapkan(){
    grid()
}

function showMode(param){
    if(param=="grid"){
        $("#grid-view").removeClass("d-none")
        $("#list-view").addClass("d-none")
        $('#btn-grid').removeClass('btn-light-primary').addClass("btn-light-danger")
        $('#btn-list').addClass('btn-light-primary').removeClass("btn-light-danger")
        $('#btn-grid').attr("disabled",true)
        $('#btn-list').attr("disabled",false)
    }else{
        $("#grid-view").addClass("d-none")
        $("#list-view").removeClass("d-none")
        $('#btn-grid').addClass('btn-light-primary').removeClass("btn-light-danger")
        $('#btn-list').removeClass('btn-light-primary').addClass("btn-light-danger")
        $('#btn-list').attr("disabled",true)
        $('#btn-grid').attr("disabled",false)
    }
}

function table() {
    document.getElementById("table-wrapper").innerHTML = ewpTable({
      targetId: "dttb-berita",
      class: "table table-row-bordered bg-default table-head-custom table-vertical-center",
      column: [
      { name: "Thumbnail", width: "20" },
      { name: "Judul", width: "30" },
      { name: "Author", width: "15" },
      { name: "Tanggal", width: "10" },
      { name: "Status", width: "15" },
      { name: "Action", width: "10" },
      ],
    });
    
    geekDatatables({
      target: "#dttb-berita",
      url: urlApi + "news/list-web?search="+txtSearch+"&status=&sortByDate=desc&sortByTitle=desc",
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
  
            let htmlImage=`<img src="" style="border-radius:3px"/>`
  
            return htmlImage;
          },
        },
      },
      {
        col: "title", 
        mid: true,
        mod: {
          aTargets: [1],
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
          aTargets: [2],
          bSortable:false,
          mRender: function (data, type, full,draw) {
            return noNull(full.created_by.name)
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
            return fDate(data,'date14')
          },
        },
      },
      {
          col: "id", 
          mid: true,
          mod: {
            aTargets: [4],
            bSortable:false,
            mRender: function (data, type, full,draw) {
                let htmlStatus=``
                if(full.status=="1"){
                    htmlStatus=`<span class="badge badge-light-warning">Draft</span>`
                }else if(full.status=="2"){
                    htmlStatus=`<span class="badge badge-light-primary">Published</span>`
                }else{
                    htmlStatus=`-`
                }
                
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
              <button class="btn btn-icon btn-color-warning btn-active-light-warning" onclick="edit(`+data+`)">
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

function grid(){
    ewpLoadingShow();
    $.ajax({
        type: "GET",
        headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        "Authorization":"Bearer " + localStorage.getItem("token")
        },
        url: urlApi + "news/web?search="+txtSearch+"&status="+txtStatus,
        success: function (response) {
        res = response.data;
        
        let htmlGrid=``
        let tableList=``

        for(r in res){
            let status=res[r].status=='1'?"Draft":"Published"
            let colorStatus=res[r].status=='1'?"warning":"primary"
            let desc=extractContent(res[r].content,true) //htmlEntities
            let desc_s=''
            let title=(res[r].title)
            let titles=''
            if(desc.length>100){
                desc_s=desc.substring(0,100)+"..."
            }else{
                desc_s=desc
            }
            if(desc.length>50){
                titles=title.substring(0,50)+"..."
            }else{
                titles=title
            }

            let htmlImage=``
            if(res[r].news_file?.link!==undefined){
                htmlImage= `<div class="news-image mb-4" style='background-image:url("`+res[r].news_file?.link+`")'></div>`
            }else{
                htmlImage=`<div class="news-image mb-4" style='
                display: flex;
                justify-content: center;
                align-items: center;
                border: 1px dashed #bbb;'><p class="text-center"><i class="far fa-image"></i><br/>Belum ada gambar</p></div>`
            }

            htmlGrid+=`
            <div class="col-md-4 mb-12" onclick="openDetail(`+res[r].id+`)">
                `+htmlImage+`
                <div>
                    <p class="fz-13 fw-bolder text-justify">`+titles+`</p>
                </div>
                <div>
                    <p class="text-justify text-muted">`+desc_s+`</p>
                </div>
                <div class="mt-4 row mx-0">
                    <div class="col-md-8 px-0 py-1 text-muted" style="font-size:10px"><strong>`+res[r].created_by.name+`</strong> - `+fDate(res[r].created_at,'date13')+`</div>
                    <div class="col-md-4 text-right"><span class="badge badge-light-`+colorStatus+`">`+status+`</span></div>
                </div>
            </div>
            `   


            let btnTable=``
            if(res[r].status=='1'){
                btnTable=`
                <a class="" href="`+baseUrl+`berita/`+res[r].id+`"><i class="text-warning bi bi-pencil-square me-3" style="font-size: 20px;" 
                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>`
            }else{
                btnTable=``
            }

            let num=parseInt(r)+1
            let showGambar=res[r].news_file?.link==undefined
            ?`<i class="bi bi-card-image"></i><br/><small>Belum ada gambar</small>`
            :`<img src="`+res[r].news_file?.link+`" style="border-radius:3px;width:100%;max-height:100px"/>`
            tableList+=`
            <tr>
                <td>`+num+`</td>
                <td style="vertical-align:middle;text-align:center;" class="text-muted">`+showGambar+`</td>
                <td>`+res[r].title+`</td>
                <td>`+fDate(res[r].created_at,'date13')+`</td>
                <td>
                    <span class="badge badge-light-`+colorStatus+`">`+status+`</span>
                </td>
                <td>
                    `+btnTable+`
                </td>
            </tr>
            `
        }

        $('#grid-list').html(htmlGrid)
        $('#table-list').html(tableList)

        ewpLoadingHide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
        ewpLoadingHide();
        handleErrorDetail(xhr);
        },
    });
}

function extractContent(s, space) {
    var span= document.createElement('span');
    span.innerHTML= s;
    if(space) {
      var children= span.querySelectorAll('*');
      for(var i = 0 ; i < children.length ; i++) {
        if(children[i].textContent)
          children[i].textContent+= ' ';
        else
          children[i].innerText+= ' ';
      }
    }
    return [span.textContent || span.innerText].toString().replace(/ +/g,' ');
  };

function openDetail(id){
    event.preventDefault()
    //window.open(baseUrl+"berita/"+id+"/perview")
    window.location.href=baseUrl+"berita/"+id+"/perview"
}

