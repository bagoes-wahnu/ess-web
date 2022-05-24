$(document).ready(function () {
    table()
    $('#mn-karyawan').addClass('active')
    $('a#mn-karyawan .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('a#mn-karyawan .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
});

function table() {
    document.getElementById("table-wrapper").innerHTML = ewpTable({
        targetId: "dttb-karyawan",
        class: "table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4",
        column: [
        { name: "No", width: "10" },
        { name: "NIP", width: "15" },
        { name: "Username", width: "20" },
        { name: "Nama", width: "15" },
        { name: "Jabatan", width: "10" },
        { name: "Action", width: "10" },
        ],
    });
    
    geekDatatables({
        target: "#dttb-karyawan",
        url: urlApi + "karyawan",
        sorting: [0, "asc"],
        apiKey: "data",
        column: [
        {
        col: "id", 
        mid: true,
        mod: {
            aTargets: [0],
            bSortable:true,
            "searchable": false,
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
        col: "nip", 
        mid: true,
        mod: {
            aTargets: [1],
            bSortable:true,
            "searchable": true,
            mRender: function (data, type, full,draw) {
            return noNull(data)
            },
        },
        },
        {
        col: "user.username", 
        mid: false,
        mod: {
            aTargets: [2],
            bSortable:true,
            "searchable": true,
            mRender: function (data, type, full,draw) {
            return noNull(data)
            },
        },
        },
        {
        col: "name", 
        mid: false,
        mod: {
            aTargets: [3],
            bSortable:true,
            "searchable": true,
            mRender: function (data, type, full,draw) {
                // console.log(full)
            return noNull(data)
            },
        },
        },
        {
        col: "position.nama", 
        mid: false,
        mod: {
            aTargets: [4],
            bSortable:false,
            "searchable": false,
            mRender: function (data, type, full,draw) {
                let nama = full.position?.nama !==undefined? noNull(full.position.nama):"-"

                return nama
            },
        },
        },
        {
        col: "id",
        mid: true,
        mod: {
            aTargets: [-1],
            bSortable:false,
            "searchable": true,
            mRender: function (data, type, full) {
    
                let button=`
                <button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="resetPass(`+data+`)" 
                data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Password">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.66666 13.8175C9.73333 14.1508 9.46667 14.5508 9.13334 14.6175C8.80001 14.6841 8.4 14.6841 8.06667 14.6841C6.33333 14.6841 4.6 14.0174 3.33333 12.7508C0.933331 10.3508 0.733322 6.48411 2.86666 3.88411L3.80001 4.81746C2.20001 6.88413 2.39999 9.88413 4.26666 11.8175C5.46666 13.0175 7.19999 13.6175 8.93333 13.2841C9.26666 13.2175 9.6 13.4841 9.66666 13.8175ZM12.2667 11.2174L13.2 12.1508C15.2667 9.5508 15.1333 5.68412 12.6667 3.28412C11.1333 1.75078 8.99999 1.08412 6.86666 1.41746C6.53332 1.48412 6.26666 1.81746 6.33333 2.1508C6.4 2.48413 6.73334 2.75079 7.06667 2.68412C8.73334 2.41745 10.4667 2.9508 11.7333 4.1508C13.6667 6.1508 13.8 9.15078 12.2667 11.2174Z" fill="#00A1D3"/>
                    <path opacity="0.3" d="M1.33331 2.41748H4.66665C5.06665 2.41748 5.33331 2.68415 5.33331 3.08415V6.41746L1.33331 2.41748ZM10.6666 9.61749V12.9508C10.6666 13.3508 10.9333 13.6175 11.3333 13.6175H14.6666L10.6666 9.61749Z" fill="#00A1D3"/>
                    </svg>
                </button>
                `
                return button;
            },
        },
    
        },
                
        ],
    });
    
}

function resetPass(id) {
	Swal.fire({
        title: 'Reset Password?',
        text: "Password user akan dikembalikan ke default password (ESS-1234)",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F64E60',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Reset',
        
    }).then((isConfirm) => {

        if (isConfirm.isConfirmed == true) { 
            console.log("ajax")
            ajaxResetPass(id)
        }
    })
}

function ajaxResetPass(id){
    $.ajax({
        type: "PUT",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: urlApi + "auth/reset-pass/"+id,
        
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
          ewpLoadingShow();
        },
        success: function (response) {
            Swal.fire("Success!", response.status.message, "success");
            // table()
            ewpLoadingHide();
        },
        error: function (response) {
            Swal.fire("Oopss!", response.status.message, "error");
            // table()
            ewpLoadingHide();
        }
    });
}