jQuery(document).ready(function($) {
    show()
   let url=window.location.href
   let urls=url.split("/")
   let last_url=urls[urls.length-1]
   console.log(last_url)
   if(last_url=="setting-izin"){
    $('#mn-setting').addClass('active')
    $('#mn-setting .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-setting .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-setting-parent').addClass('hover show')
    $('#mn-setting-parent menu-sub').addClass('hover show')
    $('#dd-setting-izin').addClass('text-primary font-weight-bolder').removeClass('menu-title')

    // $('#mn-setting-izin').addClass('active')
    // $('a#mn-setting-izin .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    // $('a#mn-setting-izin .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
   }else{
    $('#mn-setting').addClass('active')
    $('#mn-setting .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-setting .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-setting-parent').addClass('hover show')
    $('#mn-setting-parent menu-sub').addClass('hover show')
    $('#dd-target-poin').addClass('text-primary font-weight-bolder').removeClass('menu-title')

    // $('#mn-target-poin').addClass('active')
    // $('a#mn-target-poin .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    // $('a#mn-target-poin .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
   }
});	

function editSetting(param) {
    $('#modal #id').val(param)
    $('#modal #hari-maksimal').val($('#input-'+param).val())
    $('#modal .modal-title,#modal .modal-desc').html($('#title-'+param).html())
    
	$('#modal').modal('show')
    if(param=="5"){
         $('#modal .pembilang').html("Poin")
         $('#modal .text-pembilang').html("Poin Maksimal Tahunan")
    }else if(param=="6"){
         $('#modal .pembilang').html("Jam")
         $('#modal .text-pembilang').html("CSR Maksimal")
    }
}

function show(){
    $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: urlApi + "setting",
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
        },
        success: function (response) {
            let res=response.data.setting
            for (i in res){
                if(res[i].key_setting=="permission_without_statement"){
                    $('.data-1').html(noNull(res[i].value_setting)+" Hari")
                     $('#input-1').val(res[i].value_setting)
                }else if(res[i].key_setting=="permission_with_statement"){
                    $('.data-2').html(noNull(res[i].value_setting)+" Hari")
                     $('#input-2').val(res[i].value_setting)
                }else if(res[i].key_setting=="permission_with_doctor_statement"){
                    $('.data-3').html(noNull(res[i].value_setting)+" Hari")
                     $('#input-3').val(res[i].value_setting)
                }else if(res[i].key_setting=="annual_leave"){
                    $('.data-4').html(noNull(res[i].value_setting)+" Hari")
                     $('#input-4').val(res[i].value_setting)
                }else if(res[i].key_setting=="annual_point_target"){
                    $('.data-5').html(noNull(res[i].value_setting)+" Poin")
                     $('#input-5').val(res[i].value_setting)
                }else if(res[i].key_setting=="annual_csr_point_target"){
                    $('.data-6').html(noNull(res[i].value_setting)+" Jam")
                     $('#input-6').val(res[i].value_setting)
                }else if(res[i].key_setting=="maternity_leave"){
                    $('.data-7').html(noNull(res[i].value_setting)+" Hari")
                     $('#input-7').val(res[i].value_setting)
                }else if(res[i].key_setting=="cuti_besar"){
                    $('.data-8').html(noNull(res[i].value_setting)+" Hari")
                     $('#input-8').val(res[i].value_setting)
                }else{
                    console.log("other")
                }
                
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          handleErrorDetail(xhr);
        },
    });
}

function simpan(){
    loadStart()
    ewpLoadingShow()
    let param= $('#modal #id').val()
    let link=""
    let data={}
    switch(param) {
        case "1":
          link="setting/permission-without-statement"
          data={
              "value_setting": $('#modal #hari-maksimal').val()
          }
          break;
        case "2":
          link="setting/permission-with-statement"
          data={
              "value_setting": $('#modal #hari-maksimal').val()
          }
          break;
        case "3":
          link="setting/permission-with-doctor-statement"
          data={
              "value_setting": $('#modal #hari-maksimal').val()
          }
          break;
        case "4":
          link="setting/annual-leave"
          data={
              "value_setting": $('#modal #hari-maksimal').val()
          }
          break;
        case "6":
            link="setting/annual-leave"
            data={
                "value_setting": $('#modal #hari-maksimal').val()
            }
            break;
        case "7":
            link="setting/maternity-leave"
            data={
                "value_setting": $('#modal #hari-maksimal').val()
            }
            break;
        case "8":
            link="setting/cuti-besar"
            data={
                "value_setting": $('#modal #hari-maksimal').val()
            }
            break;
        default:
          link="setting/annual-csr-point-target"
          data={
              "value_setting": $('#modal #hari-maksimal').val()
          }
      }

    $.ajax({
          type: "POST",
          dataType: "json",
          data: data,
          url: urlApi+link,
          beforeSend: function (xhr) {
          xhr.setRequestHeader(
              "Authorization",
              "Bearer " + localStorage.getItem("token")
          );
          },
          success: function (response) {
          loadStop()
            $('#modal').modal('hide')
            // swal.fire({
            //     title: "Berhasil!",
            //     text: "Data berhasil tersimpan",
            //     icon: "success",
            //     confirmButtonText: "Selesai",
            // }).then((value) => {
            //     location.reload()
            // });
            ewpLoadingHide()
            toastr.success("Data berhasil tersimpan!");
            show()
          },
          error: function (xhr, ajaxOptions, thrownError) {
            loadStop()
            handleErrorDetail(xhr)
        },
    });
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