const search = document.querySelector('#search-input');
const table_rows = document.querySelectorAll('tbody tr');

search.addEventListener('input', searchTable);

function searchTable() {
    const search_data = search.value.toLowerCase(); // Ambil nilai input dan konversi ke lowercase
    let delayIncrement = 0;
    table_rows.forEach((row, i) => {
        const namaHewan = row.children[2].textContent.toLowerCase(); // Ambil teks dari kolom Nama Hewan
        let namaDokter = row.children[6].textContent.toLowerCase(); // Ambil teks dari kolom Nama Dokter
        const namaPemilik = row.children[4].textContent.toLowerCase(); // Ambil teks dari kolom Nama Pemilik

        // Hilangkan awalan "dr. " dari nama dokter untuk keperluan pencarian
        if (namaDokter.startsWith('dr. ')) {
            namaDokter = namaDokter.substring(4); // Menghilangkan awalan "dr. "
        }

        // Periksa apakah teks input adalah awal dari salah satu kolom
        const match = namaHewan.startsWith(search_data) || namaDokter.startsWith(search_data) || namaPemilik.startsWith(search_data);

        if (match) {
            row.classList.remove('hide'); // Hapus kelas hide jika cocok
            row.style.setProperty('--delay', delayIncrement / 25 + 's'); // Atur delay untuk animasi masuk
            delayIncrement++;
        } else {
            row.style.setProperty('--delay', delayIncrement / 25 + 's'); // Atur delay menjadi 0 untuk animasi keluar
            delayIncrement++;
            setTimeout(() => {
                row.classList.add('hide'); // Tambahkan kelas hide setelah delay untuk memungkinkan transisi keluar
            }, 0); // 100ms adalah durasi transisi keluar
        }
    });
}
