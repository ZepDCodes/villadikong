<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villa Dikong Resort</title>
    <!--files-->
    <link type="image/png" sizes="32x32" rel="icon" href="images/favicon_logo.png">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="hero.css">
    <link rel="stylesheet" href="amenities_section.css">
    <link rel="stylesheet" href="about_section.css">
    <link rel="stylesheet" href="foot.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
<body>
    <?php
    $ROOT = ''; 
    include __DIR__ . '/nav.php';
    ?>
<main>
  <section class="hero">
    <div class="hero-content">
      <h1>A local resort that you will enjoy.</h1>
      <p class="tagline">We offer a luxury resort for your need.</p><br><br>
      <a href="#amenities" class="exBtn">EXPLORE!</a>
    </div>
  </section>
</main>
    
<div style="overflow: hidden;">
  <svg
    preserveAspectRatio="none"
    viewBox="0 0 1200 120"
    xmlns="http://www.w3.org/2000/svg"
    style="fill: #fbf5ef; width: 130%; height: 97px; transform: scaleX(-1);"
  >
    <path d="M321.39 56.44c58-10.79 114.16-30.13 172-41.86 82.39-16.72 168.19-17.73 250.45-.39C823.78 31 906.67 72 985.66 92.83c70.05 18.48 146.53 26.09 214.34 3V0H0v27.35a600.21 600.21 0 00321.39 29.09z" />
  </svg>
</div>

  <section id="amenities">
      <!-- Floating background shapes -->
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
    <h2>⬦ Amenities</h2>

    <div class="amenities-container">
      <!-- ROOM -->
      <div class="amenities-column">
        <h3><i class='bx bxs-bed'></i> Room Amenities</h3>

        <!-- toggle card -->
        <button class="card-toggle" onclick="toggleCards('room')">
          <img src="images/room_bed.jpg" alt="Room Main">
          <p><i class='bx bxs-down-arrow'></i>View Room Amenities</p>
        </button>

        <div id="room-cards" class="card-grid hidden">
          <div class="card" onclick="openModal('images/amenities_room/TV.jpg','TV & Cable')">
            <img src="images/amenities_room/TV.jpg"><p>TV & Cable</p>
          </div>
          <div class="card" onclick="openModal('images/amenities_room/aircond.jpg','Air Conditioning')">
            <img src="images/amenities_room/aircond.jpg"><p>Air Conditioning</p>
          </div>
          <!--div class="card" onclick="openModal('images/amenities_room/wifi.jpeg','Free WiFi')">
            <img src="images/amenities_room/wifi.jpeg"><p>Free WiFi</p>
          </div-->
          <div class="card" onclick="openModal('images/amenities_room/kitchen_area.jpg','kitchen')">
            <img src="images/amenities_room/kitchen_area.jpg"><p>Kitchen</p>
          </div>
          <div class="card" onclick="openModal('images/amenities_room/shower.jpg','Shower')">
            <img src="images/amenities_room/shower.jpg"><p>Shower</p>
          </div>
          <div class="card" onclick="openModal('images/amenities_room/balcon.jpg','Balcony')">
            <img src="images/amenities_room/balcon.jpg"><p>Balcony</p>
          </div>

              <button class="close-all" onclick="toggleCards('room')" style="background: none; border: none;">
              <i class='bx bxs-up-arrow'></i> Close All
              </button>

        </div>
      </div>

      <div class="amenities-column">
        <h3><i class="fa-solid fa-water-ladder"></i> Pool Amenities</h3>

      
        <button class="card-toggle" onclick="toggleCards('pool')">
          <img src="images/background-2.png" alt="Pool Main">
          <p><i class='bx bxs-down-arrow'></i>View Pool Amenities</p>
        </button>

        <div id="pool-cards" class="card-grid hidden">
          
          <div class="card" onclick="openModal('images/amenities_pool/karaoke.jpg','Karaoke')">
            <img src="images/amenities_pool/karaoke.jpg"><p>Karaoke</p>
          </div>
          <div class="card" onclick="openModal('images/amenities_pool/pool_bar.jpg','Pool Bar')">
            <img src="images/amenities_pool/pool_bar.jpg"><p>Pool Bar</p>
          </div>
          <div class="card" onclick="openModal('images/amenities_pool/pool_dining_area.jpg','Poolside Dining area')">
            <img src="images/amenities_pool/pool_dining_area.jpg"><p>Poolside Dining area</p>
          </div>
          <!--div class="card" onclick="openModal('images/dummy_img.png','Jacuzzi')">
            <img src="images/dummy_img.png"><p>Jacuzzi</p>
          </div-->
          <!--div class="card" onclick="openModal('images/dummy_img.png','Sun Loungers')">
            <img src="images/dummy_img.png"><p>Sun Loungers</p>
          </div-->
          <!--div class="card" onclick="openModal('images/dummy_img.png','Poolside Dining')">
            <img src="images/dummy_img.png"><p>Poolside Dining</p>
          </div-->

            <button class="close-all" onclick="toggleCards('pool')" style="background: none; border: none;" >
            <i class='bx bxs-up-arrow'></i> Close All
            </button>

        </div>
      </div>

      </div>
      <!-- MODAL POPUP -->
      <div id="amenityModal" class="modal hidden">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImg" src="" alt="Amenity Image">
        <p id="modalCaption"></p>
      </div>

    <a href="tour/tour.php" class="button"><i class="fa-regular fa-circle-right"></i> TOUR</a>
  </section>

  <div style="overflow: hidden;" class="divider">
    <svg
    preserveAspectRatio="none"
    viewBox="0 0 1200 120"
    xmlns="http://www.w3.org/2000/svg"
    style="fill: #b7d8de; width: 127%; height: 120px;"><path
    d="M0 0v46.29c47.79 22.2 103.59 32.17 158 28 70.36-5.37 136.33-33.31 206.8-37.5 73.84-4.36 147.54 16.88 218.2 35.26 69.27 18 138.3 24.88 209.4 13.08 36.15-6 69.85-17.84 104.45-29.34C989.49 25 1113-14.29 1200 52.47V0z"
    opacity=".25"/>
    <path d="M0 0v15.81c13 21.11 27.64 41.05 47.69 56.24C99.41 111.27 165 111 224.58 91.58c31.15-10.15 60.09-26.07 89.67-39.8 40.92-19 84.73-46 130.83-49.67 36.26-2.85 70.9 9.42 98.6 31.56 31.77 25.39 62.32 62 103.63 73 40.44 10.79 81.35-6.69 119.13-24.28s75.16-39 116.92-43.05c59.73-5.85 113.28 22.88 168.9 38.84 30.2 8.66 59 6.17 87.09-7.5 22.43-10.89 48-26.93 60.65-49.24V0z"opacity=".5"/>
    <path d="M0 0v5.63C149.93 59 314.09 71.32 475.83 42.57c43-7.64 84.23-20.12 127.61-26.46 59-8.63 112.48 12.24 165.56 35.4C827.93 77.22 886 95.24 951.2 90c86.53-7 172.46-45.71 248.8-84.81V0z" />
    </svg>
  </div>

    <section id="explore-about" class="section-2">
    <div class="about-container">

    <div class="about-left">

      <div class="map-container">
        <p class="map-location-text" style="color: #fbf5ef;">
          <i class="fa-solid fa-map-location-dot"></i> us on map:
        </p>
        <br>
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1045.3856927492018!2d120.62638309815219!3d15.679074431697838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339133add3ff47ad%3A0x728c13f25dc5f22f!2sVilla%20Dikong%20Private%20Pool!5e1!3m2!1sen!2sph!4v1758110582641!5m2!1sen!2sph" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>

      <p> <i style="font-size: 20px;"><i class='bx bxs-pin' style="color: #fe7236;"></i>Purok Serrano Brgy.Coral, Ramos, 2311 Tarlac </i></p>
    </div>

    <div class="about-right">
        <h3 id="about-us">⬦ About us</h3>
            <p>Welcome to Villa Dikong Private Resort,<b> your perfect get away destination </b></p> <br>
            <p>&nbsp; &nbsp;Nestled in the hear of Ramos Tarlac, out private resort is designed for relaxtation, comfort and unforgettable memories, whether you're looking for a peaceful retreat , a family vacation or a place to celebrate life's special moment's we offer the perfect setting surround by nature's beauty.</p><br>
            <p>Since opening our doors in <b>2022</b>, our mission has been to provide guests with an exclusive experience that combines <i>warm hospitality, modern ameneties and serenity of private escape.</i></p>
    </div>
    </div>
    </section>

    <footer class="footer" id="feet">
        <div class="socials">
            <a href="https://www.facebook.com/villadikongresort"><i class="fab fa-facebook-f"></i></a>
            <a href="https://maps.app.goo.gl/DqvR3UpPMKXvfHQQ7"><i class="fa-solid fa-map-location-dot"></i></a>
        </div>
        <div class="pages">
            <a href="#" class="pages_link"><i class='bx bxs-up-arrow-alt'></i>Home</a>
        </div>
            <p class="footer-name"> <i style="padding-right: 10px ;">Villa Dikong Resort</i> <span style="border-left: 1.5px solid #6cb5cb; padding-left:10px;"> <i>2025</i> </span></p>
    </footer>

    <script src="tour.js"> </script>
    <script src="amenities.js"></script>
</body>
</html>