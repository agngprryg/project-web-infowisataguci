<form action="<?= base_url('admin/data-transportasi/update/' . $data_transportasi->id) ?>" method="POST" enctype="multipart/form-data">
    <div class="w-full h-[100px] p-3 flex items-center justify-between text-sm bg-white ">
        <div>
            <h1 class="text-lg font-semibold text-[#2a2a4a]">Tambah Data transportasi</h1>
        </div>

        <div class="flex gap-4">
            <a href="<?= base_url('admin/data-transportasi') ?>" class="px-3 py-1 text-red-700 border border-red-700 rounded-md">Batal</a>
            <button type="submit" class="px-3 py-1 text-white bg-[#ff5d1f] rounded-md">Tambah</button>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')) : ?>
        <div id="alert-popup" class="fixed top-5 right-5 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
            <span><?= $this->session->flashdata('error'); ?></span>
            <button onclick="closeAlert()" class="text-white font-bold">×</button>
        </div>
    <?php endif; ?>

    <div class="w-full  mt-5 p-6 bg-white ">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kategori -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Kategori</label>
                <select name="id_kategori" class="px-4 py-2 border rounded-md">
                    <option disabled>Pilih Kategori</option>
                    <?php foreach ($data_kategori as $item):  ?>
                        <option value="<?= $item->id ?>" <?= $data_transportasi->id_kategori == $item->id ? "selected" : "" ?>>
                            <?= $item->nama ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- Nama transportasi -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Nama transportasi</label>
                <input
                    type="text"
                    name="nama"
                    value="<?= $data_transportasi->nama ?>"
                    class="px-4 py-2 border rounded-md">
            </div>

            <!-- Deskripsi -->
            <div class="flex flex-col md:col-span-2">
                <label class="mb-1 font-medium">Deskripsi</label>
                <textarea
                    name="deskripsi"
                    class="px-4 py-2 border rounded-md h-32 resize-none"><?= $data_transportasi->deskripsi ?></textarea>
            </div>

            <!-- kapasitas -->
            <div class="flex flex-col md:col-span-2">
                <label class="mb-1 font-medium">kapasitas</label>
                <textarea
                    name="kapasitas"
                    class="px-4 py-2 border rounded-md h-32 resize-none"><?= $data_transportasi->kapasitas ?></textarea>
            </div>

            <!-- Harga -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Harga</label>
                <input
                    type="text"
                    name="harga"
                    value="<?= $data_transportasi->harga ?>"
                    class="px-4 py-2 border rounded-md">
            </div>

            <!-- Status -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Status</label>
                <select name="status" class="px-4 py-2 border rounded-md">
                    <option value="aktif" <?= $data_transportasi->status == "aktif" ? "selected" : "" ?>>Aktif</option>
                    <option value="nonaktif" <?= $data_transportasi->status == "nonaktif" ? "selected" : "" ?>>Nonaktif</option>
                </select>
            </div>

            <!-- Thumbnail -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Thumbnail</label>
                <div class="my-3 w-[100px] h-[100px] rounded-md border overflow-hidden">
                    <img src="<?= base_url('uploads/transportasi/' . $data_transportasi->thumbnail) ?>" class="w-full h-full object-cover">
                </div>
                <input type="file" id="thumbnail" name="thumbnail" class="px-4 py-2.5 border rounded-md">
                <input type="hidden" name="compressed_gambar" id="compressed_gambar">
            </div>

            <!-- Detail Gambar -->
            <div class="md:col-span-2 space-y-3">
                <label class="mb-1 font-medium">Detail Gambar</label>
                <span class="text-[10px] text-gray-500">(Maksimal 20 gambar)</span>
                <div class="flex flex-wrap gap-2">
                    <div id="sortable-gambar" class="flex gap-2">
                        <?php foreach ($data_gambar as $item): ?>
                            <div class="relative border rounded-md w-[100px] h-[100px] overflow-hidden group" data-id="<?= $item->id ?>">

                                <!-- Tombol hapus -->
                                <button class="hapus-gambar absolute top-1 right-1 bg-black/60 text-white text-[10px] px-[5px] rounded hidden group-hover:block"
                                    data-id="<?= $item->id ?>">
                                    ✕
                                </button>

                                <img src="<?= base_url('uploads/transportasi/' . $item->gambar) ?>" class="w-full h-full object-cover">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="previews" class="w-[100px] h-[100px] flex gap-2"></div>
                </div>

                <input type="hidden" name="compressed_gambars" id="compressed_gambars">
                <input
                    multiple
                    id="gambar"
                    name="gambar[]"
                    accept="image/*"
                    type="file"
                    class="px-4 py-2.5 border rounded-md">
                <p id="gambarError" class="mt-2 text-sm text-red-600 hidden"></p>
            </div>

        </div>
    </div>
</form>

<script>
    new Sortable(document.getElementById('sortable-gambar'), {
        animation: 150,
        onEnd: function() {
            // Ambil ID berdasarkan urutan
            let order = [];
            document.querySelectorAll('#sortable-gambar div').forEach(e => {
                order.push(e.getAttribute('data-id'));
            });
            console.log(order);


            // Kirim via AJAX ke server
            fetch("<?= base_url('CDataTransportasi/update_order_gambar') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    order: order
                })
            });
        }
    });
</script>

<script>
    document.getElementById('thumbnail').addEventListener('change', function(event) {
        const file = event.target.files[0]

        if (!file) return;

        new Compressor(file, {
            quality: 0.4,
            maxWidth: 1200,
            success(result) {
                const reader = new FileReader()
                reader.readAsDataURL(result)
                reader.onloadend = function() {
                    document.getElementById('compressed_gambar').value = reader.result;
                }
            },
            error(err) {
                console.log(err.message);
            }
        })
    })
</script>

<script>
    const input = document.getElementById('gambar');
    const hiddenInput = document.getElementById('compressed_gambars');
    const previewContainer = document.getElementById('previews');
    let hasilKompres = [];

    input.addEventListener('change', function() {
        previewContainer.innerHTML = "";
        hasilKompres = [];

        const files = this.files;
        if (!files.length) return;
        // console.log(this.files);
        // console.log(hasilKompres);


        Array.from(files).forEach(file => {
            new Compressor(file, {
                quality: 0.6,
                success(result) {
                    const reader = new FileReader();
                    reader.readAsDataURL(result);

                    reader.onloadend = function() {
                        const base64 = reader.result;
                        hasilKompres.push(base64);

                        const img = document.createElement('img')
                        img.src = base64
                        img.style.width = '200px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        img.style.border = '3px solid blue'

                        previewContainer.appendChild(img);

                        // console.log(previewContainer);
                        // console.log(previewContainer.id);

                        hiddenInput.value = JSON.stringify(hasilKompres);
                    }
                    console.log(result);
                },
                error(err) {
                    console.log(err.message);
                }
            })
        })

    })
</script>

<script>
    $(document).on('click', '.hapus-gambar', function(e) {
        e.stopPropagation(); // agar tidak mengganggu sortable
        let id = $(this).data('id');
        let card = $(this).closest("[data-id='" + id + "']");

        $.ajax({
            url: "<?= base_url('admin/data-transportasi/hapus_gambar'); ?>",
            type: "POST",
            data: {
                id: id
            },
            success: function(res) {
                let result = JSON.parse(res);
                if (result.status === "success") {
                    card.remove(); // hapus element di layar
                    window.location.href = "<?= base_url('admin/data-transportasi/edit/' . $data_transportasi->id) ?>";
                } else {
                    alert("Gagal menghapus gambar!");
                }
            }
        });
    });
</script>

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