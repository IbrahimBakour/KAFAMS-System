@extends('layouts.mainAdmin-layout')

@section('content')
<div class="container">
    <h1>KAFA Results Dashboard</h1>

    <!-- Assessment Type Filter -->
    <form method="GET" action="{{ route('home.admin') }}">
        <label for="assessment_type">Select Assessment Type:</label>
        <select name="assessment_type" id="assessment_type" onchange="this.form.submit()">
            @foreach($assessmentTypes as $type)
                <option value="{{ $type }}" {{ $selectedType == $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
    </form>

    <h3>Average Marks for "{{ $selectedType }}" of Each Subjects</h3>

    <!-- Chart Section -->
    <canvas id="averageMarksChart" width="400" height="200"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Render bar chart using Chart.js
            var ctx = document.getElementById('averageMarksChart').getContext('2d');

            var colors = [
                'rgba(75, 192, 192, 0.6)',  // Subject 1 Color (light blue)
                'rgba(153, 102, 255, 0.6)', // Subject 2 Color (purple)
                'rgba(255, 159, 64, 0.6)',   // Subject 3 Color (orange)
                'rgba(255, 99, 132, 0.6)',   // Subject 4 Color (red)
                'rgba(54, 162, 235, 0.6)',   // Subject 5 Color (blue)
                'rgba(255, 206, 86, 0.6)',   // Subject 6 Color (yellow)
            ];
            var averageMarksChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($labels), // e.g., Subjects
                    datasets: [{
                        label: 'Average Marks',
                        data: @json($data), // e.g., Average marks for each subject
                        backgroundColor: @json($data).map((_, index) => colors[index % colors.length]),  // Assign a unique color to each bar
                        borderColor: @json($data).map((_, index) => colors[index % colors.length]),     // Border color matches the background color
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false  // Hides the legend (which contains the label)
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max:100
                        }
                    }
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Subject Analysis Table -->
    <h3>Subject Analysis</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Highest Marks</th>
                <th>Lowest Marks</th>
                <th>Mean Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subjectStats as $subject => $stats)
            <tr>
                <td>{{ $subject }}</td>
                <td>{{ $stats['highest'] }}</td>
                <td>{{ $stats['lowest'] }}</td>
                <td>{{ $stats['mean'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
