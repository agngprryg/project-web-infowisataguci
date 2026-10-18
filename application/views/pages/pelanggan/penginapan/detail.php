<section class="relative">
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
    </style>


    <div class="p-[10px] md:p-[50px] lg:px-[200px] lg:py-[40px]">
        <div class="">
            <h2 class="text-[9px] md:text-xs opacity-70">
                <a href="<?= base_url('penginapan') ?>" class="text-blue-600">Penginapan</a> /
                <span class="font-bold"><?= $penginapan->nama ?></span>
            </h2>
        </div>

        <div class="mt-2">
            <h1 class="text-sm md:text-2xl font-semibold"><?= $penginapan->nama ?></h1>
        </div>

        <div class="w-full flex flex-col items-center mt-5 lg:mt-8">
            <!-- Main Carousel -->
            <div class="md:w-[1000px] md:h-[550px] relative overflow-hidden rounded-xl border border-black">
                <div id="mainCarousel" class="flex transition-transform duration-500">
                    <?php foreach ($penginapan_gambar as $index => $img): ?>
                        <img
                            src="<?= base_url('uploads/penginapan/' . $img->gambar) ?>"
                            alt="<?= $img->gambar ?> <?= $index + 1 ?>"
                            class="w-full flex-shrink-0 object-contain h-full" />
                    <?php endforeach; ?>
                </div>

                <!-- Prev Button -->
                <button id="prevBtn"
                    class="absolute left-3 top-1/2 -translate-y-1/2 bg-[#2863e8] text-white p-1 rounded-full shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256">
                        <path d="M165.66,202.34a8,8,0,0,1-11.32,11.32l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L91.31,128Z"></path>
                    </svg>
                </button>

                <!-- Next Button -->
                <button id="nextBtn"
                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-[#2863e8] text-white p-1 rounded-full shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256">
                        <path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path>
                    </svg>
                </button>
            </div>

            <!-- Dots -->
            <div id="dots" class="flex justify-center mt-3 space-x-2">
                <!-- Generated via JS -->
            </div>

            <!-- Thumbnail List -->
            <div class="flex gap-3 overflow-x-auto mt-4 pb-2 no-scrollbar">
                <?php foreach ($penginapan_gambar as $index => $img): ?>
                    <img
                        data-index="<?= $index ?>"
                        src="<?= base_url('uploads/penginapan/' . $img->gambar) ?>"
                        alt="<?= $img->gambar ?> <?= $index + 1 ?>"
                        class="h-20 w-28 object-cover rounded-lg cursor-pointer opacity-100 border-2 border-blue-500" />
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mt-[20px] mb-[150px]">
            <h1 class="text-sm md:text-2xl font-semibold">Informasi Umum</h1>
            <p class="mt-1 text-[10px] md:text-base opacity-80">
                <?= nl2br($penginapan->deskripsi) ?>
            </p>
        </div>
    </div>

    <div class="fixed bottom-0 w-full">
        <div class=" w-full py-2 px-5 flex items-center gap-2 bg-gradient-to-r from-[#164e9d] to-[#3986e1] rounded-t-xl">
            <img src="<?= base_url('assets/icon/jempol.webp') ?>" alt="jempol icon" class="size-3 md:size-5">
            <p class="text-[9px] md:text-xs text-white"><span class="text-[#ffde00]">Jempolan</span> buat kamu !</p>
        </div>

        <div class="w-full p-2 flex justify-between items-center bg-white">
            <div>
                <h1 class="text-[9px] md:text-base">Mulai Dari</h1>
                <p class="mt-1 text-[12px] md:text-sm text-[#ff5e21] font-semibold"> <?= format_rupiah($penginapan->harga) ?> </p>
                <p class="text-[7px] md:text-[11px] text-gray-500">Harga dapat berubah kapan saja.</p>
            </div>
            <a href="https://wa.me/6287830270670?text=Halo%20saya%20ingin%20booking%20penginapan%20di%20<?= $penginapan->nama ?>" class="px-2 md:px-4 py-1.5 md:py-2.5 text-[9px] md:text-sm text-white bg-[#ff5e21] rounded-md">Pesan Kamar</a>
        </div>

    </div>
</section>

<script>
    const mainCarousel = document.getElementById("mainCarousel");
    const dotsContainer = document.getElementById("dots");
    const thumbs = document.querySelectorAll("[data-index]");
    const totalSlides = mainCarousel.children.length;

    let index = 0;

    function updateCarousel() {
        mainCarousel.style.transform = `translateX(-${index * 100}%)`;

        // Update thumbnails
        thumbs.forEach((el) => {
            el.classList.remove("opacity-100", "border-blue-500", "border-2");
            el.classList.add("opacity-60");
        });

        thumbs[index].classList.add("opacity-100", "border-blue-500", "border-2");
        thumbs[index].classList.remove("opacity-60");

        // Update dots
        document.querySelectorAll(".dot").forEach((dot, i) => {
            dot.classList.toggle("bg-blue-600", i === index);
            dot.classList.toggle("bg-gray-300", i !== index);
        });
    }

    // Prev & Next
    document.getElementById("nextBtn").addEventListener("click", () => {
        index = (index + 1) % totalSlides;
        updateCarousel();
    });

    document.getElementById("prevBtn").addEventListener("click", () => {
        index = (index - 1 + totalSlides) % totalSlides;
        updateCarousel();
    });

    // Thumbnails click
    thumbs.forEach((thumb) => {
        thumb.addEventListener("click", () => {
            index = parseInt(thumb.dataset.index);
            updateCarousel();
        });
    });

    // Generate dots
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement("div");
        dot.className = "dot w-1.5 h-1.5 rounded-full bg-gray-300 cursor-pointer";
        dot.addEventListener("click", () => {
            index = i;
            updateCarousel();
        });
        dotsContainer.appendChild(dot);
    }

    updateCarousel();
</script>