<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Preview</title>
<style>
      
.myButton {
    -moz-box-shadow: -7px -1px 15px -10px #8a8a8a;
    -webkit-box-shadow: -7px -1px 15px -10px #8a8a8a;
    box-shadow: -7px -1px 15px -10px #8a8a8a;
    background-color:#ffffff;
    -webkit-border-radius:42px;
    -moz-border-radius:42px;
    border-radius:42px;
    display:inline-block;
    cursor:pointer;
    color:#575757;
    font-family:Arial;
    font-size:15px;
    padding:16px 36px;
    text-decoration:none;
    transition: 0.4s;
}
.myButton:hover {
    background-color:#e3e3e3;
    /*font-weight: bold;*/
}
.myButton:active {
    position:relative;
    top:1px;
}
</style> 

</head>

<body style="background-color: #e3e3e3">

    <div style="margin-left: 50px; margin-top: 20px; display: inline; float: left;" >
        <a href="#" class="myButton"><span><img src="{{asset('assets/extends/img/arrow-left.png')}}" style="width:17px; margin-right: 10px;" alt=""> </span> Kembali</a>
    </div>
    <div style="margin-right: 50px; margin-top: 20px; display: inline; float: right;" >
        <a href="#" class="myButton">Cetak <span><img src="{{asset('assets/extends/img/arrow-right.png')}}" style="width:17px; margin-left: 10px;" alt=""> </span></a>
    </div>


    <div style="display: flex; justify-content: center !important; margin-top: 40px;">
        <h3>Preview SK E-Dupak</h3>    
    </div>
    

 <div style="display: flex; justify-content: center !important; margin-top: 30px; margin-bottom: 140px;" >

     @yield('file')
 </div>   
<br><br><br><br><br><br>


</body>
</html>