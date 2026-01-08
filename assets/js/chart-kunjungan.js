document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("chartKunjungan");
    if (!canvas || typeof Chart === "undefined") return;

    new Chart(canvas, {
        type: "line",
        data: {
            labels: window.chartLabels || [],
            datasets: [{
                label: "Jumlah Kunjungan",
                data: window.chartData || [],
                tension: 0.4,
                borderWidth: 2,
                fill: true,
                borderColor: "#e91e63",
                backgroundColor: "rgba(233,30,99,0.15)"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});