<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MijnPooltochten.nl') }}</title>
    <link rel="icon" type="image/x-icon" href="public/favicon.ico">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Fonts -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--<script src="https://cdn.tailwindcss.com"></script> -->
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Leaflet JS  --  versie hier onder verwijderd ivm 1.9 -->
    <!--<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    
    <!-- swiper -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <!-- Voeg Leaflet JavaScript toe -->
    <!--<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-QVJ+ldh0AqBLxpMRyoZk3IAy0t4DoXUu8k3BBSJiEYk=" crossorigin=""></script>-->

    <!-- Styles --><!-- Leaflet CSS -->

    <!-- Deze hier onder verwijderd, ivm versie 1.9 -->
    <!--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />-->
    <!-- Styles -->
    
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
    
        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
  
    



    @vite(['resources/css/app.css'])

    @livewireStyles
</head>

<body class="">
    <div class="w-[817px] h-[1104px] bg-white rounded-[28px] flex-col justify-start items-center inline-flex">
    <div class="self-stretch h-[164px] pb-7 bg-[#fef7ff] flex-col justify-start items-start gap-10 flex">
      <div class="self-stretch px-3 pt-2 justify-between items-start inline-flex">
        <div class="w-12 h-12 flex-col justify-center items-center gap-2.5 inline-flex">
          <div class="rounded-[100px] justify-center items-center gap-2.5 inline-flex">
            <div class="p-2 justify-center items-center gap-2.5 flex">
              <div class="w-6 h-6 p-0.5 justify-center items-center flex"></div>
            </div>
          </div>
        </div>
        <div class="justify-end items-center flex">
          <div class="w-12 h-12 flex-col justify-center items-center gap-2.5 inline-flex">
            <div class="rounded-[100px] justify-center items-center gap-2.5 inline-flex">
              <div class="p-2 justify-center items-center gap-2.5 flex">
                <div class="w-6 h-6 px-1 py-0.5 justify-center items-center flex"></div>
              </div>
            </div>
          </div>
          <div class="w-12 h-12 flex-col justify-center items-center gap-2.5 inline-flex">
            <div class="rounded-[100px] justify-center items-center gap-2.5 inline-flex">
              <div class="p-2 justify-center items-center gap-2.5 flex">
                <div class="w-6 h-6 px-[1.95px] py-0.5 justify-center items-center flex"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="self-stretch px-6 justify-start items-start gap-2.5 inline-flex">
        <div class="text-[#1d1b20] text-[28px] font-normal font-['Roboto'] leading-9">Title</div>
      </div>
    </div>
    <div class="self-stretch h-[940px] rounded-[28px] flex-col justify-start items-start flex">
      <div class="self-stretch h-[188px] pb-4 flex-col justify-start items-start flex">
        <div class="self-stretch h-12 px-6 justify-start items-center inline-flex">
          <div class="text-[#1d1b20] text-[22px] font-normal font-['Roboto'] leading-7">Section title</div>
          <div class="w-12 h-12 flex-col justify-center items-center gap-2.5 inline-flex">
            <div class="rounded-[100px] justify-center items-center gap-2.5 inline-flex">
              <div class="p-2 justify-center items-center gap-2.5 flex">
                <div class="w-6 h-6 p-1 justify-center items-center flex"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="self-stretch pl-6 justify-start items-start gap-6 inline-flex">
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-center gap-2 inline-flex">
            <div class="w-24 h-24 rounded-full justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-full"></div>
            </div>
            <div class="self-stretch text-center text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
        </div>
      </div>
      <div class="self-stretch h-[317px] flex-col justify-start items-start flex">
        <div class="self-stretch h-12 px-6 justify-start items-center inline-flex">
          <div class="text-[#1d1b20] text-[22px] font-normal font-['Roboto'] leading-7">Section title</div>
          <div class="w-12 h-12 flex-col justify-center items-center gap-2.5 inline-flex">
            <div class="rounded-[100px] justify-center items-center gap-2.5 inline-flex">
              <div class="p-2 justify-center items-center gap-2.5 flex">
                <div class="w-6 h-6 p-1 justify-center items-center flex"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="self-stretch h-[221px] px-6 py-2 justify-start items-start gap-2 inline-flex">
          <div class="h-[205px] relative rounded-[28px]"></div>
          <div class="h-[205px] relative rounded-[28px]"></div>
          <div class="w-[120px] h-[205px] relative rounded-[28px]"></div>
          <div class="w-14 h-[205px] relative rounded-[28px]"></div>
        </div>
        <div class="self-stretch h-12 px-6 justify-start items-start gap-2 inline-flex">
          <div class="grow shrink basis-0 h-12 justify-start items-start flex">
            <div class="grow shrink basis-0 flex-col justify-start items-start inline-flex">
              <div class="self-stretch text-[#1d1b20] text-base font-normal font-['Roboto'] leading-normal tracking-wide">Artist</div>
              <div class="self-stretch text-[#49454f] text-sm font-normal font-['Roboto'] leading-tight tracking-tight">Title</div>
            </div>
            <div class="w-12 h-12 p-1 flex-col justify-center items-center gap-2.5 inline-flex">
              <div class="bg-[#e8def8] rounded-[100px] justify-center items-center gap-2.5 inline-flex">
                <div class="p-2 justify-center items-center gap-2.5 flex">
                  <div class="w-6 h-6 pl-2 pr-[5px] py-[5px] justify-center items-center flex"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="grow shrink basis-0 h-12 justify-start items-start flex">
            <div class="grow shrink basis-0 flex-col justify-start items-start inline-flex">
              <div class="self-stretch text-[#1d1b20] text-base font-normal font-['Roboto'] leading-normal tracking-wide">Artist</div>
              <div class="self-stretch text-[#49454f] text-sm font-normal font-['Roboto'] leading-tight tracking-tight">Title</div>
            </div>
            <div class="w-12 h-12 p-1 flex-col justify-center items-center gap-2.5 inline-flex">
              <div class="bg-[#e8def8] rounded-[100px] justify-center items-center gap-2.5 inline-flex">
                <div class="p-2 justify-center items-center gap-2.5 flex">
                  <div class="w-6 h-6 pl-2 pr-[5px] py-[5px] justify-center items-center flex"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-[120px] h-11 relative"></div>
          <div class="w-14 h-12 relative"></div>
        </div>
      </div>
      <div class="self-stretch h-[184px] flex-col justify-start items-start flex">
        <div class="self-stretch h-12 px-6 justify-start items-center inline-flex">
          <div class="text-[#1d1b20] text-[22px] font-normal font-['Roboto'] leading-7">Section title</div>
          <div class="w-12 h-12 flex-col justify-center items-center gap-2.5 inline-flex">
            <div class="rounded-[100px] justify-center items-center gap-2.5 inline-flex">
              <div class="p-2 justify-center items-center gap-2.5 flex">
                <div class="w-6 h-6 p-1 justify-center items-center flex"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="self-stretch px-6 py-2 justify-start items-start gap-6 inline-flex">
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
          <div class="flex-col justify-start items-start gap-1 inline-flex">
            <div class="w-24 h-24 rounded-2xl justify-center items-center inline-flex">
              <div class="w-24 h-24 relative rounded-lg"></div>
            </div>
            <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Label</div>
          </div>
        </div>
      </div>
      <div class="self-stretch h-[251px] pb-4 flex-col justify-start items-start flex">
        <div class="w-[833px] h-12 px-6 justify-start items-center inline-flex">
          <div class="text-[#1d1b20] text-[22px] font-normal font-['Roboto'] leading-7">Section title</div>
          <div class="w-12 h-12 flex-col justify-center items-center gap-2.5 inline-flex">
            <div class="rounded-[100px] justify-center items-center gap-2.5 inline-flex">
              <div class="p-2 justify-center items-center gap-2.5 flex">
                <div class="w-6 h-6 p-1 justify-center items-center flex"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="justify-end items-center inline-flex">
          <div class="self-stretch pl-6 pb-4 justify-start items-start gap-6 inline-flex">
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
            <div class="p-2 rounded-xl flex-col justify-start items-start gap-2 inline-flex">
              <div class="w-[132px] h-[180px] bg-[#ece6f0] rounded-xl flex-col justify-center items-center flex">
                <div class="w-[132px] h-[180px] p-2.5"></div>
              </div>
              <div class="w-[116px] h-[119px] relative rounded-lg"></div>
              <div class="self-stretch h-9 pr-2 flex-col justify-start items-start flex">
                <div class="self-stretch text-[#1d1b20] text-sm font-medium font-['Roboto'] leading-tight tracking-tight">Artist</div>
                <div class="self-stretch text-[#49454f] text-xs font-normal font-['Roboto'] leading-none tracking-wide">Song</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="w-[72px] h-[1999px] pt-11 pb-14 bg-[#fef7ff] flex-col justify-start items-center gap-10 inline-flex">
    <div class="h-[108px] flex-col justify-start items-center gap-1 flex">
      <div class="w-12 h-12 flex-col justify-center items-center gap-2.5 flex">
        <div class="rounded-[100px] justify-center items-center gap-2.5 inline-flex">
          <div class="p-2 justify-center items-center gap-2.5 flex">
            <div class="w-6 h-6 px-[3px] py-1.5 justify-center items-center flex"></div>
          </div>
        </div>
      </div>
      <div class="rounded-2xl justify-start items-start gap-2.5 inline-flex">
        <div class="bg-[#ffd8e4] rounded-2xl shadow justify-center items-center flex">
          <div class="p-4 justify-center items-center flex">
            <div class="w-6 h-6 p-[5px] justify-center items-center flex"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="h-[260px] flex-col justify-center items-center gap-3 flex">
      <div class="self-stretch h-14 px-0.5 pb-1 flex-col justify-start items-center gap-1 flex">
        <div class="bg-[#e8def8] rounded-[100px] justify-center items-center inline-flex">
          <div class="px-4 py-1 justify-center items-center flex">
            <div class="w-6 h-6 p-0.5 justify-center items-center flex"></div>
          </div>
        </div>
        <div class="self-stretch text-center text-[#1d1b20] text-xs font-semibold font-['Roboto'] leading-none tracking-wide">Label</div>
      </div>
      <div class="self-stretch h-14 px-0.5 pb-1 flex-col justify-start items-center gap-1 flex">
        <div class="rounded-[100px] flex-col justify-center items-center flex">
          <div class="px-4 py-1 justify-center items-center inline-flex">
            <div class="w-6 h-6 p-0.5 justify-center items-center flex"></div>
          </div>
        </div>
        <div class="self-stretch text-center text-[#49454f] text-xs font-medium font-['Roboto'] leading-none tracking-wide">Label</div>
      </div>
      <div class="self-stretch h-14 px-0.5 pb-1 flex-col justify-start items-center gap-1 flex">
        <div class="rounded-[100px] flex-col justify-center items-center flex">
          <div class="px-4 py-1 justify-center items-center inline-flex">
            <div class="w-6 h-6 p-0.5 justify-center items-center flex"></div>
          </div>
        </div>
        <div class="self-stretch text-center text-[#49454f] text-xs font-medium font-['Roboto'] leading-none tracking-wide">Label</div>
      </div>
      <div class="px-0.5 pb-1 flex-col justify-start items-center gap-1 flex">
        <div class="rounded-[100px] flex-col justify-center items-center flex">
          <div class="px-4 py-1 justify-center items-center inline-flex">
            <div class="w-6 h-6 p-0.5 justify-center items-center flex"></div>
          </div>
        </div>
        <div class="self-stretch text-center text-[#49454f] text-xs font-medium font-['Roboto'] leading-none tracking-wide">Label</div>
      </div>
    </div>
  </div>
  <div class="w-[905px] h-[68px] p-4 bg-[#fef7ff] shadow shadow-inner justify-start items-center gap-4 inline-flex">
    <div class="justify-start items-center gap-3 flex">
      <div class="w-6 h-6 p-1 justify-center items-center flex"></div>
      <div class="w-6 h-6 p-1 justify-center items-center flex"></div>
      <div class="w-6 h-6 px-1 py-1 justify-center items-center flex"></div>
    </div>
    <div class="grow shrink basis-0 h-9 px-4 py-1.5 bg-[#f3edf7] rounded-[46.08px] justify-between items-center flex">
      <div class="grow shrink basis-0 h-6 justify-start items-center gap-2 flex">
        <div class="w-[15.36px] h-[15.36px] px-[2.56px] pt-[0.64px] pb-[1.28px] justify-center items-center flex"></div>
        <div class="grow shrink basis-0 text-[#1d1b20] text-base font-normal font-['Roboto'] leading-normal tracking-wide">www.url.com</div>
      </div>
      <div class="w-5 h-5 px-[1.67px] pt-[1.67px] pb-[2.50px] justify-center items-center flex"></div>
    </div>
    <div class="pl-[7.18px] pr-[6.82px] pt-[2.82px] pb-[1.18px] bg-[#79747e] rounded-[109.09px] justify-center items-center flex">
      <div class="text-center text-white text-base font-normal font-['Roboto'] leading-normal tracking-wide">M</div>
    </div>
    <div class="w-6 h-6 py-1 justify-center items-center flex"></div>
  </div>
</body></html>