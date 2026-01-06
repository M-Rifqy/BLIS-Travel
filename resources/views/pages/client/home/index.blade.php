@extends('layouts.client.index')

@section('title', 'Home')

@section('content')

<!-- Hero Section -->
<section id="courses-hero" class="courses-hero section light-background">

  <div class="hero-content">
    <div class="container">
      <div class="row align-items-center">

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <div class="hero-text">
            <h1>INTERNATIONAL SEMINAR ON ISLAMIC EDUCATION (ISIE)</h1>
            <p>
 "Integrating Islamic Education and Knowledge
 for Global Competitiveness"
            </p>

            <div class="hero-stats">
              <div class="stat-item">
                <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="250" data-purecounter-duration="2"></span>
                <span class="label">Trip & Event Terselenggara</span>
              </div>
              <div class="stat-item">
                <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="5000" data-purecounter-duration="2"></span>
                <span class="label">Peserta Bahagia</span>
              </div>
              <div class="stat-item">
                <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="10" data-purecounter-duration="2"></span>
                <span class="label">Tahun Pengalaman</span>
              </div>
            </div>

            <!--<div class="hero-buttons">-->
            <!--  <a href="#packages" class="btn btn-primary">Lihat Paket Perjalanan</a>-->
            <!--  <a href="#about" class="btn btn-outline">Tentang Kami</a>-->
            <!--</div>-->

            <div class="hero-features">
              <div class="feature">
                <i class="bi bi-star-fill"></i>
                <span>Event Profesional</span>
              </div>
              <div class="feature">
                <i class="bi bi-geo-alt"></i>
                <span>Destinasi Premium</span>
              </div>
              <div class="feature">
                <i class="bi bi-camera"></i>
                <span>Dokumentasi Eksklusif</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
          <div class="hero-image">
            <div class="main-image">
              <img src="assets/client/img/bg/banner.jpg" alt="Travel & Event" class="img-fluid">
            </div>

            <!--<div class="floating-cards">-->
            <!--  <div class="course-card" data-aos="fade-up" data-aos-delay="300">-->
            <!--    <div class="card-icon">-->
            <!--      <i class="bi bi-airplane"></i>-->
            <!--    </div>-->
            <!--    <div class="card-content">-->
            <!--      <h6>Private Trip</h6>-->
            <!--      <span>Bali, Lombok, Singapore</span>-->
            <!--    </div>-->
            <!--  </div>-->

              <!--<div class="course-card" data-aos="fade-up" data-aos-delay="400">-->
              <!--  <div class="card-icon">-->
              <!--    <i class="bi bi-music-note-beamed"></i>-->
              <!--  </div>-->
              <!--  <div class="card-content">-->
              <!--    <h6>Event & Entertainment</h6>-->
              <!--    <span>Concert, Gathering, Wedding</span>-->
              <!--  </div>-->
              <!--</div>-->

              <!--<div class="course-card" data-aos="fade-up" data-aos-delay="500">-->
              <!--  <div class="card-icon">-->
              <!--    <i class="bi bi-briefcase"></i>-->
              <!--  </div>-->
              <!--  <div class="card-content">-->
              <!--    <h6>Corporate Tour</h6>-->
              <!--    <span>Meeting, Outbound, MICE</span>-->
              <!--  </div>-->
              <!--</div>-->
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="hero-background">
    <div class="bg-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
    </div>
  </div>

</section>
<!-- /Hero Section -->

@endsection
