<style>
    /* Container styles */
    .rate-card-container {
        padding: 20px;
        width: 100%;
        overflow-x: auto;
    }

    .rate-card {
        width: 100%;
        font-family: Arial, sans-serif;
        background: white;
    }

    .rate-card-title {
        background: #FFD700;
        padding: 8px;
        text-align: left;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: normal;
        width: 100%;
    }

    .rate-card-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0;
        table-layout: fixed;
        margin-left: auto;
    }

    /* Header row styling */
    .rate-card-table thead tr:first-child th {
        background: #CC0000;
        color: white;
        padding: 8px;
        border: 1px solid white;
        font-weight: normal;
    }

    .rate-card-table thead tr:last-child th {
        background: #CC0000;
        color: white;
        padding: 8px;
        border: 1px solid white;
        font-weight: normal;
        font-size: 14px;
    }

    .rate-card-table tbody td {
        padding: 8px;
        text-align: center;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    /* First column styling - red background */
    .rate-card-table tbody td:first-child {
        background: #CC0000;
        color: white;
    }

    /* LKR Price columns - light blue */
    .rate-card-table tbody td:nth-child(2),
    .rate-card-table tbody td:nth-child(4) {
        background: #B8D4E8;
    }

    /* USD Price columns - gray */
    .rate-card-table tbody td:nth-child(3),
    .rate-card-table tbody td:nth-child(5) {
        background: #D3D3D3;
    }

    /* Last row special styling */
    .rate-card-table tbody tr:last-child td {
        background: #B8D4E8;
    }

    .rate-card-table tbody tr:last-child td:first-child {
        background: #CC0000;
        color: white;
    }

    /* Make sure table is visible on all screen sizes */
    @media screen and (min-width: 1024px) {
        .rate-card-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .rate-card-table {
            min-width: 800px;
        }
    }
</style>

<div class="rate-card-container">
    <div class="rate-card">
        <div class="rate-card-title">
            Rate Card for Vacancy Advertising - effective from 01st February 2025
        </div>
        <table class="rate-card-table">
            <thead>
                <tr>
                    <th rowspan="2">Package size (No of<br>Job Vacancy Posts)</th>
                    <th colspan="2">20 Days</th>
                    <th colspan="2">30 Days</th>
                </tr>
                <tr>
                    <th>Per ads LKR Price</th>
                    <th>Per ads USD Price</th>
                    <th>Per ads LKR Price</th>
                    <th>Per ads USD Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                    <tr>
                        <td>{{ $package->size }}</td>
                        <td>{{ number_format($package->lkr_price) }}</td>
                        <td>{{ $package->usd_price }}</td>
                        <td>{{ number_format($package->lkr_price) }}</td>
                        <td>{{ $package->usd_price }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>11 or above per<br>month</td>
                    <td colspan="2">1). Email OR<br>2). Request a special quotation</td>
                    <td colspan="2">1). Email OR<br>2). Request a special quotation</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
