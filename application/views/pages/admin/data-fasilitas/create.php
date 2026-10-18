<form action="<?= base_url('admin/data-fasilitas/store') ?>" method="POST" enctype="multipart/form-data">
    <div class="w-full h-[100px] p-3 flex items-center justify-between text-sm bg-white ">
        <div>
            <h1 class="text-lg font-semibold text-[#2a2a4a]">Tambah Data Fasilitas</h1>
        </div>

        <div class="flex gap-4">
            <button type="reset" class="px-3 py-1 text-red-700 border border-red-700 rounded-md">Hapus Perubahan</button>
            <button type="submit" class="px-3 py-1 text-white bg-[#ff5d1f] rounded-md">Tambah</button>
        </div>
    </div>

    <div class="w-full  mt-5 px-3 py-10 grid grid-cols-2 gap-5 bg-white ">

        <div class="w-[500px] flex flex-col ">
            <label for="">Nama Fasilitas</label>
            <input
                type="text"
                class="px-4 py-2.5 border rounded-md"
                name="nama">
        </div>

        <div class="w-[500px] flex flex-col ">
            <label for="">Icon</label>
            <input
                type="file"
                class="px-4 py-2.5 border rounded-md"
                name="icon"
                accept=".webp, .png, .jpeg, .jpg">
        </div>

        <div class="w-[500px] flex flex-col ">
            <label for="">Deskripsi</label>
            <input
                type="text"
                class="px-4 py-2.5 border rounded-md"
                name="deskripsi">
        </div>

        <div class="w-[500px] flex flex-col ">
            <label for="">Status</label>
            <select name="status" class="px-4 py-2.5 border rounded-md">
                <option value="aktif">aktif</option>
                <option value="nonaktif">nonaktif</option>
            </select>
        </div>
    </div>

</form>