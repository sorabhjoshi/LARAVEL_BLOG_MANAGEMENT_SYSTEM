@extends('Blogbackend.components.layout')

@section('title', 'Dashboard')

@section('content')
<section class="overview-section">
    <div class="col-md-6 ">
        <div class="chart-container ">
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
   
    <div class="data-overview">
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
    console.log(categories);
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
</script>
@endsection

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif; /* New font for a modern feel */
    }

    body {
        background-color: #f7f7f7;
        color: #333;
        font-size: 16px;
    }
    
    .overview-section {
        display: flex;
        flex-direction: row;
        gap: 30px;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        padding: 50px 20px !important;
        max-width: 1200px;
        margin: auto;
    }

    .chart-container {
        /* flex: 1; */
        height: 400px;
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        transition: transform 0.3s ease;
    }

    .chart-container:hover {
        transform: translateY(-5px);
    }

    .chart-container h3 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #4b5563;
        font-weight: 600;
    }

    #blogCategoryChart {
        width: 100%;
        max-height: 300px;
    }

    .data-overview {
        display: flex;
        flex-direction: column;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .data-card {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        width: 550px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .data-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .data-card h3 {
        font-size: 22px;
        color: #1E293B;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .data-card p {
        font-size: 40px;
        font-weight: 800;
        color: #3498db;
        margin: 15px 0;
    }

    .data-card small {
        font-size: 14px;
        color: #6B7280;
    }

    /* New Frontend Section */
    .frontend-section {
        margin-top: 40px;
        padding: 30px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .frontend-section .section-header h3 {
        font-size: 24px;
        color: #4b5563;
        margin-bottom: 20px;
    }

    .frontend-action p {
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
    }

    .frontend-action .btn {
        background: #3498db;
        color: #fff;
        padding: 12px 30px;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .frontend-action .btn:hover {
        background: #2980b9;
    }
</style>
