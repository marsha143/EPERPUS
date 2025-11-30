<footer class="bg-light pt-5 pb-4 mt-5 border-top">
    <div class="container text-center">
        <p class="mb-3 text-muted" style="font-size: 15px;">
            Layanan perpustakaan digital untuk mengdukung kemudahan akses peminjaman buku anda
        </p>
        <p class="fw-bold mb-2" style="font-size: 16px; color:#444;">
            Ikuti Politeknik Takumi
        </p>
        <div class="d-flex justify-content-center gap-4 mb-4">
            <a href="#" class="text-danger" style="font-size: 28px;"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-danger" style="font-size: 28px;"><i class="bi bi-tiktok"></i></a>
            <a href="#" class="text-danger" style="font-size: 28px;"><i class="bi bi-youtube"></i></a>
        </div>
        <div class="text-muted" style="font-size: 14px;">
            © 2025 EPERPUS<span class="text-danger">
        </div>

    </div>
</footer>


<!--   Core JS Files   -->
<script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
<!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
<script src="./assets/js/plugins/countup.min.js"></script>

<script src="./assets/js/plugins/choices.min.js"></script>

<script src="./assets/js/plugins/prism.min.js"></script>
<script src="./assets/js/plugins/highlight.min.js"></script>
<!--  Plugin for Parallax, full documentation here: https://github.com/dixonandmoe/rellax -->
<script src="./assets/js/plugins/rellax.min.js"></script>
<!--  Plugin for TiltJS, full documentation here: https://gijsroge.github.io/tilt.js/ -->
<script src="./assets/js/plugins/tilt.min.js"></script>
<!--  Plugin for Selectpicker - ChoicesJS, full documentation here: https://github.com/jshjohnson/Choices -->
<script src="./assets/js/plugins/choices.min.js"></script>
<!--  Plugin for Parallax, full documentation here: https://github.com/wagerfield/parallax  -->
<script src="./assets/js/plugins/parallax.min.js"></script>
<!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
<script src="./assets/js/material-kit.min.js?v=3.0.0" type="text/javascript"></script>
<script type="text/javascript">
if (document.getElementById('state1')) {
    const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));
    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
if (document.getElementById('state2')) {
    const countUp1 = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));
    if (!countUp1.error) {
        countUp1.start();
    } else {
        console.error(countUp1.error);
    }
}
if (document.getElementById('state3')) {
    const countUp2 = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));
    if (!countUp2.error) {
        countUp2.start();
    } else {
        console.error(countUp2.error);
    };
}
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('chartKunjungan');
    if (!canvas) return;
    const labelsK = <?php echo json_encode($labelsKunjungan); ?>;
    const dataK = <?php echo json_encode($dataKunjungan); ?>;
    const labels = labelsK.length ? labelsK : ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    const data = dataK.length ? dataK : [0, 1, 2, 1, 3, 2, 0];
    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Kunjungan',
                data: data,
                tension: 0.3,
                fill: true,
                borderWidth: 2,
                borderColor: '#e91e63',
                backgroundColor: 'rgba(233, 30, 99, 0.15)',
                pointBackgroundColor: '#e91e63'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

});
</script>
<!--   Core JS Files   -->
<script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
<!--  Plugin for Parallax, full documentation here: https://github.com/wagerfield/parallax  -->
<script src="./assets/js/plugins/parallax.min.js"></script>
<!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
<script src="./assets/js/material-kit.min.js?v=3.0.0" type="text/javascript"></script>
<!--   Core JS Files   -->
<script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
<!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
<script src="./assets/js/plugins/countup.min.js"></script>
<!--  Plugin for Parallax, full documentation here: https://github.com/wagerfield/parallax  -->
<script src="./assets/js/plugins/parallax.min.js"></script>
<!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
<script src="./assets/js/material-kit.min.js?v=3.0.0" type="text/javascript"></script>
<script>
// get the element to animate
var element = document.getElementById('count-stats');
var elementHeight = element.clientHeight;

// listen for scroll event and call animate function

document.addEventListener('scroll', animate);

// check if element is in view

if (document.getElementById('typed')) {
    var typed = new Typed("#typed", {
        stringsElement: '#typed-strings',
        typeSpeed: 90,
        backSpeed: 90,
        backDelay: 200,
        startDelay: 500,
        loop: true
    });
}
</script>
<script>
if (document.getElementsByClassName('page-header')) {
    window.onscroll = debounce(function() {
        var scrollPosition = window.pageYOffset;
        var bgParallax = document.querySelector('.page-header');
        var oVal = (window.scrollY / 3);
        bgParallax.style.transform = 'translate3d(0,' + oVal + 'px,0)';
    }, 6);
}
</script>

</body>

</html>