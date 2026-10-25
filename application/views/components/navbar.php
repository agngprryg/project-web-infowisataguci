<nav class="absolute w-full mx-auto mt-2">
    <div class="px-5 lg:px-10 py-3 flex items-center justify-between">
        <a href="<?= base_url('/') ?>" class="w-[130px] md:w-[190px] ">
            <img src="<?= base_url('assets/logo/logo.png') ?>" alt="">
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-28">
            <div class="hidden md:hidden lg:flex gap-10 items-center text-white">
                <a href="<?= base_url('beranda') ?>" class="text-sm hover:scale-110 transition-all ease-in-out">
                    Beranda
                </a>
                <a href="<?= base_url('penginapan') ?>" class="text-sm hover:scale-110 transition-all ease-in-out">
                    Penginapan
                </a>
                <a href="<?= base_url('wisata') ?>" class="text-sm hover:scale-110 transition-all ease-in-out">
                    Wisata
                </a>
                <a href="<?= base_url('transportasi') ?>" class="text-sm hover:scale-110 transition-all ease-in-out">
                    Transportasi
                </a>

                <?php if ($this->session->userdata('role') == 'pelanggan'): ?>
                    <a href="<?= base_url('tiket-saya/' . $id_pelanggan) ?>" class="text-sm hover:scale-110 transition-all ease-in-out">
                        Tiket Saya
                    </a>
                <?php endif; ?>
            </div>

            <div>
                <?php if ($this->session->userdata('role') == 'pelanggan'): ?>
                    <div class="flex items-center gap-4">
                        <p class="text-xs text-white">Halo, <?= $this->session->userdata('nama_pelanggan'); ?>!</p>
                        <a href="<?= base_url('logout') ?>" class="px-3 py-1 text-xs text-white rounded-lg">logout</a>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="px-4 py-1 text-xs font-semibold rounded-lg text-white bg-[#002247]">Masuk</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Hamburger Button -->
        <div class="lg:hidden flex items-center">
            <button id="mobile-menu-button" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden lg:hidden bg-[#002247] bg-opacity-90 w-full absolute z-50 left-0 px-5 py-3">
        <div class="flex flex-col space-y-4 text-white">
            <a href="<?= base_url('beranda') ?>" class="text-sm py-2 border-b border-white border-opacity-20">
                Beranda
            </a>
            <a href="<?= base_url('penginapan') ?>" class="text-sm py-2 border-b border-white border-opacity-20">
                Penginapan
            </a>
            <a href="<?= base_url('wisata') ?>" class="text-sm py-2 border-b border-white border-opacity-20">
                Wisata
            </a>

            <?php if ($this->session->userdata('role') == 'pelanggan'): ?>
                <a href="<?= base_url('tiket-saya/' . $id_pelanggan) ?>" class="text-sm py-2 border-b border-white border-opacity-20">
                    Tiket Saya
                </a>
                <div class="flex items-center justify-between py-2 border-b border-white border-opacity-20">
                    <span class="text-sm">Halo, <?= $this->session->userdata('nama_pelanggan'); ?>!</span>
                    <a href="<?= base_url('logout') ?>" class="px-3 py-1 text-xs text-white rounded-lg bg-red-500">Logout</a>
                </div>
            <?php else: ?>
                <div class="flex space-x-2 py-2">
                    <a href="<?= base_url('login') ?>" class="flex-1 text-center px-4 py-2 text-xs font-semibold rounded-lg text-white border">Masuk</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="w-full h-full mt-10 lg:mt-20 flex flex-col justify-center items-center text-white ">
        <h1 class="text-sm md:text-lg lg:text-3xl font-semibold font-poppins">
            Selamat Datang di Info Wisata Guci
        </h1>

        <div class="md:w-[700px] lg:w-[900px] mt-5 lg:mt-10 md:pb-6 text-white flex flex-wrap justify-center gap-5 border-0 md:border-b md:border-white overflow-x-auto whitespace-nowrap">
            <!-- Mobile scrolling for these items -->

            <?php foreach ($data_kategori as $item): ?>
                <a href="<?= base_url($item->slug) ?>" class="flex items-center gap-1 px-2 lg:px-4 py-1 bg-white text-black border border-white rounded-2xl hover:border-black transition-all duration-300 ease-in-out">
                    <img src="<?= base_url('uploads/icon/') . $item->icon ?>" alt="<?= $item->nama ?>" class="w-[30px] md:size-[30px]" />
                    <p class="text-[12px] md:text-sm font-semibold"><?= $item->nama ?></p>
                </a>
            <?php endforeach; ?>

        </div>

        <form method="get" action="<?= site_url('penginapan') ?>"
            class="mt-5 px-1 md:px-10 py-5 flex flex-wrap items-center gap-3 rounded-lg">

            <div class="flex flex-col gap-1">

                <input
                    type="number"
                    name="kapasitas"
                    id="kapasitas"
                    min="1"
                    step="1"
                    inputmode="numeric"
                    placeholder="Mau Cari Kamar Buat Berapa Orang?"
                    value="<?= isset($kapasitas_terpilih) && $kapasitas_terpilih !== NULL
                                ? html_escape($kapasitas_terpilih)
                                : '' ?>"
                    class="w-40 md:w-[370px] rounded-md border border-gray-300 px-3 py-2 md:py-[12px] text-[8px] md:text-sm text-black bg-[#f8f9fd]">
            </div>

            <button
                type="submit"
                class="rounded-md bg-[#ff5d00] px-4 py-2 md:py-[12px] text-sm font-semibold text-white">
                Cari
            </button>

            <a href="<?= site_url('penginapan') ?>"
                class="rounded-md border border-gray-300 px-4 py-2 md:py-[12px] text-sm text-black bg-[#f8f9fd]">
                Reset
            </a>
        </form>

        <div class="hidden md:flex lg:flex mt-10 opacity-90">
            <h1 class="text-2xl text-white font-semibold">infowisataguci.com</h1>
        </div>


    </div>
</nav>

<div>
    <img
        src="<?= base_url('assets/pelanggan/background.jpg') ?>"
        alt=""
        class="-z-40 absolute w-full h-[290px] md:h-[400px] lg:h-[600px]" />
    <div class="-z-30 relative w-full h-[290px] md:h-[400px] lg:h-[600px] bg-black opacity-30"></div>
</div>

<main class="lg:-mt-28 bg-[#f8f7f3] lg:rounded-t-[120px]">

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = document.getElementById('mobile-menu-button');

            if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>