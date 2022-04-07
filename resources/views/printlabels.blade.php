<!DOCTYPE html>
<html>
<head>
    <title>Country Synergy | Pallet Label</title>
    <style>
        table, th, td, tr {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 12px;
        text-align:center;
        }
    </style>
</head>
<body>
    <h1>{{$title}}</h1>
    <table>
        <tr>
            <td>Dispatch Date:</td>
            <td>{{$date}}</td>
        </tr>
        <tr>
            <td colspan="2">Deliver To:</td>
        </tr>
        <tr>
            <td colspan="2">Inglewood Farms 486 Tobacco Road, Inglewood, QLD</td>
        </tr>
        <tr>
            <td>Qty</td>
            <td>38</td>
        </tr>
        <tr>
            <td>Weight</td>
            <td>400 KGs</td>
        </tr>
        <tr>    
            <td colspan="2"><img src="data:image/png;base64,{{DNS1D::getBarcodePNG("93358655", 'C39',1,100,array(0,0,0), true)}}" alt="barcode" /></td>
        </tr>
        <tr>
            <td colspan="2"><img src="data:image/png;base64,{{DNS1D::getBarcodePNG("98652344", 'C39',1,100,array(0,0,0), true)}}" alt="barcode" /></td>
        </tr>
    </table>
</body>
</html>