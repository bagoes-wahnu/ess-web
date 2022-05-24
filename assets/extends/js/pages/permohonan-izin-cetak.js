jQuery(document).ready(function($) {
	show($('#id').val())
    
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
          url: urlApi + "permission/" + id,
          success: function (response) {
            res = response.data;
            
            $(".txt-tanggal").html(fDate(res.start_date,'date4'))
            $(".txt-berlaku").html(fDate(res.end_date,'date4'))
            $(".txt-istri").html(noNull(res.name))
            $(".txt-np").html(noNull(res.cp))
            $(".txt-cp").html(noNull(res.np))
            $(".txt-jenis").html(noNull(res.jenis_perawatan))
            $(".txt-address").html(noNull(res.address))
            $(".txt-diagnosa").html(noNull(res.diagnose))
            $(".txt-desc").html(noNull(res.desc))
            $(".txt-biaya").html("Rp. "+ewpFormatDots(res.rate))
            console.log(res.status)
            if(res.status==1){
                
                $(".status-indicator").addClass("d-none")
            }else if(res.status==2){
                $('#div-keputusan').addClass('d-none')
                $(".status-indicator").html("Diterima")
                $(".status-indicator").addClass("bg-success")
            }else{
                $('#div-keputusan').addClass('d-none')
                $(".status-indicator").html("Ditolak")
                $(".status-indicator").addClass("bg-danger")
            }

            $(".txt-instansi").html(noNull(res?.instansi?.name))
            $(".txt-alamat-instansi").html(noNull(res?.instansi?.address))
            
            

            ewpLoadingHide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
        });
    }
}

function keputusanIzin(param) {
    let kep= param=='0'?'Tolak': 'Terima'
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang sudah di rubah tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F64E60',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, '+kep,
        
    }).then((isConfirm) => {
        if (isConfirm.isConfirmed == true) { 
            $.ajax({
                type: "PATCH",
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Authorization": "Bearer " + localStorage.getItem("token") },
                data: {
                    status: param,
                },
                url: urlApi+"permission/action/" + $('#id').val() ,
                success: function (response) {
                toastr.success("Status Berhasil Diubah!")
                window.location.href=baseUrl+"permohonan-izin"
                
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    handleErrorDetail(xhr)
                },
            });
        }
    })
    
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