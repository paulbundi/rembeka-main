@extends('layouts.e-commerce')
@section('content')
<main class="profile-padding">
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          @include('layouts.account-partial')

          <section class="col-lg-8">
            <!-- Tickets list-->
            <div class="table-responsive fs-md mb-4">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Ticket Subject</th>
                    <th>Date Submitted | Updated</th>
                    <th>Type</th>
                    <th>Priority</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-3"><a class="nav-link-style fw-medium" href="account-single-ticket.html">My new ticket</a></td>
                    <td class="py-3">09/27/2019 | 09/30/2019</td>
                    <td class="py-3">Website problem</td>
                    <td class="py-3"><span class="badge bg-warning m-0">High</span></td>
                    <td class="py-3"><span class="badge bg-success m-0">Open</span></td>
                  </tr>
                  <tr>
                    <td class="py-3"><a class="nav-link-style fw-medium" href="account-single-ticket.html">Another ticket</a></td>
                    <td class="py-3">08/21/2019 | 08/23/2019</td>
                    <td class="py-3">Partner request</td>
                    <td class="py-3"><span class="badge bg-info m-0">Medium</span></td>
                    <td class="py-3"><span class="badge bg-secondary m-0">Closed</span></td>
                  </tr>
                  <tr>
                    <td class="py-3"><a class="nav-link-style fw-medium" href="account-single-ticket.html">Yet another ticket</a></td>
                    <td class="py-3">11/19/2018 | 11/20/2018</td>
                    <td class="py-3">Complaint</td>
                    <td class="py-3"><span class="badge bg-danger m-0">Urgent</span></td>
                    <td class="py-3"><span class="badge bg-secondary m-0">Closed</span></td>
                  </tr>
                  <tr>
                    <td class="py-3"><a class="nav-link-style fw-medium" href="account-single-ticket.html">My old ticket</a></td>
                    <td class="py-3">06/19/2018 | 06/20/2018</td>
                    <td class="py-3">Info inquiry</td>
                    <td class="py-3"><span class="badge bg-success m-0">Low</span></td>
                    <td class="py-3"><span class="badge bg-secondary m-0">Closed</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="text-end">
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#open-ticket">Submit new ticket</button>
            </div>
          </section>

        </div>
    </div>
</main>
@endsection