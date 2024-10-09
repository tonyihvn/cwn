<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TCWNNI</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/log.png" rel="icon">
  <link href="assets/img/log.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-lg-0">
        <img src="assets/img/logo.jpg" alt="Logo">
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="Gallery.php">Gallery</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </nav><!-- .navbar -->

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header>
<!-- End Hero Section -->
<!-- End Header -->

  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container" data-aos="fade-up">

      <div class="row gy-4">
      <?php
            // Function to fetch content using cURL
            function fetchWithCurl($url) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For HTTPS
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }

            if (isset($_GET['url'])) {
                // Extract the URL of the post
                $post_url = urldecode($_GET['url']);
                
                // REST API URL for retrieving the post content based on the post slug
                $parsed_url = parse_url($post_url);
                $slug = basename($parsed_url['path']);
                $api_url = 'https://changenigeriainitiative.org.ng/wp-json/wp/v2/posts?slug=' . $slug;

                // Fetch post data using cURL
                $post_data_json = fetchWithCurl($api_url);
                $post_data = json_decode($post_data_json, true);
                
                if ($post_data && count($post_data) > 0) {
                    $post = $post_data[0];
                    $title = $post['title']['rendered'];
                    $content = $post['content']['rendered'];
                    $featured_image_id = $post['featured_media'];

                    // Fetch the featured image using another API call if it exists
                    $featured_image_url = '';
                    if ($featured_image_id) {
                        $image_data_json = fetchWithCurl('https://changenigeriainitiative.org.ng/wp-json/wp/v2/media/' . $featured_image_id);
                        $image_data = json_decode($image_data_json, true);
                        if (isset($image_data['source_url'])) {
                            $featured_image_url = $image_data['source_url'];
                        }
                    }

                    // Display post title, featured image, and content
                    echo '<h1>' . $title . '</h1>';
                    if ($featured_image_url) {
                        echo '<img src="' . $featured_image_url . '" alt="' . $title . '" style="width:100%;height:auto;">';
                    }
                    echo $content;
                } else {
                    echo 'Post not found or unable to fetch the content.';
                }
            } else {
                echo 'No post URL provided.';
            }
        ?>


      </div>

    </div>
  </section>
  
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div>
            <h4>Address</h4>
            <p>
              Federal Capital Territory, Nig
            </p>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
           
            <p>
              <strong>Phone:</strong>  0809 111 0574 , +234 809 111 0574<br>
              <strong>Email:</strong> changeweneednigeria@yahoo.com<br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Opening Hours</h4>
            <p>
                <strong>Mon-friday: 9AM</strong> - 5PM<br>
                saturday: Closed
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Follow Us</h4>
          <div class="social-links d-flex">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    


  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>