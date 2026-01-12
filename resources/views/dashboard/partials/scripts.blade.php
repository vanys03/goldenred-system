<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const estadoClientesCtx = document.getElementById('estadoClientesChart').getContext('2d');
    new Chart(estadoClientesCtx, {
        type: 'doughnut',
        data: {
            
            labels: ['Pagados', 'Con Deuda', 'Pendientes Hoy'],
            datasets: [{
                label: 'Estado de clientes',
                data: [
                    {{ $clientesPagados }},
                    {{ $clientesConDeuda }},
                    {{ $clientesPendientesPago }}
                ],
                backgroundColor: [
                    'rgba(76, 175, 80, 0.7)',   // Verde
                    'rgba(244, 67, 54, 0.7)',   // Rojo
                    'rgba(255, 193, 7, 0.7)'    // Amarillo
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
                animation: false,

            responsive: true,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 13
                        },
                        padding: 20
                    }
                }
            }
        }
    });

    const ventasMensualesCtx = document.getElementById('ventasMensualesChart').getContext('2d');
    new Chart(ventasMensualesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_values($meses)) !!},
            datasets: [{
                label: 'Ventas en $',
                data: {!! json_encode($ventasPorMes) !!},
                backgroundColor: 'rgba(33, 150, 243, 0.6)',
                borderColor: 'rgba(33, 150, 243, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
                            animation: false,

            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#333',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            }
        }
    });
</script>
