@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <section>
      <div class="container">
        <div class="row align-items-center">
            <div class="card col-12 col-sm-8 offset-sm-2">
              <div class="card-body">
                <h4 class="card-title text-center">I am interested in join as a Service Provider</h4>
                @if(session()->has('success'))
                  <div class="alert alert-success" role="alert">
                      Thank you for your interest to join rembeka as a stylist/service provider.
                      Your request has been received, we will review and get back shortly.
                  </div>
                @endif
                <form method="POST" action="{{ route('stylist-inquiries') }}">
                  @csrf
                  <div class="border px-3 py-4 my-4">
                    <div class="row">
                      <div class="col-6 form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" required="true"/>
                      </div>
                      <div class="col-6 form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" required="true"/>
                      </div>
                    </div>
                    
                    <div class="row mt-2">
                      <div class="col-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="First Name" name="email" required="true"/>
                      </div>
                      <div class="col-6 form-group">
                        <label>Phone Number</label>
                        <input type="tel" class="form-control" placeholder="Phone number" name="phone" required="true"/>
                      </div>
                    </div>

                    <div class="row mt-2">
                      <div class="col-12 form-group">
                        <label>Lcation / Address </label>
                        <input type="text" class="form-control" placeholder="address" name="address" required="true"/>
                      </div>
                    </div>
                  </div>
                  <div class="border px-3 py-4 my-4">
                    <h5>Services</h5>
                    @foreach($menus->chunk(4) as $menuItems)
                      <div class="row">
                        @foreach($menuItems as $menu)
                        <div class="col-6 col-sm-3">
                          <input type="checkbox" name="services[]" class="mx-1" value="{{$menu->id}}">{{ $menu->name }}
                        </div>
                        @endforeach
                      </div>
                    @endforeach
                  </div>
                  <div class="border px-3 py-4 my-4">
                      <div class="form-group mt-2">
                        <label for="">Proffessional Qualifations</label>
                        <textarea class="form-control" name="professional_qualifications" rows="3"></textarea>
                      </div>

                      <div class="form-group mt-2">
                        <label for="">Work Experience</label>
                        <textarea class="form-control" name="works_experience" rows="3"></textarea>
                      </div>
                  </div>
                <div class="form-group mt-2 float-end">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                  </div>

                </form>
              </div>
            </div>
        </div>
      </div>


      @include('layouts.e-commerce-footer')
    </section>
</main>

@endsection