<section class="p-[10px] md:p-[50px] lg:p-[85px]">
    <div class="w-full">
        <div class="px-3 flex items-center gap-2 ">
            <img
                src="<?= base_url('/assets/icon/6.png') ?>"
                alt="penginapan icon"
                class="w-[40px] md:w-[50px]" />
            <p class="text-sm md:text-lg lg:text-xl font-poppins font-semibold">
                Penginapan Terbaik Buat Kamu
            </p>
        </div>
        <div class="w-full pt-5 pb-10 flex gap-x-4 overflow-x-auto ">
            <?php foreach ($data_penginapan as $item): ?>
                <a href="<?= base_url('penginapan/detail/' . $item->id) ?>" class="relative max-w-[290px] w-[290px] h-[350px] bg-white shrink-0">
                    <img src="<?= base_url('uploads/penginapan/') .  $item->thumbnail  ?>" alt="" class="w-full h-[70%] object-cover rounded-t-lg">
                    <div class="p-2 lg:p-3 bg-white rounded-b-lg">
                        <div class="flex items-center gap-2">
                            <img src="<?= base_url('assets/icon/discount.svg') ?>" alt="logo jempol" class="size-7">
                            <p class="text-xs lg:text-sm "><?= trim_words($item->nama, 4) ?></p>
                        </div>
                        <p class="mt-3 text-[10px] font-semibold "> <?= $item->nama_kategori ?> </p>
                        <p class="mt-3 text-[10px] text-gray-500">Mulai Dari</p>
                        <p class="text-base text-[#ff5d00] font-semibold"><?= tarif_hari_ini_display($item) ?></p>
                        <p class="text-[9px] text-gray-500">Harga Dapat Berubah Kapan Saja</p>
                    </div>
                    <div class="absolute top-[200px] md:top-[170px] lg:top-[200px] left-[5px] w-[90px] md:w-[130px] h-[20px] md:h-[30px] flex justify-between items-center gap-2 text-white bg-[#1856a4] rounded-sm">
                        <div class="w-[75%] px-1.5">
                            <h1 class="text-[7px] md:text-[10px] font-semibold"> <?= $item->kapasitas_min ?> - <?= $item->kapasitas_max  ?> orang </h1>
                        </div>
                        <div class="w-[25%] h-full flex justify-center items-center bg-[#fcd817]">
                            <img src="<?= base_url('assets/icon/users.png') ?>" alt="bed icon" class="size-3 md:size-5">
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="mt-4 lg:mt-10 w-full flex justify-center">
            <a href="<?= base_url('penginapan') ?>" class="px-3 lg:px-7 py-2 flex items-center gap-2 text-xs lg:text-base text-white font-semibold bg-[#ff5d00] border-b-2 border-r-2 border-black rounded-md">
                Lihat Semua Penginapan
                <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" viewBox="0 0 256 256" class="size-[15px] lg:size-[26px]">
                    <path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path>
                </svg>
            </a>
        </div>
    </div>

    <div class="mt-20 w-full">
        <div class="px-3 flex items-center gap-2 ">
            <img
                src="<?= base_url('/assets/icon/2.png') ?>"
                alt="wisata icon"
                class="w-[40px] md:w-[50px]" />
            <p class="text-sm md:text-lg lg:text-xl font-poppins font-semibold">
                Wisata Yang Seru Buat Liburan Kamu
            </p>
        </div>
        <div class="w-full pt-5 pb-10 flex gap-x-4 overflow-x-auto ">
            <?php foreach ($data_wisata as $item): ?>
                <a href="<?= base_url('wisata/detail/' . $item->id) ?>" class="max-w-[290px] w-[290px] h-[350px] bg-white shrink-0">
                    <img src="<?= base_url('uploads/wisata/') .  $item->thumbnail  ?>" alt="" class="w-full h-[70%] object-cover rounded-t-lg">
                    <div class="p-2 lg:p-3 bg-white rounded-b-lg">
                        <div class="flex items-center gap-2">
                            <img src="<?= base_url('assets/icon/discount.svg') ?>" alt="logo jempol" class="size-7">
                            <p class="text-xs lg:text-sm "><?= trim_words($item->nama, 3) ?></p>
                        </div>
                        <p class="mt-3 text-[10px] font-semibold "> <?= $item->nama_kategori ?> </p>
                        <p class="mt-3 text-[10px] text-gray-500">Mulai Dari</p>
                        <p class="text-base text-[#ff5d00] font-semibold"><?= tarif_hari_ini_display($item) ?></p>
                        <p class="text-[9px] text-gray-500">Harga Dapat Berubah Kapan Saja</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="mt-4 lg:mt-10 w-full flex justify-center">
            <a href="<?= base_url('wisata') ?>" class="px-3 lg:px-7 py-2 flex items-center gap-2 text-xs lg:text-base text-white font-semibold bg-[#1d3976] border-b-2 border-r-2 border-black rounded-md">
                Lihat Semua Wisata
                <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" viewBox="0 0 256 256" class="size-[15px] lg:size-[26px]">
                    <path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
<a href="https://wa.me/6287830270670" class="fixed flex flex-col items-center right-5 md:right-[50px] bottom-[50px]">
    <img src="<?= base_url('assets/icon/logo-wa.webp') ?>" alt="log wa" class="size-[40px] md:size-[90px]">
</a>