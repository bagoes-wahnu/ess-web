
<div class="aside-menu flex-column-fluid mt-5">
    <!--begin::Aside Menu-->
    <div class="hover-scroll-overlay-y" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
        <!--begin::Menu-->
        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
            
            {{-- <div id="xmn-master-parent" data-kt-menu-trigger="click" class="d-none menu-item menu-accordion mt-5">
                <span id="xmn-master" class="menu-link">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.083313 12.5V16.25C0.083313 18.3213 4.00082 20 8.83333 20C13.6658 20 17.5834 18.3213 17.5834 16.25V12.5C17.5834 14.5713 13.6658 16.25 8.83333 16.25C4.00082 16.25 0.083313 14.5713 0.083313 12.5Z" fill="#888C9F"/>
                        <path d="M0.083313 6.25V10C0.083313 12.0713 4.00082 13.75 8.83333 13.75C13.6658 13.75 17.5834 12.0713 17.5834 10V6.25C17.5834 8.32125 13.6658 10 8.83333 10C4.00082 10 0.083313 8.32125 0.083313 6.25Z" fill="#888C9F"/>
                        <path d="M17.5834 3.75001C17.5834 5.82126 13.6658 7.50002 8.83333 7.50002C4.00082 7.50002 0.083313 5.82126 0.083313 3.75001C0.083313 1.67875 4.00082 0 8.83333 0C13.6658 0 17.5834 1.67875 17.5834 3.75001Z" fill="#888C9F"/>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Data Master</span>
                    <span class="menu-arrow"></span>
                </span>

                <div id="xmn-master-sub" class="menu-sub menu-sub-accordion menu-active-bg">
                    <div class="menu-item">
                        <a id="xmn-master-dinas" class="menu-link" href="{{ asset('master/dinas') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Master Dinas</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a id="xmn-master-berkas" class="menu-link" href="{{ asset('master/berkas') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Master Berkas</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a id="xmn-master-hari-libur" class="menu-link" href="{{ asset('master/hari-libur') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Master Hari Libur</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a id="xmn-master-user" class="menu-link" href="{{ asset('master/user') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Master User</span>
                        </a>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="menu-item">
                <div class="menu-content pt-8 pb-2">
                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Menu Utama</span>
                </div>
            </div> --}}
            
            <div class="menu-item" id="">
                <a id="mn-home" class="menu-link" href="{{asset('home')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.957117 5.41511L8.47857 0.818669C8.79868 0.623045 9.20136 0.623045 9.52147 0.818669L17.0429 5.41511C17.6374 5.77842 18 6.42494 18 7.12167V16.0001C18 17.1046 17.1046 18.0001 16 18.0001L2 18.0001C0.89543 18.0001 0 17.1046 0 16.0001L1.66893e-05 7.12167C1.77593e-05 6.42494 0.362608 5.77842 0.957117 5.41511ZM7.00002 10C6.44773 10 6.00002 10.4477 6.00002 11V14C6.00002 14.5523 6.44773 15 7.00002 15H11C11.5523 15 12 14.5523 12 14V11C12 10.4477 11.5523 10 11 10H7.00002Z" fill="#A2A7C3"/>
                        </svg>

                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Home</span>
                </a>
            </div>
            <div id="mn-master-parent" data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link" id="mn-master">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#A2A7C3" fill-rule="nonzero"/>
                                <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#A2A7C3" opacity="0.3"/>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Data Master</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('instansi') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-instansi">Instansi</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('struktur-jabatan') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-jabatan">Struktur Jabatan</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('divisi') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-divisi">Divisi</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('indikator-kpi') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-indikator-kpi">Indikator KPI</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('indikator-perilaku') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-indikator-perilaku">Indikator Perilaku Penilaian</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('parameter-nilai') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-parameter-nilai">Parameter Nilai</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('tahun') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-tahun">Tahun</span>
                        </a>
                    </div>
                </div>
            </div>
            {{--<div class="menu-item" id="">
                <a id="mn-struktur-jabatan" class="menu-link" href="{{asset('struktur-jabatan')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M7 11.4649V17C7 18.1046 7.89543 19 9 19H15V21H9C6.79086 21 5 19.2091 5 17V8V7H7V8C7 9.10457 7.89543 10 9 10H15V12H9C8.27143 12 7.58835 11.8052 7 11.4649Z" fill="#A2A7C3"/>
                        <path d="M6.00006 7C7.10463 7 8.00006 6.10457 8.00006 5C8.00006 3.89543 7.10463 3 6.00006 3C4.89549 3 4.00006 3.89543 4.00006 5C4.00006 6.10457 4.89549 7 6.00006 7ZM6.00006 9C3.79092 9 2.00006 7.20914 2.00006 5C2.00006 2.79086 3.79092 1 6.00006 1C8.2092 1 10.0001 2.79086 10.0001 5C10.0001 7.20914 8.2092 9 6.00006 9Z" fill="#A2A7C3"/>
                        <path d="M18 22C19.1046 22 20 21.1046 20 20C20 18.8954 19.1046 18 18 18C16.8954 18 16 18.8954 16 20C16 21.1046 16.8954 22 18 22ZM18 24C15.7909 24 14 22.2091 14 20C14 17.7909 15.7909 16 18 16C20.2091 16 22 17.7909 22 20C22 22.2091 20.2091 24 18 24Z" fill="#A2A7C3"/>
                        <path d="M18 13C19.1046 13 20 12.1046 20 11C20 9.89543 19.1046 9 18 9C16.8954 9 16 9.89543 16 11C16 12.1046 16.8954 13 18 13ZM18 15C15.7909 15 14 13.2091 14 11C14 8.79086 15.7909 7 18 7C20.2091 7 22 8.79086 22 11C22 13.2091 20.2091 15 18 15Z" fill="#A2A7C3"/>
                        </svg>


                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Struktur Jabatan</span>
                </a>
            </div>--}}
            <div class="menu-item" id="">
                <a id="mn-lokasi-kantor" class="menu-link" href="{{asset('lokasi-kantor')}}">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M5,10.5 C5,6 8,3 12.5,3 C17,3 20,6.75 20,10.5 C20,12.8325623 17.8236613,16.03566 13.470984,20.1092932 C12.9154018,20.6292577 12.0585054,20.6508331 11.4774555,20.1594925 C7.15915182,16.5078313 5,13.2880005 5,10.5 Z M12.5,12 C13.8807119,12 15,10.8807119 15,9.5 C15,8.11928813 13.8807119,7 12.5,7 C11.1192881,7 10,8.11928813 10,9.5 C10,10.8807119 11.1192881,12 12.5,12 Z" fill="#A2A7C3" fill-rule="nonzero"/>
                            </g>
                        </svg><!--end::Svg Icon--></span>
                    </span>
                    <span class="menu-title">Lokasi Kantor</span>
                </a>
            </div>
            <div class="menu-item" id="">
                <a id="mn-pengajuan-cuti" class="menu-link" href="{{asset('pengajuan-cuti')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M5.85714 2H13.7364C14.0911 2 14.4343 2.12568 14.7051 2.35474L19.4687 6.38394C19.8057 6.66895 20 7.08788 20 7.5292V20.0833C20 21.8739 19.9796 22 18.1429 22H5.85714C4.02045 22 4 21.8739 4 20.0833V3.91667C4 2.12612 4.02045 2 5.85714 2Z" fill="#A2A7C3"/>
                        <path d="M14 12H10C9.44772 12 9 12.4477 9 13C9 13.5523 9.44772 14 10 14H14C14.5523 14 15 13.5523 15 13C15 12.4477 14.5523 12 14 12Z" fill="#A2A7C3"/>
                        </svg>


                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Pengajuan Cuti</span>
                </a>
            </div>
            <div class="menu-item" id="">
                <a id="mn-permohonan-izin" class="menu-link" href="{{asset('permohonan-izin')}}">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#A2A7C3" fill-rule="nonzero" opacity="0.3"/>
                                <rect fill="#A2A7C3" x="6" y="11" width="9" height="2" rx="1"/>
                                <rect fill="#A2A7C3" x="6" y="15" width="5" height="2" rx="1"/>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-title">Permohonan Izin</span>
                </a>
            </div>
            <div class="menu-item" id="">
                <a id="mn-berita" class="menu-link" href="{{asset('berita')}}">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <rect fill="#A2A7C3" x="4" y="5" width="16" height="3" rx="1.5"/>
                                <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L12.5,10 C13.3284271,10 14,10.6715729 14,11.5 C14,12.3284271 13.3284271,13 12.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#A2A7C3" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-title">Berita</span>
                </a>
            </div>
            <div class="menu-item" id="">
                <a id="mn-karyawan" class="menu-link" href="{{asset('karyawan')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="#A2A7C3"/>
                        <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="#A2A7C3"/>
                        </svg>


                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Karyawan</span>
                </a>
            </div>
            {{--<div class="menu-item" id="">
                <a id="mn-instansi" class="menu-link" href="{{asset('instansi')}}">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#A2A7C3" fill-rule="nonzero"/>
                                <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#A2A7C3" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-title">Master Instansi</span>
                </a>
            </div>--}}
            <div id="mn-indikator-parent" data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link" id="mn-indikator">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <rect fill="#A2A7C3" opacity="0.3" x="7" y="4" width="10" height="4"/>
                                <path d="M7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,20 C19,21.1045695 18.1045695,22 17,22 L7,22 C5.8954305,22 5,21.1045695 5,20 L5,4 C5,2.8954305 5.8954305,2 7,2 Z M8,12 C8.55228475,12 9,11.5522847 9,11 C9,10.4477153 8.55228475,10 8,10 C7.44771525,10 7,10.4477153 7,11 C7,11.5522847 7.44771525,12 8,12 Z M8,16 C8.55228475,16 9,15.5522847 9,15 C9,14.4477153 8.55228475,14 8,14 C7.44771525,14 7,14.4477153 7,15 C7,15.5522847 7.44771525,16 8,16 Z M12,12 C12.5522847,12 13,11.5522847 13,11 C13,10.4477153 12.5522847,10 12,10 C11.4477153,10 11,10.4477153 11,11 C11,11.5522847 11.4477153,12 12,12 Z M12,16 C12.5522847,16 13,15.5522847 13,15 C13,14.4477153 12.5522847,14 12,14 C11.4477153,14 11,14.4477153 11,15 C11,15.5522847 11.4477153,16 12,16 Z M16,12 C16.5522847,12 17,11.5522847 17,11 C17,10.4477153 16.5522847,10 16,10 C15.4477153,10 15,10.4477153 15,11 C15,11.5522847 15.4477153,12 16,12 Z M16,16 C16.5522847,16 17,15.5522847 17,15 C17,14.4477153 16.5522847,14 16,14 C15.4477153,14 15,14.4477153 15,15 C15,15.5522847 15.4477153,16 16,16 Z M16,20 C16.5522847,20 17,19.5522847 17,19 C17,18.4477153 16.5522847,18 16,18 C15.4477153,18 15,18.4477153 15,19 C15,19.5522847 15.4477153,20 16,20 Z M8,18 C7.44771525,18 7,18.4477153 7,19 C7,19.5522847 7.44771525,20 8,20 L12,20 C12.5522847,20 13,19.5522847 13,19 C13,18.4477153 12.5522847,18 12,18 L8,18 Z M7,4 L7,8 L17,8 L17,4 L7,4 Z" fill="#A2A7C3"/>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Indikator Kerja</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('skk') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-skk">SKK</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('iku') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-iku">IKU</span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="mn-setting-parent" data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link" id="mn-setting">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#A2A7C3"/>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Settings</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('setting-skor') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-setting-skor">Setting Skor</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('setting-kpi') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-setting-kpi">Setting KPI</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('setting-indikator-perilaku') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-setting-indikator-perilaku">Setting Indikator Perilaku</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('setting-izin') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-setting-izin">Setting Izin</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ asset('setting-target-poin') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" id="dd-target-poin">Setting Target Poin Tahunan</span>
                        </a>
                    </div>
                </div>
            </div>
            {{--<div class="menu-item" id="">
                <a id="mn-setting-izin" class="menu-link" href="{{asset('setting-izin')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M7.07745 12.304C7.72445 13.0716 8.54045 13.692 9.46809 14.108L5 23L4.5 18L7.07745 12.304ZM14.5866 14.2598C15.532 13.9019 16.3754 13.3366 17.0614 12.6194L19.5 18L19 23L14.5866 14.2598ZM12 0C12.8284 0 13.5 0.671573 13.5 1.5V4H10.5V1.5C10.5 0.671573 11.1716 0 12 0Z" fill="#A2A7C3"/>
                        <path d="M12 10C13.1046 10 14 9.10457 14 8C14 6.89543 13.1046 6 12 6C10.8954 6 10 6.89543 10 8C10 9.10457 10.8954 10 12 10ZM12 13C9.23858 13 7 10.7614 7 8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8C17 10.7614 14.7614 13 12 13Z" fill="#A2A7C3"/>
                        </svg>



                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Setting Izin</span>
                </a>
            </div>
            <div class="menu-item" id="">
                <a id="mn-target-poin" class="menu-link" href="{{asset('setting-target-poin')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9497 0.807616L10.0246 3.73275C9.24356 4.5138 9.24356 5.78013 10.0246 6.56118L11.4388 7.97539C12.2199 8.75644 13.4862 8.75644 14.2672 7.97539L17.1924 5.05026C17.7341 7.04479 17.2296 9.25569 15.6746 10.8107C13.8453 12.64 11.1086 13.0155 8.88399 11.9444L3.75735 17.0711C2.9763 17.8521 1.70997 17.8521 0.928926 17.0711C0.147878 16.29 0.147878 15.0237 0.928926 14.2426L6.05556 9.11601C4.98446 6.89145 5.36004 4.15467 7.18927 2.32545C8.74431 0.77041 10.9552 0.265894 12.9497 0.807616Z" fill="#A2A7C3"/>
                        </svg>


                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Setting Target Poin Tahunan</span>
                </a>
            </div>--}}
             <div class="menu-item" id="">
                <a id="mn-poin-karyawan" class="menu-link" href="{{asset('poin-karyawan')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12C15 13.6569 13.6569 15 12 15Z" fill="#A2A7C3"/>
                        <path opacity="0.3" d="M19.5 10.5H21C21.8284 10.5 22.5 11.1716 22.5 12C22.5 12.8284 21.8284 13.5 21 13.5H19.5C18.6716 13.5 18 12.8284 18 12C18 11.1716 18.6716 10.5 19.5 10.5ZM16.0607 5.87132L17.1213 4.81066C17.7071 4.22487 18.6569 4.22487 19.2426 4.81066C19.8284 5.39645 19.8284 6.34619 19.2426 6.93198L18.182 7.99264C17.5962 8.57843 16.6464 8.57843 16.0607 7.99264C15.4749 7.40685 15.4749 6.45711 16.0607 5.87132ZM16.0607 18.182C15.4749 17.5962 15.4749 16.6464 16.0607 16.0607C16.6464 15.4749 17.5962 15.4749 18.182 16.0607L19.2426 17.1213C19.8284 17.7071 19.8284 18.6569 19.2426 19.2426C18.6569 19.8284 17.7071 19.8284 17.1213 19.2426L16.0607 18.182ZM3 10.5H4.5C5.32843 10.5 6 11.1716 6 12C6 12.8284 5.32843 13.5 4.5 13.5H3C2.17157 13.5 1.5 12.8284 1.5 12C1.5 11.1716 2.17157 10.5 3 10.5ZM12 1.5C12.8284 1.5 13.5 2.17157 13.5 3V4.5C13.5 5.32843 12.8284 6 12 6C11.1716 6 10.5 5.32843 10.5 4.5V3C10.5 2.17157 11.1716 1.5 12 1.5ZM12 18C12.8284 18 13.5 18.6716 13.5 19.5V21C13.5 21.8284 12.8284 22.5 12 22.5C11.1716 22.5 10.5 21.8284 10.5 21V19.5C10.5 18.6716 11.1716 18 12 18ZM4.81066 4.81066C5.39645 4.22487 6.34619 4.22487 6.93198 4.81066L7.99264 5.87132C8.57843 6.45711 8.57843 7.40685 7.99264 7.99264C7.40685 8.57843 6.45711 8.57843 5.87132 7.99264L4.81066 6.93198C4.22487 6.34619 4.22487 5.39645 4.81066 4.81066ZM4.81066 19.2426C4.22487 18.6569 4.22487 17.7071 4.81066 17.1213L5.87132 16.0607C6.45711 15.4749 7.40685 15.4749 7.99264 16.0607C8.57843 16.6464 8.57843 17.5962 7.99264 18.182L6.93198 19.2426C6.34619 19.8284 5.39645 19.8284 4.81066 19.2426Z" fill="#A2A7C3"/>
                        </svg>


                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Poin Karyawan</span>
                </a>
            </div>
             <div class="menu-item" id="">
                <a id="mn-cetak" class="menu-link" href="{{asset('cetak')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                        
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 17V21C16 21.5523 15.5523 22 15 22H9C8.44772 22 8 21.5523 8 21V17H5C3.89543 17 3 16.1046 3 15V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V15C21 16.1046 20.1046 17 19 17H16ZM17.5 11C18.3284 11 19 10.3284 19 9.5C19 8.67157 18.3284 8 17.5 8C16.6716 8 16 8.67157 16 9.5C16 10.3284 16.6716 11 17.5 11ZM10 14V20H14V14H10Z" fill="#A2A7C3"/>
                        <path opacity="0.3" d="M15 2H9C8.44772 2 8 2.44772 8 3C8 3.55228 8.44772 4 9 4H15C15.5523 4 16 3.55228 16 3C16 2.44772 15.5523 2 15 2Z" fill="#A2A7C3"/>
                        </svg>


                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Cetak</span>
                </a>
            </div>
            
        </div>
        <!--end::Menu-->
    </div>
</div>