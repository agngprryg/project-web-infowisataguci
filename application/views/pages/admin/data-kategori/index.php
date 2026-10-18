<div class="w-full h-[100px] p-3 flex items-center justify-between bg-white ">
    <div>
        <h1 class="text-lg font-semibold text-[#2a2a4a]">Data Kategori</h1>
    </div>

    <div class="flex flex-wrap items-center gap-3 sm:gap-4">

        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
            <div>
                <a href="<?= base_url('admin/data-kategori/create') ?>" class="px-4 py-1 text-sm text-white bg-[#ff5d1f] rounded-md">Tambah</a>
            </div>
        </div>
    </div>
</div>

<div class="w-full h-[600px] mt-5 p-4 overflow-y-auto bg-white ">
    <div class="min-h-full py-2 flex flex-col justify-between bg-white rounded-2xl space-y-6 shadow-sm">

        <!-- Table -->
        <div class="overflow-x-auto ">
            <table class="w-full text-left text-gray-600 text-sm border-separate border-spacing-y-3">
                <thead>
                    <tr class="border-b border-gray-200">

                        <th class="py-3 pl-6 font-semibold text-left">
                            #
                        </th>

                        <th class="py-3 pr-6 font-semibold text-left">
                            Nama Kategori
                        </th>
                        <th class="py-3 pr-6 font-semibold text-left">
                            Slug
                        </th>
                        <th class="py-3 pr-6 font-semibold text-left">
                            Icon
                        </th>
                        <th class="py-3 pr-6 font-semibold text-left">
                            Status
                        </th>
                        <th class="py-3 pr-6 font-semibold text-right">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_kategori as $index => $item): ?>
                        <tr class="bg-white rounded-xl shadow-sm">
                            <td class="py-4 pl-6 align-top text-gray-900">
                                <?= $index + 1 ?>
                            </td>
                            <td class="py-4 pr-6 align-top text-gray-900">
                                <?= $item->nama ?>
                            </td>
                            <td class="py-4 pr-6 align-top text-gray-900">
                                <?= $item->slug ?>
                            </td>
                            <td class="py-4 pr-6 align-top text-gray-900">
                                <img src="<?= base_url('uploads/icon/' . $item->icon) ?>" alt="<?= $item->nama ?>" class="w-[50px] h-[50px]">
                            </td>
                            <td class="py-4 pr-6 align-top text-gray-900">
                                <?= $item->status ?>
                            </td>
                            <td class="py-2 pr-6 flex justify-end gap-3  ">
                                <a href="<?= base_url('admin/data-kategori/edit/' . $item->id) ?>" class="bg-black text-white rounded-xl w-7 h-7 p-1 flex items-center justify-center text-2xl focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>

                                </a>
                                <a href="<?= base_url('admin/data-kategori/delete/' . $item->id) ?>" class="btn-delete bg-black text-white rounded-xl w-7 h-7 p-1 flex items-center justify-center text-2xl focus:outline-none" data-confirm="apkah anda ingin menghapus ini? semua data yang terkait dengan kategori ini akan hilang">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm(this.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });
</script>