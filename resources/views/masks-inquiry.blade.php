<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masks Inquiry</title>
    <link rel="stylesheet" type="text/css" href="css/masks-inquiry.css" />
</head>
<body>
    <div align="center">
        <form method="get" action="/masks-inquiry">
            <span>欲查詢的地區：</span>
            <input type="text" name="area">
            <input type="submit" value="查詢">
        </form>
        @if ($area || $area==='0')
        <p>您查詢的地區是：{{ $area }}</p>
        @endif
        <table>
            <thead>
                <tr>
                    <th>醫事機構名稱</th>
                    <th>醫事機構地址</th>
                    <th>成人口罩剩餘數</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($recordDatas as $recordData)
                <tr>
                    <td>{{ $recordData["醫事機構名稱"] }}</td>
                    <td>{{ $recordData["醫事機構地址"] }}</td>
                    <td>{{ $recordData["成人口罩剩餘數"] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
