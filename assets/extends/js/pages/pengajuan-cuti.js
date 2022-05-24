let dateFilter=""
jQuery(document).ready(function($) {
	table()
    $('#mn-pengajuan-cuti').addClass('active')
    $('a#mn-pengajuan-cuti .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('a#mn-pengajuan-cuti .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')

    $(document).on("change", '#filter-bulan', function (e) {
        let value=$(this).val()
        let valSplit=value.split("-")
        if(valSplit.length==2){
            dateFilter=valSplit[1]+"-"+valSplit[0]
            table()
        }
    });
});	




function table() {
  document.getElementById("table-wrapper").innerHTML = ewpTable({
    targetId: "dttb-pengajuan-cuti",
    class: "table table-row-bordered bg-default table-head-custom table-vertical-center",
    column: [
    { name: "No", width: "10" },
    { name: "Nama", width: "35" },
    { name: "Jabatan", width: "35" },
    { name: "Action", width: "20" },
    ],
  });
  
  geekDatatablesCuti({
    target: "#dttb-pengajuan-cuti",
    url: urlApi + "karyawan/cuti?date="+dateFilter,
    sorting: [0, "desc"],
    apiKey: "data",
    column: [
    {
      col: "permission_id", 
      mid: true,
      mod: {
        aTargets: [0],
        bSortable:false,
        mRender: function (data, type, full,draw) {

          var row = draw.row;
          var start = draw.settings._iDisplayStart;
          var length = draw.settings._iDisplayLength;

          var counter = start + 1 + row;

          return counter;
        },
      },
    },
    {
      col: "user.name", 
      mid: true,
      mod: {
        aTargets: [1],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          return noNull(full?.user?.name)
        },
      },
    },
    {
      col: "jabatan", 
      mid: true,
      mod: {
        aTargets: [2],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          return noNull(full?.user?.position?.nama)
        },
      },
    },
   
    {
      col: "permission_id",
      mid: true,
      mod: {
        aTargets: [-1],
        bSortable:false,
        mRender: function (data, type, full) {

        	// console.log(full);
        	var btn = `
            <a class="btn btn-icon btn-color-primary btn-active-light-primary" href="`+urlApi+`report/report_cuti/`+full.permission_id+`/show?token=`+localStorage.getItem("token")+`" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat PDF">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.33331 7.3335C5.99017 7.3335 7.33331 5.99035 7.33331 4.3335C7.33331 2.67664 5.99017 1.3335 4.33331 1.3335C2.67646 1.3335 1.33331 2.67664 1.33331 4.3335C1.33331 5.99035 2.67646 7.3335 4.33331 7.3335Z" fill="#00A1D3"/>
                <path opacity="0.3" d="M8.66665 4.3335C8.66665 2.66683 9.99998 1.3335 11.6666 1.3335C13.3333 1.3335 14.6666 2.66683 14.6666 4.3335C14.6666 6.00016 13.3333 7.3335 11.6666 7.3335C9.99998 7.3335 8.66665 6.00016 8.66665 4.3335ZM4.33331 14.6668C5.99998 14.6668 7.33331 13.3335 7.33331 11.6668C7.33331 10.0002 5.99998 8.66683 4.33331 8.66683C2.66665 8.66683 1.33331 10.0002 1.33331 11.6668C1.33331 13.3335 2.66665 14.6668 4.33331 14.6668ZM11.6666 14.6668C13.3333 14.6668 14.6666 13.3335 14.6666 11.6668C14.6666 10.0002 13.3333 8.66683 11.6666 8.66683C9.99998 8.66683 8.66665 10.0002 8.66665 11.6668C8.66665 13.3335 9.99998 14.6668 11.6666 14.6668Z" fill="#00A1D3"/>
                </svg>
            </a>

            <a class="btn btn-icon btn-color-primary btn-active-light-primary" href="`+urlApi+`report/report_cuti/`+full.permission_id+`/cetak?token=`+localStorage.getItem("token")+`"  data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 14.6668H1.99998C1.59998 14.6668 1.33331 14.4002 1.33331 14.0002C1.33331 13.6002 1.59998 13.3335 1.99998 13.3335H14C14.4 13.3335 14.6666 13.6002 14.6666 14.0002C14.6666 14.4002 14.4 14.6668 14 14.6668ZM8.66665 8.93351V2.00016C8.66665 1.60016 8.39998 1.3335 7.99998 1.3335C7.59998 1.3335 7.33331 1.60016 7.33331 2.00016V8.93351H8.66665Z" fill="#00A1D3"/>
                <path opacity="0.3" d="M4.66669 8.93359H11.3334L8.46668 11.8003C8.20002 12.0669 7.80002 12.0669 7.53336 11.8003L4.66669 8.93359Z" fill="#00A1D3"/>
                </svg>
            </a>
            <div id="div-hidden-`+data+`">
                <a class="d-none" href="#" target="_blank" id="watch-`+data+`">w</a>
                <a class="d-none" href="#" data-fancybox="iframe" data-fancybox-type="iframe" id="watchs-`+data+`">w</a>
            </div>
            `

            return btn
        },
      },

    },
            
   ],
 });

}

function openFiles(id,param){
    if (id != null) {
        $.ajax({
            type: "GET",
            headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: urlApi + 'karyawan/'+id,
            beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + localStorage.getItem("token")
            );
    
            },
            success: function (response) {
            ewpLoadingHide();
            res = response.data;

            console.log(res)
            if(param=="open"){
                //$('#watch-'+id).attr("href",res.link)
                var link = document.createElement('a');
                // Add the element to the DOM
                link.setAttribute("type", "hidden"); // make it hidden if needed
                link.target = '_blank';
                link.href = res.link;
                console.log("res.link")
                console.log(res.link)
                document.body.appendChild(link);
                link.click();
                link.remove();
            }else{
                var link = document.createElement('a');
                // Add the element to the DOM
                link.setAttribute("type", "hidden"); // make it hidden if needed
                link.download = '';
                link.href = res.link;
                console.log("res.link")
                console.log(res.link)
                document.body.appendChild(link);
                link.click();
                link.remove();
            }       
            },
            error: function (res) {
            ewpLoadingHide();
            handleErrorDetail(res);
            },
        });
        } 
}

async function openFilesOnClick(id,param){
    //await openFiles();
    // console.log(result)
    // if(result==undefined){
        let result = await openFiles(id,param)
        console.log(result)
        if(result=="success"){
            if(param=="open"){
                //window.open(res.link)
                //window.location.href=res.link
                console.log($('#watch-'+id))
                $('#watch-'+id).click()
                
            }else{
                // console.log($('#files-'+id))
                // $('#files-'+id).click()
            }
        }
       
    //}
}