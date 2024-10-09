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

        <style>
          .glow {
            color: #fff;
            animation: glow 1s ease-in-out infinite alternate;
          }

          @-webkit-keyframes glow {
            from {
              text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px #e60073, 0 0 20px #e60073, 0 0 25px #e60073, 0 0 30px #e60073, 0 0 35px #e60073;
            }
            
            to {
              text-shadow: 0 0 10px #fff, 0 0 15px red, 0 0 20px red, 0 0 25px red, 0 0 30px red, 0 0 35px red, 0 0 40px red;
            }
          }
          
          @media (max-width: 768px) {
              .logo {
                  width: 100%; /* Occupy 70% of the width on screens 768px wide or smaller */
              }

              #hero{
                background-image: none !important;
                background-color: black;
              }

              .carousel-caption h5, .carousel-caption p{
                display: none;
                visibility: hidden; 
              }
          }

          .carousel-caption {
              background: rgba(0, 0, 0, 0.6);
              padding: 10px;
          }

          .carousel-item img {
              width: 100%;
              height: auto;
              object-fit: cover;
          }
          .carousel-inner{
            width: 100%;
            height: auto;
          }
          .list-group-item a{
            color: darkblue;
            font-weight: bold;
          }
        </style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center" style="clear: both; position: relative; margin-bottom: 5px;">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-lg-0">
        <img src="assets/img/logo.jpg" alt="Logo" class="logo">
        
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="#updates">News/Blog</a></li>
          <li><a href="Gallery.php">Gallery</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </nav><!-- .navbar -->

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center section-bg otherrr" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2),rgba(1, 6, 7, 0.446)),url(./assets/img/secondflyer.png); padding: 0px !important;">
      <div class="row" style="width: 100%;">
        <div class="col-md-5" style="background-color: black; color: white !important; opacity: 0.9;">
          <div id="postCarousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
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

                  // URL of the WordPress site's RSS feed
                  $rss_url = 'https://changenigeriainitiative.org.ng/blog/feed/';

                  // Fetch the RSS feed content using cURL
                  $rss_content = fetchWithCurl($rss_url);

                  if ($rss_content) {
                      $rss = simplexml_load_string($rss_content, 'SimpleXMLElement', LIBXML_NOCDATA);

                      if ($rss) {
                          echo '<div id="postCarousel" class="carousel slide" data-ride="carousel">';
                          echo '<div class="carousel-inner">';

                          $i = 0;
                          foreach ($rss->channel->item as $item) {
                              $title = $item->title;
                              $link = $item->link;
                              $description = strip_tags($item->description); // Remove HTML tags
                              $excerpt = substr($description, 0, 200) . '...'; // First 200 chars for excerpt

                              // Extract image URL from the description content
                              preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $item->description, $image_match);
                              $image_url = $image_match['src'] ?? 'https://via.placeholder.com/800x500.png?text=No+Image';

                              // Add "active" class to the first carousel item
                              $active_class = ($i === 0) ? 'active' : '';

                              // Display carousel item
                              echo '<div class="carousel-item ' . $active_class . '">';
                              echo '<img class="d-block w-100" src="' . $image_url . '" alt="' . $title . '">';
                              echo '<div class="carousel-caption">';
                              echo '<h5>' . $title . '</h5>';
                              echo '<p>' . $excerpt . '</p>';
                              echo '<a href="view_post.php?url=' . urlencode($link) . '" class="btn btn-primary">Read More</a>';
                              echo '</div>';
                              echo '</div>';

                              $i++; // Increment for the next item
                          }

                          echo '</div>';
                          echo '<a class="carousel-control-prev" href="#postCarousel" role="button" data-slide="prev">';
                          echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                          echo '<span class="sr-only">Previous</span>';
                          echo '</a>';
                          echo '<a class="carousel-control-next" href="#postCarousel" role="button" data-slide="next">';
                          echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                          echo '<span class="sr-only">Next</span>';
                          echo '</a>';
                          echo '</div>';
                      } else {
                          echo 'Unable to parse the RSS feed.';
                      }
                  } else {
                      echo 'Unable to fetch the RSS feed.';
                  }
               ?>


              </div>

              <!-- Carousel Controls -->
              <a class="carousel-control-prev" href="#postCarousel" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#postCarousel" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
              </a>
          </div>
          <button style="border: none;
              background-color: red;
              color: white !important;             
              border-radius:100%;
              height: 7vh;
              padding: 10px;
              float: right;
            " class="oth-fonts"><a href="register.php" style="color: white;"></a>Click Here to Watch the Program Live</a></button>

        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <section id="updates" style="background-color:black;">
    <div class="container">
      <div class="row">
        <div class="col-md-8" style="color: white;">
          <h1>13TH Annual Change We Need Programme</h1>
          <h2 style="color: yellow;">Prayers for Nigeria and Her Leaders</h2>
          <hr>
          <p>The Change We Need (TCWN) Programme has consistently served as a platform for reflection, dialogue, and prayer for Nigeria, particularly during its annual Independence event at the National Christian Centre. Over the years, TCWN has brought together political leaders, senior public officials, Christian leaders, representatives from development organizations, the media, and academia to deliberate on critical issues affecting Nigeria’s development and to lift the nation and her leaders in prayer. The program has been institutionalized, becoming a vital occasion for inspiring collective action towards national transformation and unity. Through these dialogues, key themes have emerged, addressing the country’s most pressing challenges while seeking divine guidance for solutions.</p>
          <p>This year, the 13th Edition is themed: <b>Prayers for Nigeria and Her Leaders</b>. Links and updates of this event will be pusblished soon on this platform</p>
        <hr>
        </div>
        <div class="col-md-4">
        <?php
            // URL of the WordPress site's RSS feed
            $rss_url = 'https://changenigeriainitiative.org.ng/blog/feed/';

            // Fetch the RSS feed content using cURL
            $rss_content = fetchWithCurl($rss_url);

            if ($rss_content) {
                $rss = simplexml_load_string($rss_content, 'SimpleXMLElement', LIBXML_NOCDATA);

                if ($rss) {
                    echo '<ul class="latest-posts">';
                    foreach ($rss->channel->item as $item) {
                        $title = $item->title;
                        $link = $item->link;

                        // Display each post as a list item
                        echo '<li><a href="view_post.php?url=' . urlencode($link) . '">' . $title . '</a></li>';
                    }
                    echo '</ul>';
                } else {
                    echo 'Unable to parse the RSS feed.';
                }
            } else {
                echo 'Unable to fetch the RSS feed.';
            }
         ?>


        </div>
      </div>
    </div>
  </section>

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>About Us</h2>
          <p class="oth-fonts1"><span>Learn More</span></p>
        </div>

        <div class="row gy-4">
          <div class="col-lg-7 position-relative about-img p-well-p" style="background-image: url(./assets/img/abt.jpg) ;background-repeat:no-repeat;" data-aos="fade-up" data-aos-delay="150">
            <!-- <div class="call-us position-absolute">
              <h4>Book a Table</h4>
              <p>+1 5589 55488 55</p>
            </div> -->
          </div>
          <div class="col-lg-5 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
            <div class="content ps-0 ps-lg-5">
              <p class="fst-italic">
                In the past years, TCWNNI has facilitated Annual Independence dialogue followed by Special prayer for Nigeria at the National 
                Christian Centre that brought together political leaders, senior public officials, Christian leaders and congregation, representatives
                of development organizations, academia, the media and other participants to deliberate on issues critical to the development of Nigeria
                and to pray for the nation. The events have been institutionalized. Focus for the five years now in publications:
              </p>
              <ul>
    
                <li><i class="bi bi-check2-all"></i>2022 – 2023 General Election: Critical Success Agents</li>
                <li><i class="bi bi-check2-all"></i>2020 & 2021 – Not held because of Covid</li>
                <li><i class="bi bi-check2-all"></i>2019 – The Social Contract and Leadership in Nigeria: Experience and Prospects</li>
                <li><i class="bi bi-check2-all"></i>2018 - The Nigeria of Our DreamDisintegration or Restructuring: Which Way Nigeria</li>
                <li><i class="bi bi-check2-all"></i>2017 – Disintegration or Restructuring: Which Way Nigeria</li>
                <li><i class="bi bi-check2-all"></i>2016 – Restructuring: Whose Nigeria?</li>
                <li><i class="bi bi-check2-all"></i> 2015 – Building a new Nigeria, the imperative of attitudinal change.</li>
                <a href="about.php"><li><i class="bi bi-info"></i> Learn More</li></a>
                
              </ul>
            

              <div class="position-relative mt-4">
                <img src="assets/img/cwn2023.jpg" class="img-fluid" alt="">
                <a href="https://youtu.be/eIXu9ZM1U1o" class="glightbox play-btn"></a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->
          <!-- ======= Chefs Section ======= -->
    <section id="chefs" class="chefs section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Event</h2>
          <p class="oth-fonts1">Upcoming <span>Program</span></p>
        </div>

        <div class="row gy-4">
          <div class="col-lg-7 position-relative about-img p-well-p"  data-aos="fade-up" data-aos-delay="150">
           <div class="position-relative mt-4">
                <img src="assets/img/2024slide2.jpg" class="img-fluid" alt="">
              </div>  
          <!-- <div class="call-us position-absolute">
              <h4>Book a Table</h4>
              <p>+1 5589 55488 55</p>
            </div> -->
            <!--<img src="./assets/img/cwn3.jpeg" alt="">-->
          </div>
          <div class="col-lg-5 d-flex align-items-center" data-aos="fade-up" data-aos-delay="300">
            <div class="content ps-0 ps-lg-6">
             
              <h4>13TH THE CHANGE WE NEED NIGERIA INITIATIVE (TCWNNI) ANNUAL FORUM, 2024.</h4>
              <p>
              We would be delighted to have you participate in the TCWNNI Prayer for Nigeria on <blockquote>October 13, 2024</blockquote> at theCharismatic Renewal Ministries, Grace Sanctuary Gwagwalada, Abuja  at <i>10am to 1pm.</i> <br>
              This is planned to be a hybrid (onsite & online) event.

              To participate online or onsite,<br> please register here to receive further updates. 
              <a href="register.php">REGISTER HERE</a> <br>
              WhatsApp: Send name, email and organization to +234 809 111 0574 <br>

              Participants will also be able to watch live on our Facebook page: https://www.facebook.com/thechangeweneednigeria or <a href="https://fb.watch/nHuTShvHmE/?mibextid=RUbZ1f" target="_blank">Click here to watch Live</a>
             </p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Chefs Section -->
    <!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="stats-counter">
      <div class="container" data-aos="zoom-out">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <!-- <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span> -->
                <h4 style="color: white;">
                  VISION
                </h4>
              <p style="font-family: tahoma; color: white;">Foster attitudinal change amongst leaders and peoples of Nigeria as an imperative
              for unity, growth and development upholding godly values.
              </p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-4 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <h4 style="color: white;">MISSION</h4>
              <p style="font-family: tahoma; color: white;">Bring about positive political, social and moral change through facilitating
                deliberative dialogue and intercessory prayers, undertaking research and
                publications and actions that promote ethical, moral and godly choices.
           
                 </p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-4 col-md-6">
            <div class="stats-item text-center w-100 h-100">
                <h4 style="color: white;">OBJECTIVE</h4>
              <p style="font-family: tahoma; color: white;">Engender change in Nigeria through interactive lectures, public debates
                and enlightenment activities.
                2. Facilitate a platform for networking across class, gender and ethnicity to crossfertilize ideas for building an all-inclusive Nigeria.
                3. Increase knowledge and understanding of social, political and moral issue</p>
            </div>
          </div><!-- End Stats Item -->

         

        </div>

      </div>
    </section><!-- End Stats Counter Section -->

      <!-- ======= Chefs Section ======= -->
    <section id="chefs" class="chefs section-bg">
      <div class="section-header">
          <h2>Watch <span>Live Program</span></h2>
          <p>Livestream</p>
      </div>
      <a href="livestream.php" style="color: white;">
      <button class="btn" style = 'border-radius:20%;border: none;
              background-color: red;
              color: white !important;
              width: 20%;
              margin-left:40%;
              margin-right:40%;
              height: 7vh;'>Here</button>
              </a>
    </section><!-- End Chefs Section -->


    <!-- ======= Menu Section ======= -->
    <section id="menu" class="menu">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Events with photos</h2>
          <p>Gallery</span></p>
        </div>

     

        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">

          <div class="tab-pane fade active show" id="menu-starters">

            <!-- <div class="tab-header text-center">
              <p>Menu</p>
              <h3>Starters</h3>
            </div> -->

            <div class="row gy-5">

              <div class="col-lg-4 menu-item">
                <a href="./assets/img/wr.jpg" class="glightbox"><img src="./assets/img/wr.jpg" class="menu-img img-fluid" alt=""></a>
                <h4>5th Annual Lecture</h4>
              
              </div><!-- Menu Item -->

              <div class="col-lg-4 menu-item">
                <a href="./assets/img/main.jpg" class="glightbox"><img src="./assets/img/main.jpg" class="menu-img img-fluid" alt=""></a>
                <h4>Annual Lecture</h4>
               
              </div><!-- Menu Item -->

              <div class="col-lg-4 menu-item">
                <a href="./assets/img/qw.jpg" class="glightbox"><img src="./assets/img/qw.jpg" class="menu-img img-fluid" alt=""></a>
                <h4>Annual Lecture</h4>
               
              </div><!-- Menu Item -->

              <div class="col-lg-4 menu-item">
                <a href="./assets/img/rty.jpg" class="glightbox"><img src="./assets/img/rty.jpg" class="menu-img img-fluid" alt=""></a>
                <h4>Annual Lecture</h4>
                
              </div><!-- Menu Item -->

              <div class="col-lg-4 menu-item">
                <a href="./assets/img/vb.jpg" class="glightbox"><img src="./assets/img/vb.jpg" class="menu-img img-fluid" alt=""></a>
                <h4>Annual Lecture</h4>
                
              </div><!-- Menu Item -->

              <div class="col-lg-4 menu-item">
                <a href="./assets/img/wr.jpg" class="glightbox"><img src="./assets/img/wr.jpg" class="menu-img img-fluid" alt=""></a>
                <h4>Lecture</h4>
                
              </div><!-- Menu Item -->

            </div>
          </div><!-- End Starter Menu Content -->

          

      <button class="llo-btn" style="border-radius: 20%;"><a href="Gallery.php" style="color: white;">More</a></button>
    </section><!-- End Menu Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>TCWNNI</h2>
          <p>TCWNNI<span>PARTNERS</span></p>
        </div>

        <div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row gy-4 justify-content-center">
                  <div class="col-lg-6">
                    <div class="testimonial-content">
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        The TCWNNI had partnered for the Independence Dialogue and Prayers, with the
                        Office of the Special Adviser to the President on Ethics and Values, the National
                        Orientation Agency and on a consistent basis with the Charismatic Renewal
                        Ministries, a Christian Ministry with over 500 branches in Nigeria, USA, UK and
                        across Africa.
                        
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                      <!-- <h3>Saul Goodman</h3>
                      <h4>Ceo &amp; Founder</h4> -->
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2 text-center">
                    <img src="assets/img/testimonials/testimonials-1.jpg" class="img-fluid testimonial-img" alt="">
                  </div>
                </div>
              </div>
            </div><!-- End testimonial item -->

      
            

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Contact</h2>
          <p>Need Help? <span>Contact Us</span></p>
        </div>

      
        <div class="row gy-4">

          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-map flex-shrink-0"></i>
              <div>
                <h3>Our Address</h3>
                <p>Federal Capital Territory, Nig</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center">
              <i class="icon bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p> changeweneednigeria@yahoo.com</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+234809 111 0574 , +234 809 111 0574 </p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-share flex-shrink-0"></i>
              <div>
                <h3>Social Media Platform</h3>
                <div><strong>@</strong> changeweneednigeria
                </div>
              </div>
            </div>
          </div><!-- End Info Item -->

        </div>

        
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

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

    
 

  </footer><!-- End Footer -->
  <!-- End Footer -->

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