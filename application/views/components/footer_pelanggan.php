</main>
<div class=" w-full flex flex-wrap items-center justify-between py-10 px-5 md:px-14 lg:px-20 bg-[#1c2931]">
    <div>
        <img alt="Logo Guci" src="<?= base_url('/assets/logo/logo.png') ?>" class="mb-5 w-[105px] md:w-[250px]" />
        <div class="flex gap-5">
            <a href="https://www.instagram.com/infowisataguciofficial/">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" viewBox="0 0 256 256" class="size-[20px] md:size-[25px]">
                    <path d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160ZM176,24H80A56.06,56.06,0,0,0,24,80v96a56.06,56.06,0,0,0,56,56h96a56.06,56.06,0,0,0,56-56V80A56.06,56.06,0,0,0,176,24Zm40,152a40,40,0,0,1-40,40H80a40,40,0,0,1-40-40V80A40,40,0,0,1,80,40h96a40,40,0,0,1,40,40ZM192,76a12,12,0,1,1-12-12A12,12,0,0,1,192,76Z"></path>
                </svg>
            </a>
            <a href="https://wa.me/6287830270670">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" viewBox="0 0 256 256" class="size-[20px] md:size-[25px]">
                    <path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84ZM152,176a72.08,72.08,0,0,1-72-72A24,24,0,0,1,99.29,80.46l11.48,23L101,118a8,8,0,0,0-.73,7.51,56.47,56.47,0,0,0,30.15,30.15A8,8,0,0,0,138,155l14.61-9.74,23,11.48A24,24,0,0,1,152,176ZM128,24A104,104,0,0,0,36.18,176.88L24.83,210.93a16,16,0,0,0,20.24,20.24l34.05-11.35A104,104,0,1,0,128,24Zm0,192a87.87,87.87,0,0,1-44.06-11.81,8,8,0,0,0-6.54-.67L40,216,52.47,178.6a8,8,0,0,0-.66-6.54A88,88,0,1,1,128,216Z"></path>
                </svg>
            </a>
            <a href="https://www.tiktok.com/@infowisataguciofficial">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" viewBox="0 0 256 256" class="size-[20px] md:size-[25px]">
                    <path d="M224,72a48.05,48.05,0,0,1-48-48,8,8,0,0,0-8-8H128a8,8,0,0,0-8,8V156a20,20,0,1,1-28.57-18.08A8,8,0,0,0,96,130.69V88a8,8,0,0,0-9.4-7.88C50.91,86.48,24,119.1,24,156a76,76,0,0,0,152,0V116.29A103.25,103.25,0,0,0,224,128a8,8,0,0,0,8-8V80A8,8,0,0,0,224,72Zm-8,39.64a87.19,87.19,0,0,1-43.33-16.15A8,8,0,0,0,160,102v54a60,60,0,0,1-120,0c0-25.9,16.64-49.13,40-57.6v27.67A36,36,0,1,0,136,156V32h24.5A64.14,64.14,0,0,0,216,87.5Z"></path>
                </svg>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-2 text-white text-xs font-light opacity-90 gap-5 lg:gap-y-5 lg:gap-x-10 ">
        <p>Bantuan</p>
        <p>Pertanyaan</p>
        <p>Wisata</p>
        <p>Penginapan</p>
        <p>Kebijakan</p>
        <p>Support</p>
        <p>S&K</p>
    </div>
</div>
<div class="w-full flex flex-wrap justify-center py-1 px-5 md:px-14 lg:px-20 bg-[#1d3a76] ">
    <p class="text-[9px] md:text-xs text-white opacity-70">
        &copy;2025 Infowisataguci All right reserved | Powered by RevisiLagi Corp
    </p>
</div>
</body>

</html>
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("dropdownMenu");
        dropdown.classList.toggle("hidden");
    }

    // Optional: Click outside to close
    document.addEventListener("click", function(event) {
        const dropdown = document.getElementById("dropdownMenu");
        const button = event.target.closest("button");
        if (!dropdown.contains(event.target) && !button) {
            dropdown.classList.add("hidden");
        }
    });
</script>