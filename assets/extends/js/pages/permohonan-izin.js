jQuery(document).ready(function($) {
	table()
    $('#mn-permohonan-izin').addClass('active')
    $('a#mn-permohonan-izin .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('a#mn-permohonan-izin .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
});	




function table() {
  document.getElementById("table-wrapper").innerHTML = ewpTable({
    targetId: "dttb-permohonan-izin",
    class: "table table-row-bordered bg-default table-head-custom table-vertical-center",
    column: [
    { name: "No", width: "10" },
    { name: "Tanggal Pengajuan", width: "20" },
    { name: "Nama", width: "20" },
    { name: "Jabatan", width: "20" },
    { name: "Keperluan", width: "25" },
    { name: "Action", width: "15" },
    ],
  });
  
  geekDatatables({
    target: "#dttb-permohonan-izin",
    url: urlApi + "permission/get-spjpk",
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

          var row = draw.row;
          var start = draw.settings._iDisplayStart;
          var length = draw.settings._iDisplayLength;

          var counter = start + 1 + row;

          return counter;
        },
      },
    },
    {
      col: "created_at", 
      mid: true,
      mod: {
        aTargets: [1],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          return fDate(data,'date13')
        },
      },
    },
    {
      col: "user.name", 
      mid: true,
      mod: {
        aTargets: [2],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          return noNull(data)
        },
      },
    },
    {
        col: "user.name", 
        mid: true,
        mod: {
          aTargets: [3],
          bSortable:false,
          mRender: function (data, type, full,draw) {
            return noNull(full.user?.position?.nama)
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
            return `<span class="badge badge-light-success">SPJPK</span>`
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
           let btn=``
            //0 : ditolak, 1, menunggu, 2 : disetujui
            if(full.status=="0"){
                btn = `
                <a href="`+baseUrl+`permohonan-izin/`+data+`" target="_blank" class="btn btn-icon btn-color-danger btn-active-light-danger"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                <i class="bi bi-x-circle-fill"></i>
                </button>
                `
              
            }else if(full.status=="1"){
                btn = `
                <a href="`+baseUrl+`permohonan-izin/`+data+`" target="_blank" class="btn btn-icon btn-color-primary btn-active-light-primary"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                <i class="bi bi-columns-gap"></i>
                </button>
                `
                
            }else{
                btn = `
                <a href="`+baseUrl+`permohonan-izin/`+data+`" target="_blank" class="btn btn-icon btn-color-success btn-active-light-success"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                <i class="bi bi-check-circle-fill"></i>
                </button>
                `
            }
        	
            return btn
        },
      },

    },
            
   ],
 });

}