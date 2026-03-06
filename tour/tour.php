<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tour</title>
    <link rel="stylesheet" href="tour.css">
    <link rel="stylesheet" href="tour_nav.css">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--dito mga font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gloock&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">
</head>
</head>
<body>
    <?php
    $ROOT = '../'; 
    include __DIR__ . '/../nav.php';
    ?>
    <section>
    <!--<div class="background-shapes">  
         Floating background shapes 
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>

        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>

        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>

        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>

        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>

        <div class="floating-shape"></div>
    </div> --> 
    <h1 class="tour-title"><i class="fa-solid fa-hand-pointer"></i> explore corners of the resort.</h1>
        <div id="virtual-tour-section">
            <div class="tour-container">
                
                <div class="tour-image-display">
                    <div class="hotspots-container" id="hotspots-container"></div>
                    <div id="tour-actions-container" class="tour-actions-container"></div>
                    
                    <img id="main-tour-image" src="" alt="Virtual Tour View"> 
                    
                </div>

                <div class="tour-info">
                    
                    <h2 id="tour-title"></h2>
                    <p id="tour-description"></p>
                    
                </div>
                
            </div>
        </div>
    </section>

    <script src="tour.js"></script>
</body>
</html>