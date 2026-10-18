<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="w-full h-[800px] mt-5 p-4 overflow-y-auto bg-white ">
    <div class="min-h-full py-2 flex flex-col bg-white rounded-2xl space-y-6 shadow-sm">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm text-gray-500">Total wisata</h2>
                <p class="text-2xl font-bold"> <?= $total_wisata ?> </p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm text-gray-500">Total penginapan</h2>
                <p class="text-2xl font-bold"><?= $total_penginapan ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm text-gray-500">Total Pelanggan</h2>
                <p class="text-2xl font-bold"><?= $total_pelanggan ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm text-gray-500">Total pesanan Masuk</h2>
                <p class="text-2xl font-bold"><?= $total_pesanan ?></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">Statistik Pesanan Bulanan</h2>
            <canvas id="orderChart" height="100"></canvas>
        </div>


        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Pesanan Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-2">Kode Booking</th>
                            <th class="px-4 py-2">Pelanggan</th>
                            <th class="px-4 py-2">wisata</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pesanan_terbaru as $item): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"> <?= $item->kode_booking ?> </td>
                                <td class="px-4 py-2"><?= $item->nama_lengkap ?></td>
                                <td class="px-4 py-2"> <?= $item->nama ?> </td>
                                <td class="px-4 py-2"><?= $item->status_pesanan ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const labels = <?= json_encode(array_map(function ($item) {
                        return date('M', mktime(0, 0, 0, $item->bulan, 10));
                    }, $total_pesanan_per_bulan)); ?>;

    const data = <?= json_encode(array_column($total_pesanan_per_bulan, 'total')); ?>;

    const ctx = document.getElementById('orderChart').getContext('2d');
    const orderChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pesanan',
                data: data,
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    }
                }
            }
        }
    });
</script>