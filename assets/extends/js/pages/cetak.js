let dateFilter=""
let yearLimit=""

jQuery(document).ready(function($) {
    sDivisi()
    $('#mn-cetak').addClass('active')
    $('a#mn-cetak .menu-icon').addClass('svg-icon svg-icon-2x svg-icon-primary')
    $('a#mn-cetak .menu-title').addClass('text-primary font-weight-bolder').removeClass('menu-title')
});	

$('#tanggal-awal,#tanggal-akhir,#tanggal-awal1,#tanggal-akhir1').datepicker({
    rtl: KTUtil.isRTL(),
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    orientation: "bottom left",
    autoclose: true
});

var bulanDT=$('#bulan-awal, #bulan-akhir').datepicker({
    rtl: KTUtil.isRTL(),
    format: "MM",
    viewMode: "months", 
    minViewMode: "months",
    autoclose: true,
})

$('#tahun').datepicker({
    rtl: KTUtil.isRTL(),
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose: true
}).on("change", function() {
    yearLimit=$(this).val()
    
    //bulanDT.datepicker(option, date);
});

function openFiles(param){
    let linkDownload=""
    if(param=="1"){
        linkDownload=urlApi+"report/report_presence?start_date="+csDate($('#tanggal-awal').val())+"&end_date="+csDate($('#tanggal-akhir').val())+"&token="+localStorage.getItem("token")
    }else if(param=="2"){
        linkDownload=urlApi+"report/report_overtime?start_date="+csDate($('#tanggal-awal').val())+"&end_date="+csDate($('#tanggal-akhir').val())+"&token="+localStorage.getItem("token")
    }else if(param=="3"){
        linkDownload=urlApi+"report/report_point?division_id="+noZero($('#divisi').val())+"&year="+noZero($('#tahun').val())+"&start_month="+getMonth($('#bulan-awal').val())+"&end_month="+getMonth($('#bulan-akhir').val())+"&token="+localStorage.getItem("token")
    }

    var link = document.createElement('a');
    // Add the element to the DOM
    console.log(linkDownload)
    link.setAttribute("type", "hidden"); // make it hidden if needed
    link.download = '';
    link.href = linkDownload;
    document.body.appendChild(link);
    link.click();
    link.remove();
}

function getMonth(date){
    console.log(date)
    if (date == "January") return "1";
    else if (date == "February") return "2";
    else if (date == "March") return "3";
    else if (date == "April") return "4";
    else if (date == "May") return "5";
    else if (date == "June") return "6";
    else if (date == "July") return "7";
    else if (date == "August") return "8";
    else if (date == "September") return "9";
    else if (date == "October") return "10";
    else if (date == "November") return "11";
    else if (date == "December") return "12";
    else return "";
}

function sDivisi() {
    $("#divisi").select2({
        allowClear: true,
        placeholder: "Pilih Divisi",
        ajax: {
            url: urlApi + "select_list/divisi",
            dataType: "json",
            type: "GET",
            quietMillis: 50,
            headers: {
                "Authorization" : "Bearer "+localStorage.getItem('token'),
            },
            
            data: function (term) {
            return {
                search:term.term,
            };
            },
            processResults: function (data) {
            return {
                results: $.map(data.data.division, function (item) {
                return {
                    text: item.division_name,
                    id: item.division_id,
                };
                }),
            };
            },
        },
        });
    }