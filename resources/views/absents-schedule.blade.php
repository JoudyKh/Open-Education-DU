<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style> 
        body { 
            font-family: Helvetica, sans-serif; 
            direction: rtl;  
        } 
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        } 
        th, td { 
            border: 1px solid #f2f2f2; 
            padding: 10px; 
            text-align: center; 
        } 
        th { 
            background-color: #f2f2f2; 
            font-family: Tahoma, Geneva, sans-serif;  
 
        } 
    </style> 
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>التاريخ</th> <!-- Date -->
                <th>اليوم</th>   <!-- Day -->
                <th>الاسم</th>   <!-- Name -->
                <th>مبرر</th>   <!-- Status (Manager/Non-Manager) -->
            </tr>
        </thead>
        <tbody>
            @foreach($data as $entry)
                <tr>
                    <td>{{ $entry['date'] }}</td>
                    <td>{{ $entry['day'] }}</td>
                    <td>{{ $entry['name'] }}</td>
                    {{-- <td>{{ $entry['status'] }}</td> --}}
                    <td>
                        @if($entry['status'] == 1)
                            مبرر
                        @else
                            غير مبرر
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
