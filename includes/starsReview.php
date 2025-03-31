<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interactive Star Rating</title>
  <style>
    /* CSS Styling */
    .star-rating {
      display: flex;
      direction: row;
    }

    .star {
      font-size: 2rem;
      color: gray;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .star.filled {
      color: gold;
    }
  </style>
</head>
<body>
  <!-- HTML Structure -->
  <div class="star-rating">
    <span class="star" data-value="1">★</span>
    <span class="star" data-value="2">★</span>
    <span class="star" data-value="3">★</span>
    <span class="star" data-value="4">★</span>
    <span class="star" data-value="5">★</span>
  </div>

  <p id="rating-text">You have rated this: <span id="rating">0</span> stars</p>

  <script>
    // JavaScript Functionality
    const stars = document.querySelectorAll('.star');
    const ratingText = document.querySelector('#rating');
    
    stars.forEach(star => {
      star.addEventListener('click', () => {
        const ratingValue = star.dataset.value;
        ratingText.textContent = ratingValue;

        // Fill all stars up to the clicked one
        stars.forEach(s => {
          if (s.dataset.value <= ratingValue) {
            s.classList.add('filled');
          } else {
            s.classList.remove('filled');
          }
        });
      });

      star.addEventListener('mouseover', () => {
        const hoverValue = star.dataset.value;

        // Highlight stars up to the hovered one
        stars.forEach(s => {
          if (s.dataset.value <= hoverValue) {
            s.classList.add('filled');
          } else {
            s.classList.remove('filled');
          }
        });
      });

      star.addEventListener('mouseout', () => {
        const currentRating = ratingText.textContent;

        // Restore to the current rating when mouse moves out
        stars.forEach(s => {
          if (s.dataset.value <= currentRating) {
            s.classList.add('filled');
          } else {
            s.classList.remove('filled');
          }
        });
      });
    });
  </script>
</body>
</html>