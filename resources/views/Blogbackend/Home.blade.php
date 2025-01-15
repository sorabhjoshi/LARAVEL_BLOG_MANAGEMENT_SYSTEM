@extends('Blogbackend.components.layout')

@section('title', 'Dashboard')

@section('content')
<style>.headerimg button {
    padding: 19px 18px !important;
    border-bottom: 1px solid #4b5c70 !important;
}</style>
<section class="overview-section">
    <div class="col-md-5">
        <div class="chart-container">
            <h3>Blog Categories Overview</h3>
            <canvas id="blogCategoryChart"></canvas>
        </div>
        <section class="frontend-section">
            <div class="section-header">
                <h3>View Frontend</h3>
            </div>
            <div class="frontend-action">
                <p>Click below to visit the frontend of the blog and see the live content:</p>
                <a href="{{ route('Dashboardfront') }}" target="_blank" class="btn">Go to Frontend</a>
            </div>
        </section>
    </div>
   
    <div class="data-overview col-md-6">
        <div class="data-card">
            <h3>Users</h3>
            <p>{{ $users }}</p>
            <small>Total users registered</small>
        </div>
        <div class="data-card">
            <h3>News</h3>
            <p>{{ $news }}</p>
            <small>Total news articles published</small>
        </div>
        <div class="data-card">
            <h3>Blogs</h3>
            <p>{{ $blogs }}</p>
            <small>Total blog posts available</small>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const categories = @json($category);

    if (!categories || categories.length === 0) {
        console.warn("No category data available");
    } else {
        const labels = categories.map(item => item.categorytitle);
        const data = categories.map(item => item.blogs_count);

        const ctx = document.getElementById('blogCategoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#6A1B9A', '#283593', '#0277BD', '#2E7D32', '#F9A825'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'bottom' },
                    tooltip: { enabled: true }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }
</script>
@endsection

<style>
/* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f7f7f7;
    color: #333;
    font-size: 16px;
    overflow-x: hidden;
}

/* Responsive Section Styling */
.overview-section {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    align-items: flex-start;
    padding: 30px 10px;
    max-width: 1200px;
    margin: auto;
}

/* Chart Container */
.chart-container {
    flex: 1;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.chart-container:hover {
    transform: translateY(-5px);
}

.chart-container h3 {
    text-align: center;
    margin-bottom: 15px;
    font-size: 20px;
    color: #4b5563;
    font-weight: 600;
}

#blogCategoryChart {
    max-width: 100%;
    height: auto;
}

/* Data Overview Section */
.data-overview {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.data-card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e5e7eb;
    width: 400px;
}

.data-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.data-card h3 {
    font-size: 18px;
    color: #1E293B;
    margin-bottom: 10px;
    font-weight: 600;
}

.data-card p {
    font-size: 36px;
    font-weight: 800;
    color: #3498db;
    margin: 10px 0;
}

.data-card small {
    font-size: 14px;
    color: #6B7280;
}

/* Frontend Section */
.frontend-section {
    margin-top: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.frontend-section .section-header h3 {
    font-size: 20px;
    color: #4b5563;
    margin-bottom: 15px;
}

.frontend-action p {
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
}

.frontend-action .btn {
    background: #3498db;
    color: #fff;
    padding: 10px 20px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.3s ease;
}

.frontend-action .btn:hover {
    background: #2980b9;
}

/* Media Queries */
@media (max-width: 768px) {
    .chart-container, .data-card {
        margin: 0 auto;
        width: 200px !important;
    }
    
    .overview-section {
        padding: 20px 10px;
    }
}
</style>
