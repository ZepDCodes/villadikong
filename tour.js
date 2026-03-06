  const images = [
    { src: "tour_images/room.jpg", caption: "Room and Bed" },
    { src: "tour_images/kitchen.jpg", caption: "Kitchen" },
    { src: "tour_images/sala_area.jpg", caption: "Living Room" },
    { src: "tour_images/pool.jpg", caption: "Pool Area" },
    { src: "tour_images/outside.jpg", caption: "Outside View" }
  ];

  let currentIndex = 0;
  const tourImage = document.getElementById("tourImage");
  const tourCaption = document.getElementById("tourCaption");
  const nextBtn = document.getElementById("nextBtn");

  nextBtn.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % images.length;
    tourImage.src = images[currentIndex].src;
    tourCaption.textContent = images[currentIndex].caption;
  });