var ewpTable = function (data) {
  if (data === "undefined") {
    console.log("missing param");
  } else {
    var el_id = data["targetId"] !== "undefined" ? data["targetId"] : "";
    var el_class = data["class"] !== "undefined" ? data["class"] : "";
    var column = data["column"] !== "undefined" ? data["column"] : "";
    var setFooter = data["footer"] !== "undefined" ? data["footer"] : false;

    var thead = "";
    var tfoot = "";

    if (column !== "undefined") {
      for (i = 0; i < column.length; i++) {
        var width =
          column[i]["width"] !== "undefined" ? column[i]["width"] : "";
        var icon = column[i]["icon"] !== "undefined" ? column[i]["icon"] : "";
        var name = column[i]["name"] !== "undefined" ? column[i]["name"] : "";

        thead +=
          '<th class="fw-bold" width="' +
          width +
          '%"><i class="' +
          icon +
          '"></i>&nbsp; ' +
          name +
          "</th>";
        tfoot +=
          '<th width="' +
          width +
          '%"><i class="' +
          icon +
          '"></i>&nbsp; ' +
          name +
          "</th>";
      }
    }

    var html =
      '<table class="' +
      el_class +
      '" id="' +
      el_id +
      '" data-ride="datatables" style="width: 100%;">' +
      "<thead><tr>" +
      thead +
      "</tr></thead>" +
      "<tbody><tr><td>&nbsp;</td></tr></tbody>" +
      (setFooter == true ? "<tfoot><tr>" + tfoot + "</tr></tfoot>" : "") +
      "</table>";

    return html;
  }
};

var ewpDatatables = function (data) {
  let dTable,
    column = [],
    modColumn = [],
    isServerSide = data.serverSide ? data.serverSide : true;

  for (var i = 0; i < data.column.length; i++) {
    // Menggambar Kolom
    column.push({ mData: data.column[i]["col"] });

    // Modifikasi kolom
    if (data.column[i]["mod"] != null) {
      modColumn.push(data.column[i]["mod"]);
    }
  }

  $(data.target).each(function () {
    dTable = $(this).dataTable({
      bDestroy: true,
      processing: true,
      serverSide: isServerSide,
      ajax: {
        url: data.url,
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataSrc: function (json) {
          json.draw = $('[name="draw"]').val();
          json.recordsTotal = json.data.meta.total;
          json.recordsFiltered = json.data.meta.total;
          return json.data[data.apiKey];
        },
      },
      sPaginationType: "full_numbers",
      dom:
        "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-4'f><'col-sm-12 col-md-2 text-center'<'btn_search mt-2 mb-3'>>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
      aoColumns: column,
      aaSorting: [data.sorting],
      lengthMenu: [10, 25, 50, 75, 100],
      pageLength: 10,
      aoColumnDefs: modColumn,
      fnDrawCallback: function (oSettings) {
        $("tbody tr").each(function () {
          $('[data-toggle="tooltip"]').tooltip();
        });
        $(".btn_search").html(
          `<a href="javacript:;" class="kt-font-primary"><u><i class="la la-search"></i>  Advanced Search</u></a>`
        );
      },
      fnHeaderCallback: function (nHead, aData, iStart, iEnd, aiDisplay) {
        $(nHead).children("th").addClass("text-center");
      },
      fnFooterCallback: function (nFoot, aData, iStart, iEnd, aiDisplay) {
        $(nFoot).children("th").addClass("text-center");
      },
      fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        for (var i = 0; i < data.column.length; i++) {
          if (data.column[i]["mid"] == true) {
            $(nRow)
              .children("td:nth-child(" + (i + 1) + ")")
              .addClass("text-center");
          }
        }
      },
    });
  });

  return dTable;
};

var geekDatatables = function (data) {
  let dTable,
    column = [],
    modColumn = [],
    isServerSide = data.serverSide ? data.serverSide : true;

  for (var i = 0; i < data.column.length; i++) {
    // Menggambar Kolom
    column.push({ mData: data.column[i]["col"] });

    // Modifikasi kolom
    if (data.column[i]["mod"] != null) {
      modColumn.push(data.column[i]["mod"]);
    }
  }

  $(data.target).each(function () {
    dTable = $(this).DataTable({
      bDestroy: true,
      processing: true,
      serverSide: isServerSide,
      "dom":
        "<'row'" +
        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        ">" +

        "<'table-responsive'tr>" +

        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
      ajax: {
        url: data.url,
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
          KTMenu.init()
        },
        complete: function (data) {
          KTMenu.init()
         },
				error: function (xhr, ajaxOptions, thrownError) {
					handleErrorDetail(xhr,'login');
          
				}
      },
      sPaginationType: "full_numbers",
      // dom:
      // "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-4'f><'col-sm-12 col-md-2 text-center'<'btn_search mt-2 mb-3'>>>" +
      // "<'row'<'col-md-12'tr>>" +
      // "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
      aoColumns: column,
      aaSorting: [data.sorting],
      lengthMenu: [10, 25, 50, 75, 100],
      pageLength: 10,
      aoColumnDefs: modColumn,
      fnDrawCallback: function (oSettings) {
        $("tbody tr").each(function () {
          $('[data-toggle="tooltip"]').tooltip();
        });
        $(".btn_search").html(
          `<a href="javacript:;" class="kt-font-primary"><u><i class="la la-search"></i>  Advanced Search</u></a>`
        );
      },
      fnHeaderCallback: function (nHead, aData, iStart, iEnd, aiDisplay) {
        $(nHead).children("th").addClass("text-center");
      },
      fnFooterCallback: function (nFoot, aData, iStart, iEnd, aiDisplay) {
        $(nFoot).children("th").addClass("text-center");
      },
      fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        for (var i = 0; i < data.column.length; i++) {
          if (data.column[i]["mid"] == true) {
            $(nRow)
              .children("td:nth-child(" + (i + 1) + ")")
              .addClass("text-center");
          }
        }
      },
    });
  });

  return dTable;
};

var geekDatatableKaryawan = function (data) {
  let dTable,
    column = [],
    modColumn = [],
    isServerSide = data.serverSide ? data.serverSide : true;

  for (var i = 0; i < data.column.length; i++) {
    // Menggambar Kolom
    column.push({ mData: data.column[i]["col"] });

    // Modifikasi kolom
    if (data.column[i]["mod"] != null) {
      modColumn.push(data.column[i]["mod"]);
    }
  }

  $(data.target).each(function () {
    dTable = $(this).DataTable({
      bDestroy: true,
      processing: true,
      serverSide: isServerSide,
      "dom":
        "<'row'" +
        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        ">" +

        "<'table-responsive'tr>" +

        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
      ajax: {
        url: data.url,
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
          KTMenu.init()
        },
        complete: function (data) {
          KTMenu.init()
         },
        error: function (xhr, ajaxOptions, thrownError) {
          handleErrorDetail(xhr,'login');
          
        }
      },
      sPaginationType: "full_numbers",
      // dom:
      // "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-4'f><'col-sm-12 col-md-2 text-center'<'btn_search mt-2 mb-3'>>>" +
      // "<'row'<'col-md-12'tr>>" +
      // "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
      aoColumns: column,
      aaSorting: [data.sorting],
      lengthMenu: [10, 25, 50, 75, 100],
      pageLength: 10,
      aoColumnDefs: modColumn,
      fnDrawCallback: function (oSettings) {
        $("tbody tr").each(function () {
          $('[data-toggle="tooltip"]').tooltip();
        });
        $(".btn_search").html(
          `<a href="javacript:;" class="kt-font-primary"><u><i class="la la-search"></i>  Advanced Search</u></a>`
        );
      },
      fnHeaderCallback: function (nHead, aData, iStart, iEnd, aiDisplay) {
        $(nHead).children("th").addClass("text-center");
        $(nHead).children("th:nth-child(1)").html(`<label class="checkbox" onclick="checkAll(event)" data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih semua"><input type="checkbox" id="check-all" ><span></span></label>  `);
      },
      fnFooterCallback: function (nFoot, aData, iStart, iEnd, aiDisplay) {
        $(nFoot).children("th").addClass("text-center");
      },
      fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        for (var i = 0; i < data.column.length; i++) {
          if (data.column[i]["mid"] == true) {
            $(nRow)
              .children("td:nth-child(" + (i + 1) + ")")
              .addClass("text-center");
          }
        }
      },
    });
  });

  return dTable;
};

var geekDatatablesCuti = function (data) {
    let dTable,
      column = [],
      modColumn = [],
      isServerSide = data.serverSide ? data.serverSide : true;
  
    for (var i = 0; i < data.column.length; i++) {
      // Menggambar Kolom
      column.push({ mData: data.column[i]["col"] });
  
      // Modifikasi kolom
      if (data.column[i]["mod"] != null) {
        modColumn.push(data.column[i]["mod"]);
      }
    }
  
    $(data.target).each(function () {
      dTable = $(this).DataTable({
        bDestroy: true,
        processing: true,
        serverSide: isServerSide,
        "dom":
          "<'row'" +
          "<'col-sm-3 d-flex align-items-center justify-conten-start'l>" +
          "<'#div-month.col-md-4 form-group mb-4'>"+
          "<'col-md-2'>"+
          "<'col-sm-3 d-flex align-items-center justify-content-end'f>" +
          ">" +
  
          "<'table-responsive'tr>" +
  
          "<'row'" +
          "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
          "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
          ">",
        ajax: {
          url: data.url,
          type: "GET",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          beforeSend: function (xhr) {
            xhr.setRequestHeader(
              "Authorization",
              "Bearer " + localStorage.getItem("token")
            );
            KTMenu.init()
          },
          complete: function (data) {
            KTMenu.init()
           },
                  error: function (xhr, ajaxOptions, thrownError) {
                      handleErrorDetail(xhr,'login');
            
                  }
        },
        sPaginationType: "full_numbers",
        // dom:
        // "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-4'f><'col-sm-12 col-md-2 text-center'<'btn_search mt-2 mb-3'>>>" +
        // "<'row'<'col-md-12'tr>>" +
        // "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
        aoColumns: column,
        aaSorting: [data.sorting],
        lengthMenu: [10, 25, 50, 75, 100],
        pageLength: 10,
        aoColumnDefs: modColumn,
        fnDrawCallback: function (oSettings) {
          $("tbody tr").each(function () {
            $('[data-toggle="tooltip"]').tooltip();
          });
          $("#div-month").html(
            `<input type="text" class="form-control" name="" id="filter-bulan" placeholder="semua bulan" readonly="">`
          );
          $("#filter-bulan").datepicker( {
                format: "mm-yyyy",
                startView: "months", 
                minViewMode: "months",
                changeYear: true,
                // changeMonth: true,
                orientation: "bottom left",
                autoclose: true,
            });
        },
        fnHeaderCallback: function (nHead, aData, iStart, iEnd, aiDisplay) {
          $(nHead).children("th").addClass("text-center");
        },
        fnFooterCallback: function (nFoot, aData, iStart, iEnd, aiDisplay) {
          $(nFoot).children("th").addClass("text-center");
        },
        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          for (var i = 0; i < data.column.length; i++) {
            if (data.column[i]["mid"] == true) {
              $(nRow)
                .children("td:nth-child(" + (i + 1) + ")")
                .addClass("text-center");
            }
          }
        },
      });
    });
  
    return dTable;
  };

// var fDate = function (tgl, type) {
//   if (type == "date1") {
//     var split_tgl = tgl.split("-");
//     if (split_tgl.length == 3) {
//       return split_tgl[2] + "-" + split_tgl[1] + "-" + split_tgl[0];
//     } else {
//       return "Unknown";
//     }
//   } else if (type == "date2") {
//     var split_tgl = tgl.split("-");
//     if (split_tgl.length == 3) {
//       return split_tgl[2] + " " + monthName(split_tgl[1]) + " " + split_tgl[0];
//     } else {
//       return "Unknown";
//     }
//   } else if (type == "date3") {
//     var split_tgl = tgl.split(" ");
//     if (split_tgl.length == 2) {
//       var split_tgl1 = split_tgl[0].split("-");
//       if (split_tgl1.length == 3) {
//         return (
//           split_tgl1[0] +
//           " " +
//           monthName(split_tgl1[1]) +
//           " " +
//           split_tgl1[2] +
//           " " +
//           split_tgl[1]
//         );
//       } else {
//         return "Unknown";
//       }
//     } else {
//       return "Unknown";
//     }
//   } else if (type == "date4") {
//     var split_tgl = tgl.split("-");
//     if (split_tgl.length == 3) {
//       return split_tgl[2] + " " + monthNameS(split_tgl[1]) + " " + split_tgl[0];
//     } else {
//       return "Unknown";
//     }
//   } else {
//     return "Unknown";
//   }
// };

// function monthName(number) {
//   if (number == "1") return "Januari";
//   else if (number == "2") return "Februari";
//   else if (number == "3") return "Maret";
//   else if (number == "4") return "April";
//   else if (number == "5") return "Mei";
//   else if (number == "6") return "Juni";
//   else if (number == "7") return "Juli";
//   else if (number == "8") return "Agustus";
//   else if (number == "9") return "September";
//   else if (number == "10") return "Oktober";
//   else if (number == "11") return "November";
//   else if (number == "12") return "Desember";
//   else return "Unknown";
// }

function monthName(number) {
  if (number == "1") return "Januari";
  else if (number == "02") return "Februari";
  else if (number == "03") return "Maret";
  else if (number == "04") return "April";
  else if (number == "05") return "Mei";
  else if (number == "06") return "Juni";
  else if (number == "07") return "Juli";
  else if (number == "08") return "Agustus";
  else if (number == "09") return "September";
  else if (number == "10") return "Oktober";
  else if (number == "11") return "November";
  else if (number == "12") return "Desember";
  else return "Unknown";
}

function monthNameS(number) {
  if (number == "01") return "Jan";
  else if (number == "02") return "Feb";
  else if (number == "03") return "Mar";
  else if (number == "04") return "Apr";
  else if (number == "05") return "May";
  else if (number == "06") return "Jun";
  else if (number == "07") return "Jul";
  else if (number == "08") return "Aug";
  else if (number == "09") return "Sep";
  else if (number == "10") return "Oct";
  else if (number == "11") return "Nov";
  else if (number == "12") return "Dec";
  else return "Unknown";
}

var fRupiah = function (angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
};

function getTypeOpportunity(type) {
  if (type == "1") return "Research";
  else if (type == "2") return "Funding";
  else return "-";
}

function replaceNull(val) {
  if (val == null) return "-";
  else return val;
}

function getID() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const type = urlParams.get("id");
  if (typeof type === "undefined") {
    return null;
  } else {
    return type;
  }
}

function getParamID(){
  var currentUrl = window.location.href
  var arrayUrl = currentUrl.split("/");
  var idUrl = parseInt(arrayUrl.slice(-1)[0])
  if(isNaN(idUrl))
  return null
  else
  return idUrl
}

function cekAksesMenu(url) {
  $.ajax({
    type: "GET",
    async: false,
    beforeSend: function (xhr) {
      xhr.setRequestHeader(
        "Authorization",
        "Bearer " + localStorage.getItem("token")
      );
    },
    url: urlApi + "menu/sidebar?url=" + url,
    success: function (response) {
      accessDetail = response.data[0].action_role;
      if (accessDetail.includes("C")) {
        $("#create-" + url).show();
      }
    },
    error: function (response) {
      window.location.href = baseUrl + "not-available";
    },
  });
}


function load_master(type, place_holder, url, formID = 'form-input', mode = false) {

  // console.log(url);
  $(".list_" + type).select2({
    dropdownParent: $("#"+formID),
    placeholder: "Pilih " + place_holder,
    allowClear: mode,
    ajax: {
      url: urlApi + url,
      dataType: "json",
      type: "GET",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", "Bearer " + localStorage.getItem("token"));
      },
      quietMillis: 50,
      data: function (params) {
        search = params.term;
        var query = {
          search_value: search,
        };
        return query;
      },
      processResults: function (data) {
        return {
          results: $.map(data.data, function (item) {
            return {
              text: item.nama,
              id: item.id,
            };
          }),
        };
      },
      error: function (xhr, ajaxOptions, thrownError) {
        handleErrorSelect2(xhr);
      },
    },
  });
}

function sLoader(nama, ph) {

  console.log(nama);
    $("#select_"+nama).select2({
      allowClear: true,
      placeholder: "Pilih "+ph,
      ajax: {
        url: urlApi + "select_list/"+nama,
        dataType: "json",
        type: "GET",
        quietMillis: 50,
        headers: {
            "Authorization" : "Bearer "+localStorage.getItem('token'),
        },
       
        data: function (term) {
          return {
            status:1,
            search_field:"",
            search_value:term.term,
            order_field:"",
            order_sort:"",
            page:"",
            per_page:"",
          };
        },
        // beforeSend: function (xhr) {
        //   xhr.setRequestHeader(
        //     "Authorization",
        //     "Bearer " + localStorage.getItem("token")
        //   );
        // },
        processResults: function (data) {
          return {
            results: $.map(data.data[nama], function (item) {
              return {
                text: item.name,
                id: item.id,
              };
            }),
          };
        },
      },
    });
  }
  
function load_master_id(type, place_holder, url, formID = 'form-input', mode = false) {
  $("#" + type).select2({
    dropdownParent: $("#"+formID),
    placeholder: "Pilih " + place_holder,
    allowClear: mode,
    ajax: {
      url: urlApi + url,
      dataType: "json",
      type: "GET",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", "Bearer " + localStorage.getItem("token"));
      },
      quietMillis: 50,
      data: function (params) {
        search = params.term;
        var query = {
          search: search,
        };
        return query;
      },
      processResults: function (data) {
        return {
          results: $.map(data.data, function (item) {
            return {
              text: item.name,
              id: item.id,
            };
          }),
        };
      },
      error: function (xhr, ajaxOptions, thrownError) {
        handleErrorSelect2(xhr);
      },
    },
  });
}



var fDate = function(tgl, type){
	if(type == 'date1'){
		var split_tgl = tgl.split("-")
		if(split_tgl.length == 3){
			return split_tgl[2]+'-'+split_tgl[1]+'-'+split_tgl[0]
		} else {
			return "Unknown"
		}
	} else if(type == 'date2'){
		var split_tgl = tgl.split("-")
		if(split_tgl.length == 3){
			return split_tgl[2]+' '+monthName(split_tgl[1])+' '+split_tgl[0]
		} else {
			return "Unknown"
		}
	} else if(type == 'date3'){
		var split_tgl = tgl.split(" ")
		if(split_tgl.length == 2){
			var split_tgl1 = split_tgl[0].split("-")
			if(split_tgl1.length == 3){
				return split_tgl1[0]+' '+monthName(split_tgl1[1])+' '+split_tgl1[2]+' '+split_tgl[1]
			} else {
				return "Unknown"
			}
		} else {
			return "Unknown"
		}
	} else if(type == 'date4'){
		var split_tgl = tgl.split("-")
		if(split_tgl.length == 3){
			return split_tgl[2]+' '+monthNameS(split_tgl[1])+' '+split_tgl[0]
		} else {
			return "Unknown"
		}
	} else if(type == 'date5'){
		var waktu = "00:00"
		var split_datetime = tgl.split(" ")
		if(split_datetime.length == 2){

			var dt = split_datetime[0]
			var jam = split_datetime[1]

			var split_jam = jam.split(":")
			if(split_jam.length == 3){ 
				waktu = split_jam[0]+':'+split_jam[1]
			}else {
				return "Unknown1"
			}

			var split_tgl = dt.split("-")
			if(split_tgl.length == 3){
				return split_tgl[2]+' '+monthName(split_tgl[1])+' '+split_tgl[0]+' '+waktu
			} else {
				return "Unknown1"
			}
		} else {
			return "Unknown2"
		}
	} else if(type == 'date6'){
		var waktu = "00:00"
		var split_datetime = tgl.split(" ")
		if(split_datetime.length == 2){

			var dt = split_datetime[0]
			var jam = split_datetime[1]

			var split_jam = jam.split(":")
			if(split_jam.length == 3){ 
				waktu = split_jam[0]+':'+split_jam[1]
			}else {
				return "Unknown1"
			}

			var split_tgl = dt.split("-")
			if(split_tgl.length == 3){
				return split_tgl[2]+' '+monthNameS(split_tgl[1])+' '+split_tgl[0]+' '+waktu
			} else {
				return "Unknown1"
			}
		} else {
			return "Unknown2"
		}
	} else if(type == 'date8'){
		var split_tgl = tgl.split("T")
		if(split_tgl.length == 2){
			var split_tgl1 = split_tgl[0].split("-")
			if(split_tgl1.length == 3){
				return split_tgl1[2]+'-'+split_tgl1[1]+'-'+split_tgl1[0]
			} else {
				return "Unknown"
			}
		} else {
			return "Unknown"
		}
	} else if(type == 'date9'){
		var waktu = "00:00"
		var split_datetime = tgl.split(" ")
		if(split_datetime.length == 2){

			var dt = split_datetime[0]
			var jam = split_datetime[1]

			var split_jam = jam.split(":")
			if(split_jam.length == 3){ 
				waktu = split_jam[0]+':'+split_jam[1]
			}else {
				return "Unknown1"
			}

			var split_tgl = dt.split("-")
			if(split_tgl.length == 3){
				return split_tgl[0]+'-'+split_tgl[1]+'-'+split_tgl[2]+' '+waktu
			} else {
				return "Unknown1"
			}
		} else {
			return "Unknown2"
		}
	}
  else if(type == 'date10'){
    var split_tgl = tgl.split("T")
    if(split_tgl.length == 2){
      var split_tgl1 = split_tgl[0].split("-")
      if(split_tgl1.length == 3){
        var date10 =  split_tgl1[2]+'-'+split_tgl1[1]+'-'+split_tgl1[0]
      } else {
        return "Unknown"
      }
      var split_time = split_tgl[1].split(".")
      if(split_time.length == 2){
        var split_times = split_time[0].split(":")
        var time10 = split_times[0]+':'+split_times[1]
      } else {
        return "Unknown"
      }
    } 
    else {
      return "Unknown"
    }

    return date10+ ' ' +time10
  }
  else if(type == 'date11'){
    var split_tgl = tgl.split("-")
    if(split_tgl.length == 3){
        return split_tgl[0]+' '+monthName(split_tgl[1])+' '+split_tgl[2]
    } else {
        return "Unknown"
    }
}else if(type == 'date12'){
    var split_tgl_date = tgl.split(" ")
    if(split_tgl_date.length == 2){
       return fDate(split_tgl_date[0],'date11')
        
    } else {
        return "Unknown"
    }
}else if(type == 'date13'){
    var split_tgl_date = tgl.split(" ")
    if(split_tgl_date.length == 2){
        let split_tgl=split_tgl_date[0].split("-")
        if(split_tgl.length == 3){
            return split_tgl[2]+' '+monthName(split_tgl[1])+' '+split_tgl[0]
        } else {
            return "Unknown"
        }
        
    } else {
        return "Unknown"
    }
}else if(type == 'date14'){
    var split_tgl_date = tgl.split(" ")
    if(split_tgl_date.length == 2){
        let split_tgl=split_tgl_date[0].split("-")
        if(split_tgl.length == 3){
            return split_tgl[2]+'-'+split_tgl[1]+'-'+split_tgl[0]
        } else {
            return "Unknown"
        }
        
    } else {
        return "Unknown"
    }
}

  else {
    return 'Unknown'
  } 

}


function noNull(param) {
    //var result = param == null ? "-" : param
    let result=""
    if(param!==null && param !==undefined){
        result=param
    }else{
        result="-"
    }
    return result
}

//untuk input
function noZero(param) {
    let result=""
    if(param!==null && param !==undefined){
        result=param
    }else{
        result=""
    }
    return result
}

function csDate(dt) {
    if(dt!==''){
        var sDate = dt.split("-")
        var data = sDate[2] + "-" + sDate[1] + "-" + sDate[0]
        return data
    }else{
        return ""
    }
}

//split date for full
function sDateff(target) {
    if (target !== null) {
        var datas = target.split(" ")
        var data = datas[0]

        return csDate(data)
    } else {
        return "-"
    }
}

//split date for input
function sDatefin(target) {
    if (target !== null) {
        var datas = target.split(" ")
        var data = datas[0]

        var sDate = data.split("-")
        var dataDate = sDate[0] + "-" + sDate[1] + "-" + sDate[2]
        return dataDate
    } else {
        return "-"
    }
}

function loadStart(){
    //start
    $('#btn-simpan .indicator-label').css('display','none')
    $('#btn-simpan .indicator-progress').css('display','block')
}

function loadStop(){
    //finished
    $('#btn-simpan .indicator-label').css('display','block')
    $('#btn-simpan .indicator-progress').css('display','none')
}

// begin: dapatkan nilai adjustment
function getAdjustmentVal(className){
  var data = [];
  var classData = document.getElementsByClassName(className)
  $.each(classData,function(index, value){
    let classVal = document.getElementsByClassName(className)[index].value
    if(typeof classVal !== "undefined")
    data.push(document.getElementsByClassName(className)[index].value);
   });
   return data
}

function getAdjustmentData(data = []){
  var text_adjustment = ''
  if(data.length > 0){
    var comma = ','
    var commaDetail = ','
    var dataNode1 = getAdjustmentVal(data[0][1])
    var panjangNode1 = dataNode1.length - 1
    var panjangData = data.length - 1

    $.each(dataNode1,function(index, value){
      if(index == panjangNode1)
      comma = ''
      detil = ''
      $.each(data,function(index1, value1){
        if(index1 == panjangData)
        commaDetail = ''
        let nilai = getAdjustmentVal(value1[1])[index]
        detil += `"`+value1[0]+`" : "`+nilai+`"`+commaDetail
        commaDetail = ','
      })
      text_adjustment += `{
                              `+detil+`
                          }`+comma
    })
  }
  return JSON.parse('['+text_adjustment+']')
}


// end: dapatkan nilai adjustment

var handleErrorDetail = function(response) {
	let res = response.responseJSON
	let code = response.status

	if(code == 400) {
		//window.location.href = baseUrl+'permission';
        Swal.fire({
            title: "Oopss...",
            icon: "error",
            text: res.status.message,
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ok",
        })
	} else if(code == 403) {
		//window.location.href = baseUrl+'permission';
        Swal.fire({
            title: "Oopss...",
            icon: "error",
            text: res.status.message,
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ok",
        })
	} else if(code == 401) {
		if(localStorage.getItem("token")=='') {
			Swal.fire({
				title: "Oopss...",
				icon: "error",
				text: res.status.message,
				showCancelButton: false,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ok",
			}).then((result) => {
				if (result.value) {
                    localStorage.clear();
					window.location.href = baseUrl+'login';
                }
			});
		} else {
			Swal.fire({
				title: "Oopss...",
				icon: "error",
				text: "Silahkan login kembali",
				showCancelButton: false,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ok",
			}).then((result) => {
				if (result.value) {
					//window.location.href = baseUrl+url;
                    //location.reload()
                    logout()
                    
				}
			});
		}
	} else if(code== 422){
        let resOther = "";
        if(res.data.errors!==undefined){
            const entries = Object.entries(res.data.errors);
            
            for (const [name, errMsg] of entries) {
            resOther += `<br>. ${errMsg}`;
            }
        }else{
            const entries = Object.entries(res.data);
            
            for (const [name, errMsg] of entries) {
            resOther += `<br>. ${errMsg}`;
            }
        }
        Swal.fire(
            "Oopss...",
            res.status.message +
            `<div class="text-left text-muted p-2">` +
            resOther +
            `</div>`,
            "error"
        );
    }else {
		Swal.fire({
			title: "Oopss...",
			icon: "error",
			text: "Terjadi kesalahan koneksi",
			showCancelButton: false,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ok",
		}).then((result) => {
			if (result.value) {
				//window.location.href = baseUrl+url;
                location.reload()
			}
		});
	}
}

function getArrayBulan() {
  let namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
  return namabulan.split(" ");
}

function tanggalStandard(tg, type = 'default') {
  let val = `-`
  if(type == 'default') {
      let tgl = new Date(tg);
      let tanggal = (tgl.getDate() < 10 ? '0' : '') + tgl.getDate();
      let bulan = ((tgl.getMonth() + 1) < 10 ? '0' : '') + (tgl.getMonth() + 1); 
      let tahun = tgl.getFullYear();
      val = tanggal + "-" + bulan + "-" + tahun;
  } else if(type == 'full'){
      let tgl = new Date(tg);
      let namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
      namabulan = namabulan.split(" ")
      let tanggal = (tgl.getDate() < 10 ? '0' : '') + tgl.getDate();
      let bulan = tgl.getMonth();
      let tahun = tgl.getFullYear();
      let jam = tgl.getHours();
      let menit = tgl.getMinutes();
      val = tanggal + " " + namabulan[bulan]  + " " + tahun+ ' ' + jam+ ':' + menit;
  } else {
      let namabulan = getArrayBulan();
      let tgl = new Date(tg);
      let tanggal = (tgl.getDate() < 10 ? '0' : '') + tgl.getDate();
      let bulan = tgl.getMonth();
      let tahun = tgl.getFullYear();
      val = tanggal + " " + namabulan[bulan] + " " + tahun;
  }
  return val
}

function setMenuActive(name, sub = false) {
  $('#'+name).addClass('active')

  if(sub) {
    $('#'+name+'-parent').addClass('hover')
    $('#'+name+'-parent').addClass('show')
    $('#'+name+'-sub').addClass('show')
  }

}


function nameSlice(param){
    if(param!==null&&param!==""&&param!==undefined){
        let nameStr=param
        let nameSlice=nameStr.slice(0,9);
        return nameSlice+"..."
    }else{
        return "-"
    }
}

function uuidv4() {
return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
);
}