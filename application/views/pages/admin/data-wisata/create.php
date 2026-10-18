<form action="<?= base_url('admin/data-wisata/store') ?>" method="POST" enctype="multipart/form-data">
    <div class="w-full h-[100px] p-3 flex items-center justify-between text-sm bg-white ">
        <div>
            <h1 class="text-lg font-semibold text-[#2a2a4a]">Tambah Data Wisata</h1>
        </div>

        <div class="flex gap-4">
            <button type="reset" class="px-3 py-1 text-red-700 border border-red-700 rounded-md">Hapus Perubahan</button>
            <button type="submit" id="submitBtn" class="px-3 py-1 text-white bg-[#ff5d1f] rounded-md">Tambah</button>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')) : ?>
        <div id="alert-popup" class="fixed top-5 right-5 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
            <span><?= $this->session->flashdata('error'); ?></span>
            <button onclick="closeAlert()" class="text-white font-bold">×</button>
        </div>
    <?php endif; ?>

    <div class="w-full mt-5 p-6 bg-white">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Kategori -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Kategori</label>
                <select name="id_kategori" class="px-4 py-2.5 border rounded-md">
                    <option selected disabled>Pilih Kategori</option>
                    <?php foreach ($data_kategori as $item): ?>
                        <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                    <?php endforeach ?>
                </select>
                <span class="mt-1 text-xs text-red-600"><?php echo form_error('id_kategori'); ?></span>
            </div>

            <!-- Nama Wisata -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Nama Wisata</label>
                <input
                    type="text"
                    name="nama"
                    placeholder="Contoh : Wisata Baroon Hill"
                    class="px-4 py-2.5 border rounded-md">
                <span class="mt-1 text-xs text-red-600"><?php echo form_error('nama'); ?></span>
            </div>

            <!-- Deskripsi -->
            <div class="flex flex-col md:col-span-2">
                <label class="mb-1 font-medium">Deskripsi</label>
                <textarea
                    name="deskripsi"
                    class="px-4 py-2.5 border rounded-md h-32 resize-none"></textarea>
                <span class="mt-1 text-xs text-red-600"><?php echo form_error('deskripsi'); ?></span>
            </div>

            <!-- Thumbnail -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Thumbnail</label>
                <img id="preview" class="max-w-[200px] max-h-[200px] block rounded-md">
                <input id="thumbnail" type="file" name="thumbnail" class="px-4 py-2.5 border rounded-md">
                <input type="hidden" name="compressed_gambar" id="compressed_gambar">
                <span class="mt-1 text-xs text-red-600"><?php echo form_error('thumbnail'); ?></span>
            </div>

            <!-- Harga -->
            <?php foreach (tarif_labels() as $field => $label): ?>
            <div class="flex flex-col">
                <label for="<?= $field ?>" class="mb-1 font-medium">Harga <?= $label ?></label>
                <input id="<?= $field ?>" type="number" name="<?= $field ?>" min="0" max="2147483647" step="1" required
                    value="<?= set_value($field, 0) ?>" class="px-4 py-2.5 border rounded-md">
                <span class="mt-1 text-xs text-red-600"><?= form_error($field) ?></span>
            </div>
            <?php endforeach; ?>

            <!-- Detail Gambar -->
            <div class="flex flex-col ">
                <div id="previews" class="max-w-[600px] flex gap-5 overflow-x-auto"></div>
                <label class="mb-1 font-medium">
                    Pilih Detail Gambar
                    <span class="text-[10px] text-gray-500">(Maksimal 20 gambar)</span>
                </label>
                <input type="hidden" name="compressed_gambars" id="compressed_gambars">
                <input
                    multiple
                    id="gambar"
                    accept="image/*"
                    type="file"
                    class="px-4 py-2.5 border rounded-md">
                <p id="gambarError" class="mt-2 text-sm text-red-600 hidden">Maksimal 10 gambar saja.</p>
            </div>

            <!-- Status -->
            <div class="flex flex-col">
                <label class="mb-1 font-medium">Status</label>
                <select name="status" class="px-4 py-2.5 border rounded-md">
                    <option selected disabled>Pilih Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                <span class="mt-1 text-xs text-red-600"><?php echo form_error('status'); ?></span>
            </div>

        </div>
    </div>
</form>

<script>
    document.getElementById('gambar').addEventListener('change', function() {
        const fileInput = this;
        const errorMsg = document.getElementById('gambarError');
        const submitBtn = document.getElementById('submitBtn');

        const totalFiles = fileInput.files.length;

        if (totalFiles < 2 || totalFiles > 20) {
            errorMsg.classList.remove('hidden');

            // Pesan dinamis
            if (totalFiles < 2) {
                errorMsg.innerText = "Minimal upload 2 gambar.";
            } else {
                errorMsg.innerText = "Maksimal upload 20 gambar.";
            }

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            errorMsg.classList.add('hidden');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
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
                    document.getElementById("preview").src = reader.result;
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
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';

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