<section class="p-[10px] md:p-[40px] lg:py-[90px] overflow-hidden">
    <div class="mb-5 md:mb-10 flex items-center gap-2">
        <img src="<?= base_url('assets/icon/outbond.png') ?>" alt="outbond icon" class="size-[30px] md:size-[60px]">
        <h1 class="text-base md:text-xl font-semibold">Liburan kali ini mau kemana ?</h1>
    </div>
    <div class="w-full pb-20 grid grid-cols-2 md:grid-cols-3 lg:flex lg:flex-wrap gap-y-20 gap-x-2 md:gap-y-14 md:gap-x-5 justify-items-center">
        <?php foreach ($data_wisata as $item): ?>
            <a href="<?= base_url('wisata/detail/' . $item->id) ?>" class="relative md:max-w-[290px] md:max-h-[350px] w-[160px] md:w-[230px] lg:w-[280px] h-[180px] md:h-[300px] lg:h-[350px] rounded-md">
                <img src="<?= base_url('uploads/wisata/') .  $item->thumbnail  ?>" alt="" class="w-full h-[70%] object-cover rounded-t-lg">
                <div class="p-2 lg:p-3 bg-white rounded-b-lg">
                    <div class="flex items-end gap-2">
                        <img src="<?= base_url('assets/icon/best-seller.png') ?>" alt="logo jempol" class="size-5">
                        <p class="text-[9px] lg:text-sm "><?= trim_words($item->nama) ?></p>
                    </div>
                    <p class="md:mt-3 text-[10px] font-semibold "> <?= $item->nama_kategori ?> </p>
                    <p class="md:mt-3 text-[10px] text-gray-500">Mulai Dari</p>
                    <p class="text-xs md:text-base text-[#ff5d00] font-semibold"><?= format_rupiah($item->harga) ?></p>
                    <p class="text-[9px] text-gray-500">Harga Dapat Berubah Kapan Saja</p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<a href="https://wa.me/6287830270670" class="fixed flex flex-col items-center right-5 md:right-[50px] bottom-[50px]">
    <img src="<?= base_url('assets/icon/logo-wa.webp') ?>" alt="log wa" class="size-[40px] md:size-[90px]">
</a>