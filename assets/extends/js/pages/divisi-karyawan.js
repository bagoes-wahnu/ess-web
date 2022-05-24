var check_all

jQuery(document).ready(function($) {

    table()
    detailDivisi()

    check_all = false

    $('#mn-master').addClass('active')
    $('#mn-master .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('#mn-master .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
    $('#mn-master-parent').addClass('hover show')
    $('#mn-master-parent menu-sub').addClass('hover show')
    $('#dd-divisi').addClass('text-primary font-weight-bolder').removeClass('menu-title')


});	


function table() {
    
  document.getElementById("table-wrapper-karyawan").innerHTML = ewpTable({
    targetId: "dttb-master-divisi-karyawan",
    class: "table table-row-bordered bg-default table-head-custom table-vertical-center",
    column: [
    { name: "No", width: "5" },
    { name: "No", width: "5" },
    { name: "NIP", width: "15" },
    { name: "Username", width: "20" },
    { name: "Nama", width: "25" },
    { name: "Jabatan", width: "40" },
    ],
 });
  
  geekDatatableKaryawan({
    target: "#dttb-master-divisi-karyawan",
    url: urlApi + "division/non-division",
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

              let htmlCheck=`
                <label class="checkbox" data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih">
                  <input type="checkbox" name="Checkboxes1" class="check check-item" onclick="check(event)" data-id_karyawan="`+data+`" >
                  <span></span>
                </label>`
            return htmlCheck
          },
        },
      },
    {
      col: "id", 
      mid: true,
      mod: {
        aTargets: [1],
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
      col: "nip", 
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
      col: "username", 
      mid: true,
      mod: {
        aTargets: [3],
        bSortable:true,
        mRender: function (data, type, full,draw) {
          return noNull(data)
        },
      },
    },
    {
      col: "nama_karyawan", 
      mid: false,
      mod: {
        aTargets: [4],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          return noNull(data)
        },
      },
    },
    {
      col: "nama_jabatan", 
      mid: false,
      mod: {
        aTargets: [5],
        bSortable:false,
        mRender: function (data, type, full,draw) {
          return noNull(data)
        },
      },
    },
    
   ],
 });

}


function check(event) {

  var total_check = 0
  var total_check_checked = 0
  $('.check').each(function(index, value) {

      if ($(this).is(":checked")) {
        total_check_checked++     
      }

      total_check++
  });

  if (total_check_checked > 0) {
    $('#btn-tambah-karyawan').removeClass('d-none')
  } 
  else{
    $('#btn-tambah-karyawan').addClass('d-none')
    $('#check-all').prop('checked', false)
    $('#check-all').change()
  }

  if (total_check_checked == total_check) {
    $('#check-all').prop('checked', true)
    $('#check-all').change()
  }
}

function checkAll(event) {
  event.preventDefault()

  if (check_all == true) {
    check_all = false
  } else{
    check_all = true
  }

  if(check_all == true) {
    $('.check').prop('checked', true)
    $('#check-all').prop('checked', true)

    if ($('.check-item').length > 0) {
      $('#btn-tambah-karyawan').removeClass('d-none')
    }

  }
  else if (check_all == false){
     $('.check').prop('checked', false)
     $('#check-all').prop('checked', false)
     $('#btn-tambah-karyawan').addClass('d-none')
  }
  $('.check').change()
}

function addKaryawan() {

  ewpLoadingShow();
  loadStart();

  var selected_employees = []

  $('.check').each(function(index, value) {

      if ($(this).is(":checked")) {

        let data_karyawan = {
          divisi_id: $('#id_divisi').val(),
          employee_id: $(this).data('id_karyawan')
        }
        selected_employees.push(data_karyawan)
      }
  });

  var data = selected_employees
  $.ajax({
      type: "PATCH",
      dataType: "json",
      data: {
        data
      },
      url: urlApi + "division/add-division",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        "Authorization":"Bearer " + localStorage.getItem("token")
      },
      success: function (response) {
          // console.log(response);
          ewpLoadingHide();
          loadStop()

          // Swal.fire("Success!", response.status.message, "success");
          toastr.success(response.status.message);

          table()
          detailDivisi()
          $('#btn-tambah-karyawan').addClass('d-none')
      },
      error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          loadStop()
          handleErrorDetail(xhr)
      },
  });
}

function detailDivisi() {

  ewpLoadingShow();

  $.ajax({
      type: "GET",
      dataType: "json",
      url: urlApi + "division/" + $('#id_divisi').val(),
      headers: {
        "Authorization":"Bearer " + localStorage.getItem("token")
      },
      success: function (response) {
          // console.log(response);
          ewpLoadingHide();

          let data = response.data

          $('.nama-divisi').html(data.name)
          $('#tbody-karyawan-divisi').html('')

          let employees = data.employee

          var htmlTr = ``
          var no = 0
          for( e in employees) {

            no++
            let employee = employees[e]

            htmlTr += `<tr>
                          <td class="text-center"> ${no} </td>
                          <td class="text-center">${noNull(employee.nip)}</td>
                          <td  class="text-center"> ${noNull(employee.username)} </td>
                          <td> ${noNull(employee.nama_karyawan)} </td>
                          <td> ${noNull(employee.nama_jabatan)} </td>
                          <td class="text-center">
                              <button class="btn btn-icon btn-color-danger btn-active-light-danger" onclick="removeKaryawan(${employee.id})" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Karyawan">
                                  <i class="fa fa-trash" > </i>
                              </button>
                          </td>
                      </tr>`
          }
          $('#tbody-karyawan-divisi').html(htmlTr)
      },
      error: function (xhr, ajaxOptions, thrownError) {
        ewpLoadingHide();
        handleErrorDetail(xhr)
      },
  });
}


function removeKaryawan(id_karyawan) {
  Swal.fire({
        title: "Hapus Karyawan?",
        html: `Anda bisa menambahkan lagi karyawan ke divisi ini dilain waktu.`,
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Ya, Hapus",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton:"btn btn-secondary"
        }
    }).then(function(result) {
        if (result.value) { 

          $.ajax({
              type: "DELETE",
              headers: { 
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Authorization": "Bearer " + localStorage.getItem("token") },
              url: urlApi+"division/delete-division/" + id_karyawan ,
              success: function (response) {
                toastr.success(response.status.message);
                table();
                detailDivisi()
              },
              error: function (xhr, ajaxOptions, thrownError) {
                  handleErrorDetail(xhr)
              },
          });

        }
    })
}