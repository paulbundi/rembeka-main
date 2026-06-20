<section class="partners-section pt-4 pb-4 text-center">
  <!-- Heading-->
  <div class="d-flex justify-content-center border-bottom pb-2 mb-4">
    <h2 class="h3 mb-0 pt-3 text-uppercase fw-bold text-center" style="color: #1e293b; letter-spacing: 0.5px;">Our Partners</h2>
  </div>
  
  <div class="d-flex flex-wrap align-items-center justify-content-center gap-5 py-3">
    @foreach($partners as $partner) 
      @if($partner->logo)
        <div class="partner-logo-wrapper" style="max-width: 150px; transition: transform 0.2s ease;">
          <img class="img-fluid" src="{{ asset($partner->logo->url) }}" alt="{{ $partner->name }}" style="max-height: 45px; filter: grayscale(100%); opacity: 0.65; transition: all 0.3s ease; object-fit: contain;" onmouseover="this.style.filter='none'; this.style.opacity='1'; this.parentNode.style.transform='scale(1.05)';" onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.65'; this.parentNode.style.transform='scale(1)';">
        </div>
      @endif
    @endforeach
  </div>
</section>