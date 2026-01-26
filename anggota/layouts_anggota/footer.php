<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/material-kit.min.js?v=3.0.0"></script>

<script>
function openDetailBuku(card) {
    const cover = card.getAttribute('data-cover') || '';
    const judul = card.getAttribute('data-judul') || '';
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
        crossorigin="anonymous"></script>


<script>
const fileInput = document.getElementById('fileToUpload');
if (fileInput) {
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.querySelector('.avatar-profile');
            if (img) img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}
</script>


<script>
function downloadKartuImg(format = 'png') {
    const kartu = document.getElementById('kartu-anggota');

    if (!kartu) {
        alert('Kartu anggota tidak ditemukan');
        return;
    }

    html2canvas(kartu, {
        scale: 2,
        backgroundColor: '#ffffff',
        useCORS: true
    }).then(canvas => {
        const link = document.createElement('a');
        link.href = canvas.toDataURL(
            format === 'jpg' ? 'image/jpeg' : 'image/png'
        );
        link.download = 'kartu_anggota.' + format;
        link.click();
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
