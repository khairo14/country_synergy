<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Generate PDF From View</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
   <p><img src="data:image/png;base64,{{DNS1D::getBarcodePNG("93358655", 'C39+',1,100,array(0,0,0), true)}}" alt="barcode" /></p>
   <p><img src="data:image/png;base64,{{DNS1D::getBarcodePNG("98652344", 'C39+',1,100,array(0,0,0), true)}}" alt="barcode" /></p>
   
</body>
</html>