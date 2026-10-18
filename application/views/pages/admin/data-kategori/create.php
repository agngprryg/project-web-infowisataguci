<form action="<?= base_url('admin/data-kategori/store') ?>" method="POST" enctype="multipart/form-data">
    <div class="w-full h-[100px] p-3 flex items-center justify-between text-sm bg-white ">
        <div>
            <h1 class="text-lg font-semibold text-[#2a2a4a]">Tambah Data Kategori</h1>
        </div>

        <div class="flex gap-4">
            <button type="reset" class="px-3 py-1 text-red-700 border border-red-700 rounded-md">Hapus Perubahan</button>
            <button type="submit" class="px-3 py-1 text-white bg-[#ff5d1f] rounded-md">Tambah</button>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')) : ?>
        <div id="alert-popup" class="fixed top-5 right-5 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
            <span><?= $this->session->flashdata('error'); ?></span>
            <button onclick="closeAlert()" class="text-white font-bold">×</button>
        </div>
    <?php endif; ?>

    <div class="w-full  mt-5 px-3 py-10 grid grid-cols-2 gap-5 bg-white ">

        <div class="w-[500px] flex flex-col ">
            <label for="">Nama Kategori</label>
            <input
                type="text"
                class="px-4 py-2.5 border rounded-md"
                name="nama">
        </div>

        <div class="w-[500px] flex flex-col ">
            <label for="">Slug</label>
            <select name="slug" class="px-4 py-2.5 border rounded-md">
                <option disabled selected>-- Pilih Slug ---</option>
                <option value="transportasi">Transportasi</option>
                <option value="penginapan">Penginapan</option>
                <option value="wisata">Wisata</option>
            </select>
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
            <label for="">Status</label>
            <select name="status" class="px-4 py-2.5 border rounded-md">
                <option value="aktif">aktif</option>
                <option value="nonaktif">nonaktif</option>
            </select>
        </div>
    </div>

</form>


<script>
    // auto close 3 detik
    setTimeout(() => {
        document.getElementById('alert-popup')?.remove();
    }, 3000);

    // tombol close manual
    function closeAlert() {
        document.getElementById('alert-popup').remove();
    }
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0px);
        }
    }

    .animate-fade-in {
        animation: fade-in .3s ease-out;
    }
</style>