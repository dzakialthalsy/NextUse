import './bootstrap';

// resources/js/app.js

document.addEventListener('DOMContentLoaded', function() {
    const productList = document.getElementById('productList');
    const searchInput = document.getElementById('searchInput');
    const conditionFilter = document.getElementById('conditionFilter');
    const categoryFilters = document.querySelectorAll('.category-filter');
    const productItems = productList.querySelectorAll('.product-item');

    // Fungsi utama untuk menyaring dan menampilkan produk
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedCondition = conditionFilter.value;
        const activeCategory = document.querySelector('.category-filter.bg-teal-600')?.dataset.category || 'all';

        productItems.forEach(item => {
            const itemName = item.querySelector('h3').textContent.toLowerCase();
            const itemCondition = item.dataset.condition;
            const itemCategory = item.dataset.category;

            // 1. Filter Pencarian (Search)
            const matchesSearch = itemName.includes(searchTerm);

            // 2. Filter Kondisi (Condition)
            const matchesCondition = selectedCondition === 'all' || itemCondition === selectedCondition;

            // 3. Filter Kategori (Category)
            const matchesCategory = activeCategory === 'all' || itemCategory === activeCategory;

            // Tampilkan/Sembunyikan Item
            if (matchesSearch && matchesCondition && matchesCategory) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });

        // Catatan: Implementasi fitur Sortir (sortFilter) akan membutuhkan perubahan pada urutan elemen di DOM atau manipulasi Array data di sisi JS, yang lebih kompleks.
    }

    // Event Listeners
    searchInput.addEventListener('input', applyFilters);
    conditionFilter.addEventListener('change', applyFilters);

    categoryFilters.forEach(button => {
        button.addEventListener('click', function() {
            // Hapus status aktif dari semua tombol
            categoryFilters.forEach(btn => {
                btn.classList.remove('bg-teal-600', 'text-white', 'border-teal-600', 'hover:bg-teal-700', 'hover:text-white');
                btn.classList.add('bg-white', 'text-gray-600', 'border-gray-300', 'hover:bg-teal-50', 'hover:text-teal-600');
            });

            // Tambahkan status aktif pada tombol yang diklik
            this.classList.remove('bg-white', 'text-gray-600', 'border-gray-300', 'hover:bg-teal-50', 'hover:text-teal-600');
            this.classList.add('bg-teal-600', 'text-white', 'border-teal-600', 'hover:bg-teal-700', 'hover:text-white');

            applyFilters();
        });
    });

    // Inisialisasi: Terapkan filter awal
    // applyFilters(); 
});

// Catatan: Untuk navbar, pergantian halaman dikontrol oleh URL (atribut href) pada tag <a> di HTML. Tidak perlu JS untuk navigasi dasar.