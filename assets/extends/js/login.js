jQuery(document).ready(function() {
    $('.input-login').keyup(function(event){
        event.preventDefault();
        if (event.keyCode === 13) {
            login()
        }
    })
});


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


function login(){
    //window.location.href = baseUrl+'home';
    $.ajax({
        url:urlApi+'auth/login',
        type:'POST',
        data:{
            username: $('#xa-username').val(), 
            password: $('#xa-password').val()
        },
        beforeSend:function(){
            loadStart()
        },
        success:function(response){
            console.log(response);
            let res = response.data
            localStorage.setItem("token", res.token.access_token);
            localStorage.setItem("userID", res.user.id);
            localStorage.setItem("userName", res.user.name);
            // localStorage.setItem("roleID", res.user.role.id);
            // localStorage.setItem("roleName", res.user.role.nama);
	        // localStorage.setItem("dinasID", ((res.user.dinas !== null) ? res.user.dinas.id : ""));
            
           window.location.href = baseUrl+'home';
        },
        error:function(msg, status, error){

            console.log(msg);

            
            loadStop()
            
            localStorage.setItem("token", '');
            Swal.fire('Oopss...', msg.responseJSON.status.message, "warning");
        }
    });
}

function logout() {
    $.ajax({
        url:urlApi+'auth/logout',
        type:'POST',
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization","Bearer " + localStorage.getItem("token"));
        },
        success:function(response){
            localStorage.clear();
            localStorage.setItem("token", "");
            window.location.href = baseUrl;
        },
        error:function(msg, status, error){
            localStorage.clear();
            localStorage.setItem("token", "");
            window.location.href = baseUrl;
        }
    });
}

function showPassword(){
    if(document.getElementById('xa-password').type == 'password') {
        document.getElementById('xa-password').type = 'text'
    } else {
        document.getElementById('xa-password').type = 'password'
    }
}

function openModalPassword() {
    clearUbahSandi()
    $('#modal-password').modal('show')
    $("#btn-eye1").click(function () {
        let status= $("#inp-eye1").attr("type") =="text"?"password":"text"
        let icondel= $("#inp-eye1").attr("type") =="text"?"la-eye":"la-eye-slash"
        let icons= $("#inp-eye1").attr("type") !=="text"?"la-eye":"la-eye-slash"
        $("#inp-eye1").attr("type",status)
        $("#i-eye1").addClass(icons)
        $("#i-eye1").removeClass(icondel)
    });
    $("#btn-eye2").click(function () {
       
        let status= $("#inp-eye2").attr("type") =="text"?"password":"text"
        let icondel= $("#inp-eye2").attr("type") =="text"?"la-eye":"la-eye-slash"
        let icons= $("#inp-eye2").attr("type") !=="text"?"la-eye":"la-eye-slash"
        $("#inp-eye2").attr("type",status)
        $("#i-eye2").addClass(icons)
        $("#i-eye2").removeClass(icondel)
    });
    $("#btn-eye3").click(function () {
        let status= $("#inp-eye3").attr("type") =="text"?"password":"text"
        let icondel= $("#inp-eye3").attr("type") =="text"?"la-eye":"la-eye-slash"
        let icons= $("#inp-eye3").attr("type") !=="text"?"la-eye":"la-eye-slash"
        $("#inp-eye3").attr("type",status)
        $("#i-eye3").addClass(icons)
        $("#i-eye3").removeClass(icondel)
    });
}

function simpanUbahSandi() {
    let newpass= $("#inp-eye2").val()
    // if(newpass.length < 8){
    //     $("#lbl-eye2").html("password baru harus lebih dari 8 digit")
    // }else if(newpass!==$("#inp-eye3").val()){
    //     Swal.fire("Oppss!", "password konfirmasi tidak sama dengan password baru", "warning")
    // }else{
    //ewpLoadingShow();
    var data = {
        old_password: $("#inp-eye1").val(),
        new_password: $("#inp-eye2").val(),
        new_password_confirmation: $("#inp-eye3").val(),
    };

    var tipe = "PUT";
    var link = urlApi + "auth/change-pass";

    $.ajax({
        type: tipe,
        dataType: "json",
        data: data,
        url: link,
        beforeSend: function (xhr) {
            loadStart('#btn-ubah-sandi')
            xhr.setRequestHeader("Authorization", "Bearer " + localStorage.getItem("token"));
        },
        success: function (response) {
            clearUbahSandi()
            loadStop('#btn-ubah-sandi')
            Swal.fire({
                title:"Berhasil",
                text:"Password berhasil diperbarui",
                icon:"success",
                confirmButtonText: "Oke",
                customClass: {
                    confirmButton: "btn btn-success",
                }
            })
            $('#modal-password').modal('hide')
        },
        error: function (xhr, ajaxOptions, thrownError) {
            clearUbahSandi()
            loadStop('#btn-ubah-sandi')
            Swal.fire('Oopss...', xhr.responseJSON.status.message, 'error');
        },
    });
    //}
}

function clearUbahSandi() {
    $('#inp-eye1').val('')
    $('#inp-eye2').val('')
    $('#inp-eye3').val('')
}

