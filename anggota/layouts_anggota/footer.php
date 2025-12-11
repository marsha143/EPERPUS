<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/material-kit.min.js?v=3.0.0"></script>

<script>
function openDetailBuku(card) {
    const cover = card.getAttribute('data-cover') || '';
    const judul = card.getAttribute('data-judul') || '';
    const kode = card.getAttribute('data-kode') || '';
    const isbn = card.getAttribute('data-isbn') || '';
    const penulis = card.getAttribute('data-penulis') || '';
    const tahun = card.getAttribute('data-tahun') || '';
    const penerbit = card.getAttribute('data-penerbit') || '';
    const status = card.getAttribute('data-status') || '';
    const desk = card.getAttribute('data-deskripsi') || 'Belum ada deskripsi buku.';

    document.getElementById('modalCover').src = cover;
    document.getElementById('modalJudulBuku').textContent = judul;
    document.getElementById('modalJudul').textContent = judul;
    document.getElementById('modalPenulis').textContent = penulis;
    document.getElementById('modalKode').textContent = kode;
    document.getElementById('modalIsbn').textContent = isbn;
    document.getElementById('modalTahun').textContent = tahun;
    document.getElementById('modalPenerbit').textContent = penerbit;

    const statusSpan = document.getElementById('modalStatus');
    statusSpan.textContent = status;
    statusSpan.classList.remove('bg-danger', 'bg-success');
    if (status === 'Dipinjam') {
        statusSpan.classList.add('bg-danger', 'text-white');
    } else {
        statusSpan.classList.add('bg-success', 'text-white');
    }

    document.getElementById('modalDeskripsi').textContent = desk;

    const modalEl = document.getElementById('detailBukuModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#searchModal .js-example-basic-single').select2({
        dropdownParent: $('#searchModal')
    });
});
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNa5lQ3zq9N4fB9npDPusVfrH0eSPo6e7i9oC8blKp8o7YjA5pq/2pA8H2qJkEv+fU3HkZfNwYgqZ3j2bW+U2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- FOTO -->
<script>
document.getElementById('fileToUpload').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        document.querySelector('.avatar-profile').src = e.target.result;
    };
    reader.readAsDataURL(file);
});
</script>
</body>

</html>