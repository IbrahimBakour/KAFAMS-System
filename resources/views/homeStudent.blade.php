@extends('layouts.main-layout')

@section('content')
<div class="container">
    <h1>Student Assessment Results</h1>

    <h3>Comparison of Latest Two Assessments for Each Subject</h3>

    <!-- Chart Section -->
    <canvas id="assessmentComparisonChart" width="400" height="200"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('assessmentComparisonChart').getContext('2d');
            var assessmentComparisonChart = new Chart(ctx, {
                type: 'bar', // Bar chart for comparing the two assessments
                data: {
                    labels: @json($labels), // Subjects
                    datasets: [{
                        label: @json($assessmentTypes[0] ?? 'N/A'), // Latest assessment type
                        data: @json($data).map(item => item[0]), // Marks for the latest assessment
                        backgroundColor: 'rgba(75, 192, 192, 0.6)', // Color for the first assessment
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: @json($assessmentTypes[1] ?? 'N/A'), // Previous assessment type
                        data: @json($data).map(item => item[1]), // Marks for the second latest assessment
                        backgroundColor: 'rgba(153, 102, 255, 0.6)', // Color for the second assessment
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100, // Assuming marks are out of 100
                        }
                    }
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</div>
@endsection
