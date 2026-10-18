<div class="bg-white min-h-screen flex">
    <!-- Sidebar -->
    <aside class="max-h-screen flex flex-col justify-between bg-white w-[290px] px-8 py-10 rounded-tr-[24px] rounded-br-[24px] overflow-y-auto">
        <div>
            <div class="flex flex-col gap-3 mb-10">
                <img alt="Logo Black" class="w-[150px] h-[50px]" height="40" src="<?= base_url('assets/logo/logo-hitam.png') ?>" />
            </div>
            <nav class="flex flex-col gap-12 text-[#7a7a8c] text-xs font-medium">
                <div class="text-xs text-[#9a9aa9] font-semibold ">
                    Kelola Data
                </div>

                <a href="<?= base_url('admin/data-wisata') ?>" class="flex items-center gap-3 transition-all ease-in-out duration-200   <?= is_active($this->uri->segment(2), 'data-wisata') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                    Data Wisata
                </a>

                <a href="<?= base_url('admin/data-penginapan') ?>" class="flex items-center gap-3 transition-all ease-in-out duration-200   <?= is_active($this->uri->segment(2), 'data-penginapan') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                    Data Penginapan
                </a>

                <a href="<?= base_url('admin/data-transportasi') ?>" class="flex items-center gap-3 transition-all ease-in-out duration-200   <?= is_active($this->uri->segment(2), 'data-transportasi') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                    Data Transportasi
                </a>

                <div class="text-xs text-[#9a9aa9] font-semibold ">
                    Settings
                </div>

                <a href="<?= base_url('admin/data-kategori') ?>" class="flex items-center gap-3 transition-all ease-in-out duration-200   <?= is_active($this->uri->segment(2), 'data-kategori') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Data Kategori
                </a>

                <a href="<?= base_url('admin/data-fasilitas') ?>" class="flex items-center gap-3 transition-all ease-in-out duration-200   <?= is_active($this->uri->segment(2), 'data-fasilitas') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Data Fasilitas
                </a>
            </nav>
        </div>

    </aside>

    <!-- Main content -->
    <main class="flex-1 px-10 pt-10 max-w-full overflow-auto">
        <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
            <div>
                <?= generate_breadcrumb() ?>
            </div>
            <div class="flex items-center gap-6 justify-end flex-wrap md:flex-nowrap w-full md:w-auto">
                <div class="flex items-center gap-3">
                    <img alt="User profile photo of Randy Riley" class="rounded-full w-10 h-10 object-cover" height="40" src="https://i.pinimg.com/736x/9d/16/4e/9d164e4e074d11ce4de0a508914537a8.jpg" width="40" />
                    <div class="text-right">
                        <p class="text-xs font-semibold text-[#2a2a4a] leading-5">
                            <?= $this->session->userdata('nama'); ?>
                        </p>
                        <p class="text-xs text-[#9a9aa9] leading-4">
                            <?= $this->session->userdata('email'); ?>
                        </p>
                    </div>
                    <span class="block w-3 h-3 rounded-full bg-green-500 border-2 border-white" title="Online status">
                    </span>
                    <!-- Dropdown Profile -->
                    <div class="relative inline-block text-left">
                        <button onclick="toggleDropdown()" class="inline-flex items-center space-x-2">
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.353a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- Dropdown content -->
                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-44 bg-white rounded-md shadow-lg z-10">
                            <a href="<?= base_url('CAuth/logout') ?>" class=" px-4 py-2 flex items-center gap-3 text-sm text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000000" viewBox="0 0 256 256">
                                    <path d="M232,128a8,8,0,0,1-8,8H91.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L91.31,120H224A8,8,0,0,1,232,128ZM40,32a8,8,0,0,0-8,8V216a8,8,0,0,0,16,0V40A8,8,0,0,0,40,32Z"></path>
                                </svg>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>